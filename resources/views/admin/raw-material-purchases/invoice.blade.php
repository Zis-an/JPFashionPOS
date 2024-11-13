<!DOCTYPE html>
<html>
<head>
    <title>Raw Material Purchase Invoice</title>
    <style>
        /* A4 size setup */
        @page { size: A4; margin: 20px; }

        /* General styles */
        body { font-family: 'Arial', sans-serif; padding: 20px; font-size: 11px; color: #333; }
        .invoice-container { max-width: 700px; margin: 0 auto; text-align: center; color: #333; }

        /* Header styles */
        .header { margin-bottom: 10px; }
        .header img { width: 70px; }
        .header h1 { font-size: 20px; margin: 5px 0; font-weight: bold; color: #333; }
        .company-name { font-size: 14px; color: #555; margin-bottom: 15px; }

        /* Invoice details */
        .details { text-align: left; margin: 5px 0; font-size: 10px; color: #333; }
        .details p { margin: 2px 0; font-weight: bold; }

        /* Table styles */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px 3px; border: 1px solid #ccc; text-align: center; font-size: 10px; }
        th { background-color: #444; color: #fff; font-weight: bold; }
        td { color: #333; font-weight: normal; }

        /* Reduce whitespace in cells */
        th, td { padding: 5px; }

        /* Section titles */
        h3 { text-align: left; font-size: 12px; font-weight: bold; margin: 10px 0; color: #333; }

        /* Footer */
        .footer { margin-top: 20px; font-size: 10px; color: #666; text-align: center; }
    </style>

    <script>
        window.onload = function() {
            window.print();
        };
        // Close the window when printing is completed
        window.onafterprint = function () {
            window.close();
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

    <!-- Supplier and Purchase details -->
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
    <h3>Raw Materials</h3>
    <table>
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
                <td>{{ optional($brands->firstWhere('id', $product->pivot->brand_id))->name ?? 'N/A' }}</td>
                <td>{{ optional($sizes->firstWhere('id', $product->pivot->size_id))->name ?? 'N/A' }}</td>
                <td>{{ optional($colors->firstWhere('id', $product->pivot->color_id))->color_name ?? 'N/A' }}</td>
                <td>{{ $product->pivot->price }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ $product->pivot->total_price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Cost Details Table -->
    <h3>Cost Details</h3>
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
