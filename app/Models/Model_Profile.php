<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Model_Profile extends Model_Base
{
	


	public function get( $id )
	{
		/* $query = DB::table( 'profiles' )
								->select( 'profiles.slot', 'profiles.active', 'profiles.status', 'profiles.name', 'profiles.age', 'profiles.distance', 'profiles.description', 'profiles.avatar', 'profiles.link', DB::raw('GROUP_CONCAT(DISTINCT profiles_photo.file) AS files') )
								->where( 'slot', $id )
								->join( 'profiles_photo', 'profiles_photo.profile_id', '=', 'profiles.slot' )
								->where( 'profiles_photo.chat', 0 )
								->groupby( 'profiles.slot', 'profiles.active', 'profiles.status', 'profiles.name', 'profiles.age', 'profiles.distance', 'profiles.description', 'profiles.avatar', 'profiles.link' )
								->get(); */
		$query = DB::select(
			DB::raw( '
				SELECT profiles.slot, profiles.active, profiles.status, profiles.name, profiles.age, profiles.distance, profiles.description, profiles.avatar, profiles.link, GROUP_CONCAT( DISTINCT profiles_photo.file ) AS files
				FROM profiles
				LEFT JOIN profiles_photo ON ( profiles_photo.profile_id='.$id.' AND profiles_photo.chat=0 )
				WHERE profiles.slot='.$id.'
				GROUP BY profiles.slot, profiles.active, profiles.status, profiles.name, profiles.age, profiles.distance, profiles.description, profiles.avatar, profiles.link
			' )
		);

		return $query;
	}


	public function get_spec_goal( $id )
	{
		$query = DB::select('
			SELECT filter_goal.name as goal_name, filter_goal.id as goal_id
			FROM `filter_goal`
			JOIN `profiles_goal` ON ( profiles_goal.user_id='.$id.' AND profiles_goal.goal_id=filter_goal.id )
			ORDER BY filter_goal.number asc
		');

		return $query;
	}
	
	
	public function get_spec_type( $id )
	{
		$query = DB::select('
			SELECT filter_type.name as type_name, filter_type.id as type_id
			FROM `filter_type`
			JOIN `profiles_type` ON ( profiles_type.user_id='.$id.' AND profiles_type.type_id=filter_type.id )
			ORDER BY filter_type.number asc
		');

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
}
?>