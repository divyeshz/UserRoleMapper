<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ModulePermissionTrait;
use App\Traits\AjaxResponse;
use App\Traits\ControllerTrait;

class DemoController extends Controller
{

    use ModulePermissionTrait, AjaxResponse, ControllerTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $filterName = request()->input('filterName');
            if ($filterName == 'dl') {
                $data = Demo::get();
                return DataTables::of($data)
                    ->addColumn('#', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('action', function ($row) {
                        $viewRoute = route('demo.show', $row->id);
                        $viewBtn = $this->hasModulePermission('demo', 'view') != true ? 'd-none' : '';

                        $editRoute = route('demo.editForm', $row->id);
                        $editBtn = $this->hasModulePermission('demo', 'edit') != true ? 'd-none' : '';

                        $deleteRoute = route('demo.destroy', $row->id);
                        $deleteBtn = $this->hasModulePermission('demo', 'delete') != true ? 'd-none' : '';

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                        ' . csrf_field() . '
                        <a href="' . $editRoute . '" type="button" class="btn btn-primary btn-sm ' . $editBtn . '">Edit</a>
                        <a href="' . $viewRoute . '" type="button" class="btn btn-info btn-sm ' . $viewBtn . '">View</a>
                        <button type="button" class="btn btn-danger btn-sm delete ' . $deleteBtn . '">Delete</button>
                    </form>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            if ($filterName == 'sddl') {
                $data = Demo::withTrashed()->where('is_deleted', true)->get();
                return DataTables::of($data)
                    ->addColumn('#', function () {
                        static $counter = 0;
                        $counter++;
                        return $counter;
                    })
                    ->addColumn('action', function ($row) {
                        $restoreRoute = route('demo.restore', $row->id);
                        $deleteRoute = route('demo.delete', $row->id);
                        $deleteBtn = $this->hasModulePermission('demo', 'delete') != true ? 'd-none' : '';

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form ' . $deleteBtn . '" method="POST">
                            ' . csrf_field() . '
                            <a href="' . $restoreRoute . '" type="button" class="btn btn-primary btn-sm">Restore</a>
                            <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                        </form>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('demo.list', compact('modules', 'uniqueModules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = "Add";
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('demo.addEditView', compact('modules', 'action', 'uniqueModules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Data
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        Demo::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('demo.list')->with('success', 'Created SuccessFully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Demo = Demo::findOrFail($id);
        $action = "View";
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('demo.addEditView', compact('Demo', 'action', 'modules', 'uniqueModules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $action = "Edit";
        $Demo = Demo::findOrFail($id);
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('demo.addEditView', compact('Demo', 'action', 'modules', 'uniqueModules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate data
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $demo = Demo::findOrFail($id);

        $demo->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('demo.list')->with('success', 'Updated SuccessFully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $demo = Demo::findOrFail($id);
        if ($demo) {
            $demo->delete();
            return redirect()->route('demo.list')->with('success', 'Soft Deleted SuccessFully!!!');
        } else {
            return redirect()->route('demo.list')->with('error', 'Soft Deleted Failed!!!');
        }
    }

    /* Hard Delete */
    public function delete($id)
    {
        $delete = Demo::withTrashed()->findOrFail($id);
        if ($delete) {
            $delete->forceDelete();
            return redirect()->route('demo.list')->with('success', 'Deleted SuccessFully!!!');
        } else {
            return redirect()->route('demo.list')->with('error', 'Deleted failed!!!');
        }
    }

    /* Restore Data from trash */
    public function restore($id)
    {
        $restoredDemo = Demo::withTrashed()->findOrFail($id);

        if ($restoredDemo) {
            $restoredDemo->restore();
            return redirect()->route('demo.list')->with('success', 'Restore SuccessFully!!!');
        } else {
            return redirect()->route('demo.list')->with('error', 'Restore failed!!!');
        }
    }
}
