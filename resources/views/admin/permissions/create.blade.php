@extends('adminlte::page')

@section('title', 'Create Permission')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Permission</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.permissions.index')}}">Permissions</a></li>
                <li class="breadcrumb-item active">Create Permission</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.permissions.store')}}" method="POST">
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
                            <input name="name" type="text" required class="form-control" id="name" placeholder="Enter permission name">
                        </div>
                        <div class="form-group">
                            <label for="guard">Guard</label>
                            <input name="guard_name" id="guard" value="admin" required placeholder="Enter guard name" class="form-control">


                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <input type="text" name="group_name" required  class="form-control" id="group" placeholder="Enter group name">
                        </div>
                        @can('permission_create')
                            <button class="btn btn-primary" type="submit">Create</button>
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
        <b>versions</b> {{env('DEV_VERSION')}}
    </div>
@stop
@section('toastr',true)
@section('css')

@stop

@section('js')


@stop
