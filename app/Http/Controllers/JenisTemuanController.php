<?php

namespace App\Http\Controllers;

use App\Models\JenisTemuan;
use Illuminate\Http\Request;

class JenisTemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:opd-list|opd-create|opd-edit|opd-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:opd-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:opd-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:opd-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
        $jenisjaminan = JenisTemuan::all();
        return view('Master.jenis-jaminan', compact('jenisjaminan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('crud.create-jenisjaminan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //
        $request->validate([
            'jenis_temuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        JenisTemuan::create([
            'jenis_temuan' => $request->jenis_temuan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jenistemuan.index')->with('success', 'Data berhasil ditambahkan.');
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
    public function edit(JenisTemuan $jenistemuan)
    {
        return view('crud.edit-jenisjaminan', compact('jenistemuan'));
    }

    public function update(Request $request, JenisTemuan $jenistemuan)
    {
        $request->validate([
            'jenis_temuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jenistemuan->update([
            'jenis_temuan' => $request->jenis_temuan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jenistemuan.index')->with('success', 'Data berhasil diubah.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisTemuan $jenistemuan)
    {
        $jenistemuan->delete();

        return redirect()->route('jenistemuan.index')->with('success', 'Data berhasil dihapus.');
    }

}







