'use strict';

// menu options custom affix
var fixed_top = $(".header");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 50){  
        fixed_top.addClass("animated fadeInDown menu-fixed");
    }
    else{
        fixed_top.removeClass("animated fadeInDown menu-fixed");
    }
});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

const widgetBtn = $('.sidebar-widget .title-btn');
const widgetBody = $('.sidebar-widget__body');

widgetBtn.each(function(){
  $(this).on('click', function(){
    $(this).parent().siblings(widgetBody).slideToggle();
  });
});

const selectMenuItem = $('.select-menu-list > li');
selectMenuItem.each(function(){
  $(this).on('click', function(){
    var el = $(this);
    if (el.hasClass('active')) {
      el.toggleClass('active').siblings().show();
    }else{
      el.toggleClass('active').siblings().hide();
    }
  });
});

$(".counter-item").each(function () {
  $(this).isInViewport(function (status) {
    if (status === "entered") {
      for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
        var el = document.querySelectorAll('.odometer')[i];
        el.innerHTML = el.getAttribute("data-odometer-final");
      }
    }
  });
});

// wow js init
new WOW().init();

// lightcase plugin init
$('a[data-rel^=lightcase]').lightcase();

// main wrapper calculator
var bodySelector = document.querySelector('body');
var header = document.querySelector('.header');
var footer = document.querySelector('.footer');
(function(){
  if(bodySelector.contains(header) && bodySelector.contains(footer)){
    var headerHeight = document.querySelector('.header').clientHeight;
    var footerHeight = document.querySelector('.footer').clientHeight;

    // if header isn't fixed to top
    // var totalHeight = parseInt( headerHeight, 10 ) + parseInt( footerHeight, 10 ) + 'px'; 
    
    // if header is fixed to top
    var totalHeight = parseInt( footerHeight, 10 ) + 'px'; 
    var minHeight = '100vh';
    document.querySelector('.main-wrapper').style.minHeight = `calc(${minHeight} - ${totalHeight})`;
  }
})();

// Animate the scroll to top
$(".scroll-top").on("click", function(event) {
	event.preventDefault();
	$("html, body").animate({scrollTop: 0}, 300);
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip({
    boundary: 'window'
  })
});

// custom input animation js
$('.custom--form-group .form--control').on('input', function(){
  let passfield = $(this).val();
  if (passfield.length < 1){
      $(this).removeClass('hascontent');
  }else{
      $(this).addClass('hascontent');
  }
});

const showBtn = $('.ad-details-show-btn');
const adContent = $('.ad-details-content');
showBtn.on('click', function(){
  $(this).toggleClass('active');
  adContent.toggleClass('active');
});

const sidebarOpenBtn = $('.filter-open-btn');
const sidebarCloseBtn = $('.sidebar-close-btn');
const filterSidebar = $('.filter-sidebar');
sidebarOpenBtn.on('click', function(){
  filterSidebar.addClass('active');
});
sidebarCloseBtn.on('click', function(){
  filterSidebar.removeClass('active');
});


const acountSidebarOpenBtn = $('.account-sidebar-open-btn');
const acountSidebarCloseBtn = $('.account-sidebar-close-btn');
const accountMenuWrapper = $('.account-menu-wrapper');

acountSidebarOpenBtn.on('click', function(){
  accountMenuWrapper.addClass('active');
});
acountSidebarCloseBtn.on('click', function(){
  accountMenuWrapper.removeClass('active');
});


$('.select2-basic').select2();


/* ==============================
					slider area
================================= */

// feature-ad-slider
$('.feature-ad-slider').slick({
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 4,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
      }
    }
  ]
});

// related-ad-slider js
$('.related-ad-slider').slick({
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  arrows: true,
  centerMode: false,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
      }
    }
  ]
});

// ad details slider 
$('.main-thumb-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  infinite: true,
  asNavFor: '.ad-details-nav-slider'
});
$('.ad-details-nav-slider').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.main-thumb-slider',
  dots: false,
  infinite: true,
  centerMode: true,
  centerPadding: '0px',
  focusOnSelect: true,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 360,
      settings: {
        slidesToShow: 2,
      }
    }
  ]
});