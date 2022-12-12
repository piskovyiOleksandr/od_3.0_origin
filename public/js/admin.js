

$('.edit-photo-area').on('click', '.del', function(){
	let obj = $(this).parent(),
			id = $(this).data('id'),
			chat = $(this).data('chat'),
			profile = $('#profile-id').val(),
			type = $(this).data('type')

	if ( chat == 0 && id > 0 )
	{
		obj = '#profile-imgs';
	}
	else if ( chat == 1  && id > 0 )
	{
		obj = '#chat-imgs';
	}
	else if ( chat == 0 && type == 'avatar' )
	{
		obj = '#profile-avatar';
	}
	else if ( type == 'story' )
	{
		obj = '#stories';
	}
	
//alert('id=' + id + '&chat=' + chat + '&profile=' + profile + '&type=' + type)
	$.ajax({
		type: 'get',
		url: '/admin/profiles/edit/photo-del',
		data: 'id=' + id + '&chat=' + chat + '&profile=' + profile + '&type=' + type,
		success: function(html) {
			$(obj).html(html)
		}
	})
});


$('input[type="file"]').on('click', function(){
	$('input[type="file"]').prop('value', '')
})


$('#add-photo').on('click', function(event){
	event.preventDefault();

	let chat,
			obj,
			files,
			type = '',
			profile = $('#profile-id').val(),
			img_prof = $('#img-profile').val(),
			img_chat = $('#img-chat').val(),
			img_avatar = $('#img-avatar').val(),
			token = $('#img-profile-token').val(),
			story = $('#story').val(),
			formData = new FormData();

	if ( img_prof && img_prof != '' )
	{
		files = $('#img-profile').prop('files')[0];
		chat = 0;
		obj = '#profile-imgs';
	}
	else if ( img_chat && img_chat != '' )
	{
		files = $('#img-chat').prop('files')[0];
		chat = 1;
		obj = '#chat-imgs';
	}
	else if ( img_avatar && img_avatar != '' )
	{
		files = $('#img-avatar').prop('files')[0];
		chat = 0;
		obj = '#profile-avatar';
		type = 'avatar';
	}
	else if ( story && story != '' )
	{
		files = $('#story').prop('files')[0];
		obj = '#stories';
		type = 'story';
	}

	$( files ).each( function( i, v ) {
		if ( v.type == 'image/png' || v.type == 'image/jpeg' || v.type == 'video/mp4' )
		{
			formData.append( 'file', files );
			formData.append( '_token', token );
			formData.append( 'chat', chat );
			formData.append( 'profile', profile );
			formData.append( 'type', type );
		}
		else
			alert( 'Only .png adn .jpg files' );
	});

	$.ajax({
		type: 'post',
		enctype: 'multipart/form-data',
		url: '/admin/profiles/edit/photo-add',
		data: formData,
		processData: false,
		contentType: false,
    success: function(html) {
			$(obj).html(html);
		}
	});
});


$('.edit-col-content').on('click', '.edit-button:not(#add-photo)', function(){

	let obj = $(this).parent('.edit-col-content'),
			profile = $('#profile-id').val(),
			data = 'id=' + profile + '&block=' + obj.data('name');

	$(this).parent('.edit-col-content').find('.form-profile').each( function( i, v ){

		let value = '',
				name = $(this).prop('name');
		if ( $.isArray( $(this).val() ) )
		{
			$( $(this).val() ).each(function( k, val ){
				data += '&' + name + '[]=' + val;
			});
		}
		else if ( $(this).attr('type') == 'checkbox' )
		{
			if ( $(this).is(':checked') )
				data += '&' + name + '=1';
			else
				data += '&' + name + '=0';
		}
		else
		{
			value = $(this).val();
			data += '&' + name + '=' + value;
		}

	});

//	alert( data );

	obj.addClass('overlay');

	$.ajax({
		type: 'get',
		url: '/admin/profiles/edit/save',
		data: data,
		success: function(html){
			obj.html(html);
			obj.removeClass('overlay');
		}
	});

});
