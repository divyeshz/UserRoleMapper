{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Change Password')

{{-- Content Start --}}
@section('content')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <form class="forms-sample" action="{{ route('changePassword') }}" id="changePasswordForm" method="post">
                            {{-- Csrf --}}
                            @csrf

                            {{-- Current Password --}}
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Current Password</label>
                                <input type="password" name="old_password" class="form-control" id="old_password"
                                placeholder="Current Password">
                            </div>

                            {{-- New Password --}}
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control " id="new_password"
                                    placeholder="New Password">
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_new_password" class="form-control"
                                    id="confirm_new_password " placeholder="Confirm New Password">
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
{{-- Content end --}}

{{-- Js Content Start --}}
@section('jsContent')

    <script>
        $(document).ready(function() {

            // Validate Change Password Form
            $("#changePasswordForm").validate({
                rules: {
                    old_password: {
                        required: true,
                        minlength: 6
                    },
                    new_password: {
                        required: true,
                        minlength: 6,
                    },
                    confirm_new_password: {
                        required: true,
                        minlength: 6,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    old_password: {
                        required: "Please provide a current password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    new_password: {
                        required: "Please provide a new password",
                        minlength: "Your password must be at least 6 characters long",
                    },
                    confirm_new_password: {
                        required: "Please provide a confirm new password",
                        minlength: "Your password must be at least 6 characters long",
                        equalTo: "Please enter the same password as above"
                    }
                }
            });
        });
    </script>

@endsection
{{-- Js Content End --}}
