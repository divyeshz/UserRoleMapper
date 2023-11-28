{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Permission View')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Permission</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">


                    <div class="mb-3">
                        <label class="form-label">Name<span class="star">*</span> </label>
                        <input type="text" readonly disabled class="form-control" value="{{ $Permission->name }}"
                            name="name" placeholder="Enter Permission name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description<span class="star">*</span> </label>
                        <textarea readonly disabled class="form-control" name="description" id="description" rows="5"
                            placeholder="Enter Description">{{ $Permission->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Module Name</th>
                                            <th>Add</th>
                                            <th>View</th>
                                            <th>Modify</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($uniqueModules as $uniqueModule)
                                            @if (count($uniqueModule->childModules) > 0)
                                                <tr class="table-info">
                                                    <td colspan="6">{{ $uniqueModule->name }}</td>
                                                </tr>
                                            @else
                                                <tr class="table-info">
                                                    <td>{{ $uniqueModule->name }}</td>
                                                    <td>
                                                        {!! $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                            return $value->id === $uniqueModule->id && $value->pivot->add_access === 1;
                                                        })
                                                            ? "<i data-feather='check'></i>"
                                                            : "<i data-feather='x'></i>" !!}
                                                    </td>
                                                    <td>
                                                        {!! $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                            return $value->id === $uniqueModule->id && $value->pivot->view_access === 1;
                                                        })
                                                            ? "<i data-feather='check'></i>"
                                                            : "<i data-feather='x'></i>" !!}
                                                    </td>
                                                    <td>
                                                        {!! $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                            return $value->id === $uniqueModule->id && $value->pivot->edit_access === 1;
                                                        })
                                                            ? "<i data-feather='check'></i>"
                                                            : "<i data-feather='x'></i>" !!}
                                                    </td>
                                                    <td>
                                                        {!! $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                            return $value->id === $uniqueModule->id && $value->pivot->delete_access === 1;
                                                        })
                                                            ? "<i data-feather='check'></i>"
                                                            : "<i data-feather='x'></i>" !!}
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($modules as $module)
                                                @if ($module->parentModule->id === $uniqueModule->id)
                                                    <tr>
                                                        <td>{{ $module->name }}</td>
                                                        <td>
                                                            {!! $Permission->modules->contains(function ($value) use ($module) {
                                                                return $value->id === $module->id && $value->pivot->add_access === 1;
                                                            })
                                                                ? "<i data-feather='check'></i>"
                                                                : "<i data-feather='x'></i>" !!}
                                                        </td>
                                                        <td>
                                                            {!! $Permission->modules->contains(function ($value) use ($module) {
                                                                return $value->id === $module->id && $value->pivot->view_access === 1;
                                                            })
                                                                ? "<i data-feather='check'></i>"
                                                                : "<i data-feather='x'></i>" !!}
                                                        </td>
                                                        <td>
                                                            {!! $Permission->modules->contains(function ($value) use ($module) {
                                                                return $value->id === $module->id && $value->pivot->edit_access === 1;
                                                            })
                                                                ? "<i data-feather='check'></i>"
                                                                : "<i data-feather='x'></i>" !!}
                                                        </td>
                                                        <td>
                                                            {!! $Permission->modules->contains(function ($value) use ($module) {
                                                                return $value->id === $module->id && $value->pivot->delete_access === 1;
                                                            })
                                                                ? "<i data-feather='check'></i>"
                                                                : "<i data-feather='x'></i>" !!}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('perm.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>

@endsection
