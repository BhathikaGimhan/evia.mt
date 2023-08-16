<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'fields' => 'object'
    ];

    protected $fillable = [
        'Ownership'
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

   public function images()
   {
        return $this->hasMany(AdImage::class,'ad_id');
   }

   public function relatedProducts()
   {
       return $this->where('status',1)->where('subcategory_id',$this->subcategory_id)->inRandomOrder()->get();
   }

   public function category()
   {
       return $this->belongsTo(Category::class,'category_id');
   }

   public function promoted()
   {
       return AdPromote::where("ad_id",$this->id)->where('status',0)->first();
   }

   public function promotions()
   {
       return $this->hasMany(AdPromote::class,'ad_id');
   }

   public function runningPromotion()
   {
       return AdPromote::where("ad_id",$this->id)->where('running',1)->first();
   }

   public function userReport($userid)
   {
       return ReportAd::where('ad_id',$this->id)->where('user_id',$userid)->first();
   }


   public function reports()
   {
        return $this->hasMany(ReportAd::class,'ad_id');
   }


}
