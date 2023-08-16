<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AdList;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function featuredCron()
    {
        $general = GeneralSetting::first();
        $general->last_cron = Carbon::now();
        $general->save();
        $ads = AdList::where('status',1)->where('featured',1)->where('expired_date','<',Carbon::now()->toDateString())->get();
        if($ads->count() > 0 ){
            foreach($ads as $ad){
                $ad->featured = 0;
                $ad->expired_date = null;
                $ad->update();
    
                $promo = $ad->runningPromotion();
          
                $promo->running = 0;
                $promo->update();
    
                notify($ad->user,'PROMOTE_END',[
                    'ad_title'=> $ad->title,
                    'package' => $promo->package->name,
                    'validity' => $promo->package->validity
                ]);
            }
        }
    }
}
