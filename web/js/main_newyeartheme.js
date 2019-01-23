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

        var myFullpage = new fullpage('#fullpage', {
            anchors: ['start','news', 'foods', 'drinks','about','about','contact', 'gallery','book'],
            sectionsColor: ['#312a19','#fff','#2792E1','#834','#643','#fff', '#000'],
            css3: true,
            onLeave: function(origin, destination, direction) {
                if (destination.index === 2) {
                    destination.item.classList.add('load-background');
                }
            },
            slidesNavigation: true,
            // scrollOverflow: true,
        });

        var nlform = new NLForm( document.getElementById( 'nl-form' ) );
        $('document').ready(function(){
            $('#nl-form-submit').click(function(e){
                $('#nl-form input[data-form=booking]').each(
                    function (index) {
                        var element_name_temp = this.name+'-toggle';
                        element_name_temp = element_name_temp.replace('[','').replace(']','')
                        console.log(element_name_temp);
                        var element_temp = document.getElementById(element_name_temp);
                        console.log(element_temp)
                        if(this.checkValidity())
                        {
                            element_temp.classList.add('form-ok')
                            element_temp.classList.remove('form-error')
                            element_temp.classList.remove('pulse')
                            element_temp.classList.remove('animated')
                            console.log(element_temp.classList)

                        }
                        else{
                            element_temp.classList.add('form-error')
                            element_temp.classList.add('pulse')
                            element_temp.classList.add('animated')
                            console.log(element_temp.classList)
                        }


                    }

                )
            });
        })

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