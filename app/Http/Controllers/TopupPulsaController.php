<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiPulsa;

class TopupPulsaController extends Controller
{
    /**
     * Tampilkan form top-up pulsa
     */
    public function form()
    {
        return view('topup_pulsa');
    }

    /**
     * Proses top-up pulsa
     */
    public function submit(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string|min:10|max:15',
            'jumlah' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();

        // Cek saldo cukup
        if ($user->saldo < $request->jumlah) {
            return back()->withErrors(['Saldo tidak mencukupi untuk melakukan top-up.']);
        }

        // Potong saldo user
        $user->saldo -= $request->jumlah;
        $user->save();

        // Simpan transaksi ke tabel transaksi_pulsa
        TransaksiPulsa::create([
            'user_id' => $user->id,
            'nomor' => $request->nomor,
            'jumlah' => $request->jumlah,
        ]);

        // Simpan informasi invoice ke dalam session (untuk pop-up di halaman home)
        session()->flash('invoice', [
            'nomor' => $request->nomor,
            'jumlah' => $request->jumlah,
            'waktu' => now()->format('d M Y H:i'),
        ]);

        // Redirect langsung ke halaman home
        return redirect()->route('home');
    }

    /**
     * Tampilkan riwayat transaksi pulsa
     */
    public function riwayat()
    {
        $user = Auth::user();
        $transaksi = TransaksiPulsa::where('user_id', $user->id)->latest()->get();

        return view('riwayat_pulsa', compact('transaksi'));
    }
}
