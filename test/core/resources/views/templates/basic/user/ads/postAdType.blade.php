@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-1 shadow-sm p-4">
                <div class="card-header border-0 bg-transparent text-center">
                    <h5>@lang('Welcome') {{auth()->user()->firstname}}! @lang('Let\'s post an ad.')</h5>
                    <p class="mt-3">@lang('Choose any option below')</p>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between"><a class="text--base" href="{{route('user.post.ad.category','sell')}}">@lang('Sell Service,item or property')</a> <i class="las la-angle-right mt-1"></i></li>
                        <li class="list-group-item d-flex justify-content-between"><a class="text--base" href="{{route('user.post.ad.category','rent')}}">@lang('Rent Item or Service')</a> <i class="las la-angle-right mt-1"></i></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop