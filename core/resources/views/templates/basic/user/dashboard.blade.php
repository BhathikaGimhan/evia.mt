@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row g-3">
    <div class="col-xl-4 col-md-6">
      <div class="widget-card widget-color--1">
        <div class="widget-card__header">
          <h6 class="title">@lang('Total Ad')</h6>
          <a href="{{route('user.ad.list')}}" class="view-btn">@lang('View')</a>
        </div>                  
        <div class="widget-card__content">
          <div class="widget-number">{{$totalAd}}</div>
        
        </div>
        <div class="widget-card__icon">
          <i class="las la-list"></i>
        </div>
      </div><!-- widget-card end -->
    </div>
    <div class="col-xl-4 col-md-6">
      <div class="widget-card widget-color--5">
        <div class="widget-card__header">
          <h6 class="title">@lang('Total Pending Ad')</h6>
          <a href="{{route('user.ad.list')}}" class="view-btn">@lang('View')</a>
        </div>                  
        <div class="widget-card__content">
          <div class="widget-number">{{$totalPendingAd}}</div>
        
        </div>
        <div class="widget-card__icon">
          <i class="las la-list"></i>
        </div>
      </div><!-- widget-card end -->
    </div>
    <div class="col-xl-4 col-md-6">
      <div class="widget-card widget-color--2">
        <div class="widget-card__header">
          <h6 class="title">@lang('Saved Ad')</h6>
          <a href="{{route('user.saved.ads')}}" class="view-btn">@lang('View')</a>
        </div>                  
        <div class="widget-card__content">
          <div class="widget-number">{{$totalSaved}}</div>
         
        </div>
        <div class="widget-card__icon">
          <i class="las la-list"></i>
        </div>
      </div><!-- widget-card end -->
    </div>
    <div class="col-xl-4 col-md-6">
      <div class="widget-card widget-color--3">
        <div class="widget-card__header">
          <h6 class="title">@lang('Refunded Balance')</h6>
          
        </div>                  
        <div class="widget-card__content">
          <div class="widget-number">{{$general->cur_sym}} {{getAmount($refundedBalance)}}</div>
         
        </div>
        <div class="widget-card__icon">
          <i class="las la-list"></i>
        </div>
      </div><!-- widget-card end -->
    </div>
    <div class="col-xl-4 col-md-6">
      <div class="widget-card widget-color--4">
        <div class="widget-card__header">
          <h6 class="title">@lang('Total Transactions')</h6>
          <a href="{{route('user.trx.history')}}" class="view-btn">@lang('View')</a>
        </div>                  
        <div class="widget-card__content">
          <div class="widget-number">{{$totalTrx}}</div>

        </div>
        <div class="widget-card__icon">
          <i class="las la-list"></i>
        </div>
      </div><!-- widget-card end -->
    </div>
    <div class="col-xl-4 col-md-6">
      <div class="widget-card widget-color--9">
        <div class="widget-card__header">
          <h6 class="title">@lang('Total Ad Promotion')</h6>
          <a href="{{route('user.ad.promotion.log')}}" class="view-btn">@lang('View')</a>
        </div>                  
        <div class="widget-card__content">
          <div class="widget-number">{{$totalPromoted}}</div>

        </div>
        <div class="widget-card__icon">
          <i class="las la-list"></i>
        </div>
      </div><!-- widget-card end -->
    </div>
   
  </div><!-- row end -->
  <div class="row mt-5">
    <div class="col-lg-12">
      <h3>@lang('Latest Ads')</h3>
      <div class="table-responsive--md">
        <div class="table-responsive--md">
          <table class="table custom--table">
            <thead>
              <tr>
                <th>@lang('Ad title')</th>
                <th>@lang('Date')</th>
                <th>@lang('Status')</th>
                <th>@lang('Promote')</th>
                <th>@lang('Action')</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($latestAds as $ad)
              <tr>
                <td data-label="@lang('Ad title')">
                  <div class="table-item">
                    <div class="thumb">
                      <img src="{{getImage('assets/images/item_image/'.$ad->prev_image,'200x200')}}" alt="image">
                    </div>
                    <div class="content">
                      <h6 class="title"><a data-toggle="tooltip" title="{{$ad->title}}" target="_blank" href="{{route('ad.details',$ad->slug)}}">{{shortDescription($ad->title,30)}}</a></h6>
                    </div>
                  </div>
                </td>
                  <td data-label="@lang('Date')">{{showDateTime($ad->created_at,'d M Y')}}</td>
                  <td data-label="@lang('Status')">
                      @if ($ad->status == 1)
                      <span class="badge badge--success">@lang('Active')</span>
                      @else
                      <span class="badge badge--warning">@lang('Inactive')</span>
                      @endif
                  </td>
                  
                  <td data-label="@lang('Promote')">
                    @if ($ad->featured == 1)
                        @lang('Promoted')
                    @elseif($ad->promoted())
                        @lang('Requested')
                    @else
                      <a href="{{route('user.promote.ad.packages',$ad->slug)}}" data-toggle="tooltip" title ="@lang('Promote this ad')" class="icon-btn btn--success"><i class="las la-bullhorn"></i></a>
                    @endif
                  </td>
                  <td data-label="Action">
                    <a href="{{route('user.ad.edit',$ad->id)}}" class="icon-btn btn--primary"><i class="las la-edit"></i></a>
                    <a href="javascript:void(0)" data-route="{{route('user.ad.remove',$ad->id)}}" class="icon-btn btn--danger delete"><i class="las la-trash-alt"></i></a>
                  </td>
                </tr>
                @empty
                <tr><td colspan="12" class="text-center">@lang('No Ads')</td></tr>
               @endforelse
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection