@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Customer</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item active">Create Customer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.customers.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">Name</label>
                                    <input id="name" name="name" class="form-control" placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" type="tel" class="form-control" placeholder="Enter phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Enter address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth (DOB)</label>
                                    <input id="dob" name="dob" type="date" class="form-control" placeholder="Enter date of birth">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="anniversary_date">Anniversary Date</label>
                                    <input id="anniversary_date" name="anniversary_date" type="date" class="form-control" placeholder="Enter anniversary date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_date">Registration Date</label>
                                    <input id="registration_date" name="registration_date" type="date" class="form-control" placeholder="Enter registration date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <!-- Button to add new family details section -->
                                    <div class="d-flex justify-content-start mt-4" style="padding-top: 8px;">
                                        <button type="button" id="add-family-details" class="btn btn-primary">Add Family Members</button>
                                    </div>
                                    <!-- Container for family details -->
                                    <div id="family-details-container" class="mt-2 col-12"></div>
                                </div>
                            </div>

                        </div>

                        @can('customers.create')
                            <button class="btn btn-success" type="submit">Create</button>
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
    <script>
        document.getElementById('add-family-details').addEventListener('click', function() {
            const container = document.getElementById('family-details-container');

            // Create a new div for the family details section
            const newSection = document.createElement('div');

            newSection.classList.add('row');

            // Add HTML for the family details fields
            newSection.innerHTML = `
        <div class="col-4">
            <div class="form-group">
                <label for="relation_type">Relation Type</label>
                <select name="relation_type[]" class="form-control input-sm" >
                    <option value="spouse">Spouse</option>
                    <option value="child">Child</option>
                    <option value="parent">Parent</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="family_name">Name</label>
                <input type="text" name="family_name[]" class="form-control input-sm" placeholder="Enter name">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="family_age">Age</label>
                <input type="number" name="family_age[]" class="form-control input-sm" placeholder="Enter age">
            </div>
        </div>
        <div class="col-1 align-self-end form-group">
<!--            <span class="remove-family-details">&times;</span>-->
            <span class="btn btn-danger remove-family-details">&times;</span>
        </div>
    `;

            // Append the new section to the container
            container.appendChild(newSection);

            // Add event listener to the remove button
            newSection.querySelector('.remove-family-details').addEventListener('click', function() {
                newSection.remove();
            });
        });
    </script>
@stop
