@php
    $footer = getContent('footer.content',true)->data_values;
    $socials = getContent('footer.element',false,'',1);
    $contact = getContent('contact_us.content',true)->data_values;
    $policies  = getContent('policy.element',false,'',1);
@endphp
<footer class="footer">
    <div class="footer__top">
      <div class="container">
        <div class="row gy-5 justify-content-center">
          <div class="col-lg-6 col-md-8">
            <div class="footer-widget text-center">
              <a href="{{url('/')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image" class="footer-logo"></a>
              <p class="mt-3">{{__($footer->short_details)}}</p>
            </div><!-- footer-widget end -->
          </div>
        </div><!-- row end -->

        <ul class="social-link-list justify-content-center">
            @foreach ($socials as $social)
                
            <li>
              <a target="_blank" href="{{$social->data_values->link}}" class="facebook">
                  @php
                      echo $social->data_values->social_icon;
                  @endphp
              </a>
            </li>
            @endforeach
          </ul>
              
        <ul class="footer--links">
            <li><a href="{{route('home')}}">@lang('Home')</a></li>
            <li><a href="{{route('ads')}}">@lang('All Ads')</a></li>
            @foreach($pages as $k => $data)
            <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
            @endforeach
            <li><a href="{{route('faq')}}">@lang('Faq')</a></li>
            <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
        </ul>
      </div>
    </div><!-- footer__top end -->
    <div class="footer__bottom">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 text-lg-start text-center">
            <p>@lang('Copyrights') © {{date('Y')}} @lang('by') <a href="{{url('home')}}" class="text--base">{{$general->sitename}}</a> @lang(' All Rights Reserved') .</p>
          </div>
          <div class="col-lg-6">
              <ul class="help--link-list justify-content-center justify-content-lg-end">
                @foreach ($policies as $item)
                 <li><a href="{{route('links',[slug($item->data_values->title),$item->id])}}">{{$item->data_values->title}}</a></li>
                @endforeach
              </ul>
            </div>
        </div>
      </div>
    </div>
  </footer>

  @includeif($activeTemplate.'partials.filterModals')
  @includeif($activeTemplate.'partials.depositModal')
  @includeif($activeTemplate.'partials.paymentOptionModal')
  @includeif($activeTemplate.'partials.adReportModal')
  @includeif($activeTemplate.'partials.deleteModal')
  @includeif($activeTemplate.'partials.twofactorModal')
  @includeif($activeTemplate.'partials.paymentHistoryModals')
  @includeif($activeTemplate.'partials.ticketCloseModal')
  @includeif($activeTemplate.'partials.imageRemoveModal')