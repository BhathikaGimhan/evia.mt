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
                                <th scope="col">@lang('Reported at')</th>
                                <th scope="col">@lang('Reasons')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reports as $report)
                            @php
                            if($report->seen == 0){
                                $report->seen = 1;
                                $report->update();
                            }
                            @endphp
                            <tr>
                                <td data-label="@lang('Title')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{getImage('assets/images/item_image/'.$report->ad->prev_image,'100x100')}}" alt="image"></div>
                                        <span class="name"><a target="_blank" href="{{route('ad.details',$report->ad->slug)}}">{{$report->ad->title}}</a></span>
                                    </div>
                                </td>
                                <td data-label="@lang('User')"><a href="{{route('admin.users.detail',$report->user->id)}}">{{$report->user->username}}</a></td>
                               
                                <td data-label="@lang('Reported at')">{{showDateTime($report->created_at,'d M Y')}}</td>

                                <td data-label="@lang('Reasons')">
                                    <button type="button" class="btn btn-sm btn--dark seeReason" data-toggle="modal" data-target="#reasonModal" data-reasons="{{$report->reasons}}"> <i class="las la-eye"></i>@lang('see')</button>

                                </td>
                               
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" data-route="{{route('admin.ads.status',$report->id)}}" class="icon-btn btn--dark unpublish" data-toggle="tooltip" title="@lang('Unpublish')">
                                        <i class="las la-undo"></i>
                                    </a>
                                  
                                   
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
                    {{paginateLinks($reports)}}
                </div>
            </div><!-- card end -->
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--primary">
                    <h5 class="modal-title text-white">@lang('Reasons')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                   <p class="reasons"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn--dark" data-dismiss="modal">@lang('Close')</button>
                  
                </div>
            </div>
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
                        
                        <i class="las la-exclamation-circle text--danger display-2 mb-15"></i>
                        <h4 class="text--secondary mb-15">@lang('Are you sure want to unpublish this?')</h4>

                    </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit"  class="btn btn--danger del">@lang('Confirm')</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    
<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('Ad title')" value="{{$search??''}}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

@endpush

@push('script')

<script>

    'use strict';
     $('.seeReason').on('click',function () { 
        $('.reasons').text($(this).data('reasons'))
     })

     $('.unpublish').on('click',function(){
        var route = $(this).data('route')
        var modal = $('#confirmModal');
        modal.find('form').attr('action',route)
        modal.modal('show');
    })

</script>

@endpush
