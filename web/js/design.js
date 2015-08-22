$(document).ready(function() {


	$('form#yes-form').submit(function(){

		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		var data = $('form#yes-form').serializeArray();                
                var id = $('form#yes-form').find('input:checked').attr("id");

		$.ajax({
		type:'POST',
		dataType: 'json',
	    data: {data: data , id: id, _csrf : csrfToken},
		url:'/site/vote.html',
		cache:false,
		success:function(html){
				console.log(html);
				//var data = $.parseJSON(html);
				if(html.success == true){
					$('.vote_yes_this, .vote_no_this').hide();
					$('.main_auth').show();
				}
			}
		});

		return false;
	});

	$('form#no-form').submit(function(){

		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		var data = $('form#no-form').serializeArray();
                var id = $('form#no-form').find('input:checked').attr("id");
                
		$.ajax({
		type:'POST',
		dataType: 'json',
	    data: {data: data , id: id, _csrf : csrfToken},
		url:'/site/vote.html',
		cache:false,
		success:function(html){
				console.log(html);
				//var data = $.parseJSON(html);
				if(html.success == true){
					$('.vote_yes_this, .vote_no_this').hide();
					$('.main_auth').show();
				}
			}
		});

		return false;
	});


	if($('.inp-decorate').length) {
	 $('.inp-decorate').styler();
	}



	if($('.line__progress').length) {
		
		// Progress1
	    $('.line__progress-1').circleProgress({
		    value: 0.37,
		    thickness: 40,
		    startAngle: 4.7,
		    size: 260,
		    fill: {
	            color: '#ffec68',
	        },
	        emptyFill: '#fff',
		}).on('circle-animation-progress', function(event, progress, stepValue) {
		    var prg = Math.round(String(stepValue) * 100) + '<div class="prc">%</div>';

		    $(this).find('span').html(prg);
		});


		// Progress2
	    $('.line__progress-2').circleProgress({
		    value: 0.63,
		    thickness: 40,
		    startAngle: 4.7,
		    reverse: true,
		    size: 260,
		    fill: {
	            color: '#ffec68',
	        },
	        emptyFill: '#fff',
		}).on('circle-animation-progress', function(event, progress, stepValue) {
		    var prg = Math.round(String(stepValue) * 100) + '<div class="prc">%</div>';

		    $(this).find('span').html(prg);
		});

	}

});


$(window).scroll(function() {});
$(window).resize(function() {});
$(window).load(function() {});

function OpenYes(){
    $('.vote_yes_this').show();
    $('.block__hide').hide();
    return false;
}
function OpenNo(){
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
