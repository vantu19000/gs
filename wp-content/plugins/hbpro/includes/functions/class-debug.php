<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
defined('ABSPATH') or die;

class HBActionDebug extends HBAction{
	
	public function __construct($config=array()){
		parent::__construct();
		$this->checkPermission();
//		die('No permission');
	}
	
	private function checkPermission(){
		$user = wp_get_current_user();
		
		if(!in_array('administrator', $user->roles) && substr(site_url(), 0,16) != 'http://localhost'){
			$username = $this->input->getString('username');
			$password = $this->input->getString('password');
			$creds = array(
					'user_login'    => $username,
					'user_password' => $password
			);
			
			$user = wp_signon( $creds, false );
			if($user->ID){
				if(in_array('administrator', $user->roles)){
					return true;
				}
			}
			die('invalid request');
		}
		return;
	}
	
   private  function write_log($log_file, $error){
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$date = date('d/m/Y H:i:s');
		$error = $date.": ".$error."\n";
		$path = ABSPATH."/wp-content/uploads/logs/";
		if(!$path){
			
		}
		$log_file = $path.$log_file;
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
	
	
	private function dump($value){
		echo '---------<br><pre>';
		print_r($value);
		echo '</pre>';
	}
	
//show all function
	public function show(){
		
		$methods = get_class_methods($this);
		echo '<b>Method list</b><br>';
		echo '<table><tr><td>';
		echo '<a href="'.site_url().'">'.site_url().'</a>'.'<br>';
		foreach ($methods as $method){
			if(preg_match('/^debug(\w)*/', $method)){
				echo '<a href="'.site_url('index.php?hbaction=debug&task='.$method).'" class="btn btn-primary btn-wrapper">'.$method.'</a><br>';
			}
			
		}
		
		$links = array();
		$log_files = scandir(HB_PATH.'logs');
		foreach ($log_files as $f){
			if(!in_array($f, array('.','..','index.html')))
				$links[$f] = 'logs/'.$f;
		}
		echo "Link<ul>";
		foreach($links as $key=>$li){
			echo '<li><a href="'.site_url().'/wp-content/plugins/hbpro/'.$li.'">'.$key.'</li>';
		}
		echo "</ul>";
		
		
		foreach ($this->online_page as $online_page){			
			echo '</td><td>';
			echo "<a href='$online_page'>$online_page</a><br>";
			foreach ($methods as $method){
				
				if(preg_match('/^debug(\w)*/', $method)){
					echo '<a href="'.($online_page.'index.php?hbaction=debug&task='.$method).'" class="btn btn-primary btn-wrapper">'.$method.'</a><br>';
				}
				
			}
			echo "Link<ul>";
			foreach($links as $key=>$li){
				echo '<li><a href="'.$online_page.$li.'">'.$key.'</li>';
			}
		}
		
		echo "</ul>";
		echo "</td></tr></table>";
		echo '<a href="http://localhost/wordpress/">Back to localhost</a>';
		exit;
	}
	// query
	public function debugSQL($value= null){
		
		echo '<form method="Post" action="'.site_url('index.php?hbaction=debug&task=runsql').'" name="debug">
				SQL query: <br><textarea name="sql" style="width:100%" rows="15">'.$value.'</textarea><br>
				<input type="checkbox" name="log" value="1"/>Save log<br>
				<input type="checkbox" name="remote" value="1"/>Send request to Remote Host<br>
				<input type="submit"/>
				</form>';
		$this->show();
	}
	
	public function pingUrl($url=NULL,$timeout = 1)  
	{  
	    if($url == NULL) return false;  
	    $ch = curl_init($url);  
	    curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);  
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	    $data = curl_exec($ch);  
//	    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	    curl_close($ch);  
	    return $data;
	}
	
