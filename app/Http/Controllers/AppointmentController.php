<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $lang = $request->input('lang', 'fr');
        $isAr = ($lang === 'ar');

        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'age' => 'required|integer|min:0|max:120',
                'phone' => 'required|string|max:50',
                'email' => 'nullable|email|max:255',
                'gender' => 'required|in:homme,femme',

                'date' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($request, $isAr) {
                        if (!$request->time) {
                            return;
                        }

                        try {
                            $newTime = \Carbon\Carbon::parse($request->time);
                        } catch (\Exception $e) {
                            return;
                        }

                        $existingAppointments = \DB::table('appointments')
                            ->where(function ($q) use ($value) {
                                $q->where('date', $value)
                                    ->orWhere('date', $value . ' 00:00:00');
                            })
                            ->get(['time']);

                        foreach ($existingAppointments as $existing) {
                            try {
                                $existingTime = \Carbon\Carbon::parse($existing->time);

                                $diffInMinutes = abs(
                                    $newTime->diffInMinutes($existingTime, false)
                                );

                                if ($diffInMinutes < 30) {
                                    $fail(
                                        $isAr
                                            ? 'هذا التوقيت قريب جداً من موعد آخر (يجب أن يكون هناك 30 دقيقة على الأقل بين الموعدين).'
                                            : 'Ce créneau horaire est trop proche d\'un autre rendez-vous (il faut au moins 30 minutes d\'intervalle).'
                                    );

                                    return;
                                }
                            } catch (\Exception $e) {
                                // Skip malformed DB time formats
                            }
                        }
                    }
                ],

                'time' => 'required',

                'services' => 'required|array|min:1',

                'description' => 'nullable|string',

            ], $isAr ? [

                'services.required' => 'يجب اختيار خدمة واحدة على الأقل.',
                'services.min' => 'يجب اختيار خدمة واحدة على الأقل.',
                'date.required' => 'التاريخ مطلوب.',
                'time.required' => 'التوقيت مطلوب.',
                'firstname.required' => 'الاسم الشخصي مطلوب.',
                'lastname.required' => 'الاسم العائلي مطلوب.',
                'phone.required' => 'رقم الهاتف مطلوب.',
                'age.required' => 'العمر مطلوب.',
                'age.integer' => 'يجب أن يكون العمر عدداً صحيحاً.',
                'age.min' => 'يجب أن يكون العمر أكبر من أو يساوي 0.',
                'age.max' => 'يجب أن يكون العمر أقل من أو يساوي 120.',
                'email.email' => 'البريد الإلكتروني غير صالح.',

            ] : [

                'services.required' => 'Veuillez choisir au moins un service.',
                'services.min' => 'Veuillez choisir au moins un service.',
                'date.required' => 'La date est obligatoire.',
                'time.required' => 'L\'horaire est obligatoire.',
                'firstname.required' => 'Le prénom est obligatoire.',
                'lastname.required' => 'Le nom est obligatoire.',
                'phone.required' => 'Le numéro de téléphone est obligatoire.',
                'age.required' => 'L\'âge est obligatoire.',
                'age.integer' => 'L\'âge doit être un nombre entier.',
                'age.min' => 'L\'âge doit être supérieur ou égal à 0.',
                'age.max' => 'L\'âge doit être inférieur ou égal à 120.',
                'email.email' => 'L\'adresse e-mail est invalide.',

            ]);

            /*
             * IMPORTANT :
             * On récupère ici l'objet Appointment créé.
             *
             * Avant :
             * Appointment::create($validated);
             *
             * Maintenant :
             * $appointment = Appointment::create($validated);
             *
             * Cela nous permet d'envoyer son ID et ses informations à n8n.
             */
            $appointment = Appointment::create($validated);

            /*
             * Notification de n8n.
             *
             * Cette fonction ne bloque pas la création du rendez-vous
             * si n8n est momentanément indisponible.
             */
            $this->notifyN8n($appointment);

            return response()->json([
                'success' => true,
                'message' => $isAr
                    ? 'تم تسجيل طلب موعدكم بنجاح.'
                    : 'Votre demande de rendez-vous a été enregistrée avec succès.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => $isAr
                    ? 'لم يتم قبول البيانات المدخلة.'
                    : $e->getMessage()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $isAr
                    ? 'حدث خطأ غير متوقع أثناء التسجيل: ' . $e->getMessage()
                    : 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Envoie le nouveau rendez-vous vers n8n.
     */
    private function notifyN8n(Appointment $appointment): void
    {
        /*
         * Récupération de l'URL du webhook depuis :
         *
         * config/services.php
         *
         * qui lui-même récupère :
         *
         * N8N_WEBHOOK_URL
         *
         * depuis .env
         */
        $webhookUrl = config('services.n8n.webhook_new_rdv');

        /*
         * Si aucune URL n'est configurée,
         * on ne fait rien.
         */
        if (!$webhookUrl) {
            Log::warning(
                'Webhook n8n non configuré : N8N_WEBHOOK_URL manquant.'
            );

            return;
        }

        try {

            /*
             * Envoi des données à n8n.
             */
            $response = Http::timeout(5)
                ->acceptJson()
                ->post($webhookUrl, [

                    /*
                     * Identifiant du rendez-vous Laravel.
                     */
                    'appointment_id' => $appointment->id,

                    /*
                     * Informations du patient.
                     */
                    'firstname' => $appointment->firstname,
                    'lastname' => $appointment->lastname,
                    'phone' => $appointment->phone,

                    /*
                     * Date demandée.
                     *
                     * Appointment possède :
                     *
                     * 'date' => 'date'
                     *
                     * dans $casts.
                     *
                     * Donc $appointment->date est un objet Carbon.
                     */
                    'date_demandee' => $appointment->date
                        ? $appointment->date->format('Y-m-d')
                        : null,

                    /*
                     * Heure demandée.
                     */
                    'heure_demandee' => $appointment->time,

                    /*
                     * Services sélectionnés.
                     */
                    'services' => $appointment->services,

                    /*
                     * Description éventuelle.
                     */
                    'description' => $appointment->description,

                    /*
                     * Numéro WhatsApp du médecin.
                     *
                     * Cette valeur sera configurée dans :
                     *
                     * config/services.php
                     */
                    'docteur_telephone' => config(
                        'services.n8n.docteur_telephone'
                    ),

                    /*
                     * URLs que n8n pourra appeler pour confirmer/refuser
                     * le rendez-vous.
                     */
                    'callback_confirm' => url(
                        "/n8n/appointments/{$appointment->id}/confirm"
                    ),

                    'callback_refuse' => url(
                        "/n8n/appointments/{$appointment->id}/refuse"
                    ),

                    'callback_pending' => url(
                        "/n8n/appointments/pending"
                    ),

                    /*
                     * URL permettant à n8n de récupérer les créneaux
                     * déjà occupés.
                     */
                    'booked_slots_url' => url(
                        "/appointments/booked-slots"
                    ),

                    /*
                     * Secret partagé entre Laravel et n8n.
                     */
                    'secret' => config(
                        'services.n8n.secret'
                    ),
                ]);

            /*
             * Vérification de la réponse de n8n.
             */
            if ($response->successful()) {

                Log::info(
                    'Nouveau rendez-vous envoyé à n8n avec succès.',
                    [
                        'appointment_id' => $appointment->id,
                    ]
                );

            } else {

                Log::error(
                    'n8n a retourné une erreur lors de la réception du rendez-vous.',
                    [
                        'appointment_id' => $appointment->id,
                        'status' => $response->status(),
                        'response' => $response->body(),
                    ]
                );
            }

        } catch (\Throwable $e) {

            /*
             * IMPORTANT :
             *
             * Une erreur n8n ne doit PAS empêcher le patient
             * d'enregistrer son rendez-vous dans Laravel.
             */
            Log::error(
                'Erreur webhook n8n nouveau rdv : ' . $e->getMessage(),
                [
                    'appointment_id' => $appointment->id,
                ]
            );
        }
    }

    /**
     * Display a specific service page details.
     */
    public function showService($id)
    {
        $service = \App\Models\Service::findOrFail($id);

        return view('service_detail', compact('service'));
    }

    /**
     * Get already booked slots for a given date.
     */
    public function getBookedSlots(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json([]);
        }

        /*
         * Fetch appointments on this date
         * that are active or pending.
         */
        $booked = \DB::table('appointments')
            ->where(function ($q) use ($date) {
                $q->where('date', $date)
                    ->orWhere('date', $date . ' 00:00:00');
            })
            ->whereIn('status', ['accepte', 'en_attente'])
            ->pluck('time')
            ->map(function ($time) {

                /*
                 * Ensure format HH:MM
                 */
                return substr($time, 0, 5);

            })
            ->unique()
            ->values()
            ->toArray();

        return response()->json($booked);
    }
}