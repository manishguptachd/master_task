<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\SubCategory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'price'
    ];

    public function categories() {   
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subCategories() {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
        
    }
}
