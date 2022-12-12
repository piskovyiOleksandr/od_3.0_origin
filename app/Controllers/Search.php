<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Models\Model_Profiles;
use App\Models\Model_Filters;


class Search extends Controller
{
	const PROFILES_PAGE = 15;

	static $cols = array( 'profiles.slot', 'profiles.name', 'profiles.age', 'profiles.distance', 'profiles.small_city', 'profiles.avatar', 'profiles.cr' );


	public function __construct()
	{
		parent::__construct();

		//print_r( $this->big_cities );
	}


	public function index()
	{
		$filters = array();
		$goal = $_COOKIE['filter-goal'] ?? false;
		$type = $_COOKIE['filter-type'] ?? false;
		if ( $goal )
			$filters['goal'] = $goal;
		else
			$filters['goal'] = 0;
		if ( $type )
			$filters['type'] = $type;
		else
			$filters['type'] = 0;
		
		$filters['min-age'] = $_COOKIE['filter-min-age'] ?? 0;
		$filters['max-age'] = $_COOKIE['filter-max-age'] ?? 0;

		$filters['distance'] = isset( $_COOKIE['filter-distance'] ) ? $_COOKIE['filter-distance'] : 0;


//$ses = new Ses();
//echo  Session::get('big-city');

		$filters['big-city'] = $_SESSION['big-city'] ?? true;

		$cols = self::$cols;

		$offset = $_GET['offset'] ?? 0;

		$model_filters = new Model_Filters();
		$filter_goal = $model_filters->get_goal();
		$filter_type = $model_filters->get_type();

		$profiles = new Model_Profiles();

		$query = $profiles->get( $cols, $filters, $offset, self::PROFILES_PAGE );
		$i = 0;
		$items = array();
		foreach ( $query as $item )
		{
			$items[$i]['id'] = $item->slot;
			$items[$i]['name'] = $item->name;
			$items[$i]['age'] = $item->age;
			$items[$i]['distance'] = $item->distance;
			//$items[$i]['small-sity'] = $item->small_city;
			$items[$i]['pic'] = '/images/profile/'.$item->avatar;
			$items[$i]['link'] = '/profile/'.$item->slot;
			$items[$i]['cr'] = $item->cr;
			$i++;
		}
		
		$remain = $profiles->get_count( $cols, $filters, 12 );

		$min_max_age_overall = $model_filters->get_min_max_age_overall();
		//$min_max_age = $model_filters->get_min_max_age( $filters );

		return view( 'search', [ 'profiles' => $items, 'filter_goal' => $filter_goal, 'filter_type' => $filter_type, 'remain' => $remain, 'min_max_age_overall' => $min_max_age_overall ] );
	}
	
	
	public function load_more()
	{
		$filters = array();
		$goal = $_COOKIE['filter-goal'] ?? false;
		$type = $_COOKIE['filter-type'] ?? false;
		if ( $goal )
			$filters['goal'] = $goal;
		else
			$filters['goal'] = 0;
		if ( $type )
			$filters['type'] = $type;
		else
			$filters['type'] = 0;
		
		$filters['min-age'] = isset( $_GET['min-age'] ) ? $_GET['min-age'] : 0;
		$filters['max-age'] = isset( $_GET['max-age'] ) ? $_GET['max-age'] : 0;

		$filters['distance'] = isset( $_GET['distance'] ) ? $_GET['distance'] : 0;

		$filters['big-city'] = $_SESSION['big-city'] ?? true;

		$cols = self::$cols;

		$page = $_GET['page'] ?? 0;
		$offset = $page * self::PROFILES_PAGE;

		$profiles = new Model_Profiles();

		$query = $profiles->get( $cols, $filters, $offset, self::PROFILES_PAGE );
		$i = 0;
		$items = array();
		foreach ( $query as $item )
		{
			$items[$i]['id'] = $item->slot;
			$items[$i]['name'] = $item->name;
			$items[$i]['age'] = $item->age;
			$items[$i]['distance'] = $item->distance;
			//$items[$i]['small-sity'] = $item->small_city;
			$items[$i]['pic'] = '/images/profile/'.$item->avatar;
			$items[$i]['link'] = '/profile/'.$item->slot;
			$items[$i]['cr'] = $item->cr;
			$i++;
		}

		$remain = $profiles->get_count( $cols, $filters, $offset + self::PROFILES_PAGE );

		$model_filters = new Model_Filters();
		$min_max_age_overall = $model_filters->get_min_max_age_overall();

		return view( 'ajax-load-more-profiles', [ 'profiles' => $items, 'remain' => $remain, 'min_max_age_overall' => $min_max_age_overall ] );
	}
	
	
	public function load_filter()
	{
		$model_filters = new Model_Filters();
		$filter_goal = $model_filters->get_goal();
		$filter_type = $model_filters->get_type();

		$min_max_age_overall = $model_filters->get_min_max_age_overall();

		return view( 'ajax-load-filter', [ 'filter_goal' => $filter_goal, 'filter_type' => $filter_type, 'min_max_age_overall' => $min_max_age_overall ] );
	}
}
