<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdPromote;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;

class AdPromoteController extends Controller
{

    public function all(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $requests = AdPromote::whereHas('ad',function($ad) use($search){
                $ad->where("title",'like',"%$search%");
            })->latest()->paginate(getPaginate());
        } else {
            $page_title = 'All Requests';
            $requests = AdPromote::whereHas('ad')->latest()->paginate(getPaginate());

        }

        $empty_message = "No Requests";
        return view('admin.promotion.all',compact('page_title','empty_message','requests','search'));
    }

    public function pending(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $requests = AdPromote::where('status',0)->whereHas('ad',function($ad) use($search){
                $ad->where("title",'like',"%$search%");
            })->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Pending Requests';
            $requests = AdPromote::where('status',0)->whereHas('ad')->latest()->paginate(getPaginate());

        }

        $empty_message = "No Pending Requests";
        return view('admin.promotion.all',compact('page_title','empty_message','requests','search'));
    }

    public function accepted(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $requests = AdPromote::where('status',1)->whereHas('ad',function($ad) use($search){
                $ad->where("title",'like',"%$search%");
            })->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Accepted Requests';
            $requests = AdPromote::where('status',1)->whereHas('ad')->latest()->paginate(getPaginate());

        }

        $empty_message = "No Accepted Requests";
        return view('admin.promotion.all',compact('page_title','empty_message','requests','search'));
    }

    public function rejected(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $requests = AdPromote::where('status',2)->whereHas('ad',function($ad) use($search){
                $ad->where("title",'like',"%$search%");
            })->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Rejected Requests';
            $requests = AdPromote::where('status',2)->whereHas('ad')->latest()->paginate(getPaginate());

        }

        $empty_message = "No Rejected Requests";
        return view('admin.promotion.all',compact('page_title','empty_message','requests','search'));
    }

    public function acceptRequest($id)
    {
        $gnl = GeneralSetting::first();
        $request = AdPromote::findOrFail($id);
        $request->status = 1;
        $request->running = 1;
        $request->save();

        $today = Carbon::now();
        $exp = $today->addDays($request->package->validity);
        $request->ad->featured = 1;
        $request->ad->expired_date = $exp;
        $request->ad->save();
      
        $data = $request->deposit;
        $user = User::findOrFail($request->user_id);

        if($data){
            notify($user, 'PROMOTION_APPROVE', [
                'method_name' => $data->gateway_currency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => getAmount($data->final_amo),
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $gnl->cur_text,
                'rate' => getAmount($data->rate),
                'trx' =>  $data->trx,
                'ad_title' => $request->ad->title,
                'package' =>  $request->package->name,
                'validity' => $request->package->validity
            ]);
        } else {
            notify($user, 'PROMOTION_APPROVE_FROM_BALANCE', [
                'amount' => getAmount($request->package->price),
                'currency' => $gnl->cur_text,
                'ad_title' => $request->ad->title,
                'package' =>  $request->package->name,
                'validity' => $request->package->validity
            ]);
        }

        $notify[] = ['success', 'Promotion Accepted'];
        return back()->withNotify($notify);

    }

    public function rejectRequest(Request $request,$id)
    {
       
        $gnl = GeneralSetting::first();
        $promote = AdPromote::findOrFail($id);
        $promote->status = 2;
        $promote->save();

        $promote->user->balance += $promote->package->price;
        $promote->user->update();

        $transaction = new Transaction();
        $transaction->user_id = $promote->user->id;
        $transaction->amount = getAmount($promote->package->price);
        $transaction->post_balance = getAmount($promote->user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Payment refunded to balance' ;
        $transaction->trx = getTrx();
        $transaction->save();

        if($promote->deposit){
            notify($promote->user, 'PROMOTE_REJECT', [
                'method_name' =>  $promote->deposit->gateway_currency()->name,
                'amount' => getAmount($promote->package->price),
                'currency' => $gnl->cur_text,
                'trx' =>  $promote->deposit->trx,
                'rejection_message' => $request->message,
                'ad_title' => $promote->ad->title,
                'package' => $promote->package->name
            ]);
        } else {
            notify($promote->user, 'PROMOTE_REJECT_FROM_BALANCE', [
                'amount' => getAmount($promote->package->price),
                'currency' => $gnl->cur_text,
                'rejection_message' => $request->message,
                'ad_title' => $promote->ad->title,
                'package' => $promote->package->name
            ]);
        }
        $notify[] = ['success', 'Ad promotion request rejected'];
        return back()->withNotify($notify);
    }
}
