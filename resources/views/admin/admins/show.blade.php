@extends('adminlte::page')

@section('title', 'view Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Admin - {{$admin->name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.admins.index')}}">Admins</a></li>
                <li class="breadcrumb-item active">View Admin</li>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input id="name" name="name" class="form-control" placeholder="Enter full name" value="{{ $admin->name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input id="email" name="email" class="form-control" placeholder="Enter email address" value="{{ $admin->email ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <div class="image-container">
                                            <img src="{{ getAssetUrl($admin->photo,$admin->photo,'male')}}" alt="{{ $admin->photo ?? '' }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Roles</label>
                                        <div>
                                            @foreach($admin->roles as $role)
                                                <span class="badge badge-primary badge-pill">{{ ucfirst($role->name ?? '') }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <div>
                                            <span class="badge badge-secondary badge-pill">{{ ucfirst($admin->status ?? '') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.admins.index')}}" class="btn btn-success" >Go Back</a>
                            @can('admins.update')
                                <a href="{{route('admin.admins.edit',['admin'=>$admin->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('admins.delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
@section('plugins.Sweetalert2', true)
@section('css')
    <style>
        .badge {
            font-size: 1rem; /* Adjust font size if needed */
            padding: 0.5em 1em; /* Add padding for a better look */
        }

        .badge-primary {
            background-color: #007bff; /* Customize color as needed */
            color: white;
        }

        .badge-secondary {
            background-color: #6c757d; /* Customize color as needed */
            color: white;
        }

        .image-container {
            max-width: 100%; /* Ensure the container doesn't exceed its parent */
            text-align: left; /* Align the image to the left */
        }

        .image-container img {
            max-height: 200px; /* Limit the height of the image */
            width: auto; /* Maintain aspect ratio */
            border: 2px solid #ddd; /* Add a border around the image */
            border-radius: 8px; /* Round the corners */
            margin-bottom: 15px; /* Add margin to separate from other content */
        }
    </style>
@stop

@section('js')
    <script>
        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete Admin')),
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
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
