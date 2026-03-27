<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_category',
        'id_brand',
        'id_discount',
        'name',
        'slug',
        'description',
        'views',
        'status',
        'import_date'
    ];

    protected function casts(): array
    {
        return [
            'import_date' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(SubCategory::class, 'id_category');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'id_product');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(AttributeProduct::class, 'id_product');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_product');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->orderBy('is_main', 'desc')->first();
    }

    public function getMinPriceAttribute()
    {
        return $this->variants()->min('price');
    }

    public function getMaxPriceAttribute()
    {
        return $this->variants()->max('price');
    }
}