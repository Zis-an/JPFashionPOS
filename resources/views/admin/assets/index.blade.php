@extends('adminlte::page')

@section('title', 'Assets')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Assets</h1>
            @can('assets.create')
                <a href="{{ route('admin.assets.create') }}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('assets.trashed')
                <a href="{{ route('admin.assets.trashed') }}" class="btn btn-danger mt-2">Trash List</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Assets</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('assets.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($assets as $asset)
                                <tr>
                                    <td>{{ $asset->name ?? '' }}</td>
                                    <td>{{ $asset->category->name ?? '' }}</td>
                                    <td>{{ $asset->account->name ?? '' }}</td>
                                    <td>{{ $asset->amount ?? '' }}</td>
                                    <td>{{ ucfirst($asset->status ?? '') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('assets.updateStatus')
                                                @if($asset->status == 'pending')
                                                    @can('assets.view')
                                                        <a href="{{ route('admin.assets.show',['asset'=>$asset->id]) }}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                                    @endcan
                                                    @can('assets.update')
                                                        <a href="{{ route('admin.assets.edit',['asset'=>$asset->id]) }}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                                    @endcan
                                                    @can('assets.delete')
                                                        <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                                    @endcan
                                                    <a href="{{ route('admin.assets.updateStatus', ['asset' => $asset->id, 'status' => 'approved']) }}"
                                                       class="btn btn-success btn-sm px-1 py-0">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="{{ route('admin.assets.updateStatus', ['asset' => $asset->id, 'status' => 'rejected']) }}"
                                                       class="btn btn-danger btn-sm px-1 py-0">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @elseif($asset->status == 'rejected')
                                                    <a href="{{ route('admin.assets.updateStatus', ['asset' => $asset->id, 'status' => 'pending']) }}"
                                                       class="btn btn-primary btn-sm px-1 py-0">
                                                        <i class="fas fa-arrow-alt-circle-left"></i>
                                                    </a>
                                                @elseif($asset->status == 'approved')
                                                    <a href="{{ route('admin.assets.updateStatus', ['asset' => $asset->id, 'status' => 'pending']) }}"
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
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Account</th>
                                <th>Amount</th>
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
                title: @json(__('Delete Asset')),
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
