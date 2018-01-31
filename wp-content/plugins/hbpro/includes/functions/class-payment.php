<?php
/**
 * @package 	Bookpro
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');

class HBActionPayment extends HBAction{
	
	/*
	 * Generate checkout page of payment gateway
	 */
	function process(){
		HBImporter::classes('order/route');
		
		HBHelper::check_nonce();				
		
		$payment_plugin = $this->input->getString('payment_plugin','');
		
		$element=substr($payment_plugin, 10);
		$order_id=$this->input->getInt('order_id');
		//Saving payment method
		$order = new HBOrderRoute();
		$order->load($order_id);
		$order->pay_method=$element[1];
		$order->store();		
		
		do_action('HB_order_process_checkout',$order);		
		
		$values['email']=$customer->email;
		$values['first_name']=$customer->firstname;
		$values['last_name']=$customer->lastname;
		$values['address']=$customer->address;
		$values['mobile']=$customer->mobile;
		$values['zip']=$customer->zip;
		$values['city']=$customer->city;
		$values['desc']=$order->order_number;
		$values['total']=$order->total;
		$values['order_number']=$order->order_number;
		
		//Trigger _preparePayment of payment gateway to generate checkout page
		//import core plugin
		HBImporter::corePaymentPlugin();
		$payment = new $payment_plugin();
		$payment->config = HBFactory::getConfig();
		$payment->returnUrl = site_url("index.php?jbaction=payment&task=postpayment&medthod=$payment_plugin&paction=display_message&order_id=$order_id");
		$payment->cancelUrl = site_url("index.php?jbaction=payment&task=postpayment&medthod=$payment_plugin&paction=cancel&order_id=$order_id");
		$payment->notifyUrl = site_url("index.php?jbaction=payment&task=postpayment&medthod=$payment_plugin&paction=process&order_id=$order_id");
		$payment->order = $order;
		$payment->_prePayment($values);
		
		
		return;
			
	}
	
	
	
	/**
	 * Render form
	 * @param string $element
	 */
	function getPaymentForm($element='')
	{
		$values = $this->input->getPost();
		$html = '';
		$text = "";
		$element = $this->input->getString( 'element' );
		$core_payment = HBList::getCorePaymentMethod();
		foreach ($core_payment as $plugin){
			if($element == $plugin->name){
				$params= get_option($plugin->name,'{}');
				$params = json_decode($params);
				echo $params->description;
				exit;
			}
		}
		$payment = new $element(HBFactory::getConfig());
		$html = $payment->_renderForm($values);
		echo $html;
		exit;
	}
	
	

	/**
	 * Process payment after return from 
	 */
	function postpayment()
	{
		//import core plugin
		HBImporter::corePaymentPlugin();
		
		do_action('HB_order_process_execute_before');
		
		$plugin = $app->input->getString('method');
		
		$payment = new $plugin();
		
		$payment->order = new HBOrder();
		$results = $payment->_postPayment();
		/// Send email
		
		if($results){
			if(!$results->sendemail){
				//send email
				$url = site_url().'index.php?jbaction=payment&task=urlsendmail&order_id='.$results->id;
				HBHelper::pingUrl($url);
			}
		}
		
		do_action('HB_order_process_execute_after',$results);
		
		//redirect to success page	
		wp_redirect('index.php?option=com_bookpro&view=postpayment&order_id='.$results->id);
		return;
	}
	
	private function sendMail($order_id){		
		HBImporter::helper('email');
		$mail=new EmailHelper();		
		return $mail->sendMail($order_id);		
	}
	
	//send mail via post curl
	public function urlSendmail(){
		$order_id = $this->input->getInt('order_id');
		$this->sendMail($order_id);
		exit;
	}
	
}