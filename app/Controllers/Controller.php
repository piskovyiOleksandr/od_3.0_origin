<?php

namespace App\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;


class Controller extends BaseController
{
	//use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	//protected $big_cities;


	public function __construct()
	{
		session_start();


		$big_cities = ['Abilene', 'Akron', 'Albuquerque', 'Alexandria', 'Allen', 'Allentown', 'Amarillo', 'Anaheim', 'Anchorage', 'Ann Arbor', 'Antioch', 'Arlington', 'Arvada', 'Athens', 'Atlanta', 'Augusta', 'Aurora', 'Austin', 'Bakersfield', 'Baltimore', 'Baton Rouge', 'Beaumont', 'Bellevue', 'Berkeley', 'Billings', 'Birmingham', 'Boise', 'Boston', 'Boulder', 'Bridgeport', 'Brockton', 'Broken Arrow', 'Brownsville', 'Buffalo', 'Burbank', 'Cambridge', 'Cape Coral', 'Carlsbad', 'Carrollton', 'Cary', 'Cedar Rapids', 'Centennial', 'Chandler', 'Charleston', 'Charlotte', 'Chattanooga', 'Chesapeake', 'Chicago', 'Chico', 'Chula Vista', 'Cincinnati', 'Clarksville', 'Clearwater', 'Cleveland', 'Clinton', 'Clovis', 'College Station', 'Colorado Springs', 'Columbia', 'Columbus', 'Concord', 'Coral Springs', 'Corona', 'Corpus Christi', 'Costa Mesa', 'Dallas', 'Daly City', 'Davenport', 'Davie', 'Dayton', 'Dearborn', 'Denton', 'Denver', 'Des Moines', 'Detroit', 'Downey', 'Durham', 'Edinburg', 'Edison', 'El Cajon', 'El Monte', 'El Paso', 'Elgin', 'Elizabeth', 'Elk Grove', 'Escondido', 'Eugene', 'Evansville', 'Everett', 'Fairfield', 'Fargo', 'Fayetteville', 'Federal Way', 'Fontana', 'Fort Collins', 'Fort Lauderdale', 'Fort Wayne', 'Fort Worth', 'Fremont', 'Fresno', 'Frisco', 'Fullerton', 'Gainesville', 'Garden Grove', 'Garland', 'Gilbert', 'Glendale', 'Grand Prairie', 'Grand Rapids', 'Greeley', 'Green Bay', 'Greensboro', 'Gresham', 'Hampton', 'Hartford', 'Hayward', 'Henderson', 'Hialeah', 'High Point', 'Hillsboro', 'Hollywood', 'Honolulu', 'Houston', 'Huntington Beach', 'Huntsville', 'Independence', 'Indianapolis', 'Inglewood', 'Irvine', 'Irving', 'Jackson', 'Jacksonville', 'Jersey City', 'Joliet', 'Jurupa Valley', 'Kansas City', 'Kent', 'Killeen', 'Knoxville', 'Lafayette', 'Lakeland', 'Lakewood', 'Lancaster', 'Lansing', 'Laredo', 'Las Cruces', 'Las Vegas', 'League City', 'Lee\'s Summit', 'Lewisville', 'Lexington', 'Lincoln', 'Little Rock', 'Long Beach', 'Los Angeles', 'Louisville', 'Lowell', 'Lubbock', 'Lynn', 'Macon', 'Madison', 'Manchester', 'McAllen', 'McKinney', 'Memphis', 'Menifee', 'Meridian', 'Mesa', 'Mesquite', 'Miami', 'Miami Gardens', 'Midland', 'Milwaukee', 'Minneapolis', 'Miramar', 'Mobile', 'Modesto', 'Montgomery', 'Moreno Valley', 'Murfreesboro', 'Murrieta', 'Nampa', 'Naperville', 'Nashville', 'New Bedford', 'New Haven', 'New Orleans', 'New York', 'Newark', 'Newport News', 'Norfolk', 'Norman', 'North Charleston', 'North Las Vegas', 'Norwalk', 'Oakland', 'Oceanside', 'Odessa', 'Oklahoma City', 'Olathe', 'Omaha', 'Ontario', 'Orange', 'Orlando', 'Overland Park', 'Oxnard', 'Palm Bay', 'Palmdale', 'Pasadena', 'Paterson', 'Pearland', 'Pembroke Pines', 'Peoria', 'Philadelphia', 'Phoenix', 'Pittsburgh', 'Plano', 'Pomona', 'Pompano Beach', 'Port St. Lucie', 'Portland', 'Providence', 'Provo', 'Pueblo', 'Quincy', 'Raleigh', 'Rancho Cucamonga', 'Reno', 'Renton', 'Rialto', 'Richardson', 'Richmond', 'Rio Rancho', 'Riverside', 'Roanoke', 'Rochester', 'Rockford', 'Roseville', 'Round Rock', 'Sacramento', 'Saint Paul', 'Salem', 'Salinas', 'Salt Lake City', 'San Antonio', 'San Bernardino', 'San Diego', 'San Francisco', 'San Jose', 'San Mateo', 'Sandy Springs', 'Santa Ana', 'Santa Clara', 'Santa Clarita', 'Santa Maria', 'Santa Rosa', 'Savannah', 'Scottsdale', 'Seattle', 'Shreveport', 'Simi Valley', 'Sioux Falls', 'South Bend', 'South Fulton', 'Sparks', 'Spokane', 'Spokane Valley', 'Springfield', 'St. Louis', 'St. Petersburg', 'Stamford', 'Sterling Heights', 'Stockton', 'Sugar Land', 'Sunnyvale', 'Surprise', 'Syracuse', 'Tacoma', 'Tallahassee', 'Tampa', 'Temecula', 'Tempe', 'Thornton', 'Thousand Oaks', 'Toledo', 'Topeka', 'Torrance', 'Tucson', 'Tulsa', 'Tyler', 'Vacaville', 'Vallejo', 'Vancouver', 'Ventura', 'Victorville', 'Virginia Beach', 'Visalia', 'Waco', 'Warren', 'Washington', 'Waterbury', 'West Covina', 'West Jordan', 'West Palm Beach', 'West Valley City', 'Westminster', 'Wichita', 'Wichita Falls', 'Wilmington', 'Winston–Salem', 'Woodbridge', 'Worcester', 'Yonkers'];


		//view()->share('sharedVar', 'some value');
		//view::share( $big_cities );

		$this->big_cities = $big_cities;


		if ( ! isset( $_SESSION["big-city"] ) )
		{

			if ( isset( $_GET['city'] ) && in_array( $_GET['city'], $big_cities ) && isset( $_GET['country'] ) && $_GET['country'] == 'US' )
				$_SESSION["big-city"] = true;
			elseif ( isset( $_GET['city'] ) && ! in_array( $_GET['city'], $big_cities ) && isset( $_GET['country'] ) && $_GET['country'] == 'US' )
				$_SESSION["big-city"] = false;
			elseif ( ! isset( $_GET['city'] ) && isset( $_GET['country'] ) && $_GET['country'] == 'US' )
				$_SESSION["big-city"] = true;

		}
		else
		{
			if ( isset( $_GET['city'] ) && in_array( $_GET['city'], $big_cities ) && isset( $_GET['country'] ) && $_GET['country'] == 'US' )
				$_SESSION["big-city"] = true;
			elseif ( isset( $_GET['city'] ) && ! in_array( $_GET['city'], $big_cities ) && isset( $_GET['country'] ) && $_GET['country'] == 'US' )
				$_SESSION["big-city"] = false;
			elseif ( ! isset( $_GET['city'] ) && isset( $_GET['country'] ) && $_GET['country'] == 'US' )
				$_SESSION["big-city"] = true;
		}


		if ( isset( $_GET['country'] ) && ! empty( $_GET['country'] ) )
			$_SESSION["user-country"] = $_GET['country'];
		elseif ( ! isset( $_SESSION["user-country"] ) )
			$_SESSION["user-country"] = '';

		if ( isset( $_GET['city'] ) && ! empty( $_GET['city'] ) )
			$_SESSION["user-city"] = $_GET['city'];
		elseif ( ! isset( $_SESSION["user-city"] ) )
			$_SESSION["user-city"] = '';
	}


	public function dump( $array = array() )
	{
		$result = '';
		$result .= '<pre>'.print_r( $array ).'</pre>';
		return $result;
	}
}
