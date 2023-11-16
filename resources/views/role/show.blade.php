{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Role View')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Role</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="star">*</span> </label>
                        <input type="text" disabled readonly value="{{ $role->name }}" class="form-control" name="name" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description <span class="star">*</span> </label>
                        <textarea disabled readonly class="form-control" name="description" id="description" rows="5">{{ $role->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permission <span class="star">*</span> </label>
                        <select disabled readonly class="js-example-basic-multiple form-select" name="permission[]" multiple="multiple"
                            data-width="100%">
                            @foreach ($permission as $p)
                                <option {{ in_array($p->id, $pivotPermission) ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input disabled readonly {{ $role->is_active == 1 ? 'checked' : '' }} type="checkbox" name="is_active" class="form-check-input" id="is_active">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <a href="{{ route('role.list') }}" class="btn btn-secondary">Cancel</a>

                </div>
            </div>
        </div>
    </div>

@endsection
