<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{

    public function run(): void
    {
        $kategori = Kategori::first() ?? Kategori::create(['nama' => 'Teknologi']);

        // Buku uji untuk pembuktian Celah A1 (XSS Payload dengan NIM 250441100112)
        Buku::firstOrCreate(
            ['judul' => "<script>alert('250441100112')</script>"],
            [
                'kategori_id' => $kategori->id,
                'penulis' => 'Tester Keamanan',
                'tahun_terbit' => 2024,
            ]
        );

        if (Buku::count() < 5) {
            Buku::factory()->count(5)->create();
        }
    }
}