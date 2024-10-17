@extends('adminlte::page')

@section('title', 'Update Production House')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Production House</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.houses.index') }}">Production Houses</a></li>
                <li class="breadcrumb-item active">Update House</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.houses.update', ['house' => $house->id]) }}" method="POST" enctype="multipart/form-data" id="showroom-form">
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
                                    <label for="name">Name</label>
                                    <input id="name" name="name" value="{{ $house->name ?? '' }}" class="form-control" placeholder="Enter house name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input id="address" name="address" value="{{ $house->address ?? '' }}" class="form-control" placeholder="Enter house address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" value="{{ $house->phone ?? '' }}" type="tel" class="form-control" placeholder="Enter house phone number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ $house->email ?? '' }}" class="form-control" placeholder="Enter house email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active" {{ $house->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $house->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @can('houses.update')
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
