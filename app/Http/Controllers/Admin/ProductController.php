<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Discount;
use App\Models\ProductVariant;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'variants'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = SubCategory::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $discounts = Discount::where('status', 1)->get();

        return view('admin.products.create', compact('categories', 'brands', 'discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'id_category' => 'required|exists:sub_categories,id',
            'id_brand' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'variants' => 'required|array|min:1',
            'variants.*.option' => 'required|string|max:150',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'id_category' => $request->id_category,
            'id_brand' => $request->id_brand,
            'id_discount' => $request->id_discount,
            'description' => $request->description,
            'status' => $request->status ?? 1,
            'import_date' => now(),
        ]);

        // Tạo variants
        foreach ($request->variants as $variantData) {
            ProductVariant::create([
                'id_product' => $product->id,
                'option' => $variantData['option'],
                'price' => $variantData['price'],
                'stock' => $variantData['stock'],
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/products'), $imageName);
                
                Image::create([
                    'product_id' => $product->id,
                    'img_url' => 'storage/products/' . $imageName,
                    'is_main' => $index === 0 ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'variants', 'images', 'attributes']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = SubCategory::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $discounts = Discount::where('status', 1)->get();
        $product->load(['variants']);

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'discounts'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'id_category' => 'required|exists:sub_categories,id',
            'id_brand' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'variants' => 'required|array|min:1',
            'variants.*.option' => 'required|string|max:150',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'id_category' => $request->id_category,
            'id_brand' => $request->id_brand,
            'id_discount' => $request->id_discount,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        // Xóa variants cũ và tạo mới
        $product->variants()->delete();
        foreach ($request->variants as $variantData) {
            ProductVariant::create([
                'id_product' => $product->id,
                'option' => $variantData['option'],
                'price' => $variantData['price'],
                'stock' => $variantData['stock'],
            ]);
        }

        if ($request->hasFile('images')) {
            // Xóa hình ảnh cũ
            foreach ($product->images as $oldImage) {
                if (file_exists(public_path($oldImage->img_url))) {
                    unlink(public_path($oldImage->img_url));
                }
            }
            $product->images()->delete();
            
            // Upload hình ảnh mới
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/products'), $imageName);
                
                Image::create([
                    'product_id' => $product->id,
                    'img_url' => 'storage/products/' . $imageName,
                    'is_main' => $index === 0 ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

        public function destroy(Product $product)
        {
            // Kiểm tra xem sản phẩm có trong đơn hàng thông qua variants
            $hasOrders = \App\Models\OrderDetail::whereIn('id_variant', 
                \App\Models\ProductVariant::where('id_product', $product->id)->pluck('id')
            )->exists();

            if ($hasOrders) {
                return redirect()->route('admin.products.index')
                    ->with('error', 'Không thể xóa sản phẩm vì nó đang có trong đơn hàng!');
            }

            // Xóa hình ảnh liên quan
            foreach ($product->images as $image) {
                if (file_exists(public_path($image->img_url))) {
                    unlink(public_path($image->img_url));
                }
            }
            $product->images()->delete();

            // Xóa variants liên quan
            $product->variants()->delete();

            // Xóa sản phẩm (xóa mềm do SoftDeletes)
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được xóa thành công!');
        }
}