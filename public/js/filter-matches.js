
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

	$('#matches-list .matches-element').remove();
	$('#matches-list .cats-empty').remove();

	let goal_val = $('#filter-goals').val(),
			type_val = $('#filter-types').val(),
			page = 0,
			min_age = $('.age-min').val(),
			max_age = $('.age-max').val(),
			data = '',
			zindex = 1000,
			matches_add = localStorage.getItem( 'matches_id' ) ?? [],
			matches_del = localStorage.getItem( 'matches_id_del' ) ?? []

	if ( goal_val != '' )
		data += 'goal=' + goal_val;

	if ( type_val != '' && goal_val != '' )
		data += '&type=' + type_val;
	else
		data += 'type=' + type_val;

	$.cookie('matches-filter-goal', goal_val, { path: '/', expires: 7, secure: 1 })
	$.cookie('matches-filter-type', type_val, { path: '/', expires: 7, secure: 1 })

	if ( page )
		data += data + '&page=' + page;

	data += '&min-age=' + min_age + '&max-age=' + max_age;
	$.cookie('matches-filter-min-age', min_age, { path: '/', expires: 7, secure: 1 })
	$.cookie('matches-filter-max-age', max_age, { path: '/', expires: 7, secure: 1 })

	data += '&zindex=' + zindex + '&matches_add=' + matches_add + '&matches_del=' + matches_del;

	$.ajax({
		type: 'GET',
		url: '/ajax/matches-load-more',
		data: data,
		success: function(html){
			$('#min-age').prop('value', min_age)
			$('#max-age').prop('value', max_age)
			$('#goal').prop('value', goal_val)
			$('#type').prop('value', type_val)
			$('#page').prop('value', 1)
			$('#matches-list').append(html)
		},
		complete: function(){
			mrzv_hide_popup('', 1)
			init_matches_slider()
		}
	})
})


$(document).ready(function(){

	init_ion_slider();

});
