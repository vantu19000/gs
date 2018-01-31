<?php


class HBAdminViewRegister extends HBAdminView{
	public $items;
	
	public function display($tpl=null){
		$this->items = $this->get('Items');
		
		$input = HBFactory::getInput();
		if($input->get('layout') == 'edit'){
			$this->item = $this->get('Item');
		}
// 		$this->state = $this->get('State');
// 		$this->pagination = $this->get('Pagination');
		parent::display($tpl);
	}
	
}

$view = new HBAdminViewRegister();
$view->display();
?>
