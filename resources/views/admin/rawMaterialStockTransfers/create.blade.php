@extends('adminlte::page')
@section('title', 'Create Raw Material Stock Transfer')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Raw Material Stock Transfer</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.raw-material-stock-transfers.index')}}">Raw Material Stock Transfers</a></li>
                <li class="breadcrumb-item active">Create Raw Material Stock Transfer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.raw-material-stock-transfers.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="from_warehouse_id">From Warehouse <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="from_warehouse_id" name="from_warehouse_id" class="form-control select2" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="to_warehouse_id">To Warehouse <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="to_warehouse_id" name="to_warehouse_id" class="form-control select2" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->name }}
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

                        <!-- Table for displaying raw material info and quantity input -->
                        <div class="row" id="raw-material-table-container" style="display:none;">
                            <div class="col-12">
                                <input type="text" id="search-raw-material" class="form-control" placeholder="Search for a raw material..." style="margin-bottom: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Raw Material Name</th>
                                        <th>Quantity</th>
                                        <th>Transfer Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody id="raw-material-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('rawMaterialStockTransfers.create')
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
            height: 37px;
            display: block;
            cursor: pointer;
        }
        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            color: #444;
        }
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 35px;
            position: absolute;
            top: 1px;
            right: 1px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({ theme: "classic" });

            var originalToWarehouseOptions = $('#to_warehouse_id').html();

            $('#from_warehouse_id').on('change', function() {
                var selectedFromWarehouseId = $(this).val();
                $('#to_warehouse_id').html(originalToWarehouseOptions);

                if (selectedFromWarehouseId) {
                    // Remove the selected 'from' warehouse option from 'to_warehouse_id'
                    $('#to_warehouse_id option[value="' + selectedFromWarehouseId + '"]').remove();

                    $.ajax({
                        url: '/api/raw-material-stocks/' + selectedFromWarehouseId,
                        type: 'GET',
                        success: function(data) {
                            // Clear the previous options in the table
                            $('#raw-material-table-body').empty();

                            // Check if there are raw materials available
                            if (data.length > 0) {
                                // Show the product table container
                                $('#raw-material-table-container').show();

                                // Populate the product table with fetched data
                                $.each(data, function(index, rawMaterial) {
                                    $('#raw-material-table-body').append(`
                                        <tr>
                                            <td><input type="checkbox" class="raw-material-checkbox" name="selected_raw_materials[]" value="${rawMaterial.id}"></td>
                                            <td>${rawMaterial.raw_material_name}</td>
                                            <td>${rawMaterial.quantity}</td>
                                            <td>
                                                <input type="number" name="transfer_quantities[${rawMaterial.id}]" class="form-control transfer-quantity"
                                                    min="1" max="${rawMaterial.quantity}" disabled>
                                            </td>
                                        </tr>
                                    `);
                                });

                                // Add event listener for toggling 'required' on transfer quantity input
                                $('#raw-material-table-body').on('change', '.raw-material-checkbox', function() {
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
                                $('#raw-material-table-body').html('<tr><td colspan="6" class="text-center">No raw material available</td></tr>');
                            }
                        },
                        error: function() {
                            alert('Error fetching raw materials.');
                        }
                    });
                }
            });

            // Search functionality for the raw materials table
            $('#search-raw-material').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();

                $('#raw-material-table-body tr').each(function() {
                    var rawMaterialName = $(this).find('td').first().text().toLowerCase();

                    if (rawMaterialName.indexOf(searchTerm) > -1) {
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
