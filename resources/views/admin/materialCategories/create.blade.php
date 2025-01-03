@extends('adminlte::page')
@section('title', 'Raw Material Categories')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Raw Material Category</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.materialCategories.index') }}">Raw Material Categories</a></li>
                <li class="breadcrumb-item active">Create Raw Material Category</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.materialCategories.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
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
                                    <label for="name">Name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="Enter name" required>
                                </div>
                            </div>
                        </div>
                        @can('materialCategories.create')
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
        <b>Version</b> {{ env('DEV_VERSION') }}
    </div>
@stop

@section('plugins.toastr', true)
@section('plugins.Select2', true)

@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
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
