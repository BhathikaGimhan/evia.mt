@extends('admin.layouts.app')

@section('panel')

<div class="row">
    <div class="col-lg-7">
        <div class="card b-radius--10 ">
            <div class="card-header mb-3">
                <h5>@lang('Existing Fields')</h5>
            </div>
            <div class="card-body px-5 pb-4">
                    @forelse ($subCategory->fields as $field)
                        @if ($field->type == 1 || $field->type == 4 )
                            <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="font-weight-bold">@lang($field->label) <small class="text--danger" >({{$field->required == 1 ? 'Required':'Optional'}})</small> </label>
                                            @if($field->type == 1)
                                                <input class="form-control" type="text" placeholder="{{$field->placeholder}}">
                                            @else
                                               <textarea class="form-control"  placeholder="{{$field->placeholder}}"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                       <div class="form-group">
                                            <label for="" class="d-block">&nbsp;</label>
                                            <a href="{{route('admin.subcategories.fields.edit',$field->id)}}" class="btn btn--38px btn--primary"><i class="las la-edit"></i></a>
                                            <a href="javascript:void(0)" data-route="{{route('admin.subcategories.fields.remove',$field->id)}}" class="btn btn--38px btn--danger delete"><i class="las la-times"></i></a>
                                       </div>
                                    </div>
                            </div> 

                        @elseif($field->type == 2 || $field->type == 3)
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        @if ($field->type == 2 )
                                        <label class="font-weight-bold">@lang($field->label)</label>
                                        <select class="form-control">
                                                @foreach ($field->options as $opt)
                                                    <option>{{$opt}}</option>
                                                @endforeach
                                            </select>
                                            
                                        @else
                                            <label for="" class="font-weight-bold">@lang($field->label)</label>
                                            @foreach ($field->options as $opt)
                                            <div class="custom-control custom-checkbox form-check-primary">
                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$loop->iteration}}" checked>
                                                <label class="custom-control-label" for="customCheck{{$loop->iteration}}">@lang($opt)</label>
                                            </div>
                                            @endforeach
                                        @endif
                                    
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label for="" class="d-block">&nbsp;</label>
                                        <a href="{{route('admin.subcategories.fields.edit',$field->id)}}" class="btn btn--38px btn--primary"><i class="las la-edit"></i></a>
                                        <a href="javascript:void(0)" data-route="{{route('admin.subcategories.fields.remove',$field->id)}}" class="btn btn--38px btn--danger delete"><i class="las la-times"></i></a>
                                   </div>
                                </div>
                            </div> 
                        @endif
                    @empty
                        <div class="form-group text-center">
                            <h4 class="my-3">@lang('No Fields Available')</h4>
                        </div>
                    @endforelse
                
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card b-radius--10 ">
            <div class="card-header">
                <h5>@lang('Add Fields')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.subcategories.fields.add')}}" method="POST">
                    @csrf
                    <input type="hidden" name="subcategory_id" value="{{$subCategory->id}}">
                    <div class="form-group">
                        <label >@lang('Select Input Type')</label>
                        <select class="form-control type" name="type" required>
                            <option value="1">@lang('Input')</option>
                            <option value="2">@lang('Select')</option>
                            <option value="3">@lang('CheckBox')</option>
                            <option value="4">@lang('Textarea')</option>
                        </select>
                    </div>
                    <div class="append">
                        <div class="form-group">
                            <label>@lang('label')</label>
                            <input class="form-control" type="text" name="label" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Placeholder')</label>
                            <input class="form-control" type="text" name="placeholder" required>
                        </div>
                    </div>
                    <div class="form-group filter d-none">
                        <label>@lang('Set As Filter')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('SET')" data-off="@lang('UNSET')" name="filter" id="filter" disabled>
                    </div>
                    <div class="form-group">
                        <label>@lang('Required')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('YES')" data-off="@lang('NO')" name="required">
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


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
              <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
              <button type="submit"  class="btn btn--danger del">@lang('Delete')</button>
            </div>
            
            </form>
      </div>
    </div>
</div>

@stop

@push('script')
    
<script>
    'use strict';
(function ($) {
        $('.type').on('click',function () { 
        var data = $(this).val();
        var append = $('.append')
        var inputEl = ` <div class="form-group">
                            <label>@lang('label')</label>
                            <input class="form-control" type="text" name="label" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Placeholder')</label>
                            <input class="form-control" type="text" name="placeholder" required>
                        </div>`;
        
        var selectEl = `  <div class="form-group">
                                <label >@lang('label')</label>
                                <input class="form-control" type="text" name="label" required>
                           </div>
                            <div class="form-group">
                                <label >@lang('Option')</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="option[]" required>
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text bg--success add">+</button>
                                    </div>
                                </div>
                            </div>`;
   
   
        if(data == 1){
            append.html(inputEl)
            $('.filter').addClass('d-none')
            $('#filter').attr('disabled',true)
        } else if(data == 2){
            append.html(selectEl)
            $('.filter').removeClass('d-none')
            $('#filter').attr('disabled',false)
        } else if(data == 3){
            append.html(selectEl)
            $('.filter').removeClass('d-none')
            $('#filter').attr('disabled',false)
        } else {
            append.html(inputEl)
            $('.filter').addClass('d-none')
            $('#filter').attr('disabled',true)
        }
        
    });

    $(document).on('click','.add',function () { 
        var el = ` <div class="form-group">
                       
                        <div class="input-group">
                            <input class="form-control" type="text" name="option[]">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text bg--danger remove">-</button>
                            </div>
                        </div>
                    </div>`
        $('.append').append(el)
     })

     $(document).on('click','.remove',function () { 
        $(this).parent().parent().remove()
     })

     $('.delete').on('click',function(){
        var route = $(this).data('route')
        var modal = $('#deleteModal');
        modal.find('form').attr('action',route)
        modal.modal('show');

    })
})(jQuery);
</script>

@endpush
@push('style')
    <style>
        .btn--38px {
            height: 38px;
            line-height: 38px;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin-top: 4px;
        }
        .btn i {
              margin-right: -1px!important;
         }
    </style>
@endpush

@push('breadcrumb-plugins')
    <a  class="btn btn--dark" href="{{route('admin.subcategories',$subCategory->category_id)}}"><i class="las la-backward"></i> @lang('Go Back')</a>
@endpush