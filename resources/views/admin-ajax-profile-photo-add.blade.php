
						@if ( $type != 'avatar' && $type != 'story' )
							@if ( $chat == 0 )
								<?php $imgs_prof = 0 ?>
								@foreach ( $imgs as $img )
								<div class="pic" style="background:url(<?= $img['src'] ?>)">
									<div class="del" data-type="profile-imgs" data-id="<?= $img['id'] ?>" data-chat="0">&#10005;</div>
								</div>
								<?php $imgs_prof++ ?>
								@endforeach
								
								@if ( $imgs_prof < 4 )
								<div class="pic add">
									<input type="file" name="img-profile" id="img-profile" />
								</div>
								@endif
							@elseif ( $chat == 1 )
								<?php $imgs_chat = 0 ?>
								@foreach ( $imgs as $img )
								<div class="pic" style="background:url(<?= $img['src'] ?>)">
									<div class="del" data-type="chat-imgs" data-id="<?= $img['id'] ?>" data-chat="1">&#10005;</div>
								</div>
								<?php $imgs_chat++ ?>
								@endforeach
								
								@if ( $imgs_chat < 4 )
								<div class="pic add">
									<input type="file" name="img-chat" id="img-chat" />
								</div>
								@endif
							@endif
						@elseif ( $type == 'avatar' )
							@if ( count( $imgs ) > 0 )
							@foreach ( $imgs as $img )
							<div class="pic avatar" style="background:url(<?= $img['src'] ?>)">
								<div class="del" data-type="avatar" data-id="avatar" data-chat="0">&#10005;</div>
							</div>
							@endforeach
							@else
							<div class="pic add avatar">
								<input type="file" name="img-avatar" id="img-avatar" />
							</div>
							@endif
						@elseif ( $type == 'story' )
							<?php $story = 0 ?>
							@if ( isset( $stories ) )
							@foreach ( $stories as $video )
							<div class="story">
								<video width="" height="" controls>
									<source src="<?= $video['src'] ?>" type="video/mp4">
									Your browser does not support the video tag.
								</video>
								<div class="del" data-id="story" data-id="<?= $video['id'] ?>" data-chat="0">&#10005;</div>
							</div>
							<?php $story++ ?>
							@endforeach
							@endif

							@if ( $story < 4 )
							<div class="pic add">
								<input type="file" name="stories" id="story" />
							</div>
							@endif
						@endif
