<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground_Search extends Playground_Playground {
	
	protected $playgrounds;
	private $page;
	private $page_size;
	private $sort_by_field;
	private $sort_by_direction;

	/**
	 * Constructs a Playground_Search class.
	 * @author David Overcash <david@system76.com>
	 * @author David Overcash <funnylookinhat@gmail.com>
	 * @param  integer $page      Page to return for results.
	 * @param  integer $page_size Default page size for results.
	 * @param  array   $sort_by  Array with "field" and "direction" to sort results.
	 */
	public function __construct($page = 0, $page_size = 50,$sort_by = array())
	{
		$this->playgrounds = ORM::Factory('playground');
		$this->page = $page;
		$this->page_size = $page_size;
		$this->sort_by_field = FALSE;
		if( is_array($sort_by) AND
			isset($sort_by['field']) )
		{
			$this->sort_by_field = $sort_by['field'];
		}
		$this->sort_by_direction = FALSE;
		if( is_array($sort_by) AND
			isset($sort_by['direction']) )
		{
			$this->sort_by_direction = $sort_by['direction'];
		}
	}

	/**
	 * Runs the query through ORM and returns the results.
	 * @author David  Overcash      <david@system76.com>
	 * @author David  Overcash      <funnylookinhat@gmail.com>
	 * @return Array of Model_ORM
	 * @throws Exeption If invalid $page
	 * @throws Exception If invalid $page_size
	 * @throws Exception If invalid $sort_by['field']
	 * @throws Exception If invalid $ordery_by['direction']
	 */
	protected function _find_results() {

		if( $this->page < 0 )
		{
			throw new Exception("Invalid page - must be greater than or equal to 0.");
		}
		elseif( $this->page_size < 1 )
		{
			throw new Exception("Invalid page size - must be greater than or equal to 1.");
		}

		$this->playgrounds = $this->playgrounds->limit($this->page_size)->offset($this->page*$this->page_size);
		
		if( $this->sort_by_field OR
			$this->sort_by_direction )
		{
			if( ! in_array($this->sort_by_field, array('id','name','latitude','longitude')) )
			{
				throw new Exception("Invalid sort field.");
			}
			elseif( ! in_array($this->sort_by_direction, array('asc','desc')) )
			{
				throw new Exception("Invalid sort direction.");
			}
			$this->playgrounds = $this->playgrounds->order_by($this->sort_by_field,$this->sort_by_direction);
		}

		return $this->playgrounds->find_all();

	}

}