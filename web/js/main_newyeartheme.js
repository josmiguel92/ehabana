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




     $("#BookingBtnTop").click(function(e){
           // e.preventDefault();
           window.scrollTo(0,10)
            

        });

    $(document).ready(function() {
        try{
            var value0 = $("#inputhidden0")[0].value;
            var value1 = $("#inputhidden1")[0].value;

            $("#inputhidden0")[0].value = value0 + "_" + value1;
            $("#inputhidden1")[0].value = value0 + "_" + value1;
        }
        catch (e) {
            console.log("Error al verificar los campos del formulario")
        }

    });

    $(window).resize(function(){
       // console.log("Resized");
        console.log($(window).width())

    });
}());