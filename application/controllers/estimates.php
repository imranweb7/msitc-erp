<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estimates extends MY_Controller {

	private $invoice_shipment_type = 'Shipment';

	const ITEM_UPLOAD_PATH = './files/media/';
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('cprojects');
		}elseif($this->user){
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "estimates"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all') => 'estimates',
				 		$this->lang->line('application_open') => 'estimates/filter/open',
				 		$this->lang->line('application_Sent') => 'estimates/filter/sent',
				 		$this->lang->line('application_Accepted') => 'estimates/filter/accepted',
				 		$this->lang->line('application_Invoiced') => 'estimates/filter/invoiced',

				 		);
		$this->load->library('projectlib');
		$this->view_data['projectlib'] = $this->projectlib;
	}	
	function index()
	{
		$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate != ?', 0)));
		$days_in_this_month = days_in_month(date('m'), date('Y'));
		$lastday_in_month =  strtotime(date('Y')."-".date('m')."-".$days_in_this_month);
		$firstday_in_month =  strtotime(date('Y')."-".date('m')."-01");

		$this->view_data['estimates_paid_this_month'] = Invoice::count(array('conditions' => 'UNIX_TIMESTAMP(`paid_date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`paid_date`) >= '.$firstday_in_month.' AND estimate != 0'));
		$this->view_data['estimates_due_this_month'] = Invoice::count(array('conditions' => 'UNIX_TIMESTAMP(`due_date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`due_date`) >= '.$firstday_in_month.' AND estimate != 0'));
		
		//statistic
		$now = time();
		$beginning_of_week = strtotime('last Monday', $now); // BEGINNING of the week
		$end_of_week = strtotime('next Sunday', $now) + 86400; // END of the last day of the week
		$this->view_data['estimates_due_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`due_date`, "%w") AS "date_day", DATE_FORMAT(`due_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`due_date`) >= "'.$beginning_of_week.'" AND UNIX_TIMESTAMP(`due_date`) <= "'.$end_of_week.'" AND estimate != 0');
		$this->view_data['estimates_paid_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`paid_date`, "%w") AS "date_day", DATE_FORMAT(`paid_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`paid_date`) >= "'.$beginning_of_week.'" AND UNIX_TIMESTAMP(`paid_date`) <= "'.$end_of_week.'" AND estimate != 0');


		$this->content_view = 'estimates/all';
	}
	function filter($condition = FALSE)
	{
		$days_in_this_month = days_in_month(date('m'), date('Y'));
		$lastday_in_month =  date('Y')."-".date('m')."-".$days_in_this_month;
		$firstday_in_month =  date('Y')."-".date('m')."-01";
		$this->view_data['estimates_paid_this_month'] = Invoice::count(array('conditions' => 'paid_date <= '.$lastday_in_month.' and paid_date >= '.$firstday_in_month.' AND estimate != 0'));
		$this->view_data['estimates_due_this_month'] = Invoice::count(array('conditions' => 'due_date <= '.$lastday_in_month.' and due_date >= '.$firstday_in_month.' AND estimate != 0'));

		switch ($condition) {
			case 'open':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ?', 'Open', 0)));
				break;
			case 'sent':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ?', 'Sent', 0)));
				break;
			case 'accepted':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ?', 'Accepted', 0)));
				break;
			case 'declined':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ?', 'Declined', 0)));
				break;
			case 'invoiced':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ?', 'Invoiced', 0)));
				break;
			default:
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate != ?', 0)));
				break;
		}
		
		$this->content_view = 'estimates/all';
	}
	function create()
	{	
		if($_POST){
			unset($_POST['send']);
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);
			$_POST['estimate'] = 1;
			$_POST['estimate_status'] = "Open";
			$estimate = Invoice::create($_POST);
			$new_estimate_reference = $_POST['reference']+1;
			
			$estimate_reference = Setting::first();
			$estimate_reference->update_attributes(array('invoice_reference' => $new_estimate_reference));
       		if(!$estimate){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_estimate_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_estimate_success'));}
			redirect('estimates');
		}else
		{
			$this->view_data['estimates'] = Invoice::all();
			$this->view_data['next_reference'] = Invoice::last();
			$this->view_data['projects'] = Project::all();
			$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_estimate');
			$this->view_data['form_action'] = 'estimates/create';
			$this->content_view = 'estimates/_estimate';
		}	
	}	
	function update($id = FALSE, $getview = FALSE)
	{
		$estimate = Invoice::find($id);
		if($estimate->invoice_type == $this->invoice_shipment_type){
			$this->updateShippingEstimate($id, $getview);
		}else{
			$this->updateRegularEstimate($id, $getview);
		}
	}

	function updateRegularEstimate($id = FALSE, $getview = FALSE){
		if($_POST){
			unset($_POST['send']);
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);
			$id = $_POST['id'];
			$view = FALSE;
			if(isset($_POST['view'])){$view = $_POST['view']; }
			unset($_POST['view']);
			if($_POST['status'] == "Paid"){ $_POST['paid_date'] = date('Y-m-d', time());}
			$estimate = Invoice::find($id);
			$estimate->update_attributes($_POST);

			if(!$estimate){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_estimate_error'));}
			else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_estimate_success'));}
			redirect('estimates/view/'.$id);

		}else
		{
			$this->view_data['estimate'] = Invoice::find($id);
			$this->view_data['projects'] = Project::all();
			$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			if($getview == "view"){$this->view_data['view'] = "true";}
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_estimate');
			$this->view_data['form_action'] = 'estimates/update';
			$this->content_view = 'estimates/_estimate';
		}
	}

	function updateShippingEstimate($id = FALSE, $getview = FALSE){
		$this->load->helper('notification');
		$this->view_data['submenu'] = array();

		if($_POST) {
			$estimate = Invoice::find($id);

			unset($_POST['send']);
			unset($_POST['files']);

			$_POST['shipping_lebel'] = $estimate->shipping_lebel;

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

			$estimate->update_attributes($_POST);

			$estimate_id = $estimate->id;
			$this->projectlib->updateInvoiceAddress($estimate_id, true, $shipping_address);

			if(!$estimate){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_estimate_error'));
			}
			else{
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_estimate_success'));
			}

			redirect('estimates/view/'.$id);
		}else{
			$estimate_address = InvoiceHasAddress::find('all',array('conditions' => array('invoice_id=?',$id)));

			if(count($estimate_address)){
				foreach($estimate_address as $address) {
					$this->view_data['address'] = $address;
				}
			}

			$this->view_data['estimate'] = Invoice::find($id);
			$this->load->library('geolib');
			$this->view_data['geolib'] = $this->geolib;
			$this->view_data['shipping_methods'] = ShippingMethod::find('all', array('order' => 'name desc'));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_shipping_estimate');
			$this->view_data['form_action'] = 'estimates/update/'.$id.'/view';
			$this->content_view = 'estimates/_edit_estimate';
		}
	}
	
	function view($id = FALSE)
	{

		
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'estimates',
				 		);	
		$this->view_data['estimate'] = Invoice::find($id);
		$data["core_settings"] = Setting::first();
		$estimate = $this->view_data['estimate'];
		$this->view_data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));

		$this->projectlib->updateInvoiceTotal($estimate);

		$this->view_data['estimate_addresses'] = InvoiceHasAddress::find('all',array('conditions' => array('invoice_id=?',$id)));

		$this->content_view = 'estimates/view';
	}

	function estimateToInvoice($id = FALSE, $getview = FALSE)
	{	

			$estimate = Invoice::find($id);
			$estimate->estimate = 2;
			$estimate->estimate_status = "Invoiced";
			$estimate->save();
			
       		if(!$estimate){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_invoice_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_invoice_success'));}
			redirect('invoices/view/'.$id);
			
		
	}

	function download($id = FALSE){

		$this->load->helper('download');
		$estimate = Invoice::find($id);

		if(!$estimate){
			redirect('estimates/view/'.$id);
		}

		$data = file_get_contents('./files/media/'.$estimate->shipping_lebel);

		$type = array_reverse(explode('.', $estimate->shipping_lebel));
		$type = strtolower($type[0]);

		$name = 'shipping_label_'.$estimate->reference.'.'.$type;
		force_download($name, $data);
	}
	

	function delete($id = FALSE)
	{	
		$estimate = Invoice::find($id);
		$estimate->delete();
		$this->content_view = 'estimates/all';
		if(!$estimate){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_estimate_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_estimate_success'));}
			redirect('estimates');
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
            					'estimate_id' => $data["core_settings"]->estimate_prefix.$data["estimate"]->reference,
            					'client_link' => $data["core_settings"]->domain,
            					'company' => $data["core_settings"]->company,
            					);
  	$html = $this->load->view($data["core_settings"]->template. '/' .$data["core_settings"]->estimate_pdf_template, $data, true); 
  	$html = $this->parser->parse_string($html, $parse_data);
     
     $filename = $this->lang->line('application_estimate').'_'.$data["core_settings"]->estimate_prefix.$data["estimate"]->reference;
     pdf_create($html, $filename, TRUE);
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
	function item($id = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);

			$id = $_POST['invoice_id'];

			$invoice = Invoice::find($id);

			$item_type = 'regular';
			if($invoice->invoice_type == $this->invoice_shipment_type){
				$item_type = 'shipping';
			}

			$is_new_item = false;
			if(isset($_POST['new_item']) && htmlspecialchars($_POST['new_item']) == "1") {
				$is_new_item = true;

				$filename = $savename = $type = '';

				if($invoice->invoice_type != $this->invoice_shipment_type) {
					$config['upload_path'] = self::ITEM_UPLOAD_PATH;
					$config['encrypt_name'] = TRUE;
					$config['allowed_types'] = '*';

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload()) {
						$error = $this->upload->display_errors('', ' ');
						$this->session->set_flashdata('message', 'error:' . $error);
						redirect('estimates/view/' . $id);
					} else {
						$data = array('upload_data' => $this->upload->data());

						$filename = $data['upload_data']['orig_name'];
						$savename = $data['upload_data']['file_name'];
						$type = $data['upload_data']['file_type'];
					}
				}

				unset($_POST['send']);
				unset($_POST['userfile']);
				unset($_POST['new_item']);
				unset($_POST['file-name']);
				unset($_POST['files']);

				$item_name = $item_description = $_POST['name'];

				$cost = $original_cost = $_POST['value'];
				$sku = $_POST['sku'];
				$inactive = $_POST['inactive'];

				$item_data = array(
					'photo' => $savename,
					'photo_type' => $type,
					'photo_original_name' => $filename,
					'type' => $item_type,
					'name' => $item_name,
					'value' => $original_cost,
					'description' => $item_description,
					'sku' => $sku,
					'inactive' => $inactive
				);

				$item = Item::create($item_data);

				$item_id = $_POST['item_id'] = $item->id;


			}else{
				unset($_POST['send']);
				unset($_POST['userfile']);
				unset($_POST['file-name']);
				unset($_POST['files']);
				unset($_POST['new_item']);
				unset($_POST['name']);
				unset($_POST['sku']);
				unset($_POST['inactive']);

				$_POST = array_map('htmlspecialchars', $_POST);

				if($_POST['item_id'] == "-" || $_POST['item_id'] == "0"){
					$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_add_item_error'));
					redirect('estimates/view/'.$id);
				}

				$item_id = $_POST['item_id'];

				$item_details = Item::find($item_id);
				$item_name = $item_details->name;
				$item_description = $item_details->description;
				$cost = (empty($_POST['value'])) ? $item_details->value : $_POST['value'];
				$original_cost = $item_details->value;
				$savename = $item_details->photo;
				$type = $item_details->photo_type;
				$filename = $item_details->photo_original_name;
				$sku = $item_details->sku;
				$item_type = $item_details->type;
				$inactive = $item_details->inactive;
			}

			$estimate_item_exist = InvoiceHasItem::count(array('conditions' => array('invoice_id=? AND item_id=?',$id, $item_id)));
			if($estimate_item_exist){
				$estimate_item = false;

				$error = $this->lang->line('messages_project_save_item_exist');
				$this->session->set_flashdata('message', 'error:'.$error);
				redirect('estimates/view/'.$id);

			}else{
				$invoice_item_data = array(
					'invoice_id' => $id,
					'item_id' => $item_id,
					'project_item_id' => '0',
					'photo' => $savename,
					'photo_type' => $type,
					'photo_original_name' => $filename,
					'name' => $item_name,
					'amount' => $_POST['amount'],
					'description' => $item_description,
					'sku' => $sku,
					'value' => $cost,
					'type' => $item_type,
					'original_cost' => $original_cost,
					'shipping_item' => ($invoice->invoice_type == 'Shipment') ? '1' : '0'
				);

				$estimate_item = InvoiceHasItem::create($invoice_item_data);
			}


       		if(!$estimate_item){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_add_item_error'));
			}
       		else{
				$this->projectlib->updateInvoiceTotal($invoice);
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_add_item_success'));
			}
			redirect('estimates/view/'.$_POST['invoice_id']);
			
		}else
		{
			$this->view_data['estimate'] = Invoice::find($id);
			$this->view_data['estimate_type'] = $this->view_data['estimate']->invoice_type;
			$this->view_data['items'] = Item::find('all',array('conditions' => array('inactive=?','0')));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_add_item');
			$this->view_data['form_action'] = 'estimates/item';
			$this->content_view = 'estimates/_item';
		}	
	}	
	function item_update($id = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);
			$item = InvoiceHasItem::find($_POST['id']);

			$item = $item->update_attributes($_POST);
       		if(!$item){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_item_error'));
			}
       		else{
				$invoice = Invoice::find($item->invoice_id);
				$this->projectlib->updateInvoiceTotal($invoice);
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_item_success'));
			}
			redirect('estimates/view/'.$_POST['invoice_id']);
			
		}else
		{
			$this->view_data['estimate_has_items'] = InvoiceHasItem::find($id);
			$invoice = Invoice::find($this->view_data['estimate_has_items']->invoice_id);
			$this->view_data['estimate_type'] = $invoice->invoice_type;
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_item');
			$this->view_data['form_action'] = 'estimates/item_update';
			$this->content_view = 'estimates/_item';
		}	
	}	
	function item_delete($id = FALSE, $estimate_id = FALSE)
	{	
		$item = InvoiceHasItem::find($id);
		$invoice = Invoice::find($item->invoice_id);
		$item->delete();
		$this->content_view = 'estimates/view';
		if(!$item){
			$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_item_error'));
		}else{
			$this->projectlib->updateInvoiceTotal($invoice);
			$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_item_success'));
		}
		redirect('estimates/view/'.$estimate_id);
	}	
	
}