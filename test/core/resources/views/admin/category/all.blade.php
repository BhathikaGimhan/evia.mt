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
                                <th scope="col">@lang('Category Name')</th>
                                <th scope="col">@lang('Slug')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Sub categories')</th>
                                <th scope="col">@lang('Action')</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td data-label="@lang('Category Name')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{ getImage('assets/images/category/'.$category->image) }}" alt="image"></div>
                                        <span class="name">{{$category->name}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Slug')">{{$category->slug}}</td>
                                <td data-label="@lang('Status')">
                                    @if ($category->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">@lang('active')</span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('inactive')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Sub-Categories')"><a href="{{route('admin.subcategories',$category->id)}}" class="icon-btn btn--dark"> <i class="las la-eye"></i> @lang('View')</a></td>
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" data-category="{{$category}}" data-route="{{route('admin.categories.update',$category->id)}}" data-image="{{ getImage('assets/images/category/'.$category->image,'512x512') }}" class="icon-btn edit" data-toggle="tooltip" title="@lang('edit category')">
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
                    {{paginateLinks($categories)}}
                </div>
            </div><!-- card end -->
        </div>


         <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg--primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Add Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage('assets/images/category/','512x512') }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 512x512px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label >@lang('Category Name')</label>
                                <input type="text" class="form-control" name="name"  placeholder="@lang('Category name')">
                            
                            </div>
                            <div class="form-group">
                                <label >@lang('Short Description')</label>
                                <textarea type="text" class="form-control" name="description"  placeholder="@lang('Short Description')"></textarea>
                            
                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
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


      
         <!-- edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg--primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Edit Category')</h5>
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
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 512x512px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >@lang('Category Name')</label>
                                <input type="text" class="form-control" name="name"  placeholder="@lang('Category name')">
                            
                            </div>

                            <div class="form-group">
                                <label >@lang('Short Description')</label>
                                <textarea type="text" class="form-control" name="description"  placeholder="@lang('Short Description')"></textarea>
                            
                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
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

    </div>
@endsection



@push('breadcrumb-plugins')

    <!-- Button trigger modal -->
    <button type="button" class="btn btn--primary mr-3 mt-2" data-toggle="modal" data-target="#addModal">
      <i class="las la-plus"></i> @lang('Add Category')
    </button>
    
    <form action="{{route('admin.categories')}}" method="GET" class="form-inline float-sm-right bg--white mt-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Search by name')" value="" autocomplete="off">
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
            $('.edit').click(function () { 
                var category = $(this).data('category')
                var image = $(this).data('image')
                var route = $(this).data('route')

                $('#editModal').find('input[name=name]').val(category.name)
                $('#editModal').find('textarea[name=description]').val(category.description)
                $('#editModal').find('#profilePicPreview').css('background-image','url(' + image + ')')
                $('#editModal').find('form').attr('action',route)
                if(category.status == 1){
                    $('#editModal').find('input[name=status]').bootstrapToggle('on')
                }
                $('#editModal').modal('show')
                
            });
        })(jQuery);

    </script>

@endpush


