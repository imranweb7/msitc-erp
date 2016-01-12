<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ShippingMethods extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('cprojects');
		}elseif($this->user){
			$this->view_data['invoice_access'] = FALSE;
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "shippingmethods"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}

		$this->load->database();
		
	}	
	function index()
	{
		$this->view_data['shipping_methods'] = ShippingMethod::find('all', array('order' => 'name desc'));
		$this->content_view = 'shipping/methods/all';
	}

	function create()
	{
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);

			$shipping_method = ShippingMethod::create($_POST);
       		if(!$shipping_method){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_shipping_method_error'));
			}else {
				$this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_shipping_method_success'));
			}

			redirect('shippingmethods');
		}else{

			$this->view_data['shipping_methods'] = ShippingMethod::find('all', array('order' => 'name desc'));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_add_new_shipping_method_title');
			$this->view_data['form_action'] = 'shippingmethods/create';
			$this->content_view = 'shipping/methods/_form';
		}	
	}	
	function update($id = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			$id = $_POST['id'];
			$_POST = array_map('htmlspecialchars', $_POST);

			$shipping_method = ShippingMethod::find($id);
			$shipping_method->update_attributes($_POST);

       		if(!$shipping_method){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_shipping_method_error'));
			}else{
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_shipping_method_success'));
			}

			redirect('shippingmethods/view/'.$id);
		}else
		{
			$this->view_data['shipping_method'] = ShippingMethod::find($id);
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_shipping_method_title');
			$this->view_data['form_action'] = 'shippingmethods/update';
			$this->content_view = 'shipping/methods/_form';
		}	
	}
	function delete($id = FALSE)
	{
		$shipping_method = ShippingMethod::find($id);
		$shipping_method->delete();

		$this->content_view = 'shipping/methods/all';
		if(!$shipping_method){
			$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_shipping_method_error'));
		}else{
			$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_shipping_method_success'));
		}

		if(isset($view)){
			redirect('shippingmethods/view/'.$id);
		}else{
			redirect('shippingmethods');
		}
	}
	function view($id = FALSE)
	{ 
		$this->view_data['submenu'] = array();
		$this->view_data['shipping_method'] = ShippingMethod::find($id);

		$this->content_view = 'shipping/methods/view';
	}
}