<?php

class report
{
	private $_db;
	
	public function __construct()
	{
		$this->_db = db::getInstance();	
	}
	
	public function query($fields = array() )
	{
		$do = $this->_db->action($fields['action'], config::get('tables', 'name/report'), $fields['where'], $fields['order'], $fields['limit']);
		
		return $do;
	}
	
	
	public function create($fields = array())
	{
		if( !$this->_db->insert(config::get('tables', 'name/report'), $fields)){
			throw new Exception("Somthing Happends On Create");
		}
	}
	
	public function update($fields = array(), $id)
	{
		if( !$this->_db->update(config::get('tables', 'name/report'),$id, $fields))
		{ 
			throw new Exception("Somthing Happends On Update");
		}
	}
	
	public function delete($index)
	{
		if( !$this->_db->delete(config::get('tables', 'name/report'), array( 'id' ,'=', $index)) )
		{ 
			throw new Exception("Somthing Happends On Delete");
		}
	}
	
	public function get($index)
	{
		$data = $this->_db->get( config::get('tables', 'name/report'), array( 'id' , '=', $index));
		return $data->first();
	}
	
	public function find($index , $field = 'id')
	{
		$data = $this->_db->action('SELECT COUNT(*) ', config::get('tables', 'name/report') ,  array( $field ,'=', $index) );
		if(!empty($data->first()))
		{
			if( $data->first()->{'COUNT(*)'} > 0 )
			return true;	
		}
		return false;
	}
}

?>