<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Appointment;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_store_appointment_without_required_fields(): void
    {
        $response = $this->postJson('/rdv', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['firstname', 'lastname', 'age', 'phone', 'gender', 'date', 'time']);
    }

    public function test_can_store_valid_appointment(): void
    {
        $data = [
            'firstname' => 'Ahmed',
            'lastname' => 'Alaoui',
            'age' => 35,
            'phone' => '0612345678',
            'email' => 'ahmed@example.com',
            'gender' => 'homme',
            'date' => '2026-07-05',
            'time' => '14:30',
            'services' => ['ortho_traumato', 'rhumatologie'],
            'description' => 'Mal au dos',
        ];

        $response = $this->postJson('/rdv', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Votre demande de rendez-vous a été enregistrée avec succès.',
            ]);

        $appointment = Appointment::first();
        $this->assertNotNull($appointment);
        $this->assertEquals('Ahmed', $appointment->firstname);
        $this->assertEquals('Alaoui', $appointment->lastname);
        $this->assertEquals('2026-07-05', $appointment->date->format('Y-m-d'));
        $this->assertStringContainsString('14:30', $appointment->time);
    }

    public function test_cannot_book_appointment_within_30_minutes_of_another(): void
    {
        $baseData = [
            'firstname' => 'Ahmed',
            'lastname' => 'Alaoui',
            'age' => 35,
            'phone' => '0612345678',
            'gender' => 'homme',
            'date' => '2026-07-05',
        ];

        // Store base appointment at 14:30
        $this->postJson('/rdv', array_merge($baseData, ['time' => '14:30']))->assertStatus(200);

        // 1. Try 14:45 (15 mins after, too close) -> fails
        $response1 = $this->postJson('/rdv', array_merge($baseData, [
            'firstname' => 'Too Close 1',
            'time' => '14:45'
        ]));
        $response1->assertStatus(422)->assertJsonValidationErrors(['date']);

        // 2. Try 14:15 (15 mins before, too close) -> fails
        $response2 = $this->postJson('/rdv', array_merge($baseData, [
            'firstname' => 'Too Close 2',
            'time' => '14:15'
        ]));
        $response2->assertStatus(422)->assertJsonValidationErrors(['date']);

        // 3. Try 14:00 (30 mins before, exact boundary) -> succeeds
        $response3 = $this->postJson('/rdv', array_merge($baseData, [
            'firstname' => 'Boundary Before',
            'time' => '14:00'
        ]));
        $response3->assertStatus(200);

        // 4. Try 15:00 (30 mins after, exact boundary) -> succeeds
        $response4 = $this->postJson('/rdv', array_merge($baseData, [
            'firstname' => 'Boundary After',
            'time' => '15:00'
        ]));
        $response4->assertStatus(200);
    }
}
