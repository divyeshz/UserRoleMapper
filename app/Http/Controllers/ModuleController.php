<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ModulePermissionTrait;
use App\Traits\AjaxResponse;
use App\Traits\ControllerTrait;

class ModuleController extends Controller
{
    use ModulePermissionTrait, AjaxResponse, ControllerTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $filterName = request()->input('filterName');
            if ($filterName == 'ml') {
                $data = Module::get();
                return DataTables::of($data)
                    ->addColumn('#', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->is_active == true ? 'checked' : '';
                        $switchBtn = $this->hasModulePermission('module', 'edit') != true ? 'd-none' : '';

                        $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active ' . $switchBtn . '">
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('action', function ($row) {
                        $viewRoute = route('module.show', $row->id);
                        $viewBtn = $this->hasModulePermission('module', 'view') != true ? 'd-none' : '';

                        $editRoute = route('module.editForm', $row->id);
                        $editBtn = $this->hasModulePermission('module', 'edit') != true ? 'd-none' : '';

                        $deleteRoute = route('module.destroy', $row->id);
                        $deleteBtn = $this->hasModulePermission('module', 'delete') != true ? 'd-none' : '';

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                        ' . csrf_field() . '
                        <a href="' . $editRoute . '" type="button" class="btn btn-primary btn-sm ' . $editBtn . '">Edit</a>
                        <a href="' . $viewRoute . '" type="button" class="btn btn-info btn-sm ' . $viewBtn . '">View</a>
                        <button type="button" class="btn btn-danger btn-sm delete ' . $deleteBtn . '">Delete</button>
                    </form>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            if ($filterName == 'sdml') {
                $data = Module::withTrashed()->where('is_deleted', true)->get();
                return DataTables::of($data)
                    ->addColumn('#', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->is_active == true ? 'checked' : '';
                        $switchBtn = $this->hasModulePermission('module', 'edit') != true ? 'd-none' : '';

                        $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" disabled data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active ' . $switchBtn . '">
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('action', function ($row) {
                        $restoreRoute = route('module.restore', $row->id);
                        $deleteRoute = route('module.delete', $row->id);
                        $deleteBtn = $this->hasModulePermission('module', 'delete') != true ? 'd-none' : '';

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form ' . $deleteBtn . '" method="POST">
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

        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('module.list', compact('modules', 'uniqueModules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentModule = Module::where([
            ['parent_id', null],
            ['is_active', true],
        ])->get();
        $module = null;
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('module.addEdit', compact('module', 'parentModule', 'modules', 'uniqueModules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // validate Data
        $request->validate([
            'name'          => 'required|string',
            'code'          => 'required|string',
            'display_order' => 'required|numeric',
            'parent_id'     => 'nullable',
        ]);

        // store the data
        $add = Module::create([
            'code'          => $request->code,
            'name'          => $request->name,
            'display_order' => $request->display_order,
            'parent_id'     => $request->parent_id,
            'is_active'     => $request->is_active ?? false,
            'is_in_menu'    => $request->is_in_menu ?? false,
        ]);

        if ($add) {
            return redirect()->route('module.list')->with('success', 'Module Created SuccessFully!!!');
        } else {
            return redirect()->route('module.addForm')->with('error', 'Module Created failed!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $allModule = Module::where([
            ['parent_id', null],
            ['is_active', true],
        ])->get();
        $module = Module::findOrFail($id);
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('module.show', compact('module', 'allModule', 'modules', 'uniqueModules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $parentModule = Module::where([
            ['id', '<>', $id],
            ['parent_id', null],
            ['is_active', true],
        ])->get();
        $module = Module::findOrFail($id);
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('module.addEdit', compact('module', 'parentModule', 'modules', 'uniqueModules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validate Data
        $request->validate([
            'name'          => 'required|string',
            'code'          => 'required|string',
            'display_order' => 'required|numeric',
            'parent_id'     => 'nullable',
        ]);

        $module = Module::findOrFail($id);

        $module->update([
            'name'          => $request->name,
            'code'          => $request->code,
            'display_order' => $request->display_order,
            'parent_id'     => $request->parent_id,
            'is_active'     => $request->is_active ?? false,
            'is_in_menu'    => $request->is_in_menu ?? false,
        ]);

        if ($module) {
            return redirect()->route('module.list')->with('success', 'Module Updated SuccessFully!!!');
        } else {
            return redirect()->route('module.addForm')->with('error', 'Module Updated failed!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Module::findOrFail($id);
        if ($delete) {
            $delete->delete();
            $module = Module::where('parent_id',$id)->delete();
            return redirect()->route('module.list')->with('success', 'Soft Deleted SuccessFully!!!');
        } else {
            return redirect()->route('module.list')->with('error', 'Soft Deleted failed!!!');
        }
    }

    /* Hard Delete */
    public function delete($id)
    {
        $delete = Module::withTrashed()->findOrFail($id);
        if ($delete) {
            $delete->forceDelete();
            return redirect()->route('module.list')->with('success', 'Deleted SuccessFully!!!');
        } else {
            return redirect()->route('module.list')->with('error', 'Deleted failed!!!');
        }
    }

    /* Restore Data from trash */
    public function restore($id)
    {
        $restoredModule = Module::withTrashed()->findOrFail($id);

        if ($restoredModule && $restoredModule->restore()) {
            return redirect()->route('module.list')->with('success', 'Restore SuccessFully!!!');
        } else {
            return redirect()->route('module.list')->with('error', 'Restore failed!!!');
        }
    }

    /* Chnage active status */
    public function status(Request $request)
    {
        $status = Module::where('id', $request->id)->update([
            'is_active'     => $request->is_active,
        ]);
        if ($status) {
            return $this->success(200,'Status Updated SuccessFully!!!');
        } else {
            return $this->error(400,'Status Updated Failed!!!');
        }
    }

}
