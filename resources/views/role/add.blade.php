{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Role Add')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Role</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form class="" action="{{ route('role.store') }}" id="addRoleForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name <span class="star">*</span> </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter role name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="star">*</span> </label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permission <span class="star">*</span> </label>
                            <select class="js-example-basic-multiple form-select" name="permission[]" multiple="multiple"
                                data-width="100%">
                                <option disabled>Select Permission</option>
                                @foreach ($permission as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                        <a href="{{ route('role.list') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')

    <script>
        $(document).ready(function() {

            $("#addRoleForm").validate({
                rules: {
                    name: "required",
                    description: "required",
                    permission: "required"
                },
                messages: {
                    name: "Please specify role name",
                    description: "Please specify role description",
                    permission: "Please Select permission"
                }
            });
        });
    </script>

@endsection
