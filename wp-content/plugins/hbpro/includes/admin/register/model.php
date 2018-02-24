<?php
class HBModelRegister extends WP_List_Table{
	public function getItems(){
		global $wpdb;
		$input= HBFactory::getInput();
        $recent = (int)$_GET['p'];
        if (!$recent) $recent = 1;
		$limit = $input->get('limit',20);
		$offset = $input->get('offset', ($recent-1)*$limit);
		$query = "Select * from {$wpdb->prefix}hbpro_users where status = 0 order by id ASC";
		if($limit){
			
			$query .= " limit $offset,$limit";
		}
		return $wpdb->get_results($query);
	}
	
	public function getItem($id=null){
		global $wpdb;
		$input= HBFactory::getInput();
		if(!$id){
			$id= $input->get('id');
		}
		if($id){
			$query = "Select * from {$wpdb->prefix}hbpro_users where id = $id";
			
			$result =  $wpdb->get_results($query);
			return reset($result);
		}
		
		if(!empty($_SESSION['teacher']['data'])){
			return $_SESSION['teacher']['data'];
		}
		return false;
		
	} 
}