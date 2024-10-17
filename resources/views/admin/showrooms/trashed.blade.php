@extends('adminlte::page')

@section('title', 'Trashed Showrooms')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Trashed Showrooms</h1>
            @can('showrooms.list')
                <a href="{{ route('admin.showrooms.index') }}" class="btn btn-primary mt-2">Go Back</a>
            @endcan
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Trashed Showrooms</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('showrooms.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="showroomsList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="25%">Name</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($showrooms as $showroom)
                                <tr>
                                    <td>{{ $showroom->name }}</td>
                                    <td class="text-center">
                                        @can('showrooms.restore')
                                            <a href="{{ route('admin.showrooms.restore', ['showroom' => $showroom->id]) }}" class="btn btn-success btn-sm px-1 py-0">
                                                <i class="fa fa-arrow-left"></i>
                                            </a>
                                        @endcan
                                        @can('showrooms.force_delete')
                                            <a href="{{ route('admin.showrooms.force_delete', ['showroom' => $showroom->id]) }}" class="btn btn-danger btn-sm px-1 py-0">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="25%">Name</th>
                                <th width="10%">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@stop

@section('footer')
    <strong>Developed by <a href="https://www.techyfo.com">Techyfo</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>version</b> {{ env('DEV_VERSION') }}
    </div>
@stop

@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('css')
@stop

@section('js')
    <script>
        function isDelete(button) {
            event.preventDefault();
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete Trashed Showroom')),
                text: @json(__('Are you sure you want to delete this?')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('Delete')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            });
        }

        $(document).ready(function() {
            $("#showroomsList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copy',
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                    },
                    {
                        extend: 'colvis',
                        text: 'Colvis',
                    }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    paginate: {
                        first: "First",
                        previous: "Previous",
                        next: "Next",
                        last: "Last",
                    }
                }
            });
        });
    </script>
@stop
