grecaptcha.ready(function() {
    grecaptcha.execute('6Lec8pEUAAAAABcjeftSieE3qXAnzJIwSwmEil7X', {action: 'homepage'}).then(function(token) {
        var recaptchaResponse = document.getElementById('appbundle_booking_recaptchaResponse');
        recaptchaResponse.value = token;
    });
});