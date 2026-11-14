<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Menentukan apakah pengguna boleh melihat detail peminjaman.
     * Admin & Petugas boleh melihat semua peminjaman.
     * Siswa hanya boleh melihat transaksi peminjaman miliknya sendiri.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya boleh melihat peminjaman miliknya
        $anggota = Anggota::where('email', $user->email)->first();

        return $anggota !== null && (int) $peminjaman->anggota_id === (int) $anggota->id;
    }
}
