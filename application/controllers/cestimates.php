<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cEstimates extends MY_Controller {

	private $invoice_shipment_type = 'Shipment';
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "cestimates"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}elseif($this->user){
				redirect('estimates');
		}else{

			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all') => 'cestimates',
				 		);

		$this->load->library('projectlib');
		$this->view_data['projectlib'] = $this->projectlib;
		
	}	
	function index()
	{
		$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate != ? and company_id = ? and estimate_status != ?', 0, $this->client->company_id, 'Open')));

		$this->content_view = 'estimates/client_views/all';
	}
	function filter($condition = FALSE)
	{

		switch ($condition) {
			case 'open':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Open', 0, $this->client->company_id)));
				break;
			case 'sent':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Sent', 0, $this->client->company_id)));
				break;
			case 'accepted':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Accepted', 0, $this->client->company_id)));
				break;
			case 'declined':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Declined', 0, $this->client->company_id)));
				break;
			case 'invoiced':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Invoiced', 0, $this->client->company_id)));
				break;
			default:
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate != ? and company_id = ?', 0, $this->client->company_id)));
				break;
		}
		
		$this->content_view = 'estimates/client_views/all';
	}
	
		
	function accept($id = FALSE)
	{	
		$this->load->helper('notification');
		$data["core_settings"] = Setting::first();
			
			$this->view_data['estimate'] = Invoice::find_by_id($id);
			$this->view_data['estimate']->estimate_status = "Accepted";
			$this->view_data['estimate']->estimate_accepted_date = date("Y-m-d");

			$this->view_data['estimate']->save();

			send_notification($data["core_settings"]->email, $data["core_settings"]->estimate_prefix.$this->view_data['estimate']->reference.' - '.$this->lang->line('application_Accepted'), $this->lang->line('messages_estimate_accepted'));

			redirect('cestimates/view/'.$id);
			
	}	
	function decline($id = FALSE)
	{	
		$this->load->helper('notification');
		$data["core_settings"] = Setting::first();
		if($_POST){

			$this->view_data['estimate'] = Invoice::find_by_id($_POST['invoice_id']);
			$this->view_data['estimate']->estimate_status = "Declined";
			$this->view_data['estimate']->save();

			send_notification($data["core_settings"]->email, $data["core_settings"]->estimate_prefix.$this->view_data['estimate']->reference.' - '.$this->lang->line('application_Declined'), $_POST['reason']);

			redirect('cestimates/view/'.$_POST['invoice_id']);
		}else{
			$this->view_data['estimate'] = Invoice::find($id);

			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_Declined');
			$this->view_data['form_action'] = 'cestimates/decline';
			$this->content_view = 'estimates/client_views/_decline';
		}
		
	}
	
	function view($id = FALSE)
	{
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'cestimates',
				 		);	
		$this->view_data['estimate'] = Invoice::find($id);
		if($this->view_data['estimate']->company_id != $this->client->company->id){ redirect('cestimates');}
		$data["core_settings"] = Setting::first();
		$estimate = $this->view_data['estimate'];
		$this->view_data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));

		$this->projectlib->updateInvoiceTotal($estimate);

		$this->view_data['estimate_addresses'] = InvoiceHasAddress::find('all',array('conditions' => array('invoice_id=?',$id)));

		$this->content_view = 'estimates/client_views/view';
	}

	function createShippingEstimate()
	{
		$this->load->helper('notification');
		$this->view_data['submenu'] = array();

		if($_POST) {
			unset($_POST['send']);
			unset($_POST['files']);

			$_POST['shipping_lebel'] = '';

			$config['upload_path'] = './files/media';
			$config['encrypt_name'] = TRUE;
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload())
			{
				$data = array('upload_data' => $this->upload->data());
				$_POST['shipping_lebel'] = $data['upload_data']['file_name'];
			}

			unset($_POST['userfile']);
			unset($_POST['dummy']);

			$_POST = array_map('htmlspecialchars', $_POST);

			$shipping_address = array(
				'shipping_name'=>$_POST['shipping_name'],
				'shipping_company'=>$_POST['shipping_company'],
				'shipping_address'=>$_POST['shipping_address'],
				'shipping_city'=>$_POST['shipping_city'],
				'shipping_state'=>$_POST['shipping_state'],
				'shipping_zip'=>$_POST['shipping_zip'],
				'shipping_country'=>$_POST['shipping_country'],
				'shipping_phone'=>$_POST['shipping_phone'],
				'shipping_email'=>$_POST['shipping_email'],
				'shipping_website'=>$_POST['shipping_website'],
			);

			unset($_POST['shipping_name']);
			unset($_POST['shipping_company']);
			unset($_POST['shipping_address']);
			unset($_POST['shipping_city']);
			unset($_POST['shipping_state']);
			unset($_POST['shipping_zip']);
			unset($_POST['shipping_country']);
			unset($_POST['shipping_phone']);
			unset($_POST['shipping_email']);
			unset($_POST['shipping_website']);

			$core_settings = Setting::first();
			$_POST['reference'] = $core_settings->invoice_reference;
			$_POST['project_id'] = '0';
			$_POST['company_id'] = $this->client->company->id;
			$_POST['status'] = 'Sent';
			$_POST['estimate_status'] = 'Sent';
			$_POST['issue_date'] = date('Y-m-d');
			$_POST['due_date'] = date('Y-m-d', strtotime('+7 days'));
			$_POST['currency'] = $core_settings->currency;
			$_POST['terms'] = $core_settings->invoice_terms;
			$_POST['invoice_type'] = $this->invoice_shipment_type;
			$_POST['estimate'] = 1;

			$estimate = Invoice::create($_POST);
			$new_estimate_reference = $_POST['reference']+1;

			$estimate_id = $estimate->id;
			$this->projectlib->addInvoiceAddress($estimate_id, true, $shipping_address);

			$estimate_reference = Setting::first();
			$estimate_reference->update_attributes(array('invoice_reference' => $new_estimate_reference));

			if(!$estimate){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_estimate_error'));
			}
			else{
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_estimate_success'));
			}

			redirect('cestimates');
		}else{
			$this->load->library('geolib');
			$this->view_data['geolib'] = $this->geolib;
			$this->view_data['shipping_methods'] = ShippingMethod::find('all', array('order' => 'name desc'));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_shipping_estimate');
			$this->view_data['form_action'] = 'cestimates/createShippingEstimate';
			$this->content_view = 'estimates/client_views/_cestimate';
		}
	}

	function download($id = FALSE){

		$this->load->helper('download');
		$estimate = Invoice::find($id);

		if(!$estimate){
			redirect('cestimates/view/'.$id);
		}

		$data = file_get_contents('./files/media/'.$estimate->shipping_lebel);

		$type = array_reverse(explode('.', $estimate->shipping_lebel));
		$type = strtolower($type[0]);

		$name = 'shipping_label_'.$estimate->reference.'.'.$type;
		force_download($name, $data);
	}


	function preview($id = FALSE){
     $this->load->helper(array('dompdf', 'file')); 
     $this->load->library('parser');
     $data["estimate"] = Invoice::find($id); 
     $data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));
     $data["core_settings"] = Setting::first();
   
     $due_date = date($data["core_settings"]->date_format, human_to_unix($data["estimate"]->due_date.' 00:00:00'));  
     $parse_data = array(
            					'due_date' => $due_date,
            					'estimate_id' => $data["estimate"]->reference,
            					'client_link' => $data["core_settings"]->domain,
            					'company' => $data["core_settings"]->company,
            					);
  	$html = $this->load->view($data["core_settings"]->template. '/' .$data["core_settings"]->estimate_pdf_template, $data, true); 
  	$html = $this->parser->parse_string($html, $parse_data);
     
    $filename = $this->lang->line('application_estimate').'_'.$data["core_settings"]->estimate_prefix.$data["estimate"]->reference;
     pdf_create($html, $filename, TRUE);
	}

	


	
}