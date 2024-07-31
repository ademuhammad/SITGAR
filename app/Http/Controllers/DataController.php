<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Status;
use App\Models\Temuan;
use App\Models\Pegawai;
use App\Models\Penyedia;
//use Barryvdh\DomPDF\PDF;
use App\Models\Informasi;
use App\Models\Statustgr;
use App\Exports\DataExport;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Excel;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Facades\Excel;
//use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:data-list|data-create|data-edit|data-delete', ['only' => [
            'index', 'show',
            'alldata', 'exportPDF', 'exportCSV', 'exportPDF'
        ]]);
        $this->middleware('permission:data-create', ['only' => ['create', 'store', '']]);
        $this->middleware('permission:data-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:data-delete', ['only' => ['destroy']]);
        $this->middleware('permission:show-lhp', ['only' => ['show']]);
    }

    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            $query = Temuan::with(['status', 'opd', 'informasi', 'pegawai', 'penyedia'])
                ->whereNull('statustgr_id');

            // Tambahkan filter di sini
            if ($request->has('opd_id') && $request->opd_id != '') {
                $query->where('opd_id', $request->opd_id);
            }

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
        $opds = Opd::all();

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

        return view('Laporan.data-mentah', compact('html', 'statuses', 'opds'));
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
            'statustgr_id' => 'nullable|exists:statustgrs,id',
            'pegawai_id' => 'required|exists:pegawais,id',
            'penyedia_id' => 'required|exists:penyedias,id',
            'no_lhp' => 'required|string|max:255',
            'tgl_lhp' => 'required|date',
            'obrik_pemeriksaan' => 'required|string',
            'temuan' => 'required|string',
            'rekomendasi' => 'required|string',
            'nilai_rekomendasi' => 'required|numeric',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $temuan = new Temuan($request->except('bukti_pembayaran')); // Exclude the file from mass assignment

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
    public function show($id)
    {
        // Temukan Temuan berdasarkan ID
        $data = Temuan::findOrFail($id);
        return view('show.show-data-lhp', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Temuan::findOrFail($id);
        $informasis = Informasi::all();
        $opds = Opd::all();
        $statuses = Status::all();
        $statustgrs = Statustgr::all();
        $pegawais = Pegawai::all();
        $penyedias = Penyedia::all();
        // Tampilkan view edit atau form edit sesuai kebutuhan Anda
        return view('crud.edit-data', compact('data', 'opds', 'statustgrs', 'pegawais', 'penyedias', 'informasis', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $data = Temuan::findOrFail($id);
        // Lakukan validasi data jika diperlukan
        $data->update($request->all());
        return redirect()->route('data.index')->with('success', 'Data updated successfully');
    }

    public function destroy($id)
    {
        $data = Temuan::findOrFail($id);
        $data->delete();
        return redirect()->route('data.index')->with('success', 'Data deleted successfully');
    }

    public function alldata(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            $query = Temuan::with(['status', 'opd', 'informasi', 'pegawai', 'penyedia']);

            // Add filters
            if ($request->has('opd_id') && $request->opd_id != '') {
                $query->where('opd_id', $request->opd_id);
            }

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

            // Calculate totals
            $totalNilaiRekomendasi = $data->sum('nilai_rekomendasi');
            $totalNilaiTelahDibayar = $data->sum('nilai_telah_dibayar');
            $totalSisaNilaiUang = $data->sum('sisa_nilai_uang');

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
                ->with('totalNilaiRekomendasi', $totalNilaiRekomendasi)
                ->with('totalNilaiTelahDibayar', $totalNilaiTelahDibayar)
                ->with('totalSisaNilaiUang', $totalSisaNilaiUang)
                ->make(true);
        }

        $statuses = Status::all();
        $opds = Opd::all();

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

        return view('Laporan.full-data', compact('html', 'statuses', 'opds'));
    }

    public function exportCSV(Request $request)
    {
        $filters = $request->only(['opd_id', 'status_id', 'no_lhp', 'start_date', 'end_date']);
        return Excel::download(new DataExport($filters), 'data.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['opd_id', 'status_id', 'no_lhp', 'start_date', 'end_date']);
        return Excel::download(new DataExport($filters), 'data.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


    public function exportPDF(Request $request)
    {
        $filters = $request->all();

        $query = Temuan::query();

        if ($filters['status_id']) {
            $query->where('status_id', $filters['status_id']);
        }

        if ($filters['no_lhp']) {
            $query->where('no_lhp', 'like', '%' . $filters['no_lhp'] . '%');
        }

        if ($filters['start_date']) {
            $query->whereDate('tgl_lhp', '>=', $filters['start_date']);
        }

        if ($filters['end_date']) {
            $query->whereDate('tgl_lhp', '<=', $filters['end_date']);
        }

        $data = $query->get();

        $pdf = PDF::loadView('keseluruhan-pdf', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->download('data.pdf');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function testall(Request $request)
    {
        if ($request->ajax()) {
            $data = Temuan::with(['opd', 'status', 'pegawai', 'penyedia'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Laporan.keseluruhan-data');
    }

    public function getPegawaiByOpd(Request $request)
    {
        $opdId = $request->input('opd_id');
        $pegawais = Pegawai::where('opd_id', $opdId)->get();
        return response()->json($pegawais);
    }
}
