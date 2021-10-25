<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name'
    ];

    public function subCat_products()
	{
        return $this->hasMany(Product::class, 'subcategory_id', 'id');
	}

    public function categories() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
