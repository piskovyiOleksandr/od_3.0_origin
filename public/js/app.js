
let matches_foreach, // for matches.js
		arMatches, // for matches.js
		chat_count_stories


function ajax( type, url, data, obj, func, time = 0, add )
{
	if ( type == '' )
		var type = 'get'
	$(obj).append('<div class="mrzv-ajax-preloader"><div class="mrzv-ajax-preloader-img"></div></div>')

	$.ajax({
		type: type,
		url: url,
		data: data,
		success: function(html){
			
			if ( ! add || add == '' )
			{
				if ( obj )
					$(obj).html(html)
			}
			else if ( add != '' )
			{
				if ( obj )
				{
					if ( add == 'append' )
					{
						$(obj).append(html)
					}
				}
			}
		},
		complete: function(){
			$('.mrzv-ajax-preloader').animate({background:'rgba(255,254,248,0)'}, 1000, ajax_after)
			if ( func )
				setTimeout( func, time )
		}
	});
}
function ajax_after()
{
	$('.mrzv-ajax-preloader').remove();
}


// ajax окно
function mrzv_popup_ajax(obj, data)
{
	var url = $(obj).data('href');

	var popup_is_open = $('div').is('.mrzv-popup-1');

	if ( !popup_is_open )
		var id = '1';
	else
		var id = '2';

	$('body').append('<div class="mrzv-overlay" id="mrzv-overlay-' + id + '"></div>');
	$('.mrzv-overlay').animate({opacity: '1'}, 300);
	$('body').append('<div class="mrzv-popup-' + id + '"><div class="mrzv-popup-in"><div class="mrzv-popup-preloader"><div class="mrzv-popup-preloader-img"></div></div></div></div>');
	$('.mrzv-popup-' + id).animate({right: '0'}, 300, 'swing'/* , mrzv_show_close */);
	$('.mrzv-popup-' + id + ' .mrzv-popup-in').append('<div class="mrzv-popup-content"><div class="mrzv-popup-content-in" id="mrzv-popup-data-' + id + '"></div></div>');

	/* function mrzv_show_close()
	{
		$('.mrzv-popup-' + id).append('<div class="mrzv-popup-close" onclick="mrzv_hide_popup(this, '+ id +')" id="' + id + '"><i class="fal fa-times"></i></div>');
		if ( $('body').width() > 800 )
			$('.mrzv-popup-close').animate({left:'-62px', opacity:'1'}, 300);
		else
			$('.mrzv-popup-close').animate({left:'-46px', opacity:'1'}, 300);
	} */

	setTimeout(mrzv_ajax, 300);

	function mrzv_ajax()
	{
		$.ajax({
			url: url,
			data: data,
			success: function(html){
				$('#mrzv-popup-data-' + id).html(html);
			},
			complete: function(){
				$('.mrzv-popup-preloader').animate({opacity:'0'}, 400, mrzv_remove_preloader);
				init_swipe_ajax()
			}
		});
	}

	function mrzv_remove_preloader()
	{
		$('.mrzv-popup-preloader').remove();
	}
}

function init_swipe_ajax()
{
	/* $('.mrzv-popup-content').swipe({
		swipeRight: close_mrzv_popup,
		threshold:40
	}) */
}

function mrzv_hide_popup(obj, id)
{
	$('#mrzv-overlay-' + id).animate({opacity: '0'}, 400, mrzv_remove_overlay);
	$(obj).animate({left:'0', opacity:'0'}, 400, mrzv_remove_close);
	if ( $('body').width() > 1024 )
		$('.mrzv-popup-' + id).animate({right: '-30%'}, 400, 'swing', mrzv_remove_popup);
	else if ( $('body').width() > 200 )
		$('.mrzv-popup-' + id).animate({right: '-100%'}, 400, 'swing', mrzv_remove_popup);

	function mrzv_remove_popup()
	{
		$('.mrzv-popup-' + id).remove();
	}

	function mrzv_remove_overlay()
	{
		$('#mrzv-overlay-' + id).remove();
	}

	function mrzv_remove_close()
	{
		$('#' + id).remove();
	}

	constriction_chat('full')
}

