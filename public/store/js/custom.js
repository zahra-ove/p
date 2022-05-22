$( document ).ready(function() {

    $( "#getVerificationCode" ).on( "click", function() {
        console.log( 'hi');
        let userId = $('#user_id').val();  //get user id

        GenerateVerificationCode(userId);
    });

    const GenerateVerificationCode = function(userId) {

        $.ajax({
            cache: false,
            type: "GET",
            url: "/get-verification-code/" + userId,
            // data: dataToSend,
            success: function(data)
            {
                if(data == 'false') {
                    toastr.error('خطایی در فرآیند تولید کد تایید رخ داده!');
                }else {
                    counterDownTimer(60);
                    console.log('code generated successfully');
                    console.log(data);
                }
            },
            error: function(msg)
            {
                console.log('code generation failed');
                console.log(msg);
            }
        });
    }


    const counterDownTimer = function (remaining) {
        let timerOn = true;

        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('counter').innerHTML = m + ':' + s;
        remaining -= 1;

        if(remaining >= 0 && timerOn) {
            setTimeout(function() {
                counterDownTimer(remaining);
            }, 1000);
            return;
        }

        if(!timerOn) {
            // Do validate stuff here
            return;
        }

        // Do timeout stuff here after timer reached to 00:00
        document.getElementById('counter').innerHTML = 'دریافت مجدد کد تایید'
    }

});



