<?php 

class template 
{ 
		private $params = array();
		
		public function __set($key , $value)
		{
				$this->params[$key] = $value;
		}
		
		public function __get($key)
		{
				return isset($this->params[$key]) ? $this->params[$key] : NULL;	
		}
		
		public static function javascript($js_name, $seccion = NULL) 
		{
				global $page;
				$dir = '';
				// CSS
				if( !$seccion ) 
					$dir = START_DIR . DS . $page->data->theme . DS . 'js' . DS . $js_name . JS;
				else
					$dir = START_DIR . DS . $page->data->theme . DS . 'js' . DS . $seccion . DS . $js_name . JS;
				
				// DIR
				$template = ROOT . DS . $dir ;
				
				// CHECK IF EXISTS 
				if( !file_exists($template) ) {
					//self::view('errors/404');
					return;
				}
				
				$url = url::generate(page::$folder) . DS . $dir;
				
				print $url;
		}
		
		public static function stylesheet($css_name, $seccion = NULL) 
		{
				global $page;
				$dir = '';
				// CSS
				if( !$seccion ) 
					$dir = START_DIR . DS . $page->data->theme . DS . 'css' . DS . $css_name . CSS;
				else
					$dir = START_DIR . DS . $page->data->theme . DS . 'css' . DS . $seccion . DS . $css_name . CSS;
				
				// DIR
				$template = ROOT . DS . $dir ;
				
				// CHECK IF EXISTS 
				if( !file_exists($template) ) {
					//self::view('errors/404');
					return;
				}
				
				$url = url::generate(page::$folder) . DS . $dir;
				
				print $url;
		}
		
		public  function view($template, $return = 0)
		{
				global $page;
				
				// DIR
				$template = ROOT . DS . START_DIR . DS . $page->data->theme . DS . $template . EXT;
				
				// CHECK IF EXISTS AND IF NOT SET ERROR PAGE
				if( !file_exists($template) ) {
					self::view('errors/404');
					return;
				}
				
				// GET PARAMS
				extract($this->params);
				
				// INCLUDE DATA
				include($template);
				
				// GET RESULTS
				$results = ob_get_clean();
				
				// PRINT RESULTS
				if( $return )
					return $results;
				else 
					print($results); 
		}
}

?>