<?php

class HBActionOrders extends hbaction{	
	
	public function save(){
		global $wpdb;
		
		//check captcha
		$post = $this->input->getPost();
		$data = $post['data'];

		$data['created'] = current_time( 'mysql' );
		if($this->input->get('id')){				
			$result = $wpdb->update("{$wpdb->prefix}hbpro_orders", $data, array('id'=>$this->input->get('id')));
			wp_safe_redirect(admin_url('admin.php?page=hb_dashboard&layout=edit&id='.$this->input->get('id')));
		}else{
			$result = $wpdb->insert("{$wpdb->prefix}hbpro_orders", $data);
			wp_safe_redirect(admin_url('admin.php?page=hb_dashboard&layout=edit&id='.$wpdb->insert_id));
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

	    $data = $_POST['id'];

	    foreach ($data AS $id){
            global $wpdb;
            $wpdb->delete("{$wpdb->prefix}hbpro_orders", array('id' => $id));
        }

		wp_redirect(admin_url('admin.php?page=hb_dashboard'));
		return;
	
	}
	
}