	public function exeSql($sql){
		
	}
	
public function runSql(){
		global $wpdb;
		$input = HBFactory::getInput();
		if(isset($_GET['sqlcode'])){
			$sql_str = base64_decode($_GET['sqlcode']);
		}else{
			$sql_str = $_POST['sql'];
		}
		$sql_str = str_replace(array("\'",'\"'), "'", $sql_str);
		$w_log = $input->getInt('log');
		$sql = str_replace('#__', $wpdb->prefix, $sql_str);
		//get plain text
		//---------run sql-----------------//
		$result = $wpdb->query($sql);
		
		if($wpdb->last_error){
			$this->dump($wpdb->last_error);
		}
		/*-end-*/
		//write log
		if($result   && $w_log){
			$this->write_log('jb_sql.txt', PHP_EOL.$sql);
		}
		
		if($input->getInt('die')){
			$this->dump($result);
			die;
		}
		//send request to remote host if sql is executed
		$remote = $input->getInt('remote');
		if($remote){
			foreach ($this->online_page as $online_page){	
				$url = $online_page.'index.php?hbaction=debug&log=1&task=runsql&die=1&remote=1&sqlcode='.base64_encode($sql).'&'.http_build_query($this->online_account);
				
				$remote_result = $this->pingUrl($url,0);			
				$this->dump('Remote '.$online_page.': '.$remote_result);
			}
			
		}
		
		$this->dump('Result: '.(int)$result);
		$this->dump('SQL: '.$sql);
		
		if ((strpos($sql,'select')) !== false || (strpos($sql,'SELECT')) !== false || (strpos($sql,'show')) !== false){
			
			$this->dump($wpdb->get_results($sql)) ;
		}
		$this->debugSql($sql_str);
		$this->show();
	}
	
	private function exe_sql($sql){
		$servername = DB_HOST;
		$username = DB_USER;
		$password = DB_PASSWORD;
		$dbname = DB_NAME;

		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$check = $conn->exec($sql);
			}
		catch(PDOException $e)
			{
			echo $e->getMessage();
			return false;
			}
		
