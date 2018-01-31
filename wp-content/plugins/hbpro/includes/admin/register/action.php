<?php

class HBActionRegister extends hbaction{	
	
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
	
	function checked(){
		$id 		= $_REQUEST['id'];
	
		global $wpdb;
		$check = $wpdb->query("update {$wpdb->prefix}hbpro_register_email set checked=1 where id={$id}");
		if($check){
			hb_enqueue_message('Success');
		}else{
			hb_enqueue_message('Check failed','error');
		}
		
		
		wp_redirect(admin_url('admin.php?page=hb_register'));		
		return;
	}
	
	function delete(){
		$id 		= $_REQUEST['id'];
	
		global $wpdb;
		$check = $wpdb->query("DELETE FROM {$wpdb->prefix}hbpro_register_email WHERE id={$id}");
		
		if($check){
			hb_enqueue_message('Delete success');
		}else{
			hb_enqueue_message('Delete failed','error');
		}
		
		wp_redirect(admin_url('admin.php?page=hb_register'));		
		return;
	
	}
	
	
}