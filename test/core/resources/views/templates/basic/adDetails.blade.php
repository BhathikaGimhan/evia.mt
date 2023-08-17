@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="pt-50 pb-50">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="page-link-inline-menu">
            <li>@lang('Home')</li>
            <li>@lang('All ads')</li>
            <li>{{$ad->division}}</li>
            <li>{{$ad->district}}</li>
            <li>{{$ad->subcategory->category->name}}</li>
            <li>{{$ad->subcategory->name}}</li>
          </ul>
        </div>
      </div>
      <div class="category-details-wrapper">
        <div class="row mb-4">
          <div class="col-lg-8">
            <h3 class="ad-details-title mb-2">{{__($ad->title)}}</h3>
            <ul class="meta-list">
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
          </div>
          <div class="col-md-5 mt-md-0 mt-3">
          </div>
        </div>
        <div class="row justify-content-between">
          <div class="col-lg-8">
            <div class="ad-details-content-wrapper">
              <div class="ad-details-thumb-area">
                <h5 class="ad-details-price">{{$general->cur_sym}}{{getAmount($ad->price)}}</h5>
                <div class="main-thumb-slider">
                  @foreach ($ad->images as $image)
                    <div class="main-thumb">
                        <img src="{{getImage('assets/images/item_image/'.$image->image,'200x200')}}" alt="image">
                        <a href="{{getImage('assets/images/item_image/'.$image->image,'200x200')}}" class="fullview-image" data-rel="lightcase:myCollection:slideshow"></a>
                    </div>
                    @endforeach
                </div><!-- main-thumb-slider end -->
                <div class="ad-details-nav-slider mt-4">
                    @foreach ($ad->images as $image)
                    <div class="ad-details-nav-thumb">
                        <img src="{{getImage('assets/images/item_image/'.$image->image,'200x200')}}" alt="image">
                    </div>
                    @endforeach
                </div><!-- ad-details-nav-slider end -->
              </div>

              <div class="ad-details-content">
                <h4>@lang('Ad Overview')</h4>
                <ul class="caption-list-two mt-3">
                  <li>
                    <span class="caption">@lang('Condition')</span>

                    @if ($ad->subcategory->category_id == 8)
                        @if ($ad->use_condition == 2)
                            <span class="value">Full Time</span>
                        @elseif ($ad->use_condition == 3)
                            <span class="value">Part Time</span>
                        @endif
                    @else
                        <span class="value">{{ $ad->use_condition == 1 ? 'New' : 'Used' }}</span>
                    @endif
                  </li>
                  <li>
                    <span class="caption">@lang('Type')</span>
                    <span class="value">{{$ad->type == 1 ? 'Sell':'Rent'}}</span>
                  </li>

                  @foreach ($fields as $key => $field)
                    @if(is_array($field))
                       <li>
                           <span class="caption">{{__(ucwords(str_replace('_',' ',$key)))}}</span>
                            <span class="value">
                                @foreach ($field as $k => $item)
                                    {{$item}} @if(!$loop->last) ,@endif
                                @endforeach
                            </span>
                        </li>
                    @else
                        <li>
                            <span class="caption">{{__(ucwords(str_replace('_',' ',$key)))}}</span>
                            <span class="value">{{$field}}</span>
                        </li>
                    @endif

                  @endforeach
                </ul>


                <h4 class="mt-5">@lang('Description')</h4>
                <p class="mt-2">
                  @php
                      echo $ad->description;
                  @endphp
                </p>
                <hr>

              </div>

              <button class="ad-details-show-btn mt-3">
                <span class="text-one">@lang('Show Details')</span>
                <span class="text-two">@lang('Show Less')</span>
              </button>

            </div>

            <div class="my-5 text-center">
              @php
                    echo advertisements('970x90');
              @endphp

            </div>

            @if ($ad->relatedProducts()->count() > 1)
            <h4 class="mt-5">@lang('Related Ads')</h4>
            <div class="related-ad-slider mt-3">
              @forelse ($ad->relatedProducts() as $item)
                  @php
                      $slug = $item->subcategory->slug;
                  @endphp
                @if ($item->id != $ad->id)
                <div class="single-slide">
                  <div class="list-item related--ad">
                    <div class="list-item__thumb">
                      <a href="{{route('ad.details',$item->slug)}}"><img src="{{getImage('assets/images/item_image/'.$item->prev_image,'256x230')}}" alt="image"></a>
                    </div>
                    <div class="list-item__wrapper">
                      <div class="list-item__content">
                        <a class="cat-title" href="{{url('/ads/')."/$slug"."?location=".request()->input('location')}}" class="category"><i class="las la-tag"></i> {{__($item->subcategory->name)}}</a>
                        <h6 class="title" data-toggle="tooltip" title="{{__($item->title)}}"><a  href="{{route('ad.details',$item->slug)}}">{{__($item->title)}}</a></h6>
                      </div>
                      <div class="list-item__footer mt-2">
                        <div class="price">{{$general->cur_sym}}{{getAmount($item->price)}}</div>
                      </div>
                    </div>
                  </div><!-- list-item end -->
                </div><!-- single-slide end -->
                @endif
               @empty
                <h6 class="mt-5">@lang('No Related Ads')</h6>
              @endforelse

            </div>
            @endif
          </div>
          <div class="col-lg-4 col-xxl-3 mt-lg-0 mt-5">
            <div class="ad-details-sidebar">
              <div class="ad-save">
                @auth
                <div class="mb-4">
                    @if(auth()->id() != $ad->user_id)
                      @if ( !auth()->user()->userFavourite($ad->id))
                        <button type="button" data-userid="{{auth()->id()}}" data-adid="{{$ad->id}}" class="ad-save__btn save"><i class="las la-bookmark"></i> @lang('Save Ad')</button>
                      @else
                        <button type="button" class="ad-save__btn bg--base text-white"><i class="las la-check"></i> @lang('Saved')</button>
                      @endif
                    @endif
                  </div>
                @endauth

                @guest
                <div class="mb-4">
                  <a href="{{route('user.login')}}"  class="ad-save__btn text-dark"><i class="las la-bookmark"></i> @lang('Save Ad')</a>
                </div>
                @endguest
              </div>

              <div class="ad-details-widget">
                <h6 class="ad-details-widget__title">@lang('Seller Details')</h6>
                <div class="ad-details-widget__body">
                  <ul class="user-info-list">
                    <li>
                      <div class="icon">
                        <i class="las la-user"></i>
                      </div>
                      <div class="content">
                        <span class="caption">@lang('For sale by')</span>
                        <h6 class="value">{{$ad->user->fullname}}</h6>
                      </div>
                    </li>
                    <li>
                      <div class="icon">
                        <i class="las la-map-marker"></i>
                      </div>
                      <div class="content">
                        <span class="caption">@lang('Location')</span>
                        <h6 class="value">{{$ad->district}}</h6>
                      </div>
                    </li>
                    <li class="has--link">

                      <div class="icon">
                        <i class="las la-phone-volume"></i>
                      </div>

                      @if ($ad->hide_contact == 1)
                      <div class="content">
                        <a href="javascript:void(0)" class="btn btn-sm btn--dark show"><i class="las la-eye"></i> @lang('Show Contact')</a>
                        <span class="caption hide d-none">@lang('Contact Number')</span>
                        <h6 class="value hide-value d-none">{{$ad->contact_num}}</h6>
                      </div>
                      @else
                      <div class="content">
                        <span class="caption">@lang('Contact Number')</span>
                        <h6 class="value">{{$ad->contact_num}}</h6>
                      </div>
                      @endif
                    </li>

                  </ul>
                </div>
              </div>




              <div class="ad-details-widget mt-4">
                <h6 class="ad-details-widget__title"><i class="las la-external-link-alt"></i> @lang('Share')</h6>
                <div class="ad-details-widget__body">
                    <ul class="post__share">
                      <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"><i class="lab la-facebook-f"></i></a></li>

                      <li><a target="_blank" href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{ __($ad->title) }}&media={{ getImage('assets/images/item_image/'.$ad->prev_image) }}"><i class="lab la-pinterest"></i></a></li>

                      <li><a target="_blank" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}"><i class="lab la-twitter"></i></a></li>
                    </ul>
                </div>
              </div>




              <div class="ad-details-content-footer mt-4">
                <div class="left m-lg-0 m-2">

              @if ($ad->featured == 1)
                <a href="javascript:void(0)" class="btn btn-md btn--success w-100"><i class="las la-bullhorn"></i> @lang('Featured')</a>
              @elseif($ad->promoted())
                <a href="javascript:void(0)" class="btn btn-md btn--warning w-100"><i class="las la-bullhorn"></i> @lang('Requested')</a>
              @else
                <a href="{{route('user.promote.ad.packages',$ad->slug)}}" class="btn btn-md btn--primary w-100"><i class="las la-bullhorn"></i> @lang('Promote this ad')</a>
              @endif

              </div>

              @auth
              @if ($ad->user != auth()->user())
              <div class="right m-2 m-lg-0 mt-lg-3">
                      @if ($ad->userReport(auth()->id()))
                        <a href="javascript:void(0)"  class="btn btn-md btn--dark w-100"><i class="las la-flag"></i></i> @lang('Reported')</a>
                      @else
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adReportModal" class="btn btn-md btn--danger w-100"><i class="las la-flag"></i></i> @lang('Report this ad')</a>
                      @endif
                    </div>
                    @endif
                @endauth
                @guest
                <div class="right m-2 m-lg-0 mt-lg-3">
                  <a href="{{route('user.login')}}" class="btn btn-md btn--danger w-100"><i class="las la-flag"></i></i> @lang('Report this ad')</a>
                </div>
                @endguest
              </div>

              <div class="mt-4 text-center d-sm-none d-lg-block">
                @php
                    echo advertisements('300x600');
                @endphp
              </div>

              <div class="mt-4 text-center d-sm-none d-lg-block">
                @php
                    echo advertisements('300x250');
                @endphp
              </div>
              <div class="d-none d-sm-block d-lg-none mt-4 text-center">
                @php
                    echo advertisements('970x90');
                @endphp
              </div>
            </div><!-- ad-details-sidebar end -->
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('script-lib')
    <script src="{{asset($activeTemplateTrue.'js/axios.js')}}"></script>
@endpush

@push('script')

<script>
  'use strict';
    $('.show').on('click',function () {
        $(this).addClass('d-none')
        $('.hide').removeClass('d-none')
        $('.hide-value').removeClass('d-none')
    })

    $('.save').on('click',function () {
        var userid = $(this).data('userid')
        var adId = $(this).data('adid')

        var data = {
          userid:userid,
          adId:adId
        }
        var route = "{{route('user.save.ad')}}"
        axios.post(route,data).then(function (res) {
          if(res.data.adId ||res.data.userid)
          {
            $.each(res.data, function (i, val) {
               notify('error',val)
            });
          } else{
            notify('success',res.data.success)
          }

        })
     })
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
@push('additionalSeo')
  @includeif($activeTemplate.'partials.additionalSeo',['ad'=>$ad])
@endpush
