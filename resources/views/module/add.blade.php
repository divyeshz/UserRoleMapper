{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Module Add')

{{-- Content Start --}}
@section('content')

    <div class="page-content">
        <nav class="page-breadcrumb mb-2 mb-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Module</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <form class="" id="addRoleForm" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Module Name <span class="star">*</span> </label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Module name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description <span class="star">*</span> </label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Add Permission <span class="star">*</span> </label>
                                <input class="form-control" name="permission" id="tags" />
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <a href="{{ route('module.list') }}" class="btn btn-secondary">Cancel</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('jsContent')

@endsection
