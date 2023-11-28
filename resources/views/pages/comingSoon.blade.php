{{-- Extends mainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | 500')

{{-- Content Start --}}
@section('content')

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <img src="{{ asset('assets/images/others/404.svg') }}" class="img-fluid mb-2" alt="404">
            <h1 class="fw-bolder mb-22 mt-2 tx-80 text-muted">500</h1>
            <h4 class="mb-2">Coming Soon</h4>
            <h6 class="text-muted mb-3 text-center">Oopps!! This Page is still in development mode.</h6>
            <a href="{{ route('dashboard') }}" class="back-button">Back to home</a>
        </div>
    </div>

@endsection
