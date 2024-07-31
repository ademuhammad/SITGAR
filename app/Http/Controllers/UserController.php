<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\Opd;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                    ->addIndexColumn() // Adds DT_RowIndex for numbering
                    ->addColumn('action', function($row){
                        $editUrl = route('user.edit', $row->id);
                        $deleteUrl = route('user.destroy', $row->id);

                        $editBtn = '<a href="'.$editUrl.'" class="edit btn btn-primary btn-sm">Edit</a>';
                        $deleteBtn = '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deleteUser('.$row->id.')">Delete</a>';

                        return $editBtn . ' ' . $deleteBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $opds = Opd::all(); // Mengambil semua data OPD
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles', 'opds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'opd_id' => 'nullable|exists:opds,id', // Validasi opd_id jika ada
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }


    public function show($id): View
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $opds = Opd::all();

        return view('users.edit', compact('user', 'roles', 'userRole', 'opds'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'opd_id' => 'nullable|exists:opds,id',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        try {
            // Begin a transaction
            DB::beginTransaction();

            $user = User::findOrFail($id); // Find the user or fail if not found

            // Detach roles to avoid orphan records in the pivot table
            $user->roles()->detach();

            $user->delete(); // Delete the user

            // Commit the transaction
            DB::commit();

            return redirect()->route('user.index')
                ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            return redirect()->route('user.index')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
