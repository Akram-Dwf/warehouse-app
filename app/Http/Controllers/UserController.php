<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 1. Tambahkan Import ini

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::orderBy('is_approved', 'asc')
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Menyetujui (Approve) User.
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'is_approved' => true
        ]);

        return redirect()->back()
            ->with('success', 'Akun ' . $user->name . ' berhasil disetujui!');
    }

    /**
     * Menghapus User (Tolak/Banned).
     */
    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->back()
            ->with('success', 'Akun berhasil dihapus/ditolak.');
    }
}