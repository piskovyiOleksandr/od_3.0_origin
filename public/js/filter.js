
function init_ion_slider()
{
	var range = $('.range-slider').find('.js-range-slider'),
			inputFrom = $('.range-slider').find('.age-min'),
			inputTo = $('.range-slider').find('.age-max'),
			min_overall = $('#min-age-overall').val(),
			max_overall = $('#max-age-overall').val(),
			min = $('#min-age').val(),
			max = $('#max-age').val(),
			instance;

	range.ionRangeSlider({
		skin: 'round',
		type: 'double',
		min: min_overall,
		max: max_overall,
		from: min,
		to: max,
		onStart: updateInputs,
		onChange: updateInputs
	});

	instance = range.data('ionRangeSlider');

	function updateInputs(data)
	{
		from = data.from;
		to = data.to;

		inputFrom.prop('value', from);
		inputTo.prop('value', to);
	}

	inputFrom.on('input', function () {
		var val = $(this).prop('value');

		if ( val < min ) {
			val = min;
		} else if ( val > to ) {
			val = to;
		}

		instance.update({from: val});
	});

	inputTo.on('input', function () {
		var val = $(this).prop('value');

		if ( val < from ) {
			val = from;
		} else if ( val > max ) {
			val = max;
		}

		instance.update({to: val});
	});
}


$('.filter-apply').on('click', function(){

	$('#profiles-list').html('');
	$('.button-load-more').remove();

	let goal_val = $('#filter-goals').val(),
			type_val = $('#filter-types').val(),
			page = $('.button-load-more').data('page'),
			min_age = $('.age-min').val(),
			max_age = $('.age-max').val(),
			distance = $('.location .current').data('distance'),
			data = ''

	if ( goal_val != '' )
		data += 'goal=' + goal_val

	if ( type_val != '' && goal_val != '' )
		data += '&type=' + type_val
	else
		data += 'type=' + type_val

	$.cookie('filter-goal', goal_val, { path: '/', expires: 7, secure: 1 })
	$.cookie('filter-type', type_val, { path: '/', expires: 7, secure: 1 })

	if ( page )
		data += data + '&page=' + page
	let page_new = parseInt( page ) + 1

	data += '&min-age=' + min_age + '&max-age=' + max_age
	$.cookie('filter-min-age', min_age, { path: '/', expires: 7, secure: 1 })
	$.cookie('filter-max-age', max_age, { path: '/', expires: 7, secure: 1 })

	data += '&distance=' + distance

	$.ajax({
		type: 'GET',
		url: '/ajax/search-load-more',
		data: data,
		success: function(html){
			$('#profiles-list').html('<input type="hidden" id="min-age" value="' + min_age + '" />')
			$('#profiles-list').append('<input type="hidden" id="max-age" value="' + max_age + '" />')
			$('#profiles-list').append(html)
			//$('.button-load-more').data('page', 1)

			$('.location-list').data('min-age', min_age)
			$('.location-list').data('max-age', max_age)
		},
		complete: mrzv_hide_popup('', 1)
	})
})


$('.filter-clear').on( 'click', function(){
	let min_age = $('#min-age').val(),
			max_age = $('#max-age').val()
	$('#filter-goals').val(0)
	$('#filter-types').val(0)
	$('.age-min').val(min_age)
	$('.age-max').val(max_age)
	//init_ion_slider()
})


$(document).ready(function(){

	//init_menu();
	init_ion_slider();

});


