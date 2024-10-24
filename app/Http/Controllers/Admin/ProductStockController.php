<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\ProductStock;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductStockController extends Controller
{
    public function index(): View|Factory|Application
    {
        $stocks = ProductStock::orderBy('id', 'DESC')->latest()->get();
        return view('admin.productStocks.index', compact('stocks'));
    }

    public function show($id): View|Factory|Application
    {
        $stock = ProductStock::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(ProductStock::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.productStocks.show', compact('stock', 'admins', 'activities'));
    }
}
