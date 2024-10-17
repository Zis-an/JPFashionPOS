@extends('adminlte::page')

@section('title', 'Accounts')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Accounts</h1>
            @can('accounts.create')
                <a href="{{route('admin.accounts.create')}}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('accounts.trashed')
                <a href="{{route('admin.accounts.trashed')}}" class="btn btn-danger mt-2">Trash List</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('accounts.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Type</th>
                                <th>Balance</th>
                                <th>Admin</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>

                                    <td>{{ $account->name }}</td>
                                    <td>{{ ucfirst($account->type) }}</td>
                                    <td>{{ $account->balance }}</td>
                                    <td>{{ $account->admin->name??'' }}</td>
                                    <td>
                                        @if($account->status=='active') <span class="badge-success badge">Active</span>
                                        @else <span class="badge-danger badge">Deactivate</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('accounts.view')
                                                <a href="{{ route('admin.accounts.show',['account'=>$account->id]) }}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('accounts.update')
                                                <a href="{{ route('admin.accounts.edit',['account'=>$account->id]) }}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('accounts.delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Account Name</th>
                                <th>Type</th>
                                <th>Balance</th>
                                <th>Admin</th>
                                <th>Status</th>
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
                title: @json(__('Delete Admin')),
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
            $("#adminsList").DataTable({
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
                        first: "{{ __('First') }}",
                        previous: "{{ __('Previous') }}",
                        next: "{{ __('Next') }}",
                        last: "{{ __('Last') }}",
                    }
                }
            });

        });

    </script>
@stop
