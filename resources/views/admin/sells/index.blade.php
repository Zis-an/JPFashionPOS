@extends('adminlte::page')
@section('title', 'Sells')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Sells</h1>
            @can('sells.create')
                <a href="{{ route('admin.sells.create') }}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('sells.trashed')
                <a href="{{ route('admin.sells.trashed') }}" class="btn btn-danger mt-2">Trash List</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Sells</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('sells.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Salesman</th>
                                <th>Account</th>
                                <th>Total Amount</th>
                                <th>Discount Amount</th>
                                <th>Net Total</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sells as $sell)
                                <tr>
                                    <td>{{ $sell->customer->name ?? '' }}</td>
                                    <td>{{ $sell->salesman->name ?? '' }}</td>
                                    <td>{{ $sell->account->name ?? '' }}</td>
                                    <td class="text-right">{{$sell->currency->prefix??''}}{{ $sell->total_amount ?? '' }} {{$sell->currency->suffix??''}}</td>
                                    <td class="text-right">{{$sell->currency->prefix??''}}{{ $sell->discount_amount ?? '' }} {{$sell->currency->suffix??''}}</td>
                                    <td class="text-right"> {{$sell->currency->prefix??''}}{{ $sell->net_total ?? '' }} {{$sell->currency->suffix??''}}</td>
                                    <td>{{ $sell->paid_amount == $sell->net_total ? 'Paid in Full' : 'Due' ?? '' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.sells.destroy', $sell->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('sells.view')
                                                <a href="{{ route('admin.sells.show',['sell'=>$sell->id]) }}" class="btn btn-info px-1 py-0 btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('sells.update')
                                                <a href="{{ route('admin.sells.edit',['sell'=>$sell->id]) }}" class="btn btn-warning px-1 py-0 btn-sm">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                            @endcan
                                            @can('sells.delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Customer</th>
                                <th>Salesman</th>
                                <th>Account</th>
                                <th>Total Amount</th>
                                <th>Discount Amount</th>
                                <th>Net Total</th>
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
                title: @json(__('Delete Sell')),
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
