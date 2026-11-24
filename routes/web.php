
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessSettingController;

Route::middleware('auth')->group(function () {
    Route::put('/profile/theme', [ProfileController::class, 'updateTheme'])
    ->name('profile.theme.update');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Módulo de clientas
    Route::resource('clients', ClientController::class);

    // Módulo de servicios
    Route::resource('services', ServiceController::class)
        ->except(['show']);

    // Módulo de agenda
    Route::get('/appointments/events', [AppointmentController::class, 'events'])
        ->name('appointments.events');

    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
        ->name('appointments.updateStatus');

    Route::resource('appointments', AppointmentController::class)
        ->except(['show']);

    // Módulo de pagos
    Route::post('/appointments/{appointment}/payments', [AppointmentPaymentController::class, 'store'])
        ->name('appointments.payments.store');

    Route::delete('/payments/{payment}', [AppointmentPaymentController::class, 'destroy'])
        ->name('appointments.payments.destroy');

    Route::get('/payments/{payment}/receipt', [AppointmentPaymentController::class, 'receipt'])
        ->name('appointments.payments.receipt');

    // Módulo de reportes
    Route::prefix('reports')->name('reports.')->controller(ReportController::class)->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/income', 'income')->name('income');

        Route::get('/appointments', 'appointments')->name('appointments');

        Route::get('/services', 'services')->name('services');

        Route::get('/clients', 'clients')->name('clients');

    });

    // Administración del estudio
    Route::prefix('business-settings')->name('business-settings.')->controller(BusinessSettingController::class)->group(function () {

        Route::get('/', 'edit')->name('edit');

        Route::put('/', 'update')->name('update');

    });
    // Soporte técnico
    Route::get('/support', function () {
        return view('support.index');
    })->name('support.index');

    // Perfil del administrador
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
        // Actualizar contraseña
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.password.update');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo.update');

    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
        ->name('profile.photo.destroy');

});
