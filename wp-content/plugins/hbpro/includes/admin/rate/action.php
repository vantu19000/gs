<?php
class hbactionRate extends hbaction{	
	
	public function save(){
		
		global $wpdb;
		HBImporter::helper('date');
		
		if ( empty( $_POST['hb_meta_nonce'] ) || ! wp_verify_nonce( $_POST['hb_meta_nonce'], 'hb_action' ) ) {
			wp_die('invalid request');
		}
		//get data from request
		$data 	= $_POST['data'];		
		$weekdays = $_POST['weekday'];
		$frate 	= $_POST['frate'];
		$frateparams = $_POST['frateparams'];
		$route_id = $_REQUEST ['route_id'];
		$data['route_id'] = $route_id;
		
		//quote all value to push db
		foreach ( $frate as &$rate ) {
			$rate = array_merge($frateparams, $rate);
		}
		$key =  array_keys($frate['base']);
		
		$data ['startdate'] 	= HBDateHelper::createFromFormatYmd($data ['startdate']);
		$data ['enddate'] 		= HBDateHelper::createFromFormatYmd($data ['enddate']);
		$startdate = new DateTime( $data ['startdate'] );
		$enddate = new DateTime ( $data ['enddate'] );
		$starttoend = $startdate->diff ( $enddate )->days;
		
		// delete old record and record over than 10 day before	
		$delete_query = "delete from {$wpdb->prefix}HB_routerate 
					WHERE (route_id=$route_id
					AND date BETWEEN '".$startdate->format('Y-m-d')."' AND '".$enddate->format('Y-m-d')."'
					AND DATE_FORMAT(date,'%w') IN (".implode(',', $weekdays)."))
					OR (date < '".HBFactory::getDate('-10 Days')->format('Y-m-d')."' AND route_id=$route_id )";	
		
		$wpdb->get_results($delete_query);
			
		//insert new data to rate table	
		$insert_query = "INSERT INTO {$wpdb->prefix}HB_routerate
		 (route_id,date,".implode(',', $key).")";
		$values = array ();
			
		for($i = 0; $i <= $starttoend; $i ++) {
			$dw =(int)$startdate->format ( 'w' );
			if (in_array ( "$dw", $weekdays )) {
				foreach ( $frate as $r ) {
					$temp = array (
							$route_id,
							($startdate->format('Y-m-d'))
					);
					$temp = array_merge ($temp, $r);
		
					$values [] = '"'.implode ( '","', $temp ).'"';
				}
			}
			$startdate = $startdate->add ( new DateInterval ( 'P1D' ) );
		}
		// Save rate
		$insert_query .= 'VALUES ('.implode('),(', $values).')';
		
		$wpdb->get_results($insert_query);
		
		$frate = $_POST['frate'];
		$this->saveLog($frate,$weekdays,$data,$frateparams);
				
		wp_redirect(admin_url('admin.php?page=hb_rate&route_id='.$route_id));
		
		return;
	}
	
	/*
	 * save Log when adding rate for route
	 */
	private function saveLog($frate,$week,$jform,$frateparams){
		global $wpdb;
		$content = new stdClass();
		$content->week = $week;
		$content->price = array();
		$content->params = $frateparams;
		foreach ($frate as $rate){
			$type = $rate['pricetype'];
			unset($rate['pricetype']);
			$content->price[$type]=$rate;
		}
		$data = array();
		$data['startdate'] = $jform ['startdate'];
		$data['enddate'] = $jform ['enddate'];
		$data['route_id'] = $jform ['route_id'];
		$data['content'] = json_encode($content);
		$wpdb->insert($wpdb->prefix.'HB_routeratelog', $data);
		return true;
	}
	
	function ajaxSavedayrate() {
		
		global $wpdb;
		$data = $_REQUEST['frate'];
		$additional = $_REQUEST['frateparams'];
		//delete old rate
		$check = false;
		$wpdb->get_results("DELETE FROM {$wpdb->prefix}HB_routerate WHERE 
			route_id={$additional['route_id']}
			AND date='{$additional['date']}'");
		
		foreach($data as $rate){
			$temp = array_merge ($additional, $rate);
			$check = $wpdb->insert($wpdb->prefix.'HB_routerate', $temp);
		}
		
		if($check){
			echo 'Update successful!';
		}else{
			echo 'Update failed!';
		}
		
		die;
	
	}
	
	function delete(){
		$dates 			= $_POST['dates'];
		$route_id 		= $_POST['route_id'];
	
		if (count($dates)) {
			global $wpdb;
			$wpdb->get_results("DELETE FROM {$wpdb->prefix}HB_routerate WHERE route_id=$route_id AND date IN ('".implode("','", $dates)."')");
		}
		
		wp_redirect(admin_url('admin.php?page=HB_rate&route_id='.$route_id));		
		return;
	
	}
	
	function deleteratelogs(){
		$route_id 		= $_REQUEST['route_id'];
		$cid = $_REQUEST['log'];
		if (count($cid)) {
			global $wpdb;
			$wpdb->get_results("DELETE FROM {$wpdb->prefix}HB_routeratelog WHERE id IN (".implode(',', $cid).")");
		}
	
		wp_redirect(admin_url('admin.php?page=HB_rate&route_id='.$route_id));
		
		return;
	}
	
	public function show_rate_detail(){
		HBImporter::includes('admin/rate/view');
		die();
	}
	
	public function new_calendar(){
		$input = HBFactory::getInput();
		$min_date = DateTime::createFromFormat('Y',$_REQUEST['year'])->modify('-1 year')->format('Y');
		$max_date = DateTime::createFromFormat('Y',$_REQUEST['year'])->modify('+1 year')->format('Y');
		$calendar_attributes = array (
				'min_select_year' => $min_date,
				'max_select_year' => $max_date
		);
		require_once HB_PATH.'classes/calendar.php';
		HBImporter::css('calendar');
		$calendar = new PN_Calendar($calendar_attributes);
		echo $calendar->draw(array(), $input->get('year'), $input->get('month'));
		exit;
			
			
	}
	
}