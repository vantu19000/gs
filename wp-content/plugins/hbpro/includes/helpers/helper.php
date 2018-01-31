<?php

/**
 * @package 	Bookpro
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/

defined('ABSPATH') or die('Restricted access');

class HBHelper
{
	static function formatArrayForCloneForm($arrays){
		$result = array();
		
		foreach ($arrays as $key=>$array){
			foreach ($array as $i=>$val){
				$result[$i][$key] = $val;
			}
			
		}
		return $result;
	}
	/*Clear value for memory*/
	static function clear(&$value){
		$value = null;
		unset($value);
		return;
	}
	static function isAgent($id = null){
		$checked = false;
		$user = JFactory::getUser($id);
		if(JComponentHelper::getParams('com_bookpro')->get('agent_usergroup') && $user->groups){
			if(in_array(JComponentHelper::getParams('com_bookpro')->get('agent_usergroup'), $user->groups)){
				$checked = true;
			}
		}

		return $checked;
	}
	
	static function getAgentParams($id = null){
			
		$user = JFactory::getUser($id);
	
		if(empty($user)){
			return false;
		}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('params');
		$query->from($db->quoteName('#__bookpro_customer'));
		$query->where($db->quoteName('user').' = '.$user->id);
		$db->setQuery($query);
		$data = $db->loadResult();
		$result = json_decode($data);
		return $result;
	}
    
	
	static function renderLayout($name,$displayData,$path='layouts'){
		$file = $path.DS.$name.'.php';
		$find[] = HB_Template_Loader::getRoot().$file;
		$template       = locate_template( array_unique( $find ) );
		if(!$template){
			$template = HB_PATH ."templates/$file";
		}
		
		ob_start();
		include $template;
		$layoutOutput = ob_get_contents();
		ob_end_clean();
		return $layoutOutput;
	}
	
	static function getRangeSelect($selected){

		$option[] = JHtml:: _('select.option',0, JText::_("COM_BOOKPRO_QUICK_FILTER_DATE"));
		$option[] = JHtml:: _('select.option','today', JText::_("COM_BOOKPRO_TODAY"));
		$option[] = JHtml:: _('select.option','past_week', JText::_("COM_BOOKPRO_LAST_WEEK"));
		$option[] = JHtml:: _('select.option', 'past_1month', JText::_("COM_BOOKPRO_LAST_MONTH"));
		return JHtml::_('select.genericlist',$option,'filter_range','onchange="this.form.submit();" class="input input-medium"','value','text',$selected);

	}


	static function formatGender($gender,$symbol=false){
		if($gender=='M') {
			if($symbol)
				return 'M';
			else
				return __('Male');
		}
		else
			if($symbol)
				return 'F';
			else
				return __('Female');
	}

	static function formatAge($age){
		switch ($age){
			case 1 :
				return JText::_('COM_BOOKPRO_ADULT');
				break;
			case 2:
				return JText::_('COM_BOOKPRO_CHILDREN');
				break;
			case 3 :
				return JText::_('COM_BOOKPRO_INFANT');
				break;
		}

	}

	static function getGender(){

		return array(array('value'=>'M','text'=>JText::_('COM_BOOKPRO_MALE')),array('value'=>'F','text'=>JText::_('COM_BOOKPRO_FEMALE')));
	}
	static function getAge(){

		return array(array('value'=>1,'text'=>JText::_('COM_BOOKPRO_ADULT')),array('value'=>0,'text'=>JText::_('COM_BOOKPRO_CHILDREN')),array('value'=>2,'text'=>JText::_('INFANT')));
	}

	
	/**
	 * Get e-mail mode value to using in JUtility::sendMail().
	 *
	 * @param int $emailMode setting value
	 * @return boolean true HTML, false PLAIN TEXT
	 */
	function getEmailMode($emailMode)
	{
		$emailMode = $emailMode != PLAIN_TEXT;
		return $emailMode;
	}

	/**
	 * Convert HTML code to plain text. Paragraphs (tag <p>) and
	 * break line (tag <br/>) replace by end line sign (\n or \r\n)
	 * and remove all others HTML tags.
	 *
	 * @param $string to convert
	 * @return $string converted to plain text
	 */
	function html2text($string)
	{
		$string = str_replace('</p>', '</p>' . PHP_EOL, $string);
		$string = str_replace('<br />', PHP_EOL, $string);
		$string = strip_tags($string);

		return $string;
	}

	function sendMail($to, $subject, $body , $headers = null, $attachments = null)
	{
		if(!$header){
			$headers = array('Content-Type: text/html; charset=UTF-8');
			//$headers[] = 'From: Me Myself <me@example.net>';
			//$headers[] = 'Cc: John Q Codex <jqc@wordpress.org>';
			//$headers[] = 'Cc: iluvwp@wordpress.org'; // note you can just use a simple email address
		}
		
		return wp_mail( $to, $subject, $body, $headers, $attachments );
	}
	
	static function getPassengerForm($adult,$children,$infant){
		$passengers = array();
		$number = 0;
		if ($adult) {
			for($i =0;$i < $adult;$i++){
				$passenger = new stdClass();
				$passenger->title = sprintf(__('Adult %s','hb'),$i+1);
				$passenger->group_id = 1;
				$passenger->type = 'adult';
				$passenger->number = $number;
				$passengers[] = $passenger;
				$number++;
			}
		}
		if ($children) {
			for($i =0;$i < $children;$i++){
				$passenger = new stdClass();
				$passenger->title = sprintf(__('Child %s','hb'),$i+1);
				$passenger->group_id = 2;
				$passenger->type = 'children';
				$passenger->number = $number;
				$passengers[] = $passenger;
				$number++;
			}
		}
		if ($infant) {
			for($i =0;$i < $infant;$i++){
				$passenger = new stdClass();
				$passenger->title = sprintf(__('Infant %s','hb'),$i+1);
				$passenger->group_id = 3;
				$passenger->type = 'infant';
				$passenger->number = $number;
				$passengers[] = $passenger;
				$number++;
			}
		}
		return $passengers;
	}
	
	//ping to url with timeout 1s
	static function pingUrl($url=NULL)  
	{  
	    if($url == NULL) return false;  
	    $ch = curl_init($url);  
	    curl_setopt($ch, CURLOPT_TIMEOUT,1);  
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	    $data = curl_exec($ch);  
//	    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	    curl_close($ch);  
	    return $data;
	}
	
	
	static function write_log($log_file, $error){
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date = date('d/m/Y H:i:s');
		$error = $date.": ".$error."\n";
		
		$log_file = ABSPATH."logs/".$log_file;
		if(filesize($log_file) > 1048576 || !file_exists($log_file)){
			$fh = fopen($log_file, 'w');
		}
		else{
			//echo "Append log to log file ".$log_file;
			$fh = fopen($log_file, 'a');
		}
		
		fwrite($fh, $error);
		fclose($fh);
	}
	
	public static function check_nonce($name= 'hb_meta_nonce', $action = 'hb_action'){
		$input = HBFactory::getInput();
		$name_str = $input->get($name);
		if ( empty($name_str ) || ! wp_verify_nonce( $input->get($name), $action ) ) {
			wp_die(__('Invalid action!'));
		}
	}
	
	public static function translate_eng($str){
		$str = preg_replace("/(à|á|ạ|ả|ã|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
		$str = preg_replace("/(đ)/", "d", $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
		$str = preg_replace("/(Đ)/", "D", $str);
		return $str;
	}

}




?>
