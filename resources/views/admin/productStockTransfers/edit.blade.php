@extends('adminlte::page')
@section('title', 'Edit Product Stock Transfer')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Product Stock Transfer</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.product-stock-transfers.index')}}">Product Stock Transfers</a></li>
                <li class="breadcrumb-item active">Edit Product Stock Transfer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.product-stock-transfers.update', $transfer->id)}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="from_showroom_id">From Showroom <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="from_showroom_id" name="from_showroom_id" class="form-control select2" readonly required>
                                        <option value="{{ $transfer->from_showroom_id}}">{{$transfer->fromShowroom->name??'Deleted'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="to_showroom_id">To Showroom <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="to_showroom_id" name="to_showroom_id" class="form-control select2" required>
                                        <option value="">Select Showroom</option>
                                        @foreach ($showrooms as $showroom)
                                            <option value="{{ $showroom->id }}" {{ $showroom->id == $transfer->to_showroom_id ? 'selected' : '' }}>
                                                {{ $showroom->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ $transfer->date }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Details</label>
                                    <textarea name="note" id="summernote" class="form-control">
                                        {{strip_tags($transfer->note) ?? ''}}
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Table for displaying product info and quantity input -->
                        <div class="row" id="product-table-container">
                            <div class="col-12">
                                <table id="activityTable" class="table table-bordered">
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
                                    @foreach($showroomProducts as $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="product-checkbox" name="selected_products[]" value="{{ $product->id }}"
                                                       @if($transfer->productStocks->pluck('id')->contains($product->id)) checked @endif>
                                            </td>
                                            <td>{{ $product->product->name }}</td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>{{ $product->color->color_name }}</td>
                                            <td>{{ $product->size->name }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>
                                                <input type="number" name="transfer_quantities[{{ $product->id }}]" class="form-control transfer-quantity"
                                                       value="{{ old('transfer_quantities.' . $product->id, $transfer->productStocks->firstWhere('id', $product->id)->pivot->quantity ?? 0) }}"
                                                       min="1" max="{{ $product->quantity }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($showroomProducts->isEmpty())
                                        <tr>
                                            <td colspan="7">No products available in this showroom.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('productStockTransfers.update')
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
@section('plugins.Sweetalert2', true)
@section('plugins.Summernote', true)
@section('plugins.Datatables', true)
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
            // Get the current 'to_showroom_id' from the transfer data
            var selectedToShowroomId = {{ $transfer->to_showroom_id }};

            // Get selected product IDs from the transfer
            var selectedProductIds = @json($transfer->productStocks->pluck('id'));

            // Fetch products for the selected showroom when page loads
            $.ajax({
                url: '/api/product-stocks/' + selectedToShowroomId,
                type: 'GET',
                success: function(data) {
                    // Check if there are products available
                    if (data.length > 0) {
                        // Show the product table container
                        $('#product-table-container').show();

                        // Populate the product table with fetched data
                        $.each(data, function(index, product) {
                            // Check if product is selected in the transfer
                            let isChecked = @json($transfer->productStocks->pluck('id')->toArray()).includes(product.id);

                            $('#product-table-body').append(`
                                <tr>
                                    <td><input type="checkbox" class="product-checkbox" name="selected_products[]" value="${product.id}" ${isChecked ? 'checked' : ''}></td>
                                    <td>${product.product_name}</td>
                                    <td>${product.brand_name}</td>
                                    <td>${product.color_name}</td>
                                    <td>${product.size_name}</td>
                                    <td>${product.quantity}</td>
                                    <td>
                                        <input type="number" name="transfer_quantities[${product.id}]" class="form-control transfer-quantity"
                                            value="${product.transfer_quantity || 0}" min="1" max="${product.quantity}" ${isChecked ? '' : 'disabled'}>
                                    </td>
                                </tr>
                            `);
                        });

                        // Add event listener for toggling 'required' on transfer quantity input
                        $('#product-table-body').on('change', '.product-checkbox', function() {
                            const isChecked = $(this).is(':checked');
                            const row = $(this).closest('tr');
                            row.find('.transfer-quantity').prop('disabled', !isChecked);
                        });
                    } else {

                    }
                }
            });

            // Prevent form submission if required fields are not selected
            $('#admin-form').submit(function(e) {
                var selectedProducts = $('input[name="selected_products[]"]:checked').length;
                if (selectedProducts == 0) {
                    e.preventDefault();
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

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {

            $("#activityTable").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true, // Disable the global search box
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    {
                        text: "Created",
                        action: function(e, dt, node, config){
                            dt.column(1).search("created").draw();
                        }
                    },
                    {
                        text: "Updated",
                        action: function(e, dt, node, config){
                            dt.column(1).search("updated").draw();
                        }
                    },
                    {
                        text: "Deleted",
                        action: function(e, dt, node, config){
                            dt.column(1).search("deleted").draw();
                        }
                    },
                    { extend: 'copy', text: 'Copy' },
                    { extend: 'csv', text: 'Export CSV' },
                    { extend: 'excel', text: 'Export Excel' },
                    { extend: 'pdf', text: 'Export PDF' },
                    { extend: 'print', text: 'Print' },
                    { extend: 'colvis', text: 'Colvis' }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    paginate: {
                        first: "{{ __('First') }}",
                        previous: "{{ __('Previous') }}",
                        next: "{{ __('Next') }}",
                        last: "{{ __('Last') }}",
                    }
                }
            });
        });
    </script>
@stop
