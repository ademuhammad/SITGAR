<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permission = Permission::get();
        $opds = Opd::all(); // Mengambil semua data OPD
        return view('roles.create', compact('permission', 'opds'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $this->validate($request, [
             'name' => 'required|unique:roles,name',
             'permission' => 'required|array',
             'role_type' => 'required|in:Super Admin,OPD Admin',
             'opd_id' => 'required_if:role_type,OPD Admin|exists:opds,id',
         ]);

         $role = Role::create([
             'name' => $request->name,
             'role_type' => $request->role_type,
             'opd_id' => $request->role_type === 'OPD Admin' ? $request->opd_id : null,
         ]);

         $role->syncPermissions($request->input('permission'));

         return redirect()->route('role.index')->with('success', 'Role created successfully');
     }




    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
            'role_type' => 'required',
            'opd_id' => 'required_if:role_type,OPD Admin|exists:opds,id',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->role_type = $request->input('role_type');

        if ($request->input('role_type') === 'OPD Admin') {
            $role->opd_id = $request->input('opd_id');
        } else {
            $role->opd_id = null; // Reset opd_id jika bukan OPD Admin
        }

        $role->save();
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('role.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('role.index')
            ->with('success', 'Role deleted successfully');
    }
}
