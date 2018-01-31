<?php

class HBActionTeacher extends hbaction{	
	
	public function save(){
		global $wpdb;
		
		//check captcha
		$post = $this->input->getPost();
		$data = $post['data'];
		
		$data['created'] = current_time( 'mysql' );
		if($this->input->get('id')){				
			$result = $wpdb->update("{$wpdb->prefix}teacher", $data, array('id'=>$this->input->get('id')));
			wp_safe_redirect(admin_url('admin.php?page=teacher&layout=edit&id='.$this->input->get('id')));
		}else{
			$result = $wpdb->insert("{$wpdb->prefix}teacher", $data);
			wp_safe_redirect(admin_url('admin.php?page=teacher&layout=edit&id='.$wpdb->insert_id));
		}
		
		
		if($result){
			hb_enqueue_message('Thêm giáo viên thành công');
			$_SESSION['teacher']['data'] = false;
		}
		else{
			//neu that bai luu du lieu nay lai de user khong phai nhap lai du lieu nay
			$_SESSION['teacher']['data'] = (object)$data;
			hb_enqueue_message($wpdb->last_error,'error');
		}
		
		
		exit;
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