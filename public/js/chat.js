
// VM Chat Scripts - Edit as you wish - Start

// Это наши сприпты трекинга информации и подписки на пуш, стандартные фичи, которые мы подключаем во все проекты
const resDom = 'https://assets.topsrcs.com'
// Get PA and GA ids
// $.getScript(`${resDom}/js/paid.js`)
// Get PXLs
//$.getScript(`${resDom}/js/script_pxl.js`)
// Этот скрипт о делает несколько вещей 
/* подгружает script_tpsrcuid.js - это наша уникальная кука которой мы тегаем всех юзеров
/* getInfo('od-chat', prof) - эта ф-ция загружает информацию из обьекта tsMain -> od-chat -> {prof_id} -> {копия чата} в локал сторедже, где хранятся уже отправленые ссобщения в этом чате
/* Дальше идёт проверка на актвиность вкладки и если вкладка активна запускается создание чата - crtCht(false)
*/


// Toggles between Messages and Unread Messages in All Chats



/* для push подписки */
/* проверяем подходит ли нам браузер (не можем подписать в Сафари) и разрешена ли подписка на пуши Notification.permission должно вернуть dеfault, тогда сможем подписать. */
const notSafari = navigator.vendor !== 'Apple Computer, Inc.' ? true : false
let np = typeof Notification == 'function' ? Notification.permission : 'blocked'
let push_status = notSafari && np == 'default' ? true : false

/* Эти две переменные требует  Push Alert. pushalert_sw_file - это путь к файлу sw_od3.js, о котором мы говорили в пункте 1 */
var pushalert_sw_file = window.location.origin + '/sw_' + window.location.host.split('.')[0] + '.js'
var pushalertbyiw = window.pushalertbyiw || []

/* Это наши стандартные скрипты с айдишками проектов под все домены и рекламными пикселями. функция firePxl() отсюда, кстати */
// Get PushAlert and Google Analytics IDs for the domain
$.getScript('https://assets.topsrcs.com/js/paid.js')
// Get Advertising Pixels 
//$.getScript('https://assets.topsrcs.com/js/script_pxl.js')


//alert( localStorage.getItem( 'object' ) );



let imgCount,
		cntr = 0,
		audioCount = 1,
		totalAudio = 0,
		msgsPvt,
		prof,
		avatar,
		imgs,
		link,
		pushtriggeranswer


function start_chat( prof, avatar, imgs, msgsPvt, link, name, age, status, link_camera )
{
	history.pushState( {}, 'new', '/chat/' + prof );
	//$('.model-link').show().prop( 'href', '/profile/' + prof )
	$('.model-link').show()
	//$('.model-camera').show().prop( 'href', '/profile/' + link_camera )
	$('.model-camera').show().prop( 'href', '#' )
	$('.header-left .model-pic').show().css( 'background', 'url(' + avatar + ')' )
	$('.header-left .model-name').show().html( name + ', ' + age )
	$('.header-left .model-status').show().html( status )

	// Переменые, которые нужны для создания и работы чата
	if ( $('#cht').length )
		$('.initial-message-wrap').hide()

	// Counting Number of audio messages - пока можно скипнуть, но эта штука собирает к-во аудио сообщений которые отсылаются в чате по максросы {audio}
	$.each( msgsPvt, (i, e) => {
		if ( e == '{audio}' )
			totalAudio++
	})

	// Эта вся штука регулирует отправку сообщение пользователем в чат.
	// Для этого полю инпут даём айди #chat-res-input а кнопке отправки сообщения класс .icons.i-send и вешаем на неё ивент листенер.
	// На инпут поле в которое пользователь вводит сообщение вешаем ивент нажатия на кнопку энтер
	$('.send-icon').click( () => reply( '', prof ) )

	$('#chat-res-input').keypress( (e) => {
		if ( e.which == 13 )
			reply( '', prof )
	})
	$('#chat-res-input').on('input', (e) => {
		e.target.value ? $('.txtLn').addClass('filled') : $('.txtLn').removeClass('filled')
	})
	$('.mic-icon, .bin-icon').click( () => $('.txtLn').toggleClass('recording') )
	$('#cht').css('max-height', window.innerHeight - $('.header').height() - $('.txtLn').height() + 'px')

	//$.getScript(`${resDom}/js/script_tpsrcuid.js`, () => {
		// Preload Old Messages
		if ( getInfo( 'od-chat', prof ) !== 'empty' )
		{
			const chatInfo = getInfo( 'od-chat', prof )
			console.log(chatInfo)
			$('#cht').prepend(chatInfo.html)
			$('.dots').removeClass('dots')
			$('#cht div').last()[0].scrollIntoView( { block: 'start', inline: 'end' } )
			cntr = chatInfo.sent + 1
		}
		// Start chat
		//if ( document.hidden )
		//{
		//	const initInt = setInterval( () => {
		//		if ( !document.hidden )
		//		{
		//			//clearInterval( initInt )
		//			crtCht( false, prof, avatar, imgs, msgsPvt, link )
		//		}
		//	}, 5000 )
		//}
		//else
		//{
			crtCht( false, prof, avatar, imgs, msgsPvt, link )
		//}
	//})
}


