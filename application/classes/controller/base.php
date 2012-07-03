<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller {

	function action_index() {

		if( Session::instance()->get('message') ) {
			echo "<h2>".Session::instance()->get('message')."</h2>";
			Session::instance()->delete('message');
		}

		$playground_search = new Playground_Playground_Search();
		$result = $playground_search->execute();
		echo '<table>';
		echo '<tr>';
		echo '<td style="width: 100px;">ID</td>';
		echo '<td style="width: 200px;">Name</td>';
		echo '<td style="width: 100px;">Latitude</td>';
		echo '<td style="width: 100px;">Longitude</td>';
		echo '<td style="width: 100px;">&nbsp;</td>';
		echo '</tr>';

		foreach( $result['playgrounds'] as $playground )
		{
			echo '<tr>';
			echo '<td style="width: 100px;">'.$playground['id'].'</td>';
			echo '<td style="width: 200px;">'.$playground['name'].'</td>';
			echo '<td style="width: 100px;">'.number_format($playground['latitude'],6,'.','').'</td>';
			echo '<td style="width: 100px;">'.number_format($playground['longitude'],6,'.','').'</td>';
			echo '<td style="width: 100px;"><a href="/base/delete/'.$playground['id'].'">Delete</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<hr>';

		echo 'Create New Playground<br>';
		echo '<form action="/base/create/" method="POST">';
		echo '<table>';
		
		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">Name:</td>';
		echo '<td style="width: 200px;"><input type="text" name="new_name"></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">Latitude:</td>';
		echo '<td style="width: 200px;"><input type="text" name="new_lat"></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">Longitude:</td>';
		echo '<td style="width: 200px;"><input type="text" name="new_lon"></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">&nbsp;</td>';
		echo '<td style="width: 200px;"><input type="submit"></td>';
		echo '</tr>';

		echo '</table>';
		echo '</form>';

		echo '<hr>';

		echo 'Update Playground<br>';
		echo '<form action="/base/update/" method="POST">';
		echo '<table>';
		
		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">ID:</td>';
		echo '<td style="width: 200px;"><input type="text" name="update_id"></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">Name:</td>';
		echo '<td style="width: 200px;"><input type="text" name="update_name"></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">Latitude:</td>';
		echo '<td style="width: 200px;"><input type="text" name="update_lat"></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">Longitude:</td>';
		echo '<td style="width: 200px;"><input type="text" name="update_lon"></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td style="width: 100px; text-align:right;">&nbsp;</td>';
		echo '<td style="width: 200px;"><input type="submit"></td>';
		echo '</tr>';

		echo '</table>';

		echo '</form>';

		die();

	}

	function action_delete() {

		$playground_id = $this->request->param('id');

		$playground_delete = new Playground_Playground_Delete($playground_id);
		$result = $playground_delete->execute();

		if( $result['success'] )
			Session::instance()->set('message',"Deleted playground with ID ".$playground_id);
		else
			Session::instance()->set('message',"Delete Error: ".$result['error']);

		$this->request->redirect('/');

	}

	function action_create()
	{
		if( count($this->request->post()) )
		{
			$playground_create = new Playground_Playground_Create(array(
				'name' => $this->request->post('new_name'),
				'latitude' => $this->request->post('new_lat'),
				'longitude' => $this->request->post('new_lon')
			));
			$result = $playground_create->execute();
			if( $result['success'] )
				Session::instance()->set('message',"Created new playground: ".$result['playground']['name']);
			else
				Session::instance()->set('message',"Creation error: ".$result['error']);
		}
		$this->request->redirect('/');
	}

	function action_update()
	{
		if( count($this->request->post()) )
		{
			
			$data = array();
			if( $this->request->post('update_name') )
				$data['name'] = $this->request->post('update_name');
			if( $this->request->post('update_lat') )
				$data['latitude'] = $this->request->post('update_lat');
			if( $this->request->post('update_lon') )
				$data['longitude'] = $this->request->post('update_lon');

			$playground_update = new Playground_Playground_Update($this->request->post('update_id'),$data);
			$result = $playground_update->execute();

			if( $result['success'] )
				Session::instance()->set('message',"Updated playground: ".$result['playground']['name']);
			else
				Session::instance()->set('message',"Update error: ".$result['error']);

		}
		$this->request->redirect('/');
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