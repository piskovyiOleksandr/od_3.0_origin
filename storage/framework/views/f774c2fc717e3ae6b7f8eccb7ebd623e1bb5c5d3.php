
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Language" content="ru" />

	<title><?php echo $__env->yieldContent( 'title' ); ?></title>

	<link href="<?php echo e(asset('/public/css/app.css')); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo e(asset('/public/css/flexslider.css')); ?>" rel="stylesheet" type="text/css" />

	<script>
		function checkParam(a)
		{
			const b = new URL( window.location.href ).searchParams.get(a);
			return b == '' || b == null ? 'empty' : b
		}

		let params = new URL( window.location.href ).searchParams;
		if ( params.get('token1') )
		{
			let object = {
					'token1': checkParam('token1'),
					'token2': checkParam('token2'),
					'token3': checkParam('token3'),
					'token4': checkParam('token4'),
					'token5': checkParam('token5'),
					'token6': checkParam('token6'),
					'token7': checkParam('token7'),
					'token8': checkParam('token8'),
					'token9': checkParam('token9'),
					'cid': checkParam('cid'),
					'tid': checkParam('tid'),
					'lp': checkParam('lp'),
					'uid': checkParam('uid'),
					'city': checkParam('city'),
					'country': checkParam('country')
			}

			localStorage.setItem( 'object', JSON.stringify( object ) );
			
			let link_params = new URL( window.location.href ).searchParams;
			localStorage.setItem( 'link-params', link_params );
		}

		localStorage.setItem('country', '<?= $_SESSION["user-country"] ?>');
		localStorage.setItem('city', '<?= $_SESSION["user-city"] ?>');
	</script><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/layout-meta.blade.php ENDPATH**/ ?>