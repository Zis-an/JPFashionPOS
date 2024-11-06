@extends('adminlte::page')

@section('title', 'Update Warehouse')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Warehouse</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.warehouses.index') }}">Warehouses</a></li>
                <li class="breadcrumb-item active">Update Warehouse</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.warehouses.update', ['warehouse' => $warehouse->id]) }}" method="POST" enctype="multipart/form-data" id="warehouse-form">
                        @method('PUT')
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
                                    <input id="name" name="name" value="{{ $warehouse->name ?? '' }}" class="form-control" placeholder="Enter warehouse name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input id="address" name="address" value="{{ $warehouse->address ?? '' }}" class="form-control" placeholder="Enter warehouse address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" value="{{ $warehouse->phone ?? '' }}" type="tel" class="form-control" placeholder="Enter warehouse phone number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ $warehouse->email ?? '' }}" class="form-control" placeholder="Enter warehouse email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active" {{ $warehouse->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $warehouse->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @can('warehouses.update')
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

@section('plugins.toastr', true)

@section('css')
@stop

@section('js')
@stop
