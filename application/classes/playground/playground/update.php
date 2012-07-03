<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Create a new playground.
 * @package Playground
 * @author David Overcash <david@system76.com>
 * @author David Overcash <funnylookinhat@gmail.com>
 */
class Playground_Playground_Update extends Playground_Playground {
	protected $_playground;
	protected $_id;
	protected $_data;

	/**
	 * Playground Create Constructor
	 * @author David  Overcash <david@system76.com>
	 * @author David  Overcash <funnylookinhat@gmail.com>
	 * @param  Array $data    Fields => Values for Playground
	 */
	public function __construct($id,$data)
	{
		$this->_id = $id;
		$this->_data = $data;
		$this->_playground = $this->_load_playground($this->_id);
	}

	public function execute() {
		
		if( ! $this->_playground->loaded() )
			return array(
				'success' => FALSE,
				'error' => "That playground could not be found."
			);

		// Attempt to move data in to playground.
		foreach( $this->_playground->as_array() as $field => $value )
		{
			if( isset($this->_data[$field]) )
				$this->_playground->{$field} = $this->_data[$field];
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