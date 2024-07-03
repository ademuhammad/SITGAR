<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     function __construct()
     {
          $this->middleware('permission:status-list|status-create|status-edit|status-delete', ['only' => ['index','show']]);
          $this->middleware('permission:status-create', ['only' => ['create','store']]);
          $this->middleware('permission:status-edit', ['only' => ['edit','update']]);
          $this->middleware('permission:status-delete', ['only' => ['destroy']]);
     }
    public function index()
    {
        //
        $data = Status::all();
        return view('Master.status', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('crud.create-status');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Buat instance Status dan simpan ke database
        Status::create([
            'status' => $request->input('status'),
            'description' => $request->input('description'),
        ]);





        return redirect()->route('status.index')
            ->with('success', 'Role created successfully');
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
        return view('crud.edit-status');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
        $request->validate([
            'status' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status->update([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('status.index')->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        //
        $status->delete();
        return redirect()->route('status.index')->with('success', 'Status deleted successfully.');
    }
}
