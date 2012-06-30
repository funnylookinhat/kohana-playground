<?php defined('SYSPATH') or die('No direct script access.');

class Context_Playground_Search {

	private $playgrounds;

	public function __construct()
	{
		$this->playgrounds = ORM::Factory('playground');
	}

	public function by_id($id = FALSE)
	{
		if( ! $id )
		{
			return array(
				'success' => FALSE, 
				'error' => 'No valid ID was provided.', 
				'playgrounds' => array()
			);
		}

		$playgrounds = $this->playgrounds->where('id','=',$id)->find_all();

		if ( ! count($playgrounds) )
		{
			return array(
				'success' => FALSE, 
				'error' => 'That Playground was not found.', 
				'playgrounds' => array()
			);
		}

		$playgrounds_array_data = array();
		try {
			$playgrounds_array = new Playgrounds_Array($playgrounds);
			$playgrounds_array_data = $playgrounds_array->return_data();
		}
		catch( Exception $e )
		{
			return array(
				'success' => FALSE,
				'error' => $e->getMessage(),
				'playgrounds' => $playgrounds_array_data
			);
		}

		return array(
			'success' => TRUE,
			'playgrounds' => $playgrounds_array_data
		);
	}

	public function by_geo($latitude_minimum = 0,$latitude_maximum = 0,$longitude_minimum = 0,$longitude_maximum = 0)
	{
		// Clean our input data.
		$latitude_minimum = floatval($latitude_minimum);
		$latitude_maximum = floatval($latitude_maximum);
		$longitude_minimum = floatval($longitude_minimum);
		$longitude_maximum = floatval($longitude_maximum);

		$playgrounds = $this->playgrounds->
			where('latitude','>=',$latitude_minimum)->
			where('latitude','<=',$latitude_maximum)->
			where('longitude','>=',$longitude_minimum)->
			where('longitude','>=',$longitude_maximum)->
			find_all();

		$playgrounds_array_data = array();
		try {
			$playgrounds_array = new Playgrounds_Array($playgrounds);
			$playgrounds_array_data = $playgrounds_array->return_data();
		}
		catch( Exception $e )
		{
			return array(
				'success' => FALSE,
				'error' => $e->getMessage(),
				'playgrounds' => $playgrounds_array_data
			);
		}

		return array(
			'success' => TRUE,
			'playgrounds' => $playgrounds_array_data
		);
	}

}

class Playgrounds_Array {

	private $playgrounds;

	public function __construct($playgrounds)
	{
		$this->playgrounds = $playgrounds;
	}

	public function return_data()
	{
		$playgrounds_array = array();
		$i = 0;

		foreach( $this->playgrounds as $playground )
		{
			$playground_data = new Playground_Data($playground);
			$playgrounds_array[$i++] = $playground_data->return_data();
		}

		return $playgrounds_array;
	}

}

class Playground_Data {
	
	private $playground;
	
	public function __construct($playground)
	{
		$this->playground = $playground;
	}

	public function return_data()
	{
		if( ! $this->playground OR
			! $this->playground->loaded())
		{
			throw new Exception("Could not load playground data.");
		}
		return $this->playground->as_array();
	}

}