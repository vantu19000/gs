<?php
/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airport.php 66 2012-07-31 23:46:01Z quannv $
 **/

//namespace HB;

// Check to ensure this file is included in Joomla!
defined ( 'ABSPATH' ) or die ();

class HB_Menu {
	
	static function addMenu(){
		add_action( 'admin_menu', array( get_called_class(), 'admin_menu' ));
		
	}
	
	public static function admin_menu() {
	    global $wpdb;
	    $count = $wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}hbpro_users  WHERE status = 0");
	    $order = $wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}hbpro_orders WHERE order_status != 1");
	    $icon = null; if ($count[0]->count > 0) $icon = "<span style='color: #FFC107'>🛈</span>";
	    $notice = null; if ($count[0]->count + $order[0]->count > 0) $notice = $count[0]->count + $order[0]->count;
		add_menu_page( 'HBPRO', 'Quản lí gia sư <span class="awaiting-mod count-'.$notice.'"><span class="pending-count">'.$notice.'</span></span>', 'manage_options', 'hb_dashboard',  array( get_called_class(), 'dashboard' ), site_url().'/wp-content/plugins/hbpro/assets/images/logo.png', 5 );
		add_submenu_page( 'hb_dashboard', 'Đơn đăng kí học', 'Đơn đăng kí học <span class="awaiting-mod count-'.$order[0]->count.'"><span class="pending-count">'.$order[0]->count.'</span></span>', 'manage_options', 'hb_dashboard', array( get_called_class(), 'dashboard' ) );
		add_submenu_page( 'hb_dashboard', 'Quản lý gia sư', 'Quản lý gia sư', 'manage_options', 'teacher', array( get_called_class(), 'add_teacher_page' ) );
		add_submenu_page( 'hb_dashboard', 'Gia sư chờ phê duyệt', 'Gia sư chờ phê duyệt <span class="awaiting-mod count-'.$count[0]->count.'"><span class="pending-count">'.$count[0]->count.'</span></span>', 'manage_options', 'hb_register', array( get_called_class(), 'add_register_page' ) );
//		add_submenu_page( 'hb_dashboard', 'hbpro setting', 'Hbpro setting', 'manage_options', 'hb_setting', array( get_called_class(), 'add_setting_page' ) );
		
	}
	
	public static function dashboard(){
	
		HBImporter::includes('admin/orders/view');
	}
	public static function add_teacher_page(){
		HBImporter::includes('admin/teacher/view');
	}
	
	public static function add_register_page(){
		HBImporter::includes('admin/register/view');
	}
		
	//setting page
	public static function add_setting_page(){
		HBImporter::includes('admin/setting/view');
	}
}
