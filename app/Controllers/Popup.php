<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Model_Profile;


class Popup extends Controller
{
	public function popup()
	{
		return view( 'ajax-popup' );
	}


	public function notification()
	{
		$profile = array();

		if ( $_GET['type'] == 'matches' )
		{
			$profile = new Model_Profile();
			$result = $profile->get( $_GET['id'] );
			unset( $profile );
			foreach ( $result as $item )
			{
				$profile['id'] = $item->slot;
				$profiles['status'] = $item->status;
				$profile['name'] = $item->name;
				$profile['age'] = $item->age;
				$profile['avatar'] = '/images/profile/'.$item->avatar;
			}
		}

		return view( 'ajax-notifications', [ 'type' => $_GET['type'], 'profile' => $profile ] );
	}
}
