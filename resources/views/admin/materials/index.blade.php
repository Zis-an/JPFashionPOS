@extends('adminlte::page')

@section('title', 'Raw Materials')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Raw Materials</h1>
            @can('materials.create')
                <a href="{{ route('admin.materials.create') }}" class="btn btn-primary mt-2">Add new</a>
            @endcan
            @can('materials.trashed')
                <a href="{{ route('admin.materials.trashed') }}" class="btn btn-danger mt-2">Trash List</a>
            @endcan
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Raw Materials</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('materials.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="categoriesList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>SKU</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>
                                        <img class="rounded border"
                                             width="100px"
                                             src="{{ getAssetUrl($material->image,$material->name) }}"
                                             alt="{{ $material->name }}">
                                    </td>
                                    <td>{{ $material->name ?? '' }}</td>
                                    <td>{{ $material->category->name ?? '' }}</td>
                                    <td>{{ $material->unit->name ?? '' }}</td>
                                    <td>{{ $material->sku ?? '' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('materials.view')
                                                <a href="{{ route('admin.materials.show', ['material' => $material->id]) }}"
                                                   class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('materials.update')
                                                <a href="{{ route('admin.materials.edit', ['material' => $material->id]) }}"
                                                   class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('materials.delete')
                                                <button onclick="isDelete(this)"
                                                        class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>SKU</th>
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
        <b>Version</b> {{ env('DEV_VERSION') }}
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
                title: @json(__('Delete Material')),
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
            $("#categoriesList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    { extend: 'copy', text: 'Copy' },
                    { extend: 'csv', text: 'Export CSV' },
                    { extend: 'excel', text: 'Export Excel' },
                    { extend: 'pdf', text: 'Export PDF' },
                    { extend: 'print', text: 'Print' },
                    { extend: 'colvis', text: 'Colvis' }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    paginate: {
                        first: "{{ __('First') }}",
                        previous: "{{ __('Previous') }}",
                        next: "{{ __('Next') }}",
                        last: "{{ __('Last') }}"
                    }
                }
            });
        });
    </script>
@stop
