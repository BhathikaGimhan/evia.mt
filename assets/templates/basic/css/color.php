<?php
    header("Content-Type:text/css");
    $color = "#f0f";
    $color2 = "#000";
    function checkhexcolor($color){
        return preg_match('/^#[a-f0-9]{6}$/i', $color);
    }
    if (isset($_GET['color']) AND $_GET['color'] != '') {
        $color = "#" . $_GET['color'];
    }
    if (!$color OR !checkhexcolor($color)) {
        $color = "#f0f";
    }
    function checkhexcolor2($color2){
        return preg_match('/^#[a-f0-9]{6}$/i', $color2);
    }
    if (isset($_GET['color2']) AND $_GET['color2'] != '') {
        $color2 = "#" . $_GET['color2'];
    }
    if (!$color2 OR !checkhexcolor2($color2)) {
        $color2 = "#000";
    }
?>


    .btn--base, .hero-search-form .hero-search-form-btn, .cta-wrapper,.footer-widget .social-link-list li a,.contact-info-card__icon,.account-wrapper .right .title::after,.bg--base, .ad-details-thumb-area .ad-details-price,.user-info-list li .icon, .btn--base:hover,.feature-ad-slider .slick-arrow,.filter-open-btn{
        background-color: <?php echo $color ?> !important 
    }

    .hero__subtitle,.text--base,.list-item__footer .price, .sidebar-menu .sidebar-submenu .sidebar-menu-item a,.sidebar-menu .sidebar-dropdown > a:hover,.page-breadcrumb li:first-child::before,.faq-item.open .faq-title .title,.account-header .content .account-info-list li i,.account-menu li a:hover,.select-menu-list li > a:hover,.cat-title,.list-item.list--style .list-item__wrapper .list-item__meta li a:hover,.meta-list li a:hover{
        color: <?php echo $color ?> !important 
    }

    a:hover{
        color:<?php echo $color ?>
    }

    .faq-item.open .faq-title .right-icon::after, .faq-item.open .faq-title .right-icon::before,.custom-checkbox label::before,.pagination .page-item a, .pagination .page-item span, .pagination .page-item:hover a{
        background: <?php echo $color ?>;
    }

    .form--control{
        border: 1px solid <?php echo $color ?>;
    }
  
    .form--control:focus{
        border-color : <?php echo $color ?>;
    }

    .form--control:focus{
        box-shadow : 0 0 5px <?php echo $color.'59' ?>;
    }

    .square-list li::after{
        background-color : <?php echo $color.'73' ?> 
    }
    .account-menu li.active a{
        background-color : <?php echo $color.'26' ?>
    }

    .pagination .page-item.active .page-link{
        background: <?php echo $color.'38' ?>;
    }




    .header.menu-fixed .header__bottom,.footer__bottom::after,.item-search-wrapper .item-search-btn,.item-search-form .item-search-form-btn,.account-header,.custom--table thead,.bg--sec,.account-sidebar-open-btn{
        background-color: <?php echo $color2 ?> !important
    }
    
    .footer{
        background-color: <?php echo $color2.'F5' ?> 
    }
    .list-item-featured{
        background-color: <?php echo $color2.'38'?> !important;
    }

    .counter-item .thumb {
        background-color: <?php echo $color?>;
    }
    .how__thumb {
        border-color: <?php echo $color?>;
        color: <?php echo $color?>;
    }    

    .caption-list-two, .category-item:hover{
        background-color: <?php echo $color.'0D'?> !important;
    }

    .entry-title,.entry-title .price{
        background:<?php echo $color ?> !important;
    }