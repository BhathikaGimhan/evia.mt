@extends($activeTemplate.'layouts.master')
@section('content')
    {{-- <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                    </div>
                    <div class="col-md-8">
                        <form action="{{$data->url}}" method="{{$data->method}}">
                            <h3 class="text-center">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                            <h3 class="my-3 text-center">@lang('To Get') {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</h3>
                            <script
                                src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
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
                    <form action="{{$data->url}}" method="{{$data->method}}">
                        <ul class="list-group text-center">
                            <li class="list-group-item"><strong>@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong></li>
                            <li class="list-group-item"><strong>@lang('To Promote Your Ad')</strong></li>
                            <li class="list-group-item">

                             <script
                                src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                   data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>

                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            $('button[type="submit"]').addClass("btn btn--base btn-sm w-100");
        })
    </script>
@endpush
