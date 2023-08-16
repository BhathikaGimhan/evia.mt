
@if (Route::currentRouteName() == 'ad.details')
      {{--<!-- Apple Stuff -->--}}
      <link rel="shortcut icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" type="image/x-icon">
      <link rel="apple-touch-icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="apple-mobile-web-app-title" content="{{ $general->sitename($page_title) }}">
      {{--<!-- Google / Search Engine Tags -->--}}
      <meta itemprop="name" content="{{ $general->sitename($page_title) }}">
     
      <meta itemprop="description" content="{{ strip_tags($ad->description) }}">
      <meta itemprop="image" content="{{ getImage('assets/images/adimage/'.$ad->prev_image) }}">
      {{--<!-- Facebook Meta Tags -->--}}
      <meta property="og:type" content="website">
      <meta property="og:title" content="{{ $ad->title }}">
      <meta property="og:description" content="{{ str_limit(strip_tags($ad->description,1000)) }}">
      <meta property="og:image" content="{{ getImage('assets/images/adimage/'.$ad->prev_image) }}"/>
      <meta property="og:image:type" content="image/{{ pathinfo(getImage('assets/images/adimage/'.$ad->prev_image))['extension'] ?? 'jpg' }}" />
      <meta property="og:url" content="{{ url()->current() }}">
      {{--<!-- Twitter Meta Tags -->--}}
      <meta name="twitter:card" content="summary_large_image">
@endif