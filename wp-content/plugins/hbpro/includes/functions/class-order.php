<?php
/**
 * @package 	Bookpro
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');

class HBActionOrder extends HBAction{
	
	/*
	 * Generate checkout page of payment gateway
	 */
	function register(){ 
		global $wpdb;
		//check nonce
		if ( empty( $_POST['hb_meta_nonce'] ) || ! wp_verify_nonce( $_POST['hb_meta_nonce'], 'hb_action' ) ) {
			wp_die('invalid request');
		}
		//check captcha
		$post = $this->input->getPost();
		$data = $post['parent'];

		$data['created'] = current_time( 'mysql' );
		$insert = $wpdb->insert("{$wpdb->prefix}hbpro_orders", $data);
		if ($insert){
            hb_enqueue_message('Chúc mừng bạn đã đăng kí thành công');
            wp_safe_redirect(site_url('/?view=message'));
        }else{
            hb_enqueue_message('Đăng ký thất bại');
            wp_safe_redirect(site_url('/?view=message'));
        }

		exit;
	}
	
	private function sendMail($order_id){		
		HBImporter::helper('email');
		$mail=new EmailHelper();		
		return $mail->sendMail($order_id);		
	}
	
	//send mail via post curl
	public function urlSendmail(){
		$order_id = $this->input->getInt('order_id');
		$this->sendMail($order_id);
		exit;
	}
	
}