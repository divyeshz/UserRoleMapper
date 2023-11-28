{{-- Extends MainLayout --}}
@extends('layouts.mainLayout')

{{-- Change Title --}}
@section('title', 'UserRoleMapper | Demo List')

{{-- Content Start --}}
@section('content')

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <nav class="page-breadcrumb mb-2 mb-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Demo</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            @if (auth()->user()->hasModulePermission('demo', 'add'))
                <a href="{{ route('demo.addForm') }}" type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="plus"></i>
                    Add Demo
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                        <div>
                            <h6 class="card-title">Demo List</h6>
                        </div>
                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                            <div class="row mb-3">
                                <label for="filter" class="col-sm-2 col-form-label">Filter</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="filter">
                                        <option selected value="dl">Demo List</option>
                                        <option value="sddl">Soft Deleted Demo List</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="demoListTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
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
            let demoListTable = $('#demoListTable').DataTable({
                scrollY: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('demo.list') }}",
                    data: {
                        filterName: 'dl'
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
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
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
                            'Your data is safe :)',
                            'error'
                        )
                    }
                });
            });

            function refreshDataTable(filterName) {
                demoListTable.destroy();

                // Reinitialize DataTable based on the filterName
                demoListTable = $('#demoListTable').DataTable({
                    scrollY: false,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('demo.list') }}",
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
                            data: 'description',
                            name: 'description',
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
