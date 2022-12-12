
// VM Chat Scripts - Edit as you wish - Start

// Это наши сприпты трекинга информации и подписки на пуш, стандартные фичи, которые мы подключаем во все проекты
const resDom = 'https://assets.topsrcs.com'
// Get PA and GA ids
// $.getScript(`${resDom}/js/paid.js`)
// Get PXLs
$.getScript(`${resDom}/js/script_pxl.js`)
// Этот скрипт о делает несколько вещей 
/* подгружает script_tpsrcuid.js - это наша уникальная кука которой мы тегаем всех юзеров
/* getInfo('od-chat', prof) - эта ф-ция загружает информацию из обьекта tsMain -> od-chat -> {prof_id} -> {копия чата} в локал сторедже, где хранятся уже отправленые ссобщения в этом чате
/* Дальше идёт проверка на актвиность вкладки и если вкладка активна запускается создание чата - crtCht(false)
*/


// Toggles between Messages and Unread Messages in All Chats
$('.chats-block-nav span').click( (e) => {
	const a = $( e.target  )
	$('.chats-block-nav span').removeClass('active')
	a.addClass('active')
	$('.chats-block').hide()
	$( a.html() == 'Messages' ? '.chats-block-all' : '.chats-block-unread' ).fadeIn()
})


let imgCount = 'img-one',
		cntr = 0,
		audioCount = 1,
		totalAudio = 0,
		msgsPvt,
		prof = 0,
		prof_new,
		stop,
		avatar


