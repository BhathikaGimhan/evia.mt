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
                                <th scope="col">@lang('District Name')</th>
                                <th scope="col">@lang('Division Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                               
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($districts as $district)
                            <tr>
                                <td data-label="@lang('District Name')">{{$district->name}}</td>
                                <td data-label="@lang('Division Name')"><span class="text--small badge font-weight-normal badge--primary">{{$district->division->name}}</span></td>
                                <td data-label="@lang('Status')">
                                    @if ($district->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">@lang('active')</span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('inactive')</span>
                                    @endif
                                </td>
                               
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" class="icon-btn edit" data-district="{{$district}}" data-route="{{route('admin.location.districts.update',$district->id)}}" data-toggle="tooltip" title="@lang('Edit')">
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
                   {{paginateLinks($districts)}}
                </div>
            </div><!-- card end -->
        </div>
    </div>

<!-- ADD Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{route('admin.location.districts.store')}}" method="POST">
          @csrf
        <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Add District')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="division_id" value="{{$division->id}}">
              <div class="form-group">
                  <label >@lang('District Name')</label>
                  <input class="form-control" type="text" name="name" placeholder="@lang('District Name')" required>
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
      <form action="" method="POST">
          @csrf
        <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Edit District')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label >@lang('District Name')</label>
                  <input class="form-control" type="text" name="name" placeholder="@lang('District Name')" required>
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

<a  class="btn btn--dark mr-3 mt-2" href="{{route('admin.location.divisions')}}"><i class="las la-list"></i> @lang('Divisions')</a>

<!-- Button trigger modal -->
<button type="button" class="btn btn--primary mr-3 mt-2" data-toggle="modal" data-target="#addModal">
  <i class="la la-plus"></i>@lang('Add District')
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
                var division = $(this).data('district')
                var route = $(this).data('route')
                $('#editModal').find('input[name=name]').val(division.name)
                if(division.status == 1){
                    $('#editModal').find('input[name=status]').bootstrapToggle('on')
                }
                $('#editModal').find('form').attr('action',route)
                $('#editModal').modal('show')
             })
        })(jQuery);
    </script>

@endpush