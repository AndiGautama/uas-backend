<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Withdrawal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('withdrawal.form', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
        ], [
            'amount.required' => 'Jumlah penarikan harus diisi.',
            'amount.numeric' => 'Jumlah penarikan harus berupa angka.',
            'amount.min' => 'Minimal penarikan adalah Rp 50.000.',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Validasi saldo mencukupi
        if ($user->saldo < $amount) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
        }

        // Validasi maksimal penarikan per hari (opsional)
        $todayWithdrawals = Withdrawal::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->where('status', '!=', Withdrawal::STATUS_CANCELLED)
            ->sum('amount');

        $maxDailyWithdrawal = 2000000; // 2 juta per hari
        if (($todayWithdrawals + $amount) > $maxDailyWithdrawal) {
            return redirect()->back()->with('error', 'Batas penarikan harian Anda sudah terlampaui. Maksimal Rp ' . number_format($maxDailyWithdrawal, 0, ',', '.') . ' per hari.');
        }

        try {
            DB::beginTransaction();

            // Generate kode penarikan
            $withdrawalCode = Withdrawal::generateWithdrawalCode();

            // Kurangi saldo user
            $user->saldo -= $amount;
            $user->save();

            // Simpan data penarikan
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => Withdrawal::STATUS_PENDING,
                'withdrawal_code' => $withdrawalCode,
                'notes' => 'Penarikan melalui sistem'
            ]);

            DB::commit();

            return redirect()->route('withdrawal.success', $withdrawal->id)
                ->with('success', 'Penarikan berhasil diproses. Kode penarikan: ' . $withdrawalCode);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses penarikan. Silakan coba lagi.');
        }
    }

    public function success($id)
    {
        $withdrawal = Withdrawal::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('withdrawal.success', compact('withdrawal'));
    }

    public function riwayat()
    {
        $user = Auth::user();

        if (isset($user->role) && $user->role === 'admin') {
            $withdrawals = Withdrawal::with('user')->latest()->get();
        } else {
            $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->get();
        }

        return view('withdrawal.riwayat', compact('withdrawals'));
    }

    // Method untuk admin mengupdate status
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        
        // Hanya admin yang bisa update status
        if (!isset($user->role) || $user->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah status penarikan.');
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $withdrawal = Withdrawal::findOrFail($id);
        
        // Jika status berubah dari pending ke cancelled, kembalikan saldo
        if ($withdrawal->status === Withdrawal::STATUS_PENDING && $request->status === Withdrawal::STATUS_CANCELLED) {
            $withdrawal->user->saldo += $withdrawal->amount;
            $withdrawal->user->save();
        }

        $withdrawal->status = $request->status;
        $withdrawal->save();

        return redirect()->back()->with('success', 'Status penarikan berhasil diupdate.');
    }
    public function cetakPdf()
{
    $user = Auth::user();

    if (isset($user->role) && $user->role === 'admin') {
        $withdrawals = Withdrawal::with('user')->latest()->get();
        $title = 'Riwayat Penarikan - Semua Data (Admin)';
    } else {
        $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->get();
        $title = 'Riwayat Penarikan - ' . $user->username;
    }

    $pdf = Pdf::loadView('withdrawal.riwayat-pdf', compact('withdrawals', 'title'));
    $pdf->setPaper('A4', 'portrait');

    $filename = 'riwayat-penarikan-' . $user->username . '-' . now()->format('YmdHis') . '.pdf';

    return $pdf->download($filename);
}
}