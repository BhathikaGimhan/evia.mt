@php
	$captcha = getCustomCaptcha(46,'100');
@endphp
@if($captcha)
    <div class="form-group row ">
        <div class="col-md-12">
            @php echo $captcha @endphp
        </div>
        <div class="col-md-12 mt-4">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form--control" required>
        </div>
    </div>
@endif
