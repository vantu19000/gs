<?php
class HBTableRate extends WP_List_Table{
	public function getLog($route_id){
		global $wpdb;
		$route_id=(int)$route_id;
	
		return $wpdb->get_results("
				Select * from {$wpdb->prefix}HB_routeratelog
				WHERE route_id= {$route_id}");
	}
}