{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@if (isset($Demo) && $action == 'View')
    @section('title', 'UserRoleMapper | Demo View')
@elseif (isset($Demo) && $Demo != null && $action == 'Edit' )
    @section('title', 'UserRoleMapper | Demo Edit')
@else
    @section('title', 'UserRoleMapper | Demo Add')
@endif


{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if (isset($Demo) && $Demo != null && $action != 'View')
                <li class="breadcrumb-item active" aria-current="page">Edit Demo</li>
            @elseif (isset($Demo) && $action == 'View')
                <li class="breadcrumb-item active" aria-current="page">View Demo</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Add Demo</li>
            @endif
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if (isset($Demo) && $Demo != null && $action != 'View')
                        <form action="{{ route('demo.update', $Demo->id) }}" id="demoForm" method="post">
                    @else
                        <form class="" action="{{ route('demo.store') }}" id="demoForm" method="post">
                    @endif


                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name <span class="star">*</span> </label>
                        @if (isset($Demo) && $Demo != null && $action != 'View')
                            <input type="text" class="form-control" value="{{ $Demo->name }}" name="name"
                                placeholder="Enter name">
                        @elseif (isset($Demo) && $Demo != null && $action == 'View')
                            <input type="text" readonly disabled class="form-control" name="name"
                                value="{{ $Demo->name }}">
                        @else
                            <input type="text" class="form-control" name="name" placeholder="Enter name">
                        @endif


                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="star">*</span> </label>

                        @if (isset($Demo) && $Demo != null && $action != 'View')
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description">{{ $Demo->description }}</textarea>
                        @elseif (isset($Demo) && $Demo != null && $action == 'View')
                            <textarea class="form-control" readonly disabled name="description">{{ $Demo->description }}</textarea>
                        @else
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description"></textarea>
                        @endif

                    </div>

                    @if ($action != 'View')
                    <button type="submit" class="btn btn-primary me-2">Save</button>
                    @endif

                    <a href="{{ route('demo.list') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')

    <script>
        $(document).ready(function() {

            $("#demoForm").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Please specify name",
                    description: "Please specify description"
                }
            });
        });
    </script>

@endsection
