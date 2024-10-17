@extends('adminlte::page')

@section('title', 'Update Permission')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Permission - {{$permission->name}}</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.permissions.index')}}">Permissions</a></li>
                <li class="breadcrumb-item active">Update Permission</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.permissions.update',['permission'=>$permission->id])}}" method="POST">
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
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" value="{{$permission->name}}" required class="form-control" id="name" placeholder="Enter permission name">
                        </div>
                        <div class="form-group">
                            <label for="guard">Guard</label>
                            <input value="{{$permission->guard_name}}" placeholder="Enter guard name" name="guard_name" id="guard" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <input type="text" name="group_name" required value="{{$permission->group_name}}" class="form-control" id="group" placeholder="Enter group name">
                        </div>
                        @can('permissions.update')
                            <button class="btn btn-primary" type="submit">Update</button>
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
@section('toastr',true)
@section('css')

@stop

@section('js')


@stop
