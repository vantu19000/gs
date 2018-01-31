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
		add_menu_page( 'HBPRO', 'Dashboard', 'manage_options', 'hb_dashboard',  array( get_called_class(), 'dashboard' ), site_url().'/wp-content/plugins/hbpro/assets/images/logo.png', 5 );
		add_submenu_page( 'hb_dashboard', 'Register email', 'Register email', 'manage_options', 'hb_register', array( get_called_class(), 'add_register_page' ) );		
		add_submenu_page( 'hb_dashboard', 'hbpro setting', 'Hbpro setting', 'manage_options', 'hb_setting', array( get_called_class(), 'add_setting_page' ) );
		
	}
	
	public static function dashboard(){
	
		HBImporter::includes('admin/register/view');
	}
	
	public static function add_register_page(){
		HBImporter::includes('admin/register/view');
	}
		
	//setting page
	public static function add_setting_page(){
		HBImporter::includes('admin/setting/view');
	}
}
