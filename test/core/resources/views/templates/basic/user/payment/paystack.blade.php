@extends($activeTemplate.'layouts.master')

@section('content')
        <div class="row ">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="card paymentPrev border-0 shadow-sm">
                    <img class="card-img-top shadow-sm" src="{{$deposit->gateway_currency()->methodImage()}}" alt="Card image cap">
                    <div class="card-body">
                        <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                        <ul class="list-group text-center">
                            <li class="list-group-item"><strong>@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong></li>
                            <li class="list-group-item"><strong>@lang('To Promote Your Ad')</strong></li>
                            <li class="list-group-item"><button type="button" class="btn btn--base btn-sm w-100 btn-custom2 " id="btn-confirm">@lang('Pay Now')</button></li>
                        </ul>

                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
                        >
                        </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

