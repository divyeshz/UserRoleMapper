{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Users View')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View User</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select readonly disabled name="role[]" class="js-example-basic-multiple form-select" multiple="multiple"
                            data-width="100%">
                            @foreach ($role as $r)
                                <option {{ in_array($r->id, $pivotRoles) ? 'selected' : '' }} value="{{ $r->id }}">
                                    {{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" readonly disabled class="form-control" value="{{ $user->first_name }}" name="fname"
                            placeholder="Enter first name">
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" readonly disabled class="form-control" value="{{ $user->last_name }}" name="lname"
                                placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" readonly disabled name="email" value="{{ $user->email }}" class="form-control"
                            placeholder="Enter email">
                    </div>
                    <div class="form-check mb-3">
                        <input readonly disabled {{ $user->is_active == 1 ? 'checked' : '' }} type="checkbox" name="is_active"
                            class="form-check-input" value="1" id="is_active">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <a href="{{ route('user.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>

@endsection
