{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Users Add')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add User</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form class="" id="addUserForm" method="post" action="{{ route('user.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role[]" class="js-example-basic-multiple form-select" multiple="multiple"
                                data-width="100%">
                                @foreach ($role as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="fname" placeholder="Enter first name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lname" placeholder="Enter last name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active">
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                        <a href="{{ route('user.list') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')

    <script>
        $(document).ready(function() {

            $.validator.addMethod("endsWithCom", function(value, element) {
                return value.endsWith(".com");
            }, "Please enter a valid email address ending with .com.");

            // Validate Change Password Form
            $("#addUserForm").validate({
                rules: {
                    role: "required",
                    fname: "required",
                },
                messages: {
                    role: "Please provide a Role",
                    fname: "Please specify your First name",
                }
            });
        });
    </script>

@endsection
