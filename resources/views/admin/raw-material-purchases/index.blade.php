@extends('adminlte::page')
@section('title', 'Raw Material Purchases')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Raw Material Purchases</h1>
            @can('rawMaterialPurchases.create')
                <a href="{{ route('admin.raw-material-purchases.create') }}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('rawMaterialPurchases.trashed')
                <a href="{{ route('admin.raw-material-purchases.trashed') }}" class="btn btn-danger mt-2">Trash List</a>
            @endcan
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Purchases</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('rawMaterialPurchases.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="purchasesList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Account</th>
                                <th>Total Cost</th>
                                <th>Purchase Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->supplier->name ?? '' }}</td>
                                    <td>{{ $purchase->warehouse->name ?? '' }}</td>
                                    <td>{{ $purchase->account->name ?? '' }}</td>
                                    <td>{{ $purchase->total_cost ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') ?? '' }}</td>
                                    <td>{{ ucfirst($purchase->status ?? '') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.raw-material-purchases.destroy', $purchase->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('rawMaterialPurchases.updateStatus')
                                                @if($purchase->status == 'pending')
                                                    @can('rawMaterialPurchases.view')
                                                        <a href="{{ route('admin.raw-material-purchases.show',['raw_material_purchase'=>$purchase->id]) }}"
                                                           class="btn btn-info px-1 py-0 btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('rawMaterialPurchases.update')
                                                        <a href="{{ route('admin.raw-material-purchases.edit',['raw_material_purchase'=>$purchase->id]) }}"
                                                           class="btn btn-warning px-1 py-0 btn-sm">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                    @endcan
                                                    @can('rawMaterialPurchases.delete')
                                                        <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                    <a href="{{ route('admin.raw-material-purchases.updateStatus', ['raw_material_purchase' => $purchase->id, 'status' => 'approved']) }}"
                                                       class="btn btn-success btn-sm px-1 py-0">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="{{ route('admin.raw-material-purchases.updateStatus', ['raw_material_purchase' => $purchase->id, 'status' => 'rejected']) }}"
                                                       class="btn btn-danger btn-sm px-1 py-0">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @elseif($purchase->status == 'rejected')
                                                    <a href="{{ route('admin.raw-material-purchases.updateStatus', ['raw_material_purchase' => $purchase->id, 'status' => 'pending']) }}"
                                                       class="btn btn-primary btn-sm px-1 py-0">
                                                        <i class="fas fa-arrow-alt-circle-left"></i>
                                                    </a>
                                                    @can('rawMaterialPurchases.view')
                                                        <a href="{{ route('admin.raw-material-purchases.show',['raw_material_purchase'=>$purchase->id]) }}"
                                                           class="btn btn-info px-1 py-0 btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @elseif($purchase->status == 'approved')
                                                        <a href="{{ route('admin.raw-material-purchases.updateStatus', ['raw_material_purchase' => $purchase->id, 'status' => 'pending']) }}"
                                                           class="btn btn-primary btn-sm px-1 py-0">
                                                            <i class="fas fa-arrow-alt-circle-left"></i>
                                                        </a>
                                                    @can('rawMaterialPurchases.view')
                                                        <a href="{{ route('admin.raw-material-purchases.show',['raw_material_purchase'=>$purchase->id]) }}"
                                                           class="btn btn-info px-1 py-0 btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                   @endif
                                                    <a target="_blank"
                                                       rel="noopener noreferrer"
                                                       onclick="openSinglePrivateWindow(this.href); return false;"
                                                       href="{{ route('admin.raw-material-purchases.print', ['raw_material_purchase'=>$purchase->id]) }}" class="btn btn-warning btn-sm px-1 py-0">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Account</th>
                                <th>Total Cost</th>
                                <th>Purchase Date</th>
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
        let privateWindow = null;

        function openSinglePrivateWindow(url) {
            // If a private window is already open, focus on it instead of opening a new one
            if (!privateWindow || privateWindow.closed) {
                privateWindow = window.open(url, '_blank', 'noopener,noreferrer,width=800,height=600');
            } else {
                privateWindow.focus();
            }
        }
    </script>
    <script>
        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete RawMaterialPurchase')),
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
            $("#purchasesList").DataTable({
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
