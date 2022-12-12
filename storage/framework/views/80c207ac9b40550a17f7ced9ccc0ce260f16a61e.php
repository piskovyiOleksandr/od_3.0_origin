
						<?php if( count( $profiles ) > 0 ): ?>
						<?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="matches-element" data-id="<?= $item['id'] ?>" data-matches="<?= $item['matches'] ?>" data-timeout="<?= $item['timeout'] ?>" style="z-index:<?= $zindex ?>">
							<div class="header">
								<div class="pic" style="background:url('<?= $item['pic'] ?>')"><a href="<?= $item['link'] ?>"></a></div>
								<div class=""><?= $item['name'] ?>, <?= $item['age'] ?></div>
								<div class=""></div>
							</div>
							<div class="pics flexslider">
								<div class="slides">
									<?php $__currentLoopData = $img; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="img" style="background:url(<?php echo $pic ?>)"></div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
								<div class="icon-del transition-03">&#9932;</div>
								<div class="icon-add transition-03"><div class="icons icon-fire"></div></div>
							</div>
							<div class="button link"><a href="<?= $item['link'] ?>">Whatch profile</a></div>
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
						<div class="matches-element" style="padding:200px 0;text-align:center;font-size:20px">Все... Киски закончились...</div>
						<?php endif; ?>
						<?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-load-more-profiles-matches.blade.php ENDPATH**/ ?>