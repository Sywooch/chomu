$(document).ready(function () {

    if ($('.inp-decorate').length) {
        $('.inp-decorate').styler();
    }

    if ($('.scroller').length) {
        $('.scroller').jScrollPane({
            autoReinitialise: true,
        });
    }


    //Footer link popup

    // Contacts
    $('.footer__contacts').click(function () {
        $('body').addClass('hold');
        $('.popup_holder').fadeIn(250);
        $('.popup_contacts').fadeIn(250);
    });


    // Contidions
    $('.footer__conditions').click(function () {
        $('body').addClass('hold');
        $('.popup_holder').fadeIn(250);
        $('.popup_terms').fadeIn(250);
    });

    // Politics
    $('.footer__politics').click(function () {
        $('body').addClass('hold');
        $('.popup_holder').fadeIn(250);
        $('.popup_police').fadeIn(250);
    });


    $('.popup-close').click(function () {
        $('.popup').fadeOut(250);
        $('.popup_holder').fadeOut(250);
        $('body').removeClass('hold');
    });

    // Skip video
    $('.load_video__skip').click(function () {
        $('.load_video').fadeOut(250);

        $('#load_video')[0].pause();
    });

    $('#load_video').on('ended', function () {
        $('.load_video').fadeOut(250);
    });


    // Count vote result
    $('.countto__number').each(function () {

        var count_element = $(this).html();

        $(this).countTo({
            from: 0,
            to: count_element,
            speed: 750,
            refreshInterval: 50,
            onUpdate: function (value) {
                value = value + '%';

                $(this).parents('.progress').find('.progress__in').css({'width': value});
            }
        });
    });


    if ($('.line__progress').length) {
                                
        // Progress1
        $('.line__progress-1').circleProgress({
            value: $('.line__progress-1').find('span').text()/100 ,
            thickness: 40,
            startAngle: 4.7,
            size: 260,
            fill: {
                color: '#ffec68',
            },
            emptyFill: '#fff',
        }).on('circle-animation-progress', function (event, progress, stepValue) {
            var prg = Math.round(String(stepValue) * 100) + '<div class="prc">%</div>';

            $(this).find('span').html(prg);
        });


        // Progress2
        $('.line__progress-2').circleProgress({
            value: $('.line__progress-2').find('span').text()/100 ,
            thickness: 40,
            startAngle: 4.7,
            reverse: true,
            size: 260,
            fill: {
                color: '#ffec68',
            },
            emptyFill: '#fff',
        }).on('circle-animation-progress', function (event, progress, stepValue) {
            var prg = Math.round(String(stepValue) * 100) + '<div class="prc">%</div>';

            $(this).find('span').html(prg);
        });

    }

    $('form#yes-form').submit(function () {

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var data = $('form#yes-form').serializeArray();
        var id = $('form#yes-form').find('input:checked').attr("id");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {data: data, id: id, _csrf: csrfToken},
            url: '/site/vote.html',
            cache: false,
            success: function (html) {
                console.log(html);
                //var data = $.parseJSON(html);
                if (html.success == true) {
                    $('.vote_yes_this, .vote_no_this').hide();
                    $('.main_auth').show();
                }
            }
        });

        return false;
    });

    $('form#no-form').submit(function () {

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var data = $('form#no-form').serializeArray();
        var id = $('form#no-form').find('input:checked').attr("id");

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {data: data, id: id, _csrf: csrfToken},
            url: '/site/vote.html',
            cache: false,
            success: function (html) {
                console.log(html);
                //var data = $.parseJSON(html);
                if (html.success == true) {
                    $('.vote_yes_this, .vote_no_this').hide();
                    $('.main_auth').show();
                }
            }
        });

        return false;
    });

});

$(window).scroll(function () {
});
$(window).resize(function () {
});
$(window).load(function () {
});


function OpenYes() {
    $('.vote_yes_this').show();
    $('.block__hide').hide();
    return false;
}
function OpenNo() {
    $('.vote_no_this').show();
    $('.block__hide').hide();
    return false;
}

function auth_user() {

    $('.main_auth').hide();
    $('.popup_holder, .popup_auth').fadeIn();
    return false;
}

function auth_close() {

    $('.main_auth').show();
    $('.popup_holder, .popup_auth').fadeOut();
    return false;
}

function resultYes() {

    $('.result_page').hide();
    $('.vote_yes').show();

    return false;
}

function resultNo() {

    $('.result_page').hide();
    $('.vote_no').show();

    return false;
}

function back() {

    $('.vote_no, .vote_yes').hide();
    $('.result_page').show();

    return false;
}