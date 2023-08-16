  @php
      
    $content = getContent('cta.content',true)->data_values;
    $elements = getContent('cta.element',false,'',1);

  @endphp
  <!-- cta section start -->
  <section class="pt-50 pb-50 section--bg">
    <div class="container">
      <div class="row gy-4 justify-content-center">
     @foreach ($elements as $el)
        <div class="col-lg-4">
            <div class="feature-item text-center">
                <div class="feature-item__icon">
                <img src="{{getImage("assets/images/frontend/cta/".$el->data_values->icon_image,'65x65')}}" alt="image">
                </div>
                <div class="feature-item__content">
                <h4 class="title">{{__($el->data_values->title)}}</h4>
                <p class="mt-3">{{__($el->data_values->short_details)}}</p>
                </div>
            </div><!-- feature-item end -->
        </div>
      @endforeach
        
      </div>
      <div class="row justify-content-center mt-5">
        <div class="col-lg-12">
          <div class="cta-wrapper">
            <div class="cta-wrapper__inner text-center">
              <h2 class="title text-white">{{__($content->heading)}}</h2>
              <h6 class="mt-2 text-white">{{__($content->sub_heading)}}</h6>
              <a href="{{url($content->button_link)}}" class="btn bg-white mt-4">{{__($content->button_text)}}</a>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- cta section end -->