<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $mainCategories = MainCategory::with('subCategories')->get();
        $subCategories = SubCategory::with('mainCategory')->paginate(15);

        return view('admin.categories.index', compact('mainCategories', 'subCategories'));
    }

    public function createMain()
    {
        return view('admin.categories.create-main');
    }

    public function storeMain(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150|unique:main_categories,name',
        ]);

        MainCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục chính đã được tạo thành công!');
    }

    public function editMain(MainCategory $category)
    {
        return view('admin.categories.edit-main', compact('category'));
    }

    public function updateMain(Request $request, MainCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:150|unique:main_categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục chính đã được cập nhật thành công!');
    }

    public function destroyMain(MainCategory $category)
    {
        // Kiểm tra xem có danh mục con nào không
        if ($category->subCategories()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục chính vì còn có danh mục con!');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục chính đã được xóa thành công!');
    }

    public function createSub()
    {
        $mainCategories = MainCategory::all();
        return view('admin.categories.create-sub', compact('mainCategories'));
    }

    public function storeSub(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'id_main_category' => 'required|exists:main_categories,id',
        ]);

        SubCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'id_main_category' => $request->id_main_category,
            'status' => $request->status ?? 1,
            'sort' => $request->sort ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục con đã được tạo thành công!');
    }

    public function editSub(SubCategory $category)
    {
        $mainCategories = MainCategory::all();
        return view('admin.categories.edit-sub', compact('category', 'mainCategories'));
    }

    public function updateSub(Request $request, SubCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'id_main_category' => 'required|exists:main_categories,id',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'id_main_category' => $request->id_main_category,
            'status' => $request->status ?? 1,
            'sort' => $request->sort ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroySub(SubCategory $category)
    {
        // Kiểm tra xem có sản phẩm nào sử dụng danh mục này không
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục vì còn có sản phẩm sử dụng!');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }
}
