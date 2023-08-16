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
                                <th scope="col">@lang('Advertisement Type')</th>
                                <th scope="col">@lang('Ad Size')</th>
                                <th scope="col">@lang('Ad Image')</th>
                                <th scope="col">@lang('Total Click')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($advertisements as $advr)
                            <tr>
                                <td data-label="@lang('Advertisement Type')"><span class="text--small badge font-weight-normal {{$advr->type == 1 ? 'badge--success':'badge--primary'}}">{{$advr->type == 1 ? 'Banner':'Script'}}</span></td>
                                <td data-label=">@lang('Resolution')"><span class="text--small badge font-weight-normal badge--primary">{{$advr->resolution}}</span></td>
                                @if ($advr->type == 1)
                                  <td data-label="@lang('Ad Image')"> <a class="btn btn-sm btn--dark" href="{{getImage('assets/images/commercial/'.$advr->ad_image)}}"  data-rel="lightcase"> <i class="las la-eye"></i> @lang('see')</a></td>
                                @else
                                   <td @lang('Ad Image')> @lang('N/A')</td>
                                @endif
                                <td data-label="@lang('Total Click')"><span class="text--small badge font-weight-normal badge--primary">{{getAmount($advr->total_click)}}</span></td>

                                <td data-label="@lang('Status')"><span class="text--small badge font-weight-normal {{$advr->status == 1 ? 'badge--success':'badge--warning'}}">{{$advr->status == 1 ? 'active':'inactive'}}</span></td>
                                
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" data-advr="{{$advr}}" data-route="{{route('admin.advertisements.update',$advr->id)}}" class="icon-btn mr-2 edit" data-toggle="tooltip" title="@lang('Edit')">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-route="{{route('admin.advertisements.remove',$advr->id)}}" class="icon-btn btn--danger delete" data-toggle="tooltip" title="@lang('Delete')">
                                        <i class="las la-trash text--shadow"></i>
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
                 {{paginateLinks($advertisements)}}
                </div>
            </div><!-- card end -->
        </div>


        <div class="modal fade" id="adModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog" role="document">
               <form action="{{route('admin.advertisements.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg--primary">
                        <h5 class="modal-title text-white">@lang('Ad new advertisement')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label >@lang('Select Type')</label>
                            <select class="form-control type" name="type" required>
                                <option value="1">@lang('Banner')</option>
                                <option value="2">@lang('Script')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >@lang('Select Ad Size')</label>
                            <select class="form-control" name="size" required>
                                <option value="300x250">@lang('300x250')</option>
                                <option value="300x600">@lang('300x600')</option>
                                <option value="970x90">@lang('970x90')</option>
                            </select>
                        </div>
                        <div class="form-group ru">
                            <label >@lang('Redirect Url')</label>
                            <input type="text" class="form-control" name="redirect_url" placeholder="@lang('http/https://example.com')" required value="{{old('redirect_url')}}">
                        </div>
                      
                        <div class="form-group adfile">
                            <label >@lang('Ad Image')</label>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold"> <input type="file" class="form-control-file" name="adimage" required id="img"> </li>
                        </div>

                        <div class="form-group script d-none">
                            <label >@lang('Ad Script')</label>
                            <textarea type="text" class="form-control" disabled name="script" required>{{old('script')}}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                   data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status"
                                  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </div>
               </form>
            </div>
        </div>


        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog" role="document">
               <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg--primary">
                        <h5 class="modal-title text-white">@lang('Edit Advertisement')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label >@lang('Select Type')</label>
                            <select class="form-control type" name="type" required readonly>
                                <option value="1">@lang('Banner')</option>
                                <option value="2">@lang('Script')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >@lang('Select Ad Size')</label>
                            <select class="form-control" name="size" required>
                                <option value="728x90">@lang('728x90')</option>
                                <option value="300x250">@lang('300x250')</option>
                                <option value="300x600">@lang('300x600')</option>
                                <option value="970x90">@lang('970x90')</option>
                            </select>
                        </div>
                        <div class="form-group ru">
                            <label >@lang('Redirect Url')</label>
                            <input type="text" class="form-control" name="redirect_url" placeholder="@lang('http/https://example.com')" required value="{{old('redirect_url')}}">
                        </div>
                      
                        <div class="form-group adfile">
                            <label >@lang('Ad Image')</label>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold"> <input type="file" class="form-control-file" name="adimage" id="img"> </li>
                        </div>

                        <div class="form-group script d-none">
                            <label >@lang('Ad Script')</label>
                            <textarea type="text" class="form-control" disabled name="script" required>{{old('script')}}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                   data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status"
                                  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </div>
               </form>
            </div>
        </div>


    {{-- delete modal --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
               <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body text-center">
                            
                            <i class="las la-exclamation-circle text-danger display-2 mb-15"></i>
                            <h4 class="text--secondary mb-15">@lang('Are you sure want to delete this?')</h4>
    
                        </div>
                    <div class="modal-footer justify-content-center">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                      <button type="submit"  class="btn btn-danger del">@lang('Delete')</button>
                    </div>
                    
                    </form>
              </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')

    <button type="button" data-toggle="modal" data-target="#adModal" class="btn btn--primary mr-3 mt-2"><i class="la la-plus"></i>@lang('Ad New')</button>

    <form action="" method="GET" class="form-inline float-sm-right bg--white mt-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Search by ad size')" value="{{$search ?? ''}}" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush

@push('style-lib')
  <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}"> 
@endpush

@push('script-lib')
<script src="{{asset($activeTemplateTrue.'js/lib/lightcase.min.js')}}"></script>
@endpush

@push('script')
    
     <script>
            'use strict';
            (function ($) {
                $('.type').on("change",function () { 
                    if($(this).val() == 1){
                        $('.ru').removeClass('d-none')
                        $('.ru').find('input[name=redirect_url]').attr('disabled',false)

                        $('.adfile').removeClass('d-none')
                        $('.adfile').find('input[name=adimage]').attr('disabled',false)

                        $('.script').addClass('d-none')
                        $('.script').find('textarea[name=script]').attr('disabled',true)

                    } else if($(this).val() == 2) {

                        $('.ru').addClass('d-none')
                        $('.ru').find('input[name=redirect_url]').attr('disabled',true)

                        $('.previmage').addClass("d-none")

                        $('.adfile').addClass('d-none')
                        $('.adfile').find('input[name=adimage]').attr('disabled',true)

                        $('.script').removeClass('d-none')
                        $('.script').find('textarea[name=script]').attr('disabled',false)
                    }
                       
                })

                $('.edit').on('click',function () { 
                    var modal = $('#editModal')
                    var advr = $(this).data('advr')
                    var route = $(this).data('route')

                    modal.find('select[name=type]').val(advr.type)
                    modal.find('select[name=size]').val(advr.resolution)
                    if(advr.redirect_url){
                      modal.find('input[name=redirect_url]').val(advr.redirect_url)
                    }
                    if(advr.script != null){
                        $('.ru').addClass('d-none')
                        $('.ru').find('input[name=redirect_url]').attr('disabled',true)

                        $('.previmage').addClass("d-none")

                        $('.adfile').addClass('d-none')
                        $('.adfile').find('input[name=adimage]').attr('disabled',true)

                        $('.script').removeClass('d-none')
                        $('.script').find('textarea[name=script]').attr('disabled',false)
                        modal.find('textarea[name=script]').val(advr.script)
                    } else {
                        $('.ru').removeClass('d-none')
                        $('.ru').find('input[name=redirect_url]').attr('disabled',false)

                        $('.adfile').removeClass('d-none')
                        $('.adfile').find('input[name=adimage]').attr('disabled',false)

                        $('.script').addClass('d-none')
                        $('.script').find('textarea[name=script]').attr('disabled',true)
                    }
                    if(advr.status == 1){
                      modal.find('input[name=status]').bootstrapToggle('on')
                    }
                    modal.find('form').attr('action',route)
                    modal.modal('show')
                })

                $('.delete').on('click',function(){
                    var route = $(this).data('route')
                    var modal = $('#deleteModal');
                    modal.find('form').attr('action',route)
                    modal.modal('show');

                })

                $('a[data-rel^=lightcase]').lightcase();


            })(jQuery);
     </script>

@endpush