		$conn = null; 
		return $check;
	}
	
	//-----------------------------debug script--------------------------------------
	function debugScript($script = null){
		echo '<form action="'.site_url('index.php?hbaction=debug&task=runScript').'" method="Post">
				<div class="control-group">
					<div class="control-label">
						Script file
					</div>
					<div class="controls">
						<textarea rows="4" cols="30" name="script" style="width:100%">'.$script.'</textarea>
					</div>
				</div>
				<input type="checkbox" name="remote" value="1"/>Send request to Remote Host<br>
				<input type="submit"/>
				</form>';
		return;
	}
	public function runScript(){
		$input = HBFactory::getInput();
		$script = $_POST['script'];
		if($input->getString('code')){
			$script = base64_decode($input->getString('code'));
		}
		$this->dump($script,'Script');
		
		$result = eval($script);		
			
		if($input->getInt('die')){
			echo $result;
			die;
		}
		//send request to remote host if sql is executed
		$remote = $input->getInt('remote');
		if($remote){
			foreach ($this->online_page as $online_page){
				$remote_result = $this->pingUrl($online_page.'index.php?hbaction=debug&log=1&task=runscript&die=1&remote=1&code='.base64_encode($script).http_build_query($this->online_password),0);
				$this->dump('Remote '.$online_page.': '.$remote_result);
			}
				
		}
		
		if($result === false){
			$this->dump('error','error');
		}
		else{
			$this->dump('success');
			$this->write_log('jb_script.txt', PHP_EOL.$script);
		}
		
		$this->debugScript($script);
	}
	
	
	public function debugCreateTheme($string = null){
		$array = array('json_decode','json_encode','html_entity_decode','htmlentities','base64_decode','base64_endcode');
		echo '<form method="Post" action="'.site_url('index.php?hbaction=debug&task=runString').'" name="debug">
				String: <textarea name="sql" rows="15" style="width:100%">'.$string.'</textarea>
				Type 
				<select name="type">';
		foreach ($array as $a){
			echo '<option value="'.$a.'">'.$a.'</option>';
		}
		echo '</select>
				<input type="submit"/>
				</form>';
		return;
	}
	
	
	public function runString(){
		$input = HBFactory::getInput();
		
		$sql = $_POST['sql'];
		$type = $input->getString('type');
		debug($type($sql));
		$this->debugString($sql);					
		$this->show();
	}
	
	public function debugStringReplace($string = null){
		$array = array('base64_decode');
		echo '<form method="Post" action="'.site_url('index.php?hbaction=debug&task=runStringReplace').'" name="debug">
				String: <textarea name="sql" rows="15" style="width:100%">'.$string.'</textarea>
				Type 
				<select name="type">';
		foreach ($array as $a){
			echo '<option value="'.$a.'">'.$a.'</option>';
		}
		echo '</select>
				<input type="submit"/>
				</form>';
		return;
	}
	
	
	public function runStringReplace(){
		$input = HBFactory::getInput();
		
		$sql = $input->getString('sql');
		$type = $input->getString('type');
		$encode = array('4','3','5','1','2');
		$decode = array('i','u','e','a','o');
		$content = $type($sql);
		debug(str_replace($encode, $decode, $content));
		$this->debugString($sql);					
		$this->show();
	}
	
	public function debugBackup(){
		echo '<form method="Post" action="'.site_url('index.php?hbaction=debug&task=runBackup').'" name="debug">
				Table name: <input type="text" name="sql" style="width:100%"/><br>				
				<input type="submit"/>
				</form>';
		return;
	}
	
	public function runBackup(){
		$input = HBFactory::getInput();
		$name = $input->getString('sql');
		global $wpdb;
		$query = $db->getQuery(true);
		$query->select('*')
		->from($db->quoteName($name));
			
		echo 'Table'.$name.'<br>';
		$wpdb->get_results($query);
		$result = $db->loadObjectList();
		echo  json_encode($result);
	}
	
	public function debugRestore(){
		echo '<form method="Post" action="'.site_url('index.php?hbaction=debug&task=runRestore').'" name="debug">
				Table name: <input type="text" name="name" style="width:100%"/><br>
				Data: <input type="text" name="sql" style="width:100%"/><br>
				Delete Old data: <input type="checkbox" name="delete" value="1"/><br>
				<input type="submit"/>
				</form>';
		return;
	}
	
