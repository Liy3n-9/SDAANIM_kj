<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        $role = strtolower($user->role);
        
        // Match view name with role
        $view = "profiles.edit_{$role}";
        
        if (!view()->exists($view)) {
            $view = 'profiles.edit'; // Fallback
        }

        return view($view, compact('user'));
    }

    /**
     * Update profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->Usu_documento . ',Usu_documento',
            'password' => 'nullable|string|min:8|confirmed',
            'Usu_telefono' => 'nullable|string|max:15',
            'Usu_direccion' => 'nullable|string|max:255',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }
        $user->Usu_telefono = $data['Usu_telefono'];
        $user->Usu_direccion = $data['Usu_direccion'];
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Admin Index for users.
     */
    public function adminIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}
