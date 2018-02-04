<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Template Loader
 * Load template and override from theme for front end
 * @class 		HB_Template_Loader
 * 
 */
class HB_Template_Loader {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
	}

	/**
	 * Load a template.
	 *
	 * For override template of current theme. It is "HB" folder in theme. If there are no existed file in folder
	 * "HB" in theme then it will use file in template of plugin
	 *
	 * @param mixed $template
	 * @return string
	 */
	public static function template_loader( $template ) {
		$file = '';
		//echo '<pre>';
		$path_info = substr($_SERVER['PHP_SELF'], 0, -9);
		//echo '<pre>'.$path_info.'</pre>';
		//echo $_SERVER ['REQUEST_URI'];
		$url = substr($_SERVER ['REQUEST_URI'],strlen($path_info)); //str_replace($path_info,'',$_SERVER ['REQUEST_URI']);
		//print_r($url);
		$url = explode('/', $url);
		//print_r($_SERVER['PHP_SELF']);
		//print_r($url);
		//	die();
		switch ($url[0]){
			case 'thong-bao':
				$file='thong-bao.php';
				break;
			case 'ket-qua-tim-kiem';
			
				//add_filter('wp_title', array( __CLASS__, 'get_title' ));
				$file='result.php';
				break;
		}
		
		if ( $file ) {
			$find = self::getRoot($file);
			$template = $find;locate_template($find);
		}
// 		debug($find);
// 		debug($template);
		
// 		die;
		return $template;
	}
	
	function get_title(){
		return 'Kết quả tìm kiếm';
	}
	
	public static function getRoot($file_name){
		$path = get_template_directory().'/hbpro/'.$file_name;
		if(file_exists($path)){
			return $path;
		}else{
			return plugin_dir_path(__DIR__).'templates/'.$file_name;
		}
	}

	
}

HB_Template_Loader::init();
