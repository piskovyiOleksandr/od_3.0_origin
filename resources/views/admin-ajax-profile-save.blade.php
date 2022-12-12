
					@if ( $block == 'base' )
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
					@elseif ( $block == 'type-goal' )
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
					@elseif ( $block == 'chat' )
						<div class="select">
							<div class="select-name">Choose 1st chat</div>
							<select class="form-profile" name="chat">
								<option value="0">choose chat</option>
								@foreach ( $chats['all'] as $chat )
								<option value="<?= $chat['id'] ?>" <?= ( $chat['id'] == $chats['current'] ? 'selected' : '' ) ?>><?= $chat['name'] ?></option>
								@endforeach
							<select>
						</div>
					@elseif ( $block == 'link' )
						<div class="input"><div class="input-name">Link</div><input type="text" class="form-profile" name="link" value="<?= $profile['link'] ?>" /></div>
					@elseif ( $block == 'links' )
						<div class="input"><div class="input-name">FO</div><input type="text" class="form-profile" value="" /></div>
						<div class="input"><div class="input-name">SO</div><input type="text" class="form-profile" value="" /></div>
						<div class="input"><div class="input-name">BO</div><input type="text" class="form-profile" value="" /></div>
					@endif
						<div class="edit-button">Save</div>