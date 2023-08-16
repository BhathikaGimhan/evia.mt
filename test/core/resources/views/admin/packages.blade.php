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
                                <th scope="col">@lang('Package Name')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Validity')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($packages as $package)
                            <tr>
                                <td data-label="@lang('Subscription Name')"><span class="text--small badge font-weight-normal badge--success">{{$package->name}}</span></td>
                                <td data-label="@lang('Price')"><span class="badge badge-pill bg--primary">{{$general->cur_sym}} {{getAmount($package->price)}} {{$general->cur_text}}</span></td>
                                <td data-label="@lang('Validity')">{{$package->validity}} @lang('days')</td>
                                <td data-label="@lang('Status')">
                                    @if ($package->status == 1)
                                     <span class="text--small badge font-weight-normal badge--success">@lang('active')</span>
                                    @else
                                     <span class="text--small badge font-weight-normal badge--warning">@lang('inactive')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" class="icon-btn edit" data-package="{{$package}}" data-route="{{route('admin.packages.update',$package->id)}}" data-toggle="tooltip" title="@lang('Edit')">
                                        <i class="las la-edit text--shadow"></i>
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
                 
                </div>
            </div><!-- card end -->
        </div>


    </div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{route('admin.packages.store')}}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white">@lang('Add Package')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label >@lang('Name')</label>
                    <input class="form-control" type="text" name="name" placeholder="@lang('Package Name')" value="{{old('name')}}" required>
                </div>
                <div class="form-group">
                    <label >@lang('Price')</label>
                    <div class="input-group">
                       <input class="form-control" type="number" min="0" name="price" placeholder="@lang('Package Price')" value="{{old('price')}}" required>
                       <div class="input-group-append">
                           <span class="input-group-text">{{$general->cur_text}}</span>
                       </div>
                    </div>
                </div>
               
                <div class="form-group">
                    <label >@lang('Validity') <small>(@lang('in days'))</small></label>
                    <div class="input-group">
                       <input class="form-control" type="number" min="1" name="validity" placeholder="@lang('Package validity')" value="{{old('validity')}}" required>
                       <div class="input-group-append">
                           <span class="input-group-text">@lang('days')</span>
                       </div>
                    </div>
                </div>

                 <div class="form-group">
                     <label>@lang('Status')</label>
                     <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('active')" data-off="@lang('inactive')" name="status">
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white">@lang('Edit Package')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label >@lang('Name')</label>
                    <input class="form-control" type="text" name="name" placeholder="@lang('Package Name')" required>
                </div>
                <div class="form-group">
                    <label >@lang('Price')</label>
                    <div class="input-group">
                       <input class="form-control" type="number" min="0" name="price" placeholder="@lang('Package Price')" required>
                       <div class="input-group-append">
                           <span class="input-group-text">{{$general->cur_text}}</span>
                       </div>
                    </div>
                </div>
               
                <div class="form-group">
                    <label >@lang('Validity') <small>(@lang('in days'))</small></label>
                    <div class="input-group">
                       <input class="form-control" type="number" min="1" name="validity" placeholder="@lang('Package validity')" required>
                       <div class="input-group-append">
                           <span class="input-group-text">@lang('days')</span>
                       </div>
                    </div>
                </div>

                 <div class="form-group">
                     <label>@lang('Status')</label>
                     <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('active')" data-off="@lang('inactive')" name="status">
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
@endsection



@push('breadcrumb-plugins')

<!-- Button trigger modal -->
<button type="button" class="btn btn--primary mr-3 mt-2" data-toggle="modal" data-target="#addModal">
  <i class="las la-plus"></i> @lang('Add Package')
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
                var packages = $(this).data('package')
                var price = parseInt(packages.price)
                var route = $(this).data('route')
                $('#editModal').find('input[name=name]').val(packages.name)
                $('#editModal').find('input[name=price]').val(price.toFixed(2))
                $('#editModal').find('input[name=validity]').val(packages.validity)

                if(packages.status == 1){
                    $('#editModal').find('input[name=status]').bootstrapToggle('on')
                }
                $('#editModal').find('form').attr('action',route)
                $('#editModal').modal('show')
             })
        })(jQuery);
    </script>

@endpush