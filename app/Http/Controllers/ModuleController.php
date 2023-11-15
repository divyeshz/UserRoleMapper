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
                    $editRoute = route('module.editForm', $row->id);
                    $deleteRoute = route('module.destroy', $row->id);

                    $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                        ' . csrf_field() . '
                        <a href="' . $editRoute . '" type="button" class="btn btn-primary btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                    </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('module.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('module.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'          => 'required|string',
            'code'          => 'required',
            'display_order' => 'required|numeric',
        ]);

        $code = $request->code;
        $name = $request->name;
        $display_order = $request->display_order;
        $is_active = $request->is_active != "" ? $request->is_active : 0;
        $is_in_menu = $request->is_in_menu != "" ? $request->is_in_menu : 0;

        // store the data
        $add = Module::create([
            'code'          => $code,
            'name'          => $name,
            'display_order' => $display_order,
            'is_active'     => $is_active,
            'is_in_menu'    => $is_in_menu,
        ]);

        if ($add) {
            return redirect()->route('module.list')->with('success', 'Module Created SuccessFully!!!');
        } else {
            return redirect()->route('module.addForm')->with('success', 'Module Created failed!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return view('module.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'code'          => 'required',
            'display_order' => 'required|numeric',
        ]);

        $code = $request->code;
        $name = $request->name;
        $display_order = $request->display_order;
        $is_active = $request->is_active != "" ? $request->is_active : 0;
        $is_in_menu = $request->is_in_menu != "" ? $request->is_in_menu : 0;

        $edit = Module::where('id', $id)->update([
            'name'          => $name,
            'code'          => $code,
            'display_order' => $display_order,
            'is_active'     => $is_active,
            'is_in_menu'    => $is_in_menu,
        ]);

        if ($edit) {
            return redirect()->route('module.list')->with('success', 'Module Updated SuccessFully!!!');
        } else {
            return redirect()->route('module.addForm')->with('success', 'Module Updated failed!!!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // delete
        $delete = Module::findOrFail($id)->delete();
        if ($delete) {
            return redirect()->route('module.list')->with('success', 'Module Deleted SuccessFully!!!');
        } else {
            return redirect()->route('module.addForm')->with('success', 'Module Deleted failed!!!');
        }
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $is_active = $request->is_active;

        $status = Module::where('id', $id)->update([
            'is_active'     => $is_active,
        ]);
    }
}
