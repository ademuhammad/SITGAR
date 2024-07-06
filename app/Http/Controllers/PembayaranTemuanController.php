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
        $this->middleware('permission:pembayaran-list|pembayaran-create|pembayaran-edit|pembayaran-delete', ['only' => ['index', 'show', 'downloadPdf']]);
        $this->middleware('permission:pembayaran-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pembayaran-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pembayaran-delete', ['only' => ['destroy']]);
        $this->middleware('permission:pembayaran-download', ['only' => ['downloadPdf']]);
    }

    public function index(Temuan $temuan)
    {
        $pembayarans = $temuan->pembayarans;

        // Calculate total paid and remaining amount
        $totalPaid = $pembayarans->sum('jumlah_pembayaran');
        $remainingAmount = $temuan->sisa_nilai_uang;

        return view('pembayaran.history-pembayaran', compact('temuan', 'pembayarans', 'totalPaid', 'remainingAmount'));
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
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $pembayaran = new Pembayaran();
        $pembayaran->temuan_id = $temuan->id;
        $pembayaran->jumlah_pembayaran = $request->jumlah_pembayaran;
        $pembayaran->tgl_pembayaran = $request->tgl_pembayaran;

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_bukti_pembayaran.' . $file->getClientOriginalExtension();
            $file->move(public_path('bukti_pembayaran'), $fileName);
            $pembayaran->bukti_pembayaran = $fileName;
        }

        $pembayaran->save();

        // Update the related Temuan's nilai_telah_dibayar and sisa_nilai_uang
        $temuan->nilai_telah_dibayar += $pembayaran->jumlah_pembayaran;
        $temuan->sisa_nilai_uang -= $pembayaran->jumlah_pembayaran;
        $temuan->save();

        return redirect()->route('data.index')->with('success', 'Pembayaran berhasil ditambahkan.');
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

        // Hitung total pembayaran
        $totalPembayaran = $pembayarans->sum('jumlah_pembayaran');

        // Hitung total bayar dari temuan, jika temuan ada
        $totalBayar = $temuan ? $temuan->total_bayar : 0;

        // Hitung sisa yang harus dibayar
        $sisaYangHarusDibayar = $totalBayar - $totalPembayaran;

        // Buat nama file dengan timestamp
        $filename = 'history_pembayaran_' . now()->format('Ymd_His') . '.pdf';

        $pdf = PDF::loadView('pembayaran.downloadpdf', compact('pembayarans', 'temuan', 'totalPembayaran', 'sisaYangHarusDibayar'));
        return $pdf->download($filename);
    }



    public function download($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->bukti_pembayaran) {
            $pathToFile = storage_path('app/' . $pembayaran->bukti_pembayaran);
            return response()->download($pathToFile);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
}
