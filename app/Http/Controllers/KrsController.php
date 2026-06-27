<?php

namespace App\Http\Controllers;

use App\Exports\KrsExport;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KrsController extends Controller
{
    /**
     * Query dasar KRS sesuai role yang login:
     * - Admin    : semua data KRS
     * - Mahasiswa: hanya KRS miliknya sendiri
     */
    private function baseQuery(Request $request)
    {
        $query = Krs::with(['mahasiswa', 'matakuliah']);

        if ($request->user()->isMahasiswa()) {
            $query->where('npm', $request->user()->npm);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $krsList = $this->baseQuery($request)
            ->when($search, function ($q) use ($search) {
                $q->where('npm', 'like', "%{$search}%")
                  ->orWhere('kode_matakuliah', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString();

        return view('krs.index', compact('krsList'));
    }

    /**
     * Form tambah KRS.
     * - Admin    : pilih mahasiswa manapun + matakuliah
     * - Mahasiswa: matakuliah saja (npm otomatis dirinya sendiri)
     */
    public function create(Request $request)
    {
        $matakuliahs = Matakuliah::all();
        $mahasiswas  = $request->user()->isAdmin() ? Mahasiswa::all() : null;

        return view('krs.create', compact('matakuliahs', 'mahasiswas'));
    }

    /**
     * Simpan KRS baru.
     * - Admin    : npm dipilih dari form (bisa untuk mahasiswa manapun)
     * - Mahasiswa: npm dipaksa dari user yang login (tidak bisa pilih npm lain)
     */
    public function store(Request $request)
    {
        $isAdmin = $request->user()->isAdmin();

        $request->validate([
            'npm'             => $isAdmin ? 'required|string|exists:mahasiswa,npm' : 'nullable',
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
        ]);

        $npm = $isAdmin ? $request->npm : $request->user()->npm;

        $exists = Krs::where('npm', $npm)
                     ->where('kode_matakuliah', $request->kode_matakuliah)->exists();
        if ($exists) {
            return back()->withErrors(['kode_matakuliah' => 'Mahasiswa ini sudah mengambil matakuliah tersebut!'])->withInput();
        }

        Krs::create([
            'npm'             => $npm,
            'kode_matakuliah' => $request->kode_matakuliah,
        ]);

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil ditambahkan!');
    }

    /**
     * Admin: lihat detail KRS siapa saja.
     * Mahasiswa: hanya lihat detail KRS miliknya sendiri.
     */
    public function show(Request $request, $id)
    {
        $krs = Krs::with(['mahasiswa.dosen', 'matakuliah'])->findOrFail($id);

        if ($request->user()->isMahasiswa() && $krs->npm !== $request->user()->npm) {
            abort(403, 'Anda tidak memiliki akses ke data KRS ini.');
        }

        return view('krs.show', compact('krs'));
    }

    /**
     * Khusus Admin: form edit KRS milik mahasiswa manapun.
     */
    public function edit(Request $request, $id)
    {
        if (! $request->user()->isAdmin()) {
            abort(403, 'Hanya Admin yang dapat mengedit data KRS.');
        }

        $krs = Krs::findOrFail($id);
        $mahasiswas  = Mahasiswa::all();
        $matakuliahs = Matakuliah::all();

        return view('krs.edit', compact('krs', 'mahasiswas', 'matakuliahs'));
    }

    /**
     * Khusus Admin: update KRS (bisa pindah mahasiswa/matakuliah).
     */
    public function update(Request $request, $id)
    {
        if (! $request->user()->isAdmin()) {
            abort(403, 'Hanya Admin yang dapat mengedit data KRS.');
        }

        $krs = Krs::findOrFail($id);

        $request->validate([
            'npm'             => 'required|string|exists:mahasiswa,npm',
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
        ]);

        $exists = Krs::where('npm', $request->npm)
                     ->where('kode_matakuliah', $request->kode_matakuliah)
                     ->where('id', '!=', $krs->id)
                     ->exists();
        if ($exists) {
            return back()->withErrors(['kode_matakuliah' => 'Mahasiswa ini sudah mengambil matakuliah tersebut!'])->withInput();
        }

        $krs->update($request->only('npm', 'kode_matakuliah'));

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil diperbarui!');
    }

    /**
     * Hapus KRS.
     * - Admin    : bisa hapus KRS siapa saja.
     * - Mahasiswa: hanya bisa hapus (drop) KRS miliknya sendiri.
     */
    public function destroy(Request $request, $id)
    {
        $krs = Krs::findOrFail($id);

        if ($request->user()->isMahasiswa() && $krs->npm !== $request->user()->npm) {
            abort(403, 'Anda tidak dapat menghapus KRS milik mahasiswa lain.');
        }

        $krs->delete();
        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil dihapus!');
    }

    /**
     * Export KRS ke PDF. Admin export semua data, mahasiswa export miliknya saja.
     */
    public function exportPdf(Request $request)
    {
        $krsList = $this->baseQuery($request)->get();
        $pdf = Pdf::loadView('krs.pdf', compact('krsList'));
        return $pdf->download('data-krs-'.now()->format('Ymd-His').'.pdf');
    }

    /**
     * Export KRS ke Excel. Admin export semua data, mahasiswa export miliknya saja.
     */
    public function exportExcel(Request $request)
    {
        $krsList = $this->baseQuery($request)->get();
        return Excel::download(new KrsExport($krsList), 'data-krs-'.now()->format('Ymd-His').'.xlsx');
    }
}
