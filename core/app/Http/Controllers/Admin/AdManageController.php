<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdList;
use App\Models\AdImage;
use App\Models\ReportAd;
use App\Models\Advertise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class AdManageController extends Controller
{
    public function allAds(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $ads = AdList::where('title','like',"%$search%")->whereHas('category',function($ad) use($search){
                $ad->where("name",'like',"%$search%");
            })->latest()->paginate(15);

        } else {
            $page_title = "All Ads";
            $ads = AdList::latest()->paginate(15);
        }
        $empty_message = "No ads found";
        return view('admin.ads.allAds',compact('page_title','ads','search','empty_message'));

    }

    public function published(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $ads = AdList::where('status',1)->where('title','like',"%$search%")->whereHas('category',function($ad) use($search){
                $ad->where("name",'like',"%$search%");
            })->latest()->paginate(15);

        } else {
            $page_title = "All Published Ads";
            $ads = AdList::where('status',1)->latest()->paginate(15);
        }
        $empty_message = "No ads found";
        return view('admin.ads.allAds',compact('page_title','ads','search','empty_message'));
    }
    public function Unpublished(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $ads = AdList::where('status',2)->where('title','like',"%$search%")->whereHas('category',function($ad) use($search){
                $ad->where("name",'like',"%$search%");
            })->latest()->paginate(15);

        } else {
            $page_title = "All Un Published Ads";
            $ads = AdList::where('status',2)->latest()->paginate(15);
        }
        $empty_message = "No ads found";
        return view('admin.ads.allAds',compact('page_title','ads','search','empty_message'));
    }
    public function pending(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $ads = AdList::where('status',0)->where('title','like',"%$search%")->whereHas('category',function($ad) use($search){
                $ad->where("name",'like',"%$search%");
            })->latest()->paginate(15);

        } else {
            $page_title = "All Pending Ads";
            $ads = AdList::where('status',0)->latest()->paginate(15);
        }
        $empty_message = "No ads found";
        return view('admin.ads.allAds',compact('page_title','ads','search','empty_message'));
    }

    public function changeStatus($id)
    {
        $ad = AdList::findOrFail($id);
        if($ad->status == 1){
            $ad->status = 2;
            $notify[]=['success','Ad unpublished successfully'];
        } else {
            $ad->status = 1;
            $notify[]=['success','Ad published successfully'];
        }
        $ad->update();
        return back()->withNotify($notify);
    }

    public function editAd($id)
    {
        $page_title = "Edit Ad";
        $ad = AdList::findOrFail($id);
        $adFields = json_decode(json_encode($ad->fields),true);
        return view("admin.ads.editAd",compact("page_title","ad","adFields"));
    }


    public function updateAd(Request $request,$id)
    {
        $images = $request->image;
        $allowedExts = array('jpg','jpeg','png');
        $rules = [
            'title' => 'required',
            'condition' => 'required|in:1,2,3,4',
            'description' => 'required',
            'price' => 'required|numeric|gt:0',
            'phone' => 'required',
            'prev_image'=>['image','max:2048',new FileTypeValidate(['jpg','jpeg','png'])],

        ];

        if($images != null){
            foreach ($images as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                if (($file->getSize() / 1000000) > 5) {
                    $notify[]=['error','Images MAX  5MB ALLOW!'];
                    return back()->withNotify($notify);
                }
                if (!in_array($ext, $allowedExts)) {
                    $notify[]=['error','Only  jpg, jpeg, png files are allowed'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($images!=null && count($images) > 5) {
            $notify[]=['error','Maximum 5 images can be uploaded'];
            return back()->withNotify($notify);
        }
        $ad = AdList::findOrFail($id);
        $subcat = $ad->subcategory;

        $fields = $ad->subcategory->fields;
        if (!empty($fields)) {
            foreach ($fields as $field) {
                if ($field->required == 1) {
                    $rules["$field->name"] = 'required';
                }
            }
        }

        $request->validate($rules,['prev_image.required'=>'Preview Image is required','prev_image.image'=>'Preview Image has to be image type','prev_image.mimes'=>'Preview Image is allowed to be jpg,jped,png']);

        $extraFields = [];
        foreach ($subcat->fields as $field) {
            $fieldName = $field->name;
            if ($request["$fieldName"]) {
            $extraFields["$fieldName"] = $request["$fieldName"];
            }
        }

        $ad->title = $request->title;
        $ad->use_condition = $request->condition;
        $ad->description = $request->description;
        $ad->price = $request->price;
        $ad->negotiable = $request->negotiable ? 1:0;
        $ad->contact_num = $request->phone;
        $ad->status = 1; //meka aluthen dapu eka
        $ad->hide_contact = $request->hidenumber ? 1:0;
        $ad->fields = json_decode(json_encode($extraFields))??[];
        if($request->prev_image){
          $ad->prev_image = uploadImage($request->prev_image,'assets/images/item_image/',null,null,null,1);
        }
        $ad->save();
        if($request->image){
            foreach($request->image as $key => $image){
                $img = AdImage::firstOrNew(['id'=>$key]);
                $img->ad_id = $ad->id;
                $old = $img->image ?? null;
                $img->image = uploadImage($image,'assets/images/item_image/',null,$old,null,1);
                $img->update();
            }
        }

        $notify[]=['success','Ad updated successfully'];
        return back()->withNotify($notify);

   }

   public function adReports(Request $request)
   {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $reports = ReportAd::whereHas('ad',function($ad) use($search){
                $ad->where("title",'like',"%$search%");
            })->latest()->paginate(getPaginate());

        } else {
            $page_title = "All Reports";
            $reports = ReportAd::whereHas('ad')->latest()->paginate(getPaginate());
        }
        $empty_message = "No reports found";
        return view('admin.ads.reports',compact('page_title','reports','search','empty_message'));
   }


   public function advertisements(Request $request)
   {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $advertisements = Advertise::where('resolution','like',"%$search%")->latest()->paginate(getPaginate());

        } else {
            $page_title = "All Advertisements";
            $advertisements = Advertise::latest()->paginate(getPaginate());
        }
        $empty_message = "No Advertisements found";
        return view('admin.ads.advertisements',compact('page_title','advertisements','search','empty_message'));
   }

   public function advertisementStore(Request $request)
   {

        $request->validate([
            'type' => 'required|in:1,2',
            'size' => 'required|in:300x250,300x600,970x90',
            'redirect_url' => 'required_if:type,1|url',
            'adimage' => 'required_if:type,1|image|mimes:jpg,jpeg,png,PNG',
            'script' => 'required_if:type,2',
        ]);

        $advr = new Advertise();
        $advr->type = $request->type;
        $advr->script = $request->script ?? null;
        $advr->redirect_url = $request->redirect_url;
        $advr->resolution = $request->size;
        if($request->adimage){
            list($width, $height) = getimagesize($request->adimage);
            $size = $width.'x'.$height;
            if($request->size != $size){
                $notify[]=['error','Sorry image size has to be '.$request->size];
                return back()->withNotify($notify);
            }
            $advr->ad_image = uploadImage($request->adimage,'assets/images/commercial/');
        }
        // $advr->status = $request->status ? 1:0; yata eka edit karapu eka
        $advr->status = 1;
        $advr->save();
        $notify[]=['success','Advertisement added successfully'];
        return back()->withNotify($notify);

   }

   public function advertisementUpdate(Request $request,$id)
   {
        $request->validate([
            'type' => 'required|in:1,2',
            'size' => 'required|in:300x250,300x600,970x90',
            'redirect_url' => 'required_if:type,1|url',
            'adimage' => 'image|mimes:jpg,jpeg,png,PNG',
            'script' => 'required_if:type,2',
        ]);

        $advr = Advertise::findOrFail($id);
        $advr->type = $request->type;
        $advr->script = $request->script ?? null;
        $advr->redirect_url = $request->redirect_url;
        $advr->resolution = $request->size;
        if($request->adimage){
            $old = $advr->ad_image ?? null;
            list($width, $height) = getimagesize($request->adimage);
            $size = $width.'x'.$height;
            if($request->size != $size){
                $notify[]=['error','Sorry image size has to be '.$request->size];
                return back()->withNotify($notify);
            }
            $advr->ad_image = uploadImage($request->adimage,'assets/images/commercial/',null,$old);
        }
        $advr->status = $request->status ? 1:0;
        $advr->save();
        $notify[]=['success','Advertisement Updated successfully'];
        return back()->withNotify($notify);
   }

   public function advertisementRemove($id)
   {
       Advertise::findOrFail($id)->delete();
       $notify[]=['success','Advertisement removed successfully'];
       return back()->withNotify($notify);
   }


   public function featuredAds(Request $request)
   {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $ads = AdList::where('featured',1)->where('title','like',"%$search%")->whereHas('category',function($ad) use($search){
                $ad->where("name",'like',"%$search%");
            })->latest()->paginate(getPaginate());

        } else {
            $page_title = "All Featured Ads";
            $ads = AdList::where('featured',1)->latest()->paginate(getPaginate());
        }
        $empty_message = "No ads found";
        return view('admin.ads.allAds',compact('page_title','ads','search','empty_message'));
   }




}
