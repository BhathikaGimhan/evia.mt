@extends('admin.layouts.app')
@section('panel')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card b-radius--10 ">
            <div class="card-header py-4">
                <div class="d-flex justify-content-between title">
                    <h4 class="">@lang('Ad Information')</h4>
                     <div class="">
                       <small class="font-weight-bold"> <i class="las la-tag text--info"></i> {{$ad->subcategory->name}}</small>
                       <small class="font-weight-bold"> <i class="las la-map-marker text--info"></i> {{$ad->district}}</small>
                     </div>
                  </div>
            </div>
            <div class="card-body p-5">
                <form action="{{route('admin.ads.update',$ad->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <label class="mb-3 font-weight-bold">@lang('you need to upload at least 03 images')</label>
                        <div class="product-image-upload-container mb-2 d-flex justify-content-center">
                          <div class="single-upload">
                            <div class="center" >
                              <div class="form-input">
                                <label for="file-ip-0" data-toggle="tooltip" title="@lang('Preview image')">
                                  <img id="file-ip-0-preview" src="{{getImage('assets/images/item_image/'.$ad->prev_image)}}">
                                  <button type="button" class="imgRemove" onclick="myImgRemove(0)"></button>
                                </label>
                                <input type="file"  name="prev_image" id="file-ip-0" accept="image/*" onchange="showPreview(event, 0);">
                                <code style="font-size: 9px;"> thumbnail image</code>
                              </div>
                            </div>
                          </div>
                          @foreach ($ad->images as $img)
                          <div class="single-upload">
                            <div class="center">
                              <div class="form-input">
                                <label for="file-ip-{{$loop->iteration}}">
                                  <img id="file-ip-{{$loop->iteration}}-preview" src="{{getImage('assets/images/item_image/'.$img->image)}}">
                                  <button type="button" class="imgRemove" onclick="myImgRemove({{$loop->iteration}})"></button>
                                </label>
                                <input type="file"  name="image[{{$img->id}}]" id="file-ip-{{$loop->iteration}}" accept="image/*" onchange="showPreview(event, {{$loop->iteration}});">
                              </div>
                            </div>
                          </div>
                          @endforeach

                        </div>
                      </div>

                      <div class="col-lg-6 form-group">
                        <label class="font-weight-bold">@lang('Title')</label>
                        <input type="text" name="title" placeholder="@lang('Enter title')" class="form-control" required value="{{$ad->title}}">
                      </div>

                      <div class="col-md-6 form-group">
                        <label class="font-weight-bold">@lang('Condition')</label>
                        <select class="form-control" name="condition" required>
                            @if ($ad->subcategory->category_id == 8)
                            <option value="3" {{$ad->use_condition == 3?'selected':''}}>@lang('Full Time')</option>
                            <option value="4" {{$ad->use_condition == 4?'selected':''}}>@lang('Part Time')</option>
                            @else
                            <option value="2" {{$ad->use_condition == 2?'selected':''}}>@lang('Used')</option>
                            <option value="1" {{$ad->use_condition == 1?'selected':''}}>@lang('New')</option>
                            @endif
                        </select>
                      </div>

                      <div class="col-lg-12 form-group">
                        <label>@lang('Description')</label>
                        <textarea name="description" placeholder="Description" class="form-control nicEdit" rows="5">{{$ad->description}}</textarea>
                      </div>

                      @if($ad->subcategory->fields->count() > 0)
                         @foreach($ad->subcategory->fields as $k => $field)
                            @if ($field->type == 1 || $field->type == 4 )
                                <div class="form-group col-lg-12">
                                    <label class="font-weight-bold">@lang($field->label) <small>({{$field->required != 1 ? 'Optional':'Required'}})</small> </label>
                                    @if($field->type == 1)
                                        <input class="form-control" name="{{$field->name}}" type="text" placeholder="{{__($field->placeholder)}}" {{$field->required == 1 ? 'required':''}} value="{{!empty($adFields[$field->name])?$adFields[$field->name]:''}}">
                                    @else
                                      <textarea class="form-control" name="{{$field->name}}"  placeholder="{{__($field->placeholder)}}" {{$field->required == 1 ? 'required':''}}>{{!empty($adFields[$field->name])?$adFields[$field->name]:''}}</textarea>
                                    @endif
                                </div>

                            @elseif($field->type == 2 || $field->type == 3)
                                <div class="form-group col-lg-12">
                                    @if ($field->type == 2 )
                                    <label class="font-weight-bold">@lang($field->label) <small>({{$field->required != 1 ? 'Optional':'Required'}})</small></label>
                                    <select class="form-control" {{$field->required == 1 ? 'required':''}} name="{{$field->name}}[]">
                                        @foreach ($field->options as $opt)
                                            <option {{!empty($adFields[$field->name]) && $adFields[$field->name] == $opt?'selected':''}}>{{$opt}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                        <label class="font-weight-bold">@lang($field->label) <small>({{$field->required != 1 ? 'Optional':'Required'}})</small></label>
                                        <div class="row">
                                          @foreach ($field->options as $opt)

                                          <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                                            <div class="custom-control custom-checkbox form-check-primary">
                                              <input type="checkbox" class="custom-control-input" name="{{$field->name}}[]" id="customCheck{{$loop->iteration}}"  {{ !empty($adFields[$field->name]) && in_array($opt,$adFields[$field->name])?'checked':''}} value="{{$opt}}">
                                              <label class="custom-control-label" for="customCheck{{$loop->iteration}}">@lang($opt)</label>
                                            </div>
                                          </div>
                                          @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                      @endif


                     <div class="col-md-12 form-group">
                        <label class="font-weight-bold">@lang('Pice')</label>
                         <div class="input-group">
                          <span class="input-group-text" id="basic-addon1">{{$general->cur_sym}}</span>
                          <input type="text" class="form-control" name="price" placeholder="@lang('Enter price')" value="{{getAmount($ad->price)}}">
                          <span class="input-group-text bg-transparent" id="basic-addon1">
                            <div class="custom-control custom-checkbox form-check-primary form-check-primary d-flex align-items-center">
                              <input type="checkbox"  name="negotiable" class="custom-control-input" id="customCheck21" {{$ad->negotiable == 1?'checked':''}}>
                              <label class="custom-control-label text-dark" for="customCheck21">@lang('Negotiable')</label>
                            </div>
                          </span>
                        </div>
                      </div>


                    </div><!-- row end -->

                    <h4 class="title mt-4">@lang('Contact Details')</h4>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>@lang('Name')</label>
                        <input type="text"  value="{{$ad->user->fullname}}" class="form-control" readonly>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>@lang('Email')</label>
                        <input type="email"  value="{{$ad->user->email}}" class="form-control" readonly>
                      </div>
                      <div class="col-md-12 form-group">
                        <label>@lang('Phone Number')</label>

                        <div class="input-group">
                          <span class="input-group-text bg-transparent">
                            <div class="custom-control custom-checkbox form-check-primary d-flex align-items-center">
                              <input type="checkbox" name="hidenumber" class="custom-control-input" id="customCheck201" {{$ad->hide_contact == 1?'checked':''}}>
                              <label class="custom-control-label text-dark" for="customCheck201">@lang('Hide Number')</label>
                            </div>
                          </span>
                          <input type="tel" name="phone" placeholder="@lang('Enter phone number')" class="form-control" value="{{$ad->contact_num}}" required>
                        </div>
                      </div>
                    </div><!-- row end -->
                    <div class="text-right">
                      <button type="submit" class="btn btn--primary">@lang('Update Ad')</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')

  <a href="{{route('admin.ads')}}" class="btn btn--dark "> <i class="las la-backward"></i> @lang('Back')</a>

@endpush

@push('script')

 <script>
        'use strict';
            var number = 1;
            do {
             var showPreview =  function showPreview(event, number){
                if(event.target.files.length > 0){
                  let src = URL.createObjectURL(event.target.files[0]);
                  let preview = document.getElementById("file-ip-"+number+"-preview");
                  preview.src = src;
                  preview.style.display = "block";
                }
              }
              var myImgRemove =  function myImgRemove(number) {
                  document.getElementById("file-ip-"+number+"-preview").src = "{{getImage('assets/images/default.png')}}";
                  document.getElementById("file-ip-"+number).value = null;
                }
              number++;
            }
            while (number < 6);
 </script>

@endpush
