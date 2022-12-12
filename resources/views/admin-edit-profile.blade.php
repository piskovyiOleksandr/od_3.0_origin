<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Language" content="ru" />

		<title>Edit profile :: Cats admin</title>

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

			<div class="edit-wrapper profile">
				<h1>Edit profile settings</h1>

				@if ( $profile && count( $profile ) > 0 )
				
				<input type="hidden" id="profile-id" value="<?= $profile['id'] ?>" />

				<div class="edit flex-row">
					<div class="edit-col-name">Edit photo</div>
					<div class="edit-col-content">
						<div class="edit-photo-area">
							<div id="profile-avatar">
								@if ( $profile['avatar'] != '' )
								<div class="pic avatar" style="background:url(<?= $profile['avatar'] ?>)">
									<div class="del" data-type="avatar" data-id="avatar" data-chat="0">&#10005;</div>
								</div>
								@else
								<div class="pic add">
									<input type="file" name="img-avatar" id="img-avatar" />
								</div>
								@endif
							</div>
							
							<div class="photo profile-img" id="profile-imgs">
								<?php $imgs_prof = 0 ?>
								@if ( isset( $profile['imgs-prof'] ) )
								@foreach ( $profile['imgs-prof'] as $key => $value )
								@if ( $value['chat'] == 0 )
								<div class="pic" style="background:url(<?= $value['src'] ?>)">
									<div class="del" data-type="profile-imgs" data-id="<?= $value['id'] ?>" data-chat="0">&#10005;</div>
								</div>
								<?php $imgs_prof++ ?>
								@endif
								@endforeach
								@endif
								@if ( $imgs_prof < 4 )
								<div class="pic add">
									<input type="file" name="img-profile" id="img-profile" />
								</div>
								@endif
							</div>
							<div class="photo chat-img" id="chat-imgs">
								<?php $imgs_chat = 0 ?>
								@if ( isset( $profile['imgs-prof'] ) )
								@foreach ( $profile['imgs-prof'] as $key => $value )
								@if ( $value['chat'] == 1 )
								<div class="pic" style="background:url(<?= $value['src'] ?>)">
									<div class="del" data-type="chat-imgs" data-id="<?= $value['id'] ?>" data-chat="1">&#10005;</div>
								</div>
								<?php $imgs_chat++ ?>
								@endif
								@endforeach
								@endif
								@if ( $imgs_chat < 4 )
								<div class="pic add">
									<input type="file" name="img-chat" id="img-chat" />
								</div>
								@endif
							</div>
							
							<div class="photo stories" id="stories">
								<?php $story = 0 ?>
								@if ( isset( $profile['stories'] ) )
								@foreach ( $profile['stories'] as $key => $value )
								<div class="story">
									<video controls>
										<source src="<?= $value['src'] ?>" type="video/mp4">
										Your browser does not support the video tag.
									</video>
									<div class="del" data-type="story" data-id="<?= $value['id'] ?>">&#10005;</div>
								</div>
								<?php $story++ ?>
								@endforeach
								@endif

								@if ( $story < 4 )
								<div class="pic add">
									<input type="file" name="stories" id="story" />
								</div>
								@endif
							</div>
							
						</div>
						<input type="hidden" name="_token" id="img-profile-token" value="{{ csrf_token() }}">
						<div class="edit-button" id="add-photo">Save</div>
					</div>
				</div>
				<div class="edit flex-row">
					<div class="edit-col-name">Edit profile</div>
					<div class="edit-col-content" data-name="base">
						<div class="input"><div class="input-name">Name</div><input type="text" class="form-profile" name="name" value="<?= $profile['name'] ?>" /></div>
						<div class="input"><div class="input-name">Age</div><input type="text" class="form-profile" name="age" value="<?= $profile['age'] ?>" /></div>
						<div class="textarea"><div class="input-name">Description</div><textarea class="form-profile" name="description"><?= $profile['description'] ?></textarea></div>
						<div class="input"><div class="input-name">Distance</div><input type="text" class="form-profile" name="distance" value="<?= $profile['distance'] ?>" /></div>
						<div class="input"><div class="input-name">Small city</div><input type="checkbox" class="form-profile" name="small_city" <?= $profile['small_city'] == 1 ? 'checked' : '' ?> /></div>
						<div class="select">
							<div class="select-name">Status</div>
							<select class="form-profile" name="status">
								<option value="" <?= $profile['status'] == '' ? 'selected' : '' ?>>choose status</option>
								<option value="new" <?= $profile['status'] == 'new' ? 'selected' : '' ?>>new</option>
								<option value="writes" <?= $profile['status'] == 'writes' ? 'selected' : '' ?>>writes</option>
								<option value="open" <?= $profile['status'] == 'open' ? 'selected' : '' ?>>open</option>
								<option value="verified" <?= $profile['status'] == 'verified' ? 'selected' : '' ?>>verified</option>
							<select>
						</div>
						
						<div class="input"><div class="input-name">Writes first</div><input type="checkbox" class="form-profile" name="writes" <?= $profile['writes'] == 1 ? 'checked' : '' ?> /></div>
						<div class="input"><div class="input-name">Matches</div><input type="checkbox" class="form-profile" name="matches" <?= $profile['matches'] == 1 ? 'checked' : '' ?> /></div>
						<div class="input"><div class="input-name">Action timeout</div><input type="text" class="form-profile" name="action_timeout" value="<?= $profile['action_timeout'] ?>" /></div>
						
						<div class="edit-button">Save</div>
					</div>
				</div>
				<div class="edit flex-row metrics">
					<div class="edit-col-name">Profile metriks</div>
					<div class="edit-col-content">
						<div class="col-50 flex-row"><div class="name">CTR:</div><div class="value"><?= $profile['cr'] ?></div></div>
						<div class="col-50 flex-row"><div class="name">Rating:</div><div class="value"></div></div>
						<div class="col-50 flex-row"><div class="name">Success FO/SO/BO rate:</div><div class="value"></div></div>
						<div class="col-50 flex-row"><div class="name">Success push rate:</div><div class="value"></div></div>
						<div class="clear"></div>
						<div class="edit-button">Save</div>
					</div>
				</div>
				<div class="edit flex-row">
					<div class="edit-col-name">Main settings</div>
					<div class="edit-col-content" data-name="type-goal">
						<div class="select">
							<div class="select-name">Looking for</div>
							<select multiple class="form-profile" name="profiles_goal">
								<option value="0">choose goal</option>
								@foreach ( $filter_goal as $goal )
								<option value="<?= $goal['id'] ?>" <?= ( in_array( $goal['id'], $arGoal ) ? 'selected' : '' ) ?>><?= $goal['name'] ?></option>
								@endforeach
							<select>
						</div>
						<div class="select">
							<div class="select-name">Preferences</div>
							<select multiple class="form-profile" name="profiles_type">
								<option value="0">choose type</option>
								@foreach ( $filter_type as $type )
								<option value="<?= $type['id'] ?>" <?= ( in_array( $type['id'], $arType ) ? 'selected' : '' ) ?>><?= $type['name'] ?></option>
								@endforeach
							<select>
						</div>
						
						<div class="edit-button">Save</div>
					</div>
				</div>
				<div class="edit flex-row">
					<div class="edit-col-name">Edit chat</div>
					<div class="edit-col-content" data-name="chat">
						<div class="select">
							<div class="select-name">Choose 1st chat</div>
							<select class="form-profile" name="chat">
								<option value="0">choose chat</option>
								@foreach ( $chats['all'] as $chat )
								<option value="<?= $chat['id'] ?>" <?= ( isset( $chats['current'] ) && ( $chat['id'] == $chats['current'] ) ? 'selected' : '' ) ?>><?= $chat['name'] ?></option>
								@endforeach
							<select>
						</div>
						<div class="edit-button">Save</div>
					</div>
				</div>
				<div class="edit flex-row">
					<div class="edit-col-name">Custom external link</div>
					<div class="edit-col-content" data-name="link">
						<div class="input"><div class="input-name">Link</div><input type="text" class="form-profile" name="link" value="<?= $profile['link'] ?>" /></div>
						<div class="edit-button">Save</div>
					</div>
				</div>
				<div class="edit flex-row">
					<div class="edit-col-name">Custom FO/SO/BO links</div>
					<div class="edit-col-content" data-name="links">
						<div class="input"><div class="input-name">FO</div><input type="text" class="form-profile" value="" /></div>
						<div class="input"><div class="input-name">SO</div><input type="text" class="form-profile" value="" /></div>
						<div class="input"><div class="input-name">BO</div><input type="text" class="form-profile" value="" /></div>
						<div class="edit-button">Save</div>
					</div>
				</div>

				@else
				Что-то пошло не так...
				@endif

			</div>
		</div>
		
		<footer>
			admin
		</footer>
	</body>

	<script src="{{ asset('/public/js/jquery.3.6.0.js') }}" type="text/javascript" defer></script>
	<script src="{{ asset('/public/js/admin.js') }}" type="text/javascript" defer></script>
</html>
