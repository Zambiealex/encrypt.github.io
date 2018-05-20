<?php 

class posts
{	
		private $_db; 
		
		public function __construct()
		{
					$this->_db = db::getInstance();	
		}
		
		public function query($fields = array() , $database = '')
		{
			$do = $this->_db->action($fields['action'], ($database != '') ? $database : config::get('tables', 'name/posts'), $fields['where'], $fields['order'], $fields['limit']);
			
			return $do;
		}
		
		
		public function create($tablename, $fields = array())
		{
			if( !$this->_db->insert(config::get('tables', 'name/' . $tablename), $fields))
			{
				throw new Exception("Somthing Happends On Create POST OR COMMENT");
			}
			
			return $this->_db->lastid();
		}
		
		public function update($tablename, $fields = array(), $id)
		{
			if( !$this->_db->update(config::get('tables', 'name/' . $tablename),$id, $fields))
			{
				throw new Exception("Somthing Happends On Update POST OR COMMENT");
			}
		}
		
		public function delete($tablename, $index, $field = 'id')
		{
			if( !$this->_db->delete(config::get('tables', 'name/' . $tablename), array( $field ,'=', $index)) )
			{
				throw new Exception("Somthing Happends On Delete POST OR COMMENT");
			}
		}
		
		public function get($table, $index, $field = 'id')
		{
			$data = $this->_db->get( config::get('tables', 'name/' . $table), array( $field , '=', $index));
			return $data->first();
		}
		
		public function find($tablename, $index , $field = 'postid')
		{
			$data = $this->_db->action('SELECT COUNT(*) ', config::get('tables', 'name/' . $tablename) ,  array( $field ,'=', $index) );
			if(!empty($data->first()))
			{
				if( $data->first()->{'COUNT(*)'} > 0 )
						return true;	
			}
			return false;
		}
		
		public function counting($tablename, $field = 'id', $index =NULL, $search =NULL)
		{
			$where = array();
			$action = '';
			if($index && $search )
			{
					$where = array( $field ,'=', $index);
					$action = $search;
			}
			else if( !$index && $search) 
			{
					$action = $search;
			}
			else if( $index && !$search )
			{
					$where = array( $field ,'=', $index);
			}
			
			$data = $this->_db->action('SELECT COUNT(*) ', config::get('tables', 'name/' . $tablename) , $where, $action );
	
			if(!empty($data->first()))
			{
				if( $data->first()->{'COUNT(*)'} > 0 )
						return $data->first()->{'COUNT(*)'};	
			}
			return 0;
		}
}
?>