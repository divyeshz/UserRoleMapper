{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Users List')

{{-- Content Start --}}
@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb mb-2 mb-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Users</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('user.addForm') }}" type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="user-plus"></i>
                Add User
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                        <div>
                            <h6 class="card-title">Users List</h6>
                        </div>
                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                            <div class="row mb-3">
                                <label for="filter" class="col-sm-2 col-form-label">Filter</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="filter">
                                        <option selected value="ul">User List</option>
                                        <option value="sdul">Soft Deleted User List</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="userListTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Role(s)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsContent')
    <script>
        $(document).ready(function() {

            $('#filter').on('change', function() {
                let filterValue = $(this).val(); // Get the selected filter value
                refreshDataTable(filterValue);
            });


            // make yajra Table
            let userListTable = $('#userListTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.list') }}",
                    data: {
                        filterName: 'ul'
                    },
                },
                columns: [{
                        data: '#',
                        name: '#'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'type',
                        name: 'type',
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });

            // change is_active
            $(document).on("click", ".switch_is_active", function() {
                const id = $(this).attr('data-id');
                let is_active = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    type: 'POST',
                    data: {
                        id: id,
                        is_active: is_active,
                        _token: "{{ csrf_token() }}"
                    },
                    url: "{{ route('user.status') }}",
                    success: function(response) {
                        var userListTable = $('#userListTable').dataTable();
                        userListTable.fnDraw(false);
                    }
                });
            });

            $(document).on("click", ".delete", function() {
                const form = $(this).closest('.delete-form');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'me-2',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        )
                    }
                });
            });

            function refreshDataTable(filterName) {
                userListTable.destroy();

                // Reinitialize DataTable based on the filterName
                userListTable = $('#userListTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user.list') }}",
                        data: {
                            filterName: filterName
                        },
                    },
                    columns: [{
                        data: '#',
                        name: '#'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'type',
                        name: 'type',
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
                });
            }
        });
    </script>

@endsection
