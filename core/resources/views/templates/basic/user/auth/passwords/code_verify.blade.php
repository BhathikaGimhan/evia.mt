@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $login = getContent('login.content',true)->data_values;
@endphp
<section class="pt-100 pb-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="account-wrapper">
            <div class="left bg_img" style="background-image: url({{getImage('assets/images/frontend/login/'.$login->background_image,'1080x700')}});">
                <div>
                    <h3 class="mb-3 text-white">@lang('Reset Password')</h3>
                </div>
            </div>
            <div class="right">
              <h3 class="title">@lang('Reset Your Password')</h3>
              <form action="{{ route('user.password.verify-code') }}" method="POST">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">
               
                <div class="form-group">
                  <label class="my_value"></label>
                  <input type="text"name="code" placeholder="@lang('code')" class="form--control" required>
                </div>
               
                <div class="form-group">
                  <button type="submit" class="btn btn--base btn-md w-100">@lang('Verify')</button>
                </div>

                <div class="form-group">
                    @lang('Please check including your Junk/Spam Folder. if not found, you can,')
                    <a class="font-size--14px" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                </div>
               
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>


@endsection
