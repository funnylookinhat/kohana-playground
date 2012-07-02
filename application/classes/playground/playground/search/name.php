<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground_Search_Name extends Playground_Playground_Search {
	protected $name;

	public function __construct($name = FALSE,$page = 0, $page_size = 50,$sort_by = array())
	{
		parent::__construct($page,$page_size,$sort_by);
		$this->name = $name;
	}

	public function execute()
	{
		try
		{
			$this->playgrounds = $this->playgrounds->where('name','LIKE','%'.$this->name.'%');
			
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