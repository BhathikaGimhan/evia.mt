@extends($activeTemplate.'layouts.frontend')

@section('content')
      <!-- category section start -->
      <div class="pt-50 pb-50">
        <div class="container">
          <div class="item-search-wrapper">
            <div class="row gy-3">
              <div class="col-lg-3 col-md-6">
                <button type="button" class="item-search-btn w-100 rounded-3" data-bs-toggle="modal" data-bs-target="#locationModal"><i class="las la-map-marker"></i>
                  @if ($distrct)
                      {{$distrct->name}}
                  @elseif(request()->input('division'))
                      {{ucwords(request()->input('division'))}}
                  @else
                    @lang('Select Location')
                  @endif
                </button>
              </div>
              <div class="col-lg-3 col-md-6">
                <button type="button" class="item-search-btn w-100 rounded-3" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class="las la-tag"></i>
                  @if ($subcategory)
                    {{$subcategory->name}}
                  @elseif(request()->input('category'))
                      {{ucwords(request()->input('category'))}}
                  @else
                    @lang('Select Category')
                  @endif
                </button>
              </div>
              <div class="col-lg-6">
                <form class="item-search-form" method="GET" action="" id="searchForm">
                  <input type="text" name="search" id="search" class="form--control" placeholder="@lang('Search in here')...">
                  <button type="submit" class="item-search-form-btn"><i class="las la-search"></i></button>
                </form>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-3 col-lg-3">
              <button class="filter-open-btn mb-3"><i class="las la-bars"></i> @lang('Filter')</button>
              <div class="sidebar filter-sidebar">
                <button class="sidebar-close-btn"><i class="las la-times"></i></button>
                <div class="form-group mb-3">
                  <label for="my-select">@lang('Sort results by')</label>
                  <select class="form--control" onChange="window.location.href=this.value">
                    <option value="{{queryBuild('sortby','date_desc')}}" {{request()->input('sortby')=='date_desc'? 'selected':''}}>@lang('Date: Newest on top')</option>
                    <option value="{{queryBuild('sortby','date_asc')}}" {{request()->input('sortby')=='date_asc'? 'selected':''}}>@lang('Date: Oldest on top')</option>
                    <option value="{{queryBuild('sortby','price_desc')}}" {{request()->input('sortby')=='price_desc'? 'selected':''}}>@lang('Price: High to Low')</option>
                    <option value="{{queryBuild('sortby','price_asc')}}" {{request()->input('sortby')=='price_asc'? 'selected':''}}>@lang('Price: Low to High')</option>
                  </select>
                </div>

                @if ($subcategory)
                <div class="mb-3">
                  <span class="mb-2">@lang('Type')</span>
                  <select class="select" name="condition" onChange = 'window.location.href=this.value'>
                    <option value="">@lang('Choose Option')</option>
                    <option value="{{queryBuild('type',1)}}" {{request()->input('type') == 1 ? 'selected':''}}>@lang('Sell')</option>
                    <option value="{{queryBuild('type',2)}}" {{request()->input('type') == 2 ? 'selected':''}} >@lang('Rent')</option>
                  </select>
                </div>
                  <div class="mt-2 mb-4">
                    <span class="mb-2">@lang('Condition')</span>
                    <select class="select" name="condition" onChange = 'window.location.href=this.value'>
                      <option value="">@lang('Choose Option')</option>
                      @if ($subcategory->category_id == 8)
                      <option value="{{queryBuild('condition',3)}}" {{request()->input('condition') == 3?'selected':''}}>@lang('Full Time')</option>
                      <option value="{{queryBuild('condition',4)}}" {{request()->input('condition')==4?'selected':''}} >@lang('Part Time')</option>
                        @else
                        <option value="{{queryBuild('condition',2)}}" {{request()->input('condition') == 2?'selected':''}}>@lang('Used')</option>
                      <option value="{{queryBuild('condition',1)}}" {{request()->input('condition')==1?'selected':''}} >@lang('New')</option>
                        @endif

                    </select>
                  </div>
                @endif

                <div class="sidebar-widget">
                  <h4 class="sidebar-widget__title">
                    <span>@lang('Category')</span>
                    <button class="title-btn"><i class="las la-angle-down"></i></button>
                  </h4>
                  <div class="sidebar-widget__body">
                    <ul class="sidebar-menu">
                      @foreach ($categories as $cat)

                      <li class="sidebar-dropdown {{request()->input('category') == $cat->slug ?'active':''}} {{@$subcategory->category->slug == $cat->slug ? 'active':'' }}">
                        @php
                            $excpCat = http_build_query(request()->except('category','location')).'location='.request()->input('location');
                        @endphp
                        <a data-toggle="tooltip" title="{{$cat->description}}" href="{{ $subcategory ? url('/items/')."?category=$cat->slug"."&$excpCat": queryBuild('category',$cat->slug)}}"><img src="{{getImage('assets/images/category/'.$cat->image)}}" alt="image" class="sidebar-menu-img"> {{__($cat->name)}}</a>
                        <div class="sidebar-submenu">
                          <ul>
                            @foreach ($cat->subcategories as $subcat)
                            @if(!empty(request()->input()))
                            <li class="sidebar-menu-item">
                              <a href="{{url('/items/')."/$subcat->slug"."?location=".request()->input('location')}}" class="{{@$subcategory->id == $subcat->id?'text-dark':''}}">{{$subcat->name}}<span>{{getAmount($subcat->totalAd())}}</span></a>
                            </li>
                            @else
                            <li class="sidebar-menu-item">
                              <a href="{{url('/items/')."/$subcat->slug"}}" class="{{@$subcategory->id == $subcat->id?'text-dark':''}}">{{$subcat->name}}<span>{{getAmount($subcat->totalAd())}}</span></a>
                            </li>
                            @endif

                            @endforeach

                          </ul>
                        </div>
                      </li>
                      @endforeach
                    </ul><!-- sidebar-menu end -->
                  </div>
                </div><!-- sidebar-widget -->
                <div class="sidebar-widget">
                  <h4 class="sidebar-widget__title">
                    <span>@lang('Location')</span>
                    <button class="title-btn"><i class="las la-angle-down"></i></button>
                  </h4>
                  <div class="sidebar-widget__body">
                    <ul class="sidebar-menu">
                     @foreach ($divisions as $divsion)

                     <li class="sidebar-dropdown {{request()->input('division') == $divsion->slug ? 'active':''}} {{@$distrct->division->slug == $divsion->slug ? 'active':'' }}">
                      @php
                      $excpDiv = http_build_query(request()->except('division','location')).'location=';
                      @endphp
                      <a href="{{ $subcategory ? url('/items/')."/$subcategory->slug"."?division=$divsion->slug"."&$excpDiv" : queryBuild('division',$divsion->slug )}}"><img src="{{getImage('assets/images/location/'.$divsion->image)}}" alt="image" class="sidebar-menu-img"> {{__($divsion->name)}}</a>
                      <div class="sidebar-submenu">
                        <ul>
                          @foreach ($divsion->districts as $district)

                          <li class="sidebar-menu-item">
                            <a href="{{queryBuild('location',$district->slug)}}">{{$district->name}}<span>{{getAmount($district->totalAd())}}</span></a>
                          </li>
                          @endforeach

                        </ul>
                      </div>
                    </li>
                     @endforeach
                    </ul><!-- sidebar-menu end -->
                  </div>
                </div><!-- sidebar-widget end -->

                <div class="sidebar-widget">
                  <h4 class="sidebar-widget__title">
                    <div class="sidebar-widget__body mt-2">
                      @if ($subcategory)
                        @if($subcategory->fields->count() > 0)
                           @foreach($subcategory->fields as $k => $field)
                               @if($field->type == 2 || $field->type == 3)
                                  <div class="form-group col-lg-12">
                                      @if ($field->type == 2 &&  $field->as_filter == 1)
                                      <label class="font-weight-bold">@lang($field->label) </label>
                                      <select class="form--control"  onChange="window.location.href=this.value">
                                        <option value="">@lang('Choose Option')</option>
                                          @foreach ($field->options as $opt)
                                              <option value="{{queryBuild($field->name,slug($opt))}}" {{request()->input($field->name)==slug($opt)?'selected':''}}>{{$opt}}</option>
                                          @endforeach
                                      </select>
                                      @elseif($field->type == 3 &&  $field->as_filter == 1)
                                          <label class="font-weight-bold">@lang($field->label)</label>
                                          <select class="form--control"  onChange="window.location.href=this.value">
                                            <option value="">@lang('Choose Option')</option>
                                              @foreach ($field->options as $opt)
                                                  <option value="{{queryBuild($field->name,slug($opt))}}" {{request()->input($field->name)== slug($opt)?'selected':''}}>{{$opt}}</option>
                                              @endforeach
                                          </select>
                                      @endif
                                  </div>
                              @endif
                           @endforeach
                        @endif
                      @endif

                      @if ($subcategory)
                       <form action="" class="filterForm" method="GET">
                        <div class="row">
                          <label>@lang('Price')</label>
                          <div class="col-md-6">
                            <input class="form--control" name="min" id="min" type="text" placeholder="@lang('min')" value="{{request()->input('min')}}">
                          </div>
                          <div class="col-md-6">
                            <input class="form--control" name="max" id="max" type="text" placeholder="@lang('max')" value="{{request()->input('max')}}">
                          </div>
                          <div class="col-md-12">
                            <button class="btn btn--base btn-sm w-100 mt-2" type="submit">@lang('Apply')</button>
                          </div>
                        </div>
                      </form>
                      @endif

                    </div>
                  </h4>
                </div><!-- sidebar-widget end -->
              </div><!-- sidebar end -->
              <div class="d-sm-none text-center d-lg-block mt-4">
                @php
                    echo advertisements('300x250');
                @endphp
              </div>
              <div class="d-none d-sm-block d-lg-none mt-4 text-center">
                @php
                    echo advertisements('970x90');
                @endphp
              </div>
            </div>
            <div class="col-xl-9 col-lg-9 pl-lg-5 mt-5 mt-lg-0">
              <ul class="page-link-inline-menu mb-3">
                <li>@lang('Home')</li>
                <li>@lang('Items')</li>
                @if($distrct)
                  <li>{{$distrct->name}}</li>
                @endif
                @if($subcategory)
                 <li>{{$subcategory->name}}</li>
                @endif

              </ul>
              @if (Route::currentRouteName() == 'ads')
                @include($activeTemplate.'partials.featuredList',['featuredAds' => $featuredAds])
              @endif

              @foreach ($ads as $ad)                @php
                    $slug = $ad->subcategory->slug;
                @endphp
                <div class="list-item list--style">
                  <div class="list-item__thumb">
                    <a href="{{route('ad.details',$ad->slug)}}"><img src="{{getImage('assets/images/item_image/'.$ad->prev_image,'275x200')}}" alt="image"></a>
                  </div>
                  <div class="list-item__wrapper">
                    <div class="list-item__content">
                      <a href="{{url('/items/')."/$slug"."?location=".request()->input('location')}}" class="category text--base"><i class="las la-tag"></i> {{$ad->subcategory->name}}</a>
                      <h6 class="title"><a href="{{route('ad.details',$ad->slug)}}">{{__($ad->title)}}</a></h6>
                      <ul class="list-item__meta mt-1">
                        <li>
                          <i class="las la-clock"></i>
                          <span>{{diffForHumans($ad->created_at)}}</span>
                        </li>
                        <li>
                          <i class="las la-user"></i>
                          <a href="javascript:void(0)">{{$ad->user->fullname}}</a>
                        </li>
                        <li>
                          <i class="las la-map-marker"></i>
                          <span>{{$ad->district}}, {{$ad->division}}</span>
                        </li>
                      </ul>
                      <ul>
                        <li>
                            <span style="background-color: #43CED2; border-radius:10px; padding:8px; color:white;">{{$ad->ownership}}</span>
                        </li>
                        <li>
                            <span style="background-color: #d8cd6d; border-radius:10px; padding:8px; color:white;">{{$ad->use_condition}}</span>
                        </li>

                      </ul>
                    </div>
                    <div class="list-item__footer">
                      <div class="price">{{$general->cur_sym}}{{getAmount($ad->price)}}</div>
                      <a href="{{route('ad.details',$ad->slug)}}" class="btn btn-sm btn--base mt-2">@lang('View Details')</a>
                    </div>
                  </div>
                </div><!-- list-item end -->
              @endforeach
              @if ($ads->count() == 0 && $featuredAds->count() == 0)
              <div class="list-item list--style">
                <div class="list-item__thumb">
                  <a href="javascript:void(0)"><img src="{{getImage('assets/images/noad.png')}}" alt="image"></a>
                </div>
                <div class="list-item__wrapper">
                  <div class="list-item__content d-flex align-items-center justify-content-center">
                    <h5 class="h5">@lang('Sorry No Ads Found!!')</h5>
                  </div>
                </div>
              </div>
              @endif

             {{paginateLinks($ads)}}
            </div>
          </div>
        </div>
      </div>
@endsection

@php
  $url =  http_build_query(request()->except('min','max'));
  $url = str_replace("amp%3B","",$url);

  $searchUrl =  http_build_query(request()->except('search'));
  $searchUrl =   str_replace("amp%3B","",$searchUrl);

  $queryStrings = json_encode(request()->query());
@endphp
@push('script')
<script>
  'use strict';
  $('.filterForm').on('submit',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var url = '{{url()->current()}}?{{$url}}';
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

  $('#searchForm').on('sumit',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var url = '{{url()->current()}}?{{$searchUrl}}';
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


  $('.advert').on('click',function () {
        var ad_id = $(this).data('advertid')
        var data = {
          ad_id:ad_id
        }
        var route = "{{route('ad.click')}}"
        axios.post(route,data).then(function (res) { })
  })
</script>
@endpush
