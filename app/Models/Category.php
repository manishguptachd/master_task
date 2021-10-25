<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function subCategories()
	{
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
	}

    public function catProducts() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}