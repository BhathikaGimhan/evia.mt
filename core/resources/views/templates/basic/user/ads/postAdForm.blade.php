@extends($activeTemplate.'layouts.master')
@section('content')
<div class="create-ad-wrapper">
    <form action="{{route('user.store.ad')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name="subcategory_id" value="{{$subcategory->id}}">
      <input type="hidden" name="district_id" value="{{$district->id}}">
      <input type="hidden" name="type" value="{{$type == 'sell'? 1 : 2}}">
     <div class="d-flex justify-content-between title">
       <h4 class="">@lang('Ad Information')</h4>
        <div class="">
          <small class="font-weight-bold h6"> <i class="las la-tag text--base"></i> {{$subcategory->name}}</small>
          <small class="font-weight-bold h6"> <i class="las la-map-marker text--base"></i> {{$district->name}}</small>
        </div>
     </div>
      <div class="row">

      <label class="mb-3 font-weight-bold">@lang('you need to upload at least 03 images')</label>
       <div class="product-image-upload-container mb-2 d-flex justify-content-center">
         <div class="single-upload">
           <div class="center" >
             <div class="form-input">
               <label for="file-ip-1" data-toggle="tooltip" title="@lang('Preview image')">
                 <img id="file-ip-1-preview" src="{{getImage('assets/images/default.png')}}">

                 <button type="button" class="imgRemove" onclick="myImgRemove(1)"></button>
               </label>
               <input type="file"  name="prev_image" id="file-ip-1" accept="image/*" onchange="showPreview(event, 1);">
               <code style="font-size: 9px;"> thumbnail image</code>
             </div>
           </div>
         </div><!-- single-upload end -->
         <div class="single-upload" >
           <div class="center">
             <div class="form-input">
               <label for="file-ip-2" >
                 <img id="file-ip-2-preview" src="{{getImage('assets/images/default.png')}}">
                 <button type="button" class="imgRemove" onclick="myImgRemove(2)"></button>
               </label>
               <input type="file"  name="image[]" id="file-ip-2" accept="image/*" onchange="showPreview(event, 2);">
             </div>
           </div>
         </div><!-- single-upload end -->
         <div class="single-upload">
           <div class="form-input">
             <label for="file-ip-3">
               <img id="file-ip-3-preview" src="{{getImage('assets/images/default.png')}}">
               <button type="button" class="imgRemove" onclick="myImgRemove(3)"></button>
             </label>
             <input type="file" name="image[]" id="file-ip-3" accept="image/*" onchange="showPreview(event, 3);">
           </div>
         </div><!-- single-upload end -->
         <div class="single-upload">
           <div class="form-input">
             <label for="file-ip-4">
               <img id="file-ip-4-preview" src="{{getImage('assets/images/default.png')}}">
               <button type="button" class="imgRemove" onclick="myImgRemove(4)"></button>
             </label>
             <input type="file" name="image[]" id="file-ip-4" accept="image/*" onchange="showPreview(event, 4);">
           </div>
         </div><!-- single-upload end -->
         <div class="single-upload">
           <div class="form-input">
             <label for="file-ip-5">
               <img id="file-ip-5-preview" src="{{getImage('assets/images/default.png')}}">
               <button type="button" class="imgRemove" onclick="myImgRemove(5)"></button>
             </label>
             <input type="file" name="image[]" id="file-ip-5" accept="image/*" onchange="showPreview(event, 5);">
           </div>
         </div><!-- single-upload end -->
         <div class="single-upload">
           <div class="form-input">
             <label for="file-ip-6">
               <img id="file-ip-6-preview" src="{{getImage('assets/images/default.png')}}">
               <button type="button" class="imgRemove" onclick="myImgRemove(6)"></button>
             </label>
             <input type="file" name="image[]" id="file-ip-6" accept="image/*" onchange="showPreview(event, 6);">
           </div>
         </div><!-- single-upload end -->
       </div>

        <div class="col-lg-12 form-group">
          <label>@lang('Title')</label>
          <input type="text" name="title" placeholder="@lang('Enter title')" class="form--control" required value="{{old('title')}}">
        </div>

        <div class="col-md-12 form-group">
          <label>@lang('Condition')</label>
          <select class="form--control" name="condition" required>
            @if ($subcategory->category_id == 8)
            <option value="3">@lang('Full Time')</option>
            <option value="4">@lang('Part Time')</option>
            @else
            <option value="2">@lang('Used')</option>
            <option value="1">@lang('New')</option>
            @endif
          </select>
        </div>

        <div class="col-lg-12 form-group">
          <label>@lang('Description')</label>
          <textarea name="description" placeholder="Description" class="form--control nicEdit">{{old('description')}}</textarea>
        </div>

        @if ($subcategory->fields->count() > 0)
        <input type="hidden" name="">
           @foreach($subcategory->fields as $k => $field)
              @if ($field->type == 1 || $field->type == 4 )
                  <div class="form-group col-lg-12">
                      <label class="font-weight-bold">@lang($field->label) <small>({{$field->required != 1 ? 'Optional':'Required'}})</small> </label>
                      @if($field->type == 1)
                          <input class="form--control" name="{{$field->name}}" type="text" placeholder="{{__($field->placeholder)}}" {{$field->required == 1 ? 'required':''}} value="">
                      @else
                        <textarea class="form--control" name="{{$field->name}}"  placeholder="{{__($field->placeholder)}}" {{$field->required == 1 ? 'required':''}}>{{old('extraField')}}</textarea>
                      @endif
                  </div>

              @elseif($field->type == 2 || $field->type == 3)
                  <div class="form-group col-lg-12">
                      @if ($field->type == 2 )
                      <label class="font-weight-bold">@lang($field->label) <small>({{$field->required != 1 ? 'Optional':'Required'}})</small></label>
                      <select class="form--control" {{$field->required == 1 ? 'required':''}} name="{{$field->name}}[]">
                          @foreach ($field->options as $opt)
                              <option>{{$opt}}</option>
                          @endforeach
                      </select>
                      @else
                          <label class="font-weight-bold">@lang($field->label) <small>({{$field->required != 1 ? 'Optional':'At least 1 field required'}})</small></label>
                          <div class="row">
                            @foreach ($field->options as $opt)
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="{{$field->name}}[]" value="{{$opt}}" id="customCheck{{$loop->iteration}}">
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
          <label>@lang('Pice')</label>
           <div class="input-group">
            <span class="input-group-text" id="basic-addon1">{{$general->cur_sym}}</span>
            <input type="text" class="form--control" name="price" placeholder="@lang('Enter price')">
            <span class="input-group-text" id="basic-addon1">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="negotiable" id="customCheck31" >
                <label class="custom-control-label" for="customCheck31">@lang('Negotiable')</label>
              </div>
            </span>
          </div>
        </div>

        <div class="col-md-12 form-group">
            <label>@lang('Item Ownership')</label>
            <select class="form--control" name="Ownership" required>
              <option value="Owner">@lang('Owner')</option>
              <option value="Broker">@lang('Broker')</option>
            </select>
          </div>

      </div><!-- row end -->

      <h4 class="title mt-4">@lang('Contact Details')</h4>
      <div class="row">
        <div class="col-md-6 form-group">
          <label>@lang('Name')</label>
          <input type="text"  value="{{auth()->user()->fullname}}" class="form--control" readonly>
        </div>
        <div class="col-md-6 form-group">
          <label>@lang('Email')</label>
          <input type="email"  value="{{auth()->user()->email}}" class="form--control" readonly>
        </div>
        <div class="col-md-12 form-group">
          <label>@lang('Phone Number')</label>
          <div class="input-group">
            <span class="input-group-text">
              <div class="custom-control custom-checkbox form-check-primary d-flex align-items-center">
                <input type="checkbox" class="custom-control-input" name="hidenumber" id="customCheck32" >
                <label class="custom-control-label" for="customCheck32">@lang('Hide Number')</label>
              </div>
            </span>
            <input type="tel" name="phone" placeholder="@lang('Enter phone number')" class="form--control" value="{{auth()->user()->mobile}}" required>
          </div>
        </div>
      </div><!-- row end -->
      <div class="mt-3">
        <button type="submit" class="btn btn--base btn-md w-100">@lang('Post Your Ad')</button>
      </div>
    </form>
  </div>
@endsection



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
