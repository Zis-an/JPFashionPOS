<!DOCTYPE html>
<html>
<head>
    <title>Sell Invoice</title>
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

        /* Footer */
        .footer { margin-top: 20px; font-size: 10px; color: #666; text-align: center; }

        /* Highlight net total */
        .net-total { font-size: 14px; font-weight: bold; color: #444; margin-top: 10px; }
    </style>
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
        <p><strong>Customer Name:</strong> {{ $sell->customer->name ?? 'N/A' }}</p>
        <p><strong>Salesman Name:</strong> {{ $sell->salesman->name ?? 'N/A' }}</p>
    </div>

    <!-- Product Table -->
    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Discount Type</th>
            <th>Discount Amount</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($existingProducts as $product)
            <tr>
                <td>{{ getProductName($product->id) }}</td>
                <td>{{ $product->price ?? 'N/A' }}</td>
                <td>{{ $product->quantity ?? 'N/A' }}</td>
                <td>{{ $product->discount_type ?? 'N/A' }}</td>
                <td>{{ $product->discount_amount ?? 'N/A' }}</td>
                <td>{{ $product->total ?? 'N/A' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Net Total -->
    <p class="net-total">Net Total: {{ $sell->net_total ?? 'N/A' }}</p>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for shopping with JP Fashion!</p>
    </div>
</div>

</body>
</html>
