<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Delete a new playground.
 * @package Playground
 * @author David Overcash <david@system76.com>
 * @author David Overcash <funnylookinhat@gmail.com>
 */
class Playground_Playground_Delete extends Playground_Playground {
	protected $_playground;
	protected $_id;

	/**
	 * Playground Create Constructor
	 * @author David  Overcash <david@system76.com>
	 * @author David  Overcash <funnylookinhat@gmail.com>
	 * @param  Array $data    Fields => Values for Playground
	 */
	public function __construct($id)
	{
		$this->_id = $id;
		$this->_playground = $this->_load_playground($this->_id);
	}

	public function execute() {
		
		if( ! $this->_playground->loaded() )
			return array(
				'success' => FALSE,
				'error' => "That playground could not be found."
			);

		$this->_playground->delete();

		return array(
			'success' => TRUE
		);

	}

}