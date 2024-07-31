<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     function __construct()
     {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
         $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
     }
    public function index()
    {
        //

        $user = Auth::user();

        // Check if the user is authenticated and not null
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
        }

        return view('users.profile', compact('user'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user->fill($request->all());

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_temuan = time() . '_temuan.' . $file->getClientOriginalExtension();
            $gambarPath = public_path('photos');
            $file->move($gambarPath, $file_temuan);
            $user->photo = $file_temuan;
        }
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
