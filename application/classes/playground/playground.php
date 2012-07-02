<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground extends Playground {

	/**
	 * Returns an array of formatted array elements representing $playgrounds.
	 * @param  Array $playgrounds : an iterative array of Model_Playground
	 * @return Array of Playground Elements
	 * @author David Overcash <david@system76.com>
	 * @author David Overcash <funnylookinhat@gmail.com>
	 * @throws Exception If invalid Model_Playground
	 */
	protected function _return_playgrounds_array($playgrounds)
	{
		$playgrounds_array = array();
		$i = 0;
		foreach( $playgrounds as $playground ) {
			$playgrounds_array[$i++] = $this->_return_playground_element($playground);
		}
		return $playgrounds_array;
	}

	/**
	 * Returns a formatted array element with the information for a Model_Playground.
	 * @param  Model_Playground $playground - A Model_Playground object.
	 * @return Array : An array defining the values of a Model_Playground
	 * @author David Overcash <david@system76.com>
	 * @author David Overcash <funnylookinhat@gmail.com>
	 * @throws Exception If invalid Model_Playground
	 */
	protected function _return_playground_element($playground)
	{
		if( ! $playground OR
			! $playground->loaded() )
		{
			throw new Exception("Invalid Playground.");
		}

		return $playground->as_array();
	}

	/**
	 * Return Default Playground Values
	 * @author David  Overcash      <david@system76.com>
	 * @author David  Overcash      <funnylookinhat@gmail.com>
	 * @return Model_Playground Model_Playground with default values.
	 */
	protected function _default_playground()
	{
		$playground = ORM::Factory('playground');
		$playground->name = "No name.";
		$playground->latitude = 0;
		$playground->longitude = 0;
		return $playground;
	}

	/**
	 * Validates a Model_Playground
	 * @author David  Overcash    <david@system76.com>
	 * @author David  Overcash    <funnylookinhat@gmail.com>
	 * @param  Model_Playground $playground The Playground to validate.
	 * @return void             
	 * @throws Exception If invalid $playground->name
	 * @throws Exception If invalid $playground->latitude
	 * @throws Exception If invalid $playground->longitude
	 */
	protected function _validate_playground($playground)
	{
		if( ! strlen($playground->name) )
		{
			throw new Exception("Invalid name.");
		}
		elseif( ! is_numeric($playground->latitude) OR
				floatval($playground->latitude) != $playground->latitude )
		{
			throw new Exception("Invalid latitude.");
		}
		elseif( ! is_numeric($playground->longitude) OR
				floatval($playground->longitude) != $playground->longitude )
		{
			throw new Exception("Invalid longitude.");
		}
	}

}