<?php


class HBAdminViewOrders extends HBAdminView{
	public $items;
	
	public function display($tpl=null){
		$this->items = $this->get('Items');
// 		$this->state = $this->get('State');
// 		$this->pagination = $this->get('Pagination');
		parent::display($tpl);
	}
	
}

$view = new HBAdminViewOrders();
$view->display();
?>
