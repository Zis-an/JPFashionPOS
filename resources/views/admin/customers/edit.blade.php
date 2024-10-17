@extends('adminlte::page')

@section('title', 'Edit Customer')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Customer - {{ $customer->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item active">Edit Customer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @method('PUT')
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
                                    <input id="name" name="name" value="{{ old('name', $customer->name) }}" class="form-control" placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $customer->phone) }}" class="form-control" placeholder="Enter phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $customer->email) }}" class="form-control" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input id="address" name="address" type="text" value="{{ old('address', $customer->address) }}" class="form-control" placeholder="Enter address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth (DOB)</label>
                                    <input id="dob" name="dob" type="date" value="{{ old('dob', $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('Y-m-d') : '') }}" class="form-control" placeholder="Enter date of birth">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="anniversary_date">Anniversary Date</label>
                                    <input id="anniversary_date" name="anniversary_date" type="date" value="{{ old('anniversary_date', $customer->anniversary_date ? \Carbon\Carbon::parse($customer->anniversary_date)->format('Y-m-d') : '') }}" class="form-control" placeholder="Enter anniversary date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_date">Registration Date</label>
                                    <input id="registration_date" name="registration_date" type="date" value="{{ old('registration_date', $customer->registration_date ? \Carbon\Carbon::parse($customer->registration_date)->format('Y-m-d') : '') }}" class="form-control" placeholder="Enter registration date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="d-flex justify-content-start mt-4" style="padding-top: 8px;">
                                        <button type="button" id="add-family-details" class="btn btn-primary">Add Family Members</button>
                                    </div>
                                    <div id="family-details-container" class="mt-2 col-12">
                                        @if(!empty($customer->family_details))
                                            @php
                                                $familyDetails = json_decode($customer->family_details, true);
                                                $relations = $familyDetails['relation_type'] ?? [];
                                                $names = $familyDetails['family_name'] ?? [];
                                                $ages = $familyDetails['family_age'] ?? [];
                                            @endphp

                                            @foreach($relations as $index => $relation)
                                                @php
                                                    $uniqueId = 'family-member-' . ($index + 1); // Generate a unique ID based on the index or any other unique property
                                                @endphp
                                                <div id="{{ $uniqueId }}" class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="relation_type">Relation Type</label>
                                                            <select name="relation_type[]" class="form-control input-sm">
                                                                <option value="spouse" {{ $relation == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                                                <option value="child" {{ $relation == 'child' ? 'selected' : '' }}>Child</option>
                                                                <option value="parent" {{ $relation == 'parent' ? 'selected' : '' }}>Parent</option>
                                                                <!-- Add more options as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="family_name">Name</label>
                                                            <input type="text" name="family_name[]" class="form-control input-sm" value="{{ $names[$index] ?? '' }}" placeholder="Enter name">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="family_age">Age</label>
                                                            <input type="number" name="family_age[]" class="form-control input-sm" value="{{ $ages[$index] ?? '' }}" placeholder="Enter age">
                                                        </div>
                                                    </div>
                                                    <div class="col-1 align-self-end form-group">
                                                        <span class="btn btn-danger remove-family-details" data-id="{{ $uniqueId }}">&times;</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('customers.update')
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
        <b>version</b> {{ env('DEV_VERSION') }}
    </div>
@stop

@section('plugins.toastr', true)
@section('css')

@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add event listener for adding new family members
            document.getElementById('add-family-details').addEventListener('click', function() {
                const container = document.getElementById('family-details-container');

                // Generate a unique ID for the new section
                const uniqueId = 'family-member-' + Date.now();

                // Create a new div for the family details section
                const newSection = document.createElement('div');
                newSection.id = uniqueId;
                newSection.classList.add('row');

                // Add HTML for the family details fields
                newSection.innerHTML = `
                    <div class="col-4">
                        <div class="form-group">
                            <label for="relation_type">Relation Type</label>
                            <select name="relation_type[]" class="form-control input-sm">
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
                        <span class="btn btn-danger remove-family-details" data-id="${uniqueId}">&times;</span>
                    </div>
                `;

                // Append the new section to the container
                container.appendChild(newSection);
            });

            // Add event listener for removing family members
            document.getElementById('family-details-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-family-details')) {
                    const sectionId = event.target.getAttribute('data-id');
                    const section = document.getElementById(sectionId);

                    if (section) {
                        section.remove();
                    }
                }
            });
        });
    </script>
@stop
