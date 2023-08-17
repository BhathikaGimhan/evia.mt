
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

              <ul class="drop-menu">
                <li>
                    <a href="{{queryBuild('location',$division->slug)}}">
                        <i class="las la-map-marker"></i>
                        <span>{{__("all of, ", $division->name)}}</span>
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


 @php
		$searchUrl =  http_build_query(request()->except('search'));
		$searchUrl =   str_replace("amp%3B","",$searchUrl);
		$queryStrings = json_encode(request()->query());

	@endphp
	@push('script')
	<script>

        $(document).ready(function() {
            $(".hero-search-form-btn").prop('disabled', true);
            // Attach a change event handler to the select element
            $("#mySelect").change(function() {
                // Get the selected option value
                var selectedValue = $(this).val();
                    console.log(selectedValue);
                if(selectedValue == "all"){
                    $(".hero-search-form-btn").prop('disabled', false);
                    $("#searchForm").on('submit',function(e){
                        e.preventDefault();
                        var data = $("#SearchVal").val();
                        window.location.href = '/items/all?search='+data;
                    });
                }else if(selectedValue == "--Select--"){
                    $(".hero-search-form-btn").prop('disabled', true);
                }
                else{
                    $(".hero-search-form-btn").prop('disabled', false);
                    'use strict';
                    $('#searchForm').on('submit',function(e){
                        e.preventDefault();

                        var data = $(this).serialize();
                        var url = '{{url()->current()}}'+'/items/all'+'?{{$searchUrl}}';
                        url = url.replaceAll('amp;','');
                        var queryString = "{{$queryStrings}}"
                        var delim;
                        if(queryString.length > 2){
                            delim = "&"
                        }else {
                            delim = ""
                        }
                        window.location.href = url+delim+data;
                    });
                }
            });
        });


	</script>
	@endpush

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
