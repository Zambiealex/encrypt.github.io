<?php 

class url {
	
	public static function generate($dir = '', $page=''){
		if(isset($_SERVER['HTTPS'])){
			$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		}
		else{
			$protocol = 'http';
		}
		
		if( $page != '' && page::$folder == '')
				page::$folder = $page;
			
		$folder = $dir;
		
		if(page::$folder != '')
		{
			$folder = page::$folder . DS . $dir;
		}
		
			
		$finish = $protocol . "://" . $_SERVER['HTTP_HOST']  . DS . $folder;
		return  $finish;
	}
	
	public static function action($page, $action = ''){
			$url = self::generate() .  'secure' . DS . $page . DS . 'auth' . DS . $action;
			$url = str_replace(DS, '/', $url);
			print $url;
	}
	
	public static function path($path , $folder = NULL, $image = '', $return = 0){
			$result = NULL;
			//$folder = clean($folder);
			if($path)
			{
					if( $folder != NULL)
					{
							$result = self::generate() . DS . $path . DS . $folder . DS . $image;
					}
					else 
					{
							$result = self::generate() . DS . $path .  DS . $image;
					}
			}
			return ($return) ? $result : print $result;
	}

			
}

?>