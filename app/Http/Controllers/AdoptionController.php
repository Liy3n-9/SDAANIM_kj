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

        AdoptionRequest::create([
            'Usu_documento' => Auth::user()->Usu_documento,
            'Anim_id' => $data['animal_id'],
            'Soli_motivo' => $data['motivo'],
            'Soli_otras_mascotas' => $data['otras_mascotas'],
            'Soli_tipo_vivienda' => $data['tipo_vivienda'],
            'Soli_tiempo_disponible' => $data['tiempo_disponible'],
            'Soli_comentarios' => $data['comentarios'],
            'Soli_estado' => 'Pendiente',
        ]);

        return redirect()->route('adopter.requests')
            ->with('success', 'Solicitud enviada correctamente.');
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
     * Approve or update request.
     */
    public function approve(Request $request, $id)
    {
        $solicitud = AdoptionRequest::findOrFail($id);

        $data = $request->validate([
            'estado' => 'required|in:Pendiente,Asignada,En Entrevista,Aprobada,No Apta,Proceso Adopcion,Rechazada,En Proceso',
            'Usu_documento' => 'nullable|exists:users,Usu_documento'
        ]);

        // Actualizar solicitud
        $solicitud->update([
            'Soli_estado' => $data['estado'],
            'Soli_voluntario' => $data['Usu_documento'] ?? null,
        ]);

        // Crear tarea y notificación si hay voluntario
        if (!empty($data['Usu_documento'])) {

            Task::create([
                'Usu_documento' => $data['Usu_documento'],
                'Tar_titulo' => "Seguimiento Adopción: {$solicitud->animal->Anim_nombre}",
                'Tar_descripcion' => "Realizar seguimiento a la solicitud de adopción de {$solicitud->user->name}. Estado actual: {$data['estado']}",
                'Tar_fecha_limite' => now()->addDays(3),
                'Tar_fecha_asignacion' => now(),
                'Tar_estado' => 'Pendiente',
            ]);

            Notification::create([
                'Usu_documento' => $data['Usu_documento'],
                'Noti_mensaje' => "Se te ha asignado el seguimiento de la adopción de {$solicitud->animal->Anim_nombre}.",
                'Noti_fecha' => now(),
                'Noti_link' => route('volunteer.tasks'),
            ]);
        }

        // Actualizar estado del animal
        if ($data['estado'] === 'Aprobada') {
            $solicitud->animal->update(['Anim_estado' => 'Adoptado']);
        } else {
            $solicitud->animal->update(['Anim_estado' => 'Disponible']);
        }

        // Notificar al adoptante
        Notification::create([
            'Usu_documento' => $solicitud->Usu_documento,
            'Noti_mensaje' => "El estado de tu solicitud de adopción para {$solicitud->animal->Anim_nombre} ha cambiado a: {$data['estado']}",
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        return back()->with('success', "Estado actualizado a {$data['estado']}.");
    }

    /**
     * Assign volunteer manually.
     */
    public function assignVolunteer(Request $request, $id)
    {
        $request->validate([
            'Usu_documento' => 'required|exists:users,Usu_documento',
            'visita_fecha' => 'required|date|after:today'
        ]);

        $solicitud = AdoptionRequest::findOrFail($id);
        $solicitud->update([
            'Soli_voluntario' => $request->Usu_documento,
            'visita_fecha' => $request->visita_fecha,
            'Soli_estado' => 'En Revisión'
        ]);

        Task::create([
            'Usu_documento' => $request->Usu_documento,
            'Tar_titulo' => "Visita de Seguimiento: {$solicitud->animal->Anim_nombre}",
            'Tar_descripcion' => "Realizar visita al hogar de {$solicitud->user->name} el {$request->visita_fecha}.",
            'Tar_fecha_limite' => $request->visita_fecha,
            'Tar_fecha_asignacion' => now(),
            'Tar_estado' => 'Pendiente',
            'soli_id' => $solicitud->Soli_id, // Agregar referencia
        ]);

        Notification::create([
            'Usu_documento' => $request->Usu_documento,
            'Noti_mensaje' => "Se te ha asignado la visita de seguimiento para la adopción de {$solicitud->animal->Anim_nombre} el {$request->visita_fecha}.",
            'Noti_fecha' => now(),
            'Noti_link' => route('volunteer.tasks'),
        ]);

        // Notificar al adoptante
        Notification::create([
            'Usu_documento' => $solicitud->Usu_documento,
            'Noti_mensaje' => "Tu solicitud de adopción para {$solicitud->animal->Anim_nombre} ha sido asignada para visita el {$request->visita_fecha}.",
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        return back()->with('success', 'Voluntario asignado y visita programada correctamente.');
    }

    /**
     * Volunteer submits report.
     */
    public function submitReport(Request $request, $id)
    {
        $request->validate([
            'reporte' => 'required|string',
            'apto' => 'required|boolean'
        ]);

        $solicitud = AdoptionRequest::findOrFail($id);
        $solicitud->update([
            'reporte_voluntario' => $request->reporte,
            'apto' => $request->apto
        ]);

        // Completar la tarea relacionada
        $task = \App\Models\Task::where('Usu_documento', $solicitud->Soli_voluntario)
            ->where('Tar_estado', '!=', 'Completado')
            ->when($solicitud->Soli_id, function($q) use ($solicitud) {
                return $q->where('soli_id', $solicitud->Soli_id);
            }, function($q) {
                return $q->where(function($q2) {
                    $q2->where('Tar_descripcion', 'like', '%seguimiento%')
                       ->orWhere('Tar_descripcion', 'like', '%adopción%')
                       ->orWhere('Tar_descripcion', 'like', '%visita%');
                });
            })
            ->first();
        if ($task) {
            $task->update([
                'Tar_estado' => 'Completado',
                'Tar_comentario' => $request->reporte
            ]);
        }

        // Notificar al admin
        $admin = \App\Models\User::where('role', 'Administrador')->first();
        Notification::create([
            'Usu_documento' => $admin->Usu_documento,
            'Noti_mensaje' => "El voluntario ha enviado el reporte para la solicitud de adopción de {$solicitud->animal->Anim_nombre}.",
            'Noti_fecha' => now(),
            'Noti_link' => route('admin.requests.index'),
        ]);

        return back()->with('success', 'Reporte enviado correctamente.');
    }

    /**
     * Admin accepts or rejects after report.
     */
    public function decide(Request $request, $id)
    {
        $request->validate([
            'decision' => 'required|in:Aceptada,Rechazada'
        ]);

        $solicitud = AdoptionRequest::findOrFail($id);
        $solicitud->update(['Soli_estado' => $request->decision]);

        if ($request->decision === 'Aceptada') {
            $solicitud->animal->update(['Anim_estado' => 'Adoptado']);
        } else {
            $solicitud->animal->update(['Anim_estado' => 'Disponible']);
        }

        // Notificar al adoptante
        Notification::create([
            'Usu_documento' => $solicitud->Usu_documento,
            'Noti_mensaje' => "Tu solicitud de adopción para {$solicitud->animal->Anim_nombre} ha sido {$request->decision}.",
            'Noti_fecha' => now(),
            'Noti_link' => route('adopter.requests'),
        ]);

        return back()->with('success', "Solicitud {$request->decision}.");
    }
}