<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Temuan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $totalPaid = $pembayarans->where('status', 'diterima')->sum('jumlah_pembayaran');
        $remainingAmount = $temuan->sisa_nilai_uang;

        // Group payments by month and year
        $pembayaransByMonth = $pembayarans->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->tgl_pembayaran)->format('Y-m'); // grouping by year and month
        });

        $totalMonths = $pembayaransByMonth->count();

        return view('pembayaran.history-pembayaran', compact('temuan', 'pembayarans', 'totalPaid', 'remainingAmount', 'totalMonths'));
    }



    /**
     * Show the form for creating a new resource.
     */

    public function create(Temuan $temuan)
    {
        $remainingAmount = $temuan->sisa_nilai_uang;
        return view('pembayaran.create-pembayaran', compact('temuan', 'remainingAmount'));
    }

    // public function store(Request $request, Temuan $temuan)
    // {
    //     $remainingAmount = $temuan->sisa_nilai_uang;

    //     $request->validate([
    //         'jumlah_pembayaran' => [
    //             'required',
    //             'numeric',
    //             function ($attribute, $value, $fail) use ($remainingAmount) {
    //                 if ($value > $remainingAmount) {
    //                     $fail('Jumlah pembayaran tidak boleh melebihi sisa bayar.');
    //                 }
    //             },
    //         ],
    //         'tgl_pembayaran' => 'required|date',
    //         'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048'
    //     ]);

    //     $pembayaran = new Pembayaran();
    //     $pembayaran->temuan_id = $temuan->id;
    //     $pembayaran->jumlah_pembayaran = $request->jumlah_pembayaran;
    //     $pembayaran->tgl_pembayaran = $request->tgl_pembayaran;

    //     if ($request->hasFile('bukti_pembayaran')) {
    //         $file = $request->file('bukti_pembayaran');
    //         $fileName = time() . '_bukti_pembayaran.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('bukti_pembayaran'), $fileName);
    //         $pembayaran->bukti_pembayaran = $fileName;
    //     }

    //     $pembayaran->save();

    //     // Update the related Temuan's nilai_telah_dibayar and sisa_nilai_uang
    //     $temuan->nilai_telah_dibayar += $pembayaran->jumlah_pembayaran;
    //     $temuan->sisa_nilai_uang -= $pembayaran->jumlah_pembayaran;

    //     // Check if the remaining amount is zero and update status
    //     if ($temuan->sisa_nilai_uang == 0) {
    //         // Retrieve the ID of the "selesai" status from the statuses table
    //         $selesaiStatus = DB::table('statuses')->where('status', 'selesai')->first();
    //         if ($selesaiStatus) {
    //             $temuan->status_id = $selesaiStatus->id;
    //         }
    //     }

    //     $temuan->save();

    //     return redirect()->route('data.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    // }


    public function store(Request $request, Temuan $temuan)
    {
        $remainingAmount = $temuan->sisa_nilai_uang;

        $request->validate([
            'jumlah_pembayaran' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($remainingAmount) {
                    if ($value > $remainingAmount) {
                        $fail('Jumlah pembayaran tidak boleh melebihi sisa bayar.');
                    }
                },
            ],
            'tgl_pembayaran' => 'required|date',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $pembayaran = new Pembayaran();
        $pembayaran->temuan_id = $temuan->id;
        $pembayaran->jumlah_pembayaran = $request->jumlah_pembayaran;
        $pembayaran->tgl_pembayaran = $request->tgl_pembayaran;
        $pembayaran->status = 'pending'; // Set as pending

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_bukti_pembayaran.' . $file->getClientOriginalExtension();
            $file->move(public_path('bukti_pembayaran'), $fileName);
            $pembayaran->bukti_pembayaran = $fileName;
        }

        $pembayaran->save();
        return redirect()->route('pembayaran.index', $temuan->id)
        ->with('success', 'Pembayaran berhasil ditambahkan dan menunggu persetujuan.');

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
        $totalPembayaran = $pembayarans->where('status', 'diterima')->sum('jumlah_pembayaran');

        // Hitung nilai rekomendasi dari temuan, jika temuan ada
        $nilaiRekomendasi = $temuan ? $temuan->nilai_rekomendasi : 0;

        // Hitung sisa yang harus dibayar
        $sisaYangHarusDibayar = $nilaiRekomendasi - $totalPembayaran;

        // Group payments by month and year
        $pembayaransByMonth = $pembayarans->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->tgl_pembayaran)->format('Y-m'); // grouping by year and month
        });

        $totalMonths = $pembayaransByMonth->count();

        // Buat nama file dengan timestamp
        $filename = 'history_pembayaran_' . now()->format('Ymd_His') . '.pdf';

        // Tambahkan $totalMonths ke dalam compact
        $pdf = PDF::loadView('pembayaran.downloadpdf', compact('pembayarans', 'temuan', 'totalPembayaran', 'nilaiRekomendasi', 'sisaYangHarusDibayar', 'totalMonths'));
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
    public function validateList()
    {
        // Ambil pembayaran yang statusnya masih pending dan muat relasi yang dibutuhkan
        $pembayarans = Pembayaran::with(['temuan.opd']) // Assuming the 'temuan' relation has 'opd'
                           ->where('status', 'pending') // Filter by status
                           ->get(); // Retrieve the results

        return view('validator.validasi-pembayaran', compact('pembayarans'));
    }

    public function validatePayment(Request $request, Pembayaran $pembayaran)
    {
        $this->authorize('validate-payment'); // Memeriksa izin

        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'keterangan' => 'nullable|string|max:255', // Validasi untuk keterangan
        ]);

        $pembayaran->status = $request->status;
        $pembayaran->keterangan = $request->keterangan; // Menyimpan keterangan
        $pembayaran->save();

        if ($pembayaran->status == 'diterima') {
            $temuan = $pembayaran->temuan;

            // Update nilai_telah_dibayar dan sisa_nilai_uang di temuan terkait
            $temuan->nilai_telah_dibayar += $pembayaran->jumlah_pembayaran;
            $temuan->sisa_nilai_uang -= $pembayaran->jumlah_pembayaran;

            if ($temuan->sisa_nilai_uang == 0) {
                // Jika sisa nilai uang adalah 0, update status temuan
                $selesaiStatus = DB::table('statuses')->where('status', 'selesai')->first();
                if ($selesaiStatus) {
                    $temuan->status_id = $selesaiStatus->id;
                }
            }

            $temuan->save();
        }

        return redirect()->route('pembayaran.validate.list')->with('success', 'Status pembayaran berhasil diperbarui.');
    }


}
