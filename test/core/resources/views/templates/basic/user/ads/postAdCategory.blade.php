@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-1 shadow-sm p-4">
                <div class="card-header border-0 bg-transparent text-center">
                    <h5>@lang('Choose Category Below.')</h5>
                   
                </div>
                <div class="card-body">
                    <ul class="select-menu-list">
                        @forelse ($categories as $cat)
                        <li class="has-drop-menu">
                          <a href="javascript:void(0)">
                            <img src="{{getImage('assets/images/category/'.$cat->image)}}" alt="image" class="select-menu-img">
                            <span>{{__($cat->name)}}</span>
                          </a>
                          <ul class="drop-menu">
                            @foreach ($cat->subcategories->where('type',$flag) as $subcat)
                                
                            <li>
                              <a href="{{route('user.post.ad.location',[$type,$subcat->slug])}}">
                                <i class="las la-caret-right"></i>
                                <span>{{__($subcat->name)}}</span>
                              </a>
                            </li>
                            @endforeach
                           
                          </ul>
                        </li>
                        @empty
                        <li class="text-center">@lang('No categories available')</li>
                        @endforelse
                      </ul>
                </div>
            </div>
        </div>
    </div>
@stop


