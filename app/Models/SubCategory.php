<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_main_category',
        'name',
        'slug',
        'image',
        'status',
        'sort'
    ];

    // Relationships
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'id_main_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }
}
