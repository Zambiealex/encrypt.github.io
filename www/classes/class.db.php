<?php

class db{
	// private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false,
			$_results, 
			$_count = 0,
			$_lastid;
			
	private function __construct(){
			
			try{
				$this->_pdo = new PDO('mysql:host='. config::get('general','mysql/host') .';dbname='. config::get('general','mysql/db'), config::get('general','mysql/username') , config::get('general','mysql/password') );
				
			} catch(PDOException $e){
				die($e->getMessage());
			}
	}
	
	public static function getInstance(){
		$instance = new db();
		/*if(!isset(self::$_instance)){
			self::$_instance = new db();	
		}
		return self::$_instance;*/
		return $instance; // NEW FOR ALL REQUEST
	}
	
	public function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $parm){
					$this->_query->bindValue($x, $parm);
					$x++;
				}
			}
			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				$this->_lastid = $this->_pdo->lastInsertId();
			}
			else{
				$this->_error = true;
			}
		}
		return $this;
	}
	
	public function action($action, $table, $where = array(), $order = NULL, $limit = NULL){
		if( count($where) == 3 && $order == NULL && $limit == NULL){
			$operators = array('=', '>', '<', '>=', '<=' );
			
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
				
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE `{$field}` {$operator} ?";
				
				if(!$this->query($sql, array($value))->error()){
							return $this;
				}		
			}
		}
		else {
				$sql = '';
				$value = '';
				if( count($where) == 3 ){
						$operators = array('=', '>', '<', '>=', '<=' );
						
						$field = $where[0];
						$operator = $where[1];
						$value = $where[2];
							
						if(in_array($operator, $operators)){
								$sql = "{$action} FROM {$table} WHERE `{$field}` {$operator} ? {$order} {$limit}";
						}
				}
				else 
				{
					$sql = "{$action} FROM {$table} {$order} {$limit}";
				}
				
				if( $sql != '') {
					if(!$this->query($sql, array($value))->error()){
										return $this;
					}	
				}
		}
	
		return false;
	}
	
	public function lastid(){
			return $this->_lastid;	
	}
	public function results(){
		return $this->_results;
	}
	
	public function first(){
		return $this->_results[0];
	}
	
	public function get($table , $where){
			return $this->action('SELECT *', $table, $where);
	}
	
	public function insert($table, $fields =array()){
		if( count($fields) ){
			$keys = array_keys($fields);
			$values = null;
			$x=1;
			
			foreach($fields as $field){
				$values .= "?";
				if( $x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}
			
			$sql = "INSERT INTO `{$table}` (`". implode('`, `', $keys)."`) VALUES ({$values})";
			
			if(!$this->query($sql, $fields)->error()){
				return true;
			}
		}
		return false;
	}
	
	public function update($table, $index, $fields, $field = 'id'){
		$set = '';
		$x = 1;
		
		foreach($fields as $name => $value){
			$set .= "`{$name}` = ?";
			if( $x < count($fields)){
				$set .= ', ';	
			}
			$x++;
		}
		
		$sql = "UPDATE `{$table}` SET {$set} WHERE `{$field}` = {$index}";
		
		if( !$this->query($sql, $fields)->error()){
				return true;
		}
		return false;
	}
	
	public function delete($table , $where){
		return $this->action('DELETE', $table, $where);
	}
	
	public function error(){
		return $this->_error;	
	}
	
	public function get_count(){
		return $this->_count;	
	}
}

?>