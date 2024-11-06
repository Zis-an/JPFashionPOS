<!DOCTYPE html>
<html>
<head>
    <title>Sell Invoice</title>
    <style>
        /* A4 size setup */
        @page { size: A4; margin: 20px; }

        /* General styles */
        body { font-family: 'Arial', sans-serif; padding: 40px; }
        .invoice-container { max-width: 800px; margin: 0 auto; text-align: center; }

        /* Header styles */
        .header { margin-bottom: 20px; }
        .header img { width: 100px; }
        .header h1 { font-size: 28px; margin-top: 5px; font-weight: bold; color: #2a2a2a; }
        .company-name { font-size: 18px; color: #2a2a2a; margin-bottom: 30px; }

        /* Invoice details */
        .details { text-align: left; margin: 20px 0; font-size: 14px; }
        .details p { margin: 5px 0; }
        .details strong { color: #2a2a2a; }

        /* Table styles */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #2a2a2a; color: #ffffff; font-weight: bold; }

        /* Footer */
        .footer { margin-top: 30px; font-size: 12px; color: #666; text-align: center; }

        /* Highlight net total */
        .net-total { font-size: 18px; font-weight: bold; color: #2a2a2a; margin-top: 20px; }
    </style>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
<div class="invoice-container">
    <!-- Header with logo and company name -->
    <div class="header">
        <img src="{{ asset('jp.jpg') }}" alt="Company Logo">
        <h1>Invoice</h1>
        <p class="company-name">JP Fashion</p>
    </div>

    <!-- Customer and Salesman details -->
    <div class="details">
        <p><strong>Supplier Name:</strong> {{ $purchase->supplier->name ?? 'N/A' }}</p>
        <p><strong>Warehouse:</strong> {{ $purchase->warehouse->name ?? 'N/A' }}</p>
        <p><strong>Account:</strong> {{ $purchase->account->name ?? 'N/A' }}</p>
        <p><strong>Purchase Date:</strong> {{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('F j, Y') : 'N/A' }}</p>
        <p><strong>Total Cost:</strong> {{ $purchase->total_cost ?? 'N/A' }}</p>
        <p><strong>Total Price:</strong> {{ $purchase->total_price ?? 'N/A' }}</p>
        <p><strong>Amount:</strong> {{ $purchase->amount ?? 'N/A' }}</p>
    </div>

    <!-- Raw Materials Table -->
    <h3 class="text-left">Raw Materials</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Size</th>
            <th>Color</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                @foreach($brands as $brand)
                    @if($brand->id == $product->pivot->brand_id)
                        <td>{{ $brand->name }}</td>
                    @endif
                @endforeach
                @foreach($sizes as $size)
                    @if($size->id == $product->pivot->size_id)
                        <td>{{ $size->name }}</td>
                    @endif
                @endforeach
                @foreach($colors as $color)
                    @if($color->id == $product->pivot->color_id)
                        <td>{{ $color->color_name }}</td>
                    @endif
                @endforeach
                <td>{{ $product->pivot->price }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ $product->pivot->total_price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3 class="text-left">Cost Details</h3>
    <table>
        <thead>
        <tr>
            <th>Detail</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach(json_decode($purchase->cost_details, true) as $cost)
            <tr>
                <td>{{ $cost['detail'] }}</td>
                <td>{{ $cost['amount'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for shopping with JP Fashion!</p>
    </div>
</div>

</body>
</html>
