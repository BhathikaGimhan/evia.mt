@if (Route::currentRouteName()=='user.deposit')
<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('user.deposit.insert')}}" method="post">
        <div class="modal-content">
            <div class="modal-header bg--sec">
                <strong class="modal-title method-name" id="exampleModalLabel"></strong>
                <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
           
                @csrf
                <div class="modal-body">
                    <p class="text-danger depositLimit"></p>
                    <p class="text-danger depositCharge"></p>
                    <div class="form-group">
                        <input type="hidden" name="currency" class="edit-currency" value="">
                        <input type="hidden" name="method_code" class="edit-method-code" value="">
                    </div>
                    <div class="form-group">
                        <label>@lang('Your Amount'):</label>
                        <div class="input-group">
                            <input id="amount" type="text" class="form--control" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{$pkg?getAmount($pkg->price):old('amount')}}" {{$pkg?'readonly':''}}>

                            <span class="input-group-text currency-addon addon-bg">{{__($general->cur_text)}}</span>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-sm btn--primary">@lang('Confirm')</button>
                   
                </div>
            </form>
        </div>
    </div>
</div>
@endif