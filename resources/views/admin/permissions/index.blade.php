@extends('adminlte::page')

@section('title', 'Permissions')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Permissions</h1>
        @can('permissions.create')
            <a href="{{route('admin.permissions.create')}}" class="btn btn-primary mt-2">Add new</a>
        @endcan

    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Permissions</li>
        </ol>

    </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('permissions.list')
                <div class="card">

                    <div class="card-body table-responsive">

                        <table id="permissionsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>

                                <th>Permission</th>
                                <th>Guard</th>
                                <th>Group</th>
                                <th>Roles</th>
                                <th width="80px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>

                                    <td class="text-capitalize">{{$permission->name}}</td>
                                    <td class="text-capitalize">{{$permission->guard_name}} </td>
                                    <td class="text-capitalize">{{$permission->group_name}} </td>
                                    <th>
                                        @foreach($permission->roles as $role)
                                            <span class="badge badge-secondary text-capitalize">{{$role->name}}</span>
                                        @endforeach
                                    </th>
                                    <td>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('permissions.view')
                                                <a href="{{route('admin.permissions.show',['permission'=>$permission->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('permissions.update')
                                                <a href="{{route('admin.permissions.edit',['permission'=>$permission->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('permissions.delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>

                                <th>Permission</th>
                                <th>Guard</th>
                                <th>Group</th>
                                <th>Roles</th>
                                <th>Action</th>
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
        <b>version</b> {{env('DEV_VERSION')}}
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
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete Permission')),
                text: @json(__('Are you sure you want to delete this?')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('Delete')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                console.log(result)
                if (result.value) {
                    // Trigger the form submission
                    form.submit();
                }
            });
        }

        $(document).ready(function() {
            $("#permissionsList").DataTable({
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