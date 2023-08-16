@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pt-100 pb-100">
    <div class="container">
      <div class="row gy-4 justify-content-center pb-50">
        <div class="col-xl-12">
          <div class="p-3 p-sm-4 p-md-5 rounded section-bg">
                <div class="faq-wrapper style-two">
                    @foreach ($faqs as $faq)
                        
                    <div class="faq-item">
                        <div class="faq-title">
                            <h6 class="title">{{__($faq->data_values->question)}}</h6>
                            <div class="right-icon"></div>
                        </div>
                        <div class="faq-content">
                            <p>
                               @php
                                   echo $faq->data_values->answer;
                               @endphp
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop

@push('style')

<style>
    .faq-content{
        display: none;
    }
</style>

@endpush