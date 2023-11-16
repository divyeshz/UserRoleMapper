{{-- Extends authLayout --}}
@extends('layouts.authLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Register')

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
                            <h5 class="text-muted fw-normal mb-4">Create a free account.</h5>
                            <form class="forms-sample" action="{{ route('register') }}" id="registerForm" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name">
                                </div>
                                <div class="mb-3">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary text-white me-2 mb-2 mb-md-0">Sign up</button>
                                </div>
                                <a href="{{ route('loginForm') }}" class="d-block mt-3 text-muted">Already a user? Sign
                                    in</a>
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

            // Validate Register Form
            $("#registerForm").validate({
                rules: {
                    fname: "required",
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
                    fname: "Please specify your first name",
                    email: {
                        required: "Please provide a your email",
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
