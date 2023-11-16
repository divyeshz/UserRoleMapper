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
            $filterName = request()->input('filterName');
            if ($filterName == 'ul') {
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
                        $viewRoute = route('user.show', $row->id);
                        $editRoute = route('user.editForm', $row->id);
                        $deleteRoute = route('user.destroy', $row->id);

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
            if ($filterName == 'sdul') {
                $data = User::with('roles')->withTrashed()->where('is_deleted', 1)->get();
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
                        <input name="is_active" disabled data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active">
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('roles', function ($row) {
                        return $row->roles->pluck('name')->implode(', ');
                    })
                    ->addColumn('action', function ($row) {
                        $restoreRoute = route('user.restore', $row->id);
                        $deleteRoute = route('user.delete', $row->id);

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
        return view('user.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        return view('user.add', compact('role'));
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
            'role'          => 'required',
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

        if ($request->has('role')) {
            $roles = $request->role;
            $User->roles()->sync($roles);
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
        $user = User::with('roles')->findOrFail($id);
        $pivotRoles = $user->roles->pluck('id')->toArray();
        $role = Role::all();
        return view('user.show', compact('user', 'role', 'pivotRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $pivotRoles = $user->roles->pluck('id')->toArray();
        $role = Role::all();
        return view('user.edit', compact('user', 'role', 'pivotRoles'));
    }

    public function update(Request $request, string $id)
    {
        $save = false;
        $request->validate([
            'role'          => 'required',
            'fname'          => 'required|string',
        ]);

        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;
        $type = $request->type;
        $is_active = $request->is_active != "" ? $request->is_active : 0;

        $user = User::find($id);

        // Update user details if needed
        $user->update([
            'first_name'        => $fname,
            'last_name'         => $lname,
            'email'             => $email,
            'is_active'         => $is_active,
            'type'              => $type,
        ]);

        if ($request->has('role')) {
            $roles = $request->role;
            $user->roles()->sync($roles);
            $save = true;
        }

        if ($save) {
            return redirect()->route('user.list')->with('success', 'Updated SuccessFully!!!');
        } else {
            return redirect()->route('user.addForm')->with('success', 'Updated Failed!!!');
        }
    }

    public function destroy(string $id)
    {
        // delete
        $User = User::findOrFail($id);
        if ($User) {
            $User->delete();
            $User->roles()->update(['role_user.deleted_at' => now(), 'role_user.is_deleted' => 1]);
            return redirect()->route('user.list')->with('success', 'Soft Deleted SuccessFully!!!');
        } else {
            return redirect()->route('user.list')->with('error', 'Soft Deleted failed!!!');
        }
    }

    public function delete($id)
    {
        $delete = User::withTrashed()->findOrFail($id);
        if ($delete) {
            $delete->forceDelete();
            return redirect()->route('user.list')->with('success', 'Deleted SuccessFully!!!');
        } else {
            return redirect()->route('user.list')->with('error', 'Deleted failed!!!');
        }
    }

    public function restore($id)
    {
        $restoredUser = User::withTrashed()->findOrFail($id);

        if ($restoredUser ) {
            $restoredUser->restore();
            $userRoles = $restoredUser->roles()->withTrashed()->get();
            foreach ($userRoles as $role) {
                $restoredUser->roles()->attach($role->id);
            }
            return redirect()->route('module.list')->with('success', 'Restore SuccessFully!!!');
        } else {
            return redirect()->route('module.list')->with('error', 'Restore failed!!!');
        }
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $is_active = $request->is_active;

        $status = User::where('id', $id)->update([
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
