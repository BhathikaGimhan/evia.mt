@if (Route::currentRouteName() == 'user.twofactor')
    
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header bg--sec">
                    <h4 class="modal-title text-white">@lang('Verify Your Otp')</h4>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary btn-sm">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <!--Disable Modal -->
  <div id="disableModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg--sec">
                <h4 class="modal-title text-white">@lang('Verify Your Otp Disable')</h4>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('user.twofactor.disable')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary btn-sm">@lang('Verify')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
