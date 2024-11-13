@extends('adminlte::page')
@section('title', 'Create Product Stock Transfer')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Product Stock Transfer</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.product-stock-transfers.index')}}">Product Stock Transfers</a></li>
                <li class="breadcrumb-item active">Create Product Stock Transfer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.product-stock-transfers.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="from_showroom_id">From Showroom <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="from_showroom_id" name="from_showroom_id" class="form-control select2" required>
                                        <option value="">Select Showroom</option>
                                        @foreach ($showrooms as $showroom)
                                            <option value="{{ $showroom->id }}">
                                                {{ $showroom->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="to_showroom_id">To Showroom <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="to_showroom_id" name="to_showroom_id" class="form-control select2" required>
                                        <option value="">Select Showroom</option>
                                        @foreach ($showrooms as $showroom)
                                            <option value="{{ $showroom->id }}">
                                                {{ $showroom->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Details</label>
                                    <textarea name="note" id="summernote" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Table for displaying product info and quantity input -->
                        <div class="row" id="product-table-container" style="display:none;">
                            <div class="col-12">
                                <input type="text" id="search-product" class="form-control" placeholder="Search for a product..." style="margin-bottom: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Transfer Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody id="product-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('productStockTransfers.create')
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

@section('plugins.toastr', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Summernote', true)
@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
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
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize all select2 dropdowns
            $('.select2').select2({
                theme: "classic"
            });

            // Cache the original options of the 'to_showroom_id' dropdown
            var originalToShowroomOptions = $('#to_showroom_id').html();

            // Listen for changes in the 'from_showroom_id' dropdown
            $('#from_showroom_id').on('change', function() {
                var selectedFromShowroomId = $(this).val();

                // Restore the original options to 'to_showroom_id'
                $('#to_showroom_id').html(originalToShowroomOptions);

                if (selectedFromShowroomId) {
                    // Remove the selected 'from' showroom option from 'to_showroom_id'
                    $('#to_showroom_id option[value="' + selectedFromShowroomId + '"]').remove();

                    // Fetch products for the selected showroom
                    $.ajax({
                        url: '/api/product-stocks/' + selectedFromShowroomId,
                        type: 'GET',
                        success: function(data) {
                            // Clear the previous options in the table
                            $('#product-table-body').empty();

                            // Check if there are products available
                            if (data.length > 0) {
                                // Show the product table container
                                $('#product-table-container').show();

                                // Populate the product table with fetched data
                                $.each(data, function(index, product) {
                                    $('#product-table-body').append(`
                                        <tr>
                                            <td><input type="checkbox" class="product-checkbox" name="selected_products[]" value="${product.id}"></td>
                                            <td>${product.product_name}</td>
                                            <td>${product.brand_name}</td>
                                            <td>${product.color_name}</td>
                                            <td>${product.size_name}</td>
                                            <td>${product.quantity}</td>
                                            <td>
                                                <input type="number" name="transfer_quantities[${product.id}]" class="form-control transfer-quantity"
                                                    min="1" max="${product.quantity}" disabled>
                                            </td>
                                        </tr>
                                    `);
                                });

                                // Add event listener for toggling 'required' on transfer quantity input
                                $('#product-table-body').on('change', '.product-checkbox', function() {
                                    const isChecked = $(this).is(':checked');
                                    const quantityInput = $(this).closest('tr').find('.transfer-quantity');

                                    if (isChecked) {
                                        quantityInput.prop('required', true).prop('disabled', false);
                                    } else {
                                        quantityInput.prop('required', false).prop('disabled', true);
                                    }
                                });
                            } else {
                                // If no products are found, display a message
                                $('#product-table-body').html('<tr><td colspan="6" class="text-center">No products available</td></tr>');
                            }
                        },
                        error: function() {
                            alert('Error fetching products.');
                        }
                    });
                }
            });

            // Search functionality for the product table
            $('#search-product').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();

                $('#product-table-body tr').each(function() {
                    var productName = $(this).find('td').first().text().toLowerCase();
                    var brand = $(this).find('td').eq(1).text().toLowerCase();
                    var color = $(this).find('td').eq(2).text().toLowerCase();
                    var size = $(this).find('td').eq(3).text().toLowerCase();

                    if (productName.indexOf(searchTerm) > -1 || brand.indexOf(searchTerm) > -1 || color.indexOf(searchTerm) > -1 || size.indexOf(searchTerm) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Monitor changes on all quantity input fields
            $(document).on('input', '.transfer-quantity', function() {
                let maxQuantity = parseInt($(this).attr('max'));
                let enteredQuantity = parseInt($(this).val());

                if (enteredQuantity > maxQuantity) {
                    // Trigger SweetAlert when quantity exceeds available stock
                    Swal.fire({
                        icon: 'warning',
                        title: 'Quantity Exceeds Available Stock',
                        text: `You can transfer up to ${maxQuantity} units only.`,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reset quantity to max if exceeded
                        $(this).val(maxQuantity);
                    });
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
