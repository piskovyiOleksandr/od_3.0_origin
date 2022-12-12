
if ( typeof jQuery !== 'function' )
{
	const jqr = document.createElement( 'script' )
	jqr.type = 'text/javascript'
	jqr.src = 'https://code.jquery.com/jquery-3.5.1.min.js'
	jqr.setAttribute( 'integrity', 'sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=' )
	jqr.setAttribute( 'crossorigin', 'anonymous' )
	document.getElementsByTagName('head')[0].appendChild( jqr )
}
function initTpsrc()
{
	const cPrm = (e) => {
		const u = new URL( window.location.href )
		return u.searchParams.get(e) === '' || u.searchParams.get(e) === null ? 'empty' : u.searchParams.get(e)
	}
	const res = 'https://assets.topsrcs.com'
	const countryScoped = typeof country == 'undefined' ? cPrm('country') : country
	const dc = decodeURIComponent( document.cookie )
	const ca = dc.split( ';' )
	if ( window.localStorage.getItem( 'tsMain' ) == null )
	{
		window.localStorage.setItem( 'tsMain', JSON.stringify( { permissions:{}, webIds:{}, data:{visits:0} } ) )
	}
	getUID()
	if ( typeof tsm == 'undefined' )
	{
		window.tsm = getInfo( 'data', 'visits' )
		updInfo( [ 'data', 'visits', window.tsm + 1 ] )
	}
	if ( ca.findIndex( (a) => a.trim() == 'tpsrccnst=1' ) == '-1' && getInfo( 'permissions', 'cookies' ) !== 'granted' && ( [ 'empty','AL','AD','AM','AT','BY','BE','BA','BG','CH','CY','CZ','DE','DK','EE','ES','FO','FI','FR','GB','GE','GI','GR','HU','HR','IE','IS','IT','LT','LU','LV','M','MC','MK','MT','NO','NL','PO','PT','RO','RU','SE','SI','SK','SM','TR','UA','VA'].includes( countryScoped ) ) )
	{
		$('.ver input').prop('checked',false)
		$('.ver span.material-icons').html('check_box_outline_blank')
		$('.ver .i-check-box').css('background-image',`url(${res}/media/icons/cb_empty.svg)`)
		if( ca.findIndex( (a) => a.trim() == 'tpsrccnst=0' ) == '-1' || getInfo( 'permissions', 'cookies' ) == 'empty' )
		{
			setTimeout( ()=> {
				$.post(
					`${res}/php/db_uc.php`,
					{ uid:uid, uip:typeof uip == 'undefined' ? cPrm('uip') : uip, country:countryScoped, consent:0, url:window.location.href },
					(d) => {
						if ( d == 0 )
						{
							setConsentCookie(0)
							updInfo( [ 'permissions', 'cookies', 'pre-consent' ] )
						}
					}
				)
			}, 2000 )
		}
		$('head').append(`
            <link rel="stylesheet" href="${res}/css/style_cookies.css"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        `)
		setTimeout( () => {
			$('body').append(`
                <div class="cookie_block animate__animated">
									<div class="cookie_block_wrap">
										<div class="cookie_txt_wrap">
											We use cookies to provide you with the best experience on our website.
											If you continue to use this site we will assume you are happy with it.
										</div>
										<div class="cookie_btn_wrap">
											<div class="cookie_btn_container">
												<div class="cookie_block_consent">OK</div>
												<div class="cookie_block_show_pp">Privacy Policy</div>
											</div>
										</div>
									</div>
									<div class="cookie_block_close"></div>
								</div>
								<div class="cookie_overlay">
									<div class="cookie_overlay_close"></div>
									<div class="cookie_policy">
										<div class="cookie_title">What are cookies and tracking technologies?</div>
										<p>
											Cookies are small text files which are transferred to your computer or mobile when you visit a website or app.
											There are also similar pieces of tracking information we collect.
										</p>
										<div class="cookie_title">Why do we use cookies and other tracking?</div>
										<p>To do a few different things:</p>
										<ul>
											<li> to remember information about you, so you don't have to give it to us again. And again. And again </li>
											<li> to keep you signed in, even on different devices </li>
											<li> to help us understand how people are using our services, so we can make them better </li>
											<li> to deliver advertising to on our websites </li><li> to find out if our emails have been read and if you find them useful </li>
										</ul>
										<div class="cookie_title">What are the types of cookies?</div>
										<p> We also use functional, performance and advertising cookies to make your experience more enjoyable. You can delete all of them following these steps: </p>
										<ul>
											<li> If your are using Chrome - <a href="https://support.google.com/accounts/answer/32050?co=GENIE.Platform%3DDesktop&hl=en" target="_blank">Instructions</a> </li>
											<li> If your are using Safari - <a href="https://support.apple.com/en-gb/HT201265" target="_blank">Instructions</a> </li>
										</ul>
										<p>
											Bear in mind there are some other cookies out there from other companies.
											These "third-party cookies" might track how you use different websites, including ours.
											For example, you might get a social media company’s cookie when you see the option to share something.
											You can turn them off, but not through us.
										</p>
										<div class="cookie_title">How do cookies last?</div>
										<p>
											Some are erased when you close the browser on your website or app.
											Others stay longer, sometimes forever, and are saved onto your device so that they’re there when you come back.
											However, you can delete them manually following the steps listed above.
										</p>
										<div class="cookie_title">What types of personal information does our website collect?</div>
										<p>
											Information that you give us. We might ask for your name and contact details, your date of birth, depending on what you're doing.
											When you register for our services we ask for some personal information, like your email address and age.
										</p>
										<div class="cookie_title">Device information</div>
										<p>
											We automatically collect some technical information from your devices and web browsers.
											This might include: IP (internet protocol) address User Agent Info (browser version, device type, etc.)
										</p>
									</div>
								</div>
            `)
			$('.cookie_block').toggleClass('animate__fadeInUp').css('display','flex')
			$('.cookie_block_consent').click( () => {
				$('.cookie_block').toggleClass('animate__fadeInUp animate__fadeOutDown')
				$.post(
					`${res}/php/db_uc.php`,
					{ uid:uid, consent:1 },
					() => {
						setConsentCookie(1)
						updInfo( [ 'permissions', 'cookies', 'granted' ] )
					}
				)
			})
			$('.cookie_block_show_pp').click( () => {
				$('.cookie_block').toggleClass('animate__fadeInUp animate__fadeOutDown')
				$('.cookie_overlay').fadeIn()
			})
			$('.cookie_overlay_close').click( () => {
				$('.cookie_overlay').fadeOut()
				$('.cookie_block').toggleClass('animate__fadeOutDown animate__fadeInUp').css('display', 'flex')
			})
		}, 1000)
	}
}

