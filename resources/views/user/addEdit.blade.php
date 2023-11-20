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

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if (isset($user) && $user != null)
                        <form action="{{ route('user.update', $user->id) }}" id="addUserForm" method="post">
                    @else
                        <form class="" id="addUserForm" method="post" action="{{ route('user.store') }}">
                    @endif

                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Role <span class="star">*</span> </label>
                        <select name="role[]" class="js-example-basic-multiple form-select" multiple="multiple"
                            data-width="100%">
                            @foreach ($role as $r)
                                @if (isset($user) && $user != null)
                                    <option {{ in_array($r->id, $pivotRoles) ? 'selected' : '' }}
                                        value="{{ $r->id }}">
                                        {{ $r->name }}</option>
                                @else
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">First Name <span class="star">*</span> </label>
                        @if (isset($user) && $user != null)
                            <input type="text" class="form-control" value="{{ $user->first_name }}" name="fname"
                                placeholder="Enter first name">
                        @else
                            <input type="text" class="form-control" name="fname" placeholder="Enter first name">
                        @endif

                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            @if (isset($user) && $user != null)
                                <input type="text" class="form-control" value="{{ $user->last_name }}" name="lname"
                                    placeholder="Enter last name">
                            @else
                                <input type="text" class="form-control" name="lname" placeholder="Enter last name">
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address <span class="star">*</span> </label>
                        @if (isset($user) && $user != null)
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                placeholder="Enter email">
                        @else
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                        @endif

                    </div>
                    <div class="form-check mb-3">
                        @if (isset($user) && $user != null)
                            <input {{ $user->is_active == 1 ? 'checked' : '' }} type="checkbox" name="is_active"
                                class="form-check-input" value="1" id="is_active">
                        @else
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active">
                        @endif
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    @if (isset($user) && $user != null)
                        <input type="hidden" name="type" value="{{ $user->type }}">
                    @endif
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
                    'role[]': "required",
                    fname: "required",
                    email: {
                        required: true,
                        email: true,
                        endsWithCom: true
                    },
                },
                messages: {
                    'role[]': "Please provide a Role",
                    fname: "Please specify your First name",
                    email: {
                        required: "Please provide a your email",
                        email: "Your email address must be in the format of name@domain.com",
                        endsWithCom: "Please enter a valid email address ending with .com."
                    },
                }
            });
        });
    </script>

@endsection
