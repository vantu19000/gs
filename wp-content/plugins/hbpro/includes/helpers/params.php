<?php

/**
 */


class HBParams
{
	/**
	 * get langugage setting
	 * require xmlhelper
	 */
    static function getLanguageConfig(){
    	$config = array();
    	$file_filter = JPATH_ADMINISTRATOR.'/components/com_bookpro/data/language_filter.xml';
		$filter = JFactory::getXML($file_filter);
		$config['main_lang'] = 'en-GB';		
		$config['folder_site']		= JPATH_SITE .DS."language".DS;
		$config['folder_admin']	= JPATH_ADMINISTRATOR .DS."language".DS;
		//admin language file
		$config['file_admin'] = XmlHelper::getAttribute($filter->admin->file, 'name');
		//site language file
		$config['file_site']	= XmlHelper::getAttribute($filter->site->file, 'name');
		return $config;
    }
    
    static function get_customer_email_key(){
    	return array(
    			'firstname'	=>'First name',
    			'lastname'	=>'Last name',
    			'email'	=>'Email',
    			'address'	=>'Phone number',
    			'city'	=>'City',
    			'name'=>'Country',
    			'telephone'	=> 'Telephone',
    			'mobile'	=> 'Mobile',
    			'zip'		=> 'Zip code'
    	);
    }
    
    static function get_order_email_key(){
    	return array(
    			'order_number'	=>'Order number',
    			'pay_status'	=>'Payment status',
    			'total'			=>'Total amount',
    			'order_status'	=>'Order status',
    			'notes'			=> 'Notes',
    			'created'		=> 'created',
    			'pay_method'	=> 'Payment method, that is way customer pay money'
    	);
    }
	
	
    
    static function get_class_type(){
    	$array = array();
    	for($i=1;$i<13;$i++){
    		$array[$i]=$i; 
    	}
    	return $array;
    }
	
	static function get_exp_type(){
		return array(
			'0' => 'Giáo viên chuyên nghiệp',
			'1' => 'Gia sư cộng đồng'
		);
	}
	
	static function get_subject_type(){
		return array(
				'1' => 'Toán',
				'2' => 'Văn',
				'3' => 'Tiếng Anh',
				'4' => 'Vật lí',
				'5' => 'Hóa học'
		);
	}
	
	static function get_degree_type(){
		return array(
				'1' => 'Cao đẳng',
				'2' => 'Đại học',
				'3' => 'Thạc sĩ'
		);
	}
	
	static function get_customer_group(){
		return array(
				'teacher'=>'Gia sư',
				'student' => 'Học sinh',
				'parent' =>'Phụ huynh'
		);
	}
	
	static function get_villages(){
		global $wpdb;
		return $wpdb->get_results('select * from devvn_xaphuongthitran');
	}
	
	static function get_provinces(){
		global $wpdb;
		return $wpdb->get_results('select * from devvn_quanhuyen');
	}
	static function get_districts(){
		global $wpdb;
		return $wpdb->get_results('select * from devvn_tinhthanhpho');
	}
	static function get_gender(){
		return array(
				'F'=>"Nam",
				'M'=>"Nữ"
		);
	}
	
	
	
	static function get_pay_method(){
		AImporter::helper('file');
		$files = FileHelper::getFiles(JPATH_ROOT.'/plugins/bookpro/');
		$result = array();
		foreach($files as $file){
			if(substr($file, 0,7)=='payment'){
				$file = substr($file,8);
				$result[$file] = $file;
			}			
		}
		return $result;
	}
	
    
    static function get($key_val,$type=false){
    	$function = 'get_'.$key_val;
    	$data = self::$function();
    	if($type){
    		switch ($type) {
    			case 'arrayObject':
    				$result = array();
    				foreach ($data as $key=>$val){
    					$result[] = (object)array('value'=>$key,'text'=>$val);
    				}
    				return $result;
    				break;
    			case 'array':
    				$result = array();
    				foreach ($data as $key=>$val){
    					$result[$val] = $key;
    				}
    				return $result;
    				break;
    			default:
    				break;
    		}
    	}
    	return $data;
    }
    
}

?>