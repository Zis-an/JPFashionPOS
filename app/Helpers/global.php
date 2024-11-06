<?php

use App\Models\Account;
use App\Models\Asset;
use App\Models\Expense;
use App\Models\GlobalSetting;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductStock;
use App\Models\RawMaterialPurchase;
use App\Models\RawMaterialStock;
use App\Models\Sell;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

if (!function_exists('checkRolePermissions')) {

    function checkRolePermissions($role,$permissions){
        $status = true;
        foreach ($permissions as $permission){
            if(!$role->hasPermissionTo($permission)){
                $status = false;
            }
        }

        return $status;
    }
}

if (!function_exists('checkAdminRole')) {

    function checkAdminRole($admin,$role){
        $status = false;
        if($admin->hasAnyRole([$role])){
            $status = true;
        }

        return $status;
    }
}

if (!function_exists('getAssetUrl')) {

    function getAssetUrl($path = null, $name = 'Img', $gender = 'none')
    {
        // Base asset path
        $baseAssetPath = 'uploads/';

        if (strpos($path, $baseAssetPath) !== false) {
            return asset($path);
        } else {
            if ($path && file_exists(public_path($baseAssetPath.$path))) {
                return asset($baseAssetPath.$path);
            }
        }

        // Default path based on gender
        if ($gender === 'male') {
            $defaultAvatar = asset($baseAssetPath . 'avatars/male.png');
        } elseif ($gender === 'female') {
            $defaultAvatar = asset($baseAssetPath . 'avatars/female.png');
        } else {
            // Generate an image URL from an online service using the first letter of the name
            $firstLetter = strtoupper(substr($name, 0, 1));
            // Use DiceBear to generate an avatar based on the first letter
            $defaultAvatar = 'https://avatars.dicebear.com/api/initials/' . urlencode($firstLetter) . '.png';
        }

        // Return the generated or default avatar URL
        return $defaultAvatar;
    }

    if (!function_exists('setSetting')) {

        function setSetting($key, $value)
        {
            GlobalSetting::updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    if (!function_exists('getSetting')) {
        function getSetting($key)
        {
            $setting = GlobalSetting::where('key', $key)->first();
            if ($setting) {
                return $setting->value;
            }
            return null;
        }
    }
}
// Function to generate a color based on the transaction type
if (!function_exists('generateColor')) {
    function generateColor($type) {
        // Define dark colors for each transaction type
        $colors = [
            'Deposit' => [
                'backgroundColor' => 'rgba(0, 128, 0, 0.7)',  // Dark Green
                'borderColor' => 'rgba(0, 128, 0, 1)'
            ],
            'Withdraw' => [
                'backgroundColor' => 'rgba(255, 0, 0, 0.7)',  // Dark Red
                'borderColor' => 'rgba(255, 0, 0, 1)'
            ],
            'AccountTransfer' => [
                'backgroundColor' => 'rgba(0, 0, 255, 0.7)',  // Dark Blue
                'borderColor' => 'rgba(0, 0, 255, 1)'
            ],
            'Expense' => [
                'backgroundColor' => 'rgba(128, 0, 0, 0.7)',  // Darker Red
                'borderColor' => 'rgba(128, 0, 0, 1)'
            ],
            'Asset' => [
                'backgroundColor' => 'rgba(0, 255, 255, 0.7)', // Dark Cyan
                'borderColor' => 'rgba(0, 255, 255, 1)'
            ],
            // Add more types and colors as needed
        ];

        // Return the color for the specified type, or a default color if not defined
        return $colors[$type] ?? [
            'backgroundColor' => 'rgba(128, 128, 128, 0.7)', // Default to Gray
            'borderColor' => 'rgba(128, 128, 128, 1)'
        ];
    }
}

// Function to convert HSL to RGB (if you still want this)
if (!function_exists('hslToRgb')) {
    function hslToRgb($h, $s, $l) {
        $c = (1 - abs(2 * $l - 1)) * $s; // Chroma
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;

        $r = $g = $b = 0;

        if ($h < 60) {
            $r = $c; $g = $x;
        } elseif ($h < 120) {
            $r = $x; $g = $c;
        } elseif ($h < 180) {
            $g = $c; $b = $x;
        } elseif ($h < 240) {
            $g = $x; $b = $c;
        } elseif ($h < 300) {
            $r = $x; $b = $c;
        } else {
            $r = $c; $b = $x;
        }

        return [round(($r + $m) * 255), round(($g + $m) * 255), round(($b + $m) * 255)];
    }
    if (!function_exists('updateRawMaterialPurchase')){
        function updateRawMaterialPurchase(RawMaterialPurchase $purchase,$status): void
        {
            $purchase->status = $status;
            $purchase->update();
        }
    }
}
if (!function_exists('canStatusChangeFromApprove')) {
    /**
     * Check if the status can be changed from "approved"
     *
     * @param \App\Models\RawMaterialPurchase $purchase
     * @return bool
     */
    function canRawMaterialPurchaseStatusChangeFromApprove(RawMaterialPurchase $purchase): bool
    {
        foreach ($purchase->raw_materials as $rawMaterial) {
            $existingStock = RawMaterialStock::where('raw_material_id', $rawMaterial->pivot->raw_material_id)
                ->where('price', $rawMaterial->pivot->price)
                ->where('brand_id', $rawMaterial->pivot->brand_id)
                ->where('size_id', $rawMaterial->pivot->size_id)
                ->where('color_id', $rawMaterial->pivot->color_id)
                ->where('warehouse_id', $purchase->warehouse_id)
                ->first();

            if ($existingStock) {
                // Adjust the stock by subtracting the purchased quantity
                $existingStock->quantity -= $rawMaterial->pivot->quantity;
                if ($existingStock->quantity < 0) {
                    return false;
                }
            }
        }

        return true;
    }
}


if (!function_exists('getProductName')) {
    /**
     * Get the name of the product by its ID.
     *
     * @param int $productId
     * @return string
     */
    function getProductName($productId): string
    {
        $productModel = Product::find($productId);
        return $productModel ? $productModel->name : 'Product not found';
    }
}

if(!function_exists('getSaLe')) {
    function getSaLe($status = null)
    {
        $sell = \App\Models\Sell::query();
        if ($status) {
            $sell->where('status', $status);
        }
        return $sell->get();
    }
}

if (!function_exists('countAssets')) {
    function countAssets()
    {
        $assetCount = Asset::count();
        $assetAmount = Asset::sum('amount');
        return [
            'assetCount' => $assetCount,
            'assetAmount' => $assetAmount,
        ];
    }
}

if (!function_exists('countSales')) {
    function countSales()
    {
        // Today's sales count
        $todaySaleCount = Sell::whereDate('created_at', Carbon::today())->count();

        // Last 7 days sales count
        $last7DaysSaleCount = Sell::whereDate('created_at', '>=', Carbon::today()->subDays(6))->count();

        // Current month's sales count
        $currentMonthSaleCount = Sell::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();

        // Current year's sales count
        $currentYearSaleCount = Sell::whereYear('created_at', Carbon::now()->year)->count();

        // Assuming 'status' is a column in your 'sells' table and 'pending' indicates a pending sale
        $pendingSaleCount = Sell::where('status', 'pending')->count();

        return [
            'todaySaleCount' => $todaySaleCount,
            'last7DaysSaleCount' => $last7DaysSaleCount,
            'currentMonthSaleCount' => $currentMonthSaleCount,
            'currentYearSaleCount' => $currentYearSaleCount,
            'pendingSaleCount' => $pendingSaleCount,
        ];
    }
}

if(!function_exists('countProductStock')) {
    function countProductStock()
    {
        $totalProductStock = ProductStock::count();
        return $totalProductStock;
    }
}

if(!function_exists('countRawMaterialStock')) {
    function countRawMaterialStock()
    {
        $totalRawMaterialStock = RawMaterialStock::count();
        return $totalRawMaterialStock;
    }
}

if(!function_exists('countRawMaterialPurchase')) {
    function countRawMaterialPurchase()
    {
        $pendingRawMaterialPurchase = RawMaterialPurchase::where('status', 'pending')->count();
        $approvedRawMaterialPurchase = RawMaterialPurchase::where('status', 'approved')->count();
        return [
            'pendingRawMaterialPurchase' => $pendingRawMaterialPurchase,
            'approvedRawMaterialPurchase' => $approvedRawMaterialPurchase,
        ];
    }
}

if(!function_exists('countProductions')) {
    function countProductions()
    {
        $pendingProductions = Production::where('status', 'pending')->count();
        $approvedProductions = Production::where('status', 'approved')->count();
        return [
            'pendingProductions' => $pendingProductions,
            'approvedProductions' => $approvedProductions,
        ];
    }
}

if (!function_exists('countExpense')) {
    function countExpense()
    {
        $todayExpenseCount = Expense::whereDate('created_at', Carbon::today())->where('status', 'approved')->count();
        $last7DaysExpenseCount = Expense::whereDate('created_at', '>=', Carbon::today()->subDays(6))->where('status', 'approved')->count();
        $currentMonthExpenseCount = Expense::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->where('status', 'approved')->count();
        $currentYearExpenseCount = Expense::whereYear('created_at', Carbon::now()->year)->where('status', 'approved')->count();

        return [
            'todayExpenseCount' => $todayExpenseCount,
            'last7DaysExpenseCount' => $last7DaysExpenseCount,
            'currentMonthExpenseCount' => $currentMonthExpenseCount,
            'currentYearExpenseCount' => $currentYearExpenseCount,
        ];
    }
}

if (!function_exists('getMonthlySellsData')) {
    function getMonthlySellsData()
    {
        return Sell::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('DAY(created_at) as day, SUM(net_total) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();
    }
}

if (!function_exists('getMonthlyExpenseData')) {
    function getMonthlyExpenseData()
    {
        return Expense::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('DAY(created_at) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();
    }
}

if (!function_exists('getMonthlyAssetsData')) {
    function getMonthlyAssetsData()
    {
        return Asset::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('DAY(created_at) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();
    }
}

if (!function_exists('getMonthlyAccountsData')) {
    function getMonthlyAccountsData()
    {
        return Account::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('DAY(created_at) as day, SUM(balance) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();
    }
}

if (!function_exists('getMonthlyDaywiseChartData')) {
    function getMonthlyDaywiseChartData()
    {
        // Helper function to retrieve day-wise aggregated data
        $formatDaywiseData = function ($model, $field) {
            $daysInMonth = Carbon::now()->daysInMonth;
            $data = [];

            // Initialize each day to zero in case of missing data
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $data[$day] = 0;
            }

            // Query to get aggregated totals for each day
            $results = $model::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->selectRaw('DAY(created_at) as day, SUM(' . $field . ') as total')
                ->groupBy('day')
                ->pluck('total', 'day')
                ->toArray();

            // Merge results into the initialized array
            foreach ($results as $day => $total) {
                $data[$day] = $total;
            }

            return $data;
        };

        // Retrieve data for each component by day
        $sellData = $formatDaywiseData(Sell::class, 'net_total');
        $expenseData = $formatDaywiseData(Expense::class, 'amount');
        $assetsData = $formatDaywiseData(Asset::class, 'amount');
        $accountsData = $formatDaywiseData(Account::class, 'balance');

        // Encode each dataset as JSON for JavaScript usage in the view
        return [
            'sellData' => json_encode(array_values($sellData)),
            'sellLabels' => json_encode(array_keys($sellData)),
            'expenseData' => json_encode(array_values($expenseData)),
            'expenseLabels' => json_encode(array_keys($expenseData)),
            'assetsData' => json_encode(array_values($assetsData)),
            'assetsLabels' => json_encode(array_keys($assetsData)),
            'accountsData' => json_encode(array_values($accountsData)),
            'accountsLabels' => json_encode(array_keys($accountsData)),
        ];
    }
}

if (!function_exists('getLatestSales')) {
    function getLatestSales($limit = 5)
    {
        // Store the latest sales data in a variable
        $latestSales = Sell::orderBy('created_at', 'desc')->take($limit)->get();

        // Return the variable holding the sales data
        return $latestSales;
    }
}

if (!function_exists('getLatestRawMaterialPurchases')) {
    function getLatestRawMaterialPurchases($limit = 5)
    {
        $latestPurchases = RawMaterialPurchase::orderBy('created_at', 'desc')->take($limit)->get();
        return $latestPurchases;
    }
}

if (!function_exists('getLatestProductions')) {
    function getLatestProductions($limit = 5)
    {
        $latestProductions = Production::orderBy('created_at', 'desc')->take($limit)->get();
        return $latestProductions;
    }
}

if (!function_exists('getLatestExpenses')) {
    function getLatestExpenses($limit = 5)
    {
        $latestExpenses = Expense::orderBy('created_at', 'desc')->take($limit)->get();
        return $latestExpenses;
    }
}
