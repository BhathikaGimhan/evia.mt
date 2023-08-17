
 @if (@$categories && @$divisions)
      <!-- Select Location Modal -->
  <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="locationModalLabel">@lang('Select Location')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="select-menu-list">
            @foreach ($divisions as $division)
            <li class="has-drop-menu">
              <a href="javascript:void(0)">
                <img src="{{getImage('assets/images/location/'.$division->image,'100x100')}}" alt="image" class="select-menu-img">
                <span>{{$division->name}}</span>

              </a>
              <ul class="drop-menu" id="selectLocation">
                <li>
                    <a class="selectAll"  style="color: #43ced2" href="all?division={{$division->slug}}">
                        <i class="las la-map-pin"></i>
                        <span>all of {{__( $division->name)}}</span>
                      </a>
                </li>
                  @foreach ($division->districts as $district)

                  <li>
                    <a href="{{queryBuild('location',$district->slug)}}">
                      <i class="las la-map-marker"></i>
                      <span>{{__($district->name)}}</span>
                    </a>
                  </li>

                  @endforeach
              </ul>
            </li>
            @endforeach

          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Select Category Modal -->
  <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="categoryModalLabel">@lang('Select Category')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="select-menu-list">
            @foreach ($categories as $cat)

            <li class="has-drop-menu">
              <a href="javascript:void(0)">
                <img src="{{getImage('assets/images/category/'.$cat->image)}}" alt="image" class="select-menu-img">
                <span>{{__($cat->name)}}</span>
              </a>
              <ul class="drop-menu">
                @foreach ($cat->subcategories as $subcat)
                 @if(!empty(request()->input()))
                 <li>
                  <a href="{{url('/items/')."/$subcat->slug"."?location=".request()->input('location')}}">
                    <i class="las la-caret-right"></i>
                    <span>{{$subcat->name}}</span>
                  </a>
                </li>
                 @else
                 <li>
                  <a href="{{url('/items/')."/$subcat->slug"}}">
                    <i class="las la-caret-right"></i>
                    <span>{{$subcat->name}}</span>
                  </a>
                  </li>
                 @endif

                  @endforeach

              </ul>
            </li>
            @endforeach

          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
        </div>
      </div>
    </div>
  </div>
 @endif
