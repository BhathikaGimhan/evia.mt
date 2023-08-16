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
              <form method="POST" action="{{ route('user.password.update') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

               
                <div class="form-group">
                  <label class="my_value"></label>
                  <input type="password" name="password" placeholder="@lang('password')" class="form--control" required>
                </div>
                <div class="form-group">
                  <label class="my_value"></label>
                  <input type="password" name="password_confirmation" placeholder="@lang('confirm password')" class="form--control" required>
                </div>
               
                <div class="form-group">
                  <button type="submit" class="btn btn--base btn-md w-100">@lang('Reset Password')</button>
                </div>
               
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
