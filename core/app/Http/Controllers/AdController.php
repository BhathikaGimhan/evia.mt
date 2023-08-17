<?php

namespace App\Http\Controllers;

use App\Models\AdList;
use App\Models\AdImage;
use App\Models\Category;
use App\Models\District;
use App\Models\Division;
use App\Models\AdPromote;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Models\AdminNotification;

class AdController extends Controller
{
    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    public function createAd()
    {
        $page_title = 'Post new ad';
        return view($this->activeTemplate.'user.ads.postAdType',compact('page_title'));
    }

    public function selectCategory($type)
    {
        $page_title = 'Select Category';
        if($type == 'sell'){
            $flag = 1;
        } else if($type == 'rent') {
            $flag = 2;
        } else{
            $notify[]=['error','Sorry type couldn\'t found'];
            return back()->withNotify($notify);
        }
        $categories = Category::where('status',1)->with('subcategories')->get();
        return view($this->activeTemplate.'user.ads.postAdCategory',compact('page_title','categories','type','flag'));
    }

    public function selectLocation($type,$subcat)
    {
        $page_title = 'Select Location';
        if($type == 'sell' || $type == 'rent'){
            $locations = Division::where('status',1)->with('districts')->get();
            return view($this->activeTemplate.'user.ads.postAdLocation',compact('page_title','locations','type','subcat'));

        }
        $notify[]=['error','Sorry type couldn\'t found'];
        return back()->withNotify($notify);

    }

    public function showAdForm($type,$subcat,$location)
    {
        $page_title = 'Post Ad';
        if($type =='sell' || $type == 'rent'){
            $subcategory = SubCategory::where('status',1)->where('slug',$subcat)->first();
            $district = District::where('status',1)->where('slug',$location)->first();
            if(!$subcategory || !$district){
                $notify[]=['error','Sorry category or location currently not available or not found'];
                return back()->withNotify($notify);
            }
            return view($this->activeTemplate.'user.ads.postAdForm',compact('page_title','subcategory','district','type'));

        }
        $notify[]=['error','Sorry type couldn\'t found'];
        return back()->withNotify($notify);

    }

