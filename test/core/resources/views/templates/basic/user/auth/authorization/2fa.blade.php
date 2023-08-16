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
                        <h3 class="mb-3 text-white">@lang('2FA Verification')</h3>
                       
                      </div>
                  </div>
                <div class="right">
                  <h3 class="title">@lang('Google Authenticator Code')</h3>
                  <form action="{{route('user.go2fa.verify')}}" method="POST">
                    
                    @csrf
                    <div class="form-group">
                        <p class="text-center">@lang('Current Time'): {{\Carbon\Carbon::now()}}</p>
                    </div>
    
                    <div class="form-group">
                      <label>@lang('Verification code')</label>
                      <input type="text" name="code" placeholder="@lang('Code')" class="form--control">
                    </div>
                   
                    <div class="form-group">
                      <button type="submit" class="btn btn--base btn-md w-100">@lang('Submit')</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>  
@endsection
