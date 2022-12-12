<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Model_Admin extends Model_Base
{
	


	function get_profiles( $filters = array()/* , $offset = 0, $limit = 100 */ )
	{
		$query = DB::select(
			DB::raw( '
				SELECT profiles.slot, profiles.active, profiles.status, profiles.name, profiles.age, profiles.avatar, profiles.cr, GROUP_CONCAT( DISTINCT profiles_photo.file ) AS imgs_prof
				FROM profiles
				LEFT JOIN profiles_photo ON profiles_photo.profile_id=profiles.slot
				GROUP BY profiles.slot, profiles.active, profiles.status, profiles.name, profiles.age, profiles.avatar, profiles.cr
				ORDER BY slot ASC
			' )
		);

		return $query;
	}


	function get_profile( $id )
	{
		$query = DB::select(
			DB::raw( '
				SELECT profiles.slot, profiles.active, profiles.status, profiles.name, profiles.age, profiles.distance, profiles.small_city, profiles.description, profiles.avatar, profiles.writes, profiles.matches, profiles.action_timeout, profiles.cr, profiles.link, GROUP_CONCAT( DISTINCT profiles_photo.file ) AS imgs_prof
				FROM profiles
				LEFT JOIN profiles_photo ON profiles_photo.profile_id='.$id.'
				WHERE profiles.slot='.$id.'
				GROUP BY profiles.slot, profiles.active, profiles.status, profiles.name, profiles.age, profiles.distance, profiles.small_city, profiles.description, profiles.avatar, profiles.writes, profiles.matches, profiles.action_timeout, profiles.cr, profiles.link
			' )
		);

		return $query;
	}
	
	
	function get_profile_col( $id, $cols )
	{
		$row = '';
		$i = 1;
		foreach ( $cols as $item )
		{
			$row .= 'profiles.'.$item;
			if ( count( $cols ) > $i )
				$row .= ', ';
			$i++;
		}

		$query = DB::select(
			DB::raw( '
				SELECT '.$row.'
				FROM profiles
				WHERE profiles.slot='.$id.'
			' )
		);

		return $query;
	}


	function get_img( $file = '', $id = 0 )
	{
		if ( $file != '' )
		{
			$query = DB::select(
				DB::raw( '
					SELECT *
					FROM profiles_photo
					WHERE profiles_photo.file="'.$file.'"
				' )
			);

			return $query;
		}
		if ( $file == '' && $id > 0 )
		{
			$query = DB::select(
				DB::raw( '
					SELECT *
					FROM profiles_photo
					WHERE profiles_photo.id="'.$id.'"
				' )
			);

			return $query;
		}
	}


	function get_avatar( $id = 0 )
	{
		if ( $id > 0 )
		{
			$query = DB::select(
				DB::raw( '
					SELECT avatar
					FROM profiles
					WHERE profiles.slot="'.$id.'"
				' )
			);

			return $query;
		}
	}


	function get_imgs( $profile_id, $chat, $avatar = false )
	{
		$query = DB::select(
			DB::raw( '
				SELECT avatar
				FROM profiles
				WHERE profiles.slot="'.$profile_id.'"
			' )
		);
		foreach ( $query as $col )
			$avatar = $col->avatar;

		$query = DB::select(
			DB::raw( '
				SELECT *
				FROM profiles_photo
				WHERE profiles_photo.chat="'.$chat.'" AND profiles_photo.profile_id="'.$profile_id.'" AND profiles_photo.file<>"'.$avatar.'"
				ORDER BY id ASC
			' )
		);

		return $query;
	}


	function get_stories( $profile_id )
	{
		$query = DB::select(
			DB::raw( '
				SELECT *
				FROM profiles_story
				WHERE profiles_story.profile_id="'.$profile_id.'"
				ORDER BY id ASC
			' )
		);

		return $query;
	}


	function get_story( $id )
	{
		$query = DB::select(
			DB::raw( '
				SELECT *
				FROM profiles_story
				WHERE profiles_story.id="'.$id.'"
			' )
		);

		return $query;
	}


	function file_del( $id = 0, $profile_id = 0, $type = '' )
	{
		if ( $id == 'avatar' )
		{
			$res = DB::table( 'profiles' )->where( 'slot', $profile_id )->update( [ 'avatar' => '' ] );
			return $res;
		}
		elseif ( $id > 0 && $type != 'story' )
		{
			$res = DB::table( 'profiles_photo' )->where( 'id', '=', $id )->delete();
			return $res;
		}
		elseif ( $id > 0 && $type == 'story' )
		{
			$res = DB::table( 'profiles_story' )->where( 'id', '=', $id )->delete();
			return $res;
		}
	}
	
	
	function file_add( $profile_id, $chat = 0, $file = '', $type = '' )
	{
		if ( $type != 'avatar' && $type != 'story' )
			$res = DB::table( 'profiles_photo' )->insert( [ 'profile_id' => $profile_id, 'chat' => $chat, 'file' => $file ] );
		elseif ( $type == 'story' )
			$res = DB::table( 'profiles_story' )->insert( [ 'profile_id' => $profile_id, 'file' => $file ] );
		elseif ( $type == 'avatar' )
			$res = DB::table( 'profiles' )->where( 'slot', $profile_id )->update( [ 'avatar' => $file ] );

		return $res;
	}


	function get_chats( $id )
	{
		$all = DB::table( 'chats' )->select( '*' )->get();
		$current = DB::table( 'profiles_chat' )->where( 'profile_id', $id )->get();

		$result['all'] = $all;
		$result['current'] = $current;
		
		return $result;
	}


	function save_block( $table = '', $value )
	{
		if ( $value['block'] == 'type-goal' )
		{
			DB::table( 'profiles_goal' )->where( 'user_id', $value['id'] )->delete();
			if ( isset( $value['profiles_goal'] ) )
			{
				foreach ( $value['profiles_goal'] as $key => $val )
					DB::table( 'profiles_goal' )
							->insertGetId(
								[ 'user_id' => $value['id'], 'goal_id' => $val ]
							);
			}
			DB::table( 'profiles_type' )->where( 'user_id', $value['id'] )->delete();
			if ( isset( $value['profiles_type'] ) )
			{
				foreach ( $value['profiles_type'] as $key => $val )
					DB::table( 'profiles_type' )
							->insertGetId(
								[ 'user_id' => $value['id'], 'type_id' => $val ]
							);
			}
		}
		if ( $value['block'] == 'base' )
		{
			DB::table( $table )
					->updateOrInsert(
						[ 'slot' => $value['id'] ],
						[
						 'name' => $value['name'],
						 'age' => $value['age'],
						 'description' => $value['description'],
						 'distance' => $value['distance'],
						 'small_city' => $value['small_city'],
						 'status' => $value['status'],
						 'writes' => $value['writes'],
						 'matches' => $value['matches'],
						 'action_timeout' => $value['action_timeout']
						]
					);
		}
		if ( $value['block'] == 'chat' )
		{
			DB::table( $table )
					->updateOrInsert(
						[ 'profile_id' => $value['id'] ],
						[ 'chat_id' => $value['chat'] ]
					);
		}
		if ( $value['block'] == 'link' )
		{
			DB::table( $table )
					->updateOrInsert(
						[ 'slot' => $value['id'] ],
						[ 'link' => $value['link'] ]
					);
		}
	}
}
?>
