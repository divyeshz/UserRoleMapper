{{-- Extends authLayout --}}
@extends('layouts.authLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Login')

{{-- Content Start --}}
@section('content')

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper">

                        </div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo d-block mb-2">User&nbsp;Role&nbsp;<span>Mapper</span></a>
                            <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                            <form class="forms-sample" id="loginForm" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</button>
                                </div>
                                <a href="{{ route('forgotPasswordForm') }}" class="d-block text-muted mt-3">Forgot Password?</a>
                                <a href="{{ route('registrationForm') }}" class="d-block text-muted mt-2">Not a user? Sign
                                    up</a>
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

            $.validator.addMethod("endsWithCom", function(value, element) {
                return value.endsWith(".com");
            }, "Please enter a valid email address ending with .com.");

            // Validate Login Form
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        endsWithCom: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "We need your email address to contact you",
                        email: "Your email address must be in the format of name@domain.com",
                        endsWithCom: "Please enter a valid email address ending with .com."
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                }
            });
        });
    </script>

@endsection
