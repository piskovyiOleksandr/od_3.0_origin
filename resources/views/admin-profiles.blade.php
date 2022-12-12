<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Language" content="ru" />

		<title>Admin</title>

		<link href="{{ asset('/public/css/admin.css') }}" rel="stylesheet" type="text/css" />
	</head>

	<body class="admin">
		<header>

				<nav>
					<a href="/admin" class="transition-03">Главная</a>
					<a href="/admin/profiles" class="transition-03">Профили</a>
					
				<nav>
			
		</header>

		<div class="main">

			<?php// print_r($profiles)?>

			<div class="profiles list">
				<div class="item">
					<div class="pic avatar">Аватар</div>
					<div class="pic profile">Фото профиля</div>
					<div class="pic chat">Фото чата</div>
						
					<div class="name td">Имя, возраст</div>
					<div class="status td">Статус</div>
					<div class="cr td">Рейтинг</div>
					<div class="edit td">Редактировать</div>
				</div>
				@foreach ( $profiles as $key => $item )
				<div class="item">
					<div class="pic avatar" style="background:url(<?= $item['avatar'] ?>)"></div>
					<div class="pic profile">
						@if ( isset( $item['imgs-prof'] ) )
						@foreach ( $item['imgs-prof'] as $key => $value )
						@if ( $value['chat'] == 0 )
						<div class="pic litle" style="background:url(<?= $value['src'] ?>)"></div>
						@endif
						@endforeach
						@endif
					</div>
					<div class="pic chat">
						@if ( isset( $item['imgs-prof'] ) )
						@foreach ( $item['imgs-prof'] as $key => $value )
						@if ( $value['chat'] == 1 )
						<div class="pic litle" style="background:url(<?= $value['src'] ?>)"></div>
						@endif
						@endforeach
						@endif
					</div>
					<div class="name td"><?= $item['name'] ?>, <?= $item['age'] ?></div>
					<div class="status td"><?= $item['active'] ?></div>
					<div class="cr td"><?= $item['cr'] ?></div>
					<div class="edit td"><a href="/admin/profiles/edit/<?= $item['id'] ?>" target="_blank">edit</a></div>
				</div>
				@endforeach
			</div>
		</div>
		
		<footer>
			admin
		</footer>
	</body>

	<script src="{{ asset('/public/js/jquery.3.6.0.js') }}" type="text/javascript" defer></script>
	<script src="{{ asset('/public/js/admin.js') }}" type="text/javascript" defer></script>
</html>