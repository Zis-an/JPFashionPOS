@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard
        <span class="small badge badge-sm badge-success" id="current-time">
        {{ \Carbon\Carbon::now()->format('F j, Y at g:i A') }}
        </span>
    </h1>
@stop
@section('content')
    <div class="row">
        @if(!isLastCronJobLogWithinOneHour())
        <div class="col-12">
            <pre class="text-danger">
                {{ getCronJobCommand('queue') }}
                {{ getCronJobCommand('schedule') }}
            </pre>
        </div>
        @endif
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ countSales()['todaySaleCount'] }}</h3>
                    <p>Today's Sale</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="{{ route('admin.sells.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ countSales()['last7DaysSaleCount'] }}</h3>
                    <p>Last 7 Days Sale</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="{{ route('admin.sells.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ countSales()['currentMonthSaleCount'] }}</h3>
                    <p>Current Month's Sale</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="{{ route('admin.sells.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ countSales()['currentYearSaleCount'] }}</h3>
                    <p>Current Year's Sale</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="{{ route('admin.sells.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ countSales()['pendingSaleCount'] ?? 0 }}</h3>
                    <p>Pending Sale</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="{{ route('admin.sells.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ countProductStock() }}</h3>
                    <p>Product Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <a href="{{ route('admin.product-stocks.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ countRawMaterialStock() }}</h3>
                    <p>Raw Material Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <a href="{{ route('admin.raw-material-stocks.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ countAssets()['assetCount'] }}</h3>
                    <!-- Total Amount positioned in the top-right corner -->
                    <small class="text-black-500" style="position: absolute; top: 10px; right: 10px; font-size: 0.75rem;">
                        Total Amount: {{ countAssets()['assetAmount'] }}
                    </small>
                    <p>Total Asset</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <a href="{{ route('admin.assets.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Small Cards -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Raw Material Pending Purchases</span>
                    <span class="info-box-number">{{ countRawMaterialPurchase()['pendingRawMaterialPurchase'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Raw Material Approved Purchases</span>
                    <span class="info-box-number">{{ countRawMaterialPurchase()['approvedRawMaterialPurchase'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending Productions</span>
                    <span class="info-box-number">{{ countProductions()['pendingProductions'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Approved Productions</span>
                    <span class="info-box-number">{{ countProductions()['approvedProductions'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Today's Expense</span>
                    <span class="info-box-number">{{ countExpense()['todayExpenseCount'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Last 7 Day's Expense</span>
                    <span class="info-box-number">{{ countExpense()['last7DaysExpenseCount'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Current Month's Expense</span>
                    <span class="info-box-number">{{ countExpense()['currentMonthExpenseCount'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <span class="info-box-icon bg-danger">
                    <i class="far fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Current Year's Expense</span>
                    <span class="info-box-number">{{ countExpense()['currentYearExpenseCount'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>

    <!-- Graph Starts -->
    <?php $chartData = getMonthlyDaywiseChartData(); ?>
    <div class="row g-0">
        <div class="col-md-6 mb-3" style="background-color: white;">
            <label>Current Month's Sell Graph</label>
            <!-- New Line Chart -->
            <div>
                <canvas id="sellChart"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-3" style="background-color: white;">
            <label>Current Month's Expense Graph</label>
            <!-- New Line Chart -->
            <div>
                <canvas id="expenseChart"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-3" style="background-color: white;">
            <label>Current Month's Assets Graph</label>
            <!-- New Line Chart -->
            <div>
                <canvas id="assetsChart"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-3" style="background-color: white;">
            <label>Current Month's Accounts Graph</label>
            <!-- New Line Chart -->
            <div>
                <canvas id="accountsChart"></canvas>
            </div>
        </div>
    </div>


    <!-- Table Starts -->
    <div class="row">
        <div class="col-md-6 col-12 mt-2" style="background-color: white;">
            <label>Latest Sale</label>
            <table class="table table-sm table-striped table-hover table-bordered mt-3">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Salesman</th>
                    <th scope="col">Account</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Net Total</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $sales = getLatestSales();
                @endphp

                @if ($sales->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <i class="bi bi-clipboard-x" style="font-size: 2rem; color: #6c757d;"></i>
                                <p class="mt-2 mb-0" style="color: #6c757d; font-weight: bold;">No Recent Sales</p>
                                <small style="color: #adb5bd;">Sales data will appear here once available.</small>
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach ($sales as $index => $sale)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $sale->customer->name ?? '' }}</td>
                            <td>{{ $sale->salesman->name ?? '' }}</td>
                            <td>{{ $sale->account->name ?? '' }}</td>
                            <td>{{ $sale->total_amount ?? '' }}</td>
                            <td>{{ $sale->discount_amount ?? '' }}</td>
                            <td>{{ $sale->net_total ?? '' }}</td>
                            <td>{{ $sale->status ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-12 mt-2" style="background-color: white;">
            <label>Latest Raw Material Purchase</label>
            <table class="table table-sm table-striped table-hover table-bordered mt-3">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Warehouse</th>
                    <th scope="col">Account</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $purchases = getLatestRawMaterialPurchases();
                @endphp

                @if ($purchases->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <i class="bi bi-clipboard-x" style="font-size: 2rem; color: #6c757d;"></i>
                                <p class="mt-2 mb-0" style="color: #6c757d; font-weight: bold;">No Recent Raw Material Purchases</p>
                                <small style="color: #adb5bd;">Purchase data will appear here once available.</small>
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach ($purchases as $index => $purchase)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $purchase->supplier->name ?? '' }}</td>
                            <td>{{ $purchase->warehouse->name ?? '' }}</td>
                            <td>{{ $purchase->account->name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->toDateString() ?? '' }}</td>
                            <td>${{ number_format($purchase->total_cost, 2) ?? '' }}</td>
                            <td>${{ number_format($purchase->total_price, 2) ?? '' }}</td>
                            <td>${{ number_format($purchase->amount, 2) ?? '' }}</td>
                            <td>{{ $purchase->status ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-12 mt-2" style="background-color: white;">
            <label>Latest Production</label>
            <table class="table table-sm table-striped table-hover table-bordered mt-3">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">PDN House</th>
                    <th scope="col">Showroom</th>
                    <th scope="col">Account</th>
                    <th scope="col">PDN Date</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Total R.M. Cost</th>
                    <th scope="col">Total Product Cost</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $productions = getLatestProductions();
                @endphp

                @if ($productions->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <i class="bi bi-clipboard-x" style="font-size: 2rem; color: #6c757d;"></i>
                                <p class="mt-2 mb-0" style="color: #6c757d; font-weight: bold;">No Recent Productions</p>
                                <small style="color: #adb5bd;">Production data will appear here once available.</small>
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach ($productions as $index => $production)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $production->productionHouse->name ?? '' }}</td>
                            <td>{{ $production->showroom->name ?? '' }}</td>
                            <td>{{ $production->account->name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse( $production->production_date)->toDateString() ?? '' }}</td>
                            <td>{{ $production->total_cost ?? '' }}</td>
                            <td>{{ $production->total_raw_material_cost ?? '' }}</td>
                            <td>{{ $production->total_product_cost ?? '' }}</td>
                            <td>{{ $production->amount ?? '' }}</td>
                            <td>{{ $production->status ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-12 mt-2" style="background-color: white;">
            <label>Latest Expense</label>
            <table class="table table-sm table-striped table-hover table-bordered mt-3">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Account</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $expenses = getLatestExpenses();
                @endphp

                @if ($expenses->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <i class="bi bi-clipboard-x" style="font-size: 2rem; color: #6c757d;"></i>
                                <p class="mt-2 mb-0" style="color: #6c757d; font-weight: bold;">No Recent Expenses</p>
                                <small style="color: #adb5bd;">Expense data will appear here once available.</small>
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach ($expenses as $index => $expense)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $expense->title ?? '' }}</td>
                            <td>{{ $expense->category->name ?? '' }}</td>
                            <td>{{ $expense->account->name ?? '' }}</td>
                            <td>${{ number_format($expense->amount, 2) ?? '' }}</td>
                            <td>{{ $expense->status ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('css')
@stop
@section('js')
    <!-- Load Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof Chart !== 'undefined') {
                // Dummy data for all charts
                const chartData = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Data',
                        data: [10, 20, 15, 25, 30, 20, 35],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4 // Smooth line
                    }]
                };

                // Chart configuration
                const config = {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                // Initialize each chart with its unique ID
                new Chart(document.getElementById('sellChart').getContext('2d'), config);
                new Chart(document.getElementById('expenseChart').getContext('2d'), config);
                new Chart(document.getElementById('assetsChart').getContext('2d'), config);
                new Chart(document.getElementById('accountsChart').getContext('2d'), config);
            } else {
                console.error("Chart.js library did not load.");
            }
        });
    </script>
    <script>
        // Day-wise data for each component
        const sellData = <?php echo $chartData['sellData']; ?>;
        const sellLabels = <?php echo $chartData['sellLabels']; ?>;

        const expenseData = <?php echo $chartData['expenseData']; ?>;
        const expenseLabels = <?php echo $chartData['expenseLabels']; ?>;

        const assetsData = <?php echo $chartData['assetsData']; ?>;
        const assetsLabels = <?php echo $chartData['assetsLabels']; ?>;

        const accountsData = <?php echo $chartData['accountsData']; ?>;
        const accountsLabels = <?php echo $chartData['accountsLabels']; ?>;

        // Chart for Sells (day vs. sells)
        const sellChartCtx = document.getElementById('sellChart').getContext('2d');
        new Chart(sellChartCtx, {
            type: 'line',
            data: {
                labels: sellLabels,
                datasets: [{
                    label: 'Sells',
                    data: sellData,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        // Chart for Expenses (day vs. expenses)
        const expenseChartCtx = document.getElementById('expenseChart').getContext('2d');
        new Chart(expenseChartCtx, {
            type: 'line',
            data: {
                labels: expenseLabels,
                datasets: [{
                    label: 'Expenses',
                    data: expenseData,
                    borderColor: 'red',
                    fill: false
                }]
            }
        });

        // Chart for Assets (day vs. assets)
        const assetsChartCtx = document.getElementById('assetsChart').getContext('2d');
        new Chart(assetsChartCtx, {
            type: 'line',
            data: {
                labels: assetsLabels,
                datasets: [{
                    label: 'Assets',
                    data: assetsData,
                    borderColor: 'green',
                    fill: false
                }]
            }
        });

        // Chart for Accounts (day vs. accounts balance)
        const accountsChartCtx = document.getElementById('accountsChart').getContext('2d');
        new Chart(accountsChartCtx, {
            type: 'line',
            data: {
                labels: accountsLabels,
                datasets: [{
                    label: 'Accounts',
                    data: accountsData,
                    borderColor: 'purple',
                    fill: false
                }]
            }
        });
    </script>
    <script>
        function updateTime() {
            const options = {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            const now = new Date().toLocaleString('en-US', options);
            document.getElementById('current-time').textContent = now;
        }

        // Update time every second
        setInterval(updateTime, 1000);
    </script>
@stop
