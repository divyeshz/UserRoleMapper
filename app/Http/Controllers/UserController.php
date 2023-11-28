<?php

namespace App\Http\Controllers;

use App\Mail\AddUserMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\DispatchEmails;
use App\Traits\AjaxResponse;
use App\Traits\ControllerTrait;

class UserController extends Controller
{
    use DispatchEmails, AjaxResponse, ControllerTrait;
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
                        $checked = $row->is_active == true ? 'checked' : '';
                        $switchBtn = $this->hasModulePermission('user', 'edit') != true ? 'disabled readonly' : '';

                        $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active" ' . $switchBtn . '>
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('roles', function ($row) {
                        return $row->roles->pluck('name')->implode(', ');
                    })
                    ->addColumn('action', function ($row) {
                        $viewRoute = route('user.show', $row->id);
                        $viewBtn = $this->hasModulePermission('user', 'view') != true ? 'd-none' : '';

                        $editRoute = route('user.editForm', $row->id);
                        $editBtn = $this->hasModulePermission('user', 'edit') != true ? 'd-none' : '';

                        $deleteRoute = route('user.destroy', $row->id);
                        $deleteBtn = $this->hasModulePermission('user', 'delete') != true ? 'd-none' : '';

                        $logoutRoute = route('user.forceLogout', $row->id);
                        $displayLogout = Auth::user()->type !== "admin" ? "d-none" : "";
                        $display = $row->type == "admin" ? "d-none" : "";

                        if ($row->type != 'admin' || (Auth::user()->type == "admin")) {
                            $actionBtn = '<form action="' . $deleteRoute . '" class="delete-form" method="POST">
                            ' . csrf_field() . '
                            <a href="' . $editRoute . '" type="button" class="btn btn-primary btn-sm ' . $editBtn . '">Edit</a>
                            <a href="' . $viewRoute . '" type="button" class="btn btn-info btn-sm ' . $viewBtn . '">View</a>
                            <button type="button" data-id="' . $row->id . '" data-link="' . $logoutRoute . '" class="btn btn-secondary logout btn-sm ' . $displayLogout . ' ' . $display . ' ">Log Out</button>
                            <button type="button" class="btn btn-danger btn-sm delete ' . $display . ' ' . $deleteBtn . '">Delete</button>
                        </form>';
                            return $actionBtn;
                        }

                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            if ($filterName == 'sdul') {
                $data = User::with('roles')->withTrashed()->where('is_deleted', true)->get();
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
                        $checked = $row->is_active == true ? 'checked' : '';
                        $switchBtn = $this->hasModulePermission('user', 'edit') != true ? 'disabled readonly' : '';

                        $activeBtn = '<div class="form-check form-switch">
                        <input name="is_active" disabled data-id="' . $row->id . '" type="checkbox" ' . $checked . ' class="form-check-input switch_is_active" ' . $switchBtn . '>
                    </div>';
                        return $activeBtn;
                    })
                    ->addColumn('roles', function ($row) {
                        return $row->roles->pluck('name')->implode(', ');
                    })
                    ->addColumn('action', function ($row) {
                        $restoreRoute = route('user.restore', $row->id);
                        $deleteRoute = route('user.delete', $row->id);
                        $deleteBtn = $this->hasModulePermission('user', 'delete') != true ? 'd-none' : '';

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
        return view('user.list', compact('modules','uniqueModules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::where('is_active', true)->get();
        $user = null;
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('user.addEdit', compact('role', 'user', 'modules', 'uniqueModules'));
    }

    /* Display Profile page */
    public function profile()
    {
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('user.profile', compact('modules', 'uniqueModules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role'      => 'required',
            'fname'     => 'required|string',
            'email'     => 'unique:users|required|email',
            'is_active'     => 'boolean',
        ]);

        $min = 100000;
        $max = 999999;
        $randomPass = random_int($min, $max);

        // store the data
        $User = User::create([
            'first_name'        => $request->fname,
            'last_name'         => $request->lname,
            'email'             => $request->email,
            'password'          => Hash::make($randomPass),
            'is_first_login'    => 1,
            'is_active'         => $request->is_active ?? false,
            'type'              => 'user',
        ]);

        $data = [
            'fname'         => $request->fname,
            'lname'         => $request->lname,
            'password'      => $randomPass,
        ];

        if ($request->has('role')) {
            $roles = $request->role;

            // Loop through the updated set of roles
            foreach ($roles as $roleId) {
                $pivotData = [
                    'created_by' => Auth::id(),
                ];
                // Attach new role with pivot data
                $User->roles()->attach($roleId, $pivotData);
            }
        }

        // Call the sendEmail method from the trait
        $userEmail = $User->email; // $User holds the user data
        $mailData = new AddUserMail($data); // $data holds the necessary data
        $this->sendEmail($userEmail, $mailData);

        return redirect()->route('user.list')->with('success', 'User Created SuccessFully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $pivotRoles = $user->roles->pluck('id')->toArray();
        $role = Role::all();
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('user.show', compact('user', 'role', 'pivotRoles', 'modules', 'uniqueModules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $pivotRoles = $user->roles->pluck('id')->toArray();
        $role = Role::where('is_active', true)->get();
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('user.addEdit', compact('user', 'role', 'pivotRoles', 'modules', 'uniqueModules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role'           => 'required',
            'fname'          => 'required|string',
            'email'          => 'required|email',
            'is_active'     => 'boolean',
        ]);

        $user = User::findOrFail($id);

        // Update user details
        $user->update([
            'first_name'        => $request->fname,
            'last_name'         => $request->lname,
            'email'             => $request->email,
            'is_active'         => $request->is_active ?? false,
            'type'              => $request->type,
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
        }

        return redirect()->route('user.list')->with('success', 'Updated SuccessFully!!!');
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
            $restoredUser->roles()->update(['role_user.deleted_at' => null, 'role_user.is_deleted' => 0, 'role_user.deleted_by' => null]);
            return redirect()->route('user.list')->with('success', 'Restore SuccessFully!!!');
        } else {
            return redirect()->route('user.list')->with('error', 'Restore failed!!!');
        }
    }

    /* Chnage active status */
    public function status(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'is_active' => 'numeric'
        ]);

        $status = User::where('id', $request->id)->update([
            'is_active'     => $request->is_active,
        ]);
        if ($status) {
            return $this->success(200,'Status Updated SuccessFully!!!');
        } else {
            return $this->error(400,'Status Updated Failed!!!');
        }
    }

    /* admin can force logout any other user */
    public function forceLogout(Request $request)
    {
        $userId = $request->id;
        $user = User::find($userId);
        if ($user) {

            if ($user->tokens->isNotEmpty()) {
                foreach ($user->tokens as $token) {
                    $token->delete();
                }
                return $this->success(200,'User logged out!!!');
            } else {
                return $this->error(400,'User currently not logged in!!!');
            }
        } else {
            // User not found
            return $this->error(400,'User not found!!!');
        }
    }
}
