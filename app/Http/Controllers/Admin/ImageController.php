<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImgProduct;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function destroy($id)
    {
        $image = ImgProduct::findOrFail($id);
        
        // Xóa file vật lý
        if (file_exists(public_path($image->img_url))) {
            unlink(public_path($image->img_url));
        }
        
        // Xóa record trong database
        $image->delete();
        
        return response()->json(['success' => true]);
    }
}
