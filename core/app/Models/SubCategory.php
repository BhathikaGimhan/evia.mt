<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function fields()
    {
        return $this->hasMany(FormBuilder::class,'subcategory_id');
    }

    public function existingFields($currentId = null)
    {
        $data = [];
        foreach($this->fields as $field){
            if($currentId != null && $field->id == $currentId){
                continue;
            } else {

                $data[] = $field->name;
            }
        }
        return $data;
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function ads()
    {
        return $this->hasMany(AdList::class,'subcategory_id');
    }

    public function totalAd()
    {
        return $this->ads->count();
    }

}
