{{-- Extends authLayout --}}
@extends('layouts.authLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Change PassWord')

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
                            <p class="text-muted fw-normal mb-3">Please Change Your Password First!</p>
                            <form class="forms-sample" id="loginChangePasswordForm" action="{{ route('loginChangePassword') }}" method="POST">
                                @csrf
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
                                <div>
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Change
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

            $("#loginChangePasswordForm").validate({
                rules: {
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
