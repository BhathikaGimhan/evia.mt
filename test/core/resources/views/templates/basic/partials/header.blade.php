      <!-- header-section start  -->
      <header class="header">
        <div class="header__bottom">
          <div class="container-fluid">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-toggle"></span>
              </button>
              <a class="site-logo site-title" href="{{ url('/') }}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo"></a>
              <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                <ul class="navbar-nav main-menu ms-auto">
                  <li><a href="{{route('home')}}">@lang('Home')</a></li>
                  <li><a href="{{route('ads')}}">@lang('All Ads')</a></li>
                  @foreach($pages as $k => $data)
                  <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                  @endforeach
                  <li><a href="{{route('faq')}}">@lang('Faq')</a></li>
                  @guest
                  <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                  @endguest
                  @auth
                  <li><a href="{{route('ticket')}}">@lang('Support')</a></li>
                  <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
                  <li><a href="{{route('user.logout')}}">@lang('logout')</a></li>
                  @endauth
                  @guest
                  <li><a href="{{route('user.login')}}">@lang('Login')</a></li>
                  @endguest
                </ul>
                <div class="nav-right">
                  <a href="{{route('user.post.ad')}}" class="btn btn-md btn--base d-lg-inline-flex align-items-center m-1"><i class="las la-file-alt font-size--18px me-2"></i> @lang('Post Ad')</a>
                  <select class="language-select ms-lg-3 m-1 langSel">
                    @foreach($language as $item)
                            <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </nav>
          </div>
        </div><!-- header__bottom end -->
      </header>
      <!-- header-section end  -->