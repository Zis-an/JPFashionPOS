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
