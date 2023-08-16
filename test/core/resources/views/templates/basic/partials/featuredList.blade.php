@foreach ($featuredAds as $item)
@php
  $slug = $item->subcategory->slug;
@endphp
 <div class="list-item list-item-featured list--style">
    <div class="list-item__thumb">
      <span class="featured--ticky">@lang('Featured')</span>
      <a href="{{route('ad.details',$item->slug)}}"><img src="{{getImage('assets/images/item_image/'.$item->prev_image,'275x200')}}" alt="image"></a>
    </div>
    <div class="list-item__wrapper">
      <div class="list-item__content">
        <a href="{{url('/ads/')."/$slug"."?location=".request()->input('location')}}" class="category text--base"><i class="las la-tag"></i> {{$item->subcategory->name}}</a>
        <h6 class="title"><a href="{{route('ad.details',$item->slug)}}">{{__($item->title)}}</a></h6>
        <ul class="list-item__meta mt-1">
          <li>
            <i class="las la-clock"></i>
            <span>{{diffForHumans($item->created_at)}}</span>
          </li>
          <li>
            <i class="las la-user"></i>
            <a href="javascript:void(0)">{{$item->user->fullname}}</a>
          </li>
          <li>
            <i class="las la-map-marker"></i>
            <span>{{$item->district}}, {{$item->division}}</span>
          </li>
        </ul>
      </div>
      <div class="list-item__footer">
        <div class="price">{{$general->cur_sym}}{{getAmount($item->price)}}</div>
        <a href="{{route('ad.details',$item->slug)}}" class="btn btn-sm btn--base mt-2">@lang('View Details')</a>
      </div>
    </div>
  </div>
@endforeach

 @push('style')
      
  <style>
    .list-item-featured{
        background-color: #002046;
      }
  </style>

  @endpush