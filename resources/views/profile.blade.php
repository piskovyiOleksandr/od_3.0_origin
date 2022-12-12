
@extends('layout')

	@section('title') <?= $profile['name'] ?> - Cats Matches @endsection

	@section('content')

	<div class="main profile flex">
		<div class="header">
			<div class="header-left">
				<span class="icons backbtn-icon"></span>
			</div>
		</div>

		<div class="content">
			<div class="column-80">

				<div class="profile-wrapper flex">
					<div class="pic" style="background:url('<?= $profile['avatar'] ?>')"></div>
					<div class="profile-info flex">
						<h1 class="name"><?= $profile['name'] ?></h1>
						<span class="status">Online now</span>
						<div class="age"><?= $profile['age'] ?> years</div>
						<div class="profile-location"><?= $profile['location'] ?> km from you in</div>
					</div>
					<div class="profile-control-buttons flex">
						<div class="button report flex"><span class="icons report-icon"></span>Report spam</div>
						<a class="button start-chat flex" href="/chat/<?= $profile['id'] ?>"><span class="icons start-chat-icon"></span>Start chat</a>
					</div>
				</div>

				<div class="user-about flex">
					<div class="single-item flex status">
						<div class="label">Status</div>
						<div class="value"><?= $profile['status'] ?></div>
					</div>
					<div class="single-item flex description">
						<div class="label">Fit the description</div>
						<div class="description-list">
							@foreach ( $spec_type as $key => $val )
							<div class="value">#<?= $val->type_name ?></div>
							@endforeach
						</div>
					</div>
					<div class="single-item flex looking-for">
						<div class="label">I'm looking for</div>
						@foreach ( $spec_goal as $key => $val )
						<div class="value"><?= $val->goal_name ?></div>
						@endforeach
					</div>
					<div class="single-item flex about">
						<div class="label">About</div>
						<div class="value"><?= $profile['desc'] ?></div>
					</div>
				</div>

				<div class="tab-wrapper">
					<div class="tabs flex">
						<div class="tab stories active" data-tab="stories"><?= count( $stories ) ?> Stories</div>
						<div class="tab photos" data-tab="photos"><?= count( $img ) ?> Photos</div>
					</div>

					<div class="tab-content stories active" data-tab-content="stories">
						@if ( isset( $stories ) )
						@foreach ( $stories as $item )
						<div class="story_wrapper">
							<video onloadeddata="init_stories_video_duration(this)" preload="auto" poster="" paused="true" muted="true">
								<source src="<?= $item['src'] ?>" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
							</video>
							<div class="video-timer"></div>
							<div class="icon-play"></div>
						</div>
						@endforeach
						@endif
					</div>

					<div class="tab-content photos" data-tab-content="photos">
						@if ( isset( $img ) )
						@foreach ( $img as $key => $val )
						<div class="image_wrapper">
							<img src="<?= $val ?>" />
						</div>
						@endforeach
						@endif
					</div>
				</div>
			</div>

			<div class="profile-ad-block column-20">
				<div class="ad-wrapper-block">
					<a href="#"><img src="/images/badoo.jpg" /></a>
				</div>
			</div>
		</div>
	</div>

	<div class="overlay dark">

		<div class="modal modal-photos">
			<div class="close-icon">&#10005;</div>
			<div class="modal-header">
				<div class="modal-header-left">
					<div class="count"><span class="index-slides"></span> of <span class="count-slides"><?= count( $img ) ?></span></div>
				</div>
				<div class="modal-header-right">
					
				</div>
			</div>
			<div class="modal-container slider" id="slider-photos">
				<div class="slides">
					@foreach ( $img as $key => $val )
					<div class="img"><img src="<?= $val ?>" /></div>
					@endforeach
				</div>
			</div>
			<div class="modal-footer" id="carousel-photos">
				<div class="flex-viewport" id="">
					@foreach ( $img as $key => $val )
					<div class="image" style="background:url('<?= $val ?>')"></div>
					@endforeach
				</div>
			</div>
		</div>

		@if ( isset( $stories ) )
		<div class="modal modal-stories">
			<div class="close-icon">&#10005;</div>
			<div class="modal-header">
				<div class="modal-header-left">
					<div class="count"><span class="index-slides"></span> of <span class="count-slides"><?= count( $stories ) ?></span></div>
				</div>
			</div>
			<div class="modal-container slider" id="slider-stories">
				<div class="slides">
					@foreach ( $stories as $item )
					<div class="story_wrapp">
						<div class="story">
							<div class="video-progressbar">
								<div class="positionBar" id="positionBar-<?= $item['id'] ?>"></div>
							</div>
							<video id="video-<?= $item['id'] ?>"
											paused="true"
											@if( Cookie::get('video-muted') === 'true' )<?php echo 'muted' ?>@endif
											onTimeUpdate="video_progress('<?= $item['id'] ?>')"
											ended=""
											poster=""
											onloadeddata="init_stories_video_duration(this)"
							>
								<source src="<?= $item['src'] ?>" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
							</video>
							<div class="controls">
								<div class="icon-play" data-id="<?= $item['id'] ?>"></div>
								<div class="@if( Cookie::get('video-muted') === 'true' )<?php echo 'icon-mute-on' ?>@elseif( Cookie::get('video-muted') === 'false' || ! Cookie::get('video-muted') )<?php echo 'icon-mute-off' ?>@endif" data-id="<?= $item['id'] ?>"></div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div class="modal-footer" id="carousel-stories">
				<div class="flex-viewport" id="">
					@foreach ( $stories as $item )
					<div class="slide-nav-bt image">
						<video poster="" paused="true" muted="true">
							<source src="<?= $item['src'] ?>" type="video/mp4" codecs="avc1.42E01E, mp4a.40.2">
						</video>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif
	</div>
	
	@endsection


@section('script')
<script type="text/javascript">
	
</script>
@endsection
