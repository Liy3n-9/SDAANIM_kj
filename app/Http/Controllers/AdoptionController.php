<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AdoptionRequest;
use App\Models\Notification;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    /**
     * Show form to request adoption.
     */
    public function create($animal_id)
    {
        $animal = Animal::findOrFail($animal_id);
        return view('adoptions.create', compact('animal'));
    }

    /**
     * Store request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'animal_id' => 'required|exists:animals,Anim_id',
            'motivo' => 'required|string',
            'otras_mascotas' => 'nullable|string',
            'tipo_vivienda' => 'required|string',
            'tiempo_disponible' => 'required|string',
            'comentarios' => 'nullable|string',
        ]);

        // FIND AVAILABLE VOLUNTEER
        $availability = \App\Models\Availability::where('Ava_status', 'Disponible')
            ->where('Ava_date', '>=', now()->toDateString())
            ->orderBy('Ava_date')
            ->orderBy('Ava_start_time')
            ->first();

        $volDocumento = $availability ? $availability->Usu_documento : null;

        $solicitud = AdoptionRequest::create([
            'Usu_documento' => Auth::user()->Usu_documento,
            'Anim_id' => $data['animal_id'],
            'Soli_motivo' => $data['motivo'],
            'Soli_otras_mascotas' => $data['otras_mascotas'],
            'Soli_tipo_vivienda' => $data['tipo_vivienda'],
            'Soli_tiempo_disponible' => $data['tiempo_disponible'],
            'Soli_comentarios' => $data['comentarios'],
            'Soli_fecha' => now(),
            'Soli_estado' => 'Pendiente',
            'Soli_voluntario' => $volDocumento,
        ]);

        // IF VOLUNTEER ASSIGNED, CREATE TASK AND NOTIFY
        if ($availability) {
            // Mark availability as assigned (optional, but good for keeping track)
            $availability->update(['Ava_status' => 'Asignado']);

            Task::create([
                'Usu_documento' => $volDocumento,
                'Tar_titulo' => "Seguimiento Adopción: {$solicitud->animal->Anim_nombre}",
                'Tar_descripcion' => "Realizar seguimiento a la nueva solicitud de {$solicitud->user->name}. Cita programada según disponibilidad: {$availability->Ava_date} a las {$availability->Ava_start_time}.",
                'Tar_fecha_limite' => $availability->Ava_date,
                'Tar_fecha_asignacion' => now(),
                'Tar_estado' => 'Pendiente',
            ]);

            Notification::create([
                'Usu_documento' => $volDocumento,
                'Noti_mensaje' => "Nueva solicitud asignada: {$solicitud->animal->Anim_nombre}. Cita: {$availability->Ava_date}.",
                'Noti_fecha' => now(),
                'Noti_link' => route('volunteer.tasks'),
            ]);

            // NOTIFY ADOPTER
            $volName = $availability->user->name;
            Notification::create([
                'Usu_documento' => Auth::user()->Usu_documento,
                'Noti_mensaje' => "Tu solicitud para {$solicitud->animal->Anim_nombre} ha sido recibida. El voluntario {$volName} te atenderá el {$availability->Ava_date} a las {$availability->Ava_start_time}.",
                'Noti_fecha' => now(),
                'Noti_link' => route('adopter.requests'),
            ]);
        } else {
            // NOTIFY ADOPTER WITHOUT VOLUNTEER
            Notification::create([
                'Usu_documento' => Auth::user()->Usu_documento,
                'Noti_mensaje' => "Tu solicitud para {$solicitud->animal->Anim_nombre} ha sido recibida y está pendiente de asignación de voluntario.",
                'Noti_fecha' => now(),
                'Noti_link' => route('adopter.requests'),
            ]);
        }

        return redirect()->route('adopter.requests')->with('success', 'Solicitud enviada correctamente.');
    }

    /**
     * List user's requests.
     */
    public function userRequests()
    {
        $requests = AdoptionRequest::where('Usu_documento', Auth::user()->Usu_documento)
            ->with('animal')
            ->latest()
            ->get();
        return view('adoptions.user_index', compact('requests'));
    }

    /**
     * Admin list.
     */
    public function adminIndex()
    {
        $requests = AdoptionRequest::with(['animal', 'user'])->latest()->get();
        $volunteers = \App\Models\User::where('role', 'Voluntario')->get();
        return view('admin.adoptions.index', compact('requests', 'volunteers'));
    }

    /**
     * Approve or reject request.
     */
    public function approve(Request $request, $id)
    {
        $solicitud = AdoptionRequest::findOrFail($id);
        
        $data = $request->validate([
            'estado' => 'required|in:Aprobada,Rechazada,Pendiente,En Proceso',
            'voluntario_doc' => 'nullable|exists:users,Usu_documento'
        ]);

        $solicitud->update([
            'Soli_estado' => $data['estado'],
            'Soli_voluntario' => $data['voluntario_doc'],
        ]);

        // AUTO-CREATE TASK IF VOLUNTEER ASSIGNED
        if ($data['voluntario_doc']) {
            Task::create([
                'Usu_documento' => $data['voluntario_doc'],
                'Tar_titulo' => "Seguimiento Adopción: {$solicitud->animal->Anim_nombre}",
                'Tar_descripcion' => "Realizar seguimiento a la solicitud de adopción de {$solicitud->user->name}. Estado actual: {$data['estado']}",
                'Tar_fecha_limite' => now()->addDays(3),
                'Tar_fecha_asignacion' => now(),
                'Tar_estado' => 'Pendiente',
            ]);
            
            Notification::create([
                'Usu_documento' => $data['voluntario_doc'],
                'Noti_mensaje' => "Se te ha asignado el seguimiento de la adopción de {$solicitud->animal->Anim_nombre}.",
                'Noti_fecha' => now(),
                'Noti_link' => route('volunteer.tasks'),
            ]);
        }

        // If approved, mark animal as adopted
        if ($data['estado'] === 'Aprobada') {
            $solicitud->animal->update(['Anim_estado' => 'Adoptado']);
        } else {
            // If changed from Aprobada to something else, mark as Available
            $solicitud->animal->update(['Anim_estado' => 'Disponible']);
        }

        // NOTIFY ADOPTER
        Notification::create([
            'Usu_documento' => $solicitud->Usu_documento,
            'Noti_mensaje' => "El estado de tu solicitud de adopción para {$solicitud->animal->Anim_nombre} ha cambiado a: {$data['estado']}",
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        return back()->with('success', "Estado de la solicitud actualizado a {$data['estado']}.");
    }
}
