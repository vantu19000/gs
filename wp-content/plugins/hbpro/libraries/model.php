<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/

class HbModel
{
	public $jbcache = null;
	static $connection;
	public $_tbl;

	function __construct($table_name, $primary_key)
	{
		global $wpdb;
		$this->_tbl = str_replace('#__',$wpdb->prefix,$table_name);
		if(is_array($primary_key)){
			$this->_key = $primary_key;
		}else{
			$this->_key = array($primary_key);
		}
		
		
	}
	
	function save($data, $orderingFilter = '', $ignore = ''){
		global $wpdb;
		
 		$insert = false;
 		foreach ($this->_key as $pr_key){
 			if(!isset($data[$pr_key]) || empty($data[$pr_key])){
 				$insert = true;
 			}
 		}
 		
 		if($insert){
 			$check = $wpdb->insert($this->_tbl,$data); 	
 			foreach($this->_key as $pr_key){
 				$this->$pr_key = $wpdb->insert_id;
 			}
 		}else{
 			$table_fields = $this->get_fields();
 			$table_fields = array_map(function($a){return $a->Field;}, $table_fields);
 			$fields = array();
 			foreach($data as $key=>$value){
 				if(in_array($key, $table_fields)){
 					$fields[]=$key;
 				}
 			}
 			
 			$sql = 'INSERT INTO '.($this->_tbl).' ('.implode(',',$fields).') VALUES ';
 			$sql .= "(".$this->render_values($data,$fields)."),";
 			$sql = trim($sql,',')." ON DUPLICATE KEY UPDATE ";
 			foreach($fields as $field){
 				$sql .= "$field = VALUES($field),";
 			}
 			$sql = trim($sql,',').';';
 			$check = $this->run_query($sql);
 			foreach($this->_key as $pr_key){
 				$this->$pr_key = $data[$pr_key];
 			}
 		}
 		
 		
 			
 		return $check;
 		
 		
		
	}
	
	function batch_save($datas){
		if(!is_array($datas) || count($datas) == 0){
			return true;
		}
		$table_fields = $this->get_fields();
		$table_fields = array_map(function($a){return $a->Field;}, $table_fields);
		$fields = array();
		foreach($datas[0] as $key=>$value){
			if(in_array($key, $table_fields)){
				$fields[]=$key;
			}
		}
		
		$sql = 'INSERT INTO '.($this->_tbl).' ('.implode(',',$fields).') VALUES ';
		foreach($datas as $data){
			$data = (array)$data;
			$sql .= "(".$this->render_values($data,$fields)."),";
		}
		
		$sql = trim($sql,',')." ON DUPLICATE KEY UPDATE ";
		foreach($fields as $field){
			$sql .= "$field = VALUES($field),";
		}
		$sql = trim($sql,',').';';
		$datas=null;unset($datas);
// 		return $this->run_query($sql);
		$this->setQuery($sql);
// 		echo $sql;die;
		$sql=null;unset($sql);
		
		return $this->execute();
		
	}
	
	private function run_query($query){
// 		echo $query;
		$con = $this->get_connection();
		$check = mysqli_query($query);
		mysqli_close($con);
		return $check;
	}
	
	private function get_connection(){
		if(!self::$connection){
			$conf = JFactory::getConfig();
			self::$connection = mysqli_connect($conf->get('host'), $conf->get('user') , $conf->get('password'), $conf->get('db'));
			if (!self::$connection) {
				die('Not connected : ' . mysql_error());
			}
		}
		return self::$connection;
		$db =JFactory::getDbo();
	}
	
	private function render_values($data,$key){
		$sql = '';
		foreach($key as $v){
			if(isset($data[$v])){
				if(is_array($data[$v]) || is_object($data[$v])){
					$sql .=  ','.$this->quote(json_encode($data[$v]));
				}else{
					$sql .=  ','.$this->quote($data[$v]);
				}
				
			}else{
				$sql .=  ',""';
			}
		}
		return trim($sql,',');
	}
	
	public function quote($value){
		$value = str_replace("'","\'","{$value}");
		return "'{$value}'";
	}
	
	
	public function get_fields()
	{	
		if ($this->jbcache === null)
		{
			// Lookup the fields for this table only once.
			$name   = $this->_tbl;
			global $wpdb;
			$fields = $wpdb->get_results("SHOW COLUMNS FROM {$name};");
			if (empty($fields))
			{
				throw new UnexpectedValueException(sprintf('No columns found for %s table', $name));
			}
	
			$this->jbcache = $fields;
		}
	
		return $this->jbcache;
	}
	
	
}