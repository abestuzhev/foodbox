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
    // var d = $("#recomendationsList");
    // if (d.size() > 0) {
    //     d.find("a").on("click", function () {
    //         var a = $(this);
    //         $("#recomendationsList-title").text(a.text()).trigger("hideDropdown");
    //         $.cookie("peopleProfile", a.data("item-id"));
    //         document.location = document.location
    //     });
    //     if ($.cookie("peopleProfile")) {
    //         $("#recomendationsList-title").text(d.find('a[data-item-id="' + $.cookie("peopleProfile") + '"]').text()).removeClass("dropdown");
    //         setTimeout(function () {
    //             $("#recomendationsList-title").addClass("dropdown")
    //         }, 10)
    //     }
    // }
    // if ($("a.reg").hasClass("active")) {
    //     var e = $(".popupWin").attr("regWidth");
    //     $(".popupWin").css({width: e + "px"});
    //     $("#regTab").show()
    // } else {
    //     $(".popupWin").css({width: "530px"});
    //     $("#loginTab").show();
    //     $("#regTab").hide()
    // }
    // $("a.login").click(function () {
    //     $(".popupWin").css({width: "530px"})
    // });
    // $("a.reg").click(function () {
    //     var a = $(".popupWin").attr("regWidth");
    //     $(".popupWin").css({width: a + "px"})
    // });
    // $("#loginForm").css({padding: "50px 100px"});

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
        // var productOfTheDayTablet = {
        //     nextButton: ".swiper-button-next--promo",
        //     prevButton: ".swiper-button-prev--promo",
        //     slideClass: "product",
        //     slidesPerView: 6,
        //     simulateTouch: false,
        //     slidesPerGroup: 4,
        //     roundLengths: true,
        //     breakpoints: {
        //         1100: {slidesPerView: 4, slidesPerGroup: 4},
        //         1024: {slidesPerView: 5, slidesPerGroup: 5},
        //         970: {slidesPerView: 4, slidesPerGroup: 4},
        //         767: {slidesPerView: 3, slidesPerGroup: 3},
        //         550: {slidesPerView: 2, slidesPerGroup: 2}
        //     }
        // };
        var productSwiper = new Swiper(".swiper-container--good-of-day", productOfTheDayDesktop);
        // var productSwiperTablet = new Swiper(".swiper-container--good-of-day--tablet", productOfTheDayTablet)
    }
    // if ($(".swiper-container--blog").length) {
    //     $(".swiper-container--blog").each(function (a, b) {
    //         var c = $(this);
    //         c.addClass("instance-" + a);
    //         c.find(".swiper-button-prev").addClass("btn-prev-" + a);
    //         c.find(".swiper-button-next").addClass("btn-next-" + a);
    //         var d = new Swiper(".instance-" + a, {
    //             nextButton: ".btn-next-" + a,
    //             prevButton: ".btn-prev-" + a,
    //             slideClass: "smallBlogCard",
    //             spaceBetween: 10,
    //             slidesPerView: 5,
    //             slidesPerGroup: 5,
    //             simulateTouch: false,
    //             breakpoints: {
    //                 1024: {slidesPerView: 4, slidesPerGroup: 4},
    //                 767: {slidesPerView: 3, slidesPerGroup: 3},
    //                 520: {slidesPerView: 1, slidesPerGroup: 1}
    //             }
    //         })
    //     })
    // }
    // if ($(".swiper-container--gallery").length) {
    //     var swiperPhotoGallery = new Swiper(".swiper-container--gallery", {
    //         nextButton: ".swiper-button-next",
    //         prevButton: ".swiper-button-prev",
    //         slidesPerView: 1,
    //         simulateTouch: false,
    //         effect: "fade",
    //         fade: {crossFade: false}
    //     });
    //     if ($(".swiper-container--gallery").find(".swiper-wrapper").children(".swiper-slide").length === 1) {
    //         $(".swiper-container--gallery").find(".swiper-controls-item").hide();
    //         swiperPhotoGallery.destroy()
    //     }
    // }
    // if ($(".js-add-product-comment").length) {
    //     $(document).on("submit", "#comment-form", function (a) {
    //         if ($(this).find("textarea").val().length != 0) {
    //             setTimeout(function () {
    //                 $("body").find(".uploaded").html("");
    //                 $("body").find("#error_comment_text").html("")
    //             }, 2e3)
    //         }
    //     })
    // }
});




