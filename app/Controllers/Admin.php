<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Filters;
use App\Models\Model_Profile;
use App\Models\Model_Admin;

class Admin extends Controller
{
	static $cols = array();

	
	public function __construct()
	{
		//$admin = new Model_Admin();
	}


	public function profile_list()
	{
		$profiles = array();
		$filters = array();
		//$offset = 0;
		//$limit = 100;
		
		$admin = new Model_Admin();
		$result = $admin->get_profiles( $filters/* , $offset, $limit */ );
		$i = 0;
		foreach ( $result as $item )
		{
			$profiles[$i]['id'] = $item->slot;
			$profiles[$i]['active'] = $item->active;
			$profiles[$i]['name'] = $item->name;
			$profiles[$i]['age'] = $item->age;
			if ( isset( $item->imgs_prof ) )
			{
				$imgs_prof = explode( ',', $item->imgs_prof );
				$im = 0;
				foreach ( $imgs_prof as $img )
				{
					$query = $admin->get_img( $img );
					foreach ( $query as $col )
					{
						$chat = $col->chat;
					}
					$profiles[$i]['imgs-prof'][$im]['src'] = '/images/profile/'.$img;
					$profiles[$i]['imgs-prof'][$im]['chat'] = $chat;
					$im++;
				}
			}
			$profiles[$i]['avatar'] = '/images/profile/'.$item->avatar;
			$profiles[$i]['cr'] = $item->cr;
			$i++;
		}

		return view( 'admin-profiles', [ 'profiles' => $profiles ] );
	}


	public function profile_edit( $id = null )
	{
		if ( $id !== null )
		{
			$profile = $arGoal = $arType = $filter_goal = $filter_type = $chat = array();

			$profile = new Model_Profile();
			$spec_goal = $profile->get_spec_goal( $id );
			$spec_type = $profile->get_spec_type( $id );
			foreach ( $spec_type as $key => $val )
				$arType[] = $val->type_id;
			foreach ( $spec_goal as $key => $val )
				$arGoal[] = $val->goal_id;
			$filters = new Model_Filters();
			$filter_goal = $filters->get_goal();
			$filter_type = $filters->get_type();
			unset( $profile );

			$admin = new Model_Admin();
			$result = $admin->get_profile( $id );
			$profile = array();
			foreach ( $result as $item )
			{
				$profile['id'] = $item->slot;
				$profile['active'] = $item->active;
				$profile['name'] = $item->name;
				$profile['age'] = $item->age;
				$profile['distance'] = $item->distance;
				$profile['small_city'] = $item->small_city;
				$profile['status'] = $item->status;
				$profile['description'] = $item->description;
				if ( $item->avatar != '' )
					$profile['avatar'] = '/images/profile/'.$item->avatar;
				else
					$profile['avatar'] = '';
				$profile['writes'] = $item->writes;
				$profile['matches'] = $item->matches;
				$profile['action_timeout'] = $item->action_timeout;
				$profile['cr'] = $item->cr;
				$profile['link'] = $item->link;
				if ( isset( $item->imgs_prof ) )
				{
					$imgs_prof = explode( ',', $item->imgs_prof );
					$im = 0;
					foreach ( $imgs_prof as $img )
					{
						$query = $admin->get_img( $img );
						foreach ( $query as $col )
						{
							$chat = $col->chat;
							$img_id = $col->id;
						}
						$profile['imgs-prof'][$im]['src'] = '/images/profile/'.$img;
						$profile['imgs-prof'][$im]['chat'] = $chat;
						$profile['imgs-prof'][$im]['id'] = $img_id;
						$im++;
					}
				}
			}

			$query = $admin->get_stories( $id );
			$i = 0;
			foreach ( $query as $item )
			{
				$profile['stories'][$i]['src'] = '/stories/'.$item->file;
				$profile['stories'][$i]['id'] = $item->id;
				$i++;
			}

			$query = $admin->get_chats( $id );
			$i = 0;
			foreach ( $query['all'] as $col )
			{
				$chats['all'][$i]['id'] = $col->id;
				$chats['all'][$i]['name'] = 'Chat #'.$col->id.' - '.$col->type;
				$i++;
			}
			foreach ( $query['current'] as $col )
			{
				$chats['current'] = $col->chat_id;
			}

			return view( 'admin-edit-profile', [
				'profile' => $profile,
				'arGoal' => $arGoal,
				'arType' => $arType,
				'filter_goal' => $filter_goal,
				'filter_type' => $filter_type,
				'chats' => $chats
			] );
		}
	}


	public function profile_save()
	{
		$id = $_GET['id'];
		$block = $_GET['block'];

		$profile = $arGoal = $arType = $filter_goal = $filter_type = $chats = array();

		$admin = new Model_Admin();

		if ( $block == 'type-goal' )
		{
			$save = $admin->save_block( '', $_GET );
			
			$profile = new Model_Profile();
			$spec_goal = $profile->get_spec_goal( $id );
			$spec_type = $profile->get_spec_type( $id );
			foreach ( $spec_type as $key => $val )
				$arType[] = $val->type_id;
			foreach ( $spec_goal as $key => $val )
				$arGoal[] = $val->goal_id;
			$filters = new Model_Filters();
			$filter_goal = $filters->get_goal();
			$filter_type = $filters->get_type();
			//unset( $profile );
		}

		if ( $block == 'base' )
		{
			$save = $admin->save_block( 'profiles', $_GET );
			
			$query = $admin->get_profile_col( $id, array( 'name', 'age', 'status', 'description', 'distance', 'small_city', 'writes', 'matches', 'action_timeout' ) );
			foreach ( $query as $col )
			{
				$profile['name'] = $col->name;
				$profile['age'] = $col->age;
				$profile['description'] = $col->description;
				$profile['distance'] = $col->distance;
				$profile['small_city'] = $col->small_city;
				$profile['status'] = $col->status;
				$profile['writes'] = $col->writes;
				$profile['matches'] = $col->matches;
				$profile['action_timeout'] = $col->action_timeout;
			}
		}

		if ( $block == 'chat' )
		{
			$save = $admin->save_block( 'profiles_chat', $_GET );
			
			$query = $admin->get_chats( $id );
			$i = 0;
			foreach ( $query['all'] as $col )
			{
				$chats['all'][$i]['id'] = $col->id;
				$chats['all'][$i]['name'] = 'Chat #'.$col->id.' - '.$col->type;
				$i++;
			}
			foreach ( $query['current'] as $col )
			{
				$chats['current'] = $col->chat_id;
			}
		}

		if ( $block == 'link' )
		{
			$save = $admin->save_block( 'profiles', $_GET );
			
			$query = $admin->get_profile_col( $id, array( 'link' ) );
			foreach ( $query as $col )
				$profile['link'] = $col->link;
		}

		return view( 'admin-ajax-profile-save', [
			'profile' => $profile,
			'arGoal' => $arGoal,
			'arType' => $arType,
			'filter_goal' => $filter_goal,
			'filter_type' => $filter_type,
			'chats' => $chats,
			'block' => $block
		] );
	}


	public function profile_file_del()
	{
		$admin = new Model_Admin();

		$id = $_GET['id'];
		$chat = $_GET['chat'];
		$profile_id = $_GET['profile'];
		$type = $_GET['type'];
		$stories = $imgs = array();

		if ( $id != 'avatar' && $id > 0 && $type != 'story' )
		{
			$img = $admin->get_img( '', $id );
			foreach ( $img as $col )
				$file = $col->file;

			$query = $admin->file_del( $id );
			if ( $query )
				unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/profile/'.$file );

			$query = $admin->get_imgs( $profile_id, $chat );
			$imgs = array();
			$i = 0;
			foreach ( $query as $item )
			{
				$imgs[$i]['src'] = '/images/profile/'.$item->file;
				$imgs[$i]['id'] = $item->id;
				$i++;
			}
		}
		elseif ( $id == 'avatar')
		{
			$img = $admin->get_avatar( $profile_id );
			foreach ( $img as $col )
				$file = $col->avatar;

			$query = $admin->file_del( $id, $profile_id );
			if ( $query )
				unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/profile/'.$file );
		}
		elseif ( $type == 'story' )
		{
			$query = $admin->get_story( $id );
			foreach ( $query as $col )
				$file = $col->file;

			$query = $admin->file_del( $id, 0, 'story' );
			if ( $query )
				unlink( $_SERVER['DOCUMENT_ROOT'].'/public/stories/'.$file );

			$query = $admin->get_stories( $profile_id );
			$i = 0;
			foreach ( $query as $item )
			{
				$stories[$i]['src'] = '/stories/'.$item->file;
				$stories[$i]['id'] = $item->id;
				$i++;
			}
		}

		return view( 'admin-ajax-profile-photo-add', [ 'type' => $type, 'chat' => $chat, 'imgs' => $imgs, 'stories' => $stories ] );
	}


	public function profile_file_add()
	{
		ini_set('file_uploads', 'On'); // Разрешение на загрузку файлов
		ini_set('max_execution_time', '60'); // Максимальное время выполнения скрипта в секундах
		ini_set('memory_limit', '128M'); // Максимальное потребление памяти одним скриптом
		ini_set('post_max_size', '50M'); // Максимально допустимый размер данных отправляемых методом POST
		//ini_set('upload_tmp_dir', 'home/user/temp'); // Папка для хранения файлов во время загрузки
		ini_set('upload_max_filesize', '10M'); // Максимальный размер загружаемого файла
		ini_set('max_file_uploads', '10'); // Максимально разрешённое количество одновременно загружаемых файлов

		$admin = new Model_Admin();

		$profile_id = $_POST['profile'];
		$chat = $_POST['chat'];
		$type = $_POST['type'];
		$imgs = array();
		$stories = array();

		if ( ! isset( $_FILES ) )
			echo 'Файл не загружен.';

		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/public/images/profile/';
		$uploaddirstories = $_SERVER['DOCUMENT_ROOT'].'/public/stories/';
		$extension = strtolower( substr( strrchr( $_FILES['file']['name'], '.' ), 1 ) );
		$filename = uniqid( '', true ).'.'.$extension;
		if ( $extension == 'jpg' )
			$uploadfile = $uploaddir.$filename;
		elseif ( $extension == 'mp4' )
			$uploadfile = $uploaddirstories.$filename;

		if ( move_uploaded_file( $_FILES['file']['tmp_name'], $uploadfile ) )
		{
			$admin->file_add( $profile_id, $chat, $filename, $type );

			if ( $type == 'avatar' )
			{
				$query = $admin->get_avatar( $profile_id );
				foreach ( $query as $col )
					$imgs[0]['src'] = '/images/profile/'.$col->avatar;
			}
			elseif ( $type == 'story' )
			{
				$query = $admin->get_stories( $profile_id );
				$i = 0;
				foreach ( $query as $item )
				{
					$stories[$i]['src'] = '/stories/'.$item->file;
					$stories[$i]['id'] = $item->id;
					$i++;
				}
			}
			else
			{
				$query = $admin->get_imgs( $profile_id, $chat );
				$i = 1;
				foreach ( $query as $item )
				{
					$imgs[$i]['src'] = '/images/profile/'.$item->file;
					$imgs[$i]['id'] = $item->id;
					$i++;
				}
			}
		}
		else
		{
			//echo "Возможная атака с помощью файловой загрузки!\n";
		}

		return view( 'admin-ajax-profile-photo-add', [ 'chat' => $chat, 'imgs' => $imgs, 'stories' => $stories, 'type' => $type ] );
	}


	
}
