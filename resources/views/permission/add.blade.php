{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Permission Add')

{{-- Content Start --}}
@section('content')

    <nav class="page-breadcrumb mb-2 mb-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form class="" action="{{ route('permission.store') }}" id="addPermissionForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name <span class="star">*</span> </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Permission name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="star">*</span> </label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter Description"></textarea>
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
                                                <tr class="table-info">
                                                    <td colspan="6">{{ $uniqueModule->name }}</td>
                                                </tr>
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
                                                                    <input type="checkbox" value="add"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";1;"
                                                                        class="form-check-input add_{{ $module->name }}"
                                                                        id="add_{{ $module->name }}" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" value="view"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";2;"
                                                                        class="form-check-input view_{{ $module->name }}"
                                                                        id="view_{{ $module->name }}" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" value="edit"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";3;"
                                                                        class="form-check-input edit_{{ $module->name }}"
                                                                        id="modify_{{ $module->name }}" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" value="delete"
                                                                        name="{{ $module->name }}[]"
                                                                        data-in-perm-group=";4;"
                                                                        class="form-check-input delete"
                                                                        id="delete_{{ $module->name }}" />
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
                        <a href="{{ route('permission.list') }}" class="btn btn-secondary">Cancel</a>
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


            $("#addPermissionForm").validate({
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
