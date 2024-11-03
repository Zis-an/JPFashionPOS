@extends('adminlte::page')
@section('title', 'Raw Material Stocks')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Raw Material Stocks</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Stocks</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('rawMaterialStocks.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <form method="GET" action="{{ route('admin.rawMaterialStockReports') }}" id="filterForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="materialFilter">Filter By Raw Material</label>
                                        <select id="materialFilter" name="materialId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            @foreach($rawMaterials as $material)
                                                <option value="{{ $material->id }}" {{ request('materialId') == $material->id ? 'selected' : '' }}>
                                                    {{ $material->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="warehouseFilter">Filter By Warehouse</label>
                                        <select id="warehouseFilter" name="warehouseId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            @foreach($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" {{ request('warehouseId') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="colorFilter">Filter By Color</label>
                                        <select id="colorFilter" name="colorId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}" {{ request('colorId') == $color->id ? 'selected' : '' }}>
                                                    {{ $color->color_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="brandFilter">Filter Brand</label>
                                        <select id="brandFilter" name="brandId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ request('brandId') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sizeFilter">Filter By Size</label>
                                        <select id="sizeFilter" name="sizeId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->id }}" {{ request('sizeId') == $size->id ? 'selected' : '' }}>
                                                    {{ $size->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="startDate">Start Date</label>
                                        <input type="date" id="startDate" name="startDate" class="form-control" value="{{ request('startDate') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="endDate">End Date</label>
                                        <input type="date" id="endDate" name="endDate" class="form-control" value="{{ request('endDate') }}">
                                    </div>
                                </div>
                            </div>
                            <!-- Filter button -->
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <button type="submit" class="btn btn-primary px-5">Filter</button>
                                </div>
                            </div>
                        </form>

                        <table id="adminsList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Warehouse</th>
                                <th>Color</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->raw_material->name ?? '' }}</td>
                                    <td>{{ $stock->quantity ?? '' }}</td>
                                    <td>{{ $stock->price ?? '' }}</td>
                                    <td>{{ $stock->warehouse->name ?? '' }}</td>
                                    <td>{{ $stock->color->color_name ?? '' }}</td>
                                    <td>{{ $stock->brand->name ?? '' }}</td>
                                    <td>{{ $stock->size->name ?? '' }}</td>
                                    <td>{{ $stock->created_at ? \Carbon\Carbon::parse($stock->created_at)->format('F j, Y') : '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Warehouse</th>
                                <th>Color</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Date</th>
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
@section('plugins.Select2',true)
@section('plugins.Sweetalert2', true)
@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color: black;
        }
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 37px; /* Set to your desired height */
            user-select: none;
            -webkit-user-select: none;
        }

        /* Adjust the line-height of the rendered text inside Select2 */
        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 34px; /* Adjust line height */
        }

        /* Style the Select2 arrow and set its height */
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            background-color: #ddd;
            border: none;
            border-left: 1px solid #aaa;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            height: 35px; /* Set height for the arrow */
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            background-image: -webkit-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: -o-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: linear-gradient(to bottom, #eeeeee 50%, #cccccc 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0);
        }
    </style>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "classic"
            });

            // Initialize DataTable
            var table = $("#sellList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
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
