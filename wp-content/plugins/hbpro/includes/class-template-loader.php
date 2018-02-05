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
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ));
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
		$path_info = substr($_SERVER['PHP_SELF'], 0, -9);
		$url = substr($_SERVER ['REQUEST_URI'],strlen($path_info));		
		$url = explode('/', $url);
		$query = $url[0];
		
		$end = strpos($query, "?");
		if($end){
			$query = substr($query, 0,$end);
		}else{
			$query = substr($query, 0);
		}
		
		switch ($query){
			case 'thong-bao':
				$file='thong-bao.php';
				break;
			case 'ket-qua-tim-kiem';
				$file='result.php';
				break;
		}
		
		if ( $file ) {
			$find = self::getRoot($file);
			$template = $find;
		}
		return $template;
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
