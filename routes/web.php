<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\VueEnsembleController;
use App\Http\Controllers\Admin\RendezVousController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\PagesServicesController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BilanController;
use App\Http\Controllers\Api\N8nAppointmentController;

// Callbacks appelés par n8n (protégés par le middleware n8n.secret, pas par le login admin)
Route::middleware('n8n.secret')->prefix('n8n')->group(function () {
    Route::post('/appointments/{id}/confirm', [N8nAppointmentController::class, 'confirm'])->name('n8n.appointments.confirm');
    Route::post('/appointments/{id}/refuse', [N8nAppointmentController::class, 'refuse'])->name('n8n.appointments.refuse');
    Route::get('/appointments/pending', [N8nAppointmentController::class, 'pendingByPhone'])->name('n8n.appointments.pending');
});

Route::get('/', function () {
    return view('home');
});

Route::get('/rdv', function () {
    return view('rdv');
})->name('rdv');

Route::post('/rdv', [AppointmentController::class, 'store'])->name('rdv.store');
Route::get('/appointments/booked-slots', [AppointmentController::class, 'getBookedSlots'])->name('appointments.booked-slots');
Route::get('/services/{id}', [AppointmentController::class, 'showService'])->name('services.show');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Admin Dashboard & CRUD Routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [VueEnsembleController::class, 'index'])->name('admin.dashboard');
    Route::get('/appointments/check', [RendezVousController::class, 'checkNew'])->name('admin.appointments.check');
    Route::post('/appointments', [RendezVousController::class, 'storeManual'])->name('admin.appointments.store_manual');
    Route::delete('/appointments/{id}', [RendezVousController::class, 'destroy'])->name('admin.appointments.destroy');
    Route::post('/appointments/{id}/accept', [RendezVousController::class, 'accept'])->name('admin.appointments.accept');
    Route::post('/appointments/{id}/cancel', [RendezVousController::class, 'cancel'])->name('admin.appointments.cancel');
    Route::post('/appointments/{id}', [RendezVousController::class, 'update'])->name('admin.appointments.update');
    Route::post('/services', [ServicesController::class, 'store'])->name('admin.services.store');
    Route::post('/services/{id}', [ServicesController::class, 'update'])->name('admin.services.update');
    Route::post('/services/{id}/image', [ServicesController::class, 'updateImage'])->name('admin.services.update-image');
    Route::delete('/services/{id}', [ServicesController::class, 'destroy'])->name('admin.services.destroy');
    Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::post('/services/{id}/pages', [PagesServicesController::class, 'update'])->name('admin.services.pages.update');
    Route::post('/bilans', [BilanController::class, 'store'])->name('admin.bilans.store');
    Route::delete('/bilans/{id}', [BilanController::class, 'destroy'])->name('admin.bilans.destroy');
    Route::post('/schemas', [BilanController::class, 'storeSchema'])->name('admin.schemas.store');
    Route::post('/schemas/rename', [BilanController::class, 'renameSchema'])->name('admin.schemas.rename');
    Route::post('/schemas/delete', [BilanController::class, 'destroySchema'])->name('admin.schemas.delete');
});
