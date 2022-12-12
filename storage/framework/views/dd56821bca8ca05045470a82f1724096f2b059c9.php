<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Language" content="ru" />

		<title>Settings - Cats Matches</title>

		<link href="<?php echo e(asset('/public/css/app.css')); ?>" rel="stylesheet" type="text/css" />
	</head>

	<body class="">
		<header <?php if( Cookie::get('menu-open') == 'y' ): ?>class="open"<?php endif; ?>>
			<div class="header-open-close">&#9786;</div>
			<div class="header">
				<a href="/" class="logo"><span class="logo-short">CM</span><span class="logo-full">Cats Matches</span></a>
			</div>
			<div class="content">
				<nav>
					<a href="/chat" class="transition-03"><span class="icon ">&#9786;</span><span class="name">All chats</span></a>
					<a href="/matches" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Matches</span></a>
					<a href="/find-matches" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Find Matches</span></a>
					<a href="/search" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Search nearby</span></a>
					<a href="#" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Livecams</span></a>
					<a href="#" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Full Version (free)</span></a>
					<a href="/settings" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Settings</span></a>
					<br />
					<a href="/auth" class="transition-03"><span class="icon ">&#9786;</span><span class="name">register</span></a>
					<br />
					<a href="/" class="transition-03"><span class="icon ">&#9786;</span><span class="name">Admin</span></a>
				<nav>
			</div>
			<div class="footer">
				
			</div>
		</header>

		<div class="main <?php if( Cookie::get('menu-open') == 'y' ): ?><?php echo 'open' ?><?php endif; ?>">
			<div class="header">
				<h1>Settings</h1>
			</div>
			<div class="content">
				<div class="">
					content...
				</div>
			</div>
			<div class="footer">
				&#169; Cats Matches, <?php echo e(date('Y')); ?>

			</div>
		</div>
	</body>

	<script src="<?php echo e(asset('/public/js/jquery.3.6.0.js')); ?>" type="text/javascript" defer></script>
	<script src="<?php echo e(asset('/public/js/app.js')); ?>" type="text/javascript" defer></script>
</html><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/settings.blade.php ENDPATH**/ ?>