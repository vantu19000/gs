<?php
/**
 *View display page HB_rate
 */ 
HBImporter::includes('admin/rate/table');

class HBAdminViewRate extends HBAdminView{
	
	public function display($tpl=null){
		$this->table = new HBTableRate();
		$this->routes = HBList::getRoutes();
		if(empty($this->routes)){
			echo "You must create routes<br><a href='".admin_url('edit.php?post_type=HB_route')."'>Back to create route</a>";
			exit;
		}
		$this->route_id = !empty($_REQUEST['route_id']) ? $_REQUEST['route_id'] : key($this->routes);
		$this->logs = $this->table->getLog($this->route_id);
		$this->route = $this->routes[$this->route_id];
		return parent::display($tpl);
	}
	
	public function getDayWeek($name){
		HBImporter::helper('date');
		$days=HBDateHelper::dayofweek();
		$daysweek=array();
		foreach ($days as $key => $value)
		{
			$object=new stdClass();
			$object->key=$key;
			$object->value=$value;
			$daysweek[]=$object;
		}
		$selected=array_keys($days);
		return HBHtml::checkBoxList($daysweek,$name,'','key','value',$selected);
	
	}
	
}

$view = new HBAdminViewRate();
$view->display();
?>
