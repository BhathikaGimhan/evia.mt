@if (Route::currentRouteName() == 'user.ad.list' || Route::currentRouteName() == 'user.home')
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="d-flex justify-content-end">
      <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close">
    </div>
     
     </button>
          <form action="" method="POST">
              @csrf
              <div class="modal-body text-center">
                  
                  <i class="las la-exclamation-circle text-danger display-2 mb-15"></i>
                  <h4 class="text--secondary mb-15">@lang('Are You Sure Want to Delete This?')</h4>

              </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
            <button type="submit"  class="btn btn-sm btn--danger del">@lang('Delete')</button>
          </div>
          
          </form>
    </div>
  </div>
</div



@push('script')

 <script>
        'use strict';
         (function ($) {
          $('.delete').on('click',function(){
            var route = $(this).data('route')
            var modal = $('#deleteModal');
            modal.find('form').attr('action',route)
            modal.modal('show');


          })
        })(jQuery);
 </script>

@endpush

@endif