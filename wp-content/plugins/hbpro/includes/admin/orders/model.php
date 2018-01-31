<?php
class HBModelOrders extends WP_List_Table{
	public function getItems(){
		global $wpdb;
		return $wpdb->get_results("
				Select * from {$wpdb->prefix}order order by created DESC");
	}
}