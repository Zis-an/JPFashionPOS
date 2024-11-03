<?php

use App\Models\GlobalSetting;
use App\Models\Product;
use App\Models\RawMaterialPurchase;
use App\Models\RawMaterialStock;

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
