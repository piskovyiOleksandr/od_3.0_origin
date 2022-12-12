
			<?php if( $type == 'spam' ): ?>

			<div class="icons close_btn" onclick="close_popup()"></div>
			<div class="title">Spam notification send</div>
			<div class="message">Fucking spamers must die !</div>
			<div class="btn-wrapper flex">
				<div class="button fon" onclick="close_popup()">Ok</div>
			</div>

			<?php elseif( $type == 'matches' ): ?>

			<div class="icons close_btn" onclick="close_popup()"></div>
			<div class="popup-matches">
				<div class="pic" style="background:url('<?= $profile['avatar'] ?>')"><a href="/profile/<?= $profile['id'] ?>"></a></div>
				<div class="name">
					<b><?= $profile['name'] ?>, <?= $profile['age'] ?></b> matched with <b>you</b>.
				</div>
			</div>
			<div class="btn-wrapper flex">
				<div class="button fon"><a href="/profile/<?= $profile['id'] ?>" target="_blank">Her profile</a></div>
			</div>

			<?php elseif( $type == '' ): ?>

			<div class="icons close_btn" onclick="close_popup()"></div>
			<div class="title">...</div>
			<div class="message">...</div>
			<div class="btn-wrapper flex">
				<div class="button fon" onclick="close_popup()">...</div>
			</div>

			<?php endif; ?><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-notifications.blade.php ENDPATH**/ ?>