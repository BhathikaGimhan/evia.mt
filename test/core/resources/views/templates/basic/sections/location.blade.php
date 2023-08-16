@php
    $content = getContent('location.content',true)->data_values;
    $locations = \App\Models\Division::where('status',1)->take(8)->inRandomOrder()->get();
@endphp


   <!-- location section start -->
   <section class="pt-25 pb-50">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-header">
            <h2 class="section-title">{{__($content->heading)}}</h2>
          </div>
        </div>
      </div><!-- row end -->
      <div class="row gy-4 justify-content-center">
        @foreach ($locations as $location)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="location-card">
            <img src="{{getImage('assets/images/location/'.$location->image,'300x220')}}" alt="image">
            <div class="overlay-content has--link">
              <a href="{{route('ads')}}{{queryBuild('division',$location->slug)}}" class="item--link"></a>
              <h3 class="title">{{__($location->name)}}</h3>
              <span class="location-amount">{{getAmount($location->totalAd())}}</span>
            </div>
          </div><!-- location-card 
		  end -->
        </div>
       
        @endforeach
      </div>
    </div>
  </section>
  <!-- location section end -->



