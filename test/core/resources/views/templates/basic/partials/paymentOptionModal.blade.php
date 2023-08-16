@if (Route::currentRouteName() == 'user.promote.ad.packages')
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="d-flex justify-content-end"><button type="button" class="btn-close text-right m-3" data-bs-dismiss="modal" aria-label="Close"></div>
  
       </button>
        <div class="modal-body text-center">
         
                <h1><i class="fas fa-hand-holding-usd text--base mb-15"></i></h1>
                <h3 class="text--secondary mb-3">@lang('Please choose your payment option!')</h3>
                <small> <b class="text--success packagePrice"></b> @lang('will be deducted, if you choose from refunded balance')</small>
            </div>
        <div class="modal-footer justify-content-center">
          <a href=""  class="btn btn-sm btn--warning promotionBalance">@lang('From Refunded Balance')</a>
          <a href=""  class="btn btn-sm btn--primary  gateway">@lang('From Gateway')</a>
        </div>
      
      </div>
    </div>
</div>
@endif
