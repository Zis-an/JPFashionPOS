<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductionHouse;
use App\Models\RawMaterial;
use App\Models\Showroom;
use App\Models\Supplier;
use App\Models\Warehouse;
use Parsedown;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;


class DashboardController extends Controller
{
    public function index(): View|Factory|Application
    {
        $filePath = base_path('README.md'); // Adjust path if necessary
        $markdown = file_get_contents($filePath);
        $parsedown = new Parsedown();
        $content = $parsedown->text($markdown);
        $totalProducts = Product::count();
        $totalRawMaterials = RawMaterial::count();
        $totalAccounts = Account::count();
        $totalWarehouses = Warehouse::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $totalShowrooms = Showroom::count();
        $totalProductionHouses = ProductionHouse::count();
        $totalAssets = Asset::count();
        return view('dashboard',
            compact('content',
                'totalProducts',
                'totalRawMaterials',
                'totalAccounts',
                'totalWarehouses',
                'totalCustomers',
                'totalSuppliers',
                'totalEmployees',
                'totalDepartments',
                'totalShowrooms',
                'totalProductionHouses',
                'totalAssets'));
    }
}
