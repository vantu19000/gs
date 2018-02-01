<?php
//load include file by Url
defined ( 'ABSPATH' ) or die ('Retrict access');
class HB_Admin_Autoload{
	
	public function __construct(){
		return true;
	}
	
	public function load(){
		
		//load require files when show list of post_type
		if(isset($_REQUEST['post_type'])){
			$view_name = substr($_REQUEST['post_type'], 8);
			//load list file if exist
			if($this->is_file('includes/admin/'.$view_name.'/list.php')){
				HBImporter::includes('admin/'.$view_name.'/list');
			}
			
		}
		
		//defined action in request to execute
		
		add_action( 'admin_post_hbaction', array($this,'execute_action'),15,1);
		/* wordpress rule
		$role_object = get_role( 'editor' );
		$role_object->add_cap( 'edit_theme_options' );
		*/
		
	}
	
	public function is_file($filename){
		return is_file(HB_PATH.$filename);
	}
	
	/**
	 * Execute admin-post function via url request
	 */
	function execute_action(){
// 		die('223');
		if(!current_user_can( 'manage_options' )){
			wp_redirect(admin_url('wp-login.php'));
			exit;
		}
		
		$input = HBFactory::getInput();
		$request_action = $input->get('hbaction');
		
		//$user = wp_get_current_user();
		//debug($user);die;
		
		if($request_action){
			// Check the nonce
			$meta_nonce = $input->get('hb_meta_nonce');
			if ( empty( $meta_nonce ) || ! wp_verify_nonce( $input->get('hb_meta_nonce'), 'hb_action' ) ) {			
				die('retricted access');
				exit;
			}
			$task = $input->get('task');
			//Import action by request
			HBImporter::viewaction($request_action);
			$class = 'HBAction'.$request_action;
		
			$action = new $class;
			$action->execute($task);
			exit;
		}
	}
	
}
