{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Permission Add')

{{-- Content Start --}}
@section('content')

    <div class="page-content">
        <nav class="page-breadcrumb mb-2 mb-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <form class="" id="addPermissionForm" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Permission Name <span class="star">*</span> </label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Enter Permission name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description <span class="star">*</span> </label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description"></textarea>
                            </div>


                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <a href="{{ route('permission.list') }}" class="btn btn-secondary">Cancel</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('jsContent')

    <script>
        $(document).ready(function() {

            $("#addPermissionForm").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Please specify role name",
                    description: "Please specify role description"
                }
            });
        });
    </script>

@endsection
