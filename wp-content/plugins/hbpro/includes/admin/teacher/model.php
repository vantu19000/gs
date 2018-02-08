<?php
class HBModelTeacher {
	public function get_table_name(){
		global $wpdb;
		return "{$wpdb->prefix}hbpro_users";
	}
	public function getItems(){
		global $wpdb;
		$input= HBFactory::getInput();
		$limit = $input->get('limit',0);
		$offset = $input->get('offset');
		$query = "Select * from {$wpdb->prefix}hbpro_users order by created DESC";
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
			$query = "Select u.*,AVG(r.star_number) as star_number,count(r.id) as star_volume from {$wpdb->prefix}hbpro_users as u
			LEFT JOIN {$wpdb->prefix}hbpro_rating as r ON r.teacher_id=u.id WHERE u.id = $id";
			
			$result =  $wpdb->get_results($query);
			return reset($result);
		}
		return false;
		
	} 
	
}