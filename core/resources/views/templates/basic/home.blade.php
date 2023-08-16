@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
	$banner = getContent('banner.content',true)->data_values;
	$divisions = \App\Models\Division::where('status',1)->get();
@endphp

  <section class="hero bg_img" style="background-image: url({{getImage('assets/images/frontend/banner/'.$banner->background_image,'1920x1080')}});">
	<div class="container">
	  <div class="row justify-content-center">
		<div class="col-xxl-6 col-lg-8 text-center">
		  <span class="hero__subtitle">{{__($banner->title)}}</span>
		  <h2 class="hero__title">{{__($banner->heading)}}</h2>
		  <p class="hero__description">{{__($banner->sub_heading)}}</p>
		</div>
	  </div><!-- row end -->
	  <div class="row justify-content-center mt-5">
		<div class="col-xl-8 col-lg-10">
		  <form class="hero-search-form" action="" method="GET" id="searchForm">
			<div id="Search" class="input-group ps-sm-2">
			  <i class="las la-tag"></i>
			  <input type="text" name="search" placeholder="@lang('Enter keyword, title')" autocomplete="off" class="form--control border-none">
			</div>
			<div id="optionCheck" class="input-group ps-sm-3">
			  <i class="las la-map-marker"></i>
			  <select class="select" id="mySelect" name="division">
                <option>@lang('--Select--')</option>
                <option value="all">@lang('All Ads')</option>
				  @foreach ($divisions as $div)
				    <option value="{{$div->slug}}">{{$div->name}}</option>
				  @endforeach
			  </select>
			</div>
			<button type="submit" class="hero-search-form-btn"><i class="las la-search"></i> @lang('Search')</button>
		  </form>
		  <p class="text-white font-size--16px mt-3 text-center">{{__($banner->popular_keyword)}}</p>
		</div>
	  </div>
	</div>
  </section>

	@php
		$searchUrl =  http_build_query(request()->except('search'));
		$searchUrl =   str_replace("amp%3B","",$searchUrl);
		$queryStrings = json_encode(request()->query());

	@endphp
	@push('script')
	<script>

        $(document).ready(function() {
            // Attach a change event handler to the select element
            $("#mySelect").change(function() {
                // Get the selected option value
                var selectedValue = $(this).val();
                    console.log(selectedValue);
                if(selectedValue == "all"){
                    $("#searchForm").on('submit',function(e){
                        e.preventDefault();
                        var url = '{{url()->current()}}'+'/items/all'+'?{{$searchUrl}}';
                        url = url.replaceAll('amp;','');
                        var data = $(this).serialize();
                        var queryString = "{{$queryStrings}}"
                        var delim;
                        if(queryString.length > 2){
                            delim = "&"
                        }else {
                            delim = ""
                        }
                        window.location.href = url+delim+data;
                    });
                }else{
                    'use strict';
                    $('#searchForm').on('submit',function(e){
                        e.preventDefault();

                        var data = $(this).serialize();
                        var url = '{{url()->current()}}'+'/items/all'+'?{{$searchUrl}}';
                        url = url.replaceAll('amp;','');
                        var queryString = "{{$queryStrings}}"
                        var delim;
                        if(queryString.length > 2){
                            delim = "&"
                        }else {
                            delim = ""
                        }
                        window.location.href = url+delim+data;
                    });
                }
            });
        });


	</script>
	@endpush

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
