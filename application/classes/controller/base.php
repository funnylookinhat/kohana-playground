<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller {

	function action_index() {
		
		$playground_search = new Context_Playground_Search();
		
		// Test by_id
		$result = $playground_search->by_id(1);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo '<br>';
		
		$result = $playground_search->by_id(2);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo '<br>';

		$result = $playground_search->by_geo(0,0,0,0);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo '<br>';

		$result = $playground_search->by_geo(5,15,0,40);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo '<br>';
		
		//
		echo '<hr>';
		$playground_search = new Context_Playground_Search(0,1);
		$result = $playground_search->by_geo(-100,100,-100,100);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo ' ::: '.$result['playgrounds'][0]['name'];
		echo '<br>';
		
		$playground_search = new Context_Playground_Search(1,1);
		$result = $playground_search->by_geo(-100,100,-100,100);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo ' ::: '.$result['playgrounds'][0]['name'];
		echo '<br>';
		
		$playground_search = new Context_Playground_Search(2,1);
		$result = $playground_search->by_geo(-100,100,-100,100);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo ' ::: '.$result['playgrounds'][0]['name'];
		echo '<br>';
		
		//
		echo '<hr>';

		$playground_search = new Context_Playground_Search(0,2,array('field' => 'id','direction' => 'DESC'));
		$result = $playground_search->by_geo(-100,100,-100,100);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo ' ::: '.$result['playgrounds'][0]['name'].', '.$result['playgrounds'][1]['name'];
		echo '<br>';
		
		$playground_search = new Context_Playground_Search(1,2,array('field' => 'id','direction' => 'DESC'));
		$result = $playground_search->by_geo(-100,100,-100,100);
		echo ( $result['success'] ? "Success: ".count($result['playgrounds']) : "Failure: ".$result['error'] );
		echo ' ::: '.$result['playgrounds'][0]['name'].', '.$result['playgrounds'][1]['name'];
		echo '<br>';
		
		die('done');

	}

	function action_create() {

	}

}