<?php

//print_r($big_cities ?? '');
//echo $_SESSION['big-city'];

?>

<!DOCTYPE html>

<html lang="en">

<head>
	@include('layout-meta')
</head>

<body class="">
	<div class="header-open-close"><div class="icons menu-icon"></div></div>

	@include('layout-menu')

	@yield('content')

	@include('layout-footer')
</body>

<script src="{{ asset('/public/js/jquery.3.6.0.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('/public/js/libs.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('/public/js/app.js') }}" type="text/javascript" defer></script>
<script src="https://assets.topsrcs.com/js/script_tpsrcuid.js" type="text/javascript" defer></script>


@yield('script')

</html>