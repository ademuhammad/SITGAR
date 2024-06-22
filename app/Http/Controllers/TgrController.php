<?php

namespace App\Http\Controllers;

use App\Models\Statustgr;
use Illuminate\Http\Request;

class TgrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Statustgr::all();
        return view('Master.tgr', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.create-tgr');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgr_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Statustgr::create([
            'tgr_name' => $request->tgr_name,
            'description' => $request->description,
        ]);

        return redirect()->route('tgr.index')->with('success', 'Status created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Not implemented
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tgr = Statustgr::findOrFail($id);
        return view('crud.edit-tgr', compact('tgr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgr_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tgr = Statustgr::findOrFail($id);
        $tgr->update([
            'tgr_name' => $request->tgr_name,
            'description' => $request->description,
        ]);

        return redirect()->route('tgr.index')->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tgr = Statustgr::findOrFail($id);
        $tgr->delete();

        return redirect()->route('tgr.index')->with('success', 'Status deleted successfully.');
    }
}
