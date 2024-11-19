@extends('adminlte::page')
@section('title', 'Edit Raw Material RawMaterialPurchase')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Raw Material Purchase</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.raw-material-purchases.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Edit Purchase</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.raw-material-purchases.update', $purchase->id) }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @method('PUT') <!-- Add this to specify the form method as PUT for updates -->
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier</label>
                                    <select id="supplier_id" name="supplier_id" class="form-control select2" required>
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="warehouse_id">Warehouse</label>
                                    <select id="warehouse_id" name="warehouse_id" class="form-control select2" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $purchase->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="account_id">Account <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="account_id" name="account_id" class="form-control select2" required>
                                        <option value="">Select Account</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $purchase->account_id == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input type="date" name="purchase_date" value="{{ $purchase->purchase_date }}" class="form-control" required>
                                </div>
                            </div>
                            @php
                                $cost_details = json_decode($purchase->cost_details, true);
                            @endphp
                            <div class="col-md-6" style="height: 300px; overflow-y: auto;">
                                <legend class="w-auto ml-1">Cost Details</legend>
                                <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                    <div class="d-flex align-items-center mb-2" style="gap: 15px;">
                                        <!-- Total Cost -->
                                        <div class="d-flex align-items-center">
                                            <div class="total-sum me-3">
                                                <label>Total Cost: </label>
                                                <input type="text" name="total_cost" value="{{ $purchase->total_cost }}" class="form-control" id="total-amount" readonly>
                                            </div>
                                            <!-- Add Button -->
                                            <div class="ml-2">
                                                <button class="btn btn-success btn-sm add-item-btn" type="button">Add</button>
                                            </div>
                                        </div>
                                        <!-- Payment -->
                                        <div class="d-flex align-items-center">
                                            <label for="payment_type" class="mr-2">Payment: </label>
                                            <select id="payment_type" name="payment_type" class="select2 form-control ml-2">
                                                <option value="full_paid" @if($purchase->payment_type == 'full_paid') selected @endif>PAID</option>
                                                <option value="partial_paid" @if($purchase->payment_type == 'full_paid') selected @endif>PARTIAL</option>
                                            </select>
                                        </div>
                                        <!-- Container for the dynamic input field -->
                                        <div id="dueInputContainer" class="" style="display: @if($purchase->payment_type == 'full_paid')none @else block @endif">
                                            <input type="number" id="paid_amount" name="paid_amount" value="{{ $purchase->amount }}" class="form-control" placeholder="Enter Paid Amount">
                                        </div>
                                    </div>
                                    <div id="cost-details-container">
                                        @foreach($cost_details as $value)
                                            <div class="cost-detail-item d-flex align-items-center mb-2">
                                                <input type="text" name="cost_details[]" value="{{ $value['detail'] }}" class="form-control cost-detail-input mr-2"
                                                       placeholder="Cost Details" required>
                                                <input type="number" name="cost_amount[]" value="{{ $value['amount'] }}" class="form-control amount-input mr-2"
                                                       placeholder="Amount" required>
                                                <button class="btn btn-danger btn-sm remove-item-btn">&times;</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>













                            <div class="col-md-6">
                                <legend class="w-auto ml-1">Product List</legend>
                                <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                    <input type="text" id="product-search" class="form-control" placeholder="Search products">
                                    <ul id="product-list" class="list-group mt-2"></ul>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <legend class="w-auto ml-1">Purchased Item List</legend>
                                <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                    <table id="purchased-items-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Brand</th>
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="product_id[]" value="{{ $product->id }}" hidden>
                                                        {{ $product->name }}
                                                    </td>
                                                    <td>
                                                        <select name="brand_id[]" class="form-control select2 brand-select">
                                                            @foreach($brands as $brand)
                                                                <option
                                                                    value="{{ $brand->id }}"
                                                                    {{ $product->pivot->brand_id == $brand->id ? 'selected' : '' }}>
                                                                    {{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="size_id[]" class="form-control select2 size-select">
                                                            <option value=""></option>
                                                            @foreach($sizes as $size)
                                                                <option
                                                                    value="{{ $size->id }}"
                                                                    {{ $product->pivot->size_id == $size->id ? 'selected' : '' }}>
                                                                    {{ $size->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="color_id[]" class="form-control select2 color-select">
                                                            @foreach($colors as $color)
                                                                <option
                                                                    value="{{ $color->id }}"
                                                                    {{ $product->pivot->color_id == $color->id ? 'selected' : '' }}>
                                                                    {{ $color->color_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="price[]" value="{{ $product->pivot->price }}" step="any" class="form-control price-input form-control-sm"
                                                               placeholder="Enter price" min="0">
                                                    </td>
                                                    <td class="d-flex">
                                                        <input type="number" name="quantity[]" class="form-control quantity-input form-control-sm mr-2"
                                                               value="{{ $product->pivot->quantity }}" min="1">
                                                        <span>
                                                            {{ $product->unit && $product->unit->name ? $product->unit->name : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="total_price[]" value="{{ $product->pivot->total_price }}" class="form-control total-input form-control-sm">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm remove-product-btn">&times;</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                            @can('rawMaterialPurchases.updateStatus')
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Select Status</label>
                                        <select id="status" name="status" class="select2 form-control">
                                            <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="rejected" {{ $purchase->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="approved" {{ $purchase->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        </select>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        @can('rawMaterialPurchases.create')
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
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
        }

        .cost-detail-item {
            display: flex;
            align-items: center;
        }

        .cost-detail-input,
        .amount-input {
            flex: 1; /* Allows inputs to grow */
            margin-right: 10px; /* Space between inputs and the remove button */
        }

        .button-placeholder,
        .remove-item-btn {
            flex-shrink: 0;
            width: 36px; /* Fixed width to match the size of the remove button */
            height: 36px;
            display: inline-block;
        }

        .add-item-btn {
            background-color: #28a745; /* Bootstrap success color */
            border: none;
            padding: 5px 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .add-item-btn:hover {
            background-color: #218838;
        }

        .remove-item-btn {
            background-color: #dc3545; /* Bootstrap danger color */
            border: none;
            padding: 5px 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .remove-item-btn:hover {
            background-color: #c82333;
        }

        .total-sum {
            display: flex;
            align-items: center;
        }

        .total-sum label {
            margin-right: 10px;
        }

        #total-amount {
            width: 150px; /* Increased width for better visibility */
            text-align: right;
            font-weight: bold;
        }

        .custom-list-item {
            padding: 5px 10px; /* Adjust these values as needed */
        }

        .form-control-sm {
            max-width: 100px; /* Adjust the width as necessary */
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
            $('.select2').select2({ theme: "classic" });
            $('#summernote').summernote({
                height: 200,
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

            // Paid + Due Amount Input Field Reveal and Hide Related Code Starts
            const paymentTypeSelect = document.getElementById('payment_type');
            const dueInputContainer = document.getElementById('dueInputContainer');

            // Attach listener to Select2's change event
            $(paymentTypeSelect).on('change', function () {
                const selectedValue = this.value;

                // Show or hide the input field based on selection
                if (selectedValue === 'partial_paid') {
                    dueInputContainer.style.display = 'block'; // Show input
                } else {
                    dueInputContainer.style.display = 'none'; // Hide input
                }

                console.log("Selected Payment Type:", selectedValue);
            });
            // Paid + Due Amount Input Field Reveal and Hide Related Code Ends

            // Price, Quantity, Total Dependency
            function bindEvents() {
                $('#purchased-items-table').on('input', '.price-input, .quantity-input', function() {
                    const row = $(this).closest('tr');
                    const price = parseFloat(row.find('.price-input').val()) || 0;
                    const quantity = parseInt(row.find('.quantity-input').val()) || 1;
                    const total = price * quantity;
                    row.find('.total-input').val(total.toFixed(2));
                });

                $('#purchased-items-table').on('input', '.total-input', function() {
                    const row = $(this).closest('tr');
                    const total = parseFloat($(this).val()) || 0;
                    const quantity = parseFloat(row.find('.quantity-input').val()) || 1;

                    if (quantity > 0) {
                        row.find('.price-input').val((total / quantity).toFixed(2));
                    }
                });

                $('#purchased-items-table').on('click', '.remove-product-btn', function() {
                    const row = $(this).closest('tr');
                    row.remove();
                });
            }
            bindEvents();

            let brands = @json($brands);
            let sizes = @json($sizes);
            let colors = @json($colors);

            // Add Product to Table
            $('#product-list').on('click', '.add-product-btn', function(e) {
                e.preventDefault();

                const materialId = $(this).data('id');
                const material = rawMaterials.find(m => m.id === materialId);

                if (material) {
                    // Calculate GSM with inch to meter conversion
                    const gsm = calculateGSM(material.width, material.length, material.density);

                    $('#purchased-items-table tbody').append(`
                        <tr data-id="${material.id}">
                            <td>
                                <input type="text" name="product_id[]" value="${material.id}" hidden>
                                ${material.name}
                            </td>
                            <td>
                                <select name="brand_id[]" class="form-control select2 brand-select">
                                    ${brands.map(b => `<option value="${b.id}" ${b.id === material.brand_id ? 'selected' : ''}>${b.name}</option>`).join('')}
                                </select>
                            </td>
                            <td>
                                <select name="size_id[]" class="form-control select2 size-select">
                                    ${sizes.map(s => `<option value="${s.id}" ${s.id === material.size_id ? 'selected' : ''}>${s.name}</option>`).join('')}
                                </select>
                            </td>
                            <td>
                                <select name="color_id[]" class="form-control select2 color-select">
                                    ${colors.map(c => `<option value="${c.id}" ${c.id === material.color_id ? 'selected' : ''}>${c.color_name}</option>`).join('')}
                                </select>
                            </td>
                            <td>
                                <input type="number" name="price[]" class="form-control price-input form-control-sm" placeholder="Enter price" min="0" step="any">
                            </td>
                            <td class="d-flex">
                                <input type="number" name="quantity[]" class="form-control quantity-input form-control-sm mr-2" value="1" min="1">
                                <span class="unit-id-label">${material.unit?.code || 'N/A'}</span>
                            </td>
                            <td>
                                <input type="number" name="total_price[]" class="form-control total-input form-control-sm" value="0">
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-product-btn">&times;</button>
                            </td>
                        </tr>
                    `);

                    $('.select2').select2({ theme: "classic" });
                    bindEvents();
                } else {
                    console.error('Material not found');
                }
            });
            // Cost Details Section Functions
            function addCostDetailItem() {
                return `
                <div class="cost-detail-item d-flex align-items-center mb-2">
                    <input type="text" name="cost_details[]" class="form-control cost-detail-input mr-2" placeholder="Cost Details">
                    <input type="number" name="cost_amount[]" class="form-control amount-input mr-2" placeholder="Amount">
                    <button class="btn btn-danger btn-sm remove-item-btn">&times;</button>
                </div>
            `;
            }

            function updateTotalAmount() {
                let total = 0;
                $(".amount-input").each(function() {
                    let amount = parseFloat($(this).val()) || 0;
                    total += amount;
                });
                $("#total-amount").val(total.toFixed(2));
            }

            // Add new cost detail item when 'Add' button is clicked
            $(document).on("click", ".add-item-btn", function(e) {
                e.preventDefault();
                $("#cost-details-container").append(addCostDetailItem());
                updateTotalAmount();
            });

            // Remove a cost detail item when 'Remove' button is clicked
            $(document).on("click", ".remove-item-btn", function(e) {
                e.preventDefault();
                $(this).closest('.cost-detail-item').remove();
                updateTotalAmount();
            });

            // Update total amount when amount input changes
            $(document).on("input", ".amount-input", function() {
                updateTotalAmount();
            });

            // Fetch Products
            let rawMaterials = [];

            $.ajax({
                url: '{{ route("materials.all") }}',
                method: 'GET',
                success: function (data) {
                    rawMaterials = data;
                    populateProductList('');
                },
                error: function (error) {
                    console.error('Error fetching materials:', error);
                }
            });

            // Populate Product List
            function populateProductList(query) {
                const productList = $('#product-list');
                if (query.trim() === '') {
                    productList.empty();
                    return;
                }

                const lowerQuery = query.toLowerCase();
                const filteredMaterials = rawMaterials.filter(material =>
                    material.name.toLowerCase().includes(lowerQuery) ||
                    (material.sku && material.sku.toLowerCase().includes(lowerQuery)) ||
                    (material.density && material.density.toString().toLowerCase().includes(lowerQuery))
                );

                productList.empty();
                filteredMaterials.forEach(material => {
                    // Calculate GSM for each material
                    const gsm = calculateGSM(material.width, material.length, material.density);

                    productList.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center custom-list-item"
                    data-toggle="tooltip" title="SKU: ${material.sku || 'N/A'}, Width: ${material.width} inch, Length: ${material.length} inch, Density: ${material.density || 'N/A'} inch, GSM: ${gsm || 'N/A'}">
                        <a href="#" class="w-100 d-flex justify-content-between align-items-center text-decoration-none text-dark add-product-btn" data-id="${material.id}">
                            ${material.name} - ${material.sku ? `(SKU: ${material.sku})` : '(SKU: N/A)'} - ${material.density ? `(Density: ${material.density})` : '(Density: N/A)'}
                        </a>
                    </li>
                `);
                });
            }

            // Function to calculate GSM based on width, length, and density (in inches, converted to meters)
            function calculateGSM(width, length, density) {
                const conversionFactor = 0.0254; // inches to meters conversion factor
                const area = (width * conversionFactor) * (length * conversionFactor); // area in square meters
                const gsm = density ? density * area : 0; // GSM calculation
                return gsm.toFixed(2);
            }

            $('#product-search').on('input', function() {
                const query = $(this).val();
                populateProductList(query);
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });
    </script>
@stop
