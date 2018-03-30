;(function () {

    'use strict';



    var sliderMain;

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    var fullHeight = function() {

        if ( !isMobile.any() ) {
            $('.js-fullheight').css('height', $(window).height());
            $(window).resize(function(){
                $('.js-fullheight').css('height', $(window).height());
            });
        }

    };
    var halfHeight = function() {

        if ( !isMobile.any() ) {
            $('.js-halfHeight').css('height', $(window).height()/1.5);
            $(window).resize(function(){
                $('.js-halfHeight').css('height', $(window).height()/1.5);
            });
            $('.js-Minheight-halfHeight').css('min-height', $(window).height()/1.5);
            $(window).resize(function(){
                $('.js-Minheight-halfHeight').css('min-height', $(window).height()/1.5);
            });
        }

    };

    sliderMain = function () {
        $("nav.nav-circleslide a.next").click(function (e) {
            e.preventDefault();
            $('a.flex-next')[0].click();
        });
        $("nav.nav-circleslide a.prev").click(function (e) {
            e.preventDefault();
            $('a.flex-prev')[0].click();
        });


        $('#fh5co-hero .flexslider').flexslider({
            animation: "scroll",
            slideshowSpeed: 10000,
            directionNav: true,
            start: function () {
                setTimeout(function () {
                    $('.slider-text').removeClass('animated fadeInRight');
                    $('.flex-active-slide').find('.slider-text').addClass('animated fadeInRight');
                }, 500);


            },
            before: function () {
                setTimeout(function () {
                    $('.slider-text').removeClass('animated fadeInRight');
                    $('.flex-active-slide').find('.slider-text').addClass('animated fadeInRight');
                }, 500);
            },
            after: function () {
            }

        });

        //$('#fh5co-hero .flexslider .slides > li').css('height', $(window).height()/1.2);
        //$('#fh5co-hero .flexslider.maximized .slides > li').css('height', $(window).height());
        $(window).resize(function () {
            //$('#fh5co-hero .flexslider .slides > li').css('height', $(window).height()/1.2);
            //$('#fh5co-hero .flexslider.maximized .slides > li').css('height', $(window).height());
        });

    };

    var centerBlock = function() {
        $('.fh5co-section-with-image .fh5co-box').css('margin-top', -($('.fh5co-section-with-image .fh5co-box').outerHeight()/1.2));
        $(window).resize(function(){
            $('.fh5co-section-with-image .fh5co-box').css('margin-top', -($('.fh5co-section-with-image .fh5co-box').outerHeight()/1.2));
        });
    };

    var responseHeight = function() {
        setTimeout(function(){
            $('.js-responsive > .v-align').css('height', $('.js-responsive > img').height());
        }, 1);

        $(window).resize(function(){
            setTimeout(function(){
                $('.js-responsive > .v-align').css('height', $('.js-responsive > img').height());
            }, 1);
        })
    };


    var mobileMenuOutsideClick = function() {

        $(document).click(function (e) {
            var container = $("#fh5co-offcanvas, .js-fh5co-nav-toggle");
            if (!container.is(e.target) && container.has(e.target).length === 0) {

                if ( $('body').hasClass('offcanvas-visible') ) {

                    $('body').removeClass('offcanvas-visible');
                    $('.js-fh5co-nav-toggle').removeClass('active');

                }


            }
        });

    };


    var offcanvasMenu = function() {
        $('body').prepend('<div id="fh5co-offcanvas" />');
        $('#fh5co-offcanvas').prepend('<ul id="fh5co-side-links">');
        $('body').prepend('<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>');
        $('#fh5co-offcanvas').append($('#fh5co-header nav').clone());
    };


    var burgerMenu = function() {

        $('body').on('click', '.js-fh5co-nav-toggle', function(event){
            var $this = $(this);

            $('body').toggleClass('fh5co-overflow offcanvas-visible');
            $this.toggleClass('active');
            event.preventDefault();

        });

        $(window).resize(function() {
            if ( $('body').hasClass('offcanvas-visible') ) {
                $('body').removeClass('offcanvas-visible');
                $('.js-fh5co-nav-toggle').removeClass('active');
            }
        });

        $(window).scroll(function(){
            if ( $('body').hasClass('offcanvas-visible') ) {
                $('body').removeClass('offcanvas-visible');
                $('.js-fh5co-nav-toggle').removeClass('active');
            }
        });

    };


    var toggleBtnColor = function() {
        if ( $('#fh5co-hero').length > 0 ) {
            $('#fh5co-hero').waypoint( function( direction ) {
                if( direction === 'down' ) {
                    $('.fh5co-nav-toggle').addClass('dark');
                }
            } , { offset: - $('#fh5co-hero').height() } );

            $('#fh5co-hero').waypoint( function( direction ) {
                if( direction === 'up' ) {
                    $('.fh5co-nav-toggle').removeClass('dark');
                }
            } , {
                offset:  function() { return -$(this.element).height() + 0; }
            } );
        }
    };

    var parallax = function() {

        if ( !isMobile.any() ) {

            $(window).stellar({
                horizontalScrolling: false,
                hideDistantElements: false,
                responsive: true
            });

        }
    };

    var contentWayPoint = function() {
        var i = 0;
        $('.animate-box').waypoint( function( direction ) {

            if( direction === 'down' && !$(this.element).hasClass('animated') ) {

                i++;

                $(this.element).addClass('item-animate');
                setTimeout(function(){

                    $('body .animate-box.item-animate').each(function(k){
                        var el = $(this);
                        setTimeout( function () {
                            var effect = el.data('animate-effect');
                            if ( effect === 'fadeIn') {
                                el.addClass('fadeIn animated');
                            } else if ( effect === 'fadeInLeft') {
                                el.addClass('fadeInLeft animated');
                            } else if ( effect === 'fadeInRight') {
                                el.addClass('fadeInRight animated');
                            } else {
                                el.addClass('fadeInUp animated');
                            }

                            el.removeClass('item-animate');
                        },  k * 200, 'easeInOutExpo' );
                    });

                }, 100);

            }

        } , { offset: function() {
            return 1.4*$(window).height(); } } );
    };

    var testimonialCarousel = function(){
        var owl = $('.owl-carousel-fullwidth');
        owl.owlCarousel({
            animateOut: 'fadeOut',
            items: 1,
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            dots: true,
            smartSpeed: 500,
            autoHeight: true
        });
    };

    var tapas_pagination = function(argument) {
        var items_tapas = [];
        items_tapas = $("div#section-tapas-container").find("div.animate-box");
        for (var i = items_tapas.length - 1; i >= 0; i--) {
            $(items_tapas[i]).removeClass("visible").addClass("hidden");
        };
        var tapa_start = 0;
        var tapa_end = 0;
        var tapa_page = Number($("div#section-tapas-container").attr("data-page"));
        var last_page = 1;

        tapa_start = (tapa_page-1)*4;
        tapa_end = tapa_start + 3;
        var cociente = items_tapas.length/4;
        last_page = Math.round(cociente);
        if (cociente - last_page > 0) {
            last_page++;
        }

        for (var i = tapa_start; i <= tapa_end; i++) {
            //console.log(i);
            $(items_tapas[i]).removeClass("hidden").addClass("visible");
        };
        $("div#section-tapas-container").attr("data-last-page", last_page);

    };

    $(function(){
        fullHeight();
        halfHeight();
        sliderMain();
        centerBlock();
        responseHeight()
        mobileMenuOutsideClick();
        offcanvasMenu();
        burgerMenu();
        toggleBtnColor();
        contentWayPoint();
        testimonialCarousel();
        parallax();
        tapas_pagination();
    });

    /*Smooth Scrolling*/
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    setTimeout(function(){
                        $('html, body').animate({
                            scrollTop: target.offset().top + 10
                        }, 500)
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 800);
                    }, 200)

                    return false;
                }
            }
        });
    });

    $("a.more-info-btn").click(function(e){
        e.preventDefault();
        $("a.more-info-btn").hide();

        if($("#fh5co-hero .flexslider").hasClass("maximized"))
        {
            $("#fh5co-hero .flexslider").removeClass("maximized");
            //$('#fh5co-hero .flexslider .slides > li').css('height', $(window).height()/1.2);
            $("a.more-info-btn").text("+ Info");
            $("a.more-info-btn").addClass("btn-sm");

            $("#fh5co-hero .flexslider .slides > li .image-container").removeClass("col-md-4").addClass("col-md-12")
            $("#fh5co-hero .flexslider .slides > li .first-info").removeClass("col-md-8").addClass("col-md-12")


            $("#fh5co-hero .flexslider .slides > li .row.more-info").fadeOut();
        }
        else
        {
            $("#fh5co-hero .flexslider").addClass("maximized");
            //$('#fh5co-hero .flexslider.maximized .slides > li').css('height', $(window).height());
            //$("a.more-info-btn").text("- Info");
            //$("#fh5co-hero .flexslider .slides > li .image-container").removeClass("col-md-12").addClass("col-md-4")
            $("#fh5co-hero .flexslider .slides > li .first-info").hide();
            $("#fh5co-hero .image-container.full-image").hide()
            $("#fh5co-hero .flexslider .slides > li .row.more-info").show("slow");
        }


    });
    $(".nav#tapas-nav a").click(function(e) {
        e.preventDefault();
        var page = Number($("div#section-tapas-container").attr("data-page"));
        var last_page = Number($("div#section-tapas-container").attr("data-last-page"));

        if ($(this).attr("class") == "next") {

            if (page < last_page) {
                $("div#section-tapas-container").attr("data-page", page+1);
            }
            else
            {
                $("div#section-tapas-container").attr("data-page", 1);
            }


        };
        if ($(this).attr("class") == "prev") {
            if (page > 1) {
                $("div#section-tapas-container").attr("data-page", page-1);
            }
            else
            {
                $("div#section-tapas-container").attr("data-page", last_page);
            }

        };
        tapas_pagination();
    });
    var imagen_click=-1;

    function rotate_galery() {

        var slide_number = 0;
        var element = $(".slide-imgwrap.colection3")[0];
        if( classie.has( element, 'current' ) ){
            classie.add(element,'hidden')
          //  console.log("slide 3")
            slide_number = 3
        }
        if(slide_number == 0) {
            var element = $(".slide-imgwrap.colection2")[0];
            if (classie.has(element, 'current')) {
                classie.add(element, 'hidden')
          //      console.log("slide 2")
                slide_number = 2
            }
        }
        if(slide_number == 0){
            var element = $(".slide-imgwrap.colection1")[0];
            if( classie.has( element, 'current' ) ){
                classie.add(element,'hidden')
          //      console.log("slide 1")
                slide_number = 1
            }
        }
     //   console.log("CURRENT SLIDE "+slide_number)
        classie.remove(element,'current')
        classie.add(element,'hidden')

        if(slide_number == 3)
            slide_number = 1;
        else slide_number++;

   //     console.log("NEXT SLIDE "+slide_number)
        var element = $(".slide-imgwrap.colection"+slide_number)[0];
        classie.add(element,'current')
        classie.remove(element,'hidden')
        setTimeout(rotate_galery, 10000)


    }

    function init_galery()
    {
        //console.log("INIT-GALERY")
        //TODO: el script deja de responder...
        //buscar la manera de ejecutar la función indfinidamente sin recursión

        // setTimeout(function(){
        $("div.imageframe").each(function(k){
//      console.log(imagesGalery.length);
            var el = $(this);
            setTimeout( function () {
                var image = imagesGalery.shift();
                var imageTitle = imagesGaleryTitles.shift();
                var imageDetails = imagesGaleryDetails.shift();
                if(image)
                {
                    el[0].style.backgroundImage="url("+image+")";
                    el[0].dataset["imgtitle"] = imageTitle;
                    el[0].dataset["imgdetails"] = imageDetails;
                    el[0].dataset["imgurl"] = image;
                    imagesGalery.push(image);
                    imagesGaleryTitles.push(imageTitle);
                    imagesGaleryDetails.push(imageDetails);
                }

            },  k * 200, 'easeInOutExpo' );
        });

// }, 5000);

    }
    $('#imgModal').on('show.bs.modal', function (element) {
        console.log(imagen_click);


    })
    $("div.slide__img-inner.imageframe").click(function(){
        var imagen_click = this.dataset["imgid"];
        //console.log(imagen_click)
        $("#imgModalLabel").text($(this).attr("data-imgtitle"));
        $("#imgDetails").text($(this).attr("data-imgdetails"));
        //$("#imgModalBody")[0].style.backgroundImage="url("+$(this).attr("data-imgurl")+")";
        $("#imgModalBodyImg")[0].src=$(this).attr("data-imgurl");
    })


     $("#BookingBtnTop").click(function(e){
           // e.preventDefault();
           window.scrollTo(0,10)
            

        });

    $(document).ready(function() {
        var value0 = $("#inputhidden0")[0].value;
        var value1 = $("#inputhidden1")[0].value;

        $("#inputhidden0")[0].value = value0 + "_" + value1;
        $("#inputhidden1")[0].value = value0 + "_" + value1;

        $("div#section-tapas-container").attr("data-page", 1);
        $("div#section-tapas-container .item-grid.text-center").click(
            function(e) {
                e.preventDefault();
            });


        init_galery();
    });

 rotate_galery()
    $(window).resize(function(){
       // console.log("Resized");
        console.log($(window).width())
        $("div#section-tapas-container").attr("data-page", 1);
        tapas_pagination();

    });
}());

