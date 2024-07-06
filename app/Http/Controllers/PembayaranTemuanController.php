<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Temuan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranTemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:pembayaran-list|pembayaran-create|pembayaran-edit|pembayaran-delete', ['only' => ['index', 'show','downloadPdf']]);
        $this->middleware('permission:pembayaran-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pembayaran-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pembayaran-delete', ['only' => ['destroy']]);
        $this->middleware('permission:pembayaran-download', ['only' => ['downloadPdf']]);
    }

    public function index(Temuan $temuan)
    {
        $pembayarans = $temuan->pembayarans;
        return view('pembayaran.history-pembayaran', compact('temuan', 'pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Temuan $temuan)
    {
        return view('pembayaran.create-pembayaran', compact('temuan'));
    }

    public function store(Request $request, Temuan $temuan)
    {
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric',
            'tgl_pembayaran' => 'required|date',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $pembayaran = new Pembayaran();
        $pembayaran->temuan_id = $temuan->id;
        $pembayaran->jumlah_pembayaran = $request->jumlah_pembayaran;
        $pembayaran->tgl_pembayaran = $request->tgl_pembayaran;

        if ($request->hasFile('bukti_surat')) {
            $path = $request->file('bukti_surat')->store('bukti_surat');
            $pembayaran->bukti_surat = $path;
        }
        $pembayaran->save();

        // Update the related Temuan's nilai_telah_dibayar and sisa_nilai_uang
        $temuan->nilai_telah_dibayar += $pembayaran->jumlah_pembayaran;
        $temuan->sisa_nilai_uang -= $pembayaran->jumlah_pembayaran;
        $temuan->save();

        return redirect()->route('temuan.index')->with('success', 'Pembayaran berhasil ditambahkan.');
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
    public function downloadPdf()
    {
        // Ambil semua pembayaran dengan temuan yang terkait
        $pembayarans = Pembayaran::with('temuan.opd')->get();

        // Ambil temuan dari pembayaran pertama (asumsi semua pembayaran terkait dengan satu temuan)
        $temuan = $pembayarans->first()->temuan ?? null;

        $pdf = PDF::loadView('pembayaran.downloadpdf', compact('pembayarans', 'temuan'));
        return $pdf->download('history_pembayaran.pdf');
    }
}
