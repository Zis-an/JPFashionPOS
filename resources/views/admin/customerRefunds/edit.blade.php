@extends('adminlte::page')
@section('title', 'Update Customer Refund')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Customer Refund</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.customer-refunds.index') }}">Customer Refund</a></li>
                <li class="breadcrumb-item active">Update Customer Refund</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.customer-refunds.update',['customer_refund'=>$refund->id]) }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="customer_id">Select Customer <span class="text-danger font-weight-bolder">*</span></label>
                                    <select name="customer_id" class="select2 form-control" id="role" readonly>
                                        @if(!empty($customers))
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $refund->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option>No customer available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_id">Select Account <span class="text-danger font-weight-bolder">*</span></label>
                                    <select name="account_id" class="select2 form-control" id="role" readonly>
                                        @if(!empty($accounts))
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ $refund->account_id == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option>No account available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="amount" name="amount" value="{{ $refund->amount }}" type="number" class="form-control"
                                           placeholder="Enter amount" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="date" name="date" type="date" value="{{ $refund->date }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="refund_by">Refund By</label>
                                    <input id="refund_by" name="refund_by" value="{{ $refund->refund_by }}" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="details">Details</label>
                                    <textarea name="details" id="summernote" class="form-control">{{ $refund->details }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Select photo</label>
                                    <input name="old_photo" value="{{ asset($refund->image) ?? '' }}" class="d-none">
                                    <input name="photo" type="file" class="form-control" id="photo">
                                </div>
                                @if($refund->image)
                                    <div class="form-group mb-2">
                                        <img src="{{ asset($refund->image) }}" alt="Selected Image" id="selected-image">
                                    </div>
                                @endif
                            </div>
                            @can('customerRefunds.updateStatus')
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Select Status <span class="text-danger font-weight-bolder">*</span></label>
                                        <select id="status" name="status" class="select2 form-control" required>
                                            <option value="pending" {{ $refund->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="rejected" {{ $refund->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="approved" {{ $refund->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        </select>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        @can('customerRefunds.update')
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
        $('.select2').select2({
            theme: "classic"
        });

        const selectedImage = document.getElementById('selected-image');
        const photoInput = document.getElementById('photo');

        // Display existing photo only if selectedImage element exists
        if (selectedImage) {
            function displayExistingPhoto() {
                const existingPhotoUrl = '{{ asset($refund->images) }}';
                if (existingPhotoUrl) {
                    selectedImage.src = existingPhotoUrl;
                    selectedImage.style.display = 'block';
                } else {
                    selectedImage.style.display = 'none';
                }
            }
            displayExistingPhoto();
        }

        // Handle file input change event
        if (photoInput && selectedImage) {
            photoInput.addEventListener('change', function() {
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
        }

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
