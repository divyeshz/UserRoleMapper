{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@if (isset($module) && $module != null)
    @section('title', 'UserRoleMapper | Module Edit')
@else
    @section('title', 'UserRoleMapper | Module Add')
@endif

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if (isset($module) && $module != null)
                <li class="breadcrumb-item active" aria-current="page">Edit Module</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Add Module</li>
            @endif
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if (isset($module) && $module != null)
                        <form action="{{ route('module.update', $module->id) }}" id="editModuleForm" method="post">
                    @else
                        <form class="" id="addModuleForm" method="POST" action="{{ route('module.store') }}">
                    @endif

                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name <span class="star">*</span> </label>

                        @if (isset($module) && $module != null)
                            <input type="text" class="form-control" value="{{ $module->name }}" name="name"
                                placeholder="Enter Module name">
                        @else
                            <input type="text" class="form-control" name="name" placeholder="Enter Module name">
                        @endif

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code <span class="star">*</span> </label>

                        @if (isset($module) && $module != null)
                            <input type="text" class="form-control" value="{{ $module->code }}" name="code"
                                placeholder="Enter Module Code">
                        @else
                            <input type="text" class="form-control" name="code" placeholder="Enter Module Code">
                        @endif


                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Order <span class="star">*</span> </label>

                        @if (isset($module) && $module != null)
                            <input type="number" class="form-control" name="display_order"
                                value="{{ $module->display_order }}" placeholder="Enter Display Order">
                        @else
                            <input type="number" class="form-control" name="display_order"
                                placeholder="Enter Display Order">
                        @endif


                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Parent Module</label>
                        <select class="form-select" name="parent_id" id="exampleFormControlSelect1">
                            <option selected disabled>Select Parent Module</option>

                            @foreach ($parentModule as $m)
                                @if (isset($module) && $module != null)
                                    <option {{ $m->id == $module->parent_id ? 'selected' : '' }}
                                        value="{{ $m->id }}">
                                        {{ $m->name }}</option>
                                @else
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-check-inline">

                            @if (isset($module) && $module != null)
                                <input type="checkbox" name="is_in_menu" {{ $module->is_in_menu == 1 ? 'checked' : '' }}
                                    class="form-check-input" id="is_in_menu" value="1">
                            @else
                                <input type="checkbox" name="is_in_menu" class="form-check-input" id="is_in_menu"
                                    value="1">
                            @endif

                            <label class="form-check-label" for="is_in_menu">
                                In Menu
                            </label>
                        </div>
                        <div class="form-check form-check-inline">

                            @if (isset($module) && $module != null)
                                <input type="checkbox" name="is_active" {{ $module->is_active == 1 ? 'checked' : '' }}
                                    class="form-check-input" id="is_active" value="1">
                            @else
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                    value="1">
                            @endif

                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Save</button>
                    <a href="{{ route('module.list') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')
    <script>
        $(document).ready(function() {

            $("#editModuleForm").validate({
                rules: {
                    name: "required",
                    code: "required",
                    display_order: {
                        required: true,
                        number: true
                    },
                },
                messages: {
                    name: "Please specify Module name",
                    code: "Please specify Module Code",
                    display_order: {
                        required: "Please Enter Display Order",
                        number: "Please enter numbers Only"
                    },
                }
            });
        });
    </script>

@endsection
