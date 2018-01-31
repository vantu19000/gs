<?php
/**
 *View display page HB_setting
 */

class HBAdminViewSetting extends HBAdminView {
	protected $form;
	public function display($tpl = null) {
		
		HBImporter::libraries ( 'form' );
		$this->form = new HBForm ( 'setting' );
		$this->input = HBFactory::getInput();
		$layout = $this->getLayout();
		wp_enqueue_script ( 'jquery-validate', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js' );
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-tabs' );
		$this->activeTab ();
		
		switch ($layout){
			case 'checkout':				
				$this->plugins = HBList::getPaymentAvailPlugin(false,false);
				//default is cash payment
				$this->gateway = $this->input->get('gateway','jbpayment_cash');
				$instance = get_option ( $this->gateway, array () );
				$instance = json_decode ( $instance );
				$this->item = ( array ) $instance;
				//loading setting form if it is not cash payment
				foreach ($this->plugins as $plugin){
					if($plugin->name == $this->gateway){
						$this->form->loadFile ("{$plugin->file}{$this->gateway}.xml", true, '//config' );
					}					
				}
				
				// bind data to form
				$this->form->bind ( $this->item );
				
				break;
			default:
				$instance = get_option ( 'hb_params', array () );
				$instance = json_decode ( $instance );
// 				debug($instance);
				$this->item = ( array ) $instance;
				
				$this->form->loadFile ( HB_PATH . 'includes/admin/setting/config.xml', true, '//config' );
				// bind data to form
				$this->form->bind ( $this->item );
				break;
		}
		
		
		return parent::display ( $tpl );
	}
	
	
	
	public function activeTab() {
		$input = HBFactory::getInput();
		$active_tab = $input->getString('layout','');
		?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=hb_setting" class="nav-tab <?php echo $active_tab == '' ? 'nav-tab-active' : ''; ?>"><?php echo __('Setting','hb')?></a>
			<a href="?page=hb_setting&layout=notify" class="nav-tab <?php echo $active_tab == 'notify' ? 'nav-tab-active' : ''; ?>"><?php echo __('Notify','hb')?></a> 
			<a href="?page=hb_setting&layout=checkout" class="nav-tab <?php echo $active_tab == 'checkout' ? 'nav-tab-active' : ''; ?>"><?php echo __('Checkout','hb')?></a>
		</h2>
		<?php
			}
	}

$view = new HBAdminViewSetting ();
$view->display ();
?>