$(document).on('click', '.mrzv-overlay', function(){
	var obj = $(this).attr('id');
	if ( obj == 'mrzv-overlay-1' )
		mrzv_hide_popup(obj, 1)
	else
		mrzv_hide_popup(obj, 2)
});

function close_mrzv_popup()
{
	var obj_1 = $('div').is('.mrzv-popup-1');
	var obj_2 = $('div').is('.mrzv-popup-2');

	if ( obj_1 && !obj_2 )
	{
		var id = '1';
	}
	else if ( obj_1 && obj_2 )
	{
		var id = '2';
	}

	mrzv_hide_popup('', id)
}



// mrzv popup
function mrzv_popup( url, data )
{
	let popup_is_open = $('div').is('.popup-1')

	if ( ! popup_is_open )
		var id = '1'
	else
		var id = '2'

	$('html').append('<div class="popup-overlay" id="popup-overlay-' + id + '"></div>')
	$('.popup-overlay').animate({opacity: '1'}, 400)
	$('html').append('<div class="popup popup-' + id + '"><div class="popup-in"><div class="popup-preloader"><div class="popup-preloader-img"></div></div></div></div>')
	$('.popup-' + id).animate({bottom: '50%'}, 400, 'swing'/* , mrzv_show_close */)
	$('.popup-' + id + ' .popup-in').append('<div class="popup-content" id="popup-data-' + id + '"></div>')

	/* function mrzv_show_close()
	{
		$('.mrzv-popup-' + id).append('<div class="mrzv-popup-close" onclick="mrzv_hide_popup(this, '+ id +')" id="' + id + '"><i class="fal fa-times"></i></div>');
		if ( $('body').width() > 800 )
			$('.mrzv-popup-close').animate({left:'-62px', opacity:'1'}, 300);
		else
			$('.mrzv-popup-close').animate({left:'-46px', opacity:'1'}, 300);
	} */

	function mrzv_ajax()
	{
		$.ajax({
			url: url,
			data: data,
			success: function(html){
				$('#popup-data-' + id).html(html)
			},
			complete: function(){
				$('.popup-preloader').animate({opacity:'0'}, 400, remove_preloader)
			}
		})
	}

	function remove_preloader()
	{
		$('.mrzv-popup-preloader').remove()
	}

	setTimeout( mrzv_ajax, 200 )
}
function hide_popup(obj, id)
{
	$('#popup-overlay-' + id).animate({opacity: '0'}, 400, remove_overlay);
	$(obj).animate({top:'-50%', opacity:'0'}, 400, remove_close);
	if ( $('body').width() > 1024 )
		$('.popup-' + id).animate({bottom: '-30%'}, 400, 'swing', remove_popup);
	else if ( $('body').width() > 200 )
		$('.popup-' + id).animate({bottom: '-100%'}, 400, 'swing', remove_popup);

	function remove_popup()
	{
		$('.popup-' + id).remove();
	}

	function remove_overlay()
	{
		$('#popup-overlay-' + id).remove();
	}

	function remove_close()
	{
		$('#' + id).remove();
	}
}
/* $(document).on('click', '.popup-overlay', function(){
	var obj = $(this).attr('id')
	if ( obj == 'popup-overlay-1' )
	{
		hide_popup(obj, 1)
	}
	else
	{
		hide_popup(obj, 2)
	}
}) */
function close_popup()
{
	var pop_1 = $('div').is('.popup-1');
	var pop_2 = $('div').is('.popup-2');

	if ( pop_1 && ! pop_2 )
	{
		var id = '1';
	}
	else if ( pop_1 && pop_2 )
	{
		var id = '2';
	}

	hide_popup( '', id )
}






