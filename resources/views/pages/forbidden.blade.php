{{-- Extends mainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | 403')

{{-- Content Start --}}
@section('content')

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <img src="{{ asset('assets/images/others/404.svg') }}" class="img-fluid mb-2" alt="404">
            <h1 class="fw-bolder mb-22 mt-2 tx-80 text-muted">403</h1>
            <h4 class="mb-2">Access Denied</h4>
            <h6 class="text-muted mb-3 text-center">Oopps!! You don't have permission to access this page.</h6>
            <a href="{{ route('dashboard') }}" class="back-button">Back to home</a>
        </div>
    </div>
@endsection
