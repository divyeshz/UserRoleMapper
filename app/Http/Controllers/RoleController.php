<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $filterName = request()->input('filterName');
            if ($filterName == 'rl') {
                $data = Role::get();
                return DataTables::of($data)
                    ->addColumn('#', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->is_active == 1 ? 'checked' : '';
                        $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active">
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('action', function ($row) {
                        $viewRoute = route('role.show', $row->id);
                        $editRoute = route('role.editForm', $row->id);
                        $deleteRoute = route('role.destroy', $row->id);

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                        ' . csrf_field() . '
                        <a href="' . $editRoute . '" type="button" class="btn btn-primary btn-sm">Edit</a>
                        <a href="' . $viewRoute . '" type="button" class="btn btn-info btn-sm">View</a>
                        <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                    </form>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            if ($filterName == 'sdrl') {
                $data = Role::withTrashed()->where('is_deleted', 1)->get();
                return DataTables::of($data)
                    ->addColumn('#', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->is_active == 1 ? 'checked' : '';
                        $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" disabled data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active">
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('action', function ($row) {
                        $restoreRoute = route('role.restore', $row->id);
                        $deleteRoute = route('role.delete', $row->id);

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                            ' . csrf_field() . '
                            <a href="' . $restoreRoute . '" type="button" class="btn btn-primary btn-sm">Restore</a>
                            <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                        </form>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
        }
        return view('role.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::where([
            ['is_active', 1],
            ['is_deleted', 0],
            ['deleted_at', null],
        ])->get();
        return view('role.add', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $save = false;
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required',
            'permission'    => 'required',
        ]);

        $name = $request->name;
        $description = $request->description;
        $is_active = $request->is_active != "" ? $request->is_active : 0;

        // store the data
        $Role = Role::create([
            'name'          => $name,
            'description'   => $description,
            'is_active'     => $is_active,
        ]);

        if ($request->has('permission')) {
            $permissions = $request->permission;
            foreach ($permissions as $p) {
                $pivotData = [
                    'created_by' => Auth::id(),
                ];
                $Role->permissions()->sync([$p => $pivotData]);
            }
            $save = true;
        }

        if ($save) {
            return redirect()->route('role.list')->with('success', 'Created SuccessFully!!!');
        } else {
            return redirect()->route('role.addForm')->with('success', 'Created Failed!!!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $pivotPermission = $role->permissions->pluck('id')->toArray();
        $permission = Permission::where([
            ['is_active', 1],
            ['is_deleted', 0],
            ['deleted_at', null],
        ])->get();
        return view('role.edit', compact('permission', 'pivotPermission', 'role'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $pivotPermission = $role->permissions->pluck('id')->toArray();
        $permission = Permission::where([
            ['is_active', 1],
            ['is_deleted', 0],
            ['deleted_at', null],
        ])->get();
        return view('role.show', compact('permission', 'pivotPermission', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $save = false;
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required',
            'permission'    => 'required',
        ]);

        $name = $request->name;
        $description = $request->description;
        $is_active = $request->is_active != "" ? $request->is_active : 0;

        $role = Role::findOrFail($id);

        // Update user details if needed
        $role->update([
            'name'          => $name,
            'description'   => $description,
            'is_active'     => $is_active,
        ]);

        if ($request->has('permission')) {
            $permissions = $request->permission;
            $currentPermissions = $role->permissions()->pluck('id')->toArray();

            // Detach roles that are not in the updated set
            $permissionToDetach = array_diff($currentPermissions, $permissions);
            $role->permissions()->detach($permissionToDetach);

            // Loop through the updated set of roles
            foreach ($permissions as $p) {

                if (in_array($p, $currentPermissions)) {
                    $pivotData = [
                        'updated_by' => auth()->id(),
                    ];
                    // Update existing pivot data
                    $role->permissions()->updateExistingPivot($p, $pivotData);
                } else {
                    $pivotData = [
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ];
                    // Attach new role with pivot data
                    $role->permissions()->attach($p, $pivotData);
                }
            }
            $save = true;
        }


        if ($save) {
            return redirect()->route('role.list')->with('success', 'Updated SuccessFully!!!');
        } else {
            return redirect()->route('role.addForm')->with('success', 'Updated Failed!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role) {
            $role->delete();
            $role->permissions()->update(['permission_role.deleted_at' => now(), 'permission_role.is_deleted' => 1]);
            return redirect()->route('role.list')->with('success', 'Soft Deleted SuccessFully!!!');
        } else {
            return redirect()->route('role.list')->with('error', 'Soft Deleted failed!!!');
        }
    }

    /* Hard Delete */
    public function delete($id)
    {
        $delete = Role::withTrashed()->findOrFail($id);
        if ($delete) {
            $delete->forceDelete();
            return redirect()->route('role.list')->with('success', 'Deleted SuccessFully!!!');
        } else {
            return redirect()->route('role.list')->with('error', 'Deleted failed!!!');
        }
    }

    /* Restore Data from trash */
    public function restore($id)
    {
        $restoredRole = Role::withTrashed()->findOrFail($id);

        if ($restoredRole) {
            $restoredRole->permissions()->update(['permission_role.deleted_at' => null, 'permission_role.is_deleted' => 0]);
            $restoredRole->restore();
            return redirect()->route('role.list')->with('success', 'Restore SuccessFully!!!');
        } else {
            return redirect()->route('role.list')->with('error', 'Restore failed!!!');
        }
    }

    /* Chnage active status */
    public function status(Request $request)
    {
    }
}
