<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\BienvenidaMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'Usu_documento' => ['required', 'integer', 'unique:users,Usu_documento'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'Usu_telefono' => ['required', 'string', 'max:20'],
            'Usu_direccion' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'Usu_documento' => $data['Usu_documento'],
            'name' => $data['name'],
            'email' => $data['email'],
            'Usu_telefono' => $data['Usu_telefono'],
            'Usu_direccion' => $data['Usu_direccion'],
            'password' => Hash::make($data['password']),
            'role' => 'Adoptante',
            'status' => 'Activo',
        ]);

        Mail::to($user->email)
            ->send(new BienvenidaMail($user->name));

        return redirect()->route('login')->with('success', 'Cuenta creada exitosamente. Por favor, inicia sesión.');
    }
}
