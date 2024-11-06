@extends('adminlte::page')
@section('title', 'Productions')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Productions</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.index') }}">Productions</a></li>
                <li class="breadcrumb-item active">Create Production</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.productions.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @if ($errors->any())
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
                                    <label for="production_house_id">Select Production House <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="production_house_id" name="production_house_id" class="select2 form-control" required>
                                        @foreach($houses as $house)
                                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="showroom_id">Select Showroom <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="showroom_id" name="showroom_id" class="select2 form-control" required>
                                        @foreach($showrooms as $showroom)
                                            <option value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="account_id">Select Account <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="account_id" name="account_id" class="select2 form-control" required>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="production_date">Production Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input type="date" name="production_date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <legend class="mt-3">Raw Material Section</legend>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="warehouse_id">Select Warehouse <span class="text-danger font-weight-bolder">*</span></label>
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
                                <div class="col-md-6" style="height: 300px; overflow-y: auto;">
                                    <legend class="w-auto ml-1">Cost Details</legend>
                                    <fieldset class="form-group border p-3" style="border-color: #ccc;">
                                        <div class="d-flex mb-2">
                                            <div class="total-sum mr-2">
                                                <label>Total Cost: </label>
                                                <input type="text" name="total_cost" class="form-control" id="total-amount" value="0" readonly>
                                            </div>
                                            <div>
                                                <button class="btn btn-success btn-sm add-item-btn" type="button">Add</button>
                                            </div>
                                        </div>
                                        <div id="cost-details-container">
                                            <div class="cost-detail-item d-flex align-items-center mb-2">
                                                <input type="text" name="cost_details[]" class="form-control cost-detail-input mr-2" placeholder="Cost Details" required>
                                                <input type="number" name="cost_amount[]" class="form-control amount-input mr-2" placeholder="Amount" required>
                                                <div class="button-placeholder"></div>
                                            </div>
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
                        @can('productions.create')
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
            display: none; /* Initially hidden */
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

            const baseURL = "{{ asset('') }}";

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
                                <img src="${baseURL}${material.raw_material.image}" alt="${material.raw_material.name}" style="width: 20px; height: 20px;">
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
                            const image = $(this).data('image'); // Get the image URL
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

                            $('#alert-container').empty(); // Clear previous alerts
                            selectedMaterials[materialId] = {
                                id: materialId,
                                name: $(this).find('h5').text(),
                                sku: $(this).find('p').eq(0).text().replace('SKU: ', ''),
                                price: price,
                                count: count, // Set the count based on clicks
                                quantity: availableQuantity, // Ensure the quantity is stored correctly
                                image: image, // Store the image URL
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
                    const totalCost = material.price * material.count; // Calculate total cost

                    $('#selected-materials').append(`
                    <tr>
                        <td><img src="${baseURL}${material.image}" alt="${material.name}" style="width: 60px; height: 60px;"></td>
                        <td>
                            <input type="hidden" name="raw_material_id[]" value="${material.id}"> <!-- Raw Material ID -->
                            <input type="hidden" name="raw_material_warehouse_id[]" value="${material.warehouseId}"> <!-- Warehouse ID -->
                            <input type="hidden" name="raw_material_brand_id[]" value="${material.brandId}"> <!-- Brand ID -->
                            <input type="hidden" name="raw_material_color_id[]" value="${material.colorId}"> <!-- Color ID -->
                            <input type="hidden" name="raw_material_size_id[]" value="${material.sizeId}"> <!-- Size ID -->
                            ${material.name}
                        </td>
                        <td>
                            <input type="hidden" name="raw_material_sku[]" value="${material.sku}">
                            ${material.sku}
                        </td>
                        <td>
                            <input type="number" name="raw_material_price[]" class="form-control"
                                value="${material.price}" min="0" step="0.01" readonly> <!-- Price -->
                        </td>
                        <td>
                            <input type="number" name="raw_material_quantity[]" class="form-control count-input"
                                value="${material.count}" min="1" max="${material.quantity}" data-id="${materialId}"> <!-- Quantity -->
                        </td>
                        <td>
                            <input type="text" name="raw_material_total_price[]" class="form-control total-cost-input"
                                value="${totalCost.toFixed(2)}" readonly> <!-- Total Price -->
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-product-btn">&times;</button>
                        </td>
                    </tr>
                `);
                }

                // Update total cost when quantity changes
                $('.count-input').on('input', function () {
                    const materialId = $(this).data('id');
                    const newCount = $(this).val(); // Removed parseInt conversion
                    const availableQuantity = selectedMaterials[materialId].quantity;

                    if (isNaN(newCount) || newCount < 1) {
                        alert('Invalid count. Please enter a valid number.');
                        $(this).val(1);
                        return;
                    }

                    if (newCount > availableQuantity) {
                        alert('Quantity exceeds available stock.');
                        $(this).val(availableQuantity); // Set to max available if exceeded
                        return;
                    }

                    selectedMaterials[materialId].count = newCount; // Keep as a string

                    // Update the total cost
                    const price = selectedMaterials[materialId].price;
                    const totalCost = price * newCount;
                    $(this).closest('tr').find('.total-cost-input').val(totalCost.toFixed(2)); // Update total cost input
                });
            }

            // Remove row functionality
            $(document).on("click", ".remove-product-btn", function(e) {
                e.preventDefault();
                const materialId = $(this).closest('tr').find('.count-input').data('id'); // Get material ID
                delete selectedMaterials[materialId]; // Remove from selected materials
                $(this).closest('tr').remove(); // Remove the row
            });
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

        // Add Product to Table
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
                            <button class="btn btn-danger btn-sm remove-product-btn">&times;</button>
                        </td>
                    </tr>
                `);

                $('.select2').select2({ theme: "classic" });
                bindEvents();
            } else {
                console.error('Product not found');
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

        $(document).on("click", ".add-item-btn", function(e) {
            e.preventDefault();
            $("#cost-details-container").append(addCostDetailItem());
            updateTotalAmount();
            if ($('.cost-detail-item').length > 1) {
                $('.remove-item-btn').show();
                $('.button-placeholder').remove();
            }
        });

        $(document).on("click", ".remove-item-btn", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            updateTotalAmount();
            if ($('.cost-detail-item').length <= 1) {
                $('.remove-item-btn').hide();
                if (!$("#cost-details-container .button-placeholder").length) {
                    $("#cost-details-container .cost-detail-item").append('<div class="button-placeholder"></div>');
                }
            }
        });

        $(document).on("input", ".amount-input", function() {
            updateTotalAmount();
        });

        // Fetch Products
        let products = [];

        $.ajax({
            url: '{{ route("products.all") }}', // New route for fetching products
            method: 'GET',
            success: function (data) {
                if (Array.isArray(data)) {
                    products = data;
                } else if (data.products) {
                    products = data.products; // In case products are nested in the response
                } else {
                    products = []; // Fallback to an empty array if the structure is unexpected
                }
                populateProductList('');
            },
            error: function (error) {
                console.error('Error fetching products:', error);
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

        $('#product-search').on('input', function() {
            const query = $(this).val();
            populateProductList(query);
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
