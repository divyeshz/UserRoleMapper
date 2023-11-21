{{-- Extends mainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Dashboard')

{{-- Content Start --}}
@section('content')


    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                        data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div id="welcome-animation">

            </div>
        </div>
    </div> <!-- row -->

@endsection

@section('jsContent')

    <script>
        const animationContainer = document.getElementById('welcome-animation');
        const animationPath = 'https://lottie.host/8c62dd60-a598-4031-b303-8a8060182b0a/gXCDH6FQYZ.json';

        const animation = lottie.loadAnimation({
            container: animationContainer,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: animationPath
        });
    </script>

@endsection
