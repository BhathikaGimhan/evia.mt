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
              <th>@lang('Action')</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($favourites as $fav)
            <tr>
                <td data-label="@lang('Ad title')">
                  <div class="table-item">
                    <div class="thumb">
                      <img src="{{getImage('assets/images/item_image/'.$fav->ad->prev_image,'200x200')}}" alt="image">
                    </div>
                    <div class="content">
                      <h6 class="title"><a target="_blank" href="{{route('ad.details',$fav->ad->slug)}}">{{$fav->ad->title}}</a></h6>
                    </div>
                  </div>
                </td>
                <td data-label="@lang('Date')">{{showDateTime($fav->created_at,'d M Y')}}</td>
                <td data-label="@lang('Status')">
                    @if ($fav->ad->status == 1)
                    <span class="badge badge--success">@lang('Active')</span>
                    @else
                    <span class="badge badge--warning">@lang('Inactive')</span>
                    @endif
                </td>
                <td data-label="Action">
                  <a href="{{route('user.unsave.ad',$fav->id)}}" data-toggle="tooltip" title="@lang('Unsave')" class="icon-btn btn-danger"><i class="las la-trash-alt"></i></a>
                </td>
              </tr>
            @empty
              <tr><td colspan="12" class="text-center">@lang('No Saved Ads')</td></tr>
            @endforelse
            
          </tbody>
        </table>
      </div>
    </div>
    {{paginateLinks($favourites,'partials.paginate')}}
  </div>
@endsection