<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPromote extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class,'user_id');
      }
  
    public function ad() {
       return $this->belongsTo(AdList::class,'ad_id');
    }

    public function package() {
       return $this->belongsTo(Package::class,'package_id');
    }

    public function gateway() {
      return $this->belongsTo(Gateway::class,'gateway_id');
    }
    public function deposit() {
      return $this->belongsTo(Deposit::class,'deposit_id');
    }
}
