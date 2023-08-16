@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pt-100 pb-100">
    <div class="container">
      <div class="row gy-4 justify-content-center pb-50">
        <div class="col-xl-12">
          <div class="contact-form-wrapper">
                @php
                    echo $policy->data_values->details;
                @endphp
          </div>
        </div>
      </div>
    </div>
  </section>
@stop