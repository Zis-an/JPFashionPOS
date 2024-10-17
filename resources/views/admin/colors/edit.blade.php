@extends('adminlte::page')

@section('title', 'Update Color')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Color</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.colors.index') }}">Colors</a></li>
                <li class="breadcrumb-item active">Update Color</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.colors.update',['color'=>$color->id]) }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @method('PUT')
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
                                    <label for="code">Color Code</label>
                                    <input id="code" name="color_code" value="{{ $color->color_code ?? '' }}" class="form-control" placeholder="Enter color code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Color Name</label>
                                    <input id="name" name="name" value="{{ $color->color_name ?? '' }}" class="form-control" placeholder="Enter color name">
                                </div>
                            </div>
                        </div>
                        @can('colors.update')
                            <button class="btn btn-success" type="submit">Update</button>
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
