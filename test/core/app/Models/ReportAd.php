<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAd extends Model
{
    use HasFactory;

    public function ad()
    {
        return $this->belongsTo(AdList::class,'ad_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
