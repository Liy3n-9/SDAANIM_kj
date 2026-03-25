<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::where('Usu_documento', Auth::user()->Usu_documento)
            ->where('Ava_date', '>=', Carbon::today())
            ->orderBy('Ava_date')
            ->orderBy('Ava_start_time')
            ->get();
        return view('availability.index', compact('availabilities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Ava_date' => 'required|date|after_or_equal:today',
            'Ava_start_time' => 'required',
            'Ava_end_time' => 'required|after:Ava_start_time',
        ], [
            'Ava_date.after_or_equal' => 'No puedes seleccionar una fecha anterior al presente.',
            'Ava_end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ]);

        Availability::create([
            'Usu_documento' => Auth::user()->Usu_documento,
            'Ava_date' => $data['Ava_date'],
            'Ava_start_time' => $data['Ava_start_time'],
            'Ava_end_time' => $data['Ava_end_time'],
            'Ava_status' => 'Disponible',
        ]);

        return back()->with('success', 'Disponibilidad agregada correctamente.');
    }

    public function destroy($id)
    {
        $availability = Availability::where('id', $id)
            ->where('Usu_documento', Auth::user()->Usu_documento)
            ->firstOrFail();
        $availability->delete();

        return back()->with('success', 'Disponibilidad eliminada.');
    }
}