/*INTRO EFFECT*/
(function() {

    // detect if IE : from http://stackoverflow.com/a/16657946      
    var ie = (function(){
        var undef,rv = -1; // Return value assumes failure.
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE ');
        var trident = ua.indexOf('Trident/');

        if (msie > 0) {
            // IE 10 or older => return version number
            rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        } else if (trident > 0) {
            // IE 11 (or newer) => return version number
            var rvNum = ua.indexOf('rv:');
            rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
        }

        return ((rv > -1) ? rv : undef);
    }());


    // disable/enable scroll (mousewheel and keys) from http://stackoverflow.com/a/4770179                  
    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = [38, 40], wheelIter = 0;

    function preventDefault(e) {
        e = e || window.event;
        if (e.preventDefault)
            e.preventDefault();
        e.returnValue = false;
    }

    function keydown(e) {
        for (var i = keys.length; i--;) {
            if (e.keyCode === keys[i]) {
                preventDefault(e);
                return;
            }
        }
    }

    function touchmove(e) {
        preventDefault(e);
    }

    function wheel(e) {
        // for IE 
        //if( ie ) {
        //preventDefault(e);
        //}
    }

    function disable_scroll() {
        window.onmousewheel = document.onmousewheel = wheel;
        document.onkeydown = keydown;
        document.body.ontouchmove = touchmove;
    }

    function enable_scroll() {
        window.onmousewheel = document.onmousewheel = document.onkeydown = document.body.ontouchmove = null;
    }

    var docElem = window.document.documentElement,
        scrollVal,
        isRevealed,
        noscroll,
        isAnimating,
        container = document.getElementById( 'fh5co-page' ),
        trigger = container.querySelector( 'button.trigger' );

    function scrollY() {
        return window.pageYOffset || docElem.scrollTop;
    }

    function scrollPage() {
        $(".trigger").hide();
        scrollVal = scrollY();

        if( noscroll && !ie ) {
            if( scrollVal < 0 ) return false;
            // keep it that way
            window.scrollTo( 0, 0 );
        }

        if( classie.has( container, 'notrans' ) ) {
            classie.remove( container, 'notrans' );
            return false;
        }

        if( isAnimating ) {
            return false;
        }

        if( scrollVal <= 0 && isRevealed ) {
            toggle(0);
        }
        else if( scrollVal > 0 && !isRevealed ){
            toggle(1);
        }
    }

    function toggle( reveal ) {
        isAnimating = true;
        var headerbar = document.getElementById("fh5co-header");
        if( reveal ) {
            classie.add( container, 'modify' );
            classie.add( headerbar, 'modify' );
            classie.add(trigger, 'hidden');
        }
        else {
            noscroll = true;
            disable_scroll();
            classie.remove( container, 'modify' );
            classie.remove( headerbar, 'modify' );
            classie.remove(trigger, 'hidden');
        }

        // simulating the end of the transition:
        setTimeout( function() {
            isRevealed = !isRevealed;
            isAnimating = false;
            if( reveal ) {
                noscroll = false;
                enable_scroll();
            }
        }, 1200 );
    }

    // refreshing the page...
    var pageScroll = scrollY();
    noscroll = pageScroll === 0;

    disable_scroll();

    if( pageScroll ) {
        isRevealed = true;
        classie.add( container, 'notrans' );
        classie.add( container, 'modify' );
    }

    window.addEventListener( 'scroll', scrollPage );
    trigger.addEventListener( 'click', function() { toggle( 'reveal' ); } );
})();

