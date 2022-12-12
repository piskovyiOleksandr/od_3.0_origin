
						@if ( count( $profiles ) > 0 )
						@foreach ( $profiles as $item )
						<div class="matches-element" data-id="<?= $item['id'] ?>" data-matches="<?= $item['matches'] ?>" data-timeout="<?= $item['timeout'] ?>" style="z-index:<?= $zindex ?>">
							<div class="header">
								<div class="pic" style="background:url('<?= $item['pic'] ?>')"><a href="<?= $item['link'] ?>"></a></div>
								<div class=""><?= $item['name'] ?>, <?= $item['age'] ?></div>
								<div class=""></div>
							</div>
							<div class="pics flexslider">
								<div class="slides">
									@foreach ( $img as $pic )
									<div class="img" style="background:url(<?php echo $pic ?>)"></div>
									@endforeach
								</div>
								<div class="icon-del transition-03">&#9932;</div>
								<div class="icon-add transition-03"><div class="icons icon-fire"></div></div>
							</div>
							<div class="button link"><a href="<?= $item['link'] ?>">Whatch profile</a></div>
						</div>
						@endforeach
						@else
						<div class="matches-element" style="padding:200px 0;text-align:center;font-size:20px">Все... Киски закончились...</div>
						@endif
						