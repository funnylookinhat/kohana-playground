<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller {

	function action_index() {

		if( count($this->request->post()) ) {
			$playground_create = new Playground_Playground_Create(array(
				'name' => $this->request->post('new_name'),
				'latitude' => $this->request->post('new_lat'),
				'longitude' => $this->request->post('new_lon')
			));
			$result = $playground_create->execute();
			if( $result['success'] ) {
				echo "Created new playground: ".$result['playground']['name'];
			} else {
				echo "Creation error: ".$result['error'];
			}
			echo '<hr>';
		}

		$playground_search = new Playground_Playground_Search();
		$result = $playground_search->execute();
		echo $this->dump_result($result);
		echo '<br>';
		
		echo '<hr>';

		echo 'Create New Playground<br>';
		echo '<form action="" method="POST">';
		echo 'Name: <input type="text" name="new_name"><br>';
		echo 'Lat: <input type="text" name="new_lat"><br>';
		echo 'Lon: <input type="text" name="new_lon"><br>';
		echo '<input type="submit"><br>';
		echo '</form>';

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