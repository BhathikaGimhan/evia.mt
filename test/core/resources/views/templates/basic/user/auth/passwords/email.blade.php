@extends('templates.basic.layouts.frontend')

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
              <form method="POST" action="{{ route('user.password.email') }}">
                @csrf
                <div class="form-group">
                    <label>@lang('My')</label>
                    <select class="form--control" name="type">
                        <option value="email">@lang('E-Mail Address')</option>
                        <option value="username">@lang('Username')</option>
                    </select>
                </div>
                <div class="form-group">
                  <label class="my_value"></label>
                  <input type="text"name="value" value="{{ old('value') }}" class="form--control" required>
                </div>
               
                <div class="form-group">
                  <button type="submit" class="btn btn--base btn-md w-100">@lang('Send Reset Code')</button>
                </div>
               
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
@push('script')
<script>
    'use strict'
    $('select[name=type]').on('change',function(){
        $('.my_value').text($('select[name=type] :selected').text());
    }).change();
</script>
@endpush