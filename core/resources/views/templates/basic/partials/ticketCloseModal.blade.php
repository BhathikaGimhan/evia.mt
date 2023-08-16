@if (Route::currentRouteName()=='ticket.view')
<div class="modal fade" id="DelModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                @csrf
                <div class="modal-header bg--sec">
                    <h5 class="modal-title text-white"> @lang('Confirmation')!</h5>
                    <button type="button" class="btn-close close-button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <strong class="text-dark">@lang('Are you sure you want to Close This Support Ticket')?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i>
                        @lang('Close')
                    </button>
                    <button type="submit" class="btn btn--success btn-sm" name="replayTicket" value="2"><i class="fa fa-check"></i> @lang("Confirm")
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif