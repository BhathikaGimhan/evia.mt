@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Category/Subcategory')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Featured')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ads as $ad)
                            <tr>
                                <td data-label="@lang('Title')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{getImage('assets/images/item_image/'.$ad->prev_image,'100x100')}}" alt="image"></div>
                                        <span class="name"><a class="text-secondary" href="{{route('ad.details',$ad->slug)}}" target="_blank">{{$ad->title}}</a></span> <br>
                                    </div>
                                   
                                </td>
                                <td data-label="@lang('User')"><a href="{{route('admin.users.detail',$ad->user->id)}}">{{$ad->user->username}}</a></td>
                                <td data-label="@lang('Category/Subcategory')">
                                    <span class="text--warning font-weight-bold">{{$ad->category->name}}</span> <br>
                                    <span class="text--primary">{{$ad->subcategory->name}}</span>
                                </td>
                              
                                <td data-label="@lang('Price')">{{getAmount($ad->price)}} {{$general->cur_text}}</td>
                                <td data-label="@lang('Featured')">
                                    @if ($ad->featured == 1)
                                    <span class="badge badge-pill bg--primary">@lang('Yes')</span>
                                    @else
                                    <span class="badge badge-pill bg--dark">@lang('No')</span>
                                    @endif
                                
                                </td>
                                <td data-label="@lang('Status')">
                                    @if ($ad->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">@lang('Published')</span>
                                    @elseif($ad->status == 2)
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('Unpublished')</span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{route('admin.ads.edit',$ad->id)}}" class="icon-btn mr-2" data-toggle="tooltip" title="@lang('Edit')">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                    @if ($ad->status == 1)
                                    <a href="javascript:void(0)" data-route="{{route('admin.ads.status',$ad->id)}}" class="confirm icon-btn btn--dark" data-toggle="tooltip" title="@lang('Unpublish')">
                                        <i class="las la-undo"></i>
                                    </a>
                                    @else
                                    <a href="javascript:void(0)" data-route="{{route('admin.ads.status',$ad->id)}}" data-publish="1"  class="confirm icon-btn btn--success" data-toggle="tooltip" title="@lang('Publish')">
                                        <i class="las la-share-square"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{paginateLinks($ads)}}
                </div>
            </div><!-- card end -->
        </div>


    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
            <form action="" method="POST">
                @csrf
                <div class="modal-body text-center">
                    
                    <i class="las la-exclamation-circle text--warning modal-icon display-2 mb-15"></i>
                    <h4 class="text--secondary stat-msg mb-15">@lang('Are you sure want to unpublish?')</h4>

                </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                <button type="submit"  class="btn btn--warning del">@lang('Unpublish')</button>
            </div>
            
            </form>
        </div>
    </div>
            </div>
@endsection



@push('breadcrumb-plugins')
    
<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('title, category')" value="{{$search??''}}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

@endpush

    
@push('script')
     <script>
            'use strict';
            (function ($) {
                $('.confirm').on('click',function(){
                    var route = $(this).data('route')
                    var modal = $('#confirmModal');
                    var publish = $(this).data('publish')
                    if(publish == 1){
                        $('#confirmModal').find('.modal-icon').removeClass('text--warning').addClass('text--success')
                        $('#confirmModal').find('.del').removeClass('btn--warning').addClass('btn--success').text('Publish')
                        $('#confirmModal').find('.stat-msg').text('Are you sure want to publish?')
                    }
                    modal.find('form').attr('action',route)
                    modal.modal('show');
                })
            })(jQuery);
     </script>
@endpush