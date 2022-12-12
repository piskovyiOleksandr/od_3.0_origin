
	<div class="slider-menu @if( Cookie::get('menu-open') == 'y' )<?php echo 'open' ?>@endif">
		<div class="header">
			<a href="/" class="logo"><span class="logo-short">CM</span><span class="logo-full">Cats Matches</span></a>
			<div class="header-open-close close-icon icons"></div>
		</div>
		<div class="header-open-close slide-icon icons"></div>
		<div class="content">
			<nav>
				<a href="/chat" class="transition-03"><span class="icons all-chats-icon"></span><span class="name">All chats</span></a>
				<a href="/matches" class="transition-03" data-id="matches"><span class="icons matches-icon"></span><span class="name">Matches</span><span class="count transition-03"></span></a>
				<a href="/find-matches" class="transition-03"><span class="icons find-icon"></span><span class="name">Find Matches</span></a>
				<a href="/search" class="transition-03"><span class="icons search-icon"></span><span class="name">Search nearby</span></a>
				<a href="#" class="transition-03"><span class="icons cams-icon"></span><span class="name">Livecams</span></a>
				<hr>
				<a href="#" class="transition-03"><span class="icons full-icon"></span><span class="name">Full Version (free)</span></a>
				<a href="/settings" class="transition-03"><span class="icons settings-icon"></span><span class="name">Settings</span></a>
				<a href="#" class="premium-btn"><span class="icons premium-icon"></span><span class="name">Premium</span></a>
			</nav>
		</div>
		<div class="footer">
			<div class="guest-icon-wrap">
				<div class="icons guest-icon"></div>
			</div>
			<div class="guest-info">
				<div>Guest</div>
				<div>Unknown</div>
			</div>
			<div class="icons dots-icon"></div>
		</div>
	</div>
