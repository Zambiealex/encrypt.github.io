<?php
/*
*				@ADVERTs
*
*				USE : $advert->randim(type); THIS SELECT A RANDOM ADVERT
*				TYPE :  center, side, absolute (you make your type with CSS) 
*
*/

class adverts
{
		private $_db,
				$_data,
				$_first,
				$_store = array();
				
		public function __construct()
		{
					$this->_db = db::getInstance();	
					
					$this->getAll();
					 
					if( !empty($this->_first) )
					{
							$this->makeArray($this->_first);
					}
		}
		
		public function makeArray($data)
		{
					foreach($data as $key => $value)
					{
							$this->_store[$value->type][] = decode(trim($value->code));
					}
					return;
		}
		
		public function query($fields = array() )
		{
			$do = $this->_db->action($fields['action'], config::get('tables', 'name/adverts'), $fields['where'], $fields['order'], $fields['limit']);
			
			return $do;
		}
	
		public function random($type) {
			
				$count = 0;
				if( isset($this->_store[$type]) )
					$count = count($this->_store[$type])-1;
				else
					return;
					
				if( $count >= 0)
				{
						$ads = 	$this->_store[$type][rand(0, $count)];
						return print isset($ads) ? $ads : '';
				}
		}
		
		public function create($fields = array())
		{
			if( !$this->_db->insert(config::get('tables', 'name/adverts'), $fields)){
				throw new Exception("Somthing Happends On Create Advert");
			}
		}
		
		public function update($fields = array(), $id)
		{
			if( !$this->_db->update(config::get('tables', 'name/adverts'),$id, $fields))
			{ 
				 throw new Exception("Somthing Happends On Update Advert");
			}
		}
		
		public function delete($index)
		{
			if( !$this->_db->delete(config::get('tables', 'name/adverts'), array( 'id' ,'=', $index)) )
			{ 
				 throw new Exception("Somthing Happends On Delete Advert");
			}
		}
		
		public function get($index)
		{
			$data = $this->_db->get( config::get('tables', 'name/adverts'), array( 'id' , '=', $index));
			return $data->first();
		}
		
		public function getAll()
		{
			$data = $this->_db->get( config::get('tables', 'name/adverts'), array( ));
			$this->_first = $data->results();
		}
		
		public function data()
		{
				return $this->_first;	
		}
		
		public function find($index , $field = 'id')
		{
			$data = $this->_db->action('SELECT COUNT(*) ', config::get('tables', 'name/adverts') ,  array( $field ,'=', $index) );
			if(!empty($data->first()))
			{
				if( $data->first()->{'COUNT(*)'} > 0 )
						return true;	
			}
			return false;
		}
}

?>