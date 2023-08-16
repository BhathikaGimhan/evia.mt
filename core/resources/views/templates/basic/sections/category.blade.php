@php
    $content = getContent('category.content',true)->data_values;
    $categories = \App\Models\Category::where('status',1)->inRandomOrder()->get();
@endphp

    <!-- category section start -->
    <section class="pb-50 section--bg">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="category-wrapper">
                <div class="row justify-content-center">
                  <div class="col-xl-4 col-lg-6">
                    <h2 class="section-title text-center">{{__($content->heading)}}</h2>
                  </div>
                </div><!-- row end -->
                <div class="row mt-4 gy-4 gx-3 justify-content-center">
                  @foreach ($categories as $cat)
                      <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <div class="category-item has--link">
                          <a data-toggle="tooltip" title="{{__($cat->description)}}" href="{{route("ads")}}{{queryBuild('category',$cat->slug)}}" class="item--link"></a>
                          <div class="category-item__thumb">
                            <img src="{{getImage('assets/images/category/'.$cat->image,'512x512')}}" alt="image">
                          </div>
                          <div class="category-item__content">
                            <h6 class="title">{{__($cat->name)}}</h6>
                          </div>
                        </div><!-- category-item end -->
                      </div>

                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- category section end -->
