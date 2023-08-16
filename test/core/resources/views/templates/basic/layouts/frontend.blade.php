<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.seo')
  @stack('additionalSeo')
  <title>{{ $general->sitename($page_title ?? '') }}</title>
  <!-- bootstrap 5  -->
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/bootstrap.min.css')}}">
  <!-- fontawesome 5  -->
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}"> 
  <!-- lineawesome font -->
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}"> 
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}"> 
  <!-- slick slider css -->
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/slick.css')}}">
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/odometer.css')}}">
  <!-- main css -->
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
  <link href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{$general->base_color}}&color2={{$general->secondary_color}}"rel="stylesheet" />
  @stack('style-lib')

  @stack('style')
</head>
  <body>
    @php echo loadFbComment() @endphp
      <!-- header-section start  -->
     @include($activeTemplate.'partials.header')
     <!-- header-section end  -->
     
     <div class="main-wrapper">

        @if(!request()->routeIs('home'))
            @include($activeTemplate.'partials.breadcrumb')
        @endif

         @yield('content')
    </div><!-- main-wrapper end -->
        




@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp


@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie-remove">
        <div class="cookie__wrapper">
            <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <p class="txt my-2">
                    @php echo @$cookie->data_values->description @endphp<br>
                <a href="{{ @$cookie->data_values->link }}" target="_blank" class="text--base mt-2">@lang('Read Policy')</a>
                </p>
                <button class="btn btn-md btn--base d-lg-inline-flex align-items-center my-2 policy cookie">@lang('Accept')</button>
            </div>
            </div>
        </div>
    </div>
@endif




<!-- footer section start-->     
    @include($activeTemplate.'partials.footer')
        
<!-- footer section end -->
    <!-- jQuery library -->
  <script src="{{asset($activeTemplateTrue.'js/lib/jquery-3.5.1.min.js')}}"></script>
  <!-- bootstrap js -->
  <script src="{{asset($activeTemplateTrue.'js/lib/bootstrap.bundle.min.js')}}"></script>
  <!-- slick slider js -->
  <script src="{{asset($activeTemplateTrue.'js/lib/slick.min.js')}}"></script>
  <!-- scroll animation -->
  <script src="{{asset($activeTemplateTrue.'js/lib/wow.min.js')}}"></script>
  <!-- lightcase js -->
  <script src="{{asset($activeTemplateTrue.'js/lib/lightcase.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/lib/select2.min.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/lib/viewport.jquery.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/lib/odometer.min.js')}}"></script>
  <!-- main js -->
  <script src="{{asset($activeTemplateTrue.'js/app.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/custom.js')}}"></script>


@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('admin.partials.notify')


    <script>
        (function ($) {
            "use strict";
            $(document).on("change", ".langSel", function() {
                window.location.href = "{{url('/')}}/change/"+$(this).val() ;
            });


            $('.cookie').on('click',function () {

            var url = "{{ route('cookie.accept') }}";

            $.get(url,function(response){

                if(response.success){
                   notify('success',response.success);
                   $('.cookie-remove').html('');
                }
            });

        });


        })(jQuery);
    </script>
    
        
  </body>
</html> 