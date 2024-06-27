<?php

namespace App\Http\Controllers;

use App\Models\Penyedia;
use Illuminate\Http\Request;

class PenyediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:penyedia-list|penyedia-create|penyedia-edit|penyedia-delete', ['only' => ['index','show']]);
         $this->middleware('permission:penyedia-create', ['only' => ['create','store']]);
         $this->middleware('permission:penyedia-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penyedia-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
        $data = Penyedia::all();
        return view('Master.penyedia', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.create-penyedia');
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyedia_name' => 'required|string|max:255',
            'penyedia_address' => 'required|string|max:255',
            'penyedia_izin' => 'required|string|max:255',
            'penyedia_information' => 'nullable|string',
        ]);

        Penyedia::create($request->all());

        return redirect()->route('penyedia.index')->with('success', 'Penyedia created successfully.');
    }

    public function edit($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        return view('crud.edit-penyedia', compact('penyedia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penyedia_name' => 'required|string|max:255',
            'penyedia_address' => 'required|string|max:255',
            'penyedia_izin' => 'required|string|max:255',
            'penyedia_information' => 'nullable|string',
        ]);

        $penyedia = Penyedia::findOrFail($id);
        $penyedia->update($request->all());

        return redirect()->route('penyedia.index')->with('success', 'Penyedia updated successfully.');
    }

    public function destroy($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        $penyedia->delete();

        return redirect()->route('penyedia.index')->with('success', 'Penyedia deleted successfully.');
    }
}
