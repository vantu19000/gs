<?php

class HBActionRegister extends hbaction{	
	
	//chap nhan giao vien
	public function approve(){
		global $wpdb;
		
		//check captcha
		$post = $this->input->getPost();

		$ids = $post['id'];

		foreach ($ids AS $id){
            $result = $wpdb->update("{$wpdb->prefix}hbpro_users", array("status"=>"1"), array("id"=>$id));
        }

		wp_redirect(admin_url('admin.php?page=hb_register'));
		return;
	}
	
	
	function delete(){

        global $wpdb;
        $ids = $_REQUEST['id'];

        foreach ($ids AS $id){
            $user = $wpdb->query("SELECT * FROM {$wpdb->prefix}hbpro_users WHERE id={$id}");
            $check = $wpdb->query("DELETE FROM {$wpdb->prefix}hbpro_users WHERE id={$id}");
            wp_delete_user($user->user_id);
        }

		wp_redirect(admin_url('admin.php?page=hb_register'));
		return;
	
	}
	
	
}