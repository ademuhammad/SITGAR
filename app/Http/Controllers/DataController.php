<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Opd;
use App\Models\Pegawai;
use App\Models\Penyedia;
use App\Models\Status;
use App\Models\Statustgr;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            $query = Temuan::with(['status', 'opd', 'informasi', 'pegawai', 'penyedia'])
                ->whereNull('statustgr_id');

            // Tambahkan filter di sini
            if ($request->has('status_id') && $request->status_id != '') {
                $query->where('status_id', $request->status_id);
            }
            if ($request->has('no_lhp') && $request->no_lhp != '') {
                $query->where('no_lhp', 'like', '%' . $request->no_lhp . '%');
            }
            if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '' && $request->end_date != '') {
                $query->whereBetween('tgl_lhp', [$request->start_date, $request->end_date]);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return $row->status ? $row->status->status : '-';
                })
                ->addColumn('opd_name', function ($row) {
                    return $row->opd ? $row->opd->opd_name : '-';
                })
                ->addColumn('dinas_name', function ($row) {
                    return $row->informasi ? $row->informasi->dinas_name : '-';
                })
                ->addColumn('pegawai_name', function ($row) {
                    return $row->pegawai ? $row->pegawai->name : '-';
                })
                ->addColumn('penyedia_name', function ($row) {
                    return $row->penyedia ? $row->penyedia->penyedia_name : '-';
                })
                ->addIndexColumn()
                ->make(true);
        }

        $statuses = Status::all();

        $html = $builder->columns([
            ['data' => 'dinas_name', 'name' => 'dinas_name', 'title' => 'Sumber Informasi'],
            ['data' => 'opd_name', 'name' => 'opd_name', 'title' => 'Nama OPD'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'tgr_name', 'name' => 'tgr_name', 'title' => 'Statustgr ID'],
            ['data' => 'pegawai_name', 'name' => 'pegawai_name', 'title' => 'Nama Pegawai'],
            ['data' => 'penyedia_name', 'name' => 'penyedia_name', 'title' => 'Nama Penyedia'],
            ['data' => 'no_lhp', 'name' => 'no_lhp', 'title' => 'No LHP'],
            ['data' => 'tgl_lhp', 'name' => 'tgl_lhp', 'title' => 'Tgl LHP'],
            ['data' => 'obrik_pemeriksaan', 'name' => 'obrik_pemeriksaan', 'title' => 'Obrik Pemeriksaan'],
            ['data' => 'temuan', 'name' => 'temuan', 'title' => 'Temuan'],
            ['data' => 'rekomendasi', 'name' => 'rekomendasi', 'title' => 'Rekomendasi'],
            ['data' => 'nilai_rekomendasi', 'name' => 'nilai_rekomendasi', 'title' => 'Nilai Rekomendasi'],
            ['data' => 'bukti_surat', 'name' => 'bukti_surat', 'title' => 'Bukti Surat'],
        ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print'],
            ]);

        return view('Laporan.data-mentah', compact('html', 'statuses'));
    }



    public function getDataMentah(Request $request)
    {
        if ($request->ajax()) {
            $data = Temuan::whereNull('bukti_bayar')->orWhere('bukti_bayar', '')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    // public function data()
    // {
    //     return view('Laporan.data-mentah');
    // }

    // public function getDataMentah(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Temuan::whereNull('bukti_bayar')->orWhere('bukti_bayar', '')->get();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->make(true);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $informasis = Informasi::all();
        $opds = Opd::all();
        $statuses = Status::all();
        $statustgrs = Statustgr::all();
        $pegawais = Pegawai::all();
        $penyedias = Penyedia::all();
        return view('crud.create-data', compact('informasis', 'opds', 'statuses', 'statustgrs', 'pegawais', 'penyedias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'informasis_id' => 'required|exists:informasis,id',
            'opd_id' => 'required|exists:opds,id',
            'status_id' => 'required|exists:statuses,id',

            'pegawai_id' => 'required|exists:pegawais,id',
            'penyedia_id' => 'required|exists:penyedias,id',
            'no_lhp' => 'required|string|max:255',
            'tgl_lhp' => 'required|date',
            'obrik_pemeriksaan' => 'required',
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

        return redirect()->route('data.index')->with('success', 'Temuan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($no_lhp)
    {
        // Decode the URL-encoded parameter
        $no_lhp = urldecode($no_lhp);
        $data = Temuan::where('no_lhp', $no_lhp)->firstOrFail();
        return view('show.show-data-lhp', compact('data'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
