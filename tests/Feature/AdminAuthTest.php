<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guests are redirected from /admin to the login page.
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /**
     * Test that the login page is displayed.
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    /**
     * Test admin login with valid credentials.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@centre-oudghiri.com',
            'password' => \Hash::make('securepassword123'),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'admin@centre-oudghiri.com',
            'password' => 'securepassword123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'redirect' => route('admin.dashboard')
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test admin login fails with invalid credentials.
     */
    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@centre-oudghiri.com',
            'password' => \Hash::make('securepassword123'),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'admin@centre-oudghiri.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false
        ]);

        $this->assertGuest();
    }

    /**
     * Test authenticated admin can view the admin dashboard with data.
     */
    public function test_admin_can_view_admin_dashboard_with_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin');
        $response->assertViewHas(['appointments', 'services', 'clients', 'stats']);
    }

    /**
     * Test admin can delete an appointment.
     */
    public function test_admin_can_delete_appointment(): void
    {
        $user = User::factory()->create();
        $appointment = \App\Models\Appointment::create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'age' => 30,
            'phone' => '0612345678',
            'date' => '2026-07-15',
            'time' => '10:00:00',
        ]);

        $response = $this->actingAs($user)->delete("/admin/appointments/{$appointment->id}");

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    /**
     * Test admin can create, update and delete a service.
     */
    public function test_admin_can_manage_services(): void
    {
        $user = User::factory()->create();
        \Illuminate\Support\Facades\Storage::fake('public');

        // 1. Create a service
        $image = \Illuminate\Http\UploadedFile::fake()->image('service.png');
        $response = $this->actingAs($user)->post('/admin/services', [
            'image' => $image,
            'title_fr' => 'Service Test',
            'title_ar' => 'خدمة تجريبية',
            'desc_fr' => 'Description test',
            'desc_ar' => 'وصف تجريبي',
            'phase' => 1,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('services', [
            'title_fr' => 'Service Test',
            'phase' => 1,
        ]);

        $service = \App\Models\Service::where('title_fr', 'Service Test')->first();

        // 2. Update the service
        $newImage = \Illuminate\Http\UploadedFile::fake()->image('new_service.png');
        $response = $this->actingAs($user)->post("/admin/services/{$service->id}", [
            'image' => $newImage,
            'title_fr' => 'Updated Service Test',
            'title_ar' => 'خدمة معدلة',
            'desc_fr' => 'Description modifiée',
            'desc_ar' => 'وصف معدل',
            'phase' => 2,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title_fr' => 'Updated Service Test',
            'phase' => 2,
        ]);

        // Clean up the created image file in public path if it exists to avoid littering
        $createdService = \App\Models\Service::find($service->id);
        $filePath = public_path('images/services/' . $createdService->image);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // 3. Delete the service
        $response = $this->actingAs($user)->delete("/admin/services/{$service->id}");
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    /**
     * Test admin can accept and cancel an appointment.
     */
    public function test_admin_can_accept_and_cancel_appointment(): void
    {
        $user = User::factory()->create();
        $appointment = \App\Models\Appointment::create([
            'firstname' => 'Alice',
            'lastname' => 'Smith',
            'age' => 25,
            'phone' => '0698765432',
            'date' => '2026-07-20',
            'time' => '11:00:00',
        ]);

        // Accept
        $response = $this->actingAs($user)->post("/admin/appointments/{$appointment->id}/accept");
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'accepte'
        ]);

        // Cancel
        $response = $this->actingAs($user)->post("/admin/appointments/{$appointment->id}/cancel");
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'annule'
        ]);
    }

    /**
     * Test admin can update service page details.
     */
    public function test_admin_can_update_service_page_details(): void
    {
        $user = User::factory()->create();
        $service = \App\Models\Service::create([
            'image' => 'placeholder.png',
            'title_fr' => 'Fizyo',
            'title_ar' => 'ترويض',
            'desc_fr' => 'Desc',
            'desc_ar' => 'وصف',
            'phase' => 1
        ]);

        $response = $this->actingAs($user)->post("/admin/services/{$service->id}/pages", [
            'content_fr' => 'Full extended description in French.',
            'content_ar' => 'وصف كامل باللغة العربية.',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'content_fr' => 'Full extended description in French.',
            'content_ar' => 'وصف كامل باللغة العربية.',
        ]);
    }

    /**
     * Test admin can update an appointment's date and time.
     */
    public function test_admin_can_update_appointment_date_and_time(): void
    {
        $user = User::factory()->create();
        $appointment = \App\Models\Appointment::create([
            'firstname' => 'Alice',
            'lastname' => 'Smith',
            'age' => 25,
            'phone' => '0698765432',
            'gender' => 'femme',
            'date' => '2026-07-20',
            'time' => '11:00:00',
        ]);

        $response = $this->actingAs($user)->post("/admin/appointments/{$appointment->id}", [
            'firstname' => 'Alice Updated',
            'lastname' => 'Smith Updated',
            'age' => 26,
            'phone' => '0698765433',
            'gender' => 'femme',
            'date' => '2026-07-21',
            'time' => '14:30',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        
        $updatedAppointment = \App\Models\Appointment::find($appointment->id);
        $this->assertEquals('Alice Updated', $updatedAppointment->firstname);
        $this->assertEquals('2026-07-21', $updatedAppointment->date->format('Y-m-d'));
        $this->assertStringContainsString('14:30', $updatedAppointment->time);
    }

    /**
     * Test admin can create a manual appointment.
     */
    public function test_admin_can_create_manual_appointment(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("/admin/appointments", [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'age' => 45,
            'phone' => '0612345678',
            'email' => 'john.doe@example.com',
            'gender' => 'homme',
            'date' => '2026-07-15',
            'time' => '10:00',
            'services' => ['Rééducation Neurologique & Neuropédiatrique'],
            'description' => 'Manual reservation notes',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('appointments', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '0612345678',
            'status' => 'en_attente',
        ]);
    }
}

