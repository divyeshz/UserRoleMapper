<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = User::with('roles')->get();
            return DataTables::of($data)
                ->addColumn('#', function () {
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })
                ->addColumn('name', function ($row) {
                    $name = $row->first_name . ' ' . $row->last_name;
                    return $name;
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active == 1 ? 'checked' : '';
                    $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active">
                    </div>';
                    return $activeBtn;
                })
                ->addColumn('roles', function ($row) {
                    return $row->roles->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $editRoute = route('user.editForm', $row->id);
                    $deleteRoute = route('user.destroy', $row->id);

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
        return view('user.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.add');
    }

    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $save = false;
        $request->validate([
            'roles'          => 'required',
            'fname'          => 'required|string',
        ]);

        $min = 1000;
        $max = 9999;
        $randomPass = random_int($min, $max);

        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;
        $is_active = $request->is_active != "" ? $request->is_active : 0;

        // store the data
        $User = User::create([
            'first_name'        => $fname,
            'last_name'         => $lname,
            'email'             => $email,
            'password'          => Hash::make($randomPass),
            'is_first_login'    => 1,
            'is_active'         => $is_active,
            'type'              => 'user',
        ]);

        // Extract role names from the input
        $roleNames = explode(',', $request->roles);

        // Find roles by name and associate them with the user
        foreach ($roleNames as $roleName) {
            // Assuming 'name' is the column containing role names in the Role model
            $role = Role::where('name', trim($roleName))->first();

            if ($role) {
                $User->roles()->attach($role->id);
            }
            $save = true;
        }

        if ($save) {
            return redirect()->route('user.list')->with('success', 'User Created SuccessFully!!!');
        } else {
            return redirect()->route('user.addForm')->with('success', 'User Created failed!!!');
        }
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
