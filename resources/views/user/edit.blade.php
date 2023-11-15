{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Users Edit')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>

    @foreach ($user as $u)
        {{ $id = $u->id }}
    @endforeach

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('user.update', $id) }}" id="addUserForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input name="role" class="form-control" id="tags" value="{{ $user->name }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="Demo" name="fname"
                                placeholder="Enter first name">
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="User" name="lname"
                                    placeholder="Enter last name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" name="Email" value="demo@gmail.com" class="form-control"
                                placeholder="Enter email">
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
                    email: {
                        email: true,
                        endsWithCom: true
                    }
                },
                messages: {
                    role: "Please provide a Role",
                    fname: "Please specify your First name",
                    email: {
                        email: "Your email address must be in the format of name@domain.com",
                        endsWithCom: "Please enter a valid email address ending with .com."
                    },
                }
            });
        });
    </script>

@endsection
