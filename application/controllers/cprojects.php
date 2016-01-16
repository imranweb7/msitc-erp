<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cProjects extends MY_Controller {

	private $invoice_shipment_type = 'Shipment';
               
	function __construct()
	{
		parent::__construct();
		
		$access = FALSE;
		if($this->client){	
			$this->view_data['invoice_access'] = FALSE;
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "cinvoices"){ $this->view_data['invoice_access'] = TRUE;}
				if($value->link == "cprojects"){ $access = TRUE;}
			}
			if(!$access && !empty($this->view_data['menu'][0])){
				redirect($this->view_data['menu'][0]->link);
			}elseif(empty($this->view_data['menu'][0])){
				$this->view_data['error'] = "true";
				$this->session->set_flashdata('message', 'error: You have no access to any modules!');
				redirect('login');
			}
		}elseif($this->user){
				redirect('projects');
		}else{
			redirect('login');
		}


		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_my_projects') => 'cprojects'
				 		);	
		function submenu($id){ return array(
								$this->lang->line('application_back') => 'cprojects',
								$this->lang->line('application_overview') => 'cprojects/view/'.$id,
						 		$this->lang->line('application_media') => 'cprojects/media/'.$id,
						 		);
						}

		$this->load->library('projectlib');

		$this->view_data['projectlib'] = $this->projectlib;
	}	
	function index()
	{
		$this->view_data['project'] = Project::find('all',array('conditions' => array('company_id=?',$this->client->company->id)));
		$this->content_view = 'projects/client_views/all';
	}

	function order($id = FALSE, $condition = FALSE, $order_id = FALSE)
	{
		$this->load->helper('notification');
		$this->view_data['submenu'] = array(
			$this->lang->line('application_back') => 'cprojects',
			$this->lang->line('application_overview') => 'cprojects/view/'.$id,
			$this->lang->line('application_tasks') => 'cprojects/tasks/'.$id,
			$this->lang->line('application_media') => 'cprojects/media/'.$id,
		);
		switch ($condition) {
			case 'create':
				if(!isset($_POST['items']) || empty($_POST['items'])){
					$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_project_make_order_item_empty'));
					redirect('cprojects/view/'.$id);
				}

				$items = $_POST['items'];

				unset($_POST['userfile']);
				unset($_POST['items']);
				unset($_POST['send']);
				unset($_POST['files']);

				$core_settings = Setting::first();
				$_POST['reference'] = $core_settings->invoice_reference;
				$_POST['company_id'] = $this->client->company->id;
				$_POST['project_id'] = $id;
				$_POST['status'] = 'Open';
				$_POST['issue_date'] = date('Y-m-d');
				$_POST['due_date'] = date('Y-m-d', strtotime('+1 day'));
				$_POST['currency'] = $core_settings->currency;
				$_POST['terms'] = $core_settings->invoice_terms;

				$invoice = Invoice::create($_POST);
				$new_invoice_reference = $_POST['reference']+1;

				$invoice_reference = Setting::first();
				$invoice_reference->update_attributes(array('invoice_reference' => $new_invoice_reference));

				$invoice_id = $invoice->id;
				foreach($items as $k=>$item){
					$project_item = ProjectHasItem::find($item);

					$invoice_item_data = array(
						'invoice_id' => $invoice_id,
						'item_id' => $project_item->item_id,
						'project_item_id' => $project_item->id,
						'photo' => $project_item->photo,
						'photo_type' =>$project_item->photo_type,
						'photo_original_name' => $project_item->photo_original_name,
						'name' => $project_item->name,
						'amount' => $project_item->quantity,
						'description' => $project_item->description,
						'sku' => $project_item->sku,
						'value' => $project_item->cost,
						'original_cost' => $project_item->original_cost,
					);

					$item_add = InvoiceHasItem::create($invoice_item_data);

					$project_item->payment_status = 'invoiced';
					$project_item->save();
				}

				$this->projectlib->updateInvoiceTotal($invoice);
				$this->projectlib->sendInvoice($invoice_id, false);
				$this->projectlib->addInvoiceAddress($invoice_id);

				if(!$invoice){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_invoice_error'));}
				else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_invoice_success'));}

				echo $invoice_id;die();

				break;

			default:
				$this->view_data['project'] = Project::find($id);
				$this->content_view = 'cprojects/view/'.$id;
				break;
		}
	}

	function planOrder($id = FALSE, $condition = FALSE, $plan_id = FALSE)
	{
		$this->load->helper('notification');
		$this->view_data['submenu'] = array(
			$this->lang->line('application_back') => 'cprojects',
			$this->lang->line('application_overview') => 'cprojects/view/'.$id,
			$this->lang->line('application_tasks') => 'cprojects/tasks/'.$id,
			$this->lang->line('application_media') => 'cprojects/media/'.$id,
		);
		switch ($condition) {
			case 'create':
				$plan = ProjectHasItem::find($plan_id);
				$current_inventory = $plan->shipping_available_inventory;

				if($_POST){
					if (!isset($plan_id) || empty($plan_id)) {
						$this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_project_make_plan_item_empty'));
						redirect('cprojects/view/' . $id);
					}

					if (!$current_inventory) {
						$this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_project_make_plan_inventory_empty'));
						redirect('cprojects/view/' . $id);
					}

					$quantity = $_POST['amount'];

					$current_inventory_available = $current_inventory - $quantity;

					if (!$quantity) {
						$this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_project_make_plan_qty_empty'));
						redirect('cprojects/view/' . $id);
					}

					if ($current_inventory_available < 0) {
						$this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_project_make_plan_qty_empty'));
						redirect('cprojects/view/' . $id);
					}


					unset($_POST['send']);
					unset($_POST['files']);
					unset($_POST['amount']);

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
					$_POST['project_id'] = $id;
					$_POST['company_id'] = $this->client->company->id;
					$_POST['status'] = 'Sent';
					$_POST['issue_date'] = date('Y-m-d');
					$_POST['due_date'] = date('Y-m-d', strtotime('+1 day'));
					$_POST['currency'] = $core_settings->currency;
					$_POST['terms'] = $core_settings->invoice_terms;
					$_POST['invoice_type'] = $this->invoice_shipment_type;

					$invoice = Invoice::create($_POST);
					$new_invoice_reference = $_POST['reference']+1;

					$invoice_id = $invoice->id;
					$this->projectlib->addInvoiceAddress($invoice_id, true, $shipping_address);

					$invoice_reference = Setting::first();
					$invoice_reference->update_attributes(array('invoice_reference' => $new_invoice_reference));

					$invoice_item_data = array(
						'invoice_id' => $invoice_id,
						'item_id' => $plan->item_id,
						'project_item_id' => $plan->id,
						'photo' => $plan->photo,
						'photo_type' => $plan->photo_type,
						'photo_original_name' => $plan->photo_original_name,
						'name' => $plan->name,
						'amount' => $quantity,
						'type' => $plan->type,
						'description' => $plan->description,
						'sku' => $plan->sku,
						'value' => $plan->cost,
						'original_cost' => $plan->original_cost,
						'shipping_item' => '1',
						'shipping_method' => $plan->shipping_method,
						'shipping_box_size_length' => $plan->shipping_box_size_length,
						'shipping_box_size_width' => $plan->shipping_box_size_width,
						'shipping_box_size_height' => $plan->shipping_box_size_height,
						'shipping_box_size_weight' => $plan->shipping_box_size_weight,
						'shipping_pcs_in_carton' => $plan->shipping_pcs_in_carton
					);

					$item_add = InvoiceHasItem::create($invoice_item_data);

					$plan->shipping_available_inventory = $current_inventory_available;
					if(!$current_inventory_available){
						$plan->payment_status = 'invoiced';
					}
					$plan->save();

					$this->projectlib->updateInvoiceTotal($invoice);
					$this->projectlib->sendInvoice($invoice_id, false);

					if (!$invoice) {
						$this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_invoice_error'));
					} else {
						$this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_invoice_success'));
					}

					redirect('cinvoices/view/' . $invoice_id);

				}else {
					$this->load->library('geolib');
					$this->view_data['geolib'] = $this->geolib;

					$this->view_data['max_qty'] = $plan->shipping_available_inventory;
					$this->theme_view = 'modal';
					$this->view_data['title'] = $this->lang->line('application_create_shipping_plan');
					$this->view_data['form_action'] = 'cprojects/planOrder/' . $id . '/create/' . $plan_id;
					$this->content_view = 'projects/client_views/_create_plan';
				}

				break;

			default:
				$this->view_data['project'] = Project::find($id);
				$this->content_view = 'cprojects/view/'.$id;
				break;
		}
	}

	/*function estimate($id = FALSE, $condition = FALSE, $estimate_id = FALSE)
	{
		$this->load->helper('notification');
		$this->view_data['submenu'] = array(
			$this->lang->line('application_back') => 'cprojects',
			$this->lang->line('application_overview') => 'cprojects/view/'.$id,
			$this->lang->line('application_tasks') => 'cprojects/tasks/'.$id,
			$this->lang->line('application_media') => 'cprojects/media/'.$id,
		);
		switch ($condition) {
			case 'create':
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
					$_POST['project_id'] = $id;
					$_POST['company_id'] = $this->client->company->id;
					$_POST['status'] = 'Sent';
					$_POST['estimate_status'] = 'Sent';
					$_POST['issue_date'] = date('Y-m-d');
					$_POST['due_date'] = date('Y-m-d');
					$_POST['currency'] = $core_settings->currency;
					$_POST['terms'] = $core_settings->invoice_terms;
					$_POST['invoice_type'] = $this->invoice_shipment_type;
					$_POST['estimate'] = 1;

					$estimate = Invoice::create($_POST);
					$new_estimate_reference = $_POST['reference']+1;

					$estimate_id = $estimate->id;
					$this->projectlib->addInvoiceAddress($estimate->id, true, $shipping_address);

					$estimate_reference = Setting::first();
					$estimate_reference->update_attributes(array('invoice_reference' => $new_estimate_reference));

					if(!$estimate){
						$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_estimate_error'));
					}
					else{
						$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_estimate_success'));
					}

					redirect('cprojects/view/'.$id);
				}else{
					$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
					$this->view_data['shipping_methods'] = ShippingMethod::find('all', array('order' => 'name desc'));
					$this->view_data['next_reference'] = Project::last();
					$this->theme_view = 'modal';
					$this->view_data['title'] = $this->lang->line('application_create_shipping_estimate');
					$this->view_data['form_action'] = 'cprojects/estimate/'.$id.'/create';
					$this->content_view = 'projects/client_views/_cestimate';
				}

				break;

			default:
				$this->view_data['project'] = Project::find($id);
				$this->content_view = 'cprojects/view/'.$id;
				break;
		}
	}*/

	function create()
	{
		if($_POST){
			unset($_POST['send']);
			unset($_POST['files']);

			$_POST['reference_photo'] = '';

			$config['upload_path'] = './files/media/projects/references/';
			$config['encrypt_name'] = TRUE;
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload())
			{
				$data = array('upload_data' => $this->upload->data());
				$_POST['reference_photo'] = $data['upload_data']['file_name'];
			}

			unset($_POST['userfile']);
			unset($_POST['dummy']);

			$_POST['datetime'] = time();
			$_POST['company_id'] = $this->client->company->id;

			$_POST = array_map('htmlspecialchars', $_POST);

			$_POST['phases'] = $this->projectlib->getProjectPhasesByTypeId($_POST['project_type_id']);
			$_POST['media_phases'] = $this->projectlib->getProjectPhasesByTypeId($_POST['project_type_id'], 'media');

			$project = Project::create($_POST);
			$new_project_reference = $_POST['reference']+1;
			$project_reference = Setting::first();
			$project_reference->update_attributes(array('project_reference' => $new_project_reference));
			if(!$project){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_project_error'));}
			else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_project_success'));
				//$attributes = array('project_id' => $project->id, 'user_id' => $this->user->id);
				//ProjectHasWorker::create($attributes);
			}
			redirect('cprojects');
		}else
		{
			$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			$this->view_data['project_types'] = ProjectType::find('all',array('conditions' => array('inactive=?','0')));
			$this->view_data['shipping_methods'] = ShippingMethod::find('all',array('conditions' => array('inactive=?','0')));
			$this->view_data['next_reference'] = Project::last();
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_project');
			$this->view_data['form_action'] = 'cprojects/create';
			$this->content_view = 'projects/_cproject';
		}
	}
	function item($id = FALSE, $condition = FALSE, $item_id = FALSE)
	{
		$this->load->helper('notification');
		$this->view_data['submenu'] = array(
			$this->lang->line('application_back') => 'projects',
			$this->lang->line('application_overview') => 'projects/view/'.$id,
			$this->lang->line('application_tasks') => 'projects/tasks/'.$id,
			$this->lang->line('application_media') => 'projects/media/'.$id,
		);
		switch ($condition) {
			case 'view':
				$this->theme_view = 'modal';
				$this->content_view = 'projects/view_item';
				$this->view_data['title'] = $this->lang->line('application_item_details');
				$this->view_data['project'] = Project::find($id);
				$this->view_data['project_id'] = $id;
				$this->view_data['item'] = ProjectHasItem::find($item_id);
				$this->view_data['form_action'] = 'projects/item/'.$id.'/view/'.$item_id;
				$this->view_data['backlink'] = 'projects/view/'.$id;
				break;

			case 'update':
				$this->content_view = 'projects/client_views/_edit_item';
				$this->view_data['item'] = ProjectHasItem::find($item_id);
				$this->view_data['items'] = Item::find('all',array('conditions' => array('inactive=?','0')));
				$this->view_data['project'] = Project::find($id);
				if($_POST){
					unset($_POST['send']);
					unset($_POST['_wysihtml5_mode']);
					unset($_POST['files']);
					$_POST = array_map('htmlspecialchars', $_POST);
					$item_id = $_POST['id'];
					$item = ProjectHasItem::find($item_id);
					$item->update_attributes($_POST);
					if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_item_error'));}
					else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_item_success'));}
					redirect('cprojects/view/'.$id);
				}else
				{
					$this->theme_view = 'modal';
					$this->view_data['title'] = $this->lang->line('application_edit_item');
					$this->view_data['form_action'] = 'cprojects/item/'.$id.'/update/'.$item_id;
					$this->content_view = 'projects/client_views/_edit_item';
				}
				break;

			case 'shippingItemView':
				$this->theme_view = 'modal';
				$this->content_view = 'projects/view_shipping_item';
				$this->view_data['title'] = $this->lang->line('application_shipping_item_details');
				$this->view_data['project'] = Project::find($id);
				$this->view_data['project_id'] = $id;
				$this->view_data['item'] = ProjectHasItem::find($item_id);
				$this->view_data['form_action'] = 'cprojects/item/'.$id.'/shippingItemView/'.$item_id;
				$this->view_data['backlink'] = 'cprojects/view/'.$id;
				break;


			default:
				$this->view_data['project'] = Project::find($id);
				$this->content_view = 'projects/view/'.$id;
				break;
		}

	}
	function view($id = FALSE)
	{
		$this->view_data['submenu'] = array(
								$this->lang->line('application_back') => 'cprojects',
								$this->lang->line('application_overview') => 'cprojects/view/'.$id,
						 		$this->lang->line('application_media') => 'cprojects/media/'.$id,
						 		);
		$this->view_data['project'] = Project::find($id);
		$this->view_data['project_has_invoices'] = Invoice::find('all',array('conditions' => array('project_id = ? AND company_id=? AND estimate != ? AND invoice_type != ? AND issue_date<=?',$id,$this->client->company->id,1,'Shipment', date('Y-m-d', time()))));
		$this->view_data['project_has_estimates'] = Invoice::find('all',array('order' => 'id desc', 'conditions' => array('project_id = ? AND company_id=? AND estimate != ? AND issue_date<=?',$id,$this->client->company->id,0,date('Y-m-d', time()))));
		$this->view_data['project_has_shippings'] = Invoice::find('all',array('conditions' => array('project_id = ? AND company_id=? AND estimate != ? AND invoice_type = ? AND shipping_method = ? AND issue_date<=?',$id,$this->client->company->id,1,'Shipment', '',date('Y-m-d', time()))));

		$tasks = ProjectHasTask::count(array('conditions' => 'project_id = '.$id));
		$tasks_done = ProjectHasTask::count(array('conditions' => array('status = ? AND project_id = ?', 'done', $id)));
		@$this->view_data['opentaskspercent'] = $tasks_done/$tasks*100;
		
		$this->view_data['time_days'] = round((human_to_unix($this->view_data['project']->end.' 00:00') - human_to_unix($this->view_data['project']->start.' 00:00')) / 3600 / 24);
		$this->view_data['time_left'] = $this->view_data['time_days'];
		$this->view_data['timeleftpercent'] = 100;

		if(human_to_unix($this->view_data['project']->start.' 00:00') < time() && human_to_unix($this->view_data['project']->end.' 00:00') > time()){
			$this->view_data['time_left'] = round((human_to_unix($this->view_data['project']->end.' 00:00') - time()) / 3600 / 24);
			$this->view_data['timeleftpercent'] = $this->view_data['time_left']/$this->view_data['time_days']*100;
		}
		if(human_to_unix($this->view_data['project']->end.' 00:00') < time()){
			$this->view_data['time_left'] = 0;
			$this->view_data['timeleftpercent'] = 0;
		}
		@$this->view_data['opentaskspercent'] = $tasks_done/$tasks*100;
		$tracking = $this->view_data['project']->time_spent;
		if(!empty($this->view_data['project']->tracking)){ $tracking=(time()-$this->view_data['project']->tracking)+$this->view_data['project']->time_spent; }
		$this->view_data['timertime'] = $tracking;
		$this->view_data['time_spent_from_today'] = time() - $this->view_data['project']->time_spent;	
		$tracking = floor($tracking/60);
		$tracking_hours = floor($tracking/60);
		$tracking_minutes = $tracking-($tracking_hours*60);

		

		$this->view_data['time_spent'] = $tracking_hours." ".$this->lang->line('application_hours')." ".$tracking_minutes." ".$this->lang->line('application_minutes');
		$this->view_data['time_spent_counter'] = sprintf("%02s", $tracking_hours).":".sprintf("%02s", $tracking_minutes);

		if(!isset($this->view_data['project_has_invoices'])){$this->view_data['project_has_invoices'] = array();}
		if(!isset($this->view_data['project_has_shippings'])){$this->view_data['project_has_shippings'] = array();}
		if($this->view_data['project']->company_id != $this->client->company->id){ redirect('cprojects');}
		$this->content_view = 'projects/client_views/view';

	}
	function media($id = FALSE, $condition = FALSE, $media_id = FALSE)
	{
		$this->load->helper('notification');
			$this->view_data['submenu'] = array(
								$this->lang->line('application_back') => 'cprojects',
								$this->lang->line('application_overview') => 'cprojects/view/'.$id,
						 		$this->lang->line('application_media') => 'cprojects/media/'.$id,
						 		);
		switch ($condition) {
			case 'load':
				$this->view_data['project'] = Project::find($id);
				$this->view_data['files'] = array();

				$this->theme_view = 'ajax';
				$this->content_view = 'projects/client_views/view_media_list';

				if(!isset($_POST['phase']) || empty($_POST['phase'])){

				}else{
					$_POST = array_map('htmlspecialchars', $_POST);
					$phase = $_POST['phase'];

					$this->view_data['project'] = Project::find($id);
					$this->view_data['files'] = ProjectHasFile::find('all',array('conditions' => array('project_id=? AND phase=?', $id, $phase)));
				}
				break;

			case 'view':

				if($_POST){
					unset($_POST['send']);
					unset($_POST['_wysihtml5_mode']);
					unset($_POST['files']);
					//$_POST = array_map('htmlspecialchars', $_POST);
					$_POST['text'] = $_POST['message'];
					unset($_POST['message']);
					$_POST['project_id'] = $id;
					$_POST['media_id'] = $media_id; 
					$_POST['from'] = $this->client->firstname.' '.$this->client->lastname;
					$this->view_data['project'] = Project::find_by_id($id);
					$this->view_data['media'] = ProjectHasFile::find($media_id);
					$message = Message::create($_POST);
       				if(!$message){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_message_error'));}
       				else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_message_success'));
       					foreach ($this->view_data['project']->project_has_workers as $workers){
            			    send_notification($workers->user->email, "[".$this->view_data['project']->name."] New comment", 'New comment on meida file: '.$this->view_data['media']->name.'<br><strong>'.$this->view_data['project']->name.'</strong>');
            			}

       				}
       				redirect('cprojects/media/'.$id.'/view/'.$media_id);
				}
				$this->content_view = 'projects/client_views/view_media';
				$this->view_data['media'] = ProjectHasFile::find($media_id);
				$project = Project::find_by_id($id);
				if($project->company_id != $this->client->company->id){ redirect('cprojects');}
				$this->view_data['form_action'] = 'cprojects/media/'.$id.'/view/'.$media_id;
				$this->view_data['filetype'] = explode('.', $this->view_data['media']->filename);
				$this->view_data['filetype'] = $this->view_data['filetype'][1];
				$this->view_data['backlink'] = 'cprojects/view/'.$id;
				break;
			case 'add':
				$this->content_view = 'projects/_media';
				$this->view_data['project'] = Project::find($id);
				if($_POST){
					$config['upload_path'] = './files/media/';
					$config['encrypt_name'] = TRUE;
					$config['allowed_types'] = '*';

					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload())
						{
							$error = $this->upload->display_errors('', ' ');
							$this->session->set_flashdata('message', 'error:'.$error);
							redirect('cprojects/view/'.$id);
						}
						else
						{
							$data = array('upload_data' => $this->upload->data());

							$_POST['filename'] = $data['upload_data']['orig_name'];
							$_POST['savename'] = $data['upload_data']['file_name'];
							$_POST['type'] = $data['upload_data']['file_type'];
						}

					unset($_POST['send']);
					unset($_POST['userfile']);
					unset($_POST['file-name']);
					unset($_POST['files']);
					$_POST = array_map('htmlspecialchars', $_POST);
					$_POST['project_id'] = $id;
					$_POST['client_id'] = $this->client->id;
					$media = ProjectHasFile::create($_POST);
		       		if(!$media){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_media_error'));}
		       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_media_success'));
		       			$attributes = array('subject' => $this->lang->line('application_new_media_subject'), 'message' => '<b>'.$this->client->firstname.' '.$this->client->lastname.'</b> '.$this->lang->line('application_uploaded'). ' '.$_POST['name'], 'datetime' => time(), 'project_id' => $id, 'type' => 'media', 'client_id' => $this->client->id);
					    $activity = ProjectHasActivity::create($attributes);
    		       		
    		       		foreach ($this->view_data['project']->project_has_workers as $workers){
            			    send_notification($workers->user->email, "[".$this->view_data['project']->name."] ".$this->lang->line('application_new_media_subject'), $this->lang->line('application_new_media_file_was_added').' <strong>'.$this->view_data['project']->name.'</strong>');
            			}
            			if(isset($this->view_data['project']->company->client->email)){
            			send_notification($this->view_data['project']->company->client->email, "[".$this->view_data['project']->name."] ".$this->lang->line('application_new_media_subject'), $this->lang->line('application_new_media_file_was_added').' <strong>'.$this->view_data['project']->name.'</strong>');
            			}
		       		}
					redirect('cprojects/view/'.$id);
				}else
				{
					$this->theme_view = 'modal';
					$this->view_data['title'] = $this->lang->line('application_add_media');
					$this->view_data['form_action'] = 'cprojects/media/'.$id.'/add';
					$this->content_view = 'projects/_media';
				}	
				break;
			case 'update':
				$this->content_view = 'projects/_media';
				$this->view_data['media'] = ProjectHasFile::find($media_id);
				$this->view_data['project'] = Project::find($id);
				if($_POST){
					unset($_POST['send']);
					unset($_POST['_wysihtml5_mode']);
					unset($_POST['files']);
					$_POST = array_map('htmlspecialchars', $_POST);
					$media_id = $_POST['id'];
					$media = ProjectHasFile::find($media_id);
					if ($this->view_data['media']->client_id != "0") {
						$media->update_attributes($_POST);
					}
		       		if(!$media){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_media_error'));}
		       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_media_success'));}
					redirect('cprojects/view/'.$id);
				}else
				{
					$this->theme_view = 'modal';
					$this->view_data['title'] = $this->lang->line('application_edit_media');
					$this->view_data['form_action'] = 'cprojects/media/'.$id.'/update/'.$media_id;
					$this->content_view = 'projects/_media';
				}	
				break;
			case 'delete':
					$media = ProjectHasFile::find($media_id);
					if ($media->client_id != "0") {
						$media->delete();
						$this->load->database();
						$sql = "DELETE FROM messages WHERE media_id = $media_id";
						$this->db->query($sql);
					}
		       		if(!$media){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_media_error'));}
		       		else{	unlink('./files/media/'.$media->savename);
		       				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_media_success'));
		       			}
					redirect('cprojects/view/'.$id);
				break;
			default:
				$this->view_data['project'] = Project::find($id);
				$this->content_view = 'projects/client_views/media';
				break;
		}

	}
	function deletemessage($project_id, $media_id, $id){
					$from = $this->client->firstname.' '.$this->client->lastname;
					$message = Message::find($id);
					if($message->from == $this->client->firstname." ".$this->client->lastname){
					$message->delete();
					}
		       		if(!$message){
		       			$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_message_error'));
		       		}
		       		else{ 
		       			$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_message_success'));
		       		}
					redirect('cprojects/media/'.$project_id.'/view/'.$media_id);
	}
	function download($media_id = FALSE){

		$this->load->helper('download');
		$media = ProjectHasFile::find($media_id);
		$project = Project::find_by_id($media->project_id);
		if($project->company_id != $this->client->company->id){ redirect('cprojects');}
		$media->download_counter = $media->download_counter+1;
		$media->save();

		$data = file_get_contents('./files/media/'.$media->savename); 
		$name = $media->filename;
		force_download($name, $data);
	}

	function activity($id = FALSE, $condition = FALSE, $activityID = FALSE)
	{
	    $this->load->helper('notification');
		$project = Project::find_by_id($id);
		//$activity = ProjectHasAktivity::find_by_id($activityID);
		switch ($condition) {
			case 'add':
				if($_POST){
					unset($_POST['send']);
					$_POST['subject'] = htmlspecialchars($_POST['subject']);
					$_POST['message'] = strip_tags($_POST['message'], '<br><br/><p></p><a></a><b></b><i></i><u></u><span></span>');
					$_POST['project_id'] = $id;
					$_POST['client_id'] = $this->client->id;
					$_POST['type'] = "comment";
					unset($_POST['files']);
					$_POST['datetime'] = time();
					$activity = ProjectHasActivity::create($_POST);
		       		if(!$activity){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_error'));}
		       		else{
		       		    $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_success'));
		       		    foreach ($project->project_has_workers as $workers){
            			    send_notification($workers->user->email, "[".$project->name."] ".$_POST['subject'], $_POST['message'].'<br><strong>'.$project->name.'</strong>');
            			}
            			if(isset($project->company->client->email)){
            			send_notification($project->company->client->email, "[".$project->name."] ".$_POST['subject'], $_POST['message'].'<br><strong>'.$project->name.'</strong>');
            			}
		       		}
					//redirect('projects/view/'.$id);
					
				}
				break;
			case 'update':
				
				break;
			case 'delete':
				
				break;
		}

	}

}