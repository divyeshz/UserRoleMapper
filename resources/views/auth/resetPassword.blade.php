{{-- Extends authLayout --}}
@extends('layouts.authLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Reset PassWord')

{{-- Content Start --}}
@section('content')

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            {{-- include Flash Message --}}
            @includeIf('components.flash')
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper">

                        </div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo d-block mb-2">User&nbsp;Role&nbsp;<span>Mapper</span></a>
                            <p class="text-muted fw-normal mb-3">Reset New Password!!</p>
                            {{-- Forgot Password Form --}}
                            <form class="user" id="resetPasswordForm" action="{{ route('resetPassword') }}"
                                method="post">
                                {{-- Csrf --}}
                                @csrf

                                <input type="hidden" name="prt_token" class="d-none form-control" id="prt_token"
                                    value="{{ $token }}">

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Enter New Password">
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control"
                                        id="confirm_password" placeholder="Confirm New Password">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Reset
                                        Password</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')

    <script>
        $(document).ready(function() {

            // Validate Reset Password Form
            $("#resetPasswordForm").validate({
                rules: {
                    prt_token: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    confirm_password: {
                        required: true,
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        required: "Please Provide a New password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    confirm_password: {
                        required: "Please Confirm New password",
                        minlength: "Your password must be at least 6 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                }
            });
        });
    </script>

@endsection
