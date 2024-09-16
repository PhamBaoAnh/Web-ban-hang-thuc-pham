/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function(){
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            },
            1170: {
                items: 4
            },
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val(ui.values[0] + 'đ');
            maxamount.val(ui.values[1] + 'đ');
        }
    });
    minamount.val(rangeSlider.slider("values", 0) + 'đ');
    maxamount.val(rangeSlider.slider("values", 1) + 'đ');

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    if(proQty.hasClass('shop')){
        proQty.on('click', '.qtybtn', function () {
            var $button = $(this);
            var oldValue = $button.parent().find('input').val();
            if ($button.hasClass('inc')) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 1) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 1;
                }
            }
            $button.parent().find('input').val(newVal);
        });
    }
    else{
        proQty.on('click', '.qtybtn', function () {
            var $button = $(this);
            var product_id = $button.parent().find('input[id="product_id"]').val();
            var oldValue = $button.parent().find('input[name="quantity"]').val();
            if ($button.hasClass('inc')) {
                var newVal = parseFloat(oldValue) + 1;
                window.location.href = '/cart/increase/' + product_id;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 0;
                }
                window.location.href = '/cart/decrease/' + product_id;
            }
            $button.parent().find('input').val(newVal);
        });
    }

})(jQuery);


function kiemtrasoluong(event, input) {
    var allowedKeys = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'Backspace', 'ArrowLeft', 'ArrowRight', 'Delete', 'Tab'];

    if (!allowedKeys.includes(event.key)) {
        event.preventDefault();
    }

    var min = parseFloat(input.getAttribute('data-min_value'));
    var max = parseFloat(input.getAttribute('data-max_value'));
    var value = parseFloat(input.value);

    if (isNaN(value)) {
        input.value = min; // Set default value if non-numeric input is detected
    } else if (value < min) {
        input.value = min;
    } else if (value > max) {
        input.value = max;
    }
}

    // Function to increase quantity
    function tangsoluong(btn) {
        var input = btn.previousElementSibling;
        var value = parseFloat(input.value);
        var step = parseFloat(input.getAttribute('data-step'));
        var max = parseFloat(input.getAttribute('data-max_value'));
        var product_id = input.getAttribute('data-product_id'); // Retrieve product ID
        if (value + step <= max) {
            input.value = value ;
        }

        window.location.href = '/cart/increase/' + product_id;
    } 

    function giamsoluong(btn) {
        var input = btn.previousElementSibling.previousElementSibling;
        var value = parseFloat(input.value);
        var step = parseFloat(input.getAttribute('data-step'));
        var min = parseFloat(input.getAttribute('data-min_value'));
        var product_id = input.getAttribute('data-product_id'); // Retrieve product ID
        
        if (value - step >= min) {
            input.value = value ;
        }
     // Alert after updating the value
        
        // Redirect after alert
        setTimeout(function() {
            window.location.href = '/cart/decrease/' + product_id;
        }, 100);
    }








function previewImg(fileInput, showImg){
    if(fileInput.files && fileInput.files[0]){
        const reader = new FileReader();
        
        reader.onload = (e) =>{ 
            document.getElementById(showImg).setAttribute('src', e.target.result)
        }
        reader.readAsDataURL(fileInput.files[0]);
    }
}