<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProjectTypes extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('projecttypes');
		}elseif($this->user){
			$this->view_data['invoice_access'] = FALSE;
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "projecttypes"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}

		$this->load->database();
		
	}	
	function index()
	{
		$this->view_data['project_types'] = ProjectType::find('all', array('order' => 'name desc'));
		$this->content_view = 'projects/types/all';
	}

	function create()
	{
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);

			$project_type = ProjectType::create($_POST);
       		if(!$project_type){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_project_type_error'));
			}else {
				$this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_project_type_success'));
			}

			redirect('projecttypes');
		}else{

			$this->view_data['project_types'] = ProjectType::find('all', array('order' => 'name desc'));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_add_new_project_type');
			$this->view_data['form_action'] = 'projecttypes/create';
			$this->content_view = 'projects/types/_projecttypes';
		}	
	}	
	function update($id = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			$id = $_POST['id'];
			$_POST = array_map('htmlspecialchars', $_POST);

			$project_type = ProjectType::find($id);
			$project_type->update_attributes($_POST);

       		if(!$project_type){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_project_type_error'));
			}else{
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_project_type_success'));
			}

			redirect('projecttypes/view/'.$id);
		}else
		{
			$this->view_data['project_type'] = ProjectType::find($id);
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_project_type');
			$this->view_data['form_action'] = 'projecttypes/update';
			$this->content_view = 'projects/types/_projecttypes';
		}	
	}
	function delete($id = FALSE)
	{	
		$project_type = ProjectType::find($id);
		$project_type->delete();

		$this->content_view = 'projects/types/all';
		if(!$project_type){
			$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_project_type_error'));
		}else{
			$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_project_type_success'));
		}

		if(isset($view)){
			redirect('projecttypes/view/'.$id);
		}else{
			redirect('projecttypes');
		}
	}
	function view($id = FALSE)
	{ 
		$this->view_data['submenu'] = array();
		$this->view_data['project_type'] = ProjectType::find($id);

		$this->content_view = 'projects/types/view';
	}
}