   @php
       $content = getContent('featuredAds.content',true)->data_values;
       $featured = \App\Models\AdList::where('status',1)->where('featured',1)->where('expired_date','>',\Carbon\Carbon::now()->toDateString())->inRandomOrder()->get();
   @endphp
   <!-- feature section start -->

   <section class="pt-50 pb-25">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-header">
            <h2 class="section-title">{{__($content->heading)}}</h2>
          </div>
        </div>
      </div><!-- row end -->
      <div class="feature-ad-slider">
        @foreach ($featured as $item)
        @php
          $slug = $item->subcategory->slug;
        @endphp
        <div class="single-slide">
          <div class="list-item feature-ad">
            <div class="list-item__thumb">
              <a href="{{route('ad.details',$item->slug)}}"><img src="{{getImage('assets/images/item_image/'.$item->prev_image,'292x230')}}" alt="image"></a>
            </div>
            <div class="list-item__wrapper">
              <div class="list-item__content">
                <a href="{{url('/items/')."/$slug"."?location=".request()->input('location')}}" class="category text--base"><i class="las la-tag"></i> {{__($item->subcategory->name)}}</a>
                <h5 class="title"><a data-toggle="tooltip" title="{{$item->title}}" href="{{route('ad.details',$item->slug)}}">{{shortDescription($item->title,35)}}</a></h5>
              </div>
              <div class="list-item__footer mt-2">
                <div class="price">{{$general->cur_sym}}{{getAmount($item->price)}}</div>
              </div>
            </div>
          </div><!-- list-item end -->
        </div><!-- single-slide end -->
            
        @endforeach
        
      </div>
    </div>
   </section>

   
      <!-- feature section end -->