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
			$playgrounds_array[$i++] = $this->_return_playgrounds_array_element($playground);
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
	protected function _return_playgrounds_array_element($playground)
	{
		if( ! $playground OR
			! $playground->loaded() )
		{
			throw new Exception("Invalid Playground.");
		}

		return $playground->as_array();
	}

}