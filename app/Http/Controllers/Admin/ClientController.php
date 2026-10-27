<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class ClientController extends Controller
{
    /**
     * Display clients / patients index.
     */
    public function index()
    {
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

        return view('admin', compact('clients'));
    }
}
