<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Model_Matches extends Model_Base
{
	


	function get( $cols = array(), $filters = array(), $offset = 0, $limit = 1 )
	{
		$cols = implode( ', ', $cols );

		$tables = '';
		$tables .= $filters['goal'] != 0 ? ', profiles_goal' : '';
		$tables .= $filters['type'] != 0 ? ', profiles_type' : '';

		$where = self::query_where( $filters );

		$query = DB::select(
			DB::raw( '
				SELECT
							'.$cols.',
							GROUP_CONCAT( DISTINCT profiles_photo.file ) AS files
				FROM
						profiles, profiles_photo'.$tables.'
				'.$where.'
				GROUP BY
								'.$cols.'
				ORDER BY
								cr DESC, distance DESC, slot ASC
				LIMIT
						'.$limit.'
				
			' )
		);

		return $query;
	}
	
	
	/* function get_count( $cols = array(), $filters = array(), $offset = 0 )
	{
		$cols = implode( ', ', $cols );

		$tables = '';
		$tables .= $filters['goal'] != 0 ? ', profiles_goal' : '';
		$tables .= $filters['type'] != 0 ? ', profiles_type' : '';

		$where = self::query_where( $filters );

		$query = DB::select(
			DB::raw( '
				SELECT '.$cols.' 
				FROM profiles'.$tables.'
				'.$where.'
				ORDER BY cr DESC, slot ASC
				OFFSET '.$offset.' ROWS
			' )
		);
		
		$remain = count( $query );

		return (int) $remain;
	} */


	public function query_where( $filters = array() ) : string
	{
		$str = '';

		$where = 'WHERE ';
		//$where = ( $filters['ids'] != 0 || $filters['ids_del'] != 0 || $filters['goal'] != 0 || $filters['type'] != 0 || $filters['min-age'] != 0 || $filters['max-age'] != 0 || $filters['distance'] != 0 || $filters['big-city'] === false ) ? 'WHERE ' : '';

		$where_if = array();
		$where_if[] = ( $filters['ids'] != 0 ) ? ' profiles.slot IN ( '.$filters['ids'].' ) ' : '';
		$where_if[] = ( $filters['ids_del'] != 0 ) ? ' profiles.slot NOT IN ( '.$filters['ids_del'].' ) ' : '';
		$where_if[] = ( $filters['goal'] != 0 ) ? ' ( profiles.slot=profiles_goal.user_id AND profiles_goal.goal_id='.$filters['goal'].' ) ' : '';
		$where_if[] = ( $filters['type'] != 0 ) ? ' ( profiles.slot=profiles_type.user_id AND profiles_type.type_id='.$filters['type'].' ) ' : '';
		$where_if[] = ( $filters['min-age'] != 0 ) ? ' profiles.age>='.$filters['min-age'] : '';
		$where_if[] = ( $filters['max-age'] != 0 ) ? ' profiles.age<='.$filters['max-age'] : '';
		$where_if[] = ( $filters['distance'] != 0 ) ? ' profiles.distance<='.$filters['distance'] : '';
		$where_if[] = ( $filters['big-city'] === false ) ? ' profiles.small_city=1' : '';
		$where_if[] = ' ( profiles_photo.profile_id=profiles.slot AND profiles_photo.chat=0 )';

		$if = '';
		$and = ' AND';
		$first = 'y';
		foreach ( $where_if as $key => $row )
		{
			if ( $first == 'y' && $row != '' )
			{
				$if .= $row;
				$first = 'n';
			}
			elseif ( $first != 'y' && $row != '' )
			{
				$if .= $and.$row;
			}
		}
		
		$str = $where.$if;

		return $str;
	}
}
