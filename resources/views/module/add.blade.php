{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Module Add')

{{-- Content Start --}}
@section('content')


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

                    <form class="" id="addModuleForm" method="POST" action="{{ route('module.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name <span class="star">*</span> </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Module name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code <span class="star">*</span> </label>
                            <input type="text" class="form-control" name="code" placeholder="Enter Module Code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Display Order <span class="star">*</span> </label>
                            <input type="number" class="form-control" name="display_order"
                                placeholder="Enter Display Order">
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="is_in_menu" class="form-check-input" id="is_in_menu"
                                    value="1">
                                <label class="form-check-label" for="is_in_menu">
                                    In Menu
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active">
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                        <a href="{{ route('module.list') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')
    <script>
        $(document).ready(function() {

            $("#addModuleForm").validate({
                rules: {
                    name: "required",
                    code: "required",
                    display_order: {
                        required: true,
                        number: true
                    },
                },
                messages: {
                    name: "Please specify Module name",
                    code: "Please specify Module Code",
                    display_order: {
                        required: "Please Enter Display Order",
                        number: "Please enter numbers Only"
                    }
                }
            });
        });
    </script>
@endsection
