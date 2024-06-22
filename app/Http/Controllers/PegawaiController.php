<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pegawai::with('opd')->get();
        return view('Master.pegawai', compact('data'));
    }

    public function create()
    {
        $opds = Opd::all();
        return view('crud.create-pegwai', compact('opds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'required|string|max:255',
            'opd_id' => 'required|exists:opds,id',
        ]);

        Pegawai::create($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai created successfully.');
    }

    public function edit(Pegawai $pegawai)
    {
        $opds = Opd::all();
        return view('crud.edit-pegawai', compact('pegawai', 'opds'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nip' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'required|string|max:255',
            'opd_id' => 'required|exists:opds,id',
        ]);

        $pegawai->update($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai updated successfully.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai deleted successfully.');
    }
}
