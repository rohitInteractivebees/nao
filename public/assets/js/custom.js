$(document).ready(function () {
    $('.faq-sec li:first').addClass('active')
    $('.faq-sec li:first').children('.body').slideDown();
    $('.faq-sec li').click(function () {
        if ($(this).hasClass("active")) {
            $(this).removeClass('active')
            $(this).children('.body').slideUp();
        }
        else {
            $('.faq-sec li').removeClass('active')
            $('.faq-sec li .body').slideUp();
            $(this).toggleClass('active');
            $(this).children('.body').slideDown();
        }
    })
    /*$('.toggle-buttons .quiz-btn').click(function(){
        $(this).toggleClass("active")
    })*/

    $('.result-list-page .result-question-answer ul li.outer').each(function () {
        if ($(this).find('.not-attend').length) {
            $(this).addClass("unattempt");
        }
    });
    // Show the first tab and hide the rest
    $('.rewads-sec .prize-sec li:first-child').addClass('active');
    $('.prizes-overview .item').hide();
    $('.prizes-overview .item:first').show();

    // Click function
    $('.rewads-sec .prize-sec li').click(function () {
        $('.rewads-sec .prize-sec li').removeClass('active');
        $(this).addClass('active');
        $('.prizes-overview .item').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });

    //Menu Responsive
    $('.menu-toggle').click(function () {
        $('.menu-sec').addClass("active")
    })
    $('.close-btn').click(function () {
        $('.menu-sec').removeClass("active")
    })

    $('.menu-sec ul li.submenu').click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            $(this).children('.dropdown').slideUp()
        }
        else {
            $('.menu-sec ul li.submenu').removeClass('active')
            $('.dropdown').slideUp()
            $(this).toggleClass('active')
            $(this).children('.dropdown').slideToggle()
        }
    })

    Fancybox.bind('[data-fancybox]', {
        Html: {
            youtube: {
                controls: 0,
                rel: 0,
                fs: 0
            }
        }
    });
    $('.status-btn').click(function () {
        if ($(this).hasClass("red")) {
            $(this).removeClass("red")
            alert("Active")
        }
        else {
            $(this).toggleClass("red")
            alert("Non Active")
        }


    })
    $('#close,#close-btn').click(function () {
        $('.verify-sec').removeClass("show")
    })
    $('.validat-sec input#title').on('keyup', function () {
        var maxlen = $(this).attr('maxlength');

        var length = $(this).val().length;
        if (length > (maxlen - 10)) {
            $('#titleError').text('max length ' + maxlen + ' characters only!')
        }
        else {
            $('#titleError').text('');
        }
    });
    $('.validat-sec textarea#description').on('keyup', function () {
        var maxlen = $(this).attr('maxlength');

        var length = $(this).val().length;
        if (length > (maxlen - 10)) {
            $('#descriptionError').text('max length ' + maxlen + ' characters only!')
        }
        else {
            $('#descriptionError').text('');
        }
    });
})
$(function () {
    // Owl Carousel
    var owl = $(".announcements-slider");
    owl.owlCarousel({
        items: 2,
        margin: 50,
        loop: false,
        dots: false,
        nav: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                margin: 0,
            },
            600: {
                items: 1,
                margin: 0,
            },
            1000: {
                items: 2,
            }
        }
    });
});
$(window).scroll(function () {
    var sc = $(window).scrollTop()
    if (sc >= 1) {
        $("header.header").addClass("small")
    } else {
        $("header.header").removeClass("small")

    }
});

