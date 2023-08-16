@extends($activeTemplate .'layouts.frontend')
@section('content')
    @php
        $bg = getContent('login.content',true)->data_values;
    @endphp
    <section class="pt-100 pb-100">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-9">
              <div class="account-wrapper">
                <div class="left bg_img" style="background-image: url({{getImage('assets/images/frontend/login/'.$bg->background_image,'1080x700')}});">
                      <div>
                        <h3 class="mb-3 text-white">@lang('SMS Verification')</h3>
                       
                      </div>
                  </div>
                <div class="right">
                  <h3 class="title">@lang('Please Verify Your Phone no.')</h3>
                  <form action="{{route('user.verify_sms')}}" method="POST">
                    
                    @csrf
                    <div class="form-group">
                        <p class="text-center">@lang('Your Phone No.'):  <strong>{{auth()->user()->mobile}}</strong></p>
                    </div>
    
    
                    <div class="form-group">
                      <label>@lang('Sms verification code')</label>
                      <input type="text" name="sms_verified_code" placeholder="@lang('Code')" class="form--control">
                    </div>
                   
                    <div class="form-group">
                      <button type="submit" class="btn btn--base btn-md w-100">@lang('Submit')</button>
                    </div>
    
                    <div class="form-group">
                        <p>@lang('Didn\'t get code in your phone yet?') <a href="{{route('user.send_verify_code')}}?type=sms"> @lang('Resend code')</a></p>
                        @if ($errors->has('resend'))
                            <br/>
                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </div>
                   
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>  
@endsection
