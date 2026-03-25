<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Availability;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * List tasks for the logged in volunteer.
     */
    public function index()
    {
        $tasks = Task::where('Usu_documento', Auth::user()->Usu_documento)
            ->orderByRaw("FIELD(Tar_estado, 'Pendiente', 'Completada')")
            ->latest('Tar_fecha_limite')
            ->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Mark task as completed with a optional comment.
     */
    public function complete(Request $request, $id)
    {
        $task = Task::where('Tar_id', $id)
            ->where('Usu_documento', Auth::user()->Usu_documento)
            ->firstOrFail();

        $task->update([
            'Tar_estado' => 'Completada',
            'Tar_comentario' => $request->input('comentario')
        ]);

        return back()->with('success', 'Tarea marcada como completada.');
    }

    /**
     * Admin view to manage tasks.
     */
    public function adminIndex()
    {
        $tasks = Task::with('user')->latest()->get();
        $volunteers = User::where('role', 'Voluntario')->get();
        return view('admin.tasks.index', compact('tasks', 'volunteers'));
    }

    /**
     * Admin store task.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Usu_documento' => 'required|exists:users,Usu_documento',
            'Tar_titulo' => 'required|string|max:255',
            'Tar_descripcion' => 'required|string',
            'Tar_fecha_limite' => 'required|date|after_or_equal:today',
        ]);

        // CHECK AVAILABILITY
        $available = Availability::where('Usu_documento', $data['Usu_documento'])
            ->where('Ava_date', $data['Tar_fecha_limite'])
            ->exists();

        if (!$available) {
            return back()->withErrors(['error' => 'El voluntario no tiene disponibilidad registrada para esa fecha.'])->withInput();
        }

        $task = Task::create([
            'Usu_documento' => $data['Usu_documento'],
            'Tar_titulo' => $data['Tar_titulo'],
            'Tar_descripcion' => $data['Tar_descripcion'],
            'Tar_fecha_limite' => $data['Tar_fecha_limite'],
            'Tar_fecha_asignacion' => now(),
            'Tar_estado' => 'Pendiente',
        ]);

        // NOTIFY VOLUNTEER
        Notification::create([
            'Usu_documento' => $data['Usu_documento'],
            'Noti_mensaje' => "Se te ha asignado una nueva tarea: {$data['Tar_titulo']}",
            'Noti_fecha' => now(),
            'Noti_link' => route('volunteer.tasks'),
        ]);

        return back()->with('success', 'Tarea asignada exitosamente al voluntario disponible.');
    }
}
