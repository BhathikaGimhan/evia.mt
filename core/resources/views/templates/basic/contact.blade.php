@extends($activeTemplate.'layouts.frontend')

@php
    $content = getContent('contact_us.content',true)->data_values;
@endphp

@section('content')
<section class="pt-100 pb-100">
    <div class="container">
      <div class="row gy-4 justify-content-center pb-50">
        <div class="col-xl-6">
          <div class="map-wrapper h-100">
            <div class="maps"></div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="contact-form-wrapper">
            <h2 class="title">@lang('Contact Us.')</h2>
            <form method="POST" action="">
                @csrf
              <div class="row">
                <div class="col-lg-6 form-group">
                  <label>@lang('Name')</label>
                  <input type="text" name="name" placeholder="@lang('Enter full name')" class="form--control" required value=""{{old('name')}}>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Email')</label>
                    <input type="email" name="email" placeholder="@lang('Enter email address')" class="form--control" required value="{{old('email')}}">
                </div>
                <div class="col-lg-12 form-group">
                  <label>@lang('Subject')</label>
                  <input type="text" name="subject" placeholder="@lang('Write your subject')" class="form--control" required value=""{{old('name')}}>
                </div>
        
                <div class="col-lg-12 form-group">
                  <label>@lang('Message')</label>
                  <textarea placeholder="@lang('Your message')" name="message" class="form--control" required></textarea>
                </div>
                <div class="col-lg-12">
                  <button type="submit" class="btn btn--base btn-md">@lang('Submit Now')</button>
                </div>
              </div>
            </form>
          </div><!-- contact-form-wrapper end -->
        </div>
      </div><!-- row end -->
      <h3 class="fw-bold mb-4">{{__($content->title)}}</h3>
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="contact-info-card">
            <div class="contact-info-card__icon">
              <i class="las la-phone-volume"></i>
            </div>
            <div class="contact-info-card__content">
              <h4 class="title">@lang('Mobile Number')</h4>
              <a href="tel:{{$content->contact_number}}">{{$content->contact_number}}</a>
            </div>
          </div><!-- contact-info-card end -->
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="contact-info-card">
            <div class="contact-info-card__icon">
              <i class="las la-envelope"></i>
            </div>
            <div class="contact-info-card__content">
              <h4 class="title">@lang('Email Address')</h4>
              <a href="mailto:{{$content->email_address}}">{{$content->email_address}}</a>
            </div>
          </div><!-- contact-info-card end -->
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="contact-info-card">
            <div class="contact-info-card__icon">
              <i class="las la-map-marked-alt"></i>
            </div>
            <div class="contact-info-card__content">
              <h4 class="title">@lang('Address')</h4>
              <a href="javascript:void(0)">{{$content->address}}</a>
            </div>
          </div><!-- contact-info-card end -->
        </div>
      </div><!-- row end -->
    </div>
  </section>
@endsection

@push('script')
  <script src="https://maps.google.com/maps/api/js?key={{$content->map_api}}"></script>
  <script>
    'use strict';
    var styleArray = [{
      "featureType": "all",
      "elementType": "geometry",
      "stylers": [{
        "color": "#202c3e"
      }]
    },
    {
      "featureType": "all",
      "elementType": "labels.text.fill",
      "stylers": [{
          "gamma": 0.01
        },
        {
          "lightness": 20
        },
        {
          "weight": "1.39"
        },
        {
          "color": "#ffffff"
        }
      ]
    },
    {
      "featureType": "all",
      "elementType": "labels.text.stroke",
      "stylers": [{
          "weight": "0.96"
        },
        {
          "saturation": "9"
        },
        {
          "visibility": "on"
        },
        {
          "color": "#000000"
        }
      ]
    },
    {
      "featureType": "all",
      "elementType": "labels.icon",
      "stylers": [{
        "visibility": "off"
      }]
    },
    {
      "featureType": "landscape",
      "elementType": "geometry",
      "stylers": [{
          "lightness": 30
        },
        {
          "saturation": "9"
        },
        {
          "color": "#29446b"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "geometry",
      "stylers": [{
        "saturation": 20
      }]
    },
    {
      "featureType": "poi.park",
      "elementType": "geometry",
      "stylers": [{
          "lightness": 20
        },
        {
          "saturation": -20
        }
      ]
    },
    {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [{
          "lightness": 10
        },
        {
          "saturation": -30
        }
      ]
    },
    {
      "featureType": "road",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#193a55"
      }]
    },
    {
      "featureType": "road",
      "elementType": "geometry.stroke",
      "stylers": [{
          "saturation": 25
        },
        {
          "lightness": 25
        },
        {
          "weight": "0.01"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "all",
      "stylers": [{
        "lightness": -20
      }]
    }
  ]

var lat = parseFloat('{{$content->latitude}}')
var long = parseFloat('{{$content->longitude}}')

  var mapOptions = {
    center: new google.maps.LatLng(lat,long),
    zoom: 10,
    styles: styleArray,
    scrollwheel: false,
    backgroundColor: '#e5ecff',
    mapTypeControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
    mapOptions);
  var myLatlng = new google.maps.LatLng(lat, long);
  var focusplace = {lat: 55.864237, lng: -4.251806};
  var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    icon: {
      url: "{{asset($activeTemplateTrue.'images/map-marker.png')}}"
    }
  })
  </script>
@endpush