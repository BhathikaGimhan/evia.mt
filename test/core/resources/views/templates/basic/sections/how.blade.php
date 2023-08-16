@php
      $elements= getContent('how.element',false,'',1);
@endphp

  <!-- How Section Starts -->
  <section class="how-section section--bg pt-50 pb-50">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($elements as $item)
            <div class="col-md-4">
                <div class="how__item">
                    <div class="shape-bg">
                        @if ($loop->odd)
                        <img src="{{asset($activeTemplateTrue.'images/how-shape2.png')}}" alt="@lang('images')">
                        @else
                        <img src="{{asset($activeTemplateTrue.'images/how-shape.png')}}" alt="@lang('images')">
                        @endif
                    </div>
                  <div class="how__thumb">
                    @php
                        echo $item->data_values->icon;
                    @endphp
                  </div>
                  <div class="how__content">
                      <h5 class="title">@lang($item->data_values->title)</h5>
                  </div>
              </div>
            </div>
                
            @endforeach
          
        </div>
    </div>
</section>
<!-- How Section End -->
