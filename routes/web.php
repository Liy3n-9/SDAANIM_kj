<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

use App\Models\Animal;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\NotificationController;

// --- GUEST / PUBLIC ROUTES ---
Route::get('/', function () {
    $animals = Animal::latest()->take(6)->get();
    return view('welcome', compact('animals'));
})->name('welcome');

Route::get('/quienes-somos', function () { return view('public.about'); })->name('about');
Route::get('/adopta', [AnimalController::class, 'publicIndex'])->name('adopta');
Route::get('/animal/{id}', [AnimalController::class, 'show'])->name('animal.show');
Route::get('/productos', [ProductController::class, 'publicIndex'])->name('products.public');
Route::get('/contacto', function () { return view('public.contact'); })->name('contact');

// --- AUTHENTICATION ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registrar', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registrar', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// --- PROTECTED ROUTES (AUTH) ---
Route::middleware(['auth'])->group(function () {
    
    // NOTIFICATIONS
    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notifications');
    Route::delete('/notificaciones/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    
    // PROFILE
    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');

    // REDIRECTION ROUTE (Universal Dashboard)
    Route::get('/dashboard', function () {
        return match (Auth::user()->role) {
            'Administrador' => redirect()->route('admin.dashboard'),
            'Voluntario' => redirect()->route('volunteer.dashboard'),
            'Veterinario' => redirect()->route('vet.dashboard'),
            'Adoptante' => redirect()->route('adopter.dashboard'),
            default => redirect('/'),
        };
    })->name('dashboard');

    // ADOPTER PANEL
    Route::prefix('adopter')->name('adopter.')->group(function () {
        Route::get('/dashboard', [AnimalController::class, 'adopterDashboard'])->name('dashboard');
        Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile');
        Route::post('/perfil', [ProfileController::class, 'update']);
        Route::get('/mis-solicitudes', [AdoptionController::class, 'userRequests'])->name('requests');
        Route::get('/solicitar-adopcion/{animal_id}', [AdoptionController::class, 'create'])->name('adoption.create');
        Route::post('/solicitar-adopcion', [AdoptionController::class, 'store'])->name('adoption.store');
        Route::get('/donar', [DonationController::class, 'create'])->name('donation.create');
        Route::post('/donar', [DonationController::class, 'store'])->name('donation.store');
    });

    // VOLUNTEER PANEL
    Route::prefix('volunteer')->name('volunteer.')->group(function () {
        Route::get('/dashboard', function () { return view('home.volunteer'); })->name('dashboard');
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');

        // Actualizar estado de la tarea
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

        // Marcar/desmarcar como observado
        Route::patch('/tareas/{id}/observado', [TaskController::class, 'toggleObserved'])->name('tasks.toggleObserved');

        // Completar tarea
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');

        // Availability
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/disponibilidad/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    // VET PANEL
    Route::prefix('vet')->name('vet.')->group(function () {
        Route::get('/dashboard', function () { return view('home.vet'); })->name('dashboard');
        Route::get('/animales', [AnimalController::class, 'index'])->name('animals');
        Route::get('/historial/{animal_id}', [MedicalHistoryController::class, 'index'])->name('history');
        Route::post('/historial', [MedicalHistoryController::class, 'store'])->name('history.store');

        // Availability
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/disponibilidad/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    // ADMIN PANEL
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        Route::resource('animals', AnimalController::class);
        Route::resource('products', ProductController::class);
        Route::get('/solicitudes', [AdoptionController::class, 'adminIndex'])->name('requests.index');
        Route::post('/solicitudes/{id}/approve', [AdoptionController::class, 'approve'])->name('requests.approve');
        Route::post('/solicitudes/{id}/assign-volunteer', [AdoptionController::class, 'assignVolunteer'])->name('requests.assignVolunteer');
        Route::get('/usuarios', [ProfileController::class, 'adminIndex'])->name('users.index');
        
        // Admin Task management
        Route::get('/tareas', [TaskController::class, 'adminIndex'])->name('tasks.index');
        Route::post('/tareas', [TaskController::class, 'store'])->name('tasks.store');

        // Inscriptions (Vet/Volunteer requests)
        Route::get('/inscripciones', [InscriptionController::class, 'adminIndex'])->name('inscriptions.index');
        Route::post('/inscripciones/{id}/approve', [InscriptionController::class, 'approve'])->name('inscriptions.approve');
        Route::post('/inscripciones/{id}/reject', [InscriptionController::class, 'reject'])->name('inscriptions.reject');
    });

    // Mostrar tareas admin
    Route::get('/admin/tareas', [TaskController::class, 'adminIndex'])->name('admin.tasks.index')->middleware('auth');

    // Asignar voluntario a una tarea
    Route::post('/admin/tareas/{task}/assign-volunteer', [TaskController::class, 'assignVolunteer'])
        ->name('admin.tasks.assignVolunteer')
        ->middleware('auth');
});