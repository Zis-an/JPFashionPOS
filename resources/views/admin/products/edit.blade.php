@extends('adminlte::page')
@section('title', 'Update Product')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Product</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Update Product</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.products.update', ['product'=>$product->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">Name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" value="{{ $product->name }}" class="form-control" placeholder="Enter name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Select Category <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="category_id" name="category_id" class="select2 form-control" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="details">Details</label>
                                    <textarea id="summernote" name="details" class="form-control">{{ $product->details }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea id="summernote2" name="short_description" class="form-control">{{ $product->short_details }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="category">Select Unit</label>
                                    <select id="unit_id" name="unit_id" class="select2 form-control">
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">SKU</label>
                                    <input id="sku" name="sku" value="{{ $product->sku }}" class="form-control" placeholder="Enter product sku">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="width">Width</label>
                                    <small class="text-danger font-weight-bold ml-1">(Insert Width In Inch)</small>
                                    <input id="width" name="width" value="{{ $product->width }}" type="number" class="form-control" placeholder="Enter product width">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="length">Length</label>
                                    <small class="text-danger font-weight-bold ml-1">(Insert Length In Inch)</small>
                                    <input id="length" name="length" value="{{ $product->length }}" type="number" class="form-control" placeholder="Enter product length">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="density">Density</label>
                                    <small class="text-danger font-weight-bold ml-1">(Insert Density In Inch)</small>
                                    <input id="density" name="density" value="{{ $product->density }}" type="number" class="form-control" placeholder="Enter product density">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_images">Product Images</label>
                                    <input name="old_product_images" value="{{ $product->images }}" class="d-none">
                                    <input name="product_images[]" value="{{ $product->images }}" type="file" class="form-control" id="product_images" multiple>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_thumbnail">Product Thumbnail</label>
                                    <input name="old_thumbnail" value="{{ $product->thumbnail }}" class="d-none">
                                    <input name="thumbnail" value="{{ $product->thumbnail }}" type="file" class="form-control" id="product_thumbnail">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 d-flex flex-wrap gap-2" id="image-preview-row">
                                @foreach(json_decode($product->images) as $key => $image)
                                    <div class="image-container" id="image-{{ $key }}">
                                        <img src="{{ asset('uploads/' . $image) }}" alt="Product Image" />
                                        <button class="btn-overlay delete-image" data-image="{{ $image }}"
                                                data-key="{{ $key }}" data-product-id="{{ $product->id }}" type="button">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6 d-flex flex-wrap gap-2" id="thumb-preview-row">
                                <div class="image-container" id="product-thumbnail">
                                    <img src="{{ asset('uploads/' . $product->thumbnail) }}" alt="Product Thumbnail" />
                                    <button class="btn-overlay delete-thumbnail" data-product-id="{{ $product->id }}" type="button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @can('products.update')
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

@section('plugins.toastr', true)
@section('plugins.Select2', true)
@section('plugins.Summernote', true)

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
            margin: 0 auto; /* Center horizontally */
            padding: 5px; /* Add padding inside the border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow */
            transition: opacity 0.3s ease;
        }

        .image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 10px; /* This adds a vertical gap */
            margin-right: 10px;  /* This adds a horizontal gap */
        }

        .image-container img {
            max-height: 150px; /* Limit the height of images */
            border: 2px solid #ddd;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin: 0 auto; /* Center horizontally */
        }

        .btn-overlay {
            position: absolute;
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Adjust to center */
            background-color: transparent; /* Make background transparent */
            border: none; /* Remove border */
            cursor: pointer;
            color: white; /* Trash icon color */
            font-size: 24px; /* Increase size of icon */
            display: none; /* Hide by default */
        }

        .image-container:hover .btn-overlay {
            display: block; /* Show button on hover */
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

            // Common Summernote configuration
            function initializeSummernote(selector) {
                $(selector).summernote({
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
            }

            // Initialize Summernote for both textareas
            initializeSummernote('#summernote');
            initializeSummernote('#summernote2');

            // Product Multiple Image Handling
            const photoInput = document.getElementById('product_images');
            const imagePreviewRow = document.getElementById('image-preview-row');
            let selectedFiles = []; // To keep track of selected files

            // Handle file input change event for new images
            photoInput.addEventListener('change', function () {
                const files = Array.from(this.files);
                selectedFiles = [...selectedFiles, ...files]; // Update the selected files

                // Clear existing previews and show all selected files
                // imagePreviewRow.innerHTML = ''; // Clear existing previews
                selectedFiles.forEach((file, index) => {
                    const imageUrl = URL.createObjectURL(file);

                    // Create a wrapper for the image and button
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');

                    const img = document.createElement('img');
                    img.src = imageUrl;

                    const btn = document.createElement('button');
                    btn.classList.add('btn-overlay');
                    btn.innerHTML = '<i class="fas fa-trash"></i>'; // Font Awesome trash icon

                    // Add click event to remove the image
                    btn.addEventListener('click', function() {
                        imgContainer.remove(); // Remove the image container
                        selectedFiles.splice(index, 1); // Remove the file from the array

                        // Create a new DataTransfer to hold the remaining files
                        const dataTransfer = new DataTransfer();
                        selectedFiles.forEach(file => {
                            dataTransfer.items.add(file); // Add remaining files back to the DataTransfer
                        });
                        photoInput.files = dataTransfer.files; // Update the input's FileList
                    });

                    // Append the image and button to the container
                    imgContainer.appendChild(img);
                    imgContainer.appendChild(btn);
                    // Append the container to the preview row
                    imagePreviewRow.appendChild(imgContainer);
                });
            });

            // Handle existing image deletion
            document.querySelectorAll('#image-preview-row .btn-overlay').forEach(btn => {
                btn.addEventListener('click', function() {
                    const imgContainer = this.parentElement; // Get the parent container
                    const imageToDelete = this.getAttribute('data-image'); // Get image path

                    // Optionally, perform an AJAX call to delete the image from the server

                    imgContainer.remove(); // Remove the image container from display
                });
            });

            // Product single thumbnail upload handling
            const thumbnailInput = document.getElementById('product_thumbnail');
            const thumbnailPreviewRow = document.getElementById('thumb-preview-row');

            // Handle file input change event for thumbnail
            thumbnailInput.addEventListener('change', function () {
                thumbnailPreviewRow.innerHTML = ''; // Clear existing previews

                const files = this.files;
                if (files.length > 0) {
                    const file = files[0];
                    const imageUrl = URL.createObjectURL(file);

                    // Create a wrapper for the thumbnail and button
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');

                    const img = document.createElement('img');
                    img.src = imageUrl;

                    const btn = document.createElement('button');
                    btn.classList.add('btn-overlay');
                    btn.innerHTML = '<i class="fas fa-trash"></i>'; // Font Awesome trash icon

                    // Add click event to remove the image
                    btn.addEventListener('click', function() {
                        imgContainer.remove(); // Remove the image container
                        thumbnailInput.value = ''; // Clear the input value
                    });

                    // Append the image and button to the container
                    imgContainer.appendChild(img);
                    imgContainer.appendChild(btn);
                    // Append the container to the preview row
                    thumbnailPreviewRow.appendChild(imgContainer);
                }
            });

            // Handle existing thumbnail deletion
            document.querySelectorAll('#thumb-preview-row .btn-overlay').forEach(btn => {
                btn.addEventListener('click', function() {
                    const imgContainer = this.parentElement; // Get the parent container
                    const thumbnailToDelete = this.getAttribute('data-thumbnail'); // Get thumbnail path

                    // Optionally, perform an AJAX call to delete the thumbnail from the server

                    imgContainer.remove(); // Remove the thumbnail container from display
                    thumbnailInput.value = ''; // Clear the input value
                });
            });
        });
    </script>

    <!-- Product Image Deletion Script -->
    <script>
        $('.delete-image').on('click', function (event) {
            event.preventDefault();

            const productImageId = $(this).data('product-id');
            const key = $(this).data('key');
            const imageElement = $('#image-' + key);

            console.log("Product Image ID:", productImageId);
            console.log("Key:", key)

            $.ajax({
                url: '/admin/products/' + productImageId + '/image/' + key,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Send CSRF token
                },
                success: function(response) {
                    // Check the response message and remove the image from the DOM
                    if (response.message === 'Image deleted successfully') {
                        imageElement.remove(); // Remove the image container from the DOM
                    } else {
                        alert(response.message); // Display the error message
                    }
                },
                error: function(xhr) {
                    // Handle any errors from the AJAX request
                    alert('Error occurred: ' + xhr.responseJSON.message);
                }
            });
        });
    </script>

    <!-- Product Thumbnail Deletion Script -->
    <script>
        $(document).on('click', '.delete-thumbnail', function (event) {
            event.preventDefault();

            const productId = $(this).data('product-id'); // Retrieve the product ID
            const imageContainer = $(this).closest('.image-container'); // Get the parent image container

            console.log("Product ID:", productId);

            $.ajax({
                url: '/admin/products/' + productId + '/thumbnail', // Correct URL
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Send CSRF token
                },
                success: function(response) {
                    // Check the response message and remove the image from the DOM
                    if (response.message === 'Thumbnail deleted successfully') {
                        imageContainer.remove(); // Remove the image container from the DOM
                    } else {
                        alert(response.message); // Display the error message
                    }
                },
                error: function(xhr) {
                    // Handle any errors from the AJAX request
                    alert('Error occurred: ' + xhr.responseJSON.message);
                }
            });
        });
    </script>
@stop
