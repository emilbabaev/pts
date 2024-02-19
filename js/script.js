// width scroll
function widthScroll(){
    var div = document.createElement('div');
    div.style.overflowY = 'scroll';
    div.style.width = '50px';
    div.style.height = '50px';
    div.style.visibility = 'hidden';
    document.body.appendChild(div);
    var scrollWidth = div.offsetWidth - div.clientWidth;
    document.body.removeChild(div);
    return scrollWidth;
}

$(document).ready(function () {
    //Настройка Owl Carousel
    $(".slider-main").owlCarousel({
        loop: true,
        nav: false,
        animateOut: 'fadeOut',
        items: 1,
        autoplay: true,
        autoplayTimeout: 5000
    });

    $(".additionally-slider").owlCarousel({
        loop: true,
        nav: false,
        items: 1,
        margin: -1,
        responsive: {
            500: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    //Настройка Slick Slider
    $('.slider-news').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        draggable: false,
        dots: false,
        arrows: true,
        prevArrow: '.arrow-slick-prev',
        nextArrow: '.arrow-slick-next',
        focusOnSelect: false,
        vertical: true,
        verticalSwiping: true,
        infinite: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3
                }
            }
        ]
    });

    //настройка нестандартного скролинга
    jQuery('.wrapper').scrollbar({
        disableBodyScroll: true
    });

    //скрипт для input file в модальном окне
    $(".file-upload input[type=file]").change(function () {
        var filename = $(this).val().replace(/.*\\/, "");
        $("#filename").val(filename);
    });

    $(".file-upload2 input[type=file]").change(function () {
        var filename = $(this).val().replace(/.*\\/, "");
        $("#filename2").val(filename);
    });

    //настройка маски телефона
    $(".phone-mask").mask("+7 (999) 999-99-99");

    //настройка фиксации меню новостей
    var headerHeight = $('header').height(),
        footerHeight = $('footer').height();
    if ($(window).width() > 974) {
        (function ($) {
            $.lockfixed("#sidebar", {offset: {top: headerHeight - 92, bottom: footerHeight + 80}});
        })(jQuery);
    }

    //настройка подсказки
    $(function () {
        $('[data-toggle="tooltip-1"]').tooltip({
            placement: 'right'
        })
    });
    $(function () {
        $('[data-toggle="tooltip-2"]').tooltip({
            placement: 'auto right',
            viewport: '.tooltip-2'
        })
    });

    //Скрипт для открытия меню bootstrap при наведении
    if ($(window).width() > 768) {
        $('ul.nav > li.dropdown').hover(function () {
            $(this).addClass("open");
        }, function () {
            $(this).removeClass("open");
        });
    }
});

//скрипт для фиксации меню
$(document).on("scroll", function () {
    var headerHeight = $('header').height();
    if ($(document).scrollTop() > headerHeight) {
        $(".basket-fixed").addClass("basket-fixed-on");
        $(".footer-bottom").addClass("footer-bottom-padding");
    }
    else {
        $(".basket-fixed").removeClass("basket-fixed-on");
        $(".footer-bottom").removeClass("footer-bottom-padding");
    }
});

$("#formGalleryAdd").submit(function () {
    event.preventDefault();
    var data = new FormData($('#formGalleryAdd')[0]);
    $.ajax({
        type: "POST",
        url: "/core/gallery_add.php",
        data: data,
        contentType: false,
        processData: false,
        beforeSend: function () {
        }
    }).done(function (response) {
        $("#myModalGalleryAdd h3").html(response);
        $("#formGalleryAdd").trigger("reset");
        $("#formGalleryAdd .file-name").empty();
    });
    return false;
});


//добавление класса active для новостей в слайдере
$(function () {
    $(".slider-news .block-news").click(function () {
        $(".slider-news .block-news").removeClass("active");
        $(this).toggleClass("active");
    })
});

//закрытие фильтра на мобильном
if ($(window).width() < 768) {
    $(".js-collapsed").addClass("collapsed");
    $(".js-in").removeClass("in");
}

//скролл до новостей
$(".slider-news a").on("click", function () {
    var top = $('#news_detail').offset().top;
    $('body,html').animate({scrollTop: top}, 800);
});

//menu fixed
if ($(window).width() < 768 - (widthScroll())) {
    $(document).on("scroll", function () {
        var headerHeight = $('.js-header').height();
        if ($(document).scrollTop() > headerHeight + 50) {
            $(".js-navbar-default").addClass('navbar-fixed-top');
            $(".js-header-top").addClass('margin-header-top');
        }
        else {
            $(".js-navbar-default").removeClass('navbar-fixed-top');
            $(".js-header-top").removeClass('margin-header-top');
        }
    });
}