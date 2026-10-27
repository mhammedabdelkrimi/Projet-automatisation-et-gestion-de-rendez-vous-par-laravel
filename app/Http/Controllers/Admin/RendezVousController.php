<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    /**
     * Delete an appointment.
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Rendez-vous supprimé avec succès !');
    }

    /**
     * Accept an appointment.
     */
    public function accept($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'accepte';
        $appointment->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Rendez-vous accepté avec succès !');
    }

    /**
     * Cancel an appointment.
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'annule';
        $appointment->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Rendez-vous annulé avec succès !');
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|in:homme,femme',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'nullable|string',
        ]);

        $appointment->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Rendez-vous mis à jour avec succès !');
    }

    /**
     * Store a manual appointment created by the admin.
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:120',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|in:homme,femme',
            'date' => 'required|date',
            'time' => 'required',
            'services' => 'nullable|array',
            'description' => 'nullable|string',
        ]);

        Appointment::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'date' => $request->date,
            'time' => $request->time,
            'services' => $request->services ?? [],
            'description' => $request->description,
            'status' => 'en_attente',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Rendez-vous ajouté manuellement avec succès !');
    }

    /**
     * Check for new appointments created after the specified last ID.
     */
    public function checkNew(Request $request)
    {
        try {
            $lastId = intval($request->query('last_id', 0));
            
            // If lastId is 0 or empty, we don't return everything, we just return current max ID
            if ($lastId <= 0) {
                $maxId = Appointment::max('id') ?? 0;
                return response()->json([
                    'has_new' => false,
                    'max_id' => $maxId,
                    'appointments_count' => Appointment::count()
                ]);
            }

            // Find new appointments
            $newAppointments = Appointment::where('id', '>', $lastId)
                ->orderBy('id', 'asc') // Return in ascending order so we can prepend properly
                ->get();

            if ($newAppointments->isEmpty()) {
                return response()->json([
                    'has_new' => false,
                    'max_id' => $lastId,
                    'appointments_count' => Appointment::count()
                ]);
            }

            // Render html for the new rows
            $html = '';
            $recent24hHtml = '';
            foreach ($newAppointments as $rdv) {
                $html .= view('admin_partials.appointment_row', compact('rdv'))->render();
                $recent24hHtml .= view('admin_partials.recent_24h_row', compact('rdv'))->render();
            }

            $maxId = Appointment::max('id') ?? $lastId;

            return response()->json([
                'success' => true,
                'has_new' => true,
                'html' => $html,
                'recent_24h_html' => $recent24hHtml,
                'max_id' => $maxId,
                'appointments_count' => Appointment::count(),
                'new_count' => $newAppointments->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification : ' . $e->getMessage()
            ], 500);
        }
    }
}
