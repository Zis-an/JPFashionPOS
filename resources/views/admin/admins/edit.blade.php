@extends('adminlte::page')
@section('title', 'Update Admin')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Admin</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.admins.index')}}">Admins</a></li>
                <li class="breadcrumb-item active">Update Admin</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.admins.update',['admin'=>$admin->id]) }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">Full name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" value="{{ $admin->name ?? '' }}" class="form-control" placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email address <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="email" name="email" value="{{ $admin->email ?? '' }}" class="form-control" placeholder="Enter email address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Enter password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm password <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Select roles <span class="text-danger font-weight-bolder">*</span></label>
                                    <select name="roles[]" class="select2 form-control" id="role" multiple="true" required>
                                        <option value="">Select roles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" @if(checkAdminRole($admin,$role->name)) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Select status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($admin->status == 'active') selected @endif>Active</option>
                                        <option value="deactivate" @if($admin->status == 'deactivate') selected @endif>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Select photo</label>
                                    <input name="old_photo" value="{{ $admin->photo ?? '' }}" class="d-none">
                                    <input name="photo" type="file" class="form-control" id="photo">
                                </div>
                                <div class="form-group mb-2">
                                    <img src="{{ getAssetUrl($admin->photo,$admin->photo,'male') }}" alt="Selected Image" id="selected-image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Select Type</label>
                                    <select id="type" name="type" class="select2 form-control">
                                        <option value="salesman"{{ $admin->type == 'salesman' ? 'selected' : '' }}>Salesman</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @can('admins.update')
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
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
        }

        #selected-image {
            max-height: 150px;
            border: 2px solid #ddd;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin: 10px 0; /* Center horizontally */
            padding: 5px; /* Add padding inside the border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow */
            transition: opacity 0.3s ease;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 37px; /* Set to your desired height */
            user-select: none;
            -webkit-user-select: none;
        }

        /* Adjust the line-height of the rendered text inside Select2 */
        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 34px; /* Adjust line height */
        }

        /* Style the Select2 arrow and set its height */
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            background-color: #ddd;
            border: none;
            border-left: 1px solid #aaa;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            height: 35px; /* Set height for the arrow */
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            background-image: -webkit-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: -o-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: linear-gradient(to bottom, #eeeeee 50%, #cccccc 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0);
        }

        @media (max-width: 767px) {
            #selected-image {
                max-height: 120px; /* Reduce height on smaller screens */
            }
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "classic"
            });

            const imageForm = document.getElementById('admin-form');
            const selectedImage = document.getElementById('selected-image');
            const photoInput = document.getElementById('photo');

            // Display existing photo on page load
            function displayExistingPhoto() {
                const existingPhotoUrl = '{{ getAssetUrl($admin->photo,$admin->photo,'male') }}';
                if (existingPhotoUrl) {
                    selectedImage.src = existingPhotoUrl;
                    selectedImage.style.display = 'block';
                } else {
                    selectedImage.style.display = 'none';
                }
            }

            // Initialize existing photo display
            displayExistingPhoto();

            // Handle file input change event
            photoInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const imageUrl = URL.createObjectURL(file);
                    selectedImage.src = imageUrl;
                    selectedImage.style.display = 'block';
                } else {
                    selectedImage.src = '';
                    selectedImage.style.display = 'none';
                }
            });
        });
    </script>
@stop
