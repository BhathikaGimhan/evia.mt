@extends($activeTemplate.'layouts.master')

@section('content')
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

                                <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                      data-{{$key}}="{{$value}}"
                                    @endforeach >
                                </script>

                            </li>
                        </ul>
                       
                       <input type="hidden" custom="{{$data->custom}}" name="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            $('input[type="submit"]').addClass("btn btn--base btn-sm w-100 text-center");
        })
    </script>
@endpush
