<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground_Search_Id extends Playground_Playground_Search {
	protected $id;

	public function __construct($id = FALSE)
	{
		parent::__construct();
		$this->id = $id;
	}

	public function execute()
	{
		try
		{
			$this->_playgrounds = $this->_playgrounds->where('id','=',$this->id);
			
			$playground_results = $this->_find_results();

			if( ! $playground_results OR
				! count($playground_results) )
			{
				return array(
					'success' => FALSE,
					'error' => "That ID was not found.",
					'playgrounds' => array()
				);
			}

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