<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('dashboard', compact(['content']));
    }
}
