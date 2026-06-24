<?php

namespace App\Http\Controllers;

use App\Akreditasi;
use App\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkreditasiController extends Controller
{
    public function publicIndex()
    {
        $akreditasis = Akreditasi::with(['prodi.jenjang'])
            ->whereHas('prodi')
            ->get()
            ->sortBy(function ($akreditasi) {
                return strtolower($akreditasi->prodi->name);
            })
            ->values();

        return view('home.akreditasi.index', [
            'akreditasis' => $akreditasis,
        ]);
    }

    public function index()
    {
        return view('akreditasi.index', [
            'akreditasis' => Akreditasi::with(['prodi.jenjang'])
                ->whereHas('prodi')
                ->orderBy('prodi_id')
                ->get(),
            'prodis' => Prodi::with(['jenjang', 'akreditasi'])
                ->whereNotIn('id', [0])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Akreditasi::create($data);

        return redirect()
            ->route('akreditasi.admin.index')
            ->with('pesan', 'Data akreditasi berhasil ditambahkan.');
    }

    public function update(Request $request, Akreditasi $akreditasi)
    {
        $data = $this->validateData($request, $akreditasi);
        $akreditasi->update($data);

        return redirect()
            ->route('akreditasi.admin.index')
            ->with('pesan', 'Data akreditasi berhasil diperbarui.');
    }

    public function destroy(Akreditasi $akreditasi)
    {
        $akreditasi->delete();

        return redirect()
            ->route('akreditasi.admin.index')
            ->with('pesan', 'Data akreditasi berhasil dihapus.');
    }

    private function validateData(Request $request, Akreditasi $akreditasi = null)
    {
        $uniqueProdi = Rule::unique('akreditasis', 'prodi_id');

        if ($akreditasi) {
            $uniqueProdi->ignore($akreditasi->id);
        }

        return $request->validate([
            'prodi_id' => ['required', 'integer', 'exists:prodis,id', $uniqueProdi],
            'fakultas' => 'required|string|max:150',
            'peringkat' => 'required|string|max:100',
            'sertifikat_url' => 'nullable|url|max:2000',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_akreditasi' => 'required|date',
        ], [
            'prodi_id.unique' => 'Program studi tersebut sudah memiliki data akreditasi.',
            'sertifikat_url.url' => 'Link sertifikat harus berupa URL yang valid.',
        ]);
    }
}
