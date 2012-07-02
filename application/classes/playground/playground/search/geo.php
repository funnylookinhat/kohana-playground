<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground_Search_Geo extends Playground_Playground_Search {
	protected $latitude_min;
	protected $latitude_max;
	protected $longitude_min;
	protected $longitude_max;
	
	public function __construct($latitude_min = 0,$latitude_max = 0, $longitude_min = 0, $longitude_max = 0, $page = 0, $page_size = 50,$sort_by = array())
	{
		parent::__construct($page,$page_size,$sort_by);
		$this->latitude_min = floatval($latitude_min);
		$this->latitude_max = floatval($latitude_max);
		$this->longitude_min = floatval($longitude_min);
		$this->longitude_max = floatval($longitude_max);
	}

	public function execute()
	{
		try
		{
			$this->playgrounds = $this->playgrounds->
				where('latitude','>=',$this->latitude_min)->
				where('latitude','<=',$this->latitude_max)->
				where('longitude','>=',$this->longitude_min)->
				where('longitude','<=',$this->longitude_max);

			$playground_results = $this->_find_results();
			
			$playgrounds_array = $this->_return_playgrounds_array($playground_results);

			return array(
				'success' => TRUE,
				'playgrounds' => $playgrounds_array
			);
		}
		catch( Exception $e )
		{
			return array(
				'success' => FALSE,
				'error' => $e->getMessage()
			);
		}
	}

}