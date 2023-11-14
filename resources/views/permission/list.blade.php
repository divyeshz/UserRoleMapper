{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Permission List')

{{-- Content Start --}}
@section('content')

    <div class="page-content">


        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <nav class="page-breadcrumb mb-2 mb-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Permission</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <a href="{{ route('permission.addForm') }}" type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="plus"></i>
                    Add Permission
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Users Permission</h6>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Demo</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('permission.editForm') }}" type="button"
                                                class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-icon deleteRole">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Demo</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('permission.editForm') }}" type="button"
                                                class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-icon deleteRole">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Demo</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('permission.editForm') }}" type="button"
                                                class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-icon deleteRole">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Demo</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('permission.editForm') }}" type="button"
                                                class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-icon deleteRole">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Demo</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('permission.editForm') }}" type="button"
                                                class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-icon deleteRole">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Demo</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('permission.editForm') }}" type="button"
                                                class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-icon deleteRole">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('jsContent')
    <script>
        $(document).ready(function() {
            $('.deleteRole').on('click', function() {
                var recordId = $(this).data('record-id');

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
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
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



                /* // Make Ajax request to delete record
                $.ajax({
                    url: '/delete-record/' + recordId,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire('Deleted!', response.success, 'success');
                        // You can also remove the deleted record from the UI if needed
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Unable to delete the record.',
                            'error');
                    }
                }); */

            });
        });
    </script>

@endsection
