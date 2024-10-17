@extends('adminlte::page')

@section('title', 'Payment Methods')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Payment Methods</h1>
            @can('paymentMethods.create')
                <a href="{{ route('admin.paymentMethods.create') }}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('paymentMethods.trashed')
                <a href="{{ route('admin.paymentMethods.trashed') }}" class="btn btn-danger mt-2">Trash List</a>
            @endcan
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Payment Methods</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('paymentMethods.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="paymentMethodsList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Payment Method Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paymentMethods as $paymentMethod)
                                <tr>
                                    <td>{{ $paymentMethod->name ?? '' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.paymentMethods.destroy', $paymentMethod->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('paymentMethods.view')
                                                <a href="{{ route('admin.paymentMethods.show',['paymentMethod'=>$paymentMethod->id]) }}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('paymentMethods.update')
                                                <a href="{{ route('admin.paymentMethods.edit',['paymentMethod'=>$paymentMethod->id]) }}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('paymentMethods.delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Payment Method Name</th>
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
                title: @json(__('Delete Payment Method')),
                text: @json(__('Are you sure you want to delete this?')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('Delete')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                if (result.value) {
                    // Trigger the form submission
                    form.submit();
                }
            });
        }

        $(document).ready(function() {
            $("#paymentMethodsList").DataTable({
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
