@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12 d-flex justify-content-end">
      <form action="">
         <div class="input-group">
           <input class="form-control outline-0 shadow-none" value="{{$search??''}}" type="text" name="search" placeholder="@lang('Search by title')" required>
            <button type="submit" class="input-group-text bg--sec"><i class="las la-search"></i></button>
         </div>
      </form>
  </div>
    <div class="col-lg-12">
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
            @forelse ($ads as $ad)
            <tr>
                <td data-label="@lang('Ad title')">
                  <div class="table-item">
                    <div class="thumb">
                      <img src="{{getImage('assets/images/item_image/'.$ad->prev_image,'200x200')}}" alt="image">
                    </div>
                    <div class="content">
                      <h6 class="title"><a data-toggle="tooltip" title="{{__($ad->title)}}" target="_blank" href="{{route('ad.details',$ad->slug)}}">{{shortDescription($ad->title,30)}}</a></h6>
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
    {{paginateLinks($ads,'partials.paginate')}}
  </div>
@endsection
