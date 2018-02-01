<?php

class HBActionRegister extends hbaction{	
	
	//chap nhan giao vien
	public function approve(){
		global $wpdb;
		
		//check captcha
		$post = $this->input->getPost();
		$data = array(
				'status' => 1
		);
		
		if($this->input->get('id')){				
			$result = $wpdb->update("{$wpdb->prefix}hbpro_users", $data, array('id'=>$this->input->get('id')));
			wp_safe_redirect(admin_url('admin.php?page=hb_register&layout=edit&id='.$this->input->get('id')));
		}		
		
		if($result){
			hb_enqueue_message('Thêm giáo viên thành công');
			$_SESSION['teacher']['data'] = false;
		}
		
		wp_redirect(admin_url('admin.php?page=hb_register'));
		return;
	}
	
	
	function delete(){
		$id 		= $_REQUEST['id'];
	
		global $wpdb;
		$check = $wpdb->query("DELETE FROM {$wpdb->prefix}hbpro_users WHERE id={$id}");
		
		if($check){
			hb_enqueue_message('Delete success');
		}else{
			hb_enqueue_message('Delete failed','error');
		}
		
		wp_redirect(admin_url('admin.php?page=hb_register'));		
		return;
	
	}
	
	
}