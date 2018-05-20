<?php

class page {
		private $_db,
				$_filter = array('create', 'update', 'delete', 'edit', 'make', 'remove', 'view');
		
		public $_path = 'gallery',
						$data;
		
		public static $folder = '';
		
		public function __construct()
		{
				$this->_db = db::getInstance();	
		}
		
		public function get()
		{
			$data = $this->_db->get(config::get('tables', 'name/page'), array() );
			$this->data = $data->first();
		}
		
		public function update($fields = array(), $index){
			if(!$this->_db->update(config::get('tables', 'name/page'), $index , $fields) )
			{
					throw new Exception("There was a problem updating a page");	
			}
		}
		
		public function route($url)
		{
			//
			$index = 0;
			//
			$url_array = array(); $url_array = explode("/",$url); 
			
			// 
			$root = isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array);
		 	//
			$action = isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array); 
			
			/*if( !in_array($action, $this->_filter ) && !is_numeric($action) ) {
					$action = NULL;	
			}*/
			
			//
			
			$extra = (object) array('action' => '', 'index' => '');
			
			if( is_numeric($action) ) {
					
					//
					$index = $action;
					// 
					$action = NULL;
			}
			else {
					//
					$index = isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array); 	
					//
					$extra->action = $index;
					//
					$index = (!is_numeric($index) ) ? NULL : $index;
			}
			
			if(empty($extra->action))
				$extra->action =  isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array); 	
			$extra->index =  isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array); 	
			
			//
			$query_string = (object) array( 'root' => $root, 'action' => $action , 'index' => $index , 'extra' => $extra);
			
			return $query_string;
		}
		
		public function startUp($url) { include ROOT . DS . START_DIR . DS . $url . EXT; }
		public static function render($command) { echo $command; }
		
		public static function break_message($str, $maxChar=23, $start = 0, $pointer = '')
		{
					if(strlen($str) > $maxChar)
								$str = substr($str, $start , $maxChar) . $pointer;
					return html_entity_decode($str);
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