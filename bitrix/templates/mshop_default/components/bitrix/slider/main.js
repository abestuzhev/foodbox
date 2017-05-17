$(function(){
    var a = $("#promosSwitcher");
    if (a.size() > 0) {
        var b = a.find(".promosList");
        var c = a.find(".swiper-container").swiper({
            pagination: $("#promosPager"),
            spaceBetween: 0,
            effect: $(window).width() >= 768 ? "fade" : "slide",
            autoplay: 5e3,
            simulateTouch: false,
            autoplayDisableOnInteraction: false,
            onInit: function (a) {
                b.find("a:eq(" + a.activeIndex + ")").addClass("active")
            },
            onSlideChangeStart: function (a) {
                b.find("a.active").removeClass("active");
                b.find("a:eq(" + a.activeIndex + ")").addClass("active")
            },
            paginationClickable: true
        });
        b.on("click", "a", function (a) {
            a.preventDefault();
            c.slideTo($(this).data("index"))
        })
    }

    if ($(".swiper-container--default").length) {
        $(".swiper-container--default").each(function (a, b) {
            var c = $(this);
            c.addClass("instance-" + a);
            c.find(".swiper-button-prev").addClass("btn-prev-" + a);
            c.find(".swiper-button-next").addClass("btn-next-" + a);
            var d = new Swiper(".instance-" + a, {
                nextButton: ".btn-next-" + a,
                prevButton: ".btn-prev-" + a,
                slideClass: "product",
                slidesPerView: 6,
                simulateTouch: false,
                slidesPerGroup: 4,
                roundLengths: true,
                breakpoints: {
                    1280: {slidesPerView: 5, slidesPerGroup: 5},
                    1100: {slidesPerView: 4, slidesPerGroup: 4},
                    1024: {slidesPerView: 5, slidesPerGroup: 5},
                    970: {slidesPerView: 4, slidesPerGroup: 4},
                    767: {slidesPerView: 3, slidesPerGroup: 3},
                    550: {slidesPerView: 2, slidesPerGroup: 2}
                }
            })
        })
    }
    if ($(".swiper-container--low").length) {
        $(".swiper-container--low").each(function (a, b) {
            var c = $(this);
            c.addClass("instance-" + a);
            c.find(".swiper-button-prev").addClass("btn-prev-" + a);
            c.find(".swiper-button-next").addClass("btn-next-" + a);
            var d = new Swiper(".instance-" + a, {
                nextButton: ".btn-next-" + a,
                prevButton: ".btn-prev-" + a,
                slideClass: "product",
                slidesPerGroup: 3,
                slidesPerView: 3,
                roundLengths: true,
                simulateTouch: false,
                breakpoints: {
                    1225: {slidesPerView: 2},
                    1159: {slidesPerView: 4},
                    767: {slidesPerView: 3, slidesPerGroup: 3},
                    550: {slidesPerView: 2, slidesPerGroup: 2}
                }
            })
        })
    }
    if ($(".swiper-container--good-of-day").length) {
        var productOfTheDayDesktop = {
            nextButton: ".swiper-button-next--new-product",
            slideClass: "product",
            slidesPerView: 1,
            loop: true,
            simulateTouch: false,
            observer: true,

            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',

            roundLengths: true,
            observeParents: true,
            watchSlidesVisibility: true,
            loopAdditionalSlides: 0,
            loopedSlides: 0,
            breakpoints: {
                1125: {slidesPerView: 4, slidesPerGroup: 1},
                1024: {slidesPerView: 5, slidesPerGroup: 1},
                970: {slidesPerView: 4, slidesPerGroup: 1},
                767: {slidesPerView: 3, slidesPerGroup: 1},
                550: {slidesPerView: 2, slidesPerGroup: 1}
            }
        };
        var productSwiper = new Swiper(".swiper-container--good-of-day", productOfTheDayDesktop);
    }
});
