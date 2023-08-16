@php
     $elements= getContent('counter.element',false,'',1);
@endphp

<section class="pt-50 pb-50">
    <div class="container">
        <div class="counter-wrapper">
            @foreach ($elements as $item)
                <div class="counter-item">
                    <div class="thumb">
                        <span class="odometer" data-odometer-final="{{@intval($item->data_values->digit)}}">0</span>
                        <span>{{@ucwords(@preg_replace("/[^a-zA-Z]+/", "", $item->data_values->digit))}}</span>
                    </div>
                    <div class="counter-content">
                        <h5 class="title">@lang($item->data_values->title)</h5>
                    </div>
                </div>
            @endforeach
          

    </div>
</section>