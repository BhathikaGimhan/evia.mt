@extends($activeTemplate.'layouts.master')
@section('content')
    {{-- <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                    </div>
                    <div class="col-md-8 text-center">
                        <h3 class="mt-4">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                        <h3 class="my-3">@lang('To Get') {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</h3>
                        <button type="button" class=" mt-4 btn-success btn-round custom-success text-center btn-lg" id="btn-confirm">@lang('Pay Now')</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row ">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="card paymentPrev border-0 shadow-sm">
                <img class="card-img-top shadow-sm" src="{{$deposit->gateway_currency()->methodImage()}}" alt="Card image cap">
                <div class="card-body">
                        <ul class="list-group text-center">
                            <li class="list-group-item"><strong>@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong></li>
                            <li class="list-group-item"><strong>@lang('To Promote Your Ad')</strong></li>
                            <li class="list-group-item">
                                <button type="button" class="btn btn--base btn-sm w-100" id="btn-confirm">@lang('Pay Now')</button>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        $(document).ready(function () {
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        });
    </script>
@endpush
