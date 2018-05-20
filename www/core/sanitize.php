<?php
function escape($string){
	return htmlentities($string, ENT_QUOTES, 'UTF-8');	
}

function decode($string){
		$string = html_entity_decode($string);
		$string = htmlspecialchars_decode($string);
		return $string;
}

function clean($string , $str=0, $onlyspecial = 0) {
	
		$string = decode($string);
		$string = ucwords($string);
		$string = trim( $string );
		$string = preg_replace( '/\s+/', '+', $string ); 
		if( $str != 0 ) $string = str_replace( '+', ' ', $string ); 
		else $string=preg_replace("/[^ \w]+/", " ", $string); // Removes special chars.
		return $string;
		//  return 
}

function clean_search($input) {
		$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);
		
		$output = preg_replace($search, '', $input);
		$output = htmlentities($input);
		$output=preg_replace("/[^ \w]+/", "", $output); // Removes special chars.
		 
		//$output = advance_clean($output);
		return $output;
}

function debug($data)
{
		echo '<pre>';
		print_r($data);
		echo '</pre>';	
}


function strip_char( $char = array(), $to , $str )
{
		foreach($char as $strip)
		{
				$str = str_replace($strip, $to, $str);	
		}
		return $str;
}

function shuffle_assoc($list) { 
	  if (!is_array($list)) return $list; 
	
	  $keys = array_keys($list); 
	  shuffle($keys); 
	  $random = array(); 
	  foreach ($keys as $key) { 
		$random[$key] = $list[$key]; 
	  }
	  return $random; 
} 


function titleBreak($string, $max=23){
		if(strlen($string) > $max) 
			$string = substr($string, 0, $max).'..';
		return html_entity_decode($string);	
}

function geoCheckIP($ip)
{
               //check, if the provided ip is valid
               if(!filter_var($ip, FILTER_VALIDATE_IP))
               {
                       throw new InvalidArgumentException("IP is not valid");
               }

               //contact ip-server
               $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
               if (empty($response))
               {
                       throw new InvalidArgumentException("Error contacting Geo-IP-Server");
               }

               //Array containing all regex-patterns necessary to extract ip-geoinfo from page
               $patterns=array();
               $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
               $patterns["country"] = '#Country: (.*?)&nbsp;#i';
               $patterns["state"] = '#State/Region: (.*?)<br#i';
               $patterns["town"] = '#City: (.*?)<br#i';

               //Array where results will be stored
               $ipInfo=array();

               //check response from ipserver for above patterns
               foreach ($patterns as $key => $pattern)
               {
                       //store the result in array
                       $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
               }

               return $ipInfo;
       }
?>