@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="col-lg-12 d-flex justify-content-end">
        <form action="">
           <div class="input-group">
             <input class="form-control outline-0 shadow-none" value="{{$search??''}}" type="text" name="search" placeholder="@lang('Search by title')" required>
              <button type="submit" class="input-group-text bg--sec"><i class="las la-search"></i></button>
           </div>
        </form>
      </div>
      <div class="table-responsive--md">
        <table class="table custom--table">
          <thead>
            <tr>
                <th scope="col">@lang('Ad Title')</th>
                <th scope="col">@lang('Package Name')</th>
                <th scope="col">@lang('Validity')</th>
                <th scope="col">@lang('Amount')</th>
                <th scope="col">@lang('Status')</th>
                <th scope="col">@lang('State')</th>
                
            </tr>
          </thead>
          <tbody>
            @forelse($requests as $request)
                <tr>
                    <td data-label="@lang('Ad Title')">
                        <a target="_blank" data-toggle="tooltip" title="{{$request->ad->title}}" href="{{route('ad.details',$request->ad->slug)}}">{{Str::limit($request->ad->title,40)}}</a>
                    </td>
                   
                    <td data-label="@lang('Package Name')"><span class="text--small badge font-weight-normal badge--success">{{$request->package->name}}</span></td>
                    <td data-label="@lang('Validity')"><span class="badge badge-pill bg--primary">{{$request->package->validity}} @lang('days')</span></td>
                    <td data-label="@lang('Amount')"><span class="text--small badge font-weight-normal badge--success">{{getAmount($request->package->price)}} {{$general->cur_text}}</span></td>
                   

                    <td data-label="@lang('Status')">
                        @if ($request->status == 1)
                            <span class="text--small badge font-weight-normal badge--success">@lang('Accepted')</span>
                        @elseif($request->status == 0)
                        <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                        @else 
                        <span class="text--small badge font-weight-normal badge--danger">@lang('Rejected')</span>
                        @endif
                    </td>

                    <td data-label="@lang('Status')">
                        @if ($request->running == 1)
                            <span class="text--small badge font-weight-normal badge--primary">@lang('Running')</span>
                        @else 
                        <span class="text--small badge font-weight-normal badge--dark">@lang('Not Running')</span>
                        @endif
                    </td>
                  
                </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                    </tr>
                @endforelse
            
          </tbody>
        </table>
      </div>
    </div>
    {{paginateLinks($requests,'partials.paginate')}}
  </div>
@endsection
