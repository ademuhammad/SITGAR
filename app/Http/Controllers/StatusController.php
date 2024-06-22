<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        //
        $request->validate([
            'status' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Status::create([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('status.index')->with('success', 'Status created successfully.');
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