function crtCht( a = true, prof, avatar, imgs, msgsPvt, link )
{
	let id = $('#chat-id-marker').val()
	
	if ( prof != id )
		return false
	
	if ( a )
		cntr++

	if ( cntr < msgsPvt.length )
	{
		$('.chat-joined').show()

		const m = msgsPvt[cntr]

		if ( ~m.indexOf( '{pause}' ) )
		{
			if ( m === '{pause}' )
			{
				setTimeout( next_mess, 5000 )
				return
			}
			else if ( ~m.indexOf( '{pause}/' ) )
			{
				let t = m.replace( '{pause}/', '' )
				setTimeout( next_mess, t )
				return
			}
		}

		if ( ~m.indexOf( '{link}' ) )
		{
			$(`<div class="outbound-link"></div>`).appendTo('#cht')
			$(`
				<div class="chtMsg">
					<div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
					<div class="usrMsg">
						<div class="msgTxt">
							тыцай сюда <a href="http://` + link + '?' + localStorage.getItem( 'link-params' ) + `">` + link + '?' + localStorage.getItem( 'link-params' ) + `</a>
						</div>
					</div>
				</div>
			`).appendTo('#cht')
			setTimeout( () => {
				$('.dots').removeClass('dots')
				scrollIntoView()
			}, Math.round(Math.random() * (2000 - 1500) + 1500) )
			if ( typeof updInfo == 'function' )
				updInfo( [ 'od-chat', prof, { status: true, sent: cntr, html: $('#cht')[0].innerHTML } ] )

			setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
			return
		}

		if ( m === '{img}' || m === '{imgall}' )
		{
			if ( m === '{img}' )
			{
				imgCount = 'img-one'
				$(`
				<div class="chtMsg">
					<div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
					<div class="usrMsg">
						<div class="chat-img ${imgCount} imgLdg chat-content">
							<div class="pic" data-src="` + imgs[0] + `" style="background:url(` + imgs[0] + `)"></div>
						</div>
					</div>
				</div>
				`).appendTo('#cht')
			}
			else if ( m === '{imgall}' )
			{
				img_count = imgs.length
				//imgCount = 'img-four'
				imgCount = 'img-' + img_count
				$(`
				<div class="chtMsg">
					<div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
					<div class="usrMsg">
						<div class="chat-img imgs ${imgCount} imgLdg chat-content"></div>
					</div>
				</div>
				`).appendTo('#cht')
				$.each( imgs, function( i, v ){
					$(`<div class="pic" data-src="` + v + `" style="background:url(` + v + `)"></div>`).appendTo('.imgs')
				})
			}
			scrollIntoView()
			setTimeout( () => $('.imgLdg').removeClass('imgLdg'), 1000 )

			if ( typeof updInfo == 'function' )
				updInfo( [ 'od-chat', prof, { status: true, sent: cntr, html: $('#cht')[0].innerHTML } ] )

			setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
			return
		}

		if ( m === '{init-pop}' )
		{
			if ( push_status )
			{
				mrzv_popup( '/popup/chat', '' )
				var wait_chat_value = false

				$(document).on( 'click', '.button, .close_btn, .popup-overlay', (e) => {
					// 1. Спрятать поп-ап
					close_popup()

					if ( $(e.target).hasClass('decline') || $(e.target).hasClass('close_btn')  || $(e.target).hasClass('popup-overlay') )
					{
						//firePxl( 'ppb' )
						push_status = false
						// Изменив этот push_status, ты пропустишь макрос {request} в следующем сообщение
					}
					else
					{
						//firePxl( 'ppa' )
					}

					wait_chat_value = true
				})

				let wait_chat = ()=>
				{
					if ( ! wait_chat_value )
					{
						setTimeout( wait_chat, 2000 )
					}
					else
					{
						// 2. Продолжить чат
						setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
						return
					}
				}
				wait_chat()
				return
			}
			else
			{
				/* если не можем подписать на пуш, продолжаем чат */
				setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
				return
			}
		}

		if ( m === '{request}' )
		{
			if ( push_status )
			{
				pushTrigger()
					
				let wait_pushanswer = () =>
				{
					if ( typeof pushtriggeranswer === 'undefined' )
					{
						setTimeout( wait_pushanswer, 2000 )
					}
					else
					{
						setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
						return
					}
				}
				wait_pushanswer()
				
				setTimeout( function() { pushtriggeranswer = false }, 10000 )
				
				return
			}
			else
			{
				setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
				return
			}
		}

		// Send simple message
		$(`
		  <div class="chtMsg dots">
			  <div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
			  <div class="usrMsg">
				  <div class="msgTxt">
					  <div class="time chat-time">${cTime()}</div>
					  <div class="chat-content">${m}</div>
				  </div>
				  <span></span>
				  <span></span>
				  <span></span>
			  </div>
		  </div>
	  `).appendTo('#cht')
		scrollIntoView()
		setTimeout( () => {
			$('.dots').removeClass('dots')
			scrollIntoView()
		}, Math.round(Math.random() * (2000 - 1500) + 1500) )

		if ( typeof updInfo == 'function' )
			updInfo( [ 'od-chat', prof, { status: true, sent: cntr, html: $('#cht')[0].innerHTML } ] )
		/*
		updInfo( [ 'od-chat', prof, {
			status: true,
			sent: cntr,
			messages: {
				cntr: {
					viwed: false,
					html: ''
				}
			}
		} ] )
		*/

		setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
	}
	else
	{
		//alert( 'собеседник устал и отвалил... видимо, вы скучны и унылы... прощайте...' )
		return
	}

	function next_mess()
	{
		crtCht( true, prof, avatar, imgs, msgsPvt, link )
		chat_list_data()
	}
	function chat_list_data()
	{
		let text = msgsPvt[cntr - 1]
		if ( text == '{img}' )
			text = 'Photo'
		else if ( text == '{imgall}' )
			text = 'Photos'
		else if ( text == '{link}' )
			text = 'Link'
		else if ( text == '{request}' || text == '{init-pop}' )
			text = ''
		setTimeout( $('#message-text-' + prof).html( text ), 50 )
		setTimeout( $('#message-time-' + prof).html( cTime() ), 50 )
		if ( cntr < 11 )
			$('#message-count-' + prof).html( cntr )
	}
}



