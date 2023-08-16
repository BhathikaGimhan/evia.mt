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
            <table class="table custom--table">
              <thead>
                <tr>
                    <th scope="col">@lang('Transaction ID')</th>
                    <th scope="col">@lang('Gateway')</th>
                    <th scope="col">@lang('Amount')</th>
                    <th scope="col">@lang('Status')</th>
                    <th scope="col">@lang('Time')</th>
                    <th scope="col"> @lang('MORE')</th>
                </tr>
              </thead>
              <tbody>
                @if(count($logs) >0)
                    @foreach($logs as $k=>$data)
                        <tr>
                            <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                            <td data-label="@lang('Gateway')">{{ __(@$data->gateway->name)  }}</td>
                            <td data-label="@lang('Amount')">
                                <strong>{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                            </td>
                            <td>
                                @if($data->status == 1)
                                    <span class="badge badge--success">@lang('Complete')</span>
                                @elseif($data->status == 2)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif($data->status == 3)
                                    <span class="badge badge--danger">@lang('Cancel')</span>
                                @endif

                                @if($data->admin_feedback != null)
                                    <button class="btn-info btn-rounded  badge detailBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                @endif

                            </td>
                            <td data-label="@lang('Time')">
                                <i class="fa fa-calendar"></i> {{showDateTime($data->created_at)}}
                            </td>

                            @php
                                $details = ($data->detail != null) ? json_encode($data->detail) : null;
                            @endphp

                            <td data-label="@lang('Details')">
                                <a href="javascript:void(0)" class="icon-btn btn--primary  approveBtn"
                                    data-info="{{$details}}"
                                    data-id="{{ $data->id }}"
                                    data-amount="{{ getAmount($data->amount)}} {{ __($general->cur_text) }}"
                                    data-charge="{{ getAmount($data->charge)}} {{ __($general->cur_text) }}"
                                    data-after_charge="{{ getAmount($data->amount + $data->charge)}} {{ __($general->cur_text) }}"
                                    data-rate="{{ getAmount($data->rate)}} {{ __($data->method_currency) }}"
                                    data-payable="{{ getAmount($data->final_amo)}} {{ __($data->method_currency) }}">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="100%"> @lang('No results found')!</td>
                        </tr>
                    @endif
                
              </tbody>
            </table>
          </div>
        </div>
        {{paginateLinks($logs,'partials.paginate')}}
      </div>

@endsection


@push('script')
    <script>
        "use strict";
        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-charge').text($(this).data('charge'));
            modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
            modal.find('.withdraw-rate').text($(this).data('rate'));
            modal.find('.withdraw-payable').text($(this).data('payable'));
            var list = [];
            var details =  Object.entries($(this).data('info'));

            var ImgPath = "{{asset(imagePath()['verify']['deposit']['path'])}}/";
            var singleInfo = '';
            for (var i = 0; i < details.length; i++) {
                if (details[i][1].type == 'file') {
                    singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="@lang('Image')" class="w-100">
                                    </li>`;
                }else{
                    singleInfo += `<li class="list-group-item">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span> 
                                    </li>`;
                }
            }
            
            if (singleInfo)
            {
                modal.find('.withdraw-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${singleInfo}`);
            }else{
                modal.find('.withdraw-detail').html(`${singleInfo}`);
            }
            modal.modal('show');
        });
        
        $('.detailBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('admin_feedback');
            modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
            modal.modal('show');
        });
    </script>
@endpush

