<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Profile;


class Profile extends Controller
{
	static $cols = array();


	public function index( $id = null )
	{
		if ( ! isset( $_GET['id'] ) )
		{
			if ( $id === null )
			{
				echo 'не указан id...';
				exit();
			}
		}
		else
		{
			$id = $_GET['id'];
		}

		$profile = new Model_Profile();
		$spec_goal = $profile->get_spec_goal( $id );
		$spec_type = $profile->get_spec_type( $id );
		$result = $profile->get( $id );

		$img = $stories = array();
		foreach ( $result as $item )
		{
			$data['id'] = $item->slot;
			$data['active'] = $item->active;
			$data['status'] = $item->status;
			$data['name'] = $item->name;
			$data['age'] = $item->age;
			$data['location'] = $item->distance;
			$data['desc'] = $item->description;
			$data['avatar'] = '/images/profile/'.$item->avatar;
			if ( isset( $item->files ) )
			{
				$imgs = explode( ',', $item->files );
				foreach ( $imgs as $item )
					$img[] = '/images/profile/'.$item;
			}
		}
		$query = $profile->get_stories( $id );
		$i = 0;
		foreach ( $query as $item )
		{
			$stories[$i]['src'] = '/stories/'.$item->file;
			$stories[$i]['id'] = $item->id;
			$i++;
		}

		$page = 'profile';
		
		$type = $_GET['type'] ?? '';
		if ( $type == 'ajax' )
			$page = 'ajax-chat-item-profile';
		

		return view( $page, [ 'profile' => $data, 'img' => $img, 'stories' => $stories, 'spec_goal' => $spec_goal, 'spec_type' => $spec_type ] );
	}
}
