<?php defined('SYSPATH') or die('No direct script access.');

class Playground_Playground_Search extends Playground_Playground {
	
	protected $_playgrounds;
	private $_page;
	private $_page_size;
	private $sort_by_field;
	private $sort_by_direction;

	/**
	 * Constructs a Playground_Search class.
	 * @author David Overcash <david@system76.com>
	 * @author David Overcash <funnylookinhat@gmail.com>
	 * @param  integer $_page      Page to return for results.
	 * @param  integer $_page_size Default page size for results.
	 * @param  array   $sort_by  Array with "field" and "direction" to sort results.
	 */
	public function __construct($page = 0, $page_size = 50,$sort_by = array())
	{
		$this->_playgrounds = ORM::Factory('playground');
		$this->_page = $page;
		$this->_page_size = $page_size;
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

	public function execute()
	{
		try
		{
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

	/**
	 * Runs the query through ORM and returns the results.
	 * @author David  Overcash      <david@system76.com>
	 * @author David  Overcash      <funnylookinhat@gmail.com>
	 * @return Array of Model_ORM
	 * @throws Exeption If invalid $_page
	 * @throws Exception If invalid $_page_size
	 * @throws Exception If invalid $sort_by['field']
	 * @throws Exception If invalid $ordery_by['direction']
	 */
	protected function _find_results() {

		if( $this->_page < 0 )
		{
			throw new Exception("Invalid page - must be greater than or equal to 0.");
		}
		elseif( $this->_page_size < 1 )
		{
			throw new Exception("Invalid page size - must be greater than or equal to 1.");
		}

		$this->_playgrounds = $this->_playgrounds->limit($this->_page_size)->offset($this->_page*$this->_page_size);
		
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
			$this->_playgrounds = $this->_playgrounds->order_by($this->sort_by_field,$this->sort_by_direction);
		}

		return $this->_playgrounds->find_all();

	}

}