
$(document).on('click', '.icon-add', function(){

	let obj = $(this),
			id = obj.parent().parent().data('id'),
			profile_match = obj.closest('.matches-element').data('matches'),
			timeout = obj.closest('.matches-element').data('timeout')

	if ( profile_match == '1' )
	{
		matches_add_new( id, timeout )
	}
	else if ( profile_match == '0' )
	{
		if ( localStorage.getItem( 'matches_id_del' ) === null )
		{
			arMatches = [ id ]
			localStorage.setItem( 'matches_id_del', JSON.stringify( arMatches ) )
		}
		else
		{
			arMatches = JSON.parse( localStorage.getItem( 'matches_id_del' ) )
			arMatches.push( id )
			localStorage.setItem( 'matches_id_del', JSON.stringify( arMatches ) )
		}
	}
	
	let goal = $('#goal').val(),
			type = $('#type').val(),
			min_age = $('#min-age').val(),
			max_age = $('#max-age').val(),
			page = $('#page').val(),
			new_page = parseInt( page ) + 1,
			zindex = $(this).parent().parent().css('z-index'),
			new_zindex = parseInt( zindex ) - 1,
			matches_add = localStorage.getItem( 'matches_id' ) ?? [],
			matches_del = localStorage.getItem( 'matches_id_del' ) ?? []

	function remove_this(obj)
	{
		obj.remove()
	}

	$.ajax({
		type: 'GET',
		url: '/ajax/matches-load-more',
		data: 'goal=' + goal + '&type=' + type + '&min-age=' + min_age + '&max-age=' + max_age + '&page=' + page + '&zindex=' + new_zindex + '&matches_add=' + matches_add + '&matches_del=' + matches_del,
		success: function(html)
		{
			$('#matches-list').append(html)
		},
		complete: function()
		{
			setTimeout( obj.parent().parent().animate( { left:'-100%' }, 300, remove_this ), 1000 )
			$('#page').prop('value', new_page)
			init_matches_slider()
		}
	})

})
function matches_add_new( id, timeout )
{
	let date = new Date(),
			current_time = date.getTime(),
			matches_popup = JSON.parse( localStorage.getItem( 'matches_popup' ) )

	// для появления попапов
	if ( matches_popup === null )
	{
		//alert( 'matches_popup is null' )
		matches_popup = []
		matches_popup[id] = parseInt( current_time ) + parseInt( timeout )*1000
		localStorage.setItem( 'matches_popup', JSON.stringify( matches_popup ) )
		//alert( 'element added' )
	}
	else
	{
		//alert( 'local is' )
		matches_popup = JSON.parse( localStorage.getItem( 'matches_popup' ) )
		matches_popup[id] = parseInt( current_time ) + parseInt( timeout )*1000
		localStorage.setItem( 'matches_popup', JSON.stringify( matches_popup ) )
		//alert( 'element added' )
	}

	// для работы слайдера
	if ( localStorage.getItem( 'matches_id' ) === null )
	{
		arMatches = [ id ]
		localStorage.setItem( 'matches_id', JSON.stringify( arMatches ) )
	}
	else
	{
		arMatches = JSON.parse( localStorage.getItem( 'matches_id' ) )
		arMatches.push( id )
		localStorage.setItem( 'matches_id', JSON.stringify( arMatches ) )
	}

	clearInterval( matches_foreach )

	// для перебора массива с отсрочками
	matches_foreach = setInterval( update_matches_popup, 1000 )
}


$(document).on('click', '.icon-del', function(){

	let obj = $(this),
			id = obj.parent().parent().data('id')

	if ( localStorage.getItem( 'matches_id_del' ) === null )
	{
		arMatches = [ id ]
		localStorage.setItem( 'matches_id_del', JSON.stringify( arMatches ) )
	}
	else
	{
		arMatches = JSON.parse( localStorage.getItem( 'matches_id_del' ) )
		arMatches.push( id )
		localStorage.setItem( 'matches_id_del', JSON.stringify( arMatches ) )
	}

	let goal = $('#goal').val(),
			type = $('#type').val(),
			min_age = $('#min-age').val(),
			max_age = $('#max-age').val(),
			page = $('#page').val(),
			new_page = parseInt( page ) + 1,
			zindex = $(this).parent().parent().css('z-index'),
			new_zindex = parseInt( zindex ) - 1,
			matches_add = localStorage.getItem( 'matches_id' ) ?? [],
			matches_del = localStorage.getItem( 'matches_id_del' ) ?? []

	function remove_this()
	{
		obj.parent().parent().remove()
	}

	$.ajax({
		type: 'GET',
		url: '/ajax/matches-load-more',
		data: 'goal=' + goal + '&type=' + type + '&min-age=' + min_age + '&max-age=' + max_age + '&page=' + page + '&zindex=' + new_zindex + '&matches_add=' + matches_add + '&matches_del=' + matches_del,
		success: function(html)
		{
			$('#matches-list').append(html)
		},
		complete: function()
		{
			let slide = setTimeout( obj.parent().parent().animate( { left:'-100%' }, 300, remove_this ), 800 )
			$('#page').prop('value', new_page)
			init_matches_slider()
		}
	})

})
function unique( arr, id )
{
	let result = []

	for ( let str of arr )
	{
		if ( ! result.includes( str ) && str != id )
		{
			result.push( str )
		}
	}

	return result
}
$(document).on( 'click', '.single-grid-item .close-icon, .single-grid-item .icon-like', function(){
	let arr_matches_add = JSON.parse( localStorage.getItem( 'matches_id' ) ),
			id = $(this).data('id')

	arr_matches_add = unique( arr_matches_add, id )
	localStorage.setItem( 'matches_id', JSON.stringify( arr_matches_add ) )
	$(this).parent().parent().parent().remove()
})
