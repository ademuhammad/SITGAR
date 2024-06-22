<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Informasi::all();
        return view('Master.informasi', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.create-informasi');
    }

    public function store(Request $request)
{
    $request->validate([
        'dinas_name' => 'required|string|max:255',
        'informations_name' => 'required|string|max:255',
    ]);

    Informasi::create([
        'dinas_name' => $request->dinas_name,
        'informations_name' => $request->informations_name,
    ]);

    return redirect()->route('informasi.index')->with('success', 'Informasi created successfully.');
}


    public function edit(Informasi $informasi)
    {
        return view('crud.edit-informasi', compact('informasi'));
    }

    public function update(Request $request, Informasi $informasi)
    {
        $request->validate([
            'dinas_name' => 'required|string|max:255',
            'informations_name' => 'nullable|string',
        ]);

        $informasi->update([
            'dinas_name' => $request->dinas_name,
            'informations_name' => $request->informations_name,
        ]);

        return redirect()->route('informasi.index')->with('success', 'informasi updated successfully.');
    }

    public function destroy(Informasi $Informasi)
    {
        $Informasi->delete();
        return redirect()->route('informasi.index')->with('success', 'Informasi deleted successfully.');
    }
}