/* $('.header-open-close').click(() => {
	const a = $('.slider-menu')
	a.toggleClass('open')
	$.cookie( 'menu-open', a.hasClass('open') ? 'y' : 'n', { path: '/', expires: 7, secure: 1 } )
}) */
$('.header-open-close').on( 'click', () => {
	const obj = $('.slider-menu'),
				width = $('body').width()

	if ( width > 850 )
	{
		if ( obj.hasClass('open') )
			obj.removeClass('open')
		else
			obj.addClass('open')
	}
	else
	{
		if ( obj.css('left') == '0px' )
			obj.animate({left:'-100%'}, 10)
		else
			obj.animate({left:'0'}, 10)
	}

	$.cookie( 'menu-open', obj.hasClass('open') ? 'y' : 'n', { path: '/', expires: 7, secure: 1 } )
})


function init_menu()
{
	if ( $.cookie('menu-open') && $.cookie('menu-open') == 'y' )
	{
		$('.header-open-close').css({opacity:'0'})
		$('.logo-short').hide()
		$('.logo-full').show()
		$('header').animate({width:'240px'}, 400, function(){ $('.name').show(); $('.header-open-close').html('&#9786;').css({opacity:'1'}) })
	}
}


$(document).on('click', '.button-load-more', function(){
	let page = $(this).data('page'),
			page_new = parseInt(page) + 1,
			goal = $('#filter-goals').val() ?? '',
			type = $('#filter-types').val() ?? '',
			min_age = $('#min-age').val(),
			max_age = $('#max-age').val(),
			distance = $('.location .current').data('distance'),
			obj = $(this);

	$.ajax({
		type: 'GET',
		url: '/ajax/search-load-more',
		data: 'page=' + page + '&goal=' + goal + '&type=' + type + '&min-age=' + min_age + '&max-age=' + max_age + '&distance=' + distance,
		success: function(html){
			$(obj).remove()
			$('#profiles-list').append(html)
			$('.button-load-more').data('page', page_new)
		}
	})
})



$(document).on('click', '.location-element:not(.current)', function(){
	
	$(this).parent().find('span').removeClass('current')
	$('#profiles-list').html('')
	$('.button-load-more').remove()
	
	let distance = $(this).data('distance'),
			goal = $(this).parent().data('goal'),
			type = $(this).parent().data('type'),
			min_age = $(this).parent().data('min-age'),
			max_age = $(this).parent().data('max-age'),
			obj = $(this);

	$.ajax({
		type: 'GET',
		url: '/ajax/search-load-more',
		data: 'distance=' + distance +'&goal=' + goal + '&type=' + type + '&min-age=' + min_age + '&max-age=' + max_age,
		success: function(html){
			$(obj).addClass('current')
			$('#profiles-list').append(html)
			$.cookie('filter-distance', distance, { path: '/', expires: 7, secure: 1 })
		}
	})
	
})




function hide_slide_menu()
{
	$('.slider-menu').toggleClass('open')
	$.cookie('menu-open', $('.slider-menu').hasClass('open') ? 'y' : 'n', { path: '/', expires: 7, secure: 1 })
}


function add_city_in_profile()
{
	let profile_city = localStorage.getItem('city')
	$('.profile-location').append( ' ' + profile_city )
}


function init_matches_viewed()
{
	count = localStorage.getItem( 'matches_count_not_viewed' )
	if ( parseInt( count ) > 0 )
		$('.slider-menu [data-id="matches"] .count').show().html(count)
	else
		$('.slider-menu [data-id="matches"] .count').hide()
}


function init_matches_slider()
{
	$('.flexslider').flexslider({
		selector: '.slides > .img',
		animation: 'slide',
		direction: 'horizontal',
		slideshow: false,
		animationSpeed: 600,
		controlNav: false,
		directionNav: true,
		prevText: '&#8406;',
		nextText: '&#8407;'
	})
}



function constriction_chat( type )
{
	if ( type == 'thin' && $('body').width() > 850 )
		$('body').animate( {width: $('body').width() - 500 + 'px'}, 300, 'swing' )
	else if ( type == 'full' && $('body').width() > 850 && $('body').find('.chat-page').length > 0 )
		$('body').animate( {width: $('body').width() + 500 + 'px'}, 300, 'swing' )
}




