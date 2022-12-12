
						<?php $i = 0 ?>
						<?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="single-grid-item">
							<div class="single-grid-wrapper">
								<div class="person-info-wrapper">
									<div class="icon">
										<a href="<?= $item['link'] ?>"><img src="<?= $item['pic'] ?>"></a>
									</div>
									<div class="person-info">
										<span class="name"><?= $item['name'] ?>, <?= $item['age'] ?> <span class="icons icon-fire status"></span></span>
										<span class="city"><?= isset( $_SESSION["user-city"] ) && !empty( $_SESSION["user-city"] ) ? $_SESSION["user-city"] : '' ?></span>
									</div>
									<span class="icons close-icon" data-id="<?= $item['id'] ?>"></span>
								</div>
								<div class="photos-wrapper">
									<span class="count">1/3</span>
									<a href="<?= $item['link'] ?>"><img src="<?= $item['pic'] ?>"></a>
								</div>
								<div class="person-settings">
									<span class="icons icon-like person-setting-btn" data-id="<?= $item['id'] ?>"></span>
									<span class="icons message-icon person-setting-btn"><a href="/chat/<?= $item['id'] ?>"></a></span>
								</div>
							</div>
						</div>
						<?php if( $i == 1 ): ?>
						<div class="single-grid-item">
							<div class="single-grid-wrapper">
								<div class="person-info-wrapper">
									<div class="icon">
										<img src="/images/profile/61e56a3123cec0.55207200.jpg">
									</div>
									<div class="person-info">
										<span class="name">Best match ever by Google</span>
									</div>
									<span class="icons close-icon"></span>
								</div>
								<div class="photos-wrapper">
									<span class="count">1/3</span>
									<img src="/images/profile/61e56a3123cec0.55207200.jpg">
								</div>
								<div class="person-settings">
									<span class="icons icon-like person-setting-btn"></span>
									<span class="icons message-icon person-setting-btn"></span>
									<div class="ads-website">
										<span class="icons world-icon"></span>
										<span class="label">Browse website</span>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php $i++; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
						
						
						
						
						<?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-load-matches.blade.php ENDPATH**/ ?>