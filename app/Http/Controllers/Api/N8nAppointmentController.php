<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class N8nAppointmentController extends Controller
{
    /**
     * n8n appelle ceci quand l'agent IA et le patient se sont mis d'accord
     * sur une date/heure de RDV via WhatsApp.
     */
    public function confirm(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment = Appointment::findOrFail($id);

        // Même règle métier que AppointmentController@store : 30 min d'écart minimum.
        $newTime = \Carbon\Carbon::parse($data['time']);
        $conflict = \DB::table('appointments')
            ->where('id', '!=', $appointment->id)
            ->where('date', $data['date'])
            ->get(['time'])
            ->contains(function ($existing) use ($newTime) {
                $existingTime = \Carbon\Carbon::parse($existing->time);
                return abs($newTime->diffInMinutes($existingTime, false)) < 30;
            });

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'Créneau trop proche d\'un autre rendez-vous, proposez un autre horaire au patient.',
            ], 409);
        }

        // Assignation directe (comme RendezVousController::accept()) car 'status'
        // n'est pas dans $fillable du modèle Appointment.
        $appointment->date   = $data['date'];
        $appointment->time   = $data['time'];
        $appointment->status = 'accepte';

        try {
            $appointment->save();
        } catch (QueryException $e) {
            // Filet de sécurité : contrainte UNIQUE(date, time) déjà présente en base.
            return response()->json([
                'success' => false,
                'message' => 'Ce créneau exact est déjà utilisé par un autre rendez-vous, proposez un autre horaire.',
            ], 409);
        }

        return response()->json(['success' => true, 'appointment' => $appointment]);
    }

    /**
     * n8n appelle ceci si le patient annule sa demande ou si aucun créneau
     * n'a pu être trouvé.
     */
    public function refuse(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'annule';
        $appointment->save();

        return response()->json(['success' => true, 'appointment' => $appointment]);
    }

    /**
     * n8n appelle ceci quand le patient répond sur WhatsApp, pour retrouver
     * SON rendez-vous "en_attente" à partir de son numéro de téléphone.
     */
    public function pendingByPhone(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        $appointment = Appointment::where('phone', $request->query('phone'))
            ->where('status', 'en_attente')
            ->latest('id')
            ->first();

        if (!$appointment) {
            return response()->json(['found' => false]);
        }

        return response()->json(['found' => true, 'appointment' => $appointment]);
    }
}