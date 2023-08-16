<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'options'=> 'object'
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }
}
