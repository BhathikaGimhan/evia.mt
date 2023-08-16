@php
    $bg = getContent('breadcrumb.content',true)->data_values;
@endphp
<section class="inner-hero bg_img" style="background-image: url({{getImage('assets/images/frontend/breadcrumb/'.$bg->background_image)}});">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <h2 class="page-title text-center">{{__($page_title)}}</h2>
          <ul class="page-breadcrumb justify-content-center">
            <li><a href="{{route('home')}}">@lang('Home')</a></li>
            <li>{{__($page_title)}}</li>
          </ul>
        </div>
      </div>
    </div>
  </section>