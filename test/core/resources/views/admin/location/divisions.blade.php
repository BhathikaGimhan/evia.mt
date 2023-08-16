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
                                <th scope="col">@lang('Division Name')</th>
                                <th scope="col">@lang('Total Districts')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Districts')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($divisions as $division)
                            <tr>
                                <td data-label="@lang('Division Name')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{getImage('assets/images/location/'.$division->image,'768x550')}}" alt="image"></div>
                                        <span class="name">{{$division->name}}</span>
                                    </div>
                                </td>
                               
                                <td data-label="@lang('Total Districts')"><span class="text--small badge font-weight-normal badge--primary">{{$division->districts->count()}}</span></td>
                                <td data-label="@lang('Status')">
                                    @if ($division->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">@lang('active')</span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('inactive')</span>
                                    @endif
                                </td>
                               
                                <td data-label="@lang('Districts')">
                                    <a href="{{route('admin.location.districts',$division->id)}}" class="icon-btn btn--dark"><i class="las la-eye"></i> @lang('View')</a>
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" class="icon-btn edit" data-division="{{$division}}" data-route="{{route('admin.location.divisions.update',$division->id)}}" data-image="{{getImage('assets/images/location/'.$division->image,'768x550')}}" data-toggle="tooltip" title="@lang('Edit')">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang($empty_message)</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                   {{paginateLinks($divisions)}}
                </div>
            </div><!-- card end -->
        </div>
    </div>

<!-- ADD Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{route('admin.location.divisions.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Add Division')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview" style="background-image: url({{ getImage('','768x550') }})">
                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 768x550px') </small>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="form-group">
                  <label >@lang('Division Name')</label>
                  <input class="form-control" type="text" name="name" placeholder="@lang('Division Name')" required>
              </div>
               <div class="form-group">
                   <label>@lang('Status')</label>
                   <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status">
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
              <button type="submit" class="btn btn--primary">@lang('Submit')</button>
            </div>
          </div>
      </form>
    </div>
  </div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Edit Division')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview" id="profilePicPreview">
                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                <label for="profilePicUpload2" class="bg--success">@lang('Upload Image')</label>
                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 768x550px') </small>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="form-group">
                  <label >@lang('Division Name')</label>
                  <input class="form-control" type="text" name="name" placeholder="@lang('Division Name')" required>
              </div>
               <div class="form-group">
                   <label>@lang('Status')</label>
                   <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status">
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
              <button type="submit" class="btn btn--primary">@lang('Update')</button>
            </div>
          </div>
      </form>
    </div>
  </div>
  

@endsection



@push('breadcrumb-plugins')
<!-- Button trigger modal -->
<button type="button" class="btn btn--primary mr-3 mt-2" data-toggle="modal" data-target="#addModal">
  <i class="la la-plus"></i>@lang('Add Division')
</button>

    <form action="" method="GET" class="form-inline float-sm-right bg--white mt-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('search by name')" value="{{$search??''}}">
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
            $('.edit').on('click',function () { 
                var division = $(this).data('division')
                var route = $(this).data('route')
                var image = $(this).data('image')
                $('#editModal').find('input[name=name]').val(division.name)
                $('#editModal').find('#profilePicPreview').css('background-image','url('+image+')')
                if(division.status == 1){
                    $('#editModal').find('input[name=status]').bootstrapToggle('on')
                }
                $('#editModal').find('form').attr('action',route)
                $('#editModal').modal('show')
            })
        })(jQuery);
    </script>

@endpush

