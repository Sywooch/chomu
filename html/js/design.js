$(document).ready(function() {

	if($('.inp-decorate').length) {
	 $('.inp-decorate').styler();
	}

	if($('.scroller').length) {
		$('.scroller').jScrollPane({
			autoReinitialise: true,
		});
	}


	// Skip video
	$('.load_video__skip').click(function(){
		$('.load_video').fadeOut(250);
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