<?php
class token{
	public static function generate($tokenName=''){
		$tokenName = (!empty($tokenName)) ? $tokenName.'_' : '';
		$tokenName = $tokenName.config::get('general', 'session/token_name');
		return session::put($tokenName, md5(uniqid()));	
	}
	
	public static function check($tokenName='', $token){
		$tokenName = (!empty($tokenName)) ? $tokenName.'_' : '';
		$tokenName = $tokenName.config::get('general', 'session/token_name');
		
		if(session::exists($tokenName) && $token === session::get($tokenName)){
			session::delete($tokenName);
			return true;
		}
		return false;
	}
}


?>