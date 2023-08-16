<div class="modal fade" id="imageRemoveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="post">
        <div class="modal-content">
            <div class="modal-header bg--sec">
                <strong class="modal-title method-name">@lang('Remove Image')</strong>
                <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
           
                @csrf
                <div class="modal-body">
                    <h5 class="text-danger text-center">@lang('Are you sure to delete image ?')</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-sm btn--primary">@lang('Confirm')</button>
                   
                </div>
            </form>
        </div>
    </div>
</div>