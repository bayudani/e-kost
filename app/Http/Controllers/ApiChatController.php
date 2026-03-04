<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ApiChatController extends Controller
{
    // Mengambil pesan terbaru via JS
    public function fetch(Request $request)
    {
        $myId = Auth::id();
        $barangId = $request->barang_id;
        $receiverId = $request->receiver_id;

        if (!$barangId || !$receiverId) {
            return response()->json([]);
        }

        // ==========================================
        // FITUR BARU: Tandai pesan sudah dibaca
        // Jika kita membuka chat ini, ubah semua pesan yang dikirim oleh partner ke kita jadi is_read = true
        // ==========================================
        Chat::where('id_barang', $barangId)
            ->where('id_pengirim', $receiverId) // Pengirimnya adalah partner chat
            ->where('id_penerima', $myId)       // Penerimanya adalah kita
            ->where('is_read', false)           // Yang statusnya belum dibaca
            ->update(['is_read' => true]);      // Jadikan sudah dibaca

        $messages = Chat::where('id_barang', $barangId)
            ->where(function ($q) use ($myId, $receiverId) {
                $q->where(function ($q2) use ($myId, $receiverId) {
                    $q2->where('id_pengirim', $myId)
                        ->where('id_penerima', $receiverId);
                })->orWhere(function ($q2) use ($myId, $receiverId) {
                    $q2->where('id_pengirim', $receiverId)
                        ->where('id_penerima', $myId);
                });
            })
            ->oldest() 
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'id_pengirim' => $msg->id_pengirim,
                    'pesan' => $msg->pesan,
                    'time' => $msg->created_at->format('H:i')
                ];
            });

        return response()->json($messages);
    }

    // Mengirim pesan via JS
    public function send(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
            'barang_id' => 'required',
            'receiver_id' => 'required',
        ]);

        $chat = Chat::create([
            'id_pengirim' => Auth::id(),
            'id_penerima' => $request->receiver_id,
            'id_barang'   => $request->barang_id,
            'pesan'       => $request->pesan,
        ]);

        return response()->json(['status' => 'success']);
    }
}
