<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Status;
use App\Models\Temuan;
use App\Models\Pegawai;
use App\Models\Penyedia;
use App\Models\Informasi;
use App\Models\JenisTemuan;
use App\Models\Statustgr;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class Skp2ksController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:data-list|data-create|data-edit|data-delete', ['only' => ['index', 'show',
        'alldata','exportPDF','exportCSV','exportPDF']]);
        $this->middleware('permission:data-create', ['only' => ['create', 'store', '']]);
        $this->middleware('permission:data-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:data-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Builder $builder)
    {
        //
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
            ['data' => 'nilai_telah_dibayar', 'name' => 'nilai_telah_dibayar', 'title' => 'Nilai Telah Dibayar'],
            ['data' => 'sisa_nilai_uang', 'name' => 'sisa_nilai_uang', 'title' => 'Nilai Sisa'],
        ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print'],
            ]);

        return view('Laporan.data-skp2ks', compact('html', 'statuses', 'opds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         //
         $informasis = Informasi::all();
         $opds = Opd::all();
         $statuses = Status::all();
         $statustgrs = Statustgr::all();
         $pegawais = Pegawai::all();
         $penyedias = Penyedia::all();
         $jenisTemuans = JenisTemuan::all();
         $defaultStatustgr = Statustgr::where('tgr_name', 'SKP2KS')->first();
         return view('crud.create-skp2ks', compact('informasis', 'jenisTemuans','opds', 'statuses', 'statustgrs', 'pegawais', 'penyedias', 'defaultStatustgr'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
            // Ambil status_id dan cek apakah status adalah "selesai"
            $statusSelesaiId = 1; // Gantilah 1 dengan id status "selesai" yang sesuai

            // Validasi umum
            $rules = [
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
                'no_sktjm' => 'required|string|max:255',
                'jumlah_jaminan' => 'nullable|numeric',
                'jenis_jaminan' => 'nullable|string|max:255',
                'nilai_rekomendasi' => 'required|numeric',
            ];

            // Tambahkan validasi untuk 'bukti_surat' jika status adalah "selesai"
            if ($request->input('status_id') == $statusSelesaiId) {
                $rules['bukti_surat'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            } else {
                $rules['bukti_surat'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }

            $request->validate($rules);

            // Buat instance dari model Temuan
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
            $temuan->no_sktjm = $request->input('no_sktjm');
            $temuan->jumlah_jaminan = $request->input('jumlah_jaminan');
            $temuan->jenis_jaminan = $request->input('jenis_jaminan');
            $temuan->nilai_rekomendasi = $request->input('nilai_rekomendasi');

            // Proses upload file
            if ($request->hasFile('bukti_surat')) {
                $file = $request->file('bukti_surat');
                $file_temuan = time() . '_temuan.' . $file->getClientOriginalExtension();
                $gambarPath = public_path('bukti_temuan');
                $file->move($gambarPath, $file_temuan);
                $temuan->bukti_surat = $file_temuan;
            }

            // Inisialisasi field pembayaran
            $temuan->nilai_telah_dibayar = 0;
            $temuan->sisa_nilai_uang = $temuan->nilai_rekomendasi;

            // Simpan data
            $temuan->save();

            return redirect()->route('skp2ks.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $temuan = Temuan::findOrFail($id);
        $informasis = Informasi::all();
        $opds = Opd::all();
        $statuses = Status::all();
        $statustgrs = Statustgr::all();
        $pegawais = Pegawai::all();
        $penyedias = Penyedia::all();
        $jenisTemuans = JenisTemuan::all();
        return view('crud.edit_skp2ks', compact('jenisTemuans','temuan', 'informasis', 'opds', 'statuses', 'statustgrs', 'pegawais', 'penyedias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
            'no_skp2ks' => 'required|string|max:255', // Pastikan ini sesuai dengan struktur tabel Anda
            'jumlah_jaminan' => 'nullable|numeric',
            'jenis_jaminan' => 'nullable|string|max:255',
            'nilai_rekomendasi' => 'required|numeric',
            'bukti_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $temuan = Temuan::findOrFail($id);
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
        $temuan->no_skp2ks = $request->input('no_skp2ks'); // Pastikan ini sesuai dengan nama kolom di tabel
        $temuan->jumlah_jaminan = $request->input('jumlah_jaminan');
        $temuan->jenis_jaminan = $request->input('jenis_jaminan');
        $temuan->nilai_rekomendasi = $request->input('nilai_rekomendasi');

        if ($request->hasFile('bukti_surat')) {
            // Hapus file lama jika ada
            if ($temuan->bukti_surat && file_exists(public_path('bukti_temuan/' . $temuan->bukti_surat))) {
                unlink(public_path('bukti_temuan/' . $temuan->bukti_surat));
            }

            $file = $request->file('bukti_surat');
            $file_temuan = time() . '_temuan.' . $file->getClientOriginalExtension();
            $gambarPath = public_path('bukti_temuan');
            $file->move($gambarPath, $file_temuan);
            $temuan->bukti_surat = $file_temuan;
        }

        $temuan->save();
        return redirect()->route('skp2ks.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $temuan = Temuan::findOrFail($id);

        // Hapus file terkait jika ada
        if ($temuan->bukti_surat && file_exists(public_path('bukti_temuan/' . $temuan->bukti_surat))) {
            unlink(public_path('bukti_temuan/' . $temuan->bukti_surat));
        }

        // Hapus data dari database
        $temuan->delete();

        return redirect()->route('skp2k.index')->with('success', 'Data berhasil dihapus');
    }
}
