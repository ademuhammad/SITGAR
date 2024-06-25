<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Opd;
use App\Models\Status;
use App\Models\Temuan;
use App\Models\Pegawai;
use App\Models\Penyedia;
use App\Models\Informasi;
use App\Models\Statustgr;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TemuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $temuans = Temuan::with(['informasi', 'opd', 'status', 'statustgr', 'pegawai', 'penyedia'])
            ->whereHas('statustgr', function ($query) {
                $query->where('tgr_name', 'SKTJM');
            })
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('no_lhp', 'like', '%' . $search . '%')
                        ->orWhereHas('opd', function ($q) use ($search) {
                            $q->where('opd_name', 'like', '%' . $search . '%');
                        });
                }
            })
            ->get();

        $temuans2 = Temuan::with(['informasi', 'opd', 'status', 'statustgr', 'pegawai', 'penyedia'])
            ->whereHas('statustgr', function ($query) {
                $query->where('tgr_name', 'SKP2KS');
            })
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('no_lhp', 'like', '%' . $search . '%')
                        ->orWhereHas('opd', function ($q) use ($search) {
                            $q->where('opd_name', 'like', '%' . $search . '%');
                        });
                }
            })
            ->get();

        $temuans3 = Temuan::with(['informasi', 'opd', 'status', 'statustgr', 'pegawai', 'penyedia'])
            ->whereHas('statustgr', function ($query) {
                $query->where('tgr_name', 'SKP2K');
            })
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('no_lhp', 'like', '%' . $search . '%')
                        ->orWhereHas('opd', function ($q) use ($search) {
                            $q->where('opd_name', 'like', '%' . $search . '%');
                        });
                }
            })
            ->get();

        return view('Laporan.test', compact('temuans', 'temuans2', 'temuans3'));
    }




    public function create()
    {
        $informasis = Informasi::all();
        $opds = Opd::all();
        $statuses = Status::all();
        $statustgrs = Statustgr::all();
        $pegawais = Pegawai::all();
        $penyedias = Penyedia::all();
        return view('crud.create-temuan', compact('informasis', 'opds', 'statuses', 'statustgrs', 'pegawais', 'penyedias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'informasis_id' => 'required|exists:informasis,id',
            'opd_id' => 'required|exists:opds,id',
            'status_id' => 'required|exists:statuses,id',
            'statustgr_id' => 'required|exists:statustgrs,id',
            'pegawai_id' => 'required|exists:pegawais,id',
            'penyedia_id' => 'required|exists:penyedias,id',
            'no_lhp' => 'required|string|max:255',
            'tgl_lhp' => 'required|date',
            'obrik_pemeriksaan' => 'required|string|max:255',
            'temuan' => 'required|string',
            'rekomendasi' => 'required|string',
            'nilai_rekomendasi' => 'required|numeric',
            'bukti_surat' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $temuan = new Temuan($request->all());

        // if ($request->hasFile('bukti_surat')) {
        //     $path = $request->file('bukti_surat')->store('bukti_surat');
        //     $temuan->bukti_surat = $path;
        // }
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename);
            $temuan->bukti_pembayaran = $path;
        }
        // Initialize payment fields
        $temuan->nilai_telah_dibayar = 0;
        $temuan->sisa_nilai_uang = $temuan->nilai_rekomendasi;

        $temuan->save();

        return redirect()->route('temuan.index')->with('success', 'Temuan created successfully.');
    }

    public function show(Temuan $temuan)
    {
        return view('Laporan.show-temuan', compact('temuan'));
    }

    public function edit(Temuan $temuan)
    {
        $informasis = Informasi::all();
        $opds = Opd::all();
        $statuses = Status::all();
        $statustgrs = Statustgr::all();
        $pegawais = Pegawai::all();
        $penyedias = Penyedia::all();

        return view('crud.edit-temuan', compact('temuan', 'informasis', 'opds', 'statuses', 'statustgrs', 'pegawais', 'penyedias'));
    }

    public function update(Request $request, Temuan $temuan)
    {
        $request->validate([
            'informasis_id' => 'required|exists:informasis,id',
            'opd_id' => 'required|exists:opds,id',
            'status_id' => 'required|exists:statuses,id',
            'statustgr_id' => 'required|exists:statustgrs,id',
            'pegawai_id' => 'required|exists:pegawais,id',
            'penyedia_id' => 'required|exists:penyedias,id',
            'no_lhp' => 'required|string|max:255',
            'tgl_lhp' => 'required|date',
            'obrik_pemeriksaan' => 'required|string',
            'temuan' => 'required|string',
            'rekomendasi' => 'required|string',
            'nilai_rekomendasi' => 'required|numeric',
            'bukti_surat' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $temuan->fill($request->all());

        if ($request->hasFile('bukti_surat')) {
            $path = $request->file('bukti_surat')->store('bukti_surat');
            $temuan->bukti_surat = $path;
        }

        $temuan->save();

        return redirect()->route('temuan.index')->with('success', 'Temuan updated successfully.');
    }
    public function destroy(Temuan $temuan)
    {
        $temuan->delete();
        return redirect()->route('temuan.index')->with('success', 'Temuan deleted successfully.');
    }
}
