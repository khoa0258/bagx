<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\MainCategory;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'variants', 'images'])
            ->where('status', 1);

        // Filter by category
        if ($request->category) {
            $query->where('id_category', $request->category);
        }

        // Filter by brand
        if ($request->brand) {
            $query->where('id_brand', $request->brand);
        }

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        switch ($request->sort) {
            case 'price_asc':
                $query->join('product_variants', 'products.id', '=', 'product_variants.id_product')
                      ->orderBy('product_variants.price', 'asc')
                      ->select('products.*');
                break;
            case 'price_desc':
                $query->join('product_variants', 'products.id', '=', 'product_variants.id_product')
                      ->orderBy('product_variants.price', 'desc')
                      ->select('products.*');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = SubCategory::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('frontend.products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'brand', 'variants', 'images', 'attributes', 'comments.user'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Increment views
        $product->increment('views');

        // Related products
        $relatedProducts = Product::with(['category', 'brand', 'variants', 'images'])
            ->where('id_category', $product->id_category)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->limit(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = SubCategory::where('slug', $slug)->firstOrFail();
        
        $products = Product::with(['category', 'brand', 'variants', 'images'])
            ->where('id_category', $category->id)
            ->where('status', 1)
            ->paginate(12);

        return view('frontend.products.category', compact('products', 'category'));
    }
}
