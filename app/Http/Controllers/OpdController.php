<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Opd::all();
        return view ('Master.opd', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.create-opd');
    }

    public function store(Request $request)
    {
        $request->validate([
            'opd_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Opd::create([
            'opd_name' => $request->opd_name,
            'description' => $request->description,
        ]);

        return redirect()->route('opds.index')->with('success', 'OPD created successfully.');
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
    public function edit(Opd $opd)
    {
        return view('crud.edit-opd', compact('opd'));
    }

    public function update(Request $request, Opd $opd)
    {
        $request->validate([
            'opd_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $opd->update([
            'opd_name' => $request->opd_name,
            'description' => $request->description,
        ]);

        return redirect()->route('opds.index')->with('success', 'OPD updated successfully.');
    }

    public function destroy(Opd $opd)
    {
        $opd->delete();
        return redirect()->route('opds.index')->with('success', 'OPD deleted successfully.');
    }
}
