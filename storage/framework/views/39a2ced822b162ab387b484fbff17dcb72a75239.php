	<?php $__env->startSection('title'); ?> Search nearby <?php $__env->stopSection(); ?>

	<?php $__env->startSection('content'); ?>
	<div class="main">
		<div class="header">
			<h1>Search nearby</h1>
		</div>
		<div class="content">
			<div class="content-in">
				<div class="filters">
					<div class="location">
						<div class="location-headers">Location:</div>
						<div class="location-wrap">
							<span>
								<?=
								isset( $_SESSION["user-city"] ) && !empty( $_SESSION["user-city"] ) ? 
								"Are you from <span class='location-current' id='location'>".$_SESSION["user-city"]."</span>?" : 
								"Where are you from?";
								?>
							</span>
							<span class="button change-location mrzv-link-ajax" data-href="/ajax/search-location" onclick="mrzv_popup_ajax(this, '')">
								Change location
							</span>
							<span class="mrzv-link-ajax open-filter icons" data-href="/ajax/search-filter" onclick="mrzv_popup_ajax(this, 'filter-goal=<?= isset($_COOKIE['filter-goal']) ? $_COOKIE['filter-goal'] : 0 ?>&filter-type=<?= isset($_COOKIE['filter-goal']) ? $_COOKIE['filter-type'] : 0 ?>&min-age=<?= isset($_COOKIE['filter-min-age']) ? $_COOKIE['filter-min-age'] : $min_max_age_overall['min-age'] ?>&max-age=<?= isset($_COOKIE['filter-max-age']) ? $_COOKIE['filter-max-age'] : $min_max_age_overall['max-age'] ?>&lang=');"></span>
						</div>
					</div>

					<div class="location">
						<span class="location-list" data-goal="<?= isset($_COOKIE['filter-goal']) ? $_COOKIE['filter-goal'] : 0 ?>" data-type="<?= isset($_COOKIE['filter-goal']) ? $_COOKIE['filter-type'] : 0 ?>" data-min-age="<?= isset($_COOKIE['filter-min-age']) ? $_COOKIE['filter-min-age'] : $min_max_age_overall['min-age'] ?>" data-max-age="<?= isset($_COOKIE['filter-max-age']) ? $_COOKIE['filter-max-age'] : $min_max_age_overall['max-age'] ?>">
							<div class="location-headers">Users near you:</div>
							<span class="location-element <?php if( Cookie::get('filter-distance') == '10' || ! Cookie::get('filter-distance') ): ?><?php echo 'current' ?><?php endif; ?> transition-03" data-distance="10">Up to 10 miles</span>
							<span class="location-element <?php if( Cookie::get('filter-distance') == '5' ): ?><?php echo 'current' ?><?php endif; ?> transition-03" data-distance="5">Up to 5 miles</span>
							<span class="location-element <?php if( Cookie::get('filter-distance') == '1' ): ?><?php echo 'current' ?><?php endif; ?> transition-03" data-distance="1">Up to 1 miles</span>
						</span>
					</div>

				</div>

				<div class="profile-list" id="profiles-list">

					<input type="hidden" id="min-age" value="<?= isset($_COOKIE['filter-min-age']) ? $_COOKIE['filter-min-age'] : $min_max_age_overall['min-age'] ?>" />
					<input type="hidden" id="max-age" value="<?= isset($_COOKIE['filter-max-age']) ? $_COOKIE['filter-max-age'] : $min_max_age_overall['max-age'] ?>" />

					<?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="element">
						<div class="pic" style="background:url('<?php echo $item['pic'] ?>')"><a href="<?php echo $item['link'] ?>"></a></div>
						<div class="name"><?php echo $item['name'] ?>, <?php echo $item['age'] ?></div>
						<div class="icons profile-icon"><a href="/profile/<?= $item['id'] ?>"></a></div>
						<div class="icons message-icon"><a href="/chat/<?= $item['id'] ?>"></a></div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					<?php if( $remain > 0 ): ?>
					<div class="profile-list-button">
						<div class="button-load-more transition-03" data-page="1">load more <?php if( $remain > 0 ): ?>(remain - <?php echo $remain ?>)<?php endif; ?></div>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
	<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/search.blade.php ENDPATH**/ ?>