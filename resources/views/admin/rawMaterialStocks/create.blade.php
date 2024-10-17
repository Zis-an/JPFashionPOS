@extends('adminlte::page')

@section('title', 'Raw Material Stocks')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Stocks</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.raw-material-stocks.index') }}">Raw Material Stocks</a></li>
                <li class="breadcrumb-item active">Create Stock</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.raw-material-stocks.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Select Raw Material</label>
                                    <select id="material_id" name="raw_material_id" class="select2 form-control">
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Quantity</label>
                                    <input id="quantity" type="number" name="quantity" class="form-control" placeholder="Enter quantity">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Select Color</label>
                                    <select id="color_id" name="color_id" class="select2 form-control">
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Select Brand</label>
                                    <select id="brand_id" name="brand_id" class="select2 form-control">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Select Size</label>
                                    <select id="size_id" name="size_id" class="select2 form-control">
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Price</label>
                                    <input id="price" type="number" name="price" class="form-control" placeholder="Enter price">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Select Warehouse</label>
                                    <select id="warehouse_id" name="warehouse_id" class="select2 form-control">
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @can('rawMaterialStocks.create')
                            <button class="btn btn-success" type="submit">Create</button>
                        @endcan
                    </form>
                </div>
            </div>
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
@section('plugins.toastr',true)
@section('plugins.Select2',true)
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
        });
    </script>
@stop
