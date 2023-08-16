<?php

namespace App\Http\Controllers;

use App\Models\AdList;
use App\Models\Package;
use App\Models\AdPromote;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\AdminNotification;

class PromoteAdController extends Controller
{
    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }
    
    public function packages($slug)
    {
        $page_title = "Promote Ad";
        $ad = AdList::where('slug',$slug)->where('user_id',auth()->id())->where('status',1)->first();
        if(!$ad){
            $notify[] = ['error', 'Sorry! ad not found'];
            return back()->withNotify($notify);
        }
        if($ad->featured == 1){
            $notify[] = ['error', 'Sorry this ad has been already promoted'];
            return back()->withNotify($notify);
        }

        if($ad->promoted()){
            $notify[] = ['error', 'Sorry this ad has been already requested for promotion'];
            return back()->withNotify($notify);
        }

        if(auth()->id() != $ad->user->id){
            $notify[] = ['error', 'Sorry you can\'t promote this ad'];
            return back()->withNotify($notify);
        }
        
        $packages = Package::where('status',1)->get();
        return view($this->activeTemplate.'packages',compact('page_title','ad','packages'));
    }

    public function promoteFromBalance($adId,$pkgId)
    {

        $user = auth()->user();
        $ad = AdList::findOrFail($adId);
        $pkg = Package::findOrFail($pkgId);
        $gnl = GeneralSetting::first();
        if($user->balance < $pkg->price){
            $notify[]=['error','Sorry insufficient balance'];
            return back()->withNotify($notify);
        }

        $promote = new AdPromote();
        $promote->user_id = $user->id;
        $promote->package_id = $pkg->id;
        $promote->ad_id = $ad->id;
        $promote->status = $gnl->promote_approval == 1 ? 0 : 1;
        $promote->save();

        $user->balance -= $pkg->price;
        $user->update();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($pkg->price);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = 'Payment for Ad promotion from refunded balance' ;
        $transaction->trx = getTrx();
        $transaction->save();

        if($gnl->promote_approval == 1){
            notify($user, 'PROMOTION_REQUEST_FROM_BALANCE', [
                'amount' => getAmount($pkg->price),
                'currency' => $gnl->cur_text,
                'ad_title' => $ad->title,
                'package' =>  $pkg->name,
                'validity' => $pkg->validity
            ]);
           
        } else {
            notify($user, 'PROMOTION_APPROVE_FROM_BALANCE', [
                'amount' => getAmount($pkg->price),
                'currency' => $gnl->cur_text,
                'ad_title' => $ad->title,
                'package' =>  $pkg->name,
                'validity' => $pkg->validity
            ]);
        }

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New Ad Promotion Request';
        $adminNotification->click_url = urlPath('admin.ad.promote.pending');
        $adminNotification->save();

        $notify[]=['success','Ad Promotion request submitted successfully'];
        return redirect(route('user.ad.list'))->withNotify($notify);
    }
}
