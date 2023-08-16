<?php

namespace App\Http\Controllers;

use Image;
use App\Models\AdList;
use App\Models\ReportAd;
use App\Models\AdPromote;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Rules\FileTypeValidate;
use App\Lib\GoogleAuthenticator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    public function home()
    {
        
        $user = auth()->user();
        $data['page_title'] = 'Dashboard';
        $data['totalAd'] = AdList::where('status',1)->where('user_id',auth()->user()->id)->count();
        $data['totalPendingAd'] = AdList::where('user_id',auth()->id())->where('status',0)->count();
        $data['totalPromoted'] = AdPromote::where('user_id',auth()->id())->count();
       
        $data['totalSaved'] =  $user->favourites->count();
        $data['refundedBalance'] =  getAmount($user->balance);
        $data['totalTrx'] =  $user->transactions()->count();
        $data['latestAds'] = AdList::where('status',1)->where('user_id',auth()->id())->latest()->take(8)->get();
       
        return view($this->activeTemplate . 'user.dashboard',$data);
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate. 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);


        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];

        $user = Auth::user(); 

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $in['image'] = uploadImage($request->image, 'assets/images/user/profile/', '400X400', $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
     
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "CHANGE PASSWORD";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Results of $search";
            $logs = auth()->user()->deposits()->with(['gateway'])->where('trx',$search)->paginate(getPaginate());
        } else {
            $page_title = 'Payment History';
            $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'No history found.';
        
        return view($this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs','search'));
    }
    public function transactions(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Results of $search";
            $logs = auth()->user()->transactions()->where('trx',$search)->paginate(getPaginate());
        } else {

            $page_title = 'Transaction History';
            $logs = auth()->user()->transactions()->latest()->paginate(getPaginate());
        }
        $empty_message = 'No history found.';
        return view($this->activeTemplate . 'user.transactions', compact('page_title', 'empty_message', 'logs','search'));
    }

   


    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {

        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {

            $user->tsc = null;
            $user->ts = 0;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->with($notify);
        }
    }

    public function reportAd(Request $request)
    {
       
          $request->validate([
            'reasons' => 'required'
          ]);
          $report = new ReportAd;
          $report->user_id = Auth::user()->id;
          $report->ad_id = $request->ad_id;
          $report->reasons = $request->reasons;
          $report->save();
         
          $notify[]=['success','Report Submitted'];
          return back()->withNotify($notify);
    }

    public function saveAd(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'userid' => 'required',
            'adId' => 'required',
        ],
        [
            'userid.required'=>'Unrecognised user',
            'adId.required'=>'Unrecognised ad',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }

        $saveAd = new Favourite();
        $saveAd->user_id = $request->userid;
        $saveAd->ad_id = $request->adId;
        $saveAd->save();
        return response()->json(['success'=>'Added to favourite list']);
      }

      public function savedAds(Request $request)
      {
          $search = $request->search;
          if($search){
              $page_title = "Search Results of $search";
              $favourites = Favourite::where("user_id",auth()->id())->whereHas('ad',function($ad) use ($search){
                  $ad->where('title','like',"%$search%");
              })->paginate(getPaginate());
          } else {
              $page_title = "Favourite Ads";
              $favourites = Favourite::where("user_id",auth()->id())->latest()->paginate(getPaginate());
          }
          return view($this->activeTemplate.'user.ads.saved',compact('page_title','favourites','search'));
      }

      public function unsaveAd($id)
      {
          Favourite::findOrFail($id)->delete();
          $notify[] = ['success', 'Ad unsaved from your favourite'];
          return back()->withNotify($notify);
      }


      public function promotionLog(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $requests = AdPromote::where('user_id',auth()->id())->whereHas('ad',function($ad) use($search){
                $ad->where("title",'like',"%$search%");
            })->latest()->paginate(getPaginate());
        } else {
            $page_title = 'All Promotion log';
            $requests = AdPromote::where('user_id',auth()->id())->latest()->paginate(getPaginate());

        }

        $empty_message = "No Promotions";
        return view($this->activeTemplate.'user.ads.promotionLog',compact('page_title','empty_message','requests','search'));
    }
    
}
