<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends MY_Controller {

	const UPLOAD_PATH = './files/media/';
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('cprojects');
		}elseif($this->user){
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "items"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all_items') => 'items'
				 		);	
		
	}	
	function index()
	{
		$this->view_data['items'] = Item::find('all');
		$this->content_view = 'invoices/items';
	}
	function view($id = FALSE)
	{
		$this->view_data['submenu'] = array();
		$this->view_data['item'] = Item::find($id);

		$this->content_view = 'invoices/item_view';
	}
	function create_items(){
		if($_POST){
			$config['upload_path'] = self::UPLOAD_PATH;
			$config['encrypt_name'] = TRUE;
			$config['allowed_types'] = '*';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$error = $this->upload->display_errors('', ' ');
				$this->session->set_flashdata('message', 'error:'.$error);
				redirect('items');
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$_POST['photo'] = $data['upload_data']['file_name'];
				$_POST['photo_type'] = $data['upload_data']['file_type'];
				$_POST['photo_original_name'] = $data['upload_data']['orig_name'];
			}

			unset($_POST['send']);
			unset($_POST['userfile']);
			unset($_POST['file-name']);
			unset($_POST['files']);

			$_POST = array_map('htmlspecialchars', $_POST);
			$item = Item::create($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_item_success'));}
			redirect('items');
			
		}else
		{
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_item');
			$this->view_data['form_action'] = 'items/create_items';
			$this->content_view = 'invoices/_items';
		}	
	}
	function update_items($id = FALSE){
		if($_POST){
			unset($_POST['send']);

			$id = $_POST['id'];
			$item = Item::find($id);

			$_POST['photo'] = $item->photo;
			$_POST['photo_type'] = $item->photo_type;
			$_POST['photo_original_name'] = $item->photo_original_name;

			if (!empty($_FILES['userfile']['name'])) {
				$config['upload_path'] = self::UPLOAD_PATH;
				$config['encrypt_name'] = TRUE;
				$config['allowed_types'] = '*';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload()) {
					$data = array('upload_data' => $this->upload->data());
					$_POST['photo'] = $data['upload_data']['file_name'];
					$_POST['photo_type'] = $data['upload_data']['file_type'];
					$_POST['photo_original_name'] = $data['upload_data']['orig_name'];

					if(!empty($item->photo)){
						@unlink(self::UPLOAD_PATH.$item->photo);
					}
				}
			}

			$_POST = array_map('htmlspecialchars', $_POST);

			$item = $item->update_attributes($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_item_success'));}
			redirect('items');
			
		}else
		{
			$this->view_data['items'] = Item::find($id);
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_item');
			$this->view_data['form_action'] = 'items/update_items';
			$this->content_view = 'invoices/_items';
		}	
	}
	function delete_items($id = FALSE){
		$item = Item::find($id);
		@unlink(self::UPLOAD_PATH.$item->photo);
		$item->delete();
		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_item_error'));}
       	else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_item_success'));}
		redirect('items');
	}
	
}