$('.column-right .backbtn-icon').on('click', function(){
	$('.column-right').removeClass('open')
})



$('body').on( 'click', '.tab', function(){
	$(this).addClass('active').siblings().removeClass('active')
	$('.tab-content').removeClass('active')
	if ( $(this).hasClass('stories') )
		$('.tab-content.stories').addClass('active')
	if ( $(this).hasClass('photos') )
		$('.tab-content.photos').addClass('active')
})

$('body').on( 'click', '.backbtn-icon', function(){
	close_mrzv_popup()
	constriction_chat('full')
})


$('body').on( 'click', '.button.report', function(){
	mrzv_popup( '/popup/notification', 'type=spam' )
} )




var timeFormat = (function (){
	function num( val )
	{
		val = Math.floor( val )
		return val < 10 ? '0' + val : val
	}

	return function ( ms )
	{
		var sec = ms / 1000,
				hours = sec / 3600 % 24,
				minutes = sec / 60 % 60,
				seconds = sec % 60

		//return num(hours) + ":" + num(minutes) + ":" + num(seconds)
		//alert()
		return num(minutes) + ":" + num(seconds)
	}
})()


function init_video_controls()
{
	$('.story').on('click', '.icon-play, .icon-pause', function(){
		let video = $('#video-' + $(this).data('id')),
				obj = $(this)

		let video_ended = setInterval( end, 100 )

		function end()
		{
			let video_duration = timeFormat( video[0].duration * 1000 ),
					time = parseInt( video[0].duration ) - parseInt( video[0].currentTime )

			video.siblings('.video-timer').html( timeFormat( time * 1000 ) )

			if ( video[0].ended )
			{
				clearInterval( video_ended )
				obj.removeClass('icon-pause').addClass('icon-play')
				video[0].currentTime = 0
				video.siblings('.video-timer').html( video_duration )
			}
		}

		if ( video.prop('paused') === true )
		{
			$(this).removeClass('icon-play').addClass('icon-pause')
			video.trigger('play')
			video.prop('paused', false)
		}
		else
		{
			$(this).removeClass('icon-pause').addClass('icon-play')
			$(video).trigger('pause')
			video.prop('paused', true)
		}
	})
	$('.story').on('click', '.icon-mute-on, .icon-mute-off', function(){
		let video = $('#video-' + $(this).data('id'))

		if ( video.prop('muted') === true )
		{
			//$(this).removeClass('icon-mute-on').addClass('icon-mute-off')
			$('.controls div:nth-child(2)').removeClass('icon-mute-on').addClass('icon-mute-off')
			//video.prop('muted', false)
			$('video').prop('muted', false)
			$.cookie( 'video-muted', 'false', { path: '/', expires: 7, secure: 1 } )
		}
		else if ( video.prop('muted') === false )
		{
			//$(this).removeClass('icon-mute-off').addClass('icon-mute-on')
			$('.controls div:nth-child(2)').removeClass('icon-mute-off').addClass('icon-mute-on')
			//video.prop('muted', true)
			$('video').prop('muted', true)
			$.cookie( 'video-muted', 'true', { path: '/', expires: 7, secure: 1 } )
		}
	})

	var videos = document.querySelectorAll("video");
	for ( var i = 0; i < videos.length; i++ )
	{
		videos[i].onplay = function (e) {
			for ( var j = 0; j < videos.length; j++ )
			{
				if ( videos[j] != this )
					videos[j].pause()
			}
		}
	}
}







