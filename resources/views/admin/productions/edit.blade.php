@extends('adminlte::page')
@section('title', 'Edit Production')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Production</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Edit Production</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.productions.update', $production->id) }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="production_house_id">Select Production House</label>
                                    <select id="production_house_id" name="production_house_id" class="select2 form-control" required>
                                        @foreach($houses as $house)
                                            <option value="{{ $house->id }}" {{ $house->id == $production->production_house_id ? 'selected' : '' }}>
                                                {{ $house->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="showroom_id">Select Showroom</label>
                                    <select id="showroom_id" name="showroom_id" class="select2 form-control" required>
                                        @foreach($showrooms as $showroom)
                                            <option value="{{ $showroom->id }}" {{ $showroom->id == $production->showroom_id ? 'selected' : '' }}>
                                                {{ $showroom->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="account_id">Select Account</label>
                                    <select id="account_id" name="account_id" class="select2 form-control" required>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $account->id == $production->account_id ? 'selected' : '' }}>
                                                {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="production_date">Production Date</label>
                                    <input type="date" name="production_date" class="form-control" value="{{ $production->production_date }}" required>
                                </div>
                            </div>
                        </div>

                        <legend class="mt-3">Raw Material Section</legend>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="warehouse_id">Select Warehouse</label>
                                    <select id="warehouse_id" name="warehouse_id" class="select2 form-control" required>
                                        <option value="" disabled selected>Select a warehouse</option>
                                        @foreach($warehouses as $warehouse)
                                            @if($warehouse->raw_material_stocks->count() > 0)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="search-raw-material">Warehouse's Raw Materials</label>
                                    <input type="text" id="search-raw-material" placeholder="Search Raw Materials" class="form-control mb-2" style="max-width: 300px;">
                                    <div style="max-height: 200px; overflow-y: auto;" id="raw-materials-container">
                                        <!-- Raw materials cards will be populated here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 border rounded mt-4">
                                <label for="selected-materials">Selected Raw Materials</label>
                                <div style="max-height: 200px; overflow-y: auto;">
                                    <table id="selected-materials-table" class="table table-sm table-bordered w-100">
                                        <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Sku</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Cost</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="selected-materials">
                                        <!-- Selected raw materials will be appended here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="alert-container"></div> <!-- Alert message container -->
                            </div>

                            <div class="row mt-4">
                                @php
                                    // Check if cost_details is a valid JSON string
                                    $cost_details = is_string($production->cost_details) ? json_decode($production->cost_details, true) : [];
                                @endphp

                                <div class="col-md-6" style="height: 300px; overflow-y: auto;">
                                    <legend class="w-auto ml-1">Cost Details</legend>
                                    <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                        <div class="d-flex mb-2">
                                            <div class="total-sum mr-2">
                                                <label>Total Cost: </label>
                                                <input type="text" name="total_cost" value="{{ $production->total_cost }}" class="form-control" id="total-amount" readonly>
                                            </div>
                                            <div>
                                                <button class="btn btn-success btn-sm add-item-btn" type="button">Add</button>
                                            </div>
                                        </div>
                                        <div id="cost-details-container">
                                            @if(is_array($cost_details))
                                                @foreach($cost_details as $cosDet)
                                                    <div class="cost-detail-item d-flex align-items-center mb-2">
                                                        <input type="text" name="cost_details[]"
                                                               value="{{ is_string($cosDet['detail']) ? $cosDet['detail'] : '' }}"
                                                               class="form-control cost-detail-input mr-2" placeholder="Cost Details" required>
                                                        <input type="number" name="cost_amount[]"
                                                               value="{{ is_numeric($cosDet['amount']) ? $cosDet['amount'] : 0 }}"
                                                               class="form-control amount-input mr-2" placeholder="Amount" required>
                                                        <button class="btn btn-danger remove-item-btn">&times;</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-6" style="height: 300px; overflow-y: auto;">
                                    <legend class="w-auto ml-1">Product's List</legend>
                                    <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                        <input type="text" id="product-search" class="form-control" placeholder="Search products">
                                        <ul id="product-list" class="list-group mt-2"></ul>
                                    </fieldset>
                                </div>

                                <div class="col-12">
                                    <legend class="w-auto ml-1">Selected Product List</legend>
                                    <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                        <table id="purchased-items-table" class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Brand</th>
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th>Cost Per Piece</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Dynamic rows will be added here -->
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        @can('productions.update')
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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('css')
    <style>
        .raw-material-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            cursor: pointer;
            transition: 0.2s;
            width: calc(33.33% - 10px);
            box-sizing: border-box;
        }

        .raw-material-card img {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .raw-material-card h5 {
            margin: 0;
            font-size: 1.1rem;
        }

        .raw-material-card p {
            margin: 0;
            font-size: 0.9rem;
            color: #555;
        }

        #raw-materials-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            max-height: 200px;
            overflow-y: auto;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
        }

        #selected-image {
            max-height: 150px;
            border: 2px solid #ddd;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin: 10px 0;
            padding: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: opacity 0.3s ease;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 37px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 34px;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            background-color: #ddd;
            border: none;
            border-left: 1px solid #aaa;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            height: 35px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            background-image: linear-gradient(to bottom, #eeeeee 50%, #cccccc 100%);
            transition: background-color 0.3s ease;
        }

        .cost-detail-item {
            display: flex;
            align-items: center;
        }

        .cost-detail-input,
        .amount-input {
            width: calc(50% - 24px); /* Fixed width for inputs, adjust as needed */
            min-width: 0; /* Prevent input from overflowing */
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
            /* display: none; Remove this line to make it visible */
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
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            let selectedMaterials = {};

            // Existing raw materials data from the server
            const existingRawMaterials = @json($existingRawMaterials);
            const allRawMaterials = @json($rawMaterialStocks); // Ensure this contains all raw materials with their details

            // Populate the selected materials table with existing data
            existingRawMaterials.forEach(function (material) {
                const warehouseId = material.warehouse_id;

                $.ajax({
                    url: '{{ route("raw-materials.by-warehouse") }}',
                    type: 'GET',
                    data: { warehouse_id: warehouseId },
                    success: function (data) {
                        const materialDetails = data.find(m => m.id === material.raw_material_id);
                        if (materialDetails) {
                            // Store the existing materials in the selectedMaterials object
                            selectedMaterials[material.raw_material_id] = {
                                id: material.raw_material_id,
                                name: materialDetails.raw_material.name,
                                sku: materialDetails.raw_material.sku,
                                price: material.price,
                                count: material.quantity,
                                quantity: materialDetails.quantity,
                                image: materialDetails.raw_material.image,
                                warehouseId: warehouseId,
                                brandId: material.brand_id,
                                colorId: material.color_id,
                                sizeId: material.size_id
                            };
                            // Populate the selected materials table
                            updateSelectedMaterialsTable();
                        }
                    },
                    error: function () {
                        alert('Error loading raw materials. Please try again.');
                    }
                });
            });

            // Function to filter raw materials based on name or SKU
            $('#search-raw-material').on('input', function () {
                const searchTerm = $(this).val().toLowerCase();
                $('.raw-material-card').each(function () {
                    const materialName = $(this).find('.card-title').text().toLowerCase();
                    const materialSku = $(this).find('p').eq(0).text().toLowerCase();
                    // Search by name or SKU
                    if (materialName.includes(searchTerm) || materialSku.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#warehouse_id').on('change', function () {
                const warehouseId = $(this).val();
                $('#raw-materials-container').empty();

                $.ajax({
                    url: '{{ route("raw-materials.by-warehouse") }}',
                    type: 'GET',
                    data: { warehouse_id: warehouseId },
                    success: function (data) {
                        data.forEach(function (material) {
                            $('#raw-materials-container').append(`
                            <div class="raw-material-card" data-id="${material.id}" data-quantity="${material.quantity}" data-price="${material.price}"
                                data-image="${material.raw_material.image}" data-warehouse-id="${warehouseId}"
                                data-brand-id="${material.brand_id}" data-color-id="${material.color_id}" data-size-id="${material.size_id}">
                                <img src="${material.raw_material.image}" alt="${material.raw_material.name}" style="width: 20px; height: 20px;">
                                <h5 class="card-title">${material.raw_material.name}</h5>
                                <p><strong>SKU:</strong> ${material.raw_material.sku}</p>
                                <p>Price: ${material.price}</p>
                                <p>Available: ${material.quantity}</p>
                            </div>
                        `);
                        });

                        // Add click event for each raw material card
                        $('.raw-material-card').on('click', function () {
                            const materialId = $(this).data('id');
                            const availableQuantity = $(this).data('quantity');
                            const price = $(this).data('price');
                            const image = $(this).data('image');
                            const warehouseId = $(this).data('warehouse-id');
                            const brandId = $(this).data('brand-id');
                            const colorId = $(this).data('color-id');
                            const sizeId = $(this).data('size-id');

                            const selectedMaterial = selectedMaterials[materialId];
                            let count = selectedMaterial ? selectedMaterial.count + 1 : 1;

                            // Prevent adding more than available quantity
                            if (count > availableQuantity) {
                                $('#alert-container').html(`<div class="alert alert-danger">Quantity exceeds available stock for ${$(this).find('h5').text()}!</div>`);
                                return;
                            }

                            $('#alert-container').empty();
                            // Store the selected material
                            selectedMaterials[materialId] = {
                                id: materialId,
                                name: $(this).find('h5').text(),
                                sku: $(this).find('p').eq(0).text().replace('SKU: ', ''),
                                price: price,
                                count: count, // No conversion to integer
                                quantity: availableQuantity, // Float/Double quantity
                                image: image,
                                warehouseId: warehouseId,
                                brandId: brandId,
                                colorId: colorId,
                                sizeId: sizeId
                            };

                            updateSelectedMaterialsTable();
                        });
                    },
                    error: function () {
                        alert('Error loading raw materials. Please try again.');
                    }
                });
            });

            function updateSelectedMaterialsTable() {
                $('#selected-materials').empty();
                for (const materialId in selectedMaterials) {
                    const material = selectedMaterials[materialId];
                    const totalCost = material.price * material.count;

                    $('#selected-materials').append(`
                    <tr>
                        <td><img src="${material.image}" alt="${material.name}" style="width: 60px; height: 60px;"></td>
                        <td>
                            <input type="hidden" name="raw_material_id[]" value="${material.id}">
                            <input type="hidden" name="raw_material_warehouse_id[]" value="${material.warehouseId}">
                            <input type="hidden" name="raw_material_brand_id[]" value="${material.brandId}">
                            <input type="hidden" name="raw_material_color_id[]" value="${material.colorId}">
                            <input type="hidden" name="raw_material_size_id[]" value="${material.sizeId}">
                            ${material.name}
                        </td>
                        <td>
                            <input type="hidden" name="raw_material_sku[]" value="${material.sku}">
                            ${material.sku}
                        </td>
                        <td>
                            <input type="number" name="raw_materials_price[]" class="form-control" value="${material.price}" min="0" step="0.01" readonly>
                        </td>
                        <td>
                            <input type="number" name="raw_material_quantity[]" class="form-control count-input" value="${material.count}" min="1" max="${material.quantity}" data-id="${materialId}">
                        </td>
                        <td>
                            <input type="text" name="raw_material_total_price[]" class="form-control total-cost-input" value="${totalCost.toFixed(2)}" readonly>
                        </td>
                        <td class="d-flex justify-content-center">
                            <button class="btn btn-danger remove-product-btn" data-id="${materialId}">&times;</button>
                        </td>
                    </tr>
                `);
                }

                // Update total cost when quantity changes
                $('.count-input').on('input', function () {
                    const materialId = $(this).data('id');
                    const newCount = parseFloat($(this).val()); // Changed to float
                    const availableQuantity = selectedMaterials[materialId].quantity;

                    // Input validation with alert functionality
                    if (isNaN(newCount) || newCount < 1) {
                        alert('Invalid count. Please enter a valid number.');
                        $(this).val(1); // Reset to 1 if invalid
                        return;
                    }

                    if (newCount > availableQuantity) {
                        alert('Quantity exceeds available stock.');
                        $(this).val(availableQuantity); // Set to max available if exceeded
                        return;
                    }

                    selectedMaterials[materialId].count = newCount; // Store as float
                    const price = selectedMaterials[materialId].price;
                    const totalCost = price * newCount;
                    $(this).closest('tr').find('.total-cost-input').val(totalCost.toFixed(2)); // Update total cost input
                });

                // Event delegation for remove buttons to remove row and update selectedMaterials
                $('#selected-materials').on('click', '.remove-product-btn', function () {
                    const materialId = $(this).data('id'); // Get the material ID from the button
                    delete selectedMaterials[materialId];  // Remove the material from selectedMaterials object
                    updateSelectedMaterialsTable();        // Update the table to reflect the removal
                });
            }
        });
    </script>


    <script>
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
        let existingProducts = @json($existingProducts); // Pre-existing products from controller
        let products = [];

        // Function to load existing products into the table
        function loadExistingProducts() {
            existingProducts.forEach(product => {
                $('#purchased-items-table tbody').append(`
            <tr data-id="${product.product_id}">
                <td>
                    <input type="text" name="product_id[]" value="${product.product_id}" hidden>
                    ${products.find(p => p.id === product.product_id)?.name || 'N/A'}
                </td>
                <td>
                    <select name="brand_id[]" class="form-control select2 brand-select">
                        ${brands.map(b => `<option value="${b.id}" ${b.id == product.brand_id ? 'selected' : ''}>${b.name}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <select name="size_id[]" class="form-control select2 size-select">
                        ${sizes.map(s => `<option value="${s.id}" ${s.id == product.size_id ? 'selected' : ''}>${s.name}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <select name="color_id[]" class="form-control select2 color-select">
                        ${colors.map(c => `<option value="${c.id}" ${c.id == product.color_id ? 'selected' : ''}>${c.color_name}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <input type="number" name="price[]" class="form-control price-input form-control-sm" value="${product.per_pc_cost}" placeholder="Enter price" min="0">
                </td>
                <td class="d-flex">
                    <input type="number" name="quantity[]" class="form-control quantity-input form-control-sm mr-2" value="${product.quantity}" min="1">
                    <span class="unit-id-label">${product.unit?.code || 'N/A'}</span>
                </td>
                <td>
                    <input type="number" name="total_price[]" class="form-control total-input form-control-sm" value="${product.sub_total}">
                </td>
                <td>
                    <button class="btn btn-danger remove-product-btn">&times;</button>
                </td>
            </tr>
        `);
            });

            $('.select2').select2({ theme: "classic" });
            bindEvents();
        }

        // Load existing products when the document is ready
        $(document).ready(function() {
            // Fetch all products via API
            $.ajax({
                url: '{{ route("products.all") }}', // Use your existing API route
                method: 'GET',
                success: function(data) {
                    products = data;
                    loadExistingProducts(); // Load the existing products into the table
                },
                error: function(error) {
                    console.error('Error fetching products:', error);
                }
            });
        });

        // Add new product to the table
        $('#product-list').on('click', '.add-product-btn', function(e) {
            e.preventDefault();

            const productId = $(this).data('id');
            const product = products.find(p => p.id === productId);

            if (product) {
                $('#purchased-items-table tbody').append(`
                <tr data-id="${product.id}">
                    <td>
                        <input type="text" name="product_id[]" value="${product.id}" hidden>
                        ${product.name}
                    </td>
                    <td>
                        <select name="brand_id[]" class="form-control select2 brand-select">
                            ${brands.map(b => `<option value="${b.id}" ${b.id === product.brand_id ? 'selected' : ''}>${b.name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <select name="size_id[]" class="form-control select2 size-select">
                            ${sizes.map(s => `<option value="${s.id}" ${s.id === product.size_id ? 'selected' : ''}>${s.name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <select name="color_id[]" class="form-control select2 color-select">
                            ${colors.map(c => `<option value="${c.id}" ${c.id === product.color_id ? 'selected' : ''}>${c.color_name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="price[]" class="form-control price-input form-control-sm" placeholder="Enter price" min="0">
                    </td>
                    <td class="d-flex">
                        <input type="number" name="quantity[]" class="form-control quantity-input form-control-sm mr-2" value="1" min="1">
                        <span class="unit-id-label">${product.unit?.code || 'N/A'}</span>
                    </td>
                    <td>
                        <input type="number" name="total_price[]" class="form-control total-input form-control-sm" value="0">
                    </td>
                    <td>
                        <button class="btn btn-danger remove-product-btn">&times;</button>
                    </td>
                </tr>
            `);

                $('.select2').select2({ theme: "classic" });
                bindEvents();
            } else {
                console.error('Product not found');
            }
        });

        // Populate Product List (for searching new products)
        function populateProductList(query) {
            const productList = $('#product-list');
            const lowerQuery = query.toLowerCase();
            const filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(lowerQuery) ||
                (product.sku && product.sku.toLowerCase().includes(lowerQuery))
            );

            productList.empty();
            filteredProducts.forEach(product => {
                productList.append(`
                <li class="list-group-item d-flex justify-content-between align-items-center custom-list-item"
                data-toggle="tooltip" title="SKU: ${product.sku || 'N/A'}, Width: ${product.width || 'N/A'}, Length: ${product.length || 'N/A'}">
                    <a href="#" class="w-100 d-flex justify-content-between align-items-center text-decoration-none text-dark add-product-btn" data-id="${product.id}">
                        ${product.name} - ${product.sku ? `(SKU: ${product.sku})` : '(SKU: N/A)'}
                    </a>
                </li>
            `);
            });
        }

        // Search product functionality
        $('#product-search').on('input', function() {
            const query = $(this).val();
            populateProductList(query);
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });



        // Cost Details Section Functions
        function addCostDetailItem() {
            return `
                <div class="cost-detail-item d-flex align-items-center mb-2">
                    <input type="text" name="cost_details[]" class="form-control cost-detail-input mr-2" placeholder="Cost Details">
                    <input type="number" name="cost_amount[]" class="form-control amount-input mr-2" placeholder="Amount">
                    <button class="btn btn-danger remove-item-btn">&times;</button>
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
    </script>




@stop