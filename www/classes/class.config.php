<?php

class config {
	
	public static function get($configname , $path = null)
	{
		if( $path ){
			$config = $GLOBALS[$configname];
			$path =explode('/', $path);
			foreach($path as $bit){
				if( isset($config[$bit])){
						$config = $config[$bit];	
				}
			}
			return $config;
		}
		
		return false;
	}
	
}

















?>