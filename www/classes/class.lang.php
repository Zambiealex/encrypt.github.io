<?php

class lang {
		private static $_langs = array();
		private static $_params = array(), 
						$_current,
						$extension = '.txt',
						$whattotrim;
		
		public function __construct()
		{
					// GET ALL LENGUAGES
					self::readLang();  
					
					// VALUES TO TRIM
					self::$whattotrim = array(
							'nav_',
							'form_',
							'tab_',
							'link_'
					
					);
		}
		 
		private static function set($key , $value)
		{
				self::$_params[$key] = $value;
		}
	
		public static function output($key , $return = 0)
		{
				$notfound = '['.strtoupper($key).'_NOTFOUND]';
				
				if(!isset(self::$_params[$key]) )
						return $notfound;
						
				// TRIM VALUES 
				foreach(self::$whattotrim as $i)
				{
										if(strpos($i, $key) != -1 )
										{
													self::$_params[$key] = trim(self::$_params[$key]);
										}
				}
							
				if($return){
						return self::$_params[$key];
				}
				else
					print isset(self::$_params[$key]) ? self::$_params[$key] : $notfound;	
		}
		
		public static function langdir($name) { return ROOT . DS . START_DIR . DS . 'lang' . DS . $name . self::$extension; }
		private static function readLang()
		{
					// DIR 
					$dir = ROOT . DS . START_DIR . DS . 'lang';
					
					// CHECK IF DIR EXISTS
					if(is_dir($dir))
					{
							// SCAN DIR
							$scan = scandir($dir);
							// DESTROY ARRAY
							foreach($scan as $language)
							{
									// OMIT DIR
									if($language == '.' || $language == '..') continue;
									
									// READ ONLY TXT EXTENSION
									if( strpos($language, '.txt') ) {
											$filename = $dir . DS . $language;
											if( file_exists( $filename ) )
											{
													self::$_langs[trim($language, '.txt')] = $filename;
											}
									}
							}
					}
		}
		
		public function find($lang)
		{
					if(isset(self::$_langs[$lang]))
					{
								return true;	
					}
					return false;
		}
		
		public function get($lang = NULL)
		{
					$ar = array();
					foreach(self::$_langs as $key => $value)
					{
								$ar[$key] = (object) array('name' => $key,  'dir' => $value);
					}
					return isset($lang) ? $ar[$lang] : $ar;
		}
		
		public function delete($lang)
		{
					$directory = self::langdir($lang);
					if(file_exists($directory))
					{
							if(unlink($directory))
							{
									exit();
							}
					}
		}
		
		private static function readParams($lang)
		{
					global $page;
					
					$lenguage = isset(self::$_langs[$lang]) ? self::$_langs[$lang] : self::langdir($page->data->language);
					
					$file = fopen($lenguage, 'r+');
					
					while(!feof($file) )
					{
					 		$line = fgets($file);
							
							if( $line[0] != '@' ||  $line[0] == ''|| $line[0] == ';' || $line[0] == '/' && $line[1] == '/') continue;
							$parms = trim($line, '@');
							
							list($section, $value) = explode('=', $parms);
							 
							self::set(trim($section), decode($value));
					}
					
					fclose($file);
		}
		
		public static function setLanguage($lang)
		{
					// SKIP
					if( self::$_current == $lang && self::$_current != '') return;
					
					// SET CURRENT
					self::$_current = $lang;
					
					// COOKIE
					cookie::put(config::get('general', 'lang/cookie_name'), self::$_current, config::get('general' , 'lang/cookie_expiry'));
					// READ PARAMS
					self::readParams(self::$_current);
		}
	
}

?>