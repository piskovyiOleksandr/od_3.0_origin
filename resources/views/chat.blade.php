@extends('layout')

	@section('title') Cats Matches @endsection

	@section('content')

	<div class="main column-left flex">
		<div class="header">
			<div class="header-left">
				<h1>All Chats</h1>
			</div>
			<div class="header-right">
				<div class="icons search-icon-mag"></div>
			</div>
		</div>
		<div class="content">
			<div class="stories-block flex" id="stories-list">
				<div class="stories-block-user-story" onclick="mrzv_popup('/popup/chat', '')">
					<div class="stories-block-name">My Story</div>
				</div>
			</div>

			<div class="chats-block-nav">
				<span class="active">Messages</span>
				<span>Unread</span>
			</div>

			<div class="chats-block chats-block-all" id="chat-list-all">
				<div class="">
					There is nothing chats yet...
				</div>
			</div>

			<div class="chats-block chats-block-unread" id="chat-list-unread"></div>
		</div>
	</div>
	<!-- Main Block - All Chats End -->

	<!-- Main Block - Active Chat Start -->
	<div class="main column-center transition-03">
		<div class="header">
			<div class="header-left">
				<div class="model-pic" style="display:none"></div>
				<div class="model-wrap">
					<div class="model-name" style="display:none"></div>
					<div class="model-status" style="display:none">Online Now</div>
				</div>
			</div>
			<div class="header-right">
				<div class="model-link" style="display:none" data-href="/ajax/chat-item-profile" onclick="constriction_chat('thin');mrzv_popup_ajax(this, 'id=' + $('#chat-id-marker').val() + '&type=ajax' )">
					<div class="icons profile-icon"></div>
				</div>
				<a href="#" class="model-camera" style="display:none"><div class="icons camera-icon"></div></a>
			</div>
		</div>
		<div class="content">
			<div class="chat">
				@if ( isset( $profile ) )
				<div class="initial-message-wrap">
					<div>There is nothing here yet...</div>
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="overlay dark modal-chat-page">
		<div class="modal modal-photos">
			<div class="close-icon">&#10005;</div>
			<div class="modal-header">
				<div class="modal-header-left">
					<div class="count"><span class="index-slides"></span> of <span class="count-slides"></span></div>
				</div>
				<div class="modal-header-right">
					
				</div>
			</div>
			<div class="modal-container slider" id="chat-slider-photos">
				<div class="slides"></div>
			</div>
			<div class="modal-footer" id="chat-carousel-photos">
				<div class="flex-viewport" id=""></div>
			</div>
		</div>
		
		<div class="modal modal-stories">
			<div class="close-icon">&#10005;</div>
			
			<div class="modal-header">
				<div class="modal-header-left">
					<div class="count"><span class="index-slides"></span> of <span class="count-slides"></span></div>
				</div>
			</div>
			
			<div class="modal-stories-container transition-03" id="modal-stories"></div>
		</div>
	</div>


	<input type="hidden" id="chat-id-marker" value="" />

	@endsection


@section('script')

<script src="{{ asset('/public/js/chat.js') }}" type="text/javascript" defer></script>

<script type="text/javascript" defer>

	function load_chat( id )
	{
		if ( $('#chat-id-marker').val() != id )
		{
			$('#chat-id-marker').prop('value', id)
			ajax( 'GET', '/ajax/chat-item', 'id=' + id, '.chat' )
			$('.profile').html('')
			$('.column-center').css({display:'block'}).addClass('open')
		}
	}

	function init_chats()
	{
		ajax( 'GET', '/ajax/chat-stories', '', '#stories-list', '', 0, 'append' )

		function load_chat_list()
		{
			let ls = JSON.parse( localStorage.getItem( 'tsMain' ) ),
					ids = 'chat_list=&'

			if ( ls !== null )
			{
				$.each( ls['od-chat'], function( k, v ) {
					if ( k != '' )
						ids += 'ids[]=' + k + '&';
				})
			}

			ajax( 'GET', '/ajax/chat-list', ids, '#chat-list-all' )
		}

		setTimeout( load_chat_list, 2500 )

		<?php if ( isset( $profile ) ): ?>
		let profile_id = <?= $profile["id"] ?>;
		load_chat( profile_id );
		<?php endif ?>
	}

</script>

@endsection
