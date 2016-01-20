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
				$this->load->library('userlib');
				$this->load->library('parser');
				$this->load->helper(array('dompdf', 'file'));

				$module_estimate = Module::find_by_link('estimates');

				$admins = $this->userlib->getAdmins($module_estimate->id);
				$admin_list = array_keys($admins);

				$parse_data = array(
					'client_contact' => $estimate->company->client->firstname.' '.$estimate->company->client->lastname,
					'client_company' => $estimate->company->name,
					'estimate_id' => $core_settings->estimate_prefix.$estimate->reference,
					'estimate_link' => base_url().'estimates/view/32'.$estimate->id,
					'company' => $core_settings->company,
					'logo' => '<img src="'.base_url().''.$core_settings->logo.'" alt="'.$core_settings->company.'"/>',
					'invoice_logo' => '<img src="'.base_url().''.$core_settings->invoice_logo.'" alt="'.$core_settings->company.'"/>'
				);

				$subject = $this->parser->parse_string($core_settings->estimate_mail_subject, $parse_data);
				$this->email->from($core_settings->email, $core_settings->company);

				$this->email->to($admin_list);
				$this->email->subject($subject);

				$email_estimate = read_file('./application/views/'.$core_settings->template.'/templates/email_admin_estimate.html');
				$message = $this->parser->parse_string($email_estimate, $parse_data);
				$this->email->message($message);

				if($this->email->send()){
					log_message('error', 'Estimate #'.$core_settings->estimate_prefix.$estimate->reference.' has been send to admins who has access to estimate');
				}
				else{
					log_message('error', 'ERROR: Estimate #'.$core_settings->estimate_prefix.$estimate->reference.' has not been send to admins who has access to estimate. Please check your servers email settings.');
				}

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

	function sendestimate($id = FALSE){
		$this->load->helper(array('dompdf', 'file'));
		$this->load->library('parser');
		$data["estimate"] = Invoice::find($id);
		//check if client contact has permissions for estimates and grant if not
		if(isset($data["estimate"]->company->client->id)){
			$access = explode(",", $data["estimate"]->company->client->access);
			if(!in_array("107", $access)){
				$client_estimate_permission = Client::find_by_id($data["estimate"]->company->client->id);
				$client_estimate_permission->access = $client_estimate_permission->access.",107";
				$client_estimate_permission->save();
			}

		}
		$data["estimate"]->estimate_sent = date("Y-m-d");
		$data["estimate"]->estimate_status = "Sent";

		$data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));
		$data["core_settings"] = Setting::first();
		$due_date = date($data["core_settings"]->date_format, human_to_unix($data["estimate"]->due_date.' 00:00:00'));
		//Set parse values
		$parse_data = array(
			'client_contact' => $data["estimate"]->company->client->firstname.' '.$data["estimate"]->company->client->lastname,
			'client_company' => $data["estimate"]->company->name,
			'due_date' => $due_date,
			'estimate_id' => $data["core_settings"]->estimate_prefix.$data["estimate"]->reference,
			'client_link' => $data["core_settings"]->domain,
			'company' => $data["core_settings"]->company,
			'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
			'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>'
		);
		// Generate PDF
		$html = $this->load->view($data["core_settings"]->template. '/' .$data["core_settings"]->estimate_pdf_template, $data, true);
		$html = $this->parser->parse_string($html, $parse_data);
		$filename = $this->lang->line('application_estimate').'_'.$data["estimate"]->reference;
		pdf_create($html, $filename, FALSE);
		//email
		$subject = $this->parser->parse_string($data["core_settings"]->estimate_mail_subject, $parse_data);
		$this->email->from($data["core_settings"]->email, $data["core_settings"]->company);
		if(!isset($data["estimate"]->company->client->email)){
			$this->session->set_flashdata('message', 'error:This client company has no primary contact! Just add a primary contact.');
			redirect('estimates/view/'.$id);
		}
		$this->email->to($data["estimate"]->company->client->email);
		$this->email->subject($subject);
		$this->email->attach("files/temp/".$filename.".pdf");



		$email_estimate = read_file('./application/views/'.$data["core_settings"]->template.'/templates/email_estimate.html');
		$message = $this->parser->parse_string($email_estimate, $parse_data);
		$this->email->message($message);
		if($this->email->send()){$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_send_estimate_success'));
			$data["estimate"]->update_attributes(array('status' => 'Sent', 'sent_date' => date("Y-m-d")));
			log_message('error', 'Estimate #'.$data["core_settings"]->estimate_prefix.$data["estimate"]->reference.' has been send to '.$data["estimate"]->company->client->email);
		}
		else{$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_send_estimate_error'));
			log_message('error', 'ERROR: Estimate #'.$data["core_settings"]->estimate_prefix.$data["estimate"]->reference.' has not been send to '.$data["estimate"]->company->client->email.'. Please check your servers email settings.');
		}
		unlink("files/temp/".$filename.".pdf");
		redirect('estimates/view/'.$id);
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