function setConsentCookie(a)
{
	const d = new Date()
	const u = new URL(window.location.href).host
	document.cookie = `tpsrccnst=${a}; expires=${new Date(d.setFullYear(2200)).toUTCString()}; SameSite=Lax; path=/; domain=${u}`
}

function getUID()
{
	const d = new Date()
	const h = new URL(window.location.href).host
	const c = decodeURIComponent(document.cookie).split(';')
	if ( c.find( (a) => a.trim().split('=')[0] == 'tpsrcuid' ) )
		updInfo( [ 'data', 'uid', Number( atob( c.find( (a) => a.trim().split('=')[0] == 'tpsrcuid' ).split('tpsrcuid=')[1] ) ) ] )
	const u = getInfo( 'data', 'uid' ) == 'empty' ? Date.now() + Math.floor( Math.random()*100000 ) : getInfo( 'data', 'uid' )
	updInfo( [ 'data', 'uid', u ] )
	document.cookie = `tpsrcuid=${btoa(u)}; expires=${new Date(d.setFullYear(2200)).toUTCString()}; SameSite=Lax; path=/; domain=${h}`
	window.uid = u
}

function updInfo( o = [] )
{
	const a = JSON.parse( window.localStorage.getItem( 'tsMain' ) )
	o.forEach( (b)=> {
		const c = typeof o[0]== 'object' ? b : o
		! ( c[0] in a ) ? a[c[0]] = {} : ''
		a[c[0]][c[1]] = c[2]
	})
	window.localStorage.setItem( 'tsMain', JSON.stringify( a ) )
}

function getInfo( a = '', b = '' )
{
	const c = JSON.parse( window.localStorage.getItem( 'tsMain' ) )
	if ( typeof c[a] == 'undefined' || typeof c[a][b] == 'undefined' )
		return 'empty'
	return c[a][b]
}

initTpsrc()

