{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Role Edit')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form class="" action="{{ route('role.update', $role->id) }}" id="editRoleForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name <span class="star">*</span> </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter role name"
                                value="{{ $role->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="star">*</span> </label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description">{{ $role->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permission <span class="star">*</span> </label>
                            <select class="js-example-basic-multiple form-select" name="permission[]" multiple="multiple"
                                data-width="100%">
                                <option disabled>Select Permission</option>
                                @foreach ($permission as $p)
                                    <option {{ in_array($p->id, $pivotPermission) ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input {{ $role->is_active == 1 ? 'checked' : '' }} value="1" type="checkbox" name="is_active" class="form-check-input" id="is_active">
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

            $("#editRoleForm").validate({
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
