<?php

class user {
	private $_db,
	$_data,
	$_sessionName,
	$_isLoggedIn,
	$_cookieName;
	
	public  $_date;
	
	public function __construct($user =null){
		$this->_db = db::getInstance();
		$this->_sessionName = config::get('general', 'session/session_name');
		$this->_cookieName = config::get('general', 'remember/cookie_name');
		
		if(!$user){
			if(session::exists($this->_sessionName))
			{
				$user = session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedIn=true;	
					}else{
					
				}
			}
			}else {
			$this->find($user);	
		}
		$this->_date  = date('m d, Y');
	}
	
	public function query($fields = array() )
	{
		$do = $this->_db->action($fields['action'],config::get('tables', 'name/users'), $fields['where'], $fields['order'], $fields['limit']);
		
		return $do;
	}
	
	
	public function create($fields = array()){
		if( !$this->_db->insert(config::get('tables', 'name/users'), $fields))
		{
			throw new Exception("There was a problem creating a account");
		}
	}
	
	public function delete($index)
	{
		if(!$this->_db->delete(config::get('tables', 'name/users'), array('id', '=', $index) ) )
		{
			throw new Exception("There was a problem deleting a users");	
		}
	}
	
	public function get()
	{
		return $this->_db->action('SELECT *', config::get('tables', 'name/users') )->results();
	}
	
	public function find($user=null){
		if($user){
			$field ='';
			
			if(!validation::validEmail($user)){
				$field = (is_numeric($user)) ? 'id' : 'username';
			}
			else {
				$field = (is_numeric($user)) ? 'id' : 'email';	
			}
			
			$data = $this->_db->get(config::get('tables', 'name/users'), array($field, '=', $user));
			
			if($data->get_count()){
				$this->_data = $data->first();
				return true;	
			}
		}
		return false;
	}
	
	public function process($user=NULL){
		if($user){
			$field ='';
			if(!validation::validEmail($user)){
				$field = (is_numeric($user)) ? 'id' : 'username';
			}
			else {
				$field = (is_numeric($user)) ? 'id' : 'email';	
			}
			
			$data = $this->_db->get(config::get('tables', 'name/users'), array($field, '=', $user));
			
			if($data->get_count()){
				return $data->first(); 	
			}
		}
		return false;
	}
	
	
	public function login($email=null, $password=null,$remember=false)
	{
		$user = $this->find($email);
		
		if(!$email && !$password && $this->exists()){
			session::put($this->_sessionName, $this->data()->id);
			
			}else {
			if($user)
			{
				
				if($this->data()->password === Hash::make($password, $this->data()->salt))
				{
					session::put($this->_sessionName,$this->data()->id);
					
					if($remember){
						$hash = Hash::unique();
						$hashCheck = $this->_db->get(config::get('tables', 'name/users_session'),
						array(
						'user_id',
						'=',
						$this->data()->id
						));
						
						if(!$hashCheck->get_count()){
							$this->_db->insert(config::get('tables', 'name/users_session'),
							array(
							'user_id' => $this->data()->id,
							'hash' => $hash
							)); 
							}else{
							$hash = $hashCheck->first()->hash; 
						}
						
						cookie::put($this->_cookieName, $hash, config::get('general' , 'remember/cookie_expiry'));
					}
					return true;
				}
			}
		}
		return false;
	}
	
	public function logout(){
		$this->_db->delete(config::get('tables', 'name/users_session'), array( 'user_id' ,'=', $this->data()->id));
		session::delete($this->_sessionName);	
		cookie::delete($this->_cookieName);
	}
	
	public function update($fields = array(), $id = 0){
		
		if( !$id && $this->isLoggedIn()){
				$id = $this->data()->id;
		}
		
		if(!$this->_db->update(config::get('tables', 'name/users'), $id, $fields)){
			echo 'error';
			throw new Exception('there was a problem updating.');
		}
	}
	
	public function data(){
		return $this->_data;
	}
	
	public function isLoggedIn(){
		return $this->_isLoggedIn;	
	}
	
	public function exists(){
		return (!empty($this->_data) ) ? true : false;	
	}
	
	public function compare($index, $id){
		if( $index == $id)
			return true;
		return false;
	}
	
	public function getGroup($index){
		$group = $this->_db->get(config::get('tables', 'name/groups'), array( 'id', '=', $index));
		if($group->get_count()){
			return $group->first();
		}
		return false;
	}
	
	public function getGroups(){
		$group = $this->_db->get(config::get('tables', 'name/groups'), array());
		if($group->get_count()){
			return $group->results();
		}
		return false;
	}
	
	public function hasPermission($key){
		$group = $this->_db->get(config::get('tables', 'name/groups'), array( 'id', '=', $this->data()->group));
		if($group->get_count()){
			$permissions = json_decode($group->first()->permissions, true);
			if($permissions[$key] == true){
				return true;
			}
		}
		return false;
	}
	
	public function get_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}

?>