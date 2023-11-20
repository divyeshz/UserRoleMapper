<?php

namespace App\Http\Controllers;

use App\Mail\AddUserMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Laravel\Sanctum\PersonalAccessToken;

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
                        $logoutRoute = route('user.forceLogout', $row->id);
                        $displayLogout = Auth::user()->type !== "admin" ? "d-none" : "";

                        $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                        ' . csrf_field() . '
                        <a href="' . $editRoute . '" type="button" class="btn btn-primary btn-sm">Edit</a>
                        <a href="' . $viewRoute . '" type="button" class="btn btn-info btn-sm">View</a>
                        <button type="button" data-id="' . $row->id . '" data-link="' . $logoutRoute . '" class="btn btn-secondary logout btn-sm ' . $displayLogout . ' ">Log Out</button>
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

    /* Display Profile page */
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
            'email'          => 'required|email',
        ]);

        $min = 100000;
        $max = 999999;
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

        $data = [
            'fname'         => $fname,
            'lname'         => $lname,
            'password'      => $randomPass,
        ];

        if ($request->has('role')) {
            $roles = $request->role;
            foreach ($roles as $roleId) {
                $pivotData = [
                    'created_by' => Auth::id(),
                ];
                $User->roles()->sync([$roleId => $pivotData]);
            }
            $save = true;
        }

        if ($save) {
            dispatch(function () use ($User, $data) {
                Mail::to($User->email)->send(new AddUserMail($data));
            });
        }

        if ($save) {
            return redirect()->route('user.list')->with('success', 'User Created SuccessFully!!!');
        } else {
            return redirect()->route('user.addForm')->with('success', 'User Created failed!!!');
        }
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $save = false;
        $request->validate([
            'role'          => 'required',
            'fname'          => 'required|string',
            'email'          => 'required|email',
        ]);

        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;
        $type = $request->type;
        $is_active = $request->is_active != "" ? $request->is_active : 0;

        $user = User::findOrFail($id);

        // Update user details
        $user->update([
            'first_name'        => $fname,
            'last_name'         => $lname,
            'email'             => $email,
            'is_active'         => $is_active,
            'type'              => $type,
        ]);

        if ($request->has('role')) {
            $roles = $request->role;
            $currentRoles = $user->roles()->pluck('id')->toArray();

            // Detach roles that are not in the updated set
            $rolesToDetach = array_diff($currentRoles, $roles);
            $user->roles()->detach($rolesToDetach);

            // Loop through the updated set of roles
            foreach ($roles as $roleId) {

                if (in_array($roleId, $currentRoles)) {
                    $pivotData = [
                        'updated_by' => auth()->id(),
                    ];
                    // Update existing pivot data
                    $user->roles()->updateExistingPivot($roleId, $pivotData);
                } else {
                    $pivotData = [
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ];
                    // Attach new role with pivot data
                    $user->roles()->attach($roleId, $pivotData);
                }
            }
            $save = true;
        }

        if ($save) {
            return redirect()->route('user.list')->with('success', 'Updated SuccessFully!!!');
        } else {
            return redirect()->route('user.addForm')->with('success', 'Updated Failed!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete
        $User = User::findOrFail($id);
        if ($User) {
            $User->delete();
            $User->roles()->update(['role_user.deleted_by' => Auth::id(), 'role_user.deleted_at' => now(), 'role_user.is_deleted' => 1]);
            return redirect()->route('user.list')->with('success', 'Soft Deleted SuccessFully!!!');
        } else {
            return redirect()->route('user.list')->with('error', 'Soft Deleted failed!!!');
        }
    }

    /* Hard Delete */
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

    /* Restore Data from trash */
    public function restore($id)
    {
        $restoredUser = User::withTrashed()->findOrFail($id);

        if ($restoredUser) {
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

    /* Chnage active status */
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

    public function forceLogout(Request $request)
    {
        $userId = $request->id;
        $user = User::find($userId);
        if ($user) {

            if ($user->tokens->isNotEmpty()) {
                foreach ($user->tokens as $token) {
                    $token->delete();
                }
                $response = [
                    'status' => '200',
                    'message' => 'User logged out!!!'
                ];
            } else {
                // User currently not logged in no tokens available
                $response = [
                    'status' => '400',
                    'message' => 'User currently not logged in!!!'
                ];
            }
        } else {
            // User not found
            $response = [
                'status' => '400',
                'message' => 'User not found!!!'
            ];
        }
        return json_encode($response);
    }
}
