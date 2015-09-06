$(document).ready(function () {


    if ($('.inp-decorate').length) {
        $('.inp-decorate').styler();
    }

    if ($('.scroller').length) {
        $('.scroller').jScrollPane({
            autoReinitialise: true
        });
    }
//GA

    $('a[data-eauth-service="facebook"]').click(function() {
        ga('send', 'event', 'Authorizfb', 'Click');
    });
    $('a[data-eauth-service="vkontakte"]').click(function() {
        ga('send', 'event', 'Authorizvk', 'Click');
    });
    $('a[data-eauth-service="odnoklassniki"]').click(function() {
        ga('send', 'event', 'Authorizok', 'Click');
    });

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
                color: '#ffec68'
            },
            emptyFill: '#fff'
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
                color: '#ffec68'
            },
            emptyFill: '#fff'
        }).on('circle-animation-progress', function (event, progress, stepValue) {
            var prg = Math.round(String(stepValue) * 100) + '<div class="prc">%</div>';

            $(this).find('span').html(prg);
        });

    }

    $('form#yes-form').submit(function () {

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var data = $('form#yes-form').serializeArray();
        var id = $('form#yes-form').find('input:checked').attr("id");
        var answer = $('form#yes-form').find('#custom_yes_answer').val();        

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {data: data, id: id, answer:answer, _csrf: csrfToken},
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
        var answer = $('form#no-form').find('#custom_no_answer').val();        

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {data: data, id: id, answer:answer, _csrf: csrfToken},
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
    
    $('#yes-form  input[type="submit"]').attr('disabled','disabled');
    $('#no-form  input[type="submit"]').attr('disabled','disabled');
    
    $('#custom_yes_answer').keydown(function(){ $('#yes-form input[type="submit"]').removeAttr('disabled');})

    $.each($('#yes-form  ul  li'), function(){ 
    var elem = $('#yes-form  ul  li').eq($(this).index());
    if(elem.hasClass('myvote') == false ){
        elem.children().change(function(){ 
            $('#yes-form input[type="submit"]').removeAttr('disabled');
            })
    } else {
        elem.children().change(function(){ 
            if($('#custom_yes_answer').val() !== ''){
            $('#yes-form input[type="submit"]').removeAttr('disabled');
            } else {
                $('#yes-form input[type="submit"]').attr('disabled','disabled');
            }
            })
    }
    })
    
    $('#custom_no_answer').keydown(function(){ $('#no-form input[type="submit"]').removeAttr('disabled');})

    $.each($('#no-form  ul  li'), function(){ 
    var elem = $('#no-form  ul  li').eq($(this).index());
    if(elem.hasClass('myvote') == false ){
        elem.children().change(function(){ 
            $('#no-form input[type="submit"]').removeAttr('disabled');
            })
    } else {
        elem.children().change(function(){ 
            if($('#custom_no_answer').val() !== ''){
            $('#no-form input[type="submit"]').removeAttr('disabled');
            } else {
                $('#no-form input[type="submit"]').attr('disabled','disabled');
            }
            })
    }
    })
    
    $('.vote_page__list').find('div').removeClass('checked');
    
    $('li.myvote > div > input:radio').change(function() {
            if ($(this).is(':checked')) {
            $('li.myvote > div + label > input').val('');
            $('li.myvote > div + label > input').focus();
        }
    });
    $('li.myvote > div + label > input').click(function(){
        $('li.myvote > div + label > input').val(''); 
        $('.vote_page__list').find('div').removeClass('checked');
        $('li.myvote > div > input:radio').prop('checked', true).trigger('refresh');
        
    });
    $(".top__mobiletoggle").click(toggleMenu);
});

$(window).scroll(function () {
});
$(window).resize(function () {
});
$(window).load(function () {
    $('.vote_page__list').find('div').removeClass('checked');
});

function toggleMenu() {
    $(".top__mobiletoggle").toggleClass('is-active');
    $(".mobile__menuwrap").toggle(400);
    $(window).scrollTop(0);
}

function OpenYes() {
    ga('send', 'event', 'Chomutak', 'Click');
    $('.vote_yes_this').show();
    $('.block__hide').hide();
    return false;
}
function OpenNo() {
    ga('send', 'event', 'Chomunet', 'Click');
    $('.vote_no_this').show();
    $('.block__hide').hide();
    return false;
}

function auth_user() {
ga('send', 'event', 'Authoriz', 'Click');
    $('.main_auth').fadeOut();
    $('.popup_holder, .popup_auth').fadeIn();

}

function auth_close() {
    $('.popup_holder, .popup_auth').fadeOut();
    $('.main_auth').fadeIn();

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
