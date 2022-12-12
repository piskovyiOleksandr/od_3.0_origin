<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Profile;
use App\Models\Model_Chat;

class Chat extends Controller
{
	static $cols = array( 'profiles.slot', 'profiles.status', 'profiles.name', 'profiles.age', 'profiles.avatar', 'profiles.cr', 'profiles.link' );


	public function index( $id = null )
	{
		if ( $id !== null )
		{
			$profile = new Model_Profile();
			$result = $profile->get( $id );
			unset( $profile );
			foreach ( $result as $item )
			{
				$profile['id'] = $item->slot;
				$profiles['status'] = $item->status;
				$profile['name'] = $item->name;
				$profile['age'] = $item->age;
				$profile['avatar'] = '/images/profile/'.$item->avatar;
			}

			$chat = new Model_Chat();
			$result = $chat->messages( $id );
			if ( $result )
			{
				foreach ( $result as $item )
				{
					$profile['messages'][0] = $item->mes_1;
					$profile['messages'][1] = $item->mes_2;
					$profile['messages'][2] = $item->mes_3;
					$profile['messages'][3] = $item->mes_4;
					$profile['messages'][4] = $item->mes_5;
					$profile['messages'][5] = $item->mes_6;
					$profile['messages'][6] = $item->mes_7;
					$profile['messages'][7] = $item->mes_8;
					$profile['messages'][8] = $item->mes_9;
					$profile['messages'][9] = $item->mes_10;
				}
			}
			else
			{
				$profile['messages'] = array();
			}

			return view( 'chat', [ 'profile' => $profile ] );
		}
		else
			return view( 'chat' );
	}


	public function chat_list()
	{
		if ( isset( $_GET['ids'] ) && is_array( $_GET['ids'] ) && count( $_GET['ids'] ) > 0 )
		{
			$ids = '';
			foreach ( $_GET['ids'] as $k => $v )
				$ids .= $v.',';
			$ids = substr( $ids, 0, -1);

			$profiles = new Model_Chat();
			$result = $profiles->get_list( $ids, self::$cols );
			unset( $profiles );

			$i = 0;
			foreach ( $result as $item )
			{
				$profiles[$i]['id'] = $item->slot;
				$profiles[$i]['status'] = $item->status;
				$profiles[$i]['name'] = $item->name;
				$profiles[$i]['age'] = $item->age;
				$profiles[$i]['avatar'] = '/images/profile/'.$item->avatar;
				$i++;
			}

			return view( 'ajax-chat-list', [ 'profiles' => $profiles ] );
		}
	}


	public function chat_item()
	{
		if ( isset( $_GET['id'] ) && $_GET['id'] != '' )
		{
			$profile = new Model_Profile();
			$result = $profile->get( $_GET['id'] );
			unset( $profile );
			foreach ( $result as $item )
			{
				$profile['id'] = $item->slot;
				$profile['name'] = $item->name;
				$profile['age'] = $item->age;
				$profile['avatar'] = '/images/profile/'.$item->avatar;
				$profile['link'] = $item->link;
			}

			$chat = new Model_Chat();
			$result = $chat->messages( $_GET['id'] );
			if ( $result )
			{
				foreach ( $result as $item )
				{
					$profile['messages'][0] = $item->mes_1;
					$profile['messages'][1] = $item->mes_2;
					$profile['messages'][2] = $item->mes_3;
					$profile['messages'][3] = $item->mes_4;
					$profile['messages'][4] = $item->mes_5;
					$profile['messages'][5] = $item->mes_6;
					$profile['messages'][6] = $item->mes_7;
					$profile['messages'][7] = $item->mes_8;
					$profile['messages'][8] = $item->mes_9;
					$profile['messages'][9] = $item->mes_10;
				}
			}
			else
			{
				$profile['messages'] = array();
			}
			$result = $chat->chat_images( $_GET['id'] );
			if ( $result )
			{
				$i = 0;
				foreach ( $result as $item )
				{
					$profile['chat-images'][$i] = '/images/profile/'.$item->file;
					$i++;
				}
			}
			else
			{
				$profile['chat-images'] = array();
			}

			return view( 'ajax-chat-item', [ 'profile' => $profile ] );
		}
		else
			return view( 'ajax-chat-item' );
	}


	public function get_stories()
	{
		$type = isset( $_GET['type'] ) ? $_GET['type'] : '';
		$index = isset( $_GET['index'] ) ? $_GET['index'] : '';

		$chat = new Model_Chat();
		$query = $chat->get_stories( 'all' );

		$stories = array();
		$i = 0;
		foreach ( $query as $item )
		{
			if ( $i > 0 && $stories[$i - 1]['profile_id'] != $item->profile_id )
			{
				$stories[$i]['src'] = '/stories/'.$item->file;
				$stories[$i]['profile_id'] = $item->profile_id;
				$stories[$i]['name'] = $item->name;
				$stories[$i]['age'] = $item->age;
				$stories[$i]['avatar'] = '/images/profile/'.$item->avatar;
				$stories[$i]['id'] = $item->id;
				$i++;
			}
			elseif ( $i == 0 )
			{
				$stories[$i]['src'] = '/stories/'.$item->file;
				$stories[$i]['profile_id'] = $item->profile_id;
				$stories[$i]['name'] = $item->name;
				$stories[$i]['age'] = $item->age;
				$stories[$i]['avatar'] = '/images/profile/'.$item->avatar;
				$stories[$i]['id'] = $item->id;
				$i++;
			}
		}

		if ( $type == 'modal' )
			return view( 'ajax-chat-stories-modal', [ 'stories' => $stories, 'index' => $index ] );
		else
			return view( 'ajax-chat-stories', [ 'stories' => $stories ] );
	}
}
