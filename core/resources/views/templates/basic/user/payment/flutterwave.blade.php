@extends($activeTemplate.'layouts.master')

@section('content')
  
        <div class="row ">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="card paymentPrev border-0 shadow-sm">
                    <img class="card-img-top shadow-sm" src="{{$deposit->gateway_currency()->methodImage()}}" alt="Card image cap">
                    <div class="card-body">
                        <ul class="list-group text-center">
                            <li class="list-group-item"><strong>@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong></li>
                            <li class="list-group-item"><strong>@lang('To Promote Your Ad')</strong></li>
                            <li class="list-group-item"><button type="button" class="btn btn--base btn-sm w-100 btn-custom2 " id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button></li>
                        </ul>

                        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                        <script>
                            var btn = document.querySelector("#btn-confirm");
                            btn.setAttribute("type", "button");
                            const API_publicKey = "{{$data->API_publicKey}}";

                            function payWithRave() {
                                var x = getpaidSetup({
                                    PBFPubKey: API_publicKey,
                                    customer_email: "{{$data->customer_email}}",
                                    amount: "{{$data->amount }}",
                                    customer_phone: "{{$data->customer_phone}}",
                                    currency: "{{$data->currency}}",
                                    txref: "{{$data->txref}}",
                                    onclose: function () {
                                    },
                                    callback: function (response) {
                                        var txref = response.tx.txRef;
                                        var status = response.tx.status;
                                        var chargeResponse = response.tx.chargeResponseCode;
                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        } else {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        }
                                            // x.close(); // use this to close the modal immediately after payment.
                                        }
                                    });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    


    
@endsection

