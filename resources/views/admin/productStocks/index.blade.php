@extends('adminlte::page')
@section('title', 'Product Stocks')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Product Stocks</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Product Stocks</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('productStocks.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Total Avg Cost</th>
                                <th>Showroom</th>
                                <th>Color</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Sell Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->product->name ?? '' }}</td>
                                    <td>{{ $stock->quantity ?? '' }}</td>
                                    <td>{{ $stock->total_cost_price ?number_format($stock->total_cost_price,2): '' }}</td>
                                    <td>{{ $stock->showroom->name ?? '' }}</td>
                                    <td>{{ $stock->color->color_name ?? '' }}</td>
                                    <td>{{ $stock->brand->name ?? '' }}</td>
                                    <td>{{ $stock->size->name ?? '' }}</td>
                                    <td>{{ $stock->product_sell_prices->count() ?? 'Not Set yet' }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm px-1 py-0" onclick="openSellPriceModal({{ $stock->id }}, '{{ $stock->product->name }}')">
                                            Update Sell Price
                                        </button>
                                        <form class="d-inline" action="{{ route('admin.product-stocks.destroy', $stock->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('productStocks.view')
                                                <a href="{{ route('admin.product-stocks.show',['product_stock'=>$stock->id]) }}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i> View</a>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Total Avg Cost</th>
                                <th>Showroom</th>
                                <th>Color</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Sell Price</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Global Sell Price Modal -->
                <div class="modal fade" id="globalSellPriceModal" tabindex="-1" aria-labelledby="globalSellPriceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="globalSellPriceModalLabel">Update Sell Price for <span id="modalProductName"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="globalSellPriceForm" method="POST">
                                    @csrf
                                    <table class="table table-bordered table-sm" id="priceListTable">
                                        <thead>
                                        <tr>
                                            <th>Currency</th>
                                            <th>Sell Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Dynamically loaded currency options will go here -->
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <label for="currency">Currency:</label>
                                        <select class="form-control" name="currency_id" id="currency_id">
                                            <option value="">Select Currency</option>
                                            <!-- Dynamically loaded currency options -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sell_price">Sell Price:</label>
                                        <input type="number" step="0.01" class="form-control" name="sell_price" id="sell_price" required>
                                    </div>
                                    <input type="hidden" name="product_stock_id" id="modalProductStockId">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="updateSellPrice()">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endcan

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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)


@section('css')

@stop

@section('js')

    <script>
        function openSellPriceModal(stockId, productName) {
            // Set the product name in the modal title
            $('#modalProductName').text(productName);

            // Set the product stock ID in the hidden input field
            $('#modalProductStockId').val(stockId);

            // Clear previous form values
            $('#currency_id').empty();
            $('#sell_price').val('');


            // Fetch the product's sell price data using AJAX
            $.ajax({
                url: `/api/product-stocks/${stockId}/get-sell-price-data`, // Create this route
                type: 'GET',
                success: function (response) {
                    //response = typeof response === 'string' ? JSON.parse(response) : response;
                    if (Array.isArray(response.currencies)) {
                        let currencies = response.currencies;
                        let sellPrice = response.sellPrice;
                        let productSellPriceList = response.productSellPriceList;

                        // Clear the previous options
                        $('#currency_id').empty();
                        $('#priceListTable tbody').empty();

                        // Populate the currency dropdown
                        currencies.forEach(currency => {
                            $('#currency_id').append(
                                `<option value="${currency.id}">${currency.name} (${currency.code})</option>`
                            );
                        });// Populate the currency dropdown
                        productSellPriceList.forEach(productSellPrice => {
                            $('#priceListTable tbody').append(
                                `<tr>
                                    <td>${productSellPrice.currency.name}</td>
                                    <td>${productSellPrice.sell_price} ${productSellPrice.currency.code}</td>
                                </tr>`
                            );
                        });

                        // Set the current sell price if available
                        if (sellPrice) {
                            $('#sell_price').val(sellPrice);
                        }
                    } else {
                        console.error("Currencies data is not an array");
                    }


                    // Show the modal
                    $('#globalSellPriceModal').modal('show');
                },
                error: function (xhr) {
                    alert('Error fetching data');
                }
            });
        }

        function updateSellPrice() {
            let stockId = $('#modalProductStockId').val(); // Ensure this ID exists

            // Manually create an object for form data
            let formData = {
                currency_id: $('#currency_id').val(), // Assuming you have a select with this ID
                sell_price: $('#sell_price').val() // Assuming you have an input with this ID
            };

            // Check if stockId is present and not empty
            if (!stockId) {
                alert('Stock ID is missing. Please try again.');
                return;
            }

            $.ajax({
                url: `/api/product-stocks/${stockId}/update-sell-price`, // Create this route for updating sell prices
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Check if response indicates success
                    if (response.success) { // Change this to response.success if that's how your API returns success
                        $('#globalSellPriceModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Sell Price updated successfully!',
                        }).then(() => {
                            // Reopen the modal
                            openSellPriceModal(stockId, $('#modalProductName').text()); // Pass the stock ID and product name to reopen
                        });
                    } else {
                        alert(response.message); // Display the message returned from the server
                    }
                },
                error: function (xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value.join(', ') + '\n'; // Join multiple errors for each field
                        });
                        alert('Validation Error:\n' + errorMessage);
                    } else {
                        // Handle other errors
                        alert('Error: ' + (xhr.responseJSON.message || 'An unexpected error occurred.'));
                    }
                }
            });
        }


        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete Stock')),
                text: @json(__('Are you sure you want to delete this?')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('Delete')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                console.log(result)
                if (result.value) {
                    // Trigger the form submission
                    form.submit();
                }
            });
        }

        $(document).ready(function() {
            $("#adminsList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copy',
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                    },
                    {
                        extend: 'colvis',
                        text: 'Colvis',
                    }
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
