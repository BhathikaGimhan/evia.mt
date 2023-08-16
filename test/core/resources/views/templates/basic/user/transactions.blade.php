@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-end">
        <form action="">
           <div class="input-group">
             <input class="form-control outline-0 shadow-none" value="{{$search??''}}" type="text" name="search" placeholder="@lang('Search by trx')" required>
              <button type="submit" class="input-group-text bg--sec"><i class="las la-search"></i></button>
           </div>
        </form>
      </div>
        <div class="col-lg-12">
          <div class="table-responsive--md">
            <table class="table custom--table m-0">
              <thead>
                <tr>
                    <th scope="col">@lang('Trx ID')</th>
                    <th scope="col">@lang('Amount')</th>
                    <th scope="col">@lang('Charge')</th>
                    <th scope="col">@lang('Type')</th>
                    <th scope="col">@lang('Details')</th>
                    <th scope="col">@lang('Date')</th>
                </tr>
              </thead>
              <tbody>
                
                    @forelse($logs as $k=>$data)
                        <tr>
                            <td data-label="@lang('Transaction ID')">{{$data->trx}}</td>
                            <td data-label="@lang('Amount')">{{getAmount($data->amount)}} {{$general->cur_text}}</td>
                            <td data-label="@lang('Charge')">{{getAmount($data->charge)}} {{$general->cur_text}}</td>
                            <td data-label="@lang('Trx Type')">
                                @if ($data->trx_type == '+')
                                <span class="badge badge--success"><i class="las la-plus"></i></span>
                                @else
                                <span class="badge badge--danger"><i class="las la-minus"></i></span>
                                @endif
                            </td>
                            <td data-label="@lang('Details')">{{__($data->details)}}</td>
                            <td data-label="@lang('Date')">{{showDateTime($data->created_at,'d-m-Y')}}</td>
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%"> @lang('No data found')!</td>
                        </tr>
                    @endforelse
                
              </tbody>
            </table>
          </div>
        </div>
        {{paginateLinks($logs,'partials.paginate')}}
        
      </div>

@endsection


