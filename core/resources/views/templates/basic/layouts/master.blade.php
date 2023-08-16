<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.seo')
  <title>{{ $general->sitename($page_title ?? '') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}">
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


        <section class="pt-100 pb-100">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-3">
                @include($activeTemplate.'partials.sidemenu')
              </div>
              <div class="col-lg-9 ps-xl-5 mt-lg-0 mt-5">
                @yield('content')
              </div>
            </div>
          </div>
        </section>


    </div><!-- main-wrapper end -->
        
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
  <!-- main js -->
  <script src="{{asset($activeTemplateTrue.'js/app.js')}}"></script>
  <script src="{{asset($activeTemplateTrue.'js/custom.js')}}"></script>
  <script src="{{ asset($activeTemplateTrue.'js/nicEdit.js') }}"></script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('admin.partials.notify')

    <script>
      (function($,document){
          "use strict";
          bkLib.onDomLoaded(function() {
              $( ".nicEdit" ).each(function( index ) {
                  $(this).attr("id","nicEditor"+index);
                  new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
              });
          });
        
      })(jQuery, document);
    </script>

    <script>
        (function ($) {
            "use strict";
            $(document).on("change", ".langSel", function() {
                window.location.href = "{{url('/')}}/change/"+$(this).val() ;
            });
        })(jQuery);
    </script>
  </body>
</html> 