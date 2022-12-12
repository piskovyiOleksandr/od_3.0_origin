
			<div class="initial-message-wrap">
				<div>There is nothing here yet...</div>
				<div>Send a message</div>
			</div>
			<div id="cht">
				<div class="chat-joined" style="display:none">
					<div class="chat-date">
						<?= date('M d') ?>
					</div>
					<div class="chat-joined-wrap flex">
						<span class="model-pic" style="background:url('<?= $profile["avatar"] ?>')"></span>
						<span class="model-name"><?= $profile["name"] ?></span> has joined chat
					</div>
				</div>
			</div>
			<div class="txtLn">
				<span class="icons photo-icon"></span>
				<span class="icons pic-icon"></span>
				<input id="chat-res-input" type="text" placeholder="Write a message..." />
				<span class="rec-time">0:00:00</span>
				<span class="icons smile-icon"></span>
				<span class="icons mic-icon"></span>
				<span class="icons bin-icon"></span>
				<span class="icons send-icon"></span>
			</div>


			<script type="text/javascript">
				msgsPvt = <?= json_encode( $profile['messages'] ) ?>,
				imgs = <?= json_encode( $profile['chat-images'] ) ?>,
				link = '<?= $profile["link"] ?>'

				start_chat( '<?= $profile["id"] ?>', '<?= $profile["avatar"] ?>', imgs, msgsPvt, link, '<?= $profile["name"] ?>', '<?= $profile["age"] ?>', 'status here', '<?= $profile["id"] ?>' )
			</script>
<?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-chat-item.blade.php ENDPATH**/ ?>