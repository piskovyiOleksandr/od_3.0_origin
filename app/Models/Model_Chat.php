<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Model_Chat extends Model_Base
{
	


	function get_list( $ids = '', $cols )
	{
		$cols = implode( ', ', $cols );

		$query = DB::select(
			DB::raw( '
				SELECT '.$cols.'
				FROM profiles
				WHERE slot IN ('.$ids.')
				ORDER BY cr DESC, distance DESC, slot ASC
			' )
		);

		return $query;
	}


	function messages( $id )
	{
		$query = DB::select(
			DB::raw( '
				SELECT chats.mes_1, chats.mes_2, chats.mes_3, chats.mes_4, chats.mes_5, chats.mes_6, chats.mes_7, chats.mes_8, chats.mes_9, chats.mes_10
				FROM chats, profiles_chat
				WHERE chats.id=profiles_chat.chat_id AND profiles_chat.profile_id='.$id.'
			' )
		);

		return $query;
	}


	function chat_images( $id )
	{
		$query = DB::select(
			DB::raw( '
				SELECT file
				FROM profiles_photo
				WHERE profiles_photo.chat=1 AND profiles_photo.profile_id='.$id.'
			' )
		);

		return $query;
	}


	function get_stories( $type )
	{
		$query = DB::select(
			DB::raw( '
				SELECT profiles_story.id, profiles_story.profile_id, profiles_story.file, profiles.name, profiles.age, profiles.avatar
				FROM profiles_story, profiles
				WHERE profiles_story.profile_id=profiles.slot
				LIMIT 10
			' )
		);

		return $query;
	}
}
