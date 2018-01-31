<?php
class HBModelEstateHouse extends WP_List_Table{
	public function getItems(){
		global $wpdb;
		$input= HBFactory::getInput();
		$limit = $input->get('limit',0);
		$offset = $input->get('offset');
		$query = "Select * from {$wpdb->prefix}hbpro_estate_houses order by created DESC";
		if($limit && ($offset != null || $offset != '')){
			
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
			$query = "Select * from {$wpdb->prefix}hbpro_estate_houses where id = $id";
			
			$result =  $wpdb->get_results($query);
			return reset($result);
		}
		
		if(!empty($_SESSION['estatehouse']['data'])){
			return $_SESSION['estatehouse']['data'];
		}
		return false;
		
	} 
}