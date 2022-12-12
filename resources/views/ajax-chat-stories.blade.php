
								@if ( isset( $stories ) )
								@foreach ( $stories as $key => $value )
								<div class="stories-block-bot-story">
									<video class="stories-block-image">
										<source src="<?= $value['src'] ?>" type="video/mp4">
									</video>
									<div class="stories-block-name"><?= $value['name'] ?>, <?= $value['age'] ?></div>
								</div>
								@endforeach
								@endif