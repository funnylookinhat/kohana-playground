<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground_Search_Geo extends Playground_Playground_Search {
	protected $_latitude_min;
	protected $_latitude_max;
	protected $_longitude_min;
	protected $_longitude_max;
	
	public function __construct($latitude_min = 0,$latitude_max = 0, $longitude_min = 0, $longitude_max = 0, $page = 0, $page_size = 50,$sort_by = array())
	{
		parent::__construct($page,$page_size,$sort_by);
		$this->_latitude_min = floatval($latitude_min);
		$this->_latitude_max = floatval($latitude_max);
		$this->_longitude_min = floatval($longitude_min);
		$this->_longitude_max = floatval($longitude_max);
	}

	public function execute()
	{
		try
		{
			$this->_playgrounds = $this->_playgrounds->
				where('latitude','>=',$this->_latitude_min)->
				where('latitude','<=',$this->_latitude_max)->
				where('longitude','>=',$this->_longitude_min)->
				where('longitude','<=',$this->_longitude_max);

			$playground_results = $this->_find_results();
			
			return array(
				'success' => TRUE,
				'playgrounds' => $this->_return_playgrounds_array($playground_results)
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