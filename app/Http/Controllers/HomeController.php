<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'brand', 'variants', 'images'])
            ->where('status', 1)
            ->orderBy('views', 'desc')
            ->limit(8)
            ->get();

        $newProducts = Product::with(['category', 'brand', 'variants', 'images'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $brands = Brand::where('status', 1)
            ->orderBy('sort')
            ->limit(6)
            ->get();

        return view('frontend.home', compact('featuredProducts', 'newProducts', 'brands'));
    }
}