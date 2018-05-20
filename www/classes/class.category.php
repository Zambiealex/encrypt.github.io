<?php

class category
{
	private $_db,
	$_first;
	
	public function __construct()
	{
		$this->_db = db::getInstance();	
	}
	
	public function query($fields = array() )
	{
		$do = $this->_db->action($fields['action'], config::get('tables', 'name/category'), $fields['where'], $fields['order'], $fields['limit']);
		
		return $do;
	}
	
	
	public function create($fields = array())
	{
		if( !$this->_db->insert(config::get('tables', 'name/category'), $fields)){
			throw new Exception("Somthing Happends On Create Category");
		}
	}
	
	public function update($fields = array(), $id)
	{
		if( !$this->_db->update(config::get('tables', 'name/category'),$id, $fields))
		{ 
			throw new Exception("Somthing Happends On Update  Category");
		}
	}
	
	public function delete($index)
	{
		if( !$this->_db->delete(config::get('tables', 'name/category'), array( 'id' ,'=', $index)) )
		{ 
			throw new Exception("Somthing Happends On Delete  Category");
		}
	}
	
	public function getAll()
	{
		$data = $this->_db->get(config::get('tables', 'name/category'), array() );
		$this->_first = $data->results();
	}
	
	public function data()
	{
		return $this->_first;	
	}
	
	public function get($index, $field = 'id')
	{
		$data = $this->_db->get( config::get('tables', 'name/category'), array( $field , '=', $index));
		return $data->first();
	}
	
	
	public function find($index , $field = 'id')
	{
		$data = $this->_db->action('SELECT COUNT(*) ', config::get('tables', 'name/category') ,  array( $field ,'=', $index) );
		if(!empty($data->first()))
		{
			if( $data->first()->{'COUNT(*)'} > 0 )
			return true;	
		}
		return false;
	}
}

?>