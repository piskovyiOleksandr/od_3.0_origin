
@extends('layout')

	@section('title') Cats Matches @endsection

	@section('content')
		<div class="main">
			<div class="header">
				<h1>Find Matches</h1>
			</div>
			<div class="content matches">
				<div class="mrzv-link-ajax open-filter icons" data-href="/ajax/matches-filter" onclick="mrzv_popup_ajax(this, 'filter-goal=<?= isset($_COOKIE['matches-filter-goal']) ? $_COOKIE['matches-filter-goal'] : 0 ?>&filter-type=<?= isset($_COOKIE['matches-filter-goal']) ? $_COOKIE['matches-filter-type'] : 0 ?>&min-age=<?= isset($_COOKIE['matches-filter-min-age']) ? $_COOKIE['matches-filter-min-age'] : $min_max_age_overall['min-age'] ?>&max-age=<?= isset($_COOKIE['matches-filter-max-age']) ? $_COOKIE['matches-filter-max-age'] : $min_max_age_overall['max-age'] ?>&lang=');"></div>

				<div class="location" style="display:none">
					<span class="location-list" data-goal="<?= isset($_COOKIE['matches-filter-goal']) ? $_COOKIE['matches-filter-goal'] : 0 ?>" data-type="<?= isset($_COOKIE['matches-filter-goal']) ? $_COOKIE['matches-filter-type'] : 0 ?>" data-min-age="<?= isset($_COOKIE['matches-filter-min-age']) ? $_COOKIE['matches-filter-min-age'] : $min_max_age_overall['min-age'] ?>" data-max-age="<?= isset($_COOKIE['matches-filter-max-age']) ? $_COOKIE['matches-filter-max-age'] : $min_max_age_overall['max-age'] ?>">
						<div class="location-headers">Users near you:</div>
						<span class="location-element @if( Cookie::get('filter-distance') == '10' || ! Cookie::get('filter-distance') )<?php echo 'current' ?>@endif transition-03" data-distance="10">Up to 10 miles</span>
						<span class="location-element @if( Cookie::get('filter-distance') == '5' )<?php echo 'current' ?>@endif transition-03" data-distance="5">Up to 5 miles</span>
						<span class="location-element @if( Cookie::get('filter-distance') == '1' )<?php echo 'current' ?>@endif transition-03" data-distance="1">Up to 1 miles</span>
					</span>
				</div>

				<div class="matches-find">
					<div class="matches-list" id="matches-list">
						<input type="hidden" id="min-age" value="<?= isset($_COOKIE['matches-filter-min-age']) ? $_COOKIE['matches-filter-min-age'] : $min_max_age_overall['min-age'] ?>" />
						<input type="hidden" id="max-age" value="<?= isset($_COOKIE['matches-filter-max-age']) ? $_COOKIE['matches-filter-max-age'] : $min_max_age_overall['max-age'] ?>" />
						<input type="hidden" id="goal" value="<?= isset($_COOKIE['matches-filter-goal']) ? $_COOKIE['matches-filter-goal'] : 0 ?>" />
						<input type="hidden" id="type" value="<?= isset($_COOKIE['matches-filter-goal']) ? $_COOKIE['matches-filter-type'] : 0 ?>" />
						<input type="hidden" id="page" value="0" />
					</div>
				</div>
			</div>
		</div>
	@endsection


@section('script')

<script src="{{ asset('/public/js/matches.js') }}" type="text/javascript" defer></script>

<script type="text/javascript" defer>
	function init_find_matches()
	{
		let matches_add = localStorage.getItem( 'matches_id' ) ? localStorage.getItem( 'matches_id' ) : [],
				matches_del = localStorage.getItem( 'matches_id_del' ) ? localStorage.getItem( 'matches_id_del' ) : [],
				goal = $('#goal').val(),
				type = $('#type').val(),
				min_age = $('#min-age').val(),
				max_age = $('#max-age').val(),
				page = $('#page').val(),
				new_page = parseInt( page ) + 1,
				zindex = $(this).parent().parent().css('z-index'),
				new_zindex = parseInt( zindex ) - 1

		$.ajax({
			type: 'GET',
			url: '/ajax/matches-load-more',
			data: 'goal=' + goal + '&type=' + type + '&min-age=' + min_age + '&max-age=' + max_age + '&page=' + page + '&zindex=' + new_zindex + '&matches_add=' + matches_add + '&matches_del=' + matches_del,
			success: function(html){
				$('#matches-list').append(html)
				$('#page').prop('value', new_page)
			},
			complete: function(){
				init_matches_slider()
			}
		})
		//ajax( 'get', '/ajax/matches-load-more', 'goal=' + goal + '&type=' + type + '&min-age=' + min_age + '&max-age=' + max_age + '&page=' + page + '&zindex=' + new_zindex + '&arMatches=' + arMatches + '&arMatches_del' + arMatches_del, '#matches-list' )
	}
</script>

@endsection
