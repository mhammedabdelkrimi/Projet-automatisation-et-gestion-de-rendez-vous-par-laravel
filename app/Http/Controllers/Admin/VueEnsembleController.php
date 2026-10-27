<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Bilan;

class VueEnsembleController extends Controller
{
    /**
     * Display the overview panel.
     */
    public function index()
    {
        $appointments = Appointment::orderBy('created_at', 'desc')
            ->get();

        $bilans = Bilan::orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $services = Service::orderBy('phase', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $acceptedAppts = Appointment::where('status', 'accepte')->get();
        
        $clients = $acceptedAppts->groupBy(function($item) {
            return strtolower($item->firstname . '_' . $item->lastname . '_' . $item->phone);
        })->map(function($group) {
            $first = $group->first();
            $allServices = [];
            foreach ($group as $appt) {
                $servicesArr = is_string($appt->services) ? json_decode($appt->services, true) : $appt->services;
                if (is_array($servicesArr)) {
                    $allServices = array_merge($allServices, $servicesArr);
                }
            }
            return (object) [
                'firstname' => $first->firstname,
                'lastname' => $first->lastname,
                'phone' => $first->phone,
                'email' => $first->email,
                'age' => $first->age,
                'gender' => $first->gender,
                'services' => array_unique($allServices),
            ];
        })->values();

        $stats = [
            'appointments_count' => $appointments->count(),
            'services_count' => $services->count(),
            'clients_count' => $clients->count(),
            'complete_pages_count' => $services->filter(function($s) {
                return !empty($s->content_fr) && !empty($s->content_ar);
            })->count(),
        ];
        $stats['incomplete_pages_count'] = $stats['services_count'] - $stats['complete_pages_count'];

        // 24h Activity Data
        $last24h = \Carbon\Carbon::now()->subHours(24);

        $recentAppointments24h = Appointment::where('created_at', '>=', $last24h)
            ->orderBy('created_at', 'desc')
            ->get();

        $processedAppointments24h = Appointment::whereIn('status', ['accepte', 'annule'])
            ->where('updated_at', '>=', $last24h)
            ->orderBy('updated_at', 'desc')
            ->get();

        $filledPages24h = Service::where(function($query) {
                $query->whereNotNull('content_fr')->orWhereNotNull('content_ar');
            })
            ->where('updated_at', '>=', $last24h)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin', compact(
            'appointments', 
            'services', 
            'clients', 
            'stats',
            'recentAppointments24h',
            'processedAppointments24h',
            'filledPages24h',
            'bilans'
        ));
    }
}
