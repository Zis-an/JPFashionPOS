<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\RawMaterialStock;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class RawMaterialStockController extends Controller
{
    public function index(): View|Factory|Application
    {
        $stocks = RawMaterialStock::orderBy('id', 'DESC')->latest()->get();
        return view('admin.rawMaterialStocks.index', compact('stocks'));
    }

    public function show($id): View|Factory|Application
    {
        $stock = RawMaterialStock::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(RawMaterialStock::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.rawMaterialStocks.show', compact('stock', 'admins', 'activities'));
    }
}
