<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class TopUpGameController extends Controller {
    /**
     * Tampilkan form top up.
     */
    public function index()
    {
        return view('topup-game.index');
    }

    /**
     * Proses penyimpanan top up.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'game' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();
        $jumlah = $validated['amount'];

        if ($user->saldo < $jumlah) {
            return back()->with('error', 'Saldo tidak mencukupi untuk top up.');
        }

        DB::transaction(function () use ($user, $validated, $jumlah) {
            // Kurangi saldo user
            $user->saldo -= $jumlah;
            $user->save();

            // Simpan data top up
            TopUp::create([
                'user_id' => $user->id,
                'game'    => $validated['game'],
                'amount'  => $jumlah,
                'status'  => 'pending',
            ]);
        });

        // Redirect ke form topup game, bukan ke riwayat
        return redirect()->route('topupgame.riwayat')->with('success', 'Top Up berhasil dan saldo telah dikurangi.');

    }

    /**
     * Tampilkan riwayat top up user yang login.
     */
    public function riwayat()
    {
        $topups = TopUp::where('user_id', Auth::id())->latest()->get();

        return view('topup-game.riwayat', compact('topups'));
    }

    /**
     * Cetak PDF riwayat top up.
     */
    public function cetakPdf()
    {
        $topups = TopUp::where('user_id', Auth::id())->latest()->get();
        $pdf = Pdf::loadView('topup-game.pdf', compact('topups'));

        return $pdf->download('riwayat_topup.pdf');
    }
}
