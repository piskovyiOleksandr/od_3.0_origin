
								<?php if( isset( $stories ) ): ?>
								<?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="stories-block-bot-story">
									<video class="stories-block-image">
										<source src="<?= $value['src'] ?>" type="video/mp4">
									</video>
									<div class="stories-block-name"><?= $value['name'] ?>, <?= $value['age'] ?></div>
								</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-chat-stories.blade.php ENDPATH**/ ?>