<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function totalAd()
    {
        return $this->ads->count();
    }

    public function ads()
    {
        return $this->hasMany(AdList::class,'category_id');
    }
}
