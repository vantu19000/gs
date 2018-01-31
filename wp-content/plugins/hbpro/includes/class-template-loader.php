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
		
		$path_info = substr($_SERVER['PHP_SELF'], 0, -9);
		$url = str_replace($path_info,'',$_SERVER ['REQUEST_URI']);
		$url = explode('/', $url);
		if($url[0]=='thong-bao'){
			$file='thong-bao.php';
		}
		
		if ( $file ) {
			$find = self::getRoot().$file;
			$template = locate_template($find);
		}
		
		return $template;
	}
	
	public static function getRoot(){
		return apply_filters('HB_template_path', '/hbpro/');
	}

	
}

HB_Template_Loader::init();
