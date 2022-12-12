
<script src="/js/ion.slider.js" defer></script>
<link rel="stylesheet" href="/css/ion.rangeSlider.min.css">


<input type="hidden" id="min-age-overall" value="<?= $min_max_age_overall['min-age'] ?>" />
<input type="hidden" id="max-age-overall" value="<?= $min_max_age_overall['max-age'] ?>" />


<div class="filter">
	<div class="header">
		<span class="mrzv-popup-close" onclick="mrzv_hide_popup(this, 1)">&#10005;</span> Filter
	</div>
<?php
//echo '<pre>';print_r($min_max_age);echo '</pre>';
?>
	<div class="title">Who are looking for ?</div>

	<?php if( count( $filter_goal ) > 0 ): ?>
	<div class="select">
		<div class="select-title">I'm looking for</div>
		<select id="filter-goals">
			<option value="0">choose goal</option>
			<?php foreach ( $filter_goal as $goal ) { ?>
			<option value="<?= $goal['id'] ?>" <?= isset( $_COOKIE['matches-filter-goal'] ) ? ( $_COOKIE['matches-filter-goal'] == $goal['id'] ? 'selected' : '' ) : '' ?>><?= $goal['name'] ?></option>
			<?php } ?>
		</select>
	</div>
	<?php endif; ?>
	<?php if( count( $filter_type ) > 0 ): ?>
	<div class="select">
		<div class="select-title">Preferenses</div>
		<select id="filter-types">
			<option value="0">choose type</option>
			<?php foreach ( $filter_type as $type ) { ?>
			<option value="<?= $type['id'] ?>" <?= isset( $_COOKIE['matches-filter-type'] ) ? ( $_COOKIE['matches-filter-type'] == $type['id'] ? 'selected' : '' ) : '' ?>><?= $type['name'] ?></option>
			<?php } ?>
		</select>
	</div>
	<?php endif; ?>

	<div class="range-slider">
		<div class="age">
			<span class="name">Age</span>
			<input class="age-min" value="<?= $_GET['min-age'] ?>" /> - <input class="age-max" value="<?= $_GET['max-age'] ?>" />
		</div>
		<input type="text" class="js-range-slider" value="" />
	</div>

	<div class="filter-others">
			<input type="checkbox" id="" value="" checked /> With photo

			<input type="checkbox" id="" value="" /> Verified user
	</div>
	
	<div class="button filter-apply">To apply</div>
	
</div>


<script src="/js/filter-matches.js" defer></script>
<?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/ajax-load-filter-matches.blade.php ENDPATH**/ ?>