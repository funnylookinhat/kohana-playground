<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Create a new playground.
 * @package Playground
 * @author David Overcash <david@system76.com>
 * @author David Overcash <funnylookinhat@gmail.com>
 */
class Playground_Playground_Create extends Playground_Playground {
	protected $_playground;
	protected $_data;

	/**
	 * Playground Create Constructor
	 * @author David  Overcash <david@system76.com>
	 * @author David  Overcash <funnylookinhat@gmail.com>
	 * @param  Array $data    Fields => Values for Playground
	 */
	public function __construct($data)
	{
		$this->_data = $data;
		$this->_playground = $this->_default_playground();
	}

	public function execute() {
		
		if( isset($this->_data['name']) )
		{
			$this->_playground->name = $this->_data['name'];
		}
		if( isset($this->_data['latitude']) )
		{
			$this->_playground->latitude = $this->_data['latitude'];
		}
		if( isset($this->_data['longitude']) )
		{
			$this->_playground->longitude = $this->_data['longitude'];
		}

		try
		{
			$this->_validate_playground($this->_playground);
			$this->_playground->save();
			return array(
				'success' => TRUE,
				'playground' => $this->_return_playground_element($this->_playground)
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