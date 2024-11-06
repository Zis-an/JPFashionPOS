@extends('adminlte::page')
@section('title', 'Edit Sell')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex">
                <h1>Edit Sell</h1>
                <div class="ml-2">
                    <form action="{{ route('sells.setCurrency') }}" method="POST">
                        @csrf
                        <select id="currency_id" name="currency_id" class="select2 form-control input-sm" onchange="this.form.submit()">
                            <option value="">Select Currency</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                    {{ session('currency') && session('currency')['id'] === $currency->id ? 'selected' : '' }}>
                                    {{ $currency->name }}
                                </option>
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
                    <form action="{{ route('admin.sells.update', ['sell'=>$sell->id]) }}" method="POST"
                          enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-6 border" id="selected-products-table">
                                <h5 class="mb-2 text-center">Selected Products</h5>
                                <hr>
                                <div class="col-12">
                                    <div class="form-group mb-2">
                                        <select name="customer" class="select2 form-control input-sm" id="customer">
                                            <option value="" disabled selected> Select Customer </option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ $sell->customer_id == $customer->id ? 'selected' : ''}}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                    <tr>
                                        <th style="width: 100px;">Name</th>
                                        <th style="width: 120px;">Price</th>
                                        <th style="width: 100px;">Quantity</th>
                                        <th style="width: 130px;">Discount Type</th>
                                        <th style="width: 120px;">Discount (%)</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="selected-products-body" style="overflow-y: auto;">
                                    <!-- Selected products will be populated here -->
                                    </tbody>
                                </table>
                                <div class="p-2 mb-3" style="background-color: #f0fbee; border-radius: 10px;">
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label for="salesman">Salesman <span class="text-danger font-weight-bolder">*</span></label>
                                                <select name="salesman" class="select2 form-control input-sm" id="salesman" required>
                                                    @foreach($salesman as $man)
                                                        <option value="{{ $man->id }}" {{ $sell->salesman_id == $man->id ? 'selected' : ''}}>
                                                            {{ $man->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label for="account">Accounts <span class="text-danger font-weight-bolder">*</span></label>
                                                <select name="account_id" class="select2 form-control input-sm" id="account" required>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->id }}" {{ $sell->account_id == $account->id ? 'selected' : '' }}>
                                                            {{ $account->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label for="paidAmount">Paid Amount</label>
                                                <select name="paidAmountOption" class="form-control input-sm" id="paidAmountOption" onchange="toggleAmountInput()">
                                                    <option value="paid_in_full">Paid In Full</option>
                                                    <option value="custom_amount">Enter Custom Amount</option>
                                                </select>
                                                <input type="number" step="0.01" name="amount" class="form-control input-sm mt-2" id="amount" placeholder="Enter amount" style="display:none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Select Status</label>
                                        <select id="status" name="status" class="select2 form-control">
                                            <option value="pending" {{ $sell->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="rejected" {{ $sell->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="approved" {{ $sell->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        </select>
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
                                    <input type="text" id="product-search" class="form-control input-sm mb-3" placeholder="Search products...">
                                    <div id="product-table">
                                        <div id="product-table-body" class="row justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('sells.update')
                            <button class="btn btn-success mt-3" type="submit">Update</button>
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
            let existingProductsArray = @json($existingProducts);
            let existingProducts = {};

            // Convert the array to an object using the product ID as the key
            existingProductsArray.forEach(item => {
                existingProducts[item.stock_id] = {
                    id: item.id,
                    name: item.stock.product.name,  // Modify as needed to retrieve name
                    price: item.price || 0,
                    quantity: item.quantity || 0,
                    maxQuantity: (item.quantity + item.stock.quantity) || 0,  // Assuming max quantity is the same as available quantity
                    discount: item.discount_amount || 0,
                    discountType: item.discount_type || 'fixed'
                };
            });

            // Add existing products to selectedProducts
            selectedProducts = { ...existingProducts };

            // Render the table with existing products
            renderSelectedProducts();

            // Initialize functions
            initScrollFunctionality();
            initCategoryClick();
            fetchProducts('all'); // Initial fetch
            initCategorySelectChange();

            // Scroll functionality
            function initScrollFunctionality() {
                document.getElementById('scroll-left').addEventListener('click', function() {
                    scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });
                document.getElementById('scroll-right').addEventListener('click', function() {
                    scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });
            }

            // Handle category click
            function initCategoryClick() {
                $('.category-link').on('click', function(e) {
                    e.preventDefault();
                    $('.category-link').parent().removeClass('active-category');
                    $(this).parent().addClass('active-category');
                    let categoryId = $(this).data('category-id');
                    fetchProducts(categoryId);
                });
            }

            // Fetch products based on the selected category
            function fetchProducts(categoryId) {
                $.ajax({
                    url: categoryId === 'all' ? '/api/get-all-products' : '/api/get-products-by-category',
                    type: 'GET',
                    data: categoryId === 'all' ? {} : { category_id: categoryId },
                    success: function(response) {
                        populateProductTable(response.products);
                        attachProductCardClick(); // Attach event after fetching products
                    },
                    error: function(err) {
                        console.error('Error fetching products:', err);
                    }
                });
            }

            // Populate product table with fetched data
            function populateProductTable(products) {
                let productTableBody = $('#product-table-body');
                productTableBody.empty(); // Clear the container

                if (Array.isArray(products) && products.length > 0) {
                    products.forEach(item => {
                        let product = item.product;
                        let priceInSessionCurrency = getPriceInSessionCurrency(item.sell_prices);

                        let productCard = createProductCard(product, priceInSessionCurrency, item.quantity);
                        productTableBody.append(productCard);
                    });
                } else {
                    productTableBody.append('<p>No products available in this category.</p>');
                }
            }

            // Get price in session currency
            function getPriceInSessionCurrency(sellPrices) {
                let price = null;
                if (Array.isArray(sellPrices) && sellPrices.length > 0) {
                    sellPrices.forEach(sellPrice => {
                        if (sellPrice.currency_id === sessionCurrency.id) {
                            price = sellPrice.price;
                        }
                    });
                }
                return price !== null ? price : "Price was not provided";
            }

            // Create HTML for product card
            function createProductCard(product, price, quantity) {
                return `
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="cursor: pointer">
                            <div class="card text-center border-0 p-0  product-card"
                                data-stock-id="${product.id}"
                                data-product-name="${product.name}"
                                data-product-sku="${product.sku}"
                                data-product-price="${price}"
                                data-product-quantity="${quantity}">
                                <div class="card-body p-1">
                                    <img class="img-fluid img-rounded" style="max-height: 60px" src="/uploads/${product.thumbnail}" alt="${product.name}">
                                    <div class="d-block">${product.name || 'N/A'}</div>
                                    <div class="small">SKU: ${product.sku || 'N/A'}</div>
                                    <div class="small">Quantity: ${quantity}</div>
                                    <div class="small">Price: ${price}</div>
                                </div>
                            </div>
                        </div>`;
            }

            // Attach click event to product cards
            function attachProductCardClick() {
                $('.product-card').off('click').on('click', function() {
                    const stockId = $(this).data('stock-id');
                    const productName = $(this).data('product-name');
                    const productPrice = $(this).data('product-price') === "Price was not provided" ? null : parseFloat($(this).data('product-price'));
                    const productQuantity = parseInt($(this).data('product-quantity'));

                    if (productQuantity <= 0) {
                        swal.fire({
                            title: "Invalid Stock Amount", // Title of the alert
                            text: "Stock out, selection not possible.", // Main text message
                            icon: "error", // Type of alert (error in this case)
                            confirmButtonText: "OK" // Optional: Customize the button text
                        });
                        return;
                    }

                    updateSelectedProducts(stockId, productName, productPrice, productQuantity);
                    renderSelectedProducts();
                });
            }

            // Update selected products based on user selection
            function updateSelectedProducts(stockId, productName, productPrice, productQuantity) {
                if (!selectedProducts[stockId]) {
                    selectedProducts[stockId] = {
                        name: productName,
                        price: productPrice,
                        quantity: 1,
                        maxQuantity: productQuantity,
                        discount: 0 // Initialize discount
                    };
                } else {
                    // if (selectedProducts[stockId].quantity < productQuantity) {
                    if (selectedProducts[stockId].quantity < selectedProducts[stockId].maxQuantity) {
                        selectedProducts[stockId].quantity += 1;
                    } else {

                        swal.fire({
                            title: "Invalid Stock", // Title of the alert
                            text: "Stock out, selection not possible anymore.", // Main text message
                            icon: "error", // Type of alert (error in this case)
                            confirmButtonText: "OK" // Optional: Customize the button text
                        });
                    }
                }
            }


            function renderSelectedProducts() {
                let selectedProductsBody = $('#selected-products-body');
                selectedProductsBody.empty();
                let total = 0;

                Object.keys(selectedProducts).forEach(stockId => {
                    const product = selectedProducts[stockId];
                    const productPrice = product.price !== null ? product.price : 0;
                    const productQuantity = product.quantity;
                    const productTotal = calculateProductTotal(product); // Ensure this function is called
                    const discountType = selectedProducts[stockId].discountType;

                    const tableRow = createSelectedProductRow(stockId, product, productTotal, productPrice, discountType);
                    selectedProductsBody.append(tableRow);
                    total += productTotal; // Accumulate total
                });

                selectedProductsBody.append(`
                    <tr>
                        <td colspan="5"><strong>Total</strong></td>
                        <td id="overall-total"><strong>${total.toFixed(2)}</strong></td>
                    </tr>
                `);

                attachRemoveProductAndQuantityChangeListeners();
                updateOverallTotal(); // Ensure the overall total is updated
            }

            // Calculate total for a product
            function calculateProductTotal(product) {
                return (product.price * product.quantity) - product.discount;
            }

            // Create HTML for selected product row
            function createSelectedProductRow(stockId, product, productTotal, enteredPrice, discountType) {
                return `
                <tr>
                    <td>
                        ${product.name}
                        <input type="hidden" name="stock_id[]" value="${stockId}">
                    </td>
                    <td>
                        <input type="number" name="product_price[]" min="0" value="${enteredPrice.toFixed(2)}" class="price-input form-control input-sm" data-stock-id="${stockId}">
                    </td>
                    <td>
                        <input type="number" name="product_quantity[]" min="1" max="${product.maxQuantity}" value="${product.quantity}" class="quantity-input form-control input-sm" data-stock-id="${stockId}">
                    </td>
                    <td>
                        <select name="discount_type[]" class="form-control input-sm select2 discount_type">
                            <option value="percentage" ${discountType === 'percentage' ? 'selected' : ''}>Percentage</option>
                            <option value="fixed" ${discountType === 'fixed' ? 'selected' : ''}>Fixed</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="discount_amount[]" min="0" class="discount-input form-control input-sm" data-stock-id="${stockId}" value="${product.discount.toFixed(2)}" placeholder="0.00">
                    </td>
                    <td>
                        <input type="text" name="product_total[]" value="${productTotal.toFixed(2)}" class="form-control input-sm product-total" readonly>
                    </td>
                    <td>
                        <button class="btn btn-danger remove-product" data-stock-id="${stockId}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            }

            // Attach listeners for removing products and changing quantities
            function attachRemoveProductAndQuantityChangeListeners() {
                $('.remove-product').off('click').on('click', function() {
                    const stockId = $(this).data('stock-id');
                    delete selectedProducts[stockId]; // Remove product from selectedProducts
                    renderSelectedProducts(); // Re-render the product table
                    updateOverallTotal(); // Update the overall total after rendering
                });


                $('.quantity-input').off('change').on('change', function() {
                    const stockId = $(this).data('stock-id');
                    const newQuantity = parseInt($(this).val());

                    // Ensure the new quantity is within valid limits
                    if (newQuantity >= 1 && newQuantity <= selectedProducts[stockId].maxQuantity) {
                        selectedProducts[stockId].quantity = newQuantity; // Update the selected product quantity
                    } else {
                        swal.fire({
                            title: "Invalid quantity", // Title of the alert
                            text: "Please enter a valid quantity.", // Main text message
                            icon: "error", // Type of alert (error in this case)
                            confirmButtonText: "OK" // Optional: Customize the button text
                        });
                        $(this).val(selectedProducts[stockId].quantity); // Reset to original quantity
                    }

                    renderSelectedProducts(); // Re-render to reflect changes
                    updateOverallTotal(); // Update overall total in real-time
                });

                $('.price-input').off('focus').on('focus', function() {
                    // Prevent resetting the price when focusing on the price input
                    $(this).data('manual-entry', true);
                }).off('blur').on('blur', function() {
                    const stockId = $(this).data('stock-id');
                    const manualPrice = $(this).val();

                    // Keep the manually entered price
                    selectedProducts[stockId].price = parseFloat(manualPrice) || selectedProducts[stockId].price;

                    // Ensure the price input reflects the stored price
                    $(this).val(selectedProducts[stockId].price.toFixed(2));

                    renderSelectedProducts();
                    updateOverallTotal();
                });

                updateProductAndTotalOnDiscountChange();
            }

            // Update product total and overall total when discount or discount type changes
            function updateProductAndTotalOnDiscountChange() {
                $('.discount-input, .discount_type').off('change input').on('change input', function() {
                    const productRow = $(this).closest('tr'); // Get the current product row
                    const stockId = productRow.find('.discount-input').data('stock-id'); // Get the product ID
                    const discountValue = parseFloat(productRow.find('.discount-input').val()) || 0; // Get discount value
                    const discountType = productRow.find('.discount_type').val(); // Get selected discount type
                    const product = selectedProducts[stockId]; // Get the product from the selectedProducts object

                    if (discountValue < 0) {
                        swal.fire({
                            title: "Invalid discount", // Title of the alert
                            text: "Please enter a valid amount.", // Main text message
                            icon: "error", // Type of alert (error in this case)
                            confirmButtonText: "OK" // Optional: Customize the button text
                        });
                        productRow.find('.discount-input').val(''); // Reset the input
                        return;
                    }

                    applyDiscountToProduct(productRow, product, discountValue, discountType);
                    updateOverallTotal();
                });

                // Prevent deletion on Enter key press in discount input
                $('.discount-input').off('keypress').on('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Prevent default action
                    }
                });

                // Prevent deletion on Enter key press in discount input
                $('.price-input').off('keypress').on('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Prevent default action
                    }
                });
            }

            // Apply discount to product total
            function applyDiscountToProduct(productRow, product, discountValue, discountType) {
                const productPrice = product.price || 0; // Ensure product price is valid
                const productQuantity = product.quantity || 0; // Ensure product quantity is valid
                let productTotal = productPrice * productQuantity; // Calculate total before discount

                if (discountType === 'percentage') {
                    const discountAmount = productTotal * (discountValue / 100); // Calculate percentage discount
                    productTotal -= discountAmount; // Subtract discount from total
                } else if (discountType === 'fixed') {
                    productTotal -= discountValue; // Subtract fixed amount from total
                }

                if (productTotal < 0) {
                    swal.fire({
                        title: "Invalid Discount Total", // Title of the alert
                        text: "Discount total cannot be less than zero.", // Main text message
                        icon: "error", // Type of alert (error in this case)
                        confirmButtonText: "OK" // Optional: Customize the button text
                    });
                    productTotal = 0; // Reset to zero if below zero
                }

                selectedProducts[productRow.find('.discount-input').data('stock-id')].discount = discountValue; // Update discount
                productRow.find('.product-total').val(productTotal.toFixed(2)); // Update displayed product total
            }

            // Update the overall total
            function updateOverallTotal() {
                let overallTotal = 0; // Initialize overall total
                $('#selected-products-body .product-total').each(function() {
                    overallTotal += parseFloat($(this).val()) || 0; // Sum all product totals
                });
                $('#overall-total').text(overallTotal.toFixed(2)); // Update displayed overall total
            }

            // Set event listeners for category selection
            function initCategorySelectChange() {
                $('#category-select').on('change', function() {
                    const categoryId = $(this).val();
                    fetchProducts(categoryId);
                });
            }
        });
    </script>
    <script>
        function toggleAmountInput() {
            var select = document.getElementById("paidAmountOption");
            var amountInput = document.getElementById("amount");
            if (select.value === "custom_amount") {
                amountInput.style.display = "block";
            } else {
                amountInput.style.display = "none";
                amountInput.value = ""; // Clear the input when not visible
            }
        }
    </script>
@endsection




