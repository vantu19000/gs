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
        global $wpdb;
		$file = '';
		$path_info = substr($_SERVER['PHP_SELF'], 0, -9);
		$url = substr($_SERVER ['REQUEST_URI'],strlen($path_info));		
		$url = explode('/', $url);
		foreach($url as &$path){
			$end = strpos($path, "?");
			if($end){
				$path = substr($path, 0,$end);
			}
		}
		
		
		switch ($url[0]){
			case 'thong-bao':
				$file='thong-bao.php';
				break;
			case 'danh-sach-gia-su';
				$file='result.php';
				break;
			case 'gia-su':
				$name = $url[1];

				global $title_gia_su;

                $title_gia_su = $name;
				$id = explode('-', $name);

                $tieude = reset( $wpdb->get_results("SELECT full_name FROM {$wpdb->prefix}hbpro_users WHERE id = " . end($id)) );

                $title_gia_su = $tieude->full_name . ' - ' . get_bloginfo();

                http_response_code (200);
                $input = HBFactory::getInput();
				$input->set('teacher_id', end($id));
				$file = 'teacher.php';

                add_filter('wpseo_title', 'filter_product_wpseo_title');
                function filter_product_wpseo_title($title) {
                    global $title_gia_su;
                    return $title_gia_su;
                }

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
