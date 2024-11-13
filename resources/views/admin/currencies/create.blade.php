@extends('adminlte::page')
@section('title', 'Create Currency')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Currency</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.currencies.index')}}">Currencies</a></li>
                <li class="breadcrumb-item active">Create Currency</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.currencies.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="code">Code <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="code" name="code" class="form-control" placeholder="Enter code" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="Enter name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rate">Rate <span class="text-danger font-weight-bolder">*</span></label>
                                    <input type="number" id="rate" name="rate" class="form-control" placeholder="Enter rate" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="suffix">Suffix </label>
                                    <input type="text" id="suffix" name="suffix" class="form-control" placeholder="Enter suffix">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prefix">Prefix </label>
                                    <input type="text" id="prefix" name="prefix" class="form-control" placeholder="Enter prefix">
                                </div>
                            </div>
                        </div>

                        @can('currencies.create')
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
