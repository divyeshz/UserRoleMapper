{{-- Extends authLayout --}}
@extends('layouts.authLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Forgot PassWord')

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
                            <p class="text-muted fw-normal mb-3">We get it, stuff happens. Just enter your email address
                                below
                                and we'll send you a link to reset your password!</p>
                            <form class="forms-sample" id="forgotPasswordForm" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Email">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Reset
                                        Password</button>
                                </div>
                                {{-- Create an Account Button --}}
                                <a class="d-block text-muted mt-3" href="{{ route('registrationForm') }}">Create an
                                    Account!</a>

                                {{-- Already have an account Button --}}
                                <a class="d-block text-muted mt-2" href="{{ route('loginForm') }}">Already have an account?
                                    Login!</a>

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

            // Validate Forgot Password Form
            $("#forgotPasswordForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        endsWithCom: true
                    }
                },
                messages: {
                    email: {
                        required: "We need your email address to contact you",
                        email: "Your email address must be in the format of name@domain.com",
                        endsWithCom: "Please enter a valid email address ending with .com."
                    }
                }
            });
        });
    </script>

@endsection
