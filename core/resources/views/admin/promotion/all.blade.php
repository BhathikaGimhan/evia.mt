@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Ad Title')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Package Name/Validity')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Payment Gateway')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('State')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($requests as $request)
                            <tr>
                                <td data-label="@lang('Ad Title')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{getImage('assets/images/item_image/'.$request->ad->prev_image,'100x100')}}" alt="image"></div>
                                        <span class="name"><a class="text-secondary" data-toggle="tooltip" title="{{$request->ad->title}}" target="_blank" href="{{route('ad.details',$request->ad->slug)}}">{{Str::limit($request->ad->title,25)}}</a></span>
                                    </div>
                                </td>
                                <td data-label="@lang('Username')"><a href="{{route('admin.users.detail',$request->user->id)}}">{{$request->user->username}}</a></td>
                                <td data-label="@lang('Package Name/Validity')">
                                    <span class="font-weight-bold text--warning">{{$request->package->name}}</span> <br>
                                    <span class="text--primary">{{$request->package->validity}} @lang('days')</span>
                                </td>
                                <td data-label="@lang('Amount')"><span class="text--small badge font-weight-normal badge--success">{{getAmount($request->package->price)}} {{$general->cur_text}}</span></td>
                                <td data-label="@lang('Payment Gateway')">{{$request->gateway ? $request->gateway->name : 'from refunded balace'}}</td>

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
                                <td data-label="@lang('Action')">
                                    @if ($request->status == 0)
                                    <a href="javascript:void(0)" data-route="{{route('admin.ad.promote.accept',$request->id)}}" class="icon-btn mr-2 confirm" data-toggle="tooltip" title="@lang('accept')">
                                        <i class="las la-check-double text--shadow"></i>
                                    </a>

                                    <a href="javascript:void(0)" data-route="{{route('admin.ad.promote.reject',$request->id)}}" data-amount="{{getAmount($request->package->price)}}" class="icon-btn btn--danger rejectBtn" data-toggle="tooltip" title="@lang('reject')">
                                        <i class="las la-ban text--shadow"></i>
                                    </a>
                                   
                                    @else
                                        @lang('N/A')
                                    @endif
                                    
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{paginateLinks($requests)}}
                </div>
            </div><!-- card end -->
        </div>


        <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg--primary">
                        <h5 class="modal-title text-white">@lang('Reject Ad Promotion Confirmation')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        
                        <div class="modal-body">
                            <p>@lang('Are you sure want to') <span class="font-weight-bold">@lang('reject ?')</span></p>
                            
                            <p><span class="amount font-weight-bold text--success"> </span> @lang(' will be refunded to user refund balance')</p>

                            <div class="form-group">
                                <label class="font-weight-bold mt-2">@lang('Reason for Rejection')</label>
                                <textarea name="message" id="message" placeholder="@lang('Reason for Rejection')" class="form-control" rows="5"></textarea>
                            </div>
    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--danger">@lang('Reject')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body text-center">
                        
                        <i class="las la-exclamation-circle text--success display-2 mb-15"></i>
                        <h4 class="text--secondary mb-15">@lang('Are you sure want to accept?')</h4>

                    </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                    <button type="submit"  class="btn btn--success del">@lang('Accept')</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>

    </div>
@endsection



@push('breadcrumb-plugins')

<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('Search by ad title')" value="{{$search??''}}" autocomplete="off">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

@endpush

@push('script')
    
<script>
    'use strict';
    $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            var curr = '{{$general->cur_text}}'
            modal.find('.amount').text($(this).data('amount')+' '+curr);
            modal.find('form').attr('action',$(this).data('route'))
            modal.modal('show');
    });

    $('.confirm').on('click',function(){
        var route = $(this).data('route')
        var modal = $('#confirmModal');
        modal.find('form').attr('action',route)
        modal.modal('show');
    })
</script>
   
@endpush