<?php

class validation{
	private $_passed = false,
			$_errors = array(),
			$_db = null,
			$_formats = array('png', 'jpg', 'jpeg','JPEG', 'gif', 'bmp', 'webm');
				
	public  $_maxSize = 5120000, // 5mb
			$_path; 
		
			
	public function __construct(){
		global $page;
		
		$this->_db = db::getInstance();	
		$this->_path = ROOT . DS . $page->_path . DS;
	}
	
	public function check($source, $items = array()){
		
		// PREVENT PASSED TRUE
		$this->_passed = false;
		
		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){
			
				$value = trim($source[$item]);
				$item = escape($item);
				
				if( $rule == 'validate' && !$this->validEmail($value))
				{	
					$this->addError("{$item} is not valid");
				} else if($rule == 'required' && empty($value) ){
						$this->addError("{$item} is required");
				}else if(!empty($value)) {
					switch($rule){
						case 'min':
							if( strlen($value) < $rule_value ){
								$this->addError("{$item} must be a minimun {$rule_value} characters.");							
							}
						break;	
						case 'max':
							if( strlen($value) > $rule_value ){
								$this->addError("{$item} must be a maximun {$rule_value} characters.");							
							}
						break;	
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");	
							}
						break;	
						case 'unique':
							$check = $this->_db->get($rule_value,
							array(
								$item,
								'=',
								$value
							));
							
							if($check->get_count()){
								$this->addError("{$item} already Exist");
							}
						break;
						case 'numeric':
								if( !is_numeric($value) )
								{
									$this->addError("{$item} need to be in numbers");	
								}
						break;
							
					}
				}
			}
		}
		
		if(empty($this->_errors)){
			$this->_passed = true;	
		}
	}
	
	public function refresh()
	{
		if( $this->_passed == true)
					$this->_passed = false;
					
		if(empty($this->_errors)){
			$this->_passed = true;	
		}
	}
	
	public function addError($error){
		
		$this->_errors[] = $error;	
		$this->refresh();
	}
	
	public function errors(){
		return $this->_errors;	
	}
	
	public function passed(){
		return $this->_passed;
	}
	
	public static function validEmail($email) {
	 	 return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
	}
	
	public function uploadImage($pathname, $fields = array(), $rename = false, $oldname = '' , $thumbsize = 100, $thumbprop = 'width')
	{
			//
			$oldname = $this->_path . clean($oldname) . DS;
			
			//
			$this->_path = $this->_path . clean($pathname). DS;
			
			if( !is_dir($this->_path) ) {
						if($rename)
						{
								if(is_dir($oldname))
								{
										$do = rename($oldname, $this->_path);
								}
								return;
						}
						else 
							mkdir($this->_path, 0777, true);
			}
			
			$up = array();
			foreach($fields as $field)
			{
					if(!empty($_FILES[$field]) )
					{
							// CONTINUE IF IMAGE HAVE ERROR!
							if($_FILES[$field]['error'] != 0)
									continue;
									
							// GET DATA
							$name = $_FILES[$field]['name'];
							$extension = pathinfo($name, PATHINFO_EXTENSION);
							
							if ($_FILES[$field]['size'] > $this->_maxSize) 
							{
									$this->addError("{$name} is too large!.");
							}
							else if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $this->_formats) )
							{
									$this->addError("{$name} is not a valid format");
							}
							$hash = md5(uniqid().$name);
							$uniqname =  $hash . '.' . $extension;
							$store =  $this->_path . $uniqname;
							
							$this->refresh(); // REFRESH ERRORS
							
							if( empty($this->_errors)  ) 
							{
								if(move_uploaded_file($_FILES[$field]["tmp_name"], $store)) 
								{
											$up[$field] = $uniqname;
											$up[$field . '_patch'] = $store;
											
											$thumb = new thumb();
											$thumb->load($store);
											
											$thumb->resize(100, 'width');
											
											$thm = $hash;
											$uniq = $this->_path . $thm;
											
											$result = $thumb->save($uniq, $thm,  80);
											
											$up['thumb'] = $result->name;
											$up['thumb_patch'] = $result->patch;
								}
							}
					}
					else 
					{
							return false; // IF NOTHING TO UPLOAD	
					}
			}
			return (!empty($up)) ? (object) $up : false;
	}
}
?>