<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Marcar todas las notificaciones del usuario logueado como leídas.
     */
    public function markAsRead(Request $request)
    {
        Notification::where('Usu_documento', Auth::user()->Usu_documento)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Eliminar una notificación específica del usuario.
     */
    public function destroy($notificationId)
    {
        $notification = Notification::where('Noto_id', $notificationId)
            ->where('Usu_documento', Auth::user()->Usu_documento)
            ->firstOrFail();

        $notification->delete();

        return response()->json(['success' => true]);
    }
}
