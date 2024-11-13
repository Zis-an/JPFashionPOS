<!DOCTYPE html>
<html>
<head>
    <title>Production Invoice</title>
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
        <h1>Production Invoice</h1>
        <p class="company-name">JP Fashion</p>
    </div>

    <!-- Production and Showroom details -->
    <div class="details">
        <p><strong>Production House:</strong> {{ $production->productionHouse->name ?? 'N/A' }}</p>
        <p><strong>Showroom:</strong> {{ $production->showroom->name ?? 'N/A' }}</p>
        <p><strong>Account:</strong> {{ $production->account->name ?? 'N/A' }}</p>
        <p><strong>Production Date:</strong> {{ $production->production_date ? \Carbon\Carbon::parse($production->production_date)->format('F j, Y') : 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($production->status ?? 'Pending') }}</p>
        <p><strong>Total Cost:</strong> {{ $production->total_cost ?? 'N/A' }}</p>
        <p><strong>Total Amount:</strong> {{ $production->amount ?? 'N/A' }}</p>
    </div>

    <!-- Raw Material Details Table -->
    <h3>Raw Material Details</h3>
    <table>
        <thead>
        <tr>
            <th>Material Name</th>
            <th>Brand</th>
            <th>Size</th>
            <th>Color</th>
            <th>Warehouse</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($production->rawMaterials as $material)
            <tr>
                <td>{{ optional($material->rawMaterial)->name }}</td>
                <td>{{ optional($material->brand)->name }}</td>
                <td>{{ optional($material->size)->name }}</td>
                <td>{{ optional($material->color)->color_name }}</td>
                <td>{{ optional($material->warehouse)->name }}</td>
                <td>{{ $material->price }}</td>
                <td>{{ $material->quantity }}</td>
                <td>{{ $material->total_price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Product Details Table -->
    <h3>Product Details</h3>
    <table>
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Size</th>
            <th>Color</th>
            <th>Cost per Qty</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($production->products as $productionProduct)
            <tr>
                <td>{{ optional($productionProduct->product)->name }}</td>
                <td>{{ optional($productionProduct->brand)->name }}</td>
                <td>{{ optional($productionProduct->size)->name }}</td>
                <td>{{ optional($productionProduct->color)->color_name }}</td>
                <td>{{ $productionProduct->per_pc_cost }}</td>
                <td>{{ $productionProduct->quantity }}</td>
                <td>{{ $productionProduct->sub_total }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your business with JP Fashion!</p>
    </div>
</div>

</body>
</html>
