@extends($activeTemplate.'layouts.master')

@section('content')
  
        <div class="row">
            <div class="col-lg-6 col-md-6">
                @if(Auth::user()->ts)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg--sec">
                            <h5 class="card-title text-white">@lang('Two Factor Authenticator')</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)"  class="btn w-100 btn-md btn--danger" data-bs-toggle="modal" data-bs-target="#disableModal">
                                    @lang('Disable Two Factor Authenticator')</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg--sec">
                            <h5 class="card-title text-white">@lang('Two Factor Authenticator')</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form--control" id="referralURL" readonly>
                                        <button class="btn btn--secondary btn-sm copytext" id="copyBoard" onclick="myFunction()"> <i class="fa fa-copy"></i> </button>
                                </div>
                            </div>
                            <div class="form-group mx-auto text-center">
                                <img class="mx-auto" src="{{$qrCodeUrl}}">
                            </div>
                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)" class="btn btn--base btn-md mt-3 mb-1" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg--sec">
                        <h5 class="card-title text-white">@lang('Google Authenticator')</h5>
                    </div>
                    <div class=" card-body">
                        <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                        <a class="btn btn--base btn-md mt-3" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                    </div>
                </div><!-- //. single service item -->
            </div>
        </div>
   

@endsection

@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush


