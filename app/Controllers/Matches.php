<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Model_Matches;
use App\Models\Model_Filters;


class Matches extends Controller
{
	const PROFILES_PAGE = 1;

	static $cols = array( 'profiles.slot', 'profiles.name', 'profiles.age', 'profiles.distance', 'profiles.matches', 'profiles.avatar', 'profiles.matches', 'profiles.action_timeout', 'profiles.cr' );


	public function index()
	{
		
		return view('matches');
	}


	public function matches_load()
	{
		$filters = array();
		if ( $_GET['ids'] )
		{
			$ids = mb_substr( $_GET['ids'], 0, -1 );
			$ids = mb_substr( $ids, 1 );
			$filters['ids'] = $ids;
		}
		else
		{
			$filters['ids'] = 0;
		}
		$filters['ids_del'] = 0;

		$profiles = new Model_Matches();

		$goal = false;
		$type = false;
		if ( $goal )
			$filters['goal'] = $goal;
		else
			$filters['goal'] = 0;
		if ( $type )
			$filters['type'] = $type;
		else
			$filters['type'] = 0;

		$filters['min-age'] = 0;
		$filters['max-age'] = 0;

		$filters['distance'] = isset( $_COOKIE['matches-filter-distance'] ) ? $_COOKIE['matches-filter-distance'] : 0;

		$filters['big-city'] = $_SESSION['big-city'] ?? true;

		$cols = self::$cols;

		$page = $_GET['page'] ?? 0;
		$offset = $page * self::PROFILES_PAGE;
		$query = $profiles->get( $cols, $filters, $offset, 100 );
		$i = 0;
		$items = array();
		foreach ( $query as $item )
		{
			$items[$i]['id'] = $item->slot;
			$items[$i]['name'] = $item->name;
			$items[$i]['age'] = $item->age;
			$items[$i]['distance'] = $item->distance;
			$items[$i]['pic'] = '/images/profile/'.$item->avatar;
			$items[$i]['link'] = '/profile/'.$item->slot;
			$items[$i]['timeout'] = $item->action_timeout;
			$items[$i]['cr'] = $item->cr;
			$i++;
		}

		return view( 'ajax-load-matches', [ 'profiles' => $items ] );
	}


	public function find_matches()
	{
		$filters = array();
		$filters['ids'] = $_GET['ids'] ?? 0;
		$filters['ids_del'] = $_GET['ids'] ?? 0;
		$goal = $_COOKIE['matches-filter-goal'] ?? false;
		$type = $_COOKIE['matches-filter-type'] ?? false;
		if ( $goal )
			$filters['goal'] = $goal;
		else
			$filters['goal'] = 0;
		if ( $type )
			$filters['type'] = $type;
		else
			$filters['type'] = 0;
		
		$filters['min-age'] = $_COOKIE['matches-filter-min-age'] ?? 0;
		$filters['max-age'] = $_COOKIE['matches-filter-max-age'] ?? 0;

		$filters['distance'] = isset( $_COOKIE['matches-filter-distance'] ) ? $_COOKIE['matches-filter-distance'] : 0;

		$filters['big-city'] = $_SESSION['big-city'] ?? true;

		$cols = self::$cols;

		//$offset = $_GET['offset'] ?? 0;
		$page = $_GET['page'] ?? 0;
		$offset = $page * self::PROFILES_PAGE;

		$model_filters = new Model_Filters();
		$filter_goal = $model_filters->get_goal();
		$filter_type = $model_filters->get_type();

		$profiles = new Model_Matches();

		$query = $profiles->get( $cols, $filters, $offset, self::PROFILES_PAGE );
		$i = 0;
		$items = array();
		foreach ( $query as $item )
		{
			$items[$i]['id'] = $item->slot;
			$items[$i]['name'] = $item->name;
			$items[$i]['age'] = $item->age;
			$items[$i]['distance'] = $item->distance;
			$items[$i]['matches'] = $item->matches;
			$items[$i]['timeout'] = $item->action_timeout;
			$items[$i]['pic'] = '/images/profile/'.$item->avatar;
			$items[$i]['link'] = '/profile/'.$item->slot;
			$items[$i]['cr'] = $item->cr;
			$i++;
		}
		
		//$remain = $profiles->get_count( $cols, $filters, 2 );

		$min_max_age_overall = $model_filters->get_min_max_age_overall();
		//$min_max_age = $model_filters->get_min_max_age( $filters );

		return view( 'find-matches', [ 'profiles' => $items, 'filter_goal' => $filter_goal, 'filter_type' => $filter_type, /* 'remain' => $remain, */ 'min_max_age_overall' => $min_max_age_overall ] );
	}


	public function load_more()
	{
		$filters = array();
		$matches_add = explode( ',', trim( trim( $_GET['matches_add'], '[' ), ']' ) );
		$matches_del = explode( ',', trim( trim( $_GET['matches_del'], '[' ), ']' ) );
		$ids = array_diff( array_unique( array_merge( $matches_add, $matches_del ) ), array('') );

		if ( count( $ids ) == 1 )
			$filters['ids_del'] = implode( '', $ids );
		else
			$filters['ids_del'] = implode( ',', $ids ) != '' ? implode( ',', $ids ) : 0;

		$filters['ids'] = 0;

		$goal = $_COOKIE['matches-filter-goal'] ?? false;
		$type = $_COOKIE['matches-filter-type'] ?? false;
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

		$profiles = new Model_Matches();

		$query = $profiles->get( $cols, $filters, $offset, self::PROFILES_PAGE );
		$i = 0;
		$items = array();
		foreach ( $query as $item )
		{
			$items[$i]['id'] = $item->slot;
			$items[$i]['name'] = $item->name;
			$items[$i]['age'] = $item->age;
			$items[$i]['distance'] = $item->distance;
			$items[$i]['matches'] = $item->matches;
			$items[$i]['pic'] = '/images/profile/'.$item->avatar;
			$items[$i]['link'] = '/profile/'.$item->slot;
			$items[$i]['timeout'] = $item->action_timeout;
			$items[$i]['cr'] = $item->cr;
			$imgs = explode( ',', $item->files );
			$img[] = '/images/profile/'.$item->avatar;
			foreach ( $imgs as $item )
				$img[] = '/images/profile/'.$item;
			$i++;
		}

		$model_filters = new Model_Filters();
		$min_max_age_overall = $model_filters->get_min_max_age_overall();

		return view( 'ajax-load-more-profiles-matches', [ 'profiles' => $items, 'img' => $img, 'min_max_age_overall' => $min_max_age_overall, 'zindex' => $_GET['zindex'] ] );
	}
	
	
	public function load_filter()
	{
		$model_filters = new Model_Filters();
		$filter_goal = $model_filters->get_goal();
		$filter_type = $model_filters->get_type();

		$min_max_age_overall = $model_filters->get_min_max_age_overall();

		return view( 'ajax-load-filter-matches', [ 'filter_goal' => $filter_goal, 'filter_type' => $filter_type, 'min_max_age_overall' => $min_max_age_overall ] );
	}
}