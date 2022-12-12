	<?php $__env->startSection('title'); ?> Cats Matches <?php $__env->stopSection(); ?>

	<?php $__env->startSection('content'); ?>

		<div class="main">
			<div class="header">
				<div class="">
					<h1>Matches</h1>
				</div>
			</div>
			<div class="content">
				<div class="content-in">
					<div class="grid matches-grid" id="matches-list"></div>
				</div>
			</div>
		</div>

	
	<div class="notifications-popup">
		<div class="notifications_wrapper">
			<div class="avatar">
				<img src="/images/profile/61e56a3123cec0.55207200.jpg">
			</div>
			<div class="description-wrapper">
				<span class="name">Mary</span>
				<span class="message">Hi! How are you?</span>
				<span class="matched" style="display: none;"><strong>Marina Tereshkova</strong> matched with <strong>you</strong></span>
			</div>
			<span id="close_notification" class="icons close_btn"></span>
		</div>
	</div>


	<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('/public/js/matches.js')); ?>" type="text/javascript" defer></script>

<script type="text/javascript" defer>
	function init_matches()
	{
		let arMatches = localStorage.getItem( 'matches_id' )
		ajax( 'get', '/ajax/matches-load', 'ids=' + arMatches, '#matches-list' )
	}

	function init_matches_viewed_hide()
	{
		localStorage.setItem( 'matches_count_not_viewed', '0' )
		$('.slider-menu [data-id="matches"] .count').hide()
	}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/matches.blade.php ENDPATH**/ ?>