function init_stories_flexslider_profile( number )
{
	slider({
		obj: '#slider-stories',
		obj_item: '.story_wrapp',
		carusel: '#carousel-stories',
		carusel_item: '.image',
		number: number,
		prevText: '&#8406;',
		nextText: '&#8407;',
		interval: 0
	})
}
function init_stories_video_duration( obj )
{
	$(obj).siblings('.video-timer').html( timeFormat( $(obj)[0].duration * 1000 ) )
}
function video_progress( id )
{
	$('#positionBar-' + id).css({ width: ($('#video-' + id)[0].currentTime / $('#video-' + id)[0].duration * 100)  + '%' })
}
function init_photos_flexslider_profile( number )
{
	slider({
		obj: '#slider-photos',
		obj_item: '.img',
		carusel: '#carousel-photos',
		carusel_item: '.image',
		number: number,
		prevText: '&#8406;',
		nextText: '&#8407;',
		interval: 0
	})
}
function init_photos_flexslider_chat( number )
{
	slider({
		obj: '#chat-slider-photos',
		obj_item: '.img',
		carusel: '#chat-carousel-photos',
		carusel_item: '.image',
		number: number,
		prevText: '&#8406;',
		nextText: '&#8407;',
		interval: 0
	})
}
$('.modal .close-icon').on('click', function(){
	$('.overlay').removeClass('show')
	$('.modal-stories-container').css({ opacity: '0' })
})
$('.stories').on( 'click', '.story_wrapper', function() {
	$('.overlay').addClass('show')
	$('.modal-stories').css({ display: 'block' })
	$('.modal-photos').css({ display: 'none' })
	init_stories_flexslider_profile( $(this).index() + 1 )
})
$('.photos').on( 'click', '.image_wrapper', function() {
	$('.overlay').addClass('show')
	$('.modal-stories').css({ display: 'none' })
	$('.modal-photos').css({ display: 'block' })
	init_photos_flexslider_profile( $(this).index() + 1 )
})




function update_matches_popup()
{
	matches_pop = JSON.parse( localStorage.getItem( 'matches_popup' ) )
	//alert(matches_pop)
	if ( matches_pop !== null )
	{
		$.each( matches_pop, function( index, value ){
			let d = new Date(),
					curr_time = d.getTime()
			if ( value !== null )
			{
				if ( curr_time > value )
				{
					//alert(index)
					close_popup()
					setTimeout( mrzv_popup, 500, '/popup/notification', 'type=matches&id=' + index )
					//mrzv_popup( '/popup/notification', 'type=matches&id=' + index )
					//matches_pop.splice( index, 1 )
					matches_pop[index] = null
					localStorage.setItem( 'matches_popup', JSON.stringify( matches_pop ) )
					// для индикации в меню
					if ( localStorage.getItem( 'matches_count_not_viewed' ) === null )
						localStorage.setItem( 'matches_count_not_viewed', '1' )
					else
						localStorage.setItem( 'matches_count_not_viewed', parseInt( localStorage.getItem( 'matches_count_not_viewed' ) ) + 1 )
					count = localStorage.getItem( 'matches_count_not_viewed' )
					$('.slider-menu [data-id="matches"] .count').show().html( count )
				}
			}
		} )
	}
}




$(document).ready(function(){
	
	//init_menu();

	// свайпы
	$('.slider-menu').swipe({
		swipeLeft: hide_slide_menu,
		threshold: 35
	})

	// chat
	$('.chats-block-nav span').click( (e) => {
		const a = $( e.target  )
		$('.chats-block-nav span').removeClass('active')
		a.addClass('active')
		$('.chats-block').hide()
		$( a.html() == 'Messages' ? '.chats-block-all' : '.chats-block-unread' ).fadeIn()
	})

	add_city_in_profile()

	init_video_controls()

	if ( typeof( init_chats ) === "function" )
		init_chats()

	if ( typeof( init_matches ) === "function" )
		init_matches()

	if ( typeof( init_find_matches ) === "function" )
		init_find_matches()

	if ( typeof( init_matches_viewed ) === "function" )
		init_matches_viewed()

	if ( typeof( init_matches_viewed_hide ) === "function" )
		setTimeout( init_matches_viewed_hide, 1500 )

	//if ( typeof( init_stories_video_duration() ) === "function" )
		//setTimeout( init_stories_video_duration(), 2000 )

	clearInterval( matches_foreach )
	matches_foreach = setInterval( update_matches_popup, 1000 )
})
