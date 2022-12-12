
				@foreach ( $profiles as $item )

				<div class="chats-block-wrap badge-<?= $item['status'] ?> flex" id="chat-list-<?= $item['id'] ?>" onclick="load_chat('<?= $item['id'] ?>')">
					<div class="model-pic" style="background:url(<?= $item['avatar'] ?>)"></div>
					<div class="chats-block-outer-wrap">
						<div class="chats-block-inner-wrap flex">
							<div class="model-name"><?= $item['name'] ?></div>
							<div>
								<span class="chats-block-status icons read-icon"></span>
								<span class="chats-block-time" id="message-time-<?= $item['id'] ?>">00:00</span>
							</div>
						</div>
						<div class="chats-block-inner-wrap flex">
							<span class="chats-blocks-message-txt" id="message-text-<?= $item['id'] ?>">...</span>
							<span class="chats-blocks-message-badge" id="message-count-<?= $item['id'] ?>"></span>
						</div>
					</div>
				</div>
				
				<script>
						if ( getInfo( 'od-chat', '<?= $item["id"] ?>' ) !== 'empty' )
						{
							$('#message-count-' + '<?= $item["id"] ?>').html( getInfo( 'od-chat', '<?= $item["id"] ?>' ).sent + 1 )
							$('#message-text-' + '<?= $item["id"] ?>').html( $( getInfo( 'od-chat', '<?= $item["id"] ?>' ).html ).find('.chat-content').last().html() )
							$('#message-time-' + '<?= $item["id"] ?>').html( $( getInfo( 'od-chat', '<?= $item["id"] ?>' ).html ).find('.chat-time').last().html() )
						}
				</script>

				@endforeach