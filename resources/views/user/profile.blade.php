{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Profile')

{{-- Content Start --}}
@section('content')

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="position-relative">
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                        <img src="{{ asset('assets/images/cover.jpg') }}" class="rounded-top" alt="profile cover">
                    </figure>
                    <div
                        class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                        <div>
                            <img class="wd-70 rounded-circle" src="{{ asset('assets/images/user.png') }}" alt="profile">
                            <span class="h4 ms-3 text-dark">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center p-3 rounded-bottom">
                    <ul class="d-flex align-items-center m-0 p-0">
                        <li class="ms-3 ps-3 active d-flex align-items-center">
                            <i class="me-1 icon-md text-primary" data-feather="user"></i>
                            <span class="pt-1px d-none d-md-block text-primary">About</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-12 col-xl-12 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0">About</h6>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, impedit facere voluptatibus non
                        repellat culpa corrupti quas! Sit a adipisci laudantium suscipit natus libero in eveniet repellat
                        ut. Odio, accusamus.</p>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Joined:</label>
                        <p class="text-muted">November 15, 2015</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Lives:</label>
                        <p class="text-muted">New York, USA</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
    </div>

@endsection
