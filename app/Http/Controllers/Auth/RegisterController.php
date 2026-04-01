<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidaMail;

class RegisterController extends Controller
{
    // ✅ MOSTRAR FORMULARIO
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ✅ ENVIAR CÓDIGO (NO CREA USUARIO)
    public function register(Request $request)
    {
        // 🧪 PRUEBA (puedes quitarla luego)

        $data = $request->validate([
            'Usu_documento' => ['required', 'integer', 'unique:users,Usu_documento'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'Usu_telefono' => ['required', 'string', 'max:20'],
            'Usu_direccion' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 🔢 Generar código
        $codigo = rand(100000, 999999);

        // 💾 Guardar temporal
        session([
            'registro_temp' => $data,
            'codigo_verificacion' => $codigo
        ]);

        // 📩 Enviar correo
        Mail::raw("Tu código de verificación es: $codigo", function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Código de verificación 🐾');
        });

        return redirect()->route('register')->with('mostrar_modal', true);
    }

    // ✅ VERIFICAR CÓDIGO Y CREAR USUARIO
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);

        $codigoIngresado = $request->codigo;
        $codigoGuardado = session('codigo_verificacion');
        $data = session('registro_temp');

        if (!$data) {
            return redirect()->route('register')
                ->with('error', 'Sesión expirada')
                ->with('mostrar_modal', true);
        }

        if ($codigoIngresado != $codigoGuardado) {
            return redirect()->route('register')
                ->with('error', 'Código incorrecto ❌')
                ->with('mostrar_modal', true);
        }

        // ✅ Crear usuario
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

        // 📩 Bienvenida
        Mail::to($user->email)
            ->send(new BienvenidaMail($user->name));

        // 🧹 Limpiar sesión
        session()->forget(['registro_temp', 'codigo_verificacion']);

        return redirect()->route('login')
            ->with('success', 'Cuenta verificada y creada ✅');
    }
}
