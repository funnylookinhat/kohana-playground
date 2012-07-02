<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller {

	function action_index() {

		$playground_search_id = new Playground_Playground_Search_Id(1);
		$result = $playground_search_id->execute();
		echo $this->dump_result($result);
		echo '<br>';

		$playground_search_id = new Playground_Playground_Search_Id(5);
		$result = $playground_search_id->execute();
		echo $this->dump_result($result);
		echo '<br>';

		echo '<hr>';

		$playground_search_name = new Playground_Playground_Search_Name('test');
		$result = $playground_search_name->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		echo '<h2>Page Size: 2</h2>';

		$playground_search_name = new Playground_Playground_Search_Name('test',0,2);
		$result = $playground_search_name->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		$playground_search_name = new Playground_Playground_Search_Name('test',1,2);
		$result = $playground_search_name->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		echo '<h2>Page Size: 3. Sort Order Reverse ID</h2>';

		$playground_search_name = new Playground_Playground_Search_Name('test',0,3,array('field' => 'id','direction' => 'desc'));
		$result = $playground_search_name->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		$playground_search_name = new Playground_Playground_Search_Name('test',1,3,array('field' => 'id','direction' => 'desc'));
		$result = $playground_search_name->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		$playground_search_name = new Playground_Playground_Search_Name('this cannot be found');
		$result = $playground_search_name->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		echo '<h2>GEO SEARCH SORT LAT ASC</h2>';

		$playground_search_geo = new Playground_Playground_Search_Geo(4,15,0,100,0,50,array('field' => 'latitude','direction' => 'asc'));
		$result = $playground_search_geo->execute();
		echo $this->dump_result($result);
		echo '<hr>';

		die('done');

	}

	private function dump_result($result) {
		$string = '';
		$string .= ( $result['success'] ? "SUCCESS" : "FAILURE" ).'<br>';
		if( ! $result['success'] ) {
			$string .= ( isset($result['error']) ? $result['error'] : 'UNKNOWN/UNCAUGHT ERROR' ).'<br>';
		} else {
			$string .=  "Playgrounds: ".count($result['playgrounds']).'<br>';
			foreach( $result['playgrounds'] as $playground ) {
				$string .=  '&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .=  $playground['id'].' ';
				$string .=  $playground['name'].' ';
				$string .=  $playground['latitude'].' ';
				$string .=  $playground['longitude'].' ';
				$string .=  '<br>';
			}
		}
		return $string;
	}

}