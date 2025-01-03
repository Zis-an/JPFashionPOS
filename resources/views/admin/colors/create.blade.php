@extends('adminlte::page')
@section('title', 'Colors')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Color</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.colors.index') }}">Colors</a></li>
                <li class="breadcrumb-item active">Create Color</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="code">Color Code <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="code" name="color_code" class="form-control" placeholder="Enter color code" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Color Name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="Enter color name" required>
                                </div>
                            </div>
                        </div>

                        @can('colors.create')
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
@section('css')

@stop

@section('js')

@stop
