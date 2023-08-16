@extends('admin.layouts.app')

@section('panel')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card b-radius--10 ">
            <div class="card-header">
                <h5>@lang('Edit Fields')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.subcategories.fields.update',$field->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{$field->type}}">
                    <div class="form-group">
                        <label>@lang('label')</label>
                        <input class="form-control" type="text" name="label" value="{{$field->label}}" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Required')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('YES')" data-off="@lang('NO')" name="required" {{$field->required == 1 ?'checked':''}}>
                    </div>
                    @if ($field->type == 2 || $field->type == 3 )
                    <div class="form-group">
                        <label>@lang('Set As Filter')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('SET')" data-off="@lang('UNSET')" name="filter" {{$field->as_filter == 1 ?'checked':''}}>
                    </div>
                    @endif
                    @if ($field->type == 1 || $field->type == 4 )
                        <div class="form-group">
                            <label>@lang('Placeholder')</label>
                            <input class="form-control" type="text" name="placeholder" value="{{$field->placeholder}}" required>
                        </div>
                       
                    @elseif($field->type == 2 || $field->type == 3)
                            <label >@lang('Option')</label>
                        @foreach ($field->options as $opt)
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="option[]" value="{{$opt}}" required>
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text bg--danger remove">-</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="append"></div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn--success add"><i class="las la-plus"></i> @lang('Add')</button>
                        </div>
                    @endif
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@push('script')
    
<script>
    'use strict';
    (function ($) {
        $(document).on('click','.add',function () { 
        var el = ` <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" type="text" name="option[]" required>
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

    <a  class="btn btn--dark" href="{{route('admin.subcategories.fields',$field->subcategory->id)}}"><i class="las la-backward"></i> @lang('Go Back')</a>

@endpush