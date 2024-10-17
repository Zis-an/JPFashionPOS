@extends('adminlte::page')

@section('title', 'View Permissions')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Permission - {{$permission->name}}</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.permissions.index')}}">Permissions</a></li>
                <li class="breadcrumb-item active">View Permission</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

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
                            <input name="name" type="text" value="{{$permission->name}}" disabled required class="form-control" id="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="guard">Guard</label>
                            <input type="text" name="guard_name" disabled required value="{{$permission->guard_name}}" class="form-control" id="guard" placeholder="Enter guard name">
                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <input type="text" name="group_name" disabled required value="{{$permission->group_name}}" class="form-control" id="group" placeholder="Enter group">
                        </div>
                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            @can('permissions.view')
                                <a href="{{route('admin.permissions.index')}}" class="btn btn-info px-1 py-0 btn-sm">Go Back</a>
                            @endcan
                            @can('permissions.update')
                                <a href="{{route('admin.permissions.edit',['permission'=>$permission->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                            @endcan
                            @can('permissions.delete')
                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
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
@section('plugins.Sweetalert2', true)
@section('css')

@stop

@section('js')
<script>
    function isDelete(button) {
        event.preventDefault();
        var row = $(button).closest("tr");
        var form = $(button).closest("form");
        Swal.fire({
            title: @json(__('Delete Permission')),
            text: @json(__('Are you sure you want to delete this?')),
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: @json(__('Delete')),
            cancelButtonText: @json(__('Cancel')),
        }).then((result) => {
            console.log(result)
            if (result.value) {
                // Trigger the form submission
                form.submit();
            }
        });
    }
</script>

@stop
