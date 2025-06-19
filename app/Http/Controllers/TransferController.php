<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transfer;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $pengirim->saldo -= $jumlah;
        $pengirim->save();

        $penerima->saldo += $jumlah;
        $penerima->save();

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

    public function cetakPdf()
    {
        $user = Auth::user();

        if (isset($user->role) && $user->role === 'admin') {
            $transfers = Transfer::with(['fromUser', 'toUser'])->latest()->get();
            $title = 'Riwayat Transfer - Semua Data (Admin)';
        } else {
            $transfers = Transfer::with(['fromUser', 'toUser'])
                ->where('from_user_id', $user->id)
                ->orWhere('to_user_id', $user->id)
                ->latest()
                ->get();
            $title = 'Riwayat Transfer - ' . $user->username;
        }

        $pdf = Pdf::loadView('riwayat-pdf', compact('transfers', 'title'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $filename = 'riwayat-transfer-' . $user->username . '-' . date('Y-m-d-H-i-s') . '.pdf';
        return $pdf->download($filename);
    }

    public function cetakPdfFilter(Request $request)
    {
        $user = Auth::user();

        if (isset($user->role) && $user->role === 'admin') {
            $query = Transfer::with(['fromUser', 'toUser']);
            $title = 'Riwayat Transfer - Semua Data (Admin)';
        } else {
            $query = Transfer::with(['fromUser', 'toUser'])
                ->where('from_user_id', $user->id)
                ->orWhere('to_user_id', $user->id);
            $title = 'Riwayat Transfer - ' . $user->username;
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $title .= ' (Dari: ' . date('d/m/Y', strtotime($request->start_date)) . ')';
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
            $title .= ' (Sampai: ' . date('d/m/Y', strtotime($request->end_date)) . ')';
        }

        $transfers = $query->latest()->get();

        $pdf = Pdf::loadView('riwayat-pdf', compact('transfers', 'title'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $filename = 'riwayat-transfer-filter-' . $user->username . '-' . date('Y-m-d-H-i-s') . '.pdf';
        return $pdf->download($filename);
    }

    public function topupPulsa(Request $request)
    {
        $request->validate([
            'nomor_hp' => 'required|string|min:10',
            'nominal' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();
        $jumlah = $request->nominal;

        if ($user->saldo < $jumlah) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk top up.');
        }

        $user->saldo -= $jumlah;
        $user->save();

        Transfer::create([
            'from_user_id' => $user->id,
            'to_user_id' => null,
            'amount' => $jumlah,
            'description' => 'Top Up Pulsa ke nomor: ' . $request->nomor_hp,
        ]);

        return redirect()->route('home')->with('success', 'Top up pulsa berhasil ke nomor ' . $request->nomor_hp);
    }
}
