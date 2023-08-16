@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pt-50 pb-50">
    <div class="container py-xl-5">
        <div class="text-center mb-30-none d-flex flex-wrap justify-content-center">
           @foreach ($packages as $pkg)
           <div class="plan shadow">
            <div class="plan-inner">
              <div class="entry-title">
                <h3 class="shadow-sm">{{__( $pkg->name)}}</h3>
                 <div class="price">{{$general->cur_sym}}{{getAmount($pkg->price)}}
                </div>
              </div>
              <div class="entry-content">
                <ul>
                  <li><strong>@lang('Validity')</strong> {{$pkg->validity}} @lang('days')</li>
                </ul>
              </div>
              <div class="btn">
                <a href="javascript:void(0)" data-balance="{{route('user.payment.promote',[$ad->id,$pkg->id])}}" data-gateway="{{route('user.deposit',[$ad->id,$pkg->id])}}" data-price="{{getAmount($pkg->price)}}" class="btn--base shadow-sm purchase">@lang('Promote Now')</a>
              </div>
            </div>
          </div>
           @endforeach
        </div>
    </div>
</section>



@endsection

@push('script')

    <script>
      'use strict';
      $('.purchase').on('click',function(){
        var gatewayRoute = $(this).data('gateway')
        var balanceRoute = $(this).data('balance')
        var price = $(this).data('price')
        var curr = "{{$general->cur_text}}"
         
        var modal = $('#purchaseModal');
        $('.packagePrice').text(price+' '+curr)
        $('.gateway').attr('href',gatewayRoute)
        $('.promotionBalance').attr('href',balanceRoute)
        modal.modal('show');
    })
    </script>

@endpush