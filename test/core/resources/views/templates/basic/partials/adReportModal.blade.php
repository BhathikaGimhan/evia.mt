@if (Route::currentRouteName() == 'ad.details')
<div class="modal fade" id="adReportModal" tabindex="-1" aria-labelledby="adReportModal" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('user.report.ad')}}" method="POST">
            @csrf
            <input type="hidden" name="ad_id" value="{{$ad->id}}">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel">@lang('Tell Us The Reasons')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Reasons')</label>
                        <textarea class="form--control" name="reasons" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                <button type="submit" class="btn btn-sm btn--primary">@lang('Submit')</button>
                </div>
            </div>
        </form>
    </div>
  </div>
@endif


