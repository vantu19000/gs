<?php

class HBActionTeacher extends hbaction{	
	
	public function save(){
		global $wpdb;
		$post = $this->input->getPost();
		$data = $post['data'];

        $subject = '';
        foreach ($data['subject_id'] AS $value){
            $subject .= $value.",";
        }

        $data['subject_id'] = rtrim($subject,",");

        $huyen = '';
        foreach ($data['province_id'] AS $value){
            $huyen .= $value.',';
        }

        $data['province_id'] = rtrim($huyen, ",");

        $class ='';
        foreach ($data['class_type'] AS $value){
            $class .= $value.',';
        }
        $data['class_type'] = rtrim($class, ",");

        if($this->input->get('id')){
            $result = $wpdb->update("{$wpdb->prefix}hbpro_users", $data, array('id'=>$this->input->get('id')));
		}else{
//			$result = $wpdb->insert("{$wpdb->prefix}hbpro_users", $data);
//			wp_safe_redirect(admin_url('admin.php?page=teacher&layout=edit&id='.$wpdb->insert_id));
		}

        wp_safe_redirect(admin_url('admin.php?page=teacher&layout=edit&id='.$this->input->get('id')));

        if($result){
			hb_enqueue_message('Cập nhật thành công');
			$_SESSION['teacher']['data'] = false;
		}
		else{
            if ($result === 0){
                hb_enqueue_message('Không có trường nào thay đổi');
            }else{
                hb_enqueue_message('Cập nhật thất bại');
                hb_enqueue_message($wpdb->show_errors(),'error');
            }
            //neu that bai luu du lieu nay lai de user khong phai nhap lai du lieu nay
			$_SESSION['teacher']['data'] = (object)$data;
		}

        exit;
	}
	
	/*
	 * save Log when adding rate for route
	 */
	private function saveLog($frate,$week,$jform,$frateparams){
		global $wpdb;
		$content = new stdClass();
		$content->week = $week;
		$content->price = array();
		$content->params = $frateparams;
		foreach ($frate as $rate){
			$type = $rate['pricetype'];
			unset($rate['pricetype']);
			$content->price[$type]=$rate;
		}
		$data = array();
		$data['startdate'] = $jform ['startdate'];
		$data['enddate'] = $jform ['enddate'];
		$data['route_id'] = $jform ['route_id'];
		$data['content'] = json_encode($content);
		$wpdb->insert($wpdb->prefix.'HB_routeratelog', $data);
		return true;
	}
	
	function ajaxSavedayrate() {
		
		global $wpdb;
		$data = $_REQUEST['frate'];
		$additional = $_REQUEST['frateparams'];
		//delete old rate
		$check = false;
		$wpdb->get_results("DELETE FROM {$wpdb->prefix}HB_routerate WHERE 
			route_id={$additional['route_id']}
			AND date='{$additional['date']}'");
		
		foreach($data as $rate){
			$temp = array_merge ($additional, $rate);
			$check = $wpdb->insert($wpdb->prefix.'HB_routerate', $temp);
		}
		
		if($check){
			echo 'Update successful!';
		}else{
			echo 'Update failed!';
		}
		
		die;
	
	}

    function delete(){

        global $wpdb;
        $ids = $_REQUEST['id'];

        foreach ($ids AS $id){
            $user = $wpdb->query("SELECT * FROM {$wpdb->prefix}hbpro_users WHERE id={$id}");
            $check = $wpdb->query("DELETE FROM {$wpdb->prefix}hbpro_users WHERE id={$id}");
            wp_delete_user($user->user_id);
        }

        wp_redirect(admin_url('admin.php?page=teacher'));
        return;

    }
	
	function deleteratelogs(){
		$route_id 		= $_REQUEST['route_id'];
		$cid = $_REQUEST['log'];
		if (count($cid)) {
			global $wpdb;
			$wpdb->get_results("DELETE FROM {$wpdb->prefix}HB_routeratelog WHERE id IN (".implode(',', $cid).")");
		}
	
		wp_redirect(admin_url('admin.php?page=HB_rate&route_id='.$route_id));
		
		return;
	}
	
	public function show_rate_detail(){
		HBImporter::includes('admin/rate/view');
		die();
	}
	
	public function new_calendar(){
		$input = HBFactory::getInput();
		$min_date = DateTime::createFromFormat('Y',$_REQUEST['year'])->modify('-1 year')->format('Y');
		$max_date = DateTime::createFromFormat('Y',$_REQUEST['year'])->modify('+1 year')->format('Y');
		$calendar_attributes = array (
				'min_select_year' => $min_date,
				'max_select_year' => $max_date
		);
		require_once HB_PATH.'classes/calendar.php';
		HBImporter::css('calendar');
		$calendar = new PN_Calendar($calendar_attributes);
		echo $calendar->draw(array(), $input->get('year'), $input->get('month'));
		exit;
	}

    function avatar(){
        $target_dir = "/wp-content/uploads/avatar";
        $userid = $_POST['userid'];
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                hb_enqueue_message(  "File is not an image." );
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file)) {
            hb_enqueue_message(  "Sorry, file already exists.");
            $uploadOk = 0;
        }
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            hb_enqueue_message( "Dung lượng file nhỏ hơn 2MB");
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            hb_enqueue_message( "Định dạn ảnh không hợp lệ, vui lòng chọn jpg, png, jpeg" );
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            hb_enqueue_message( "Lỗi, vui lòng cập nhật sau." );
        } else {

            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $newfilename = $userid . '.' . end($temp);

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], ABSPATH."/wp-content/uploads/avatar/" . $newfilename)) {
                global $wpdb;
                $wpdb->update("{$wpdb->prefix}hbpro_users", array('icon'=>"/wp-content/uploads/avatar/".$newfilename), array('id'=>$userid));
                hb_enqueue_message( "Upload thành công!" );
            } else {
                hb_enqueue_message( "Sorry, there was an error uploading your file." );
            }
        }
            wp_safe_redirect(site_url("wp-admin/admin.php?page=teacher&layout=edit&id=".$userid));
        exit;
    }
	
}