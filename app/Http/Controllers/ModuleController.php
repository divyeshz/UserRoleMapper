<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ModuleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $filterName = request()->input('filterName');
            if ($filterName == 'ml') {
                $data = Module::latest()->get();
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
                        $viewRoute = route('module.show', $row->id);
                        $editRoute = route('module.editForm', $row->id);
                        $deleteRoute = route('module.destroy', $row->id);

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
            if ($filterName == 'sdml') {
                $data = Module::withTrashed()->where('is_deleted', 1)->get();
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
                        $restoreRoute = route('module.restore', $row->id);
                        $deleteRoute = route('module.delete', $row->id);

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
        return view('module.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentModule = Module::where([
            ['parent_id', null],
            ['is_active', 1],
            ['is_deleted', 0],
            ['deleted_at', null],
        ])->get();
        $module = null;
        return view('module.addEdit', compact('module','parentModule'));
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
        ]);

        $code           = $request->code;
        $name           = $request->name;
        $display_order  = $request->display_order;
        $parent_id      = $request->parent_id;
        $is_active      = $request->is_active != "" ? $request->is_active : 0;
        $is_in_menu     = $request->is_in_menu != "" ? $request->is_in_menu : 0;

        // store the data
        $add = Module::create([
            'code'          => $code,
            'name'          => $name,
            'display_order' => $display_order,
            'parent_id'     => $parent_id,
            'is_active'     => $is_active,
            'is_in_menu'    => $is_in_menu,
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
            ['is_active', 1],
            ['is_deleted', 0],
            ['deleted_at', null],
        ])->get();
        $module = Module::findOrFail($id);
        return view('module.show', compact('module', 'allModule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $parentModule = Module::where([
            ['id','<>' ,$id],
            ['parent_id', null],
            ['is_active', 1],
            ['is_deleted', 0],
            ['deleted_at', null],
        ])->get();
        $module = Module::findOrFail($id);
        return view('module.addEdit', compact('module', 'parentModule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validate Data
        $request->validate([
            'name'          => 'required|string',
            'code'          => 'required',
            'display_order' => 'required|numeric',
        ]);

        $code           = $request->code;
        $name           = $request->name;
        $display_order  = $request->display_order;
        $parent_id      = $request->parent_id;
        $is_active      = $request->is_active != "" ? $request->is_active : 0;
        $is_in_menu     = $request->is_in_menu != "" ? $request->is_in_menu : 0;

        $module = Module::findOrFail($id);

        $module->update([
            'name'          => $name,
            'code'          => $code,
            'display_order' => $display_order,
            'parent_id'     => $parent_id,
            'is_active'     => $is_active,
            'is_in_menu'    => $is_in_menu,
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
        // delete
        $delete = Module::findOrFail($id);
        if ($delete) {
            $delete->delete();
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
        $id = $request->id;
        $is_active = $request->is_active;

        $status = Module::where('id', $id)->update([
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
