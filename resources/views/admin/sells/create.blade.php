@extends('adminlte::page')
@section('title', 'Create Sell')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex">
                <h1>Create Sell</h1>
                <div class="ml-2">
                    <form action="{{ route('sells.setCurrency') }}" method="POST">
                        @csrf
                        <select id="currency_id" name="currency_id" class="select2 form-control" onchange="this.form.submit()">
                            <option value="">Select Currency</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.sells.index') }}">Sells</a></li>
                <li class="breadcrumb-item active">Create Sell</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.sells.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-6 border" id="selected-products-table">
                                <h5>Selected Products</h5>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Discount (%)</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="selected-products-body" style="height: 300px; overflow-y: auto;">
                                    <!-- Selected products will be populated here -->
                                    </tbody>
                                </table>
                                <div class="p-2 mb-3" style="background-color: #f0fbee; border-radius: 10px;">
                                    <div class="row">
                                        <!-- Row 1: Wholesale checkbox, Total Items -->
                                        <div class="col-md-6 d-flex" style="padding-left: 30px;">
                                            <input type="checkbox" class="form-check-input mr-2" id="wholesaleCheck">
                                            <label for="wholesaleCheck" class="mb-0">Wholesale</label>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <!-- Row 2: Subtotal, VAT, Salesman -->
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label for="sub_total">Sub Total</label>
                                                <input type="number" name="sub_total" id="sub_total" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label for="vat">VAT</label>
                                                <input type="number" name="vat" id="vat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label for="salesman">Salesman</label>
                                                <select name="salesman" class="select2 form-control" id="salesman">
                                                    <option value="dd">dd1</option>
                                                    <option value="dd2">dd2</option>
                                                    <option value="dd3">dd3</option>
                                                    <option value="dd4">dd4</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="col-md-6 mt-3">
                                            <button type="reset" id="cancel-button" class="btn btn-primary w-100">Cancel</button>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <button class="btn btn-danger w-100">Payment</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <!-- Product Category Part -->
                                <div class="w-100 row align-items-center">
                                    <!-- Left Scroll Button -->
                                    <div class="col-md-1 btn" id="scroll-left">
                                        <i class="fas fa-arrow-left"></i>
                                    </div>
                                    <!-- Scrollable Div -->
                                    <div class="col-md-10 d-flex overflow-hidden" style="overflow-x: auto; scroll-behavior: smooth;" id="scroll-container">
                                        <div class="border border-2 px-3 active-category" style="display: inline-block; white-space: nowrap;">
                                            <a href="#" class="link-unstyled category-link" data-category-id="all">All</a>
                                        </div>
                                        @foreach($productCategories as $prodCat)
                                            <div class="border border-2 px-3" style="display: inline-block; white-space: nowrap;">
                                                <a href="#" class="link-unstyled category-link" data-category-id="{{ $prodCat->id }}">{{ $prodCat->name }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Right Scroll Button -->
                                    <div class="col-md-1 btn" id="scroll-right">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 mt-4 mb-3">
                                    <input type="text" id="product-search" class="form-control mb-3" placeholder="Search products...">
                                    <div class="d-flex flex-wrap" style="max-height: 400px; overflow-y: auto;" id="product-table">
                                        <div id="product-table-body" class="d-flex flex-wrap"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('sells.create')
                            <button class="btn btn-success mt-3" type="submit">Create</button>
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
@section('css')
    <style>
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

        .product-card {
            width: 100px;
            margin: 5px;
            padding: 2px 0;
        }
        .product-card img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
        }
        .product-card .card-body {
            padding: 5px;
            text-align: left;
        }
        .active-category {
            background-color: #2573d9;
            border-color: #0c5460;
            color: white;
        }
        .active-category .category-link {
            color: white;
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
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            const sessionCurrency = @json(session('currency'));
            const scrollContainer = document.getElementById('scroll-container');
            const scrollAmount = 300; // Adjust this value to scroll more or less
            let selectedProducts = {};

            // Scroll functionality
            document.getElementById('scroll-left').addEventListener('click', function() {
                scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
            document.getElementById('scroll-right').addEventListener('click', function() {
                scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });

            // Fetch products based on the selected category
            function fetchProducts(categoryId) {
                $.ajax({
                    url: categoryId === 'all' ? '/api/get-all-products' : '/api/get-products-by-category',
                    type: 'GET',
                    data: categoryId === 'all' ? {} : { category_id: categoryId },
                    success: function(response) {
                        let productTableBody = $('#product-table-body');
                        productTableBody.empty(); // Clear the container

                        if (Array.isArray(response.products) && response.products.length > 0) {
                            response.products.forEach((item) => {
                                let product = item.product;
                                let priceInSessionCurrency = null;

                                if (Array.isArray(item.sell_prices) && item.sell_prices.length > 0) {
                                    item.sell_prices.forEach((sellPrice) => {
                                        if (sellPrice.currency_id === sessionCurrency.id) {
                                            priceInSessionCurrency = sellPrice.price;
                                        }
                                    });
                                }

                                if (priceInSessionCurrency === null) {
                                    priceInSessionCurrency = "Price was not provided";
                                }

                                let productCard = `
                            <div class="card text-center product-card" style="border: none;"
                                data-product-id="${product.id}"
                                data-product-name="${product.name}"
                                data-product-sku="${product.sku}"
                                data-product-price="${priceInSessionCurrency}"
                                data-product-quantity="${item.quantity}">
                                <div class="card-img-top">
                                    <img src="/uploads/${product.thumbnail}" alt="${product.name}">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 12px; margin: 0;">${product.name || 'N/A'}</h5>
                                    <p class="card-text" style="font-size: 10px; margin: 0;">SKU: ${product.sku || 'N/A'}</p>
                                    <p class="card-text" style="font-size: 10px; margin: 0;">Quantity: ${item.quantity}</p>
                                    <p class="card-text" style="font-size: 10px; margin: 0;">Price: ${priceInSessionCurrency}</p>
                                </div>
                            </div>
                        `;
                                productTableBody.append(productCard);
                            });
                        } else {
                            console.warn('No products available for this category or incorrect response format.');
                            productTableBody.append('<p>No products available in this category.</p>');
                        }

                        // Attach the click event for selecting products
                        attachProductCardClick();
                    },
                    error: function(err) {
                        console.error('Error fetching products:', err);
                    }
                });
            }

            // Attach click event to product cards
            function attachProductCardClick() {
                $('.product-card').off('click').on('click', function() {
                    const productId = $(this).data('product-id');
                    const productName = $(this).data('product-name');
                    const productPrice = $(this).data('product-price') === "Price was not provided" ? null : parseFloat($(this).data('product-price'));
                    const productQuantity = parseInt($(this).data('product-quantity'));

                    if (productQuantity <= 0) {
                        alert('Stock out, selection not possible');
                        return;
                    }

                    if (!selectedProducts[productId]) {
                        selectedProducts[productId] = {
                            name: productName,
                            price: productPrice,
                            quantity: 1,
                            maxQuantity: productQuantity,
                            discount: 0 // Initialize discount
                        };
                    } else {
                        if (selectedProducts[productId].quantity < productQuantity) {
                            selectedProducts[productId].quantity += 1;
                        } else {
                            alert('Stock out, selection not possible anymore');
                            return;
                        }
                    }

                    renderSelectedProducts();
                });
            }

            // Render selected products in the table
            function renderSelectedProducts() {
                let selectedProductsBody = $('#selected-products-body');
                selectedProductsBody.empty();

                let total = 0;

                Object.keys(selectedProducts).forEach(productId => {
                    const product = selectedProducts[productId];

                    const productPrice = product.price !== null ? product.price : 0;
                    const productQuantity = product.quantity;

                    // Calculate total
                    const productTotal = productQuantity * productPrice;

                    const tableRow = `
                <tr>
                    <td>${product.name}</td>
                    <td>
                        <input type="number" min="0" value="${productPrice.toFixed(2)}" class="price-input form-control" data-product-id="${productId}" readonly>
                    </td>
                    <td>
                        <input type="number" min="1" max="${product.maxQuantity}" value="${productQuantity}"
                            class="quantity-input form-control" data-product-id="${productId}">
                    </td>
                    <td>
                        <input type="number" min="0" class="discount-input form-control" data-product-id="${productId}" value="${product.discount.toFixed(2)}" placeholder="0.00%">
                    </td>
                    <td class="product-total">${productTotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger remove-product" data-product-id="${productId}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

                    selectedProductsBody.append(tableRow);
                    total += productTotal;
                });

                selectedProductsBody.append(`
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>${total.toFixed(2)}</strong></td>
            </tr>
        `);

                $('.remove-product').off('click').on('click', function() {
                    const productId = $(this).data('product-id');
                    delete selectedProducts[productId];
                    renderSelectedProducts();
                });

                $('.quantity-input').off('change').on('change', function() {
                    const productId = $(this).data('product-id');
                    const newQuantity = parseInt($(this).val());

                    if (newQuantity >= 1 && newQuantity <= selectedProducts[productId].maxQuantity) {
                        selectedProducts[productId].quantity = newQuantity;
                    } else {
                        alert('Invalid quantity. Please enter a valid quantity.');
                        $(this).val(selectedProducts[productId].quantity);
                    }

                    renderSelectedProducts();
                });

                $('.discount-input').off('change').on('change', function() {
                    const productId = $(this).data('product-id');
                    const discountValue = parseFloat($(this).val()) || 0;

                    // Validate discount
                    if (discountValue < 0) {
                        alert('Invalid discount. Please enter a valid percentage.');
                        $(this).val(''); // Reset the input
                        return;
                    }

                    // Calculate discounted price
                    const originalPrice = selectedProducts[productId].price || 0;
                    const discountedPrice = originalPrice - (originalPrice * (discountValue / 100));
                    selectedProducts[productId].discount = discountValue; // Store discount percentage
                    selectedProducts[productId].price = discountedPrice; // Update to discounted price

                    // Update the product total
                    const productTotal = selectedProducts[productId].quantity * discountedPrice;
                    $(this).closest('tr').find('.product-total').text(productTotal.toFixed(2));

                    updateOverallTotal(); // Call to recalculate overall total
                });
            }

            // Update the overall total
            function updateOverallTotal() {
                let overallTotal = 0;

                $('#selected-products-body .product-total').each(function() {
                    overallTotal += parseFloat($(this).text()) || 0;
                });

                $('#overall-total').text(overallTotal.toFixed(2));
            }

            // Cancel button functionality
            $('#cancel-button').on('click', function() {
                if (confirm('Are you sure you want to cancel?')) {
                    selectedProducts = {}; // Clear selected products
                    renderSelectedProducts(); // Refresh the selected products table
                }
            });

            // On page load, fetch all products
            fetchProducts('all');

            // Handle category selection change
            $('#category-select').on('change', function() {
                const selectedCategory = $(this).val();
                fetchProducts(selectedCategory);
            });
        });
    </script>
@stop

