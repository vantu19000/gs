<?php
/*
Plugin Name: hbpro	
Plugin URI: http://hbproweb.com/wordpress/plugins/hbpro.zip
Description: Customizing for wordpress.
Version: 1.0
Author: Vuong Anh Duong
Author URI: http://hbproweb.com/
Text Domain: prowp-plugin
License: GPLv2
*/

defined( 'ABSPATH' ) or die( 'Restricted access' );

if ( ! class_exists( 'HBFactory' ) ) :
class HBFactory {
	public $version = '1.0.0';
	public $loader;
	//configuration of plugin
	static $config;
	//process input of request
	static $input;
	//session
	static $cart;
	static $user;
	/**
	 * The single instance of the class.
	 *
	 */
	
	protected static $_instance = null;
	
	/**
	 * main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
		$this->includes();	
		$this->hook();
	}
	
	private function includes(){
		//define construct
		require 'defines.php';
		//libraries
		require_once HB_PATH.'libraries/hbobject.php';
		require_once HB_PATH.'libraries/importer.php';
		require_once HB_PATH.'libraries/hbview.php';
		require_once HB_PATH.'libraries/hbaction.php';
		require_once HB_PATH.'libraries/table.php';
		
		HBImporter::helper('debug','html','list','helper');
		HBImporter::includes('functions','widget-functions');
		//import require file only for admin sie
		if(is_admin()){
			HBImporter::includes(
					'admin/class-menu',
					'admin/class-post-types',
					'admin/functions',
					'admin/class-admin-autoloader',
					'admin/class-admin-metaboxs',
					'admin/class-view/class-posttype-view-list',
					'admin/class-view/class-posttype-view-metabox'
					);
			HB_Menu::addMenu();
			//add style
			add_action( 'admin_enqueue_scripts', 'hb_admin_add_root_stylesheet' );
			//load require file when need to optimize memory
			$this->loader = new HB_Admin_Autoload();
			$this->loader->load();
		}else{
			HBImporter::includes(
					'class-site-autoloader'
					);
			//load require file when need to optimize memory
			$this->loader = new HB_Site_Autoload();
			$this->loader->load();
			include_once HB_PATH.'apps/slideshow.php';		
		}
		
		//add extensions
		$config = self::getConfig();
		if($config->app_smtp_mail){
			include_once HB_PATH.'apps/wp_mail_smtp.php';
		}
		if($config->app_vn_wc){
			include_once HB_PATH.'apps/woocommerce-vn.php';
		}
		if($config->app_estate){
			include_once HB_PATH.'apps/estate.php';
		}
		
		
	}
	
	
	//get configuration of plugin
	public static function getConfig($name=''){
		if(empty(self::$config)){
			$config = get_option('hb_params','{}');
			$config = json_decode($config);
			//set default value if it is not set
			$default = array('date_format_short'=>'Y-m-d',
					'date_format_type_long'=>'Y-m-d',
					'formatHours'  => 12,
					'currency_symbol' => '$',
					'currency_display' => '0',
					'main_currency'	=> 'USD',
					'ps_group' => 1,
					'currency_decimalpoint' => 2
			);
			foreach ($default as $key=>$val){
				if(!isset($config->$key)){
					$config->$key = $val;
				}
			}
			$config = new HBObject($config);
			self::$config = $config;
		}
		if($name){
			return self::$config->$name;
		}
		return self::$config;
	}
	
	
	public static function getDate($string_date = 'now',$timezone= false){
		if($timezone){
			$date = new DateTime($string_date, new DateTimeZone($timezone));
		}else{
			$date = new DateTime($string_date);
		}
	
		return $date;
	}
	
	/*
	 * Get input of request
	 */
	public static function getInput(){
		if(empty(self::$input)){
			require_once HB_PATH.'libraries/factory/hbinput.php';
			self::$input = new HBInput();
		}
		return self::$input;
	}
	
	/**
	 * get cart from session
	 */
	public static function getCart(){
		if(empty(self::$cart)){
			HBImporter::includes('class-cart');
			self::$cart = new HBCart();
			self::$cart->load();
		}
		return self::$cart;
	}
	
	/**
	 * Get account logined
	 * @return Customer
	 */
	public static function getUser($user_id = null)
	{
		$id = (int)$user_id;
		if(!self::$user[$id]){
			require_once HB_PATH.'libraries/customer.php';
			if($id){
				$user = get_user_by('ID',$id);
			}else{
				$user = wp_get_current_user();
			}
			//if user exist
			if($user->ID){
				$id = $user->ID;
				if(!self::$user[$user->ID]){
					self::$user[$user->ID] = new HBUser($user->id);
				}
			}else{
				if(!self::$user[0]){
					self::$user[0] = new BookproUser();
				}
			}
		}
	
		return self::$user[$id];
	}
	
	public function hook(){
		include HB_PATH.'includes/hook/post.php';
	}
	
}
endif;

HBFactory::instance();

register_activation_hook( __FILE__, 'hb_activation' );
function hb_activation() {
	require HB_PATH.'install.php';
}