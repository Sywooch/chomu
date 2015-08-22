$(document).ready(function() {

	if($('.inp-decorate').length) {
	 $('.inp-decorate').styler();
	}

	if($('.scroller').length) {
		$('.scroller').jScrollPane({
			autoReinitialise: true,
		});
	}


	//Footer link popup

	// Contacts
	$('.footer__contacts').click(function(){
		$('body').addClass('hold');
		$('.popup_holder').fadeIn(250);
		$('.popup_contacts').fadeIn(250);
	});


	// Contidions
	$('.footer__conditions').click(function(){
		$('body').addClass('hold');
		$('.popup_holder').fadeIn(250);
		$('.popup_terms').fadeIn(250);
	});

	// Politics
	$('.footer__politics').click(function(){
		$('body').addClass('hold');
		$('.popup_holder').fadeIn(250);
		$('.popup_police').fadeIn(250);
	});


	$('.popup-close').click(function(){
		$('.popup').fadeOut(250);
		$('.popup_holder').fadeOut(250);
		$('body').removeClass('hold');
	});

	// Skip video
	$('.load_video__skip').click(function(){
		$('.load_video').fadeOut(250);

		$('#load_video')[0].pause();
	});

	$('#load_video').on('ended', function(){
		$('.load_video').fadeOut(250);
    });


	// Count vote result
    $('.countto__number').each(function() {

		var count_element = $(this).html();

		$(this).countTo({
			from: 0,
			to: count_element,
			speed: 750,
			refreshInterval: 50,
			onUpdate: function(value){
				value = value + '%';

				$(this).parents('.progress').find('.progress__in').css({'width': value});
			}
		});
	});


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