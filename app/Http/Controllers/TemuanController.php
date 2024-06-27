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
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class TemuanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:temuan-list|temuan-create|temuan-edit|temuan-delete', ['only' => ['index', 'show', 'datasktjm', 'dataskp2ks', 'dataskp2k']]);
        $this->middleware('permission:temuan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:temuan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:temuan-delete', ['only' => ['destroy']]);
    }
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
            'bukti_surat' => 'nullable|file'
        ]);

        $temuan = new Temuan();
        $temuan->informasis_id = $request->input('informasis_id');
        $temuan->opd_id = $request->input('opd_id');
        $temuan->status_id = $request->input('status_id');
        $temuan->statustgr_id = $request->input('statustgr_id');
        $temuan->pegawai_id = $request->input('pegawai_id');
        $temuan->penyedia_id = $request->input('penyedia_id');
        $temuan->no_lhp = $request->input('no_lhp');
        $temuan->tgl_lhp = $request->input('tgl_lhp');
        $temuan->obrik_pemeriksaan = $request->input('obrik_pemeriksaan');
        $temuan->temuan = $request->input('temuan');
        $temuan->rekomendasi = $request->input('rekomendasi');
        $temuan->nilai_rekomendasi = $request->input('nilai_rekomendasi');

        if ($request->hasFile('bukti_surat')) {
            $file = $request->file('bukti_surat');
            $file_temuan = time() . '_temuan.' . $file->getClientOriginalExtension();
            $gambarPath = public_path('bukti_temuan');
            $file->move($gambarPath, $file_temuan);
            $temuan->bukti_surat = $file_temuan;
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
            'obrik_pemeriksaan' => 'required|string|max:255',
            'temuan' => 'required|string',
            'rekomendasi' => 'required|string',
            'nilai_rekomendasi' => 'required|numeric',
            'bukti_surat' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $temuan->fill($request->all());

        if ($request->hasFile('bukti_surat')) {
            $file = $request->file('bukti_surat');
            $file_temuan = time() . '_temuan.' . $file->getClientOriginalExtension();
            $gambarPath = public_path('bukti_temuan');
            $file->move($gambarPath, $file_temuan);
            $temuan->bukti_surat = $file_temuan;
        }



        $temuan->save();

        return redirect()->route('data.index')->with('success', 'Temuan updated successfully.');
    }
    public function destroy(Temuan $temuan)
    {
        $temuan->delete();
        return redirect()->route('temuan.index')->with('success', 'Temuan deleted successfully.');
    }
    public function datasktjm(Request $request, Builder $builder)
    {
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
            ['data' => 'nilai_telah_dibayar', 'name' => 'nilai_telah_dibayar', 'title' => 'Nilai Telah Dibayar'],
            ['data' => 'sisa_nilai_uang', 'name' => 'sisa_nilai_uang', 'title' => 'Nilai Sisa'],
        ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print'],
            ]);

        return view('Laporan.data-sktjm', compact('html', 'statuses'));
    }

    public function getDatasktjm(Request $request)
    {
        if ($request->ajax()) {
            $query = Temuan::with(['status', 'opd', 'informasi', 'pegawai', 'penyedia'])
                ->whereHas('statustgr', function ($query) {
                    $query->where('tgr_name', 'SKTJM');
                });

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
    }
    public function dataskp2ks(Request $request, Builder $builder)
    {
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
            ['data' => 'nilai_telah_dibayar', 'name' => 'nilai_telah_dibayar', 'title' => 'Nilai Telah Dibayar'],
            ['data' => 'sisa_nilai_uang', 'name' => 'sisa_nilai_uang', 'title' => 'Nilai Sisa'],

        ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print'],
            ]);

        return view('Laporan.data-skp2ks', compact('html', 'statuses'));
    }

    public function getDataskp2ks(Request $request)
    {
        if ($request->ajax()) {
            $query = Temuan::with(['status', 'opd', 'informasi', 'pegawai', 'penyedia'])
                ->whereHas('statustgr', function ($query) {
                    $query->where('tgr_name', 'SKP2KS');
                });

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
    }
    public function dataskp2k(Request $request, Builder $builder)
    {
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
            ['data' => 'nilai_telah_dibayar', 'name' => 'nilai_telah_dibayar', 'title' => 'Nilai Telah Dibayar'],
            ['data' => 'sisa_nilai_uang', 'name' => 'sisa_nilai_uang', 'title' => 'Nilai Sisa'],

        ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print'],
            ]);

        return view('Laporan.data-skp2k', compact('html', 'statuses'));
    }

    public function getDataskp2k(Request $request)
    {
        if ($request->ajax()) {
            $query = Temuan::with(['status', 'opd', 'informasi', 'pegawai', 'penyedia'])
                ->whereHas('statustgr', function ($query) {
                    $query->where('tgr_name', 'SKP2K');
                });

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
    }
}
