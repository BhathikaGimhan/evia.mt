@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-1 shadow-sm p-4">
                <div class="card-header border-0 bg-transparent text-center">
                    <h5>@lang('Select Location Below.')</h5>
                   
                </div>
                <div class="card-body">
                    <ul class="select-menu-list">
                        @forelse ($locations as $division)
                        <li class="has-drop-menu">
                          <a href="javascript:void(0)">
                            <img src="{{getImage('assets/images/location/'.$division->image)}}" alt="location" class="select-menu-img">
                            <span>{{__($division->name)}}</span>
                          </a>
                          <ul class="drop-menu">
                            @foreach ($division->districts as $district)
                                
                            <li>
                              <a href="{{route('user.post.ad.form',[$type,$subcat,$district->slug])}}">
                                <i class="las la-caret-right"></i>
                                <span>{{__($district->name)}}</span>
                              </a>
                            </li>
                            @endforeach
                           
                          </ul>
                        </li>
                       
                        @empty
                        <li class="text-center">@lang('No locations available')</li>
                        @endforelse
                        
                      </ul>
                </div>
            </div>
        </div>
    </div>
@stop


