
			<div class="modal-container slider" id="slider-stories">
				<div class="slides">
					<?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="story_wrapp">
						<div class="story">
							<a href="/profile/<?= $value['profile_id'] ?>" class="story-profile transition-03">
								<div class="avatar-wrapp"><div class="avatar" style="background:url(<?= $value['avatar'] ?>)"></div></div>
								<div class="name"><?= $value['name'] ?></div>
							</a>
							<div class="video-progressbar">
								<div class="positionBar" id="positionBar-<?= $value['id'] ?>"></div>
							</div>
							<video id="video-<?= $value['id'] ?>"
											paused="true"
											<?php if( Cookie::get('video-muted') === 'true' ): ?><?php echo 'muted' ?><?php endif; ?>
											onTimeUpdate="video_progress('<?= $value['id'] ?>')"
											poster=""
											ended=""
											onloadeddata="init_stories_video_duration(this)"
							>
								<source src="<?= $value['src'] ?>" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
							</video>
							<div class="controls">
								<div class="icon-play" data-id="<?= $value['id'] ?>"></div>
								<div class="<?php if( Cookie::get('video-muted') === 'true' ): ?><?php echo 'icon-mute-on' ?><?php elseif( Cookie::get('video-muted') === 'false' || ! Cookie::get('video-muted') ): ?><?php echo 'icon-mute-off' ?><?php endif; ?>" data-id="<?= $value['id'] ?>"></div>
							</div>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
			<div class="modal-footer" id="carousel-stories">
				<div class="flex-viewport" id="nav-btns">
					<?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="slide-nav-bt image">
						<video poster="" paused="true" muted="true">
							<source src="<?= $value['src'] ?>" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
						</video>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>


			<script type="text/javascript">

					chat_count_stories = '<?= count( $stories ) ?>'

				slider({
					obj: '#slider-stories',
					obj_item: '.story_wrapp',
					//carusel: '#carousel-stories',
					//carusel_item: '.image',
					number: <?= $index ?>,
					prevText: '&#8406;',
					nextText: '&#8407;',
					interval: 0
				})

				init_video_controls()
				
				$('#slider-stories').parent().siblings().find('.count-slides').html( chat_count_stories )

			</script>
<?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-chat-stories-modal.blade.php ENDPATH**/ ?>