<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transfer;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan import ini

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

    // Method baru untuk generate PDF
    public function cetakPdf()
    {
        $user = Auth::user();

        // Logic yang sama seperti di method riwayat untuk filter data
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
        
        // Set paper size dan orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Set options untuk handling gambar dan font
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);
        
        // Generate filename dengan timestamp dan username
        $filename = 'riwayat-transfer-' . $user->username . '-' . date('Y-m-d-H-i-s') . '.pdf';
        
        // Download PDF
        return $pdf->download($filename);
    }
    
    // Method untuk PDF dengan filter tanggal
    public function cetakPdfFilter(Request $request)
    {
        $user = Auth::user();
        
        // Mulai query sesuai role
        if (isset($user->role) && $user->role === 'admin') {
            $query = Transfer::with(['fromUser', 'toUser']);
            $title = 'Riwayat Transfer - Semua Data (Admin)';
        } else {
            $query = Transfer::with(['fromUser', 'toUser'])
                ->where('from_user_id', $user->id)
                ->orWhere('to_user_id', $user->id);
            $title = 'Riwayat Transfer - ' . $user->username;
        }
        
        // Tambahkan filter tanggal jika ada
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
}