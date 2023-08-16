<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\AdList;
use App\Models\Frontend;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\Advertise;
use App\Models\Category;
use App\Models\District;
use App\Models\Division;
use App\Models\GeneralSetting;
use App\Models\SubCategory;
use App\Models\SupportAttachment;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }
        
        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($this->activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $data['page_title'] = "Contact Us";
        return view($this->activeTemplate . 'contact', $data);
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id() ? auth()->id() : 0;
        $adminNotification->title = 'New support ticket has opened';
        $adminNotification->click_url = route('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->image = uploadImage($image, $path);
                    $attachment->save();
                    
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }


    public function placeholderImage($size = null){
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    
    public function faq()
    {
        $page_title = 'Frequently asked quetions';
        $faqs = Frontend::where('data_keys','faq.element')->get();
        return view($this->activeTemplate.'faq',compact('page_title','faqs'));

    }

    public function policyAndTerms($slug,$id)
    {
        $policy = Frontend::findOrFail($id);
        $page_title= $policy->data_values->title;
        return view($this->activeTemplate.'policies',compact('policy','page_title'));
    }

    public function adFilter($request,$subcategory,$distrct)
    {
        $condition = $request->condition;
        $sortby = $request->sortby;
        $type = $request->type;
        $min = $request->min;
        $max = $request->max;
        $search = $request->search;
     
        $category  = Category::where('status',1)->where('slug',$request->category)->first();
        $division = Division::where('status',1)->where('slug',$request->division)->first();

        $ads = AdList::when($distrct,function ($ad,$distrct)  {
            return $ad->where('district', $distrct->name);
        })
        ->when($division ,function($ad,$division) {
            return $ad->where('division', $division->name);
        })
        ->when($category ,function($ad,$category) {
            return $ad->where('category_id', $category->id);
        })
        ->when($subcategory ,function($ad,$subcategory) {
            return $ad->where('subcategory_id', $subcategory->id);
        })
        ->when($condition ,function($ad,$condition) {
            return $ad->where('use_condition', $condition);
        })
        ->when($search, function($ad, $search) {
            return $ad->where('title', 'like', "%$search%");
        })

        ->when($type ,function($ad,$type) {
            return $ad->where('type', $type);
        })
        ->when($min, function($ad, $min) {
            return $ad->where('price', '>=', $min);
          })
        ->when($max, function($ad, $max) {
            return $ad->where('price', '<=', $max);
          })
        ->when($sortby, function ($ad, $sortby) {
            if ($sortby=='date_desc') {
              return $ad->orderBy('id', 'DESC');
            }
            elseif($sortby=='date_asc') {
              return $ad->orderBy('id', 'ASC');
            }
            elseif($sortby=='price_desc') {
              return $ad->orderBy('price', 'DESC');
            }
            elseif($sortby=='price_asc') {
              return $ad->orderBy('price', 'ASC');
            }
         })
        
        ;

        if($subcategory){
            foreach($subcategory->fields as $field){
               if($request->has($field->name)){
                  $fieldName = $field->name;   
                  $value = $request->input($fieldName);
                  $value = ucwords(str_replace('-', ' ',$value));
                  if($field->options  && is_array($field->options)){
                      $ads = $ads->whereJsonContains("fields->$fieldName",$value);
                    }else {
                      $ads = $ads->where("fields->$fieldName",$value);
                  }
               } 
            }
        }

        return $ads;
    }

    public function allAds(Request $request,$subcat = null)
    {
        $page_title = 'All Ads';
        $gnl = GeneralSetting::first(['featured_show_count']);
        $subcategory  = SubCategory::where('status',1)->where('slug',$subcat)->with('category')->first();
        $distrct = District::where('slug',$request->location)->with('division')->first();
 
        $ads = $this->adFilter($request,$subcategory,$distrct);
        $featured = $this->adFilter($request,$subcategory,$distrct);

        $featuredAds = $featured->where('status',1)->where('featured',1)->where('expired_date','>',Carbon::now()->toDateString())->with(['subcategory','user'])->inRandomOrder()->take($gnl->featured_show_count)->get();

        $ads = $ads->where('status',1)->where('featured',0)->with(['subcategory','user'])->latest()->paginate(getPaginate());

        $categories = Category::with('subcategories')->where('status',1)->get();
        $divisions = Division::with('districts')->where('status',1)->get();
        return view($this->activeTemplate.'allAds',compact('page_title','ads','categories','divisions','subcategory','distrct','featuredAds'));
    }


    public function adDetails($slug)
    {
        $page_title = "Ad details";
        $ad = AdList::where('slug',$slug)->where('status',1)->first();
        $fields = @json_decode(json_encode($ad->fields),true);
        return view($this->activeTemplate.'adDetails',compact('page_title','ad','fields'));
    }

    public function adClick(Request $request)
    {
        $advert = Advertise::findOrFail($request->ad_id);
        $advert->total_click += 1;
        $advert->save();
    }
    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cookie accepted successfully']);
    }
}
