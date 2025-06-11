<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function index()
    {
        return view('transfer.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required|string|exists:users,username',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $pengirim = Auth::user();
        $jumlah = $request->jumlah;
        $penerima = User::where('username', $request->tujuan)->first();

        if ($pengirim->saldo < $jumlah) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk transfer.');
        }

        if ($pengirim->id === $penerima->id) {
            return redirect()->back()->with('error', 'Tidak bisa transfer ke diri sendiri.');
        }

        // Kurangi saldo pengirim
        $pengirim->saldo -= $jumlah;
        $pengirim->save();

        // Tambah saldo penerima
        $penerima->saldo += $jumlah;
        $penerima->save();

        // Simpan ke riwayat transfer
        Transfer::create([
            'from_user_id' => $pengirim->id,
            'to_user_id' => $penerima->id,
            'amount' => $jumlah,
        ]);

        return redirect()->route('home')->with('success', 'Transfer berhasil ke ' . $penerima->username);
    }

    public function riwayat()
    {
        $user = Auth::user();

        if (isset($user->role) && $user->role === 'admin') {
            $transfers = Transfer::with(['fromUser', 'toUser'])->latest()->get();
        } else {
            $transfers = Transfer::with(['fromUser', 'toUser'])
                ->where('from_user_id', $user->id)
                ->orWhere('to_user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('riwayat', compact('transfers'));
    }
}