public function runRestore(){
		$input = HBFactory::getInput();
		$data = $input->getString('sql');
		$name = $input->getString('name');
		$delete = $input->getInt('delete');
		global $wpdb;
		if($delete){
			$wpdb->get_results('delete * from '.$db->quoteName($name).' where 1;');
			try{
				$result = $wpdb->get_results($sql);			
			}
			catch(RuntimeException $e){
				die('delete table error');
			}
			echo 'Result: ';
			var_dump($result);
		}
		$sql = 'INSERT INTO '.$db->quoteName($name).' values ';
		$datas = json_decode($data);
		$sql_data = array();
		foreach ($datas as $data){
			$row = '';
			foreach ($data as $d){
				$row .= !empty($d) ? $db->quote($d).',' : '"",';
			}
			$sql_data[] = '('.substr($row, 0,-1).')';
		}
		$sql .= implode(',', $sql_data).';';
		$this->dump($sql);
		
		try{
			$result = $wpdb->get_results($sql);
		}
		catch(RuntimeException $e){
			$this->dump('sql error','error');
		}
		$this->dump($result);
		$this->show();
	}
	
	public function debugSwitchTheme(){
		if($this->input->get('theme')){
			$theme = $this->input->get('theme');
			global $wpdb;
			$query = "update {$wpdb->prefix}options set option_value='".$wpdb->esc_like($theme,array())."' where option_name LIKE 'template' OR option_name LIKE 'stylesheet'";
			$check = $wpdb->query($query);
			//add menu to the theme
			$sql = "SELECT term_id FROM wp_terms AS t LEFT JOIN wp_term_taxonomy AS tt ON tt.term_id = t.term_id
				WHERE tt.taxonomy = 'nav_menu' AND t.slug='main';";
			$menu = $wpdb->get_var($sql);
			
			$locations = get_theme_mod('nav_menu_locations');
			$locations['primary'] = $menu;
			set_theme_mod( 'nav_menu_locations', $locations );
			
			wp_redirect(site_url());
			exit;
		}
		$cat_args=array(
				'exclude' => '1,10',
				'hide_empty' => 0
		);
		$themes = wp_get_themes();
// 		debug($themes);
		echo '<h1>Theme</h1>';
		foreach($themes as $key=>$theme){
			echo '<a href="index.php?hbaction=debug&task=debugswitchtheme&theme='.$key.'">'.$key.'</a><br>';
		}
		echo '<br>';
		$this->show();
	}
	
	public function debugSendMail(){
		global $wpdb;
		$wpdb->get_results('select * from #__bookpro_orders limit 0,10');
		$orders = $db->loadObjectList();
		
		foreach ($orders as $i=>$order){
			echo '<a href="index.php?hbaction=debug&task=runsendmail&order_id='.$order->id.'">'.$order->id.'</a><br>';
		}
		return $this->show();
	}
	
	public function runsendmail(){
		$order_id = $this->input->getInt('order_id');
		AImporter::helper('email');
		$mail = new EmailHelper();
		debug($mail->sendMail($order_id));
		return $this->show();
		
	}
	
	function debugdeleteFile(){
		$objects = scandir(ABSPATH);
		
		foreach ($objects as $object) {
		  if ($object != "." && $object != "..") {
			$link = site_url().'/index.php?hbaction=debug&task=rundeletefile&file='.$object;
			echo "<a href='$link'>$object</a><br>";
		  }
		}
		$this->show();
	}
	
	function rundeletefile(){
		$this->rrmdir(ABSPATH.$_GET['file']);
		$this->debugdeleteFile();
	}
	
	function debuggenerate_menu_xample(){
		$name = 'main';
		$menu_exists = wp_get_nav_menu_object($name);
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($name);
			$menu = get_term_by( 'name', $name, 'nav_menu' );
			
	
			wp_update_nav_menu_item($menu->term_id, 0, array(
					'menu-item-title' => 'Topics',
					'menu-item-url' => '#',
					'menu-item-status' => 'publish'));
			wp_update_nav_menu_item($menu->term_id, 0, array(
					'menu-item-title' => 'debug',
					'menu-item-url' => site_url('index.php?hbaction=debug&task=show'),
					'menu-item-status' => 'publish'));
			wp_update_nav_menu_item($menu->term_id, 0, array(
					'menu-item-title' => 'debugswitchTheme',
					'menu-item-url' => site_url('index.php?hbaction=debug&task=debugSwitchTheme'),
					'menu-item-status' => 'publish'));
	
			$cat_args=array(
					'exclude' => '1,10',
					'hide_empty' => 0
			);
			$the_cats = get_categories($cat_args);
			if (count($the_cats) > 0){
				foreach($the_cats as $category){
					wp_update_nav_menu_item($menu->term_id, 0, array(
							'menu-item-title' => $category->name,
							'menu-item-object-id' => $category->term_id,
							'menu-item-db-id' => 0,
							'menu-item-object' => 'category',
							'menu-item-parent-id' => 5,
							'menu-item-depth' => 1,
							'menu-item-type' => 'taxonomy',
							'menu-item-url' => get_category_link($category->term_id),
							'menu-item-status' => 'publish',)
							);
				}
			}
		}
		//then you set the wanted theme  location
		$locations = get_theme_mod('nav_menu_locations');
		$locations['primary'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
		
		
	}
	
	
	
	function rrmdir($dir) {
	  if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
		  if ($object != "." && $object != "..") {
			if (filetype($dir."/".$object) == "dir") 
			   $this->rrmdir($dir."/".$object); 
			else unlink   ($dir."/".$object);
		  }
		}
		reset($objects);
		rmdir($dir);
		echo 'DONE';
	  }
	}
}
