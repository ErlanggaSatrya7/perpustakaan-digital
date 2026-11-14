<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        $bukus = Buku::with('kategori')->latest()->get();

        return view('buku.index', compact('kategoris', 'bukus'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        $dataBuku = $buku;

        return view('buku.detail', compact('buku', 'dataBuku'));
    }

    /**
     * Celah A2: SQL Injection via raw query concatenation.
     */
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        // Nilai judul digabungkan langsung ke string SQL
        $bukus = DB::select("SELECT * FROM bukus WHERE judul = ?", [$judul]);

        return response()->json($bukus);
    }

    /**
     * Celah A3: Penghapusan buku yang dapat dipanggil via HTTP GET (CSRF vulnerable).
     */
    public function destroy(Buku $buku)
    {
        $judul = $buku->judul;
        $buku->delete();

        return redirect()->route('buku.index')->with('success', "Buku '{$judul}' berhasil dihapus.");
    }
}
