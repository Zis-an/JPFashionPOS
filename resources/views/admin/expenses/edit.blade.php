@extends('adminlte::page')
@section('title', 'Update Expense')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Expense</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.expenses.index') }}">Expenses</a></li>
                <li class="breadcrumb-item active">Update Expense</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.expenses.update', ['expense' => $expense->id]) }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="title">Title <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="title" name="title" value="{{ $expense->title ?? '' }}" class="form-control"
                                           placeholder="Enter title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Select Category <span class="text-danger font-weight-bolder">*</span></label>
                                    <select name="category_id" class="select2 form-control" id="category_id" required>
                                        @if(!empty($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $expense->expense_category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option>No category available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_id">Select Account <span class="text-danger font-weight-bolder">*</span></label>
                                    <select name="account_id" class="select2 form-control" id="role" required>
                                        @if(!empty($accounts))
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ $expense->account_id == $account->id ? 'selected' : '' }}
                                                    {{ $account->status == 'deactivate' ? 'disabled' : '' }}>
                                                    {{ $account->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option>No account available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input id="amount" name="amount" value="{{ $expense->amount }}" type="number" class="form-control" placeholder="Enter amount">
                                </div>
                            </div>
                            @can('expenses.updateStatus')
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Select Status <span class="text-danger font-weight-bolder">*</span></label>
                                        <select id="status" name="status" class="select2 form-control" required>
                                            <option value="pending" {{ $expense->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="rejected" {{ $expense->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="approved" {{ $expense->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        </select>
                                    </div>
                                </div>
                            @endcan
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="details">Details</label>
                                    <textarea name="details" id="summernote" class="form-control">{{ $expense->details ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Select photo</label>
                                    <input name="old_photo" value="{{ asset($expense->images) ?? '' }}" class="d-none">
                                    <input name="photo" type="file" class="form-control" id="photo">
                                </div>
                                <div class="form-group mb-2">
                                    <img src="{{ asset($expense->images) }}" alt="Selected Image" id="selected-image">
                                </div>
                            </div>
                        </div>
                        @can('accounts.update')
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
@section('plugins.Select2', true)
@section('plugins.Summernote', true)
@section('css')
    <style>
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
            // Initialize Select2
            $('.select2').select2({
                theme: "classic"
            });

            const imageForm = document.getElementById('admin-form');
            const selectedImage = document.getElementById('selected-image');
            const photoInput = document.getElementById('photo');

            // Display existing photo on page load
            function displayExistingPhoto() {
                const existingPhotoUrl = '{{ asset($expense->images) }}';
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

            // Initialize Summernote
            $('#summernote').summernote({
                height: 200, // Set the height of the editor
                placeholder: 'Enter details here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@stop


