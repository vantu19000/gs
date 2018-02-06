<?php
//load include file by Url
defined ( 'ABSPATH' ) or die ();
class HB_Site_Autoload{

    public function __construct(){
        return true;
    }

    public function load(){
        //defined action in request to execute
        add_action( 'init', array($this,'execute_action'),15);
        $this->includefiles();

    }

    private function is_file($filename){
        return is_file(HB_PATH.$filename);
    }

    private function includefiles(){
        include HB_PATH.'includes/class-template-loader.php';
    }

    /**
     * Execute admin-post function via url request
     */
    function execute_action(){
		//do_action('init');
        $input = HBFactory::getInput();

        $view= $input->get('view');
        if($view){
            include HB_PATH.'templates/'.$view.'.php';
            exit;
        }
        $request_action = $input->get('hbaction');
        if($request_action){

            $task = $input->get('task');
            //Import action by request
            HBImporter::functions($request_action);
            $class = 'hbaction'.$request_action;

            $action = new $class;
            $action->execute($task);
            return;
        }
        return;
    }

}