// ещё несколько полезных ф-ция для чата время и проверка гет параметров из ликни 
/**
 * Get Current time
 * @return {string} current time
 */
function cTime()
{
	const d = new Date()
	const m = d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes()
	const h = d.getHours() < 10 ? '0' + d.getHours() : d.getHours()
	return h + ':' + m
}


/**
 * Check query param
 * @param {string} e param name
 * @return {string} param value
 */
function checkParam(e)
{
	return url.searchParams.get(e) === '' || url.searchParams.get(e) === null ? 'empty' : url.searchParams.get(e)
}


/**
 * User's reply
 * @param {string} a message
 */
function reply( a, p )
{
	let t = ''
	if ( ! prof )
		prof = p
	if ( $('#chat-res-input').val() && $('#chat-res-input').val() !== '' )
	{
		t = $('#chat-res-input').val()
		$('#chat-res-input').val('')
	}
	if ( a !== '' && a )
		t = a
	
	if ( t.trim() !== '' )
	{
		const m = `
		<div class="chtMsg">
			<div class="usrMsg right">
			<div class="msgTxt">
				<div class="time">${cTime()}</div>
				${t}
			</div>
			</div>
		</div>`
		// const l = $('.chtMsg').last();
		const l = $('#cht > div').last()
		// if (k.hasClass('chtMsg')) {
		l.hasClass('dots') ? l.before(m) : l.after(m)
		// } else {
		//	 k.after(m);
		// }
		scrollIntoView()
		if ( $('.quick-resp-vis').length )
		{
			qc++
			$('.quick-resp').removeClass('quick-resp-vis')
			setTimeout( crtCht, 1500 )
		}
		if ( typeof updInfo == 'function' )
			updInfo( [ 'od-chat', prof, { status: getInfo('od-chat', prof).status, sent: getInfo('od-chat', prof).sent, html: $('#cht')[0].innerHTML } ] )
	}
}


