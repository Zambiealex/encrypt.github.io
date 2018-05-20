<?php
class redirect{
	
	public static function to($location = null)
	{
		if( $location ){
			if(is_numeric($location)){
				switch($location){
					case 404:
						header('HTTP/1.0 404 Not Found');
						exit();
					break;
				}
			}
			if( $location == 'init') 
				$location = url::generate(page::$folder);
			else
				$location = url::generate(page::$folder) . DS . $location;
			
			header('Location: ' . $location);
			exit();	
		}
	}
	
	
	
}

?>