{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@if (isset($Permission) && $Permission != null)
    @section('title', 'UserRoleMapper | Permission Edit')
@else
    @section('title', 'UserRoleMapper | Permission Add')
@endif


{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if (isset($Permission) && $Permission != null)
                <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
            @endif
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if (isset($Permission) && $Permission != null)
                        <form action="{{ route('perm.update', $Permission->id) }}" id="editPermissionForm"
                            method="post">
                        @else
                            <form class="" action="{{ route('perm.store') }}" id="addPermissionForm"
                                method="post">
                    @endif


                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name<span class="star">*</span> </label>
                        @if (isset($Permission) && $Permission != null)
                            <input type="text" class="form-control" value="{{ $Permission->name }}" name="name"
                                placeholder="Enter Permission name">
                        @else
                            <input type="text" class="form-control" name="name" placeholder="Enter Permission name">
                        @endif


                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description<span class="star">*</span> </label>

                        @if (isset($Permission) && $Permission != null)
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description">{{ $Permission->description }}</textarea>
                        @else
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description"></textarea>
                        @endif

                    </div>

                    <div class="form-check form-check-inline">

                        @if (isset($Permission) && $Permission != null)
                            <input type="checkbox" name="is_active" {{ $Permission->is_active == 1 ? 'checked' : '' }}
                                class="form-check-input" id="is_active" value="1">
                        @else
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1">
                        @endif

                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Module Name</th>
                                            <th>All</th>
                                            <th>Add
                                                <div class="form-check">
                                                    <input type="checkbox" value="1"
                                                        class="form-check-input perm_group" />
                                                </div>
                                            </th>
                                            <th>View
                                                <div class="form-check">
                                                    <input type="checkbox" value="2"
                                                        class="form-check-input perm_group" />
                                                </div>
                                            </th>
                                            <th>Modify
                                                <div class="form-check">
                                                    <input type="checkbox" value="3"
                                                        class="form-check-input perm_group" />
                                                </div>
                                            </th>
                                            <th>Delete
                                                <div class="form-check">
                                                    <input type="checkbox" value="4"
                                                        class="form-check-input perm_group" />
                                                </div>
                                            </th>
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
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input all"
                                                            id="{{ $uniqueModule->name }}" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">

                                                        @if (isset($Permission) && $Permission != null)
                                                            <input type="checkbox" value="add"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";1;"
                                                                {{ $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                                    return $value->id === $uniqueModule->id && $value->pivot->add_access === 1;
                                                                })
                                                                    ? 'checked'
                                                                    : '' }}
                                                                class="form-check-input add_{{ $uniqueModule->name }}"
                                                                id="add_{{ $uniqueModule->name }}" />
                                                        @else
                                                            <input type="checkbox" value="add"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";1;"
                                                                class="form-check-input add_{{ $uniqueModule->name }}"
                                                                id="add_{{ $uniqueModule->name }}" />
                                                        @endif

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">

                                                        @if (isset($Permission) && $Permission != null)
                                                            <input type="checkbox" value="view"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";2;"
                                                                {{ $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                                    return $value->id === $uniqueModule->id && $value->pivot->view_access === 1;
                                                                })
                                                                    ? 'checked'
                                                                    : '' }}
                                                                class="form-check-input view_{{ $uniqueModule->name }}"
                                                                id="view_{{ $uniqueModule->name }}" />
                                                        @else
                                                            <input type="checkbox" value="view"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";2;"
                                                                class="form-check-input view_{{ $uniqueModule->name }}"
                                                                id="view_{{ $uniqueModule->name }}" />
                                                        @endif

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">

                                                        @if (isset($Permission) && $Permission != null)
                                                            <input type="checkbox" value="edit"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";3;"
                                                                {{ $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                                    return $value->id === $uniqueModule->id && $value->pivot->edit_access === 1;
                                                                })
                                                                    ? 'checked'
                                                                    : '' }}
                                                                class="form-check-input edit_{{ $uniqueModule->name }}"
                                                                id="modify_{{ $uniqueModule->name }}" />
                                                        @else
                                                            <input type="checkbox" value="edit"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";3;"
                                                                class="form-check-input edit_{{ $uniqueModule->name }}"
                                                                id="modify_{{ $uniqueModule->name }}" />
                                                        @endif

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">

                                                        @if (isset($Permission) && $Permission != null)
                                                            <input type="checkbox" value="delete"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";4;"
                                                                {{ $Permission->modules->contains(function ($value) use ($uniqueModule) {
                                                                    return $value->id === $uniqueModule->id && $value->pivot->delete_access === 1;
                                                                })
                                                                    ? 'checked'
                                                                    : '' }}
                                                                class="form-check-input delete"
                                                                id="delete_{{ $uniqueModule->name }}" />
                                                        @else
                                                            <input type="checkbox" value="delete"
                                                                name="{{ $uniqueModule->name }}[]"
                                                                data-in-perm-group=";4;"
                                                                class="form-check-input delete"
                                                                id="delete_{{ $uniqueModule->name }}" />
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @foreach ($modules as $module)
                                                @if ($module->parentModule->id === $uniqueModule->id)
                                                    <tr>
                                                        <td>{{ $module->name }}</td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input all"
                                                                    id="{{ $module->name }}" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">

                                                                @if (isset($Permission) && $Permission != null)
                                                                    <input type="checkbox" value="add"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";1;"
                                                                        {{ $Permission->modules->contains(function ($value) use ($module) {
                                                                            return $value->id === $module->id && $value->pivot->add_access === 1;
                                                                        })
                                                                            ? 'checked'
                                                                            : '' }}
                                                                        class="form-check-input add_{{ $module->name }}"
                                                                        id="add_{{ $module->name }}" />
                                                                @else
                                                                    <input type="checkbox" value="add"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";1;"
                                                                        class="form-check-input add_{{ $module->name }}"
                                                                        id="add_{{ $module->name }}" />
                                                                @endif

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">

                                                                @if (isset($Permission) && $Permission != null)
                                                                    <input type="checkbox" value="view"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";2;"
                                                                        {{ $Permission->modules->contains(function ($value) use ($module) {
                                                                            return $value->id === $module->id && $value->pivot->view_access === 1;
                                                                        })
                                                                            ? 'checked'
                                                                            : '' }}
                                                                        class="form-check-input view_{{ $module->name }}"
                                                                        id="view_{{ $module->name }}" />
                                                                @else
                                                                    <input type="checkbox" value="view"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";2;"
                                                                        class="form-check-input view_{{ $module->name }}"
                                                                        id="view_{{ $module->name }}" />
                                                                @endif

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">

                                                                @if (isset($Permission) && $Permission != null)
                                                                    <input type="checkbox" value="edit"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";3;"
                                                                        {{ $Permission->modules->contains(function ($value) use ($module) {
                                                                            return $value->id === $module->id && $value->pivot->edit_access === 1;
                                                                        })
                                                                            ? 'checked'
                                                                            : '' }}
                                                                        class="form-check-input edit_{{ $module->name }}"
                                                                        id="modify_{{ $module->name }}" />
                                                                @else
                                                                    <input type="checkbox" value="edit"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";3;"
                                                                        class="form-check-input edit_{{ $module->name }}"
                                                                        id="modify_{{ $module->name }}" />
                                                                @endif

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">

                                                                @if (isset($Permission) && $Permission != null)
                                                                    <input type="checkbox" value="delete"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";4;"
                                                                        {{ $Permission->modules->contains(function ($value) use ($module) {
                                                                            return $value->id === $module->id && $value->pivot->delete_access === 1;
                                                                        })
                                                                            ? 'checked'
                                                                            : '' }}
                                                                        class="form-check-input delete"
                                                                        id="delete_{{ $module->name }}" />
                                                                @else
                                                                    <input type="checkbox" value="delete"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";4;"
                                                                        class="form-check-input delete"
                                                                        id="delete_{{ $module->name }}" />
                                                                @endif

                                                            </div>
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
                    <button type="submit" class="btn btn-primary me-2">Save</button>
                    <a href="{{ route('perm.list') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')

    <script>
        $(document).ready(function() {

            $('.all').on('change', function() {
                let id = $(this).attr('id'); // Get the ID of the 'all' checkbox
                if ($(this).is(':checked')) {
                    // Check all checkboxes that contain the same ID in their own IDs
                    $('[id*=' + id + ']:checkbox').prop('checked', true);
                } else {
                    // Uncheck all checkboxes that contain the same ID in their own IDs
                    $('[id*=' + id + ']:checkbox').prop('checked', false);
                }
            });

            var permGroupsSelected = [];
            $('body').on('change', '.perm_group', function() {
                permGroupsSelected = [];
                $('.perm_group:checked').each(function() {
                    permGroupsSelected.push($(this).val());
                });

                if ($(this).is(':checked')) {
                    $('input[data-in-perm-group]').prop('checked', false);
                    $(permGroupsSelected).each(function(permGroupIdIndex) {
                        $('input[data-in-perm-group*=";' + permGroupsSelected[permGroupIdIndex] +
                            ';"]').prop('checked', true);
                    });
                } else {
                    var clickedVal = $(this).val();
                    $('input[data-in-perm-group*=";' + clickedVal + ';"]').prop('checked', false);
                }
            });

            $("#editPermissionForm").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Please specify role name",
                    description: "Please specify role description"
                }
            });
        });
    </script>

@endsection
