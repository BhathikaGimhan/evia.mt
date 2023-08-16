@php
    $user = auth()->user();
@endphp
<div class="account-sidebar">
  <button type="button" class="account-sidebar-open-btn"><i class="las la-bars"></i>@lang(' Dashboard Menu')</button>
      @if(url()->current() == url('user/dashboard'))
      <div class="account-header mb-3">
        <div class="thumb">
          <img src="{{getImage('assets/images/user/profile/'.$user->image,'400x400')}}" alt="image">
        </div>
        <div class="content">
          <h6 class="name fw-bold">{{$user->fullname}}</h4>
          <ul class="account-info-list mt-3">
            <li>
              <i class="las la-map-marked-alt"></i>
              <span>{{$user->address->address ?? 'No address'}}</span>
            </li>
            <li>
              <i class="las la-phone-volume"></i>
              <span>{{$user->mobile}}</span>
            </li>
            <li>
              <i class="las la-envelope"></i>
              <span>{{$user->email}}</span>
            </li>
          </ul>
        </div>
      </div>
      @endif
    
    <div class="account-menu-wrapper mt-0">
      <button type="button" class="account-sidebar-close-btn"><i class="las la-times"></i></button>

      <ul class="account-menu">
        <li class="menu-header mt-0">@lang('Ads Menu')</li>

        <li class="{{menuActive('user.home')}}">
            <a href="{{route('user.home')}}">
              <i class="las la-sliders-h"></i>
              <span class="menu-title">@lang('Dashboard')</span>
            </a>
          </li>

          <li class="{{menuActive('user.post.ad')}}">
            <a href="{{route('user.post.ad')}}">
              <i class="las la-folder-plus"></i>
              <span class="menu-title">@lang('Post An Ad')</span>
            </a>
          </li>

        <li class="{{menuActive('user.ad.list')}}">
          <a href="{{route('user.ad.list')}}">
            <i class="las la-list-alt"></i>
            <span class="menu-title">@lang('Active Ads')</span>
          </a>
        </li>
        <li class="{{menuActive('user.saved.ads')}}">
          <a href="{{route('user.saved.ads')}}">
            <i class="las la-bookmark"></i>
            <span class="menu-title">@lang('Saved Ads')</span>
          </a>
        </li>
        
        <li class="{{menuActive('user.ad.promotion.log')}}">
          <a href="{{route('user.ad.promotion.log')}}">
            <i class="las la-bullhorn"></i>
            <span class="menu-title">@lang('Promotion Log')</span>
          </a>
        </li>
       
        <li class="{{menuActive('user.deposit.history')}}">
          <a href="{{route('user.deposit.history')}}">
            <i class="las la-wallet"></i>
            <span class="menu-title">@lang('Payment Log')</span>
          </a>
        </li>
        <li class="{{menuActive('user.trx.history')}}">
          <a href="{{route('user.trx.history')}}">
            <i class="las la-exchange-alt"></i>
            <span class="menu-title">@lang('Transaction Log')</span>
          </a>
        </li>
        


        <li class="menu-header">@lang('User Menu')</li>
        
        <li  class="{{menuActive('user.profile-setting')}}">
          <a href="{{route('user.profile-setting')}}">
            <i class="las la-user"></i>
            <span>@lang('Profile Setting')</span>
          </a>
        </li>
        <li class="{{menuActive('user.change-password')}}">
          <a href="{{route('user.change-password')}}">
            <i class="las la-lock"></i>
            <span class="menu-title">@lang('Change Password')</span>
          </a>
        </li>
        <li class="{{menuActive('user.twofactor')}}">
          <a href="{{route('user.twofactor')}}">
            <i class="las la-key"></i>
            <span class="menu-title">@lang('2FA Security')</span>
          </a>
        </li>
        <li class="{{menuActive('ticket')}}">
          <a href="{{route('ticket')}}">
            <i class="las la-ticket-alt"></i>
            <span class="menu-title">@lang('Support Ticket')</span>
          </a>
        </li>
      </ul>
    </div>
  
  </div>