    public function storeAd(Request $request)
    {

            $images = $request->image;
            $allowedExts = array('jpg','jpeg','png');
            $rules = [
                'title' => 'required',
                'condition' => 'required|in:1,2,3,4',
                'description' => 'required',
                'price' => 'required|numeric|gt:0',
                'phone' => 'required',
                'prev_image'=>['required','image','max:2048',new FileTypeValidate(['jpg','jpeg','png'])],
                'image' => 'required'

            ];

            if ($images == null || count($images) == 0) {
                $notify[]=['error','At least 1 image is required'];
                return back()->withNotify($notify);
            }

            if (count($images) > 5) {
                $notify[]=['error','Maximum 5 images can be uploaded'];
                return back()->withNotify($notify);
            }

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

           $subcat = SubCategory::findOrFail($request->subcategory_id);
           $district = District::findOrFail($request->district_id);

            $fields = $subcat->fields;
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    if ($field->required == 1) {
                        $rules["$field->name"] = 'required';
                    }
                }
            }
            $request->validate($rules,['prev_image.required'=>'Preview Image is required','prev_image.image'=>'Preview Image has to be image type','prev_image.max'=>'Preview Image can not be greater than 2 MB']);

            $extraFields = [];
            foreach ($subcat->fields as $field) {
              $fieldName = $field->name;
              if ($request["$fieldName"]) {
                $extraFields["$fieldName"] = $request["$fieldName"];
              }
            }

           $ad = new AdList();
           $ad->user_id = auth()->id();
           $ad->category_id = $subcat->category->id;
           $ad->subcategory_id = $subcat->id;
           $ad->division = $district->division->name;
           $ad->district = $district->name;
           $ad->title = $request->title;
           $ad->slug = Str::slug($request->title).'-'.rand(411,799);
           $ad->use_condition = $request->condition;
           $ad->description = $request->description;
           $ad->price = $request->price;
           $ad->type = $request->type;
           $ad->negotiable = $request->negotiable ? 1:0;
           $ad->ownership = $request->Ownership;
           $ad->contact_num = $request->phone;
           $ad->status = 1; //meka wenas kala
           $ad->hide_contact = $request->hidenumber ? 1:0;
           $ad->fields = json_decode(json_encode($extraFields))??[];
           if($request->prev_image){
             $ad->prev_image = uploadImage($request->prev_image,'assets/images/item_image/','200x200',null,null,1);
           }
           $ad->save();
           if($request->image){
               foreach($request->image as $image){
                   $img = new AdImage();
                   $img->ad_id = $ad->id;
                   $img->image = uploadImage($image,'assets/images/item_image/','800x400',null,null,1);
                   $img->save();
               }
           }

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = auth()->id();
            $adminNotification->title = auth()->user()->username.' Posted A New Ad';
            $adminNotification->click_url = urlPath('admin.ads.pending');
            $adminNotification->save();

           $notify[]=['success','Ad posted successfully'];
           return back()->withNotify($notify);
     }

     public function adList(Request $request)
     {
         $search = $request->search;
         if($search){
            $page_title = "Search Result of $search";
            $ads = AdList::where('status',1)->where('user_id',auth()->id())->where('title','like',"%$search%")->paginate(getPaginate());
         } else {

             $page_title = "Ad Lists";
             $ads = AdList::where('status',1)->where('user_id',auth()->id())->latest()->paginate(getPaginate());
         }
         return view($this->activeTemplate.'user.ads.adList',compact('ads','page_title','search'));
     }

     public function editAd($id)
     {
        $page_title = "Edit Ad";
        $ad = AdList::where('id',$id)->where('user_id',auth()->id())->first();
        if(!$ad){
            $notify[]=['error','Sorry! invalid request'];
            return back()->withNotify($notify);
        }
        $adFields = json_decode(json_encode($ad->fields),true);

        return view($this->activeTemplate.'user.ads.editAd',compact('ad','page_title','adFields'));
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

        $request->validate($rules,['prev_image.required'=>'Preview Image is required','prev_image.image'=>'Preview Image has to be image type','prev_image.max'=>'Preview Image can not be greater than 2 MB']);

        $extraFields = [];
        foreach ($subcat->fields as $field) {
            $fieldName = $field->name;
           if ($request["$fieldName"]) {
              $extraFields["$fieldName"] = $request["$fieldName"];
            }
        }

        $ad->title = $request->title;
        $ad->slug = Str::slug($request->title).rand(411,799);
        $ad->use_condition = $request->condition;
        $ad->description = $request->description;
        $ad->price = $request->price;
        $ad->negotiable = $request->negotiable ? 1:0;
        $ad->contact_num = $request->phone;
        $ad->status = 1; //meka wenas kala
        $ad->hide_contact = $request->hidenumber ? 1:0;
        $ad->fields = json_decode(json_encode($extraFields))??[];

        if($request->prev_image){
          $old = $ad->prev_image ?? null;
          $ad->prev_image = uploadImage($request->prev_image,'assets/images/item_image/','200x200',$old,null,1);
        }
        $ad->save();

        if($images){
            foreach($images as $key => $image){
                $img = AdImage::firstOrNew(['id'=>$key]);
                $img->ad_id = $ad->id;
                $old = $img->image ?? null;
                $img->image = uploadImage($image,'assets/images/item_image/','800x400',$old,null,1);
                $img->save();
            }
        }

        $notify[]=['success','Ad updated successfully'];
        return back()->withNotify($notify);

    }

    public function removeAd($id)
    {
        $ad = AdList::findOrFail($id);
        removeFile('assets/images/item_image/'.$ad->prev_image);
        $adImages = AdImage::where('ad_id',$ad->id)->get();
        foreach ($adImages as $key => $adImage) {
            removeFile('assets/images/item_image/'.$adImage->image);
            $adImage->delete();
        }
        AdPromote::where('ad_id',$ad->id)->delete();
        $ad->delete();
        $notify[]=['success','Ad removed successfully'];
        return back()->withNotify($notify);
    }

    public function removeImage($id){
        $adImage = AdImage::findOrFail($id);
        $adList = AdList::where('id',$adImage->ad_id)->first();
        if($adList->user_id != auth()->user()->id){
            abort(403);
        }
        removeFile('assets/images/item_image/'.$adImage->image);
        $adImage->delete();
        $notify[]=['success','Image removed successfully'];
        return back()->withNotify($notify);
    }

}
