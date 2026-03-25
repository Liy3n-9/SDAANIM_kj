<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InscriptionController extends Controller
{
    /**
     * Admin list of pending inscriptions.
     */
    public function adminIndex()
    {
        $inscriptions = Inscription::where('ins_estado', 'Pendiente')->latest()->get();
        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    /**
     * Approve inscription and create user.
     */
    public function approve(Request $request, $id)
    {
        $ins = Inscription::findOrFail($id);
        
        // 1. Create User
        User::create([
            'Usu_documento' => $ins->ins_documento,
            'name' => $ins->ins_nombre,
            'email' => $ins->ins_email,
            'Usu_telefono' => $ins->ins_telefono,
            'Usu_direccion' => $ins->ins_direccion,
            'role' => ucfirst($ins->ins_tipo_rol), // 'Voluntario' or 'Veterinario'
            'password' => Hash::make($ins->ins_documento), // Default password is ID
            'status' => 'Activo',
        ]);

        // 2. Mark Inscription as Approved
        $ins->update(['ins_estado' => 'Aprobada']);

        return back()->with('success', "Solicitud aprobada. El usuario {$ins->ins_nombre} ha sido creado con éxito.");
    }

    /**
     * Reject inscription.
     */
    public function reject($id)
    {
        $ins = Inscription::findOrFail($id);
        $ins->update(['ins_estado' => 'Rechazada']);
        return back()->with('success', "Solicitud de {$ins->ins_nombre} rechazada.");
    }
}
