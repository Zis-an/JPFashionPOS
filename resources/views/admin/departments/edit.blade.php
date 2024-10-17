@extends('adminlte::page')

@section('title', 'Update Department')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Department</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">Departments</a></li>
                <li class="breadcrumb-item active">Update Department</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.departments.update',['department'=>$department->id]) }}" method="POST"
                          enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">Department name</label>
                                    <input id="name" name="name" value="{{ $department->name ?? '' }}" class="form-control" placeholder="Enter department name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Select Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active" {{ $department->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="deactive" {{ $department->status == 'deactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @can('departments.update')
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
@section('plugins.Select2',true)
@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
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
