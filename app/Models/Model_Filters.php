<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Model_Filters extends Model_Base
{
	const
		TABLE_GOAL = 'filter_goal',
		TABLE_TYPE = 'filter_type';


	public function get_goal()
	{
		$query = DB::table( self::TABLE_GOAL )
									->select( 'id', 'name' )
									->orderBy( 'number', 'asc' )
									->get();

		if ( ! $query )
		{
			return false;
		}

		$i = 0;
		foreach ( $query as $key => $row )
		{
			$results[$i]['id'] = $row->id;
			$results[$i]['name'] = $row->name;
			$i++;
		}

		return $results;
	}


	public function get_type()
	{
		$query = DB::table( self::TABLE_TYPE )
									->select( 'id', 'name' )
									->orderBy( 'number', 'asc' )
									->get();

		if ( ! $query )
		{
			return false;
		}

		$i = 0;
		foreach ( $query as $key => $row )
		{
			$results[$i]['id'] = $row->id;
			$results[$i]['name'] = $row->name;
			$i++;
		}

		return $results;
	}
	
	
	public function get_min_max_age( $filters ) : array // используется ли это еще ?
	{
		$_goal = $_GET['filter-goal'] ?? $filters['goal'];
		$_type = $_GET['filter-type'] ?? $filters['type'];

		$tables = '';
		$tables .= $_goal != 0 ? ', profiles_goal' : '';
		$tables .= $_type != 0 ? ', profiles_type' : '';

		$where = ( $_goal != 0 || $_type != 0 ) ? 'WHERE ' : '';

		$goal = ( $_goal != 0 ) ? '( profiles.slot=profiles_goal.user_id AND profiles_goal.goal_id='.$_goal.' ) ' : '';

		$type = '';
		if ( $_goal != 0 && $_type != 0 )
			$type = ( $_type != 0 ) ? ' AND profiles.slot=profiles_type.user_id AND profiles_type.type_id='.$_type : '';
		elseif ( $_goal == 0 && $_type != 0 )
			$type = ( $_type != 0 ) ? ' profiles.slot=profiles_type.user_id AND profiles_type.type_id='.$_type : '';

		$query = DB::select(
			DB::raw( '
				SELECT MAX( age ) AS "max_age", MIN( age ) AS "min_age"
				FROM profiles'.$tables.'
				'.$where.$goal.$type.'
			' )
		);
		$query = DB::select(
			DB::raw( '
				SELECT MAX( age ) AS "max_age", MIN( age ) AS "min_age"
				FROM profiles
			' )
		);
		foreach ( $query as $key => $val )
		{
			$results['min-age'] = $val->min_age;
			$results['max-age'] = $val->max_age;
		}

		return $results;
	}
	
	
	public function get_min_max_age_overall() : array
	{
		$query = DB::select(
			DB::raw( '
				SELECT MAX( age ) AS "max_age", MIN( age ) AS "min_age"
				FROM profiles
			' )
		);

		foreach ( $query as $key => $val )
		{
			$results['min-age'] = $val->min_age;
			$results['max-age'] = $val->max_age;
		}

		return $results;
	}
}
?>