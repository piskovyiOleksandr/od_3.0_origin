
					<input type="hidden" id="min-age" value="<?= isset( $_COOKIE['filter-min-age'] ) ? $_COOKIE['filter-min-age'] : $min_max_age_overall['min-age'] ?>" />
					<input type="hidden" id="max-age" value="<?= isset( $_COOKIE['filter-max-age'] ) ? $_COOKIE['filter-max-age'] : $min_max_age_overall['max-age'] ?>" />

					@foreach ( $profiles as $item )
					<div class="element">
						<div class="pic" style="background:url('<?php echo $item['pic'] ?>')"><a href="<?php echo $item['link'] ?>"></a></div>
						<?php// echo $item['id'] ?>
						<?php// echo $item['spot'] ?>
						<div class="name"><?php echo $item['name'] ?>, <?php echo $item['age'] ?></div>
						<?php// echo $item['location'] ?>
						<div class="icons profile-icon"><a href="/profile/<?= $item['id'] ?>"></a></div>
						<div class="icons message-icon"><a href="/chat/<?= $item['id'] ?>"></a></div>
					</div>
					@endforeach

					@if ( $remain > 0 )
					<div class="profile-list-button"><div class="button-load-more transition-03" data-page="1">load more (remain <?php echo $remain ?>)</div></div>
					@endif
					<?php// echo $_SESSION['big-city'] ?>