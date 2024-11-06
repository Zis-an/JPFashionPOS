@extends('adminlte::page')
@section('title', 'Update Employee')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Employee</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Employees</a></li>
                <li class="breadcrumb-item active">Update Employee</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.employees.update',['employee'=>$employee->id]) }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="Enter employee name" value="{{ $employee->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Enter employee email"
                                           value="{{ $employee->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" type="tel" class="form-control" placeholder="Enter phone number" value="{{ $employee->phone }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea id="address" name="address" class="form-control" placeholder="Enter employee address">{{ $employee->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <input id="date_of_birth" name="date_of_birth" type="date" class="form-control" value="{{ $employee->date_of_birth }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hire_date">Hire Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="hire_date" name="hire_date" type="date" class="form-control" value="{{ $employee->hire_date }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="position">Position <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="position" name="position" class="form-control" placeholder="Enter employee position"
                                           value="{{ $employee->position }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department">Department <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="department" name="department_id" class="select2 form-control" required>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ $department->id == $employee->department_id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="education_level">Education Level</label>
                                    <input id="education_level" name="education_level" type="text" class="form-control"
                                           placeholder="Enter employee education level" value="{{ $employee->education_level }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select id="gender" name="gender" class="form-control">
                                        <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ $employee->gender == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nid">National ID (NID) <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="nid" name="nid" type="number" class="form-control" placeholder="Enter employee NID"
                                           value="{{ $employee->nid }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="salary">Salary <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="salary" name="salary" type="number" step="0.01" class="form-control" placeholder="Enter salary"
                                           value="{{ $employee->salary }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="service_days">Service Days <span class="text-danger font-weight-bolder">*</span></label>
                                    <small class="text-danger">(in years)</small>
                                    <input id="service_days" name="service_days" type="number"
                                           class="form-control" placeholder="Enter service days" value="{{ $employee->service_days }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $employee->status == 'deactivate' ? 'selected' : '' }}>Inactive</option>
                                        <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ed_certificate">Education Certificate</label>
                                    <input name="old_photo" value="" class="d-none">
                                    <input name="photo[]" type="file" class="form-control" id="photo" multiple>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-start gy-2 my-2" id="image-preview-row">
                            @if($employee->ed_certificate)
                                @foreach(json_decode($employee->ed_certificate) as $key => $certificate)
                                    <div class="position-relative col-lg-2 col-md-3 col-sm-4 col-6">
                                        <img src="{{ asset($certificate) }}" alt="" id="image-{{ $key }}" class="img-fluid img-thumbnail h-100">
                                        <a href="#" class="delete-image badge badge-danger position-absolute"
                                           data-employee-id="{{ $employee->id }}" data-id="{{ $key }}"
                                           style="top: 0; right: 7px;">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @can('employees.update')
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

@stop

@section('js')
    <script>
        $(document).ready(function () {

            $('.select2').select2({
                theme: "classic"
            });

            const imagePreviewRow = document.getElementById('image-preview-row');
            const photoInput = document.getElementById('photo'); // Assuming your input field has id 'photo'

            // Handle new image uploads
            photoInput.addEventListener('change', function () {
                const files = this.files;

                // Loop through each selected file
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const imageUrl = URL.createObjectURL(file);

                    // Create a new div container for the image
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('position-relative', 'col-lg-2', 'col-md-3', 'col-sm-4', 'col-6');

                    // Create the image element
                    const img = document.createElement('img');
                    img.src = imageUrl;
                    img.classList.add('img-fluid', 'img-thumbnail', 'h-100');  // Same classes used for existing images

                    // Create the delete button
                    const deleteButton = document.createElement('a');
                    deleteButton.href = '#';
                    deleteButton.classList.add('delete-image', 'badge', 'badge-danger', 'position-absolute');
                    deleteButton.style.top = '0';
                    deleteButton.style.right = '7px';
                    deleteButton.innerHTML = '<i class="fas fa-times"></i>';

                    // Add event listener to delete the image container when clicked
                    deleteButton.addEventListener('click', function (event) {
                        event.preventDefault(); // Prevent default link behavior

                        if (confirm('Are you sure you want to remove this image?')) {
                            // Remove the parent container (the image and the delete button)
                            imageContainer.remove();
                        }
                    });

                    // Append the image and delete button to the container
                    imageContainer.appendChild(img);
                    imageContainer.appendChild(deleteButton);

                    // Append the container to the preview row
                    imagePreviewRow.appendChild(imageContainer);
                }
            });

            $('.delete-image').on('click', function (event) {
                event.preventDefault(); // Prevent the default link behavior

                const employeeId = $(this).data('employee-id');
                const key = $(this).data('id');
                const imageElement = $('#image-' + key);

                // Check if employeeId and key are being retrieved correctly
                console.log("Employee ID:", employeeId);
                console.log("Key:", key);

                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: `/admin/employees/${employeeId}/delete_certificate/${key}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // CSRF token
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in headers
                        },
                        success: function (response) {
                            // Remove the image element from the DOM
                            imageElement.remove();
                            alert(response.message); // Show success message
                        },
                        error: function (xhr) {
                            alert('An error occurred while deleting the image.'); // Show error message
                        }
                    });
                }
            });
        });
    </script>
@stop
