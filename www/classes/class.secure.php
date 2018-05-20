<?php 

class secure 
{
			public function __set($name, $value)
			{
						if(session::exists($name) )
								session::delete($name);
								
						session::put($name, $value);
			}
			
			public function __get($name)
			{
					$current = (session::exists($name) ) ? session::flash($name) : '';
					return $current;
			}
}

?>