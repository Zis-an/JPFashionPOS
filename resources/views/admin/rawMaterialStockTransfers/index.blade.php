@extends('adminlte::page')
@section('title', 'Raw Material Stock Transfers')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Raw Material Stock Transfers</h1>
            @can('rawMaterialStockTransfers.create')
                <a href="{{route('admin.raw-material-stock-transfers.create')}}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('rawMaterialStockTransfers.trashed')
                <a href="{{route('admin.raw-material-stock-transfers.trashed')}}" class="btn btn-danger mt-2">Trash List</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Raw Material Stock Transfers</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('rawMaterialStockTransfers.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>From Warehouse</th>
                                <th>To Warehouse</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transfers as $transfer)
                                <tr>
                                    <td>{{ $transfer->fromWarehouse->name ?? '' }}</td>
                                    <td>{{ $transfer->toWarehouse->name ?? '' }}</td>
                                    <td class="text-capitalize">{{ $transfer->status ?? '' }}</td>
                                    <td class="text-center">
                                        <form class="d-inline" action="{{ route('admin.raw-material-stock-transfers.destroy', $transfer->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <a href="{{ route('admin.raw-material-stock-transfers.show',['raw_material_stock_transfer'=>$transfer->id]) }}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.raw-material-stock-transfers.edit',['raw_material_stock_transfer'=>$transfer->id]) }}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @if( $transfer->status == 'pending')
                                        <form class="d-inline" action="{{route('admin.raw-material-stock-transfers.changeStatus', $transfer)}}" method="get">
                                            <input name="status" value="approved" hidden="">
                                            <button class="btn btn-success btn-sm px-1 py-0"><i class="fa fa-check"></i></button>
                                        </form>
                                        @endif
                                        @if( $transfer->status == 'pending')
                                        <form  class="d-inline" action="{{route('admin.raw-material-stock-transfers.changeStatus', $transfer)}}" method="get">
                                            <input name="status" value="rejected" hidden="">
                                            <button class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-times"></i></button>
                                        </form>
                                        @endif
                                        @if( $transfer->status == 'rejected' || $transfer->status == 'approved')
                                        <form  class="d-inline" action="{{route('admin.raw-material-stock-transfers.changeStatus', $transfer)}}" method="get">
                                            <input name="status" value="pending" hidden="">
                                            <button class="btn btn-info btn-sm px-1 py-0"><i class="fa fa-arrow-left"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>From Warehouse</th>
                                <th>To Warehouse</th>
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
                title: @json(__('Delete Transfer')),
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
