<?php
/*class HBModelOrders extends WP_List_Table{
	public function getItems(){
		global $wpdb;
		$input= HBFactory::getInput();
		$limit = $input->get('limit',0);
		$offset = $input->get('offset');
		$query = "Select * from {$wpdb->prefix}hbpro_orders order by id ASC where status=0";
		$where = array();
		if(isset($_GET['search']) && !empty($_GET['search'])){
			$search = "'%{$_GET['search']}%'";
			$where [] = " email like  {$search} OR phone like {$search} OR full_name LIKE {$search}";
		}
		if(!empty($where)){
			$query .= ' WHERE '.implode(' AND ', $where).'';
		}
		if($limit && ($offset != null || $offset != '')){
			
			$query .= " limit $offset,$limit";
		}
		return $wpdb->get_results($query);
	}
	
	public function getItem($id=null){
		global $wpdb;
		$input= HBFactory::getInput();
		if(!$id){
			$id= $input->get('id');
		}
		if($id){
			$query = "Select * from {$wpdb->prefix}hbpro_orders where id = $id";
			
			$result =  $wpdb->get_results($query);
			return reset($result);
		}
		
		if(!empty($_SESSION['teacher']['data'])){
			return $_SESSION['teacher']['data'];
		}
		return false;
		
	}
}*/
?>


<?php
class HBModelOrders {
    public function get_table_name(){
        global $wpdb;
        return "{$wpdb->prefix}hbpro_orders";
    }
    public function getItems(){
        global $wpdb;
        $input= HBFactory::getInput();
        $recent = (int)$_GET['p'];
        if (!$recent) $recent = 1;
        $limit = $input->get('limit',20);
        $offset = $input->get('offset', ($recent - 1) * 20);
        $query = "Select * from {$wpdb->prefix}hbpro_orders order by created DESC";
        if($limit){

            $query .= " limit $offset,$limit";
        }
        return $wpdb->get_results($query);
    }

    public function getItem($id=null){
        global $wpdb;
        $input= HBFactory::getInput();
        if(!$id){
            $id= $input->get('id');
        }
        if($id){
            $query = "Select * from {$wpdb->prefix}hbpro_users where id = $id";

            $result =  $wpdb->get_results($query);
            return reset($result);
        }

        if(!empty($_SESSION['teacher']['data'])){
            return $_SESSION['teacher']['data'];
        }
        return false;

    }
}