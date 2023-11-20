<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $filterName = request()->input('filterName');
            if ($filterName == 'pl') {
                $data = Permission::get();
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
                        $viewRoute = route('permission.show', $row->id);
                        $editRoute = route('permission.editForm', $row->id);
                        $deleteRoute = route('permission.destroy', $row->id);

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
            if ($filterName == 'sdpl') {
                $data = Permission::withTrashed()->where('is_deleted', 1)->get();
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
                        $restoreRoute = route('permission.restore', $row->id);
                        $deleteRoute = route('permission.delete', $row->id);

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
        return view('permission.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::whereNotNull('parent_id')
            ->with('parentModule')
            ->where([
                ['is_active', 1],
                ['is_deleted', 0],
                ['deleted_at', null],
            ])
            ->get();

        $uniqueModules = $modules
            ->groupBy('parent_id') // Group modules by parent_id
            ->map(function ($groupedModules) {
                return $groupedModules->first()->parentModule; // Get the first parentModule from each group
            })
            ->values();

        $Permission = null;
        return view('permission.addEdit', compact('modules', 'uniqueModules','Permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? 0,
        ]);

        $actionMapping = [
            'add' => 'add_access',
            'view' => 'view_access',
            'edit' => 'edit_access',
            'delete' => 'delete_access',
        ];

        $modules = Module::whereNotNull('parent_id')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        foreach ($modules as $module) {
            $moduleName = $module->name;

            if ($request->has($moduleName) && is_array($request->$moduleName)) {
                $pivotData = [];

                foreach ($request->$moduleName as $action) {
                    if (isset($actionMapping[$action])) {
                        $pivotData[$actionMapping[$action]] = 1;
                    }
                }

                $pivotData['created_by'] = Auth::id();
                $module->permissions()->attach($permission, $pivotData);
            }
        }
        return redirect()->route('permission.list')->with('success', 'Created SuccessFully!!!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Permission = Permission::with('modules')->findOrFail($id);
        $pivotPermission = $Permission->modules->pluck('pivot')->toArray();;

        $modules = Module::whereNotNull('parent_id')
            ->with('parentModule')
            ->where([
                ['is_active', 1],
                ['is_deleted', 0],
                ['deleted_at', null],
            ])
            ->get();

        $uniqueModules = $modules
            ->groupBy('parent_id') // Group modules by parent_id
            ->map(function ($groupedModules) {
                return $groupedModules->first()->parentModule; // Get the first parentModule from each group
            })
            ->values();

        return view('permission.addEdit', compact('Permission', 'modules', 'uniqueModules', 'pivotPermission'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Permission = Permission::with('modules')->findOrFail($id);
        $pivotPermission = $Permission->modules->pluck('pivot')->toArray();;

        $modules = Module::whereNotNull('parent_id')
            ->with('parentModule')
            ->where([
                ['is_active', 1],
                ['is_deleted', 0],
                ['deleted_at', null],
            ])
            ->get();

        $uniqueModules = $modules
            ->groupBy('parent_id') // Group modules by parent_id
            ->map(function ($groupedModules) {
                return $groupedModules->first()->parentModule; // Get the first parentModule from each group
            })
            ->values();

        return view('permission.show', compact('Permission', 'modules', 'uniqueModules', 'pivotPermission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? 0,
        ]);

        $actionMapping = [
            'add' => 'add_access',
            'view' => 'view_access',
            'edit' => 'edit_access',
            'delete' => 'delete_access',
        ];

        $modules = Module::whereNotNull('parent_id')
            ->with('parentModule')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $syncData = [];

        foreach ($modules as $module) {
            $moduleName = $module->name;

            if ($request->has($moduleName) && is_array($request->$moduleName)) {
                $pivotData = [];

                foreach ($request->$moduleName as $action) {
                    if (isset($actionMapping[$action])) {
                        $pivotData[$actionMapping[$action]] = 1;
                    }
                }

                if (!empty($pivotData)) {
                    $syncData[$module->id] = $pivotData;
                }
            }
        }

        // Detach access rights that were removed
        foreach ($permission->modules as $module) {
            $pivotData = [];
            $existingPivotData = $module->pivot;

            foreach ($actionMapping as $key => $value) {
                if (!in_array($key, array_keys($syncData[$module->id] ?? [])) && $existingPivotData->$value === 1) {
                    $pivotData[$value] = 0;
                }
            }

            if (!empty($pivotData)) {
                $permission->modules()->updateExistingPivot($module->id, $pivotData);
            }
        }

        $permission->modules()->sync($syncData);
        return redirect()->route('permission.list')->with('success', 'Updated SuccessFully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        if ($permission) {
            $permission->delete();
            $permission->modules()->update(['permission_module.deleted_at' => now(), 'permission_module.is_deleted' => 1, 'permission_module.deleted_by' => Auth::id()]);
            return redirect()->route('permission.list')->with('success', 'Soft Deleted SuccessFully!!!');
        } else {
            return redirect()->route('permission.list')->with('error', 'Soft Deleted Failed!!!');
        }
    }

    /* Hard Delete */
    public function delete($id)
    {
        $delete = Permission::withTrashed()->findOrFail($id);
        if ($delete) {
            $delete->forceDelete();
            return redirect()->route('permission.list')->with('success', 'Deleted SuccessFully!!!');
        } else {
            return redirect()->route('permission.list')->with('error', 'Deleted failed!!!');
        }
    }

    /* Restore Data from trash */
    public function restore($id)
    {
        $restoredPermission = Permission::withTrashed()->findOrFail($id);

        if ($restoredPermission) {
            $restoredPermission->modules()->update(['permission_module.deleted_at' => null, 'permission_module.is_deleted' => 0]);
            $restoredPermission->restore();
            return redirect()->route('permission.list')->with('success', 'Restore SuccessFully!!!');
        } else {
            return redirect()->route('permission.list')->with('error', 'Restore failed!!!');
        }
    }

    /* Chnage active status */
    public function status(Request $request)
    {

        $id = $request->id;
        $is_active = $request->is_active;

        $status = Permission::where('id', $id)->update([
            'is_active'     => $is_active,
        ]);
        if ($status) {
            $response = [
                'status'    => '200',
                'message'   => 'Status Updated SuccessFully!!!'
            ];
        } else {
            $response = [
                'status'    => '400',
                'message'   => 'Status Updated Failed!!!'
            ];
        }
        return json_encode($response);
    }
}
