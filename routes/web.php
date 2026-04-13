<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Animal;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AboutController;

// --- GUEST / PUBLIC ROUTES ---
Route::get('/', function () {
    $animals = Animal::where('Anim_estado', '!=', 'Adoptado')->latest()->take(6)->get();
    return view('welcome', compact('animals'));
})->name('welcome');

Route::get('/quienes-somos', [AboutController::class, 'show'])->name('about');
Route::get('/adopta', [AnimalController::class, 'publicIndex'])->name('adopta');
Route::get('/animal/{id}', [AnimalController::class, 'show'])->name('animal.show');
Route::get('/api/animal/{id}/medical-history', [AnimalController::class, 'getMedicalHistory'])->name('animal.medical-history');
Route::get('/productos', [ProductController::class, 'publicIndex'])->name('products.public');
Route::get('/contacto', function () {
    return view('public.contact');
})->name('contact');

Route::get('/voluntario', [InscriptionController::class, 'createVolunteer'])->name('inscriptions.volunteer');
Route::get('/veterinario', [InscriptionController::class, 'createVeterinarian'])->name('inscriptions.veterinarian');
Route::post('/inscripciones', [InscriptionController::class, 'store'])->name('inscriptions.store');

Route::get('/redes-sociales', [ReviewController::class, 'publicIndex'])->name('social');
Route::get('/modelo-negocio', function () { return view('public.business'); })->name('business');
Route::get('/concientizacion', function () { return view('public.awareness'); })->name('awareness');

// --- AUTHENTICATION ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/password/forgot', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetCode'])->name('password.forgot');
Route::post('/password/verify-code', [App\Http\Controllers\Auth\PasswordResetController::class, 'verifyResetCode'])->name('password.verify');
Route::post('/password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.reset');

Route::get('/registrar', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registrar', [RegisterController::class, 'register'])->name('register.custom');
Route::get('/verificar', function () {
    return view('auth.verify');
})->name('verify');

Route::post('/verificar', [RegisterController::class, 'verificarCodigo'])->name('verify.code');

// --- PROTECTED ROUTES (AUTH) ---
Route::middleware(['auth'])->group(function () {

    // PROFILE
    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/mi-perfil/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/mi-perfil/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');

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
        Route::post('/mis-solicitudes/{soli_id}/calificar', [ReviewController::class, 'store'])->name('review.store');
    });

    // CART ROUTES (all authenticated users)
    Route::prefix('carrito')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'view'])->name('view');
        Route::post('/agregar/{prod_id}', [CartController::class, 'add'])->name('add');
        Route::delete('/remover/{cart_id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/actualizar-cantidad/{cart_id}', [CartController::class, 'updateQuantity'])->name('update-quantity');
        Route::post('/vaciar', [CartController::class, 'clear'])->name('clear');
    });

    // ORDERS ROUTES
    Route::prefix('pedidos')->name('orders.')->group(function () {
        Route::post('/confirmar', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/{ord_id}', [OrderController::class, 'show'])->name('show');
        Route::get('/', [OrderController::class, 'history'])->name('history');
    });

    // VOLUNTEER PANEL
    Route::prefix('volunteer')->name('volunteer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('home.volunteer');
        })->name('dashboard');
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');
        Route::get('/progreso', [TaskController::class, 'volunteerProgress'])->name('progress');

        // Actualizar estado de la tarea
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

        // Completar tarea (con comentario)
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tareas/{id}/comentar', [TaskController::class, 'updateComment'])->name('tasks.updateComment');

        // Availability
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/disponibilidad/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    // VET PANEL
    Route::prefix('vet')->name('vet.')->group(function () {
        Route::get('/dashboard', function () {
            return view('home.vet');
        })->name('dashboard');
        Route::get('/animales', [AnimalController::class, 'index'])->name('animals');
        Route::get('/historial/{animal_id}', [MedicalHistoryController::class, 'index'])->name('history');
        Route::post('/historial', [MedicalHistoryController::class, 'store'])->name('history.store');

        // Vet tasks (tareas asignadas por el admin)
        Route::get('/tareas', [TaskController::class, 'index'])->name('tasks');
        Route::get('/progreso', [TaskController::class, 'volunteerProgress'])->name('progress');
        Route::patch('/tareas/{id}/estado', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::post('/tareas/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tareas/{id}/comentar', [TaskController::class, 'updateComment'])->name('tasks.updateComment');

        // Availability
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/disponibilidad/{id}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    // ADMIN PANEL
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::resource('animals', AnimalController::class);
        Route::resource('products', ProductController::class);
        
        // Orders management for admin
        Route::get('/pedidos', [OrderController::class, 'history'])->name('orders.history');
        Route::post('/pedidos/{ord_id}/recoger', [OrderController::class, 'markAsPickedUp'])->name('orders.mark-picked-up');
        Route::post('/pedidos/{ord_id}/cancelar', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
        Route::get('/solicitudes', [AdoptionController::class, 'adminIndex'])->name('requests.index');
        Route::post('/solicitudes/{id}/approve', [AdoptionController::class, 'approve'])->name('requests.approve');
        Route::post('/solicitudes/{id}/assign-volunteer', [AdoptionController::class, 'assignVolunteer'])->name('requests.assignVolunteer');
        Route::post('/solicitudes/{id}/submit-report', [AdoptionController::class, 'submitReport'])->name('requests.submitReport');
        Route::post('/solicitudes/{id}/decide', [AdoptionController::class, 'decide'])->name('requests.decide');
        Route::get('/usuarios', [ProfileController::class, 'adminIndex'])->name('users.index');
        Route::post('/usuarios/{document}/toggle', [ProfileController::class, 'adminToggleStatus'])->name('users.toggleStatus');

        // Admin Task management
        Route::get('/tareas', [TaskController::class, 'adminIndex'])->name('tasks.index');
        Route::post('/tareas', [TaskController::class, 'store'])->name('tasks.store');
        Route::post('/tareas/{task}/assign-volunteer', [TaskController::class, 'assignVolunteer'])->name('tasks.assignVolunteer');
        Route::get('/actividades', [TaskController::class, 'adminActivities'])->name('activities');

        // Inscriptions (Vet/Volunteer requests)
        Route::get('/inscripciones', [InscriptionController::class, 'adminIndex'])->name('inscriptions.index');
        Route::post('/inscripciones/{id}/approve', [InscriptionController::class, 'approve'])->name('inscriptions.approve');
        Route::post('/inscripciones/{id}/reject', [InscriptionController::class, 'reject'])->name('inscriptions.reject');

        // Donaciones admin view
        Route::get('/donaciones', [DonationController::class, 'adminIndex'])->name('donations.index');

        // Quiénes somos admin edit
        Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
        Route::post('/about', [AboutController::class, 'update'])->name('about.update');
    });

    // ADMIN: Task expiration (should run as scheduled command)
    Route::post('/admin/orders/expire', function () {
        OrderController::expireOldOrders();
        return response()->json(['message' => 'Pedidos expirados procesados']);
    })->middleware('admin')->name('admin.expire-orders');

    Route::post('/notificaciones/leer', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notificaciones.leer');
    Route::get('/notifications', function () {
        $notifications = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)
            ->latest('Noti_fecha')
            ->get();
        return view('notifications.index', compact('notifications'));
    })->name('notifications');

    Route::delete('/notifications/{id}', function ($id) {
        $notification = \App\Models\Notification::where('Noto_id', $id)
            ->where('Usu_documento', Auth::user()->Usu_documento)
            ->firstOrFail();
        $notification->delete();
        return back()->with('success', 'Notificación eliminada.');
    })->name('notifications.delete');
});