/* Scroll message into view */

function scrollIntoView()
{
	setTimeout( () => $('#cht div').last()[0].scrollIntoView( { behavior: 'smooth', block: 'end', inline: 'nearest' } ), 300 )
}


/* Subscribe to Push Notifications */

function pushTrigger()
{
	var data = JSON.parse( localStorage.getItem( 'object' ) )
//alert(data)
	var push, wait_push = false;

	// Function that sets cookie with status sub or unsub
	const setRedCookie = (a) => {
		const b = new URL(window.location.href).host
		document.cookie = `tpsrc_red=${btoa(JSON.stringify({url: b, profile: 'ADD PROFILE ID HERE', status: a}))}; SameSite=Lax; expires=Thu, 31 Dec 2040 12:00:00 UTC; path=/; domain=${b}`
	}

	//If we can subscibe to push do the following
	if ( push_status )
	{
		// Executes if user subscribes to Push Notifications
		const a = (r) => {
			$.getScript( 'https://assets.topsrcs.com/js/script_push_db.js' )
			pushalertbyiw.push([
				'addAttributes',
				{
					api: 'empty',
					p1: 'empty',
					p2: 'empty',
					tid: data.tid,
					cid: data.cid,
					cost: '0',
					lp: data.lp,
					city: data.city,
					token1: data.token1,
					token2: data.token2,
					token3: data.lp,
					token4: data.token4,
					token5: data.token5,
					token6: data.token6,
					token7: data.token7,
					token8: data.token8,
					token9: data.token9,
					offer: data.token6,
					event: 'empty',
					uid: data.uid,
					builder: false
				}
			])
			//firePxl( 'pss', 1 )
			setRedCookie( 'sub' )
			// Сюда нужно добавить скрипт, который продолжит выполнение чата
			pushtriggeranswer = true
			wait_push = true
		}

		// Executes if user blocked Push Notifications 
		const b = (r) => {
			//firePxl( 'psf' )
			setRedCookie( 'unsub' )
			// Сюда нужно добавить скрипт, который продолжит выполнение чата
			pushtriggeranswer = false
			wait_push = true
		}

		$('head').append(`<script src='https://cdn.pushalert.co/integrate_${paId}.js'></script>`)
		pushalertbyiw.push( [ 'onSuccess', a ], [ 'onFailure', b ] )
	}
	else
	{
		//Если мы не можем подписать на пуш, то продолжаем чат. Добавь сюда соответсвующую ф-цию
		//return false;
		pushtriggeranswer = false;
		return;
	}

	let wait_chat = () =>
	{
		if ( ! wait_push )
		{
			setTimeout( wait_chat, 2000 )
		}
		else
		{
			return pushtriggeranswer;
		}
	}
	wait_chat()
}

// VM Chat Scripts - Edit as you wish - End



$('#stories-list').on( 'click', '.stories-block-bot-story', function() {
	//ajax( 'GET', '/ajax/chat-stories', 'type=modal&index=' + ( $(this).index() - 1 ), '.modal-stories', '', 0, 'append' )
	ajax( 'GET', '/ajax/chat-stories', 'type=modal&index=' + ( $(this).index() ), '#modal-stories', show_modal_stories, 800, '' )
	$('.overlay').addClass('show')
	$('.modal-photos').css({ display: 'none' })
	$('.modal-stories').css({ display: 'block' })
})
function show_modal_stories()
{
	$('.modal-stories-container').css({ opacity: '1' })
}


// просмотр фото в чате
$('.chat').on( 'click', '.pic', function(){
	let imgs_obj = $(this).parent().find('.pic'),
			index = $(this).index(),
			src

	$('#chat-slider-photos .slides').html('')
	$('#chat-carousel-photos .flex-viewport').html('')

	$.each( imgs_obj, function(){
		src = $(this).data('src')
		$('#chat-slider-photos .slides').append('<div class="img"><img src="' + src + '" /></div>')
		$('#chat-carousel-photos .flex-viewport').append('<div class="image" style="background:url('+src+')"></div>')
	})

	$('.overlay').addClass('show')
	$('.modal-stories').css({ display: 'none' })
	$('.modal-photos').css({ display: 'block' })
	$('.count-slides').html( imgs_obj.length )
	init_photos_flexslider_chat( index + 1 )
})