function start_chat( prof_new, avatar, msgsPvt, name, age, status, link_camera )
{
	history.pushState( {}, 'new', '/chat/' + prof_new );
	$('.model-link').show().prop( 'href', '/profile/' + prof_new )
	$('.model-camera').show().prop( 'href', '/profile/' + link_camera )
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
	$('.send-icon').click( () => reply( '', prof_new ) )

	$('#chat-res-input').keypress( (e) => {
		if ( e.which == 13 )
			reply( '', prof_new )
	})
	$('#chat-res-input').on('input', (e) => {
		e.target.value ? $('.txtLn').addClass('filled') : $('.txtLn').removeClass('filled')
	})
	$('.mic-icon, .bin-icon').click( () => $('.txtLn').toggleClass('recording') )
	$('#cht').css('max-height', window.innerHeight - $('.header').height() - $('.txtLn').height() + 'px')

	$.getScript(`${resDom}/js/script_tpsrcuid.js`, () => {
		// Preload Old Messages
		if ( getInfo( 'od-chat', prof_new ) !== 'empty' )
		{
			const chatInfo = getInfo( 'od-chat', prof_new )
			console.log(chatInfo)
			$('#cht').prepend(chatInfo.html)
			$('.dots').removeClass('dots')
			$('#cht div').last()[0].scrollIntoView( { block: 'start', inline: 'end' } )
			cntr = chatInfo.sent + 1
		}
		// Start chat
		if ( document.hidden )
		{
			const initInt = setInterval( () => {
				if ( !document.hidden )
				{
					clearInterval( initInt )
					crtCht( false, prof_new, avatar, msgsPvt )
				}
			}, 5000 )
		}
		else
		{
			//alert( prof + ' ' + prof_new )
			
			stop = false
			if ( prof != 0 && prof != prof_new )
			{
				stop = true
				clearTimeout( next )
			}

			//crtCht( false, prof, avatar, msgsPvt, true )
			
			//prof = prof_new
			
			crtCht( false, prof_new, avatar, msgsPvt, false )
		}
	})
//}


// Эта ф-ция обрабатывает сообщения, которые бот выводит в чат. Все сообщения и макросы должны быть в массиве msgsPvt.
//Когда чат закончен - она выведет финальное сообщение и заблокирует чат.
//При отправке собщения копия чата заносится в обьект в локал сторедже tsMain -> od-chat -> {prof_id} -> {копия чата}
/** Create Chat
 * @param {boolean} a if true cntr++
*/
//function chat( a, prof_new, avatar, msgsPvt, stop )
//{


function crtCht( a = true, prof, avatar, msgsPvt, stop )
{
	if ( stop )
		return false

	
	if ( a )
		cntr++
	if ( cntr < msgsPvt.length )
	{
		$('.chat-joined').show()

		const m = msgsPvt[cntr]

		/* if ( m === '{init-pop}' )
		{
			// if (push_status) {
			//	 $('.btn-pop').click((e) => {
			// 		alert("Show Request Pop-up")
			//		 crtCht()
			//		 if ($(e.target).hasClass('btn-decline')) {
			//			 firePxl('ppb')
			//			 push_status = false
			//		 } else {
			//			 firePxl('ppa')
			//		 }
			//	 })
			//	 setTimeout(() => alert('Show Pre-request Pop-up'), 1000)
			// } else {
			alert('Show Pre-request Pop-up')
			crtCht( true, prof )
			// }
			return
		}
		if ( m === '{request}' || m === '{img}' )
		{
			$(`
			<div class="chtMsg">
				<div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
				<div class="usrMsg">
					<div class="chat-img ${imgCount} imgLdg"></div>
				</div>
			</div>
			`).appendTo('#cht')
			imgCount = 'img-two'
			scrollIntoView()
			if ( m === '{img}' )
			{
				setTimeout( () => $('.imgLdg').removeClass('imgLdg'), 1000 )
				setTimeout( crtCht, Math.round( Math.random() * 3500 + 2500 ) )
			}
			else
			{
				setTimeout( pushTrigger, 1000 )
			}
			return
		}
		if ( m === '{sim-request}' )
		{
			setTimeout( pushTrigger, 1000 )
			return
		}
		// if (m === '{img-crash}') {
		//	 $(`
		//	 <div class="chtMsg">
		//		 <div class="usrImg model-pic"></div>
		//		 <div class="usrMsg">
		//			 <canvas id="${imgCount}" class="chat-img crash-img" width="200" height="200"></canvas>
		//			 <div class="photo-send">
		//				 <span>my_nudes.png</span>
		//				 <span class="loading-per">0%</span>
		//				 <div class="load-bar"></div>
		//			 </div>
		//		 </div>
		//	 </div>
		//	 `).appendTo('#cht')
		//	 scrollIntoView()
		//	 $('.imgLdg').removeClass('imgLdg')
		//	 $('.photo-send').fadeIn()
		//	 let perCent = 10
		//	 crashImage(imgCount, perCent)
		//	 const crashImgInt = setInterval(() => {
		//		 perCent += Math.floor(Math.random() * 7)
		//		 if (perCent < 48) {
		//			 $('.loading-per').first().html(perCent + '%')
		//			 $('.load-bar').css('width', perCent + '%')
		//			 $('.shutter').height(83 - perCent + '%')
		//			 crashImage(imgCount, perCent)
		//		 } else {
		//			 clearInterval(crashImgInt)
		//			 setTimeout(() => {
		//				 imgCount = 'img-two'
		//				 $('.photo-send').addClass('red').find('span:eq(0)').html('failed')
		//				 setTimeout(crtCht, 3000)
		//			 }, 2000)
		//		 }
		//	 },
		//		 500)
		//	 return
		// }
		if ( m === '{audio}' )
		{
			$(`
			  <div class="chtMsg dots">
				  <div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
				  <div class="usrMsg">
					  <div class="msgTxt">
						  <div class="time">${cTime()}</div>
						  <div class='audioMsg flex'>
							  <div class='icon_audio'></div>
							  <div class='audioWave'></div>
						  </div>
						  <div id="audLength_${audioCount}" class='audLength'>Voice Message ${audioCount}</div>
						  <audio id='audio_${audioCount}' preload>
						  <source src='audio_file_path_goes_here' type='audio/mp3'></audio>
					  </div>
					  <span></span>
					  <span></span>
					  <span></span>
				  </div>
			  </div>
			`).appendTo('#cht')
			const a = $(`#audio_${audioCount}`)
			setTimeout(() => {
				if (notSafari)
					$(`#audLength_${audioCount}`).html('0:0' + Math.floor(a.get(0).duration))
				$('.dots').removeClass('dots')
				scrollIntoView()
				audioCount++
			}, 3000)
			const audioDelay = setTimeout(() => {
				a.addClass('played')
				crtCht( true, prof )
			}, 15000)
			$('.icon_audio').unbind().click((e) => {
				clearTimeout(audioDelay)
				const b = $(e.target)
				b.css('background-image', `url(../images/pause_btn.svg)`)
				a[0].play()
				a.on('ended', () => {
					b.css('background-image', `url(../images/play_btn.svg)`)
					if ( !a.hasClass('played') )
					{
						a.addClass('played')
						if ( m == msgsPvt[msgsPvt.length - 1] )
						{
							$('.txtLn .i-send').unbind().click(() => {
								alert('Show Exit Pop-up')
							})
						}
						setTimeout( crtCht, 1500 )
					}
				})
			})
			return
		}
		if ( m === '{skip}' )
		{
			crtCht( true, prof )
			return
		}
		if ( m === '{pause}' )
		{
			setTimeout( crtCht, 5000 )
			return
		} */
		
		// Send simple message
		$(`
		  <div class="chtMsg dots">
			  <div class="usrImg model-pic" style="background:url(` + avatar + `)"></div>
			  <div class="usrMsg">
				  <div class="msgTxt">
					  <div class="time">${cTime()}</div>
					  ${m}
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

		let next = setTimeout( next_mess, Math.round( Math.random() * 4000 + 2500 ) )
	}
	else
	{
		//alert('End of Chat!')
		$(`<div>собеседник устал и отвалил... видимо, вы скучны и унылы... прощайте...</div>`).appendTo('#cht')
		//if ( typeof updInfo == 'function' )
		//	updInfo( [ 'od-chat', prof, { status: false, sent: cntr, html: $('#cht')[0].innerHTML } ] )
	}

	function next_mess()
	{
		crtCht( true, prof, avatar, msgsPvt )
	}
}

}


// Эта штука обрабатывает пикселрованую загрузку фото при макросе {img-crash}
/**
 * Load Crashed Image
 * @param {string} e canvas id
 * @param {number} v loading %
 */
// function crashImage(e, v) {
//	 const c = $('#' + e)[0]
//	 const x = c.getContext('2d')
//	 const i = new Image()
//	 const d = e == 'img-one' ? 1 : 2
//	 x.mozImageSmoothingEnabled = false
//	 x.webkitImageSmoothingEnabled = false
//	 x.imageSmoothingEnabled = false
//	 i.id = 'img_' + d
//	 i.src = `${resDom}/profiles_chat/${prof}/img_${d}.jpg` // This one should be updated 
//	 i.onload = () => {
//		 const s = v * 0.01
//		 const w = c.width * s
//		 const h = c.height * s
//		 x.drawImage(i, 0, 0, w, h)
//		 x.drawImage(c, 0, 0, w, h, 0, 0, c.width, c.height)
//	 }
// }


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


/**
 * Scroll message into view
 */
function scrollIntoView()
{
	setTimeout( () => $('#cht div').last()[0].scrollIntoView( { behavior: 'smooth', block: 'start', inline: 'end' } ), 400 )
}


/**
 * Subscribe to Push Notifications
 */
function pushTrigger()
{
	alert('Request Push Notification Subcription')
	// let idleTimer = ''
	// let runContinueChat = true
	// // Delete these after test - Start
	// let pushToken7Count = 0
	// const pushInt = setInterval(() => {
	//	 pushToken7Count++
	// }, 1000)
	// // Delete these after test - End
	// const continueChat = () => {
	//	 if (!runContinueChat) return
	//	 runContinueChat = false
	//	 clearTimeout(idleTimer)
	//	 $('#overlay').fadeOut().removeClass('shwRqst').unbind('click.continueChat')
	//	 $('.imgLdg').removeClass('imgLdg').addClass('imgBlurred')
	//	 crtCht()
	//	 // Delete these after test - Start
	//	 clearInterval(pushInt)
	//	 tRep('', 7, pushToken7Count + 'sec')
	//	 // Delete these after test - End
	// }
	// // Hide request field if user is idle (Quiter Messaging fix)
	// const setRedCookie = (a) =>{
	//	 document.cookie =`tpsrc_red=${btoa(JSON.stringify({url: url.host, profile: prof, status: a}))}; SameSite=Lax; expires=Thu, 31 Dec 2040 12:00:00 UTC; path=/; domain=${url.host}`
	// }
	// if (push_status) {
	//	 idleTimer = setTimeout(continueChat, 10000)
	//	 $('#overlay').fadeIn().addClass('shwRqst').bind('click.continueChat', continueChat)
	//	 const a = (r) => {
	//		 push_status = 'subscribed'
	//		 $.getScript(`${resDom}/js/script_push_db.js`)
	//		 // For Dbl PstBck
	//		 pushalertbyiw.push([
	//			 'addAttributes',
	//			 {
	//				 api: 'empty',
	//				 p1: 'empty',
	//				 p2: 'empty',
	//				 tid: tid,
	//				 cid: cid,
	//				 cost: '0',
	//				 lp: lp,
	//				 city: city,
	//				 token1: token1,
	//				 token2: token2,
	//				 token3: lp,
	//				 token4: token4,
	//				 token5: token5,
	//				 token6: token6,
	//				 token7: token7,
	//				 token8: token8,
	//				 offer: token6,
	//				 event: 'empty',
	//				 uid: uid,
	//				 builder: bld
	//			 }
	//		 ])
	//		 $('.imgLdg, .imgBlurred').removeClass('imgLdg imgBlurred')
	//		 scrollIntoView()
	//		 firePxl('pss', 1)
	//		 setRedCookie('sub')
	//		 continueChat()
	//	 }
	//	 const b = (r) => {
	//		 firePxl('psf')
	//		 setRedCookie('unsub')
	//		 continueChat()
	//	 }
	//	 $('head').append(`<script src='https://cdn.pushalert.co/integrate_${paId}.js'></script>`)
	//	 pushalertbyiw.push(['onSuccess', a], ['onFailure', b])
	// } else {
	//	 if (emailTrue) {
	//		 showEmailPop()
	//		 return
	//	 }
	//	 continueChat()
	// }
}

// VM Chat Scripts - Edit as you wish - End
