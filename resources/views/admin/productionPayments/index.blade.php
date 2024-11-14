@extends('adminlte::page')
@section('title', 'Production House Payments')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Production House Payments</h1>
            @can('productionPayments.create')
                <a href="{{ route('admin.production-payments.create') }}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('productionPayments.trashed')
                <a href="{{ route('admin.production-payments.trashed') }}" class="btn btn-danger mt-2">Trash List</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Production House Payments</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('productionPayments.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="15%">Production House</th>
                                <th width="15%">Account</th>
                                <th width="15%">Amount</th>
                                <th width="15%">Date</th>
                                <th width="15%">Received By</th>
                                <th width="15%">Status</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->productionHouse->name ?? '' }}</td>
                                    <td>{{ $payment->account->name ?? '' }}</td>
                                    <td>{{ $payment->amount ?? '' }}</td>
                                    <td>{{ $payment->date ?? '' }}</td>
                                    <td>{{ $payment->received_by ?? '' }}</td>
                                    <td>{{ ucfirst($payment->status ?? '') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.production-payments.destroy', $payment->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('productionPayments.updateStatus')
                                                @if($payment->status == 'pending')
                                                    @can('productionPayments.view')
                                                        <a href="{{ route('admin.production-payments.show',['production_payment'=>$payment->id]) }}" class="btn btn-info px-1 py-0 btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('productionPayments.update')
                                                        <a href="{{ route('admin.production-payments.edit',['production_payment'=>$payment->id]) }}" class="btn btn-warning px-1 py-0 btn-sm">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                    @endcan
                                                    @can('productionPayments.delete')
                                                        <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                    <a href="{{ route('admin.production-payments.updateStatus', ['production_payment' => $payment->id, 'status' => 'approved']) }}"
                                                       class="btn btn-success btn-sm px-1 py-0">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="{{ route('admin.production-payments.updateStatus', ['production_payment' => $payment->id, 'status' => 'rejected']) }}"
                                                       class="btn btn-danger btn-sm px-1 py-0">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @elseif($payment->status == 'rejected')
                                                    <a href="{{ route('admin.production-payments.updateStatus', ['production_payment' => $payment->id, 'status' => 'pending']) }}"
                                                       class="btn btn-primary btn-sm px-1 py-0">
                                                        <i class="fas fa-arrow-alt-circle-left"></i>
                                                    </a>
                                                @elseif($payment->status == 'approved')
                                                    <a href="{{ route('admin.production-payments.updateStatus', ['production_payment' => $payment->id, 'status' => 'pending']) }}"
                                                       class="btn btn-primary btn-sm px-1 py-0">
                                                        <i class="fas fa-arrow-alt-circle-left"></i>
                                                @endif
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="15%">Production House</th>
                                <th width="15%">Account</th>
                                <th width="15%">Amount</th>
                                <th width="15%">Date</th>
                                <th width="15%">Received By</th>
                                <th width="15%">Status</th>
                                <th width="15%">Action</th>
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
                title: @json(__('Delete Payment')),
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
