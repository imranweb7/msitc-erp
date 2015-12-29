<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Project common behaviors
 *
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author		Muhammed Imran Hussain (imranweb7@gmail.com)
 * @link		http://www.ihussain.info/
 */
class Projectlib
{
	private $_ci;				// CodeIgniter instance
	private $_item_status = array('pending'=>'Pending', 'invoiced'=> 'Invoiced', 'paid'=>'Paid');


	function __construct($url = '')
	{
		$this->_ci = & get_instance();
	}

	/*
	 * Get project items status array
	 *
	 * @return Array
	 */
	public function getStatusArray()
	{
		return $this->_item_status;
	}

	/*
	 * Get project items status array
	 *
	 * @return Array
	 */
	public function getPaymentStatusbyKey($key=NULL)
	{
		if(empty($key)){
			return '';
		}

		if(!array_key_exists($key, $this->getStatusArray())){
			return '';
		}

		return $this->getStatusArray()[$key];
	}

	/*
	 * Get project phases by project type
	 *
	 * @param int $type_id the project type id
	 * @param string $phase_type default|media
	 *
	 * @return string
	 */
	public function getProjectPhasesByTypeId($type_id=NULL, $phase_type='default')
	{
		if(empty($type_id)){
			return '';
		}

		$project_type = ProjectType::find($type_id);

		if(!$project_type) {
			return '';
		}else{
			switch ($phase_type) {
				case 'media':
						return $project_type->media_phases;
					break;

				case 'default':
				default:
				return $project_type->phases;
					break;

			}
		}
	}

	/*
	 * Get project phases
	 *
	 * @param mix $project the project id or project object
	 * @param string $phase_type default|media
	 *
	 * @return array
	 */
	public function getProjectPhaseArray($project=NULL, $phase_type='default')
	{
		if(empty($project)){
			return array();
		}

		if(!is_object($project)){
			$project = Project::find($project);
		}

		if(!is_object($project)){
			return array();
		}else{
			switch ($phase_type) {
				case 'media':
					return $project->media_phases;
					break;

				case 'default':
				default:
					return $project->phases;
					break;

			}
		}
	}

	/*
	 * Update project invoice total
	 *
	 * @param Object $invoice the invoice object
	 *
	 * @return null
	 */
	public function updateInvoiceTotal($invoice=NULL)
	{
		if(empty($invoice)){
			return;
		}

		$items = $invoice->invoice_has_items;

		//calculate sum
		$i = 0; $sum = 0; $core_settings = Setting::first();
		foreach ($items as $value){
			$sum = $sum+$invoice->invoice_has_items[$i]->amount*$invoice->invoice_has_items[$i]->value; $i++;
		}
		if(substr($invoice->discount, -1) == "%"){
			$discount = sprintf("%01.2f", round(($sum/100)*substr($invoice->discount, 0, -1), 2));
		}
		else{
			$discount = $invoice->discount;
		}
		$sum = $sum-$discount;

		if($invoice->tax != ""){
			$tax_value = $invoice->tax;
		}else{
			$tax_value = $core_settings->tax;
		}

		if($invoice->second_tax != ""){
			$second_tax_value = $invoice->second_tax;
		}else{
			$second_tax_value = $core_settings->second_tax;
		}

		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$second_tax = sprintf("%01.2f", round(($sum/100)*$second_tax_value, 2));

		$sum = sprintf("%01.2f", round($sum+$tax+$second_tax, 2));

		$payment = 0;
		$i = 0;
		$payments = $invoice->invoice_has_payments;
		if(isset($payments)){
			foreach ($payments as $value) {
				$payment = sprintf("%01.2f", round($payment+$payments[$i]->amount, 2));
				$i++;
			}
			$invoice->paid = $payment;
			$invoice->outstanding = sprintf("%01.2f", round($sum-$payment, 2));
		}

		$invoice->sum = $sum;
		$invoice->save();
	}

	/*
	 * Update project invoice items status
	 *
	 * @param Object $invoice the invoice object
	 *
	 * @return null
	 */
	public function updateInvoiceProjectItemStatus($invoice=NULL)
	{
		if(empty($invoice)){
			return;
		}

		$items = $invoice->invoice_has_items;

		$i = 0;
		foreach ($items as $value){
			$project_item = ProjectHasItem::find($value->project_item_id);
			if(!$project_item){
				continue;
			}

			$project_item->payment_status = 'paid';
			$project_item->save();
		}
	}

	/*
	 * Send invoice to client email
	 *
	 * @param int $id the invoice id
	 * @param bool $redirect
	 *
	 * @return null
	 */
	public function sendInvoice($id = FALSE, $redirect=true){
		$this->_ci->load->helper(array('dompdf', 'file'));
		$this->_ci->load->library('parser');

		$data["invoice"] = Invoice::find($id);
		$data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));
		$data["core_settings"] = Setting::first();
		$due_date = date($data["core_settings"]->date_format, human_to_unix($data["invoice"]->due_date.' 00:00:00'));
		//Set parse values
		$parse_data = array(
			'client_contact' => $data["invoice"]->company->client->firstname.' '.$data["invoice"]->company->client->lastname,
			'client_company' => $data["invoice"]->company->name,
			'due_date' => $due_date,
			'invoice_id' => $data["invoice"]->reference,
			'client_link' => $data["core_settings"]->domain,
			'company' => $data["core_settings"]->company,
			'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
			'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>'
		);
		// Generate PDF
		$html = $this->_ci->load->view($data["core_settings"]->template. '/' .$data["core_settings"]->invoice_pdf_template, $data, true);
		$html = $this->_ci->parser->parse_string($html, $parse_data);
		$filename = $this->_ci->lang->line('application_invoice').'_'.$data["invoice"]->reference;
		pdf_create($html, $filename, FALSE);
		//email
		$subject = $this->_ci->parser->parse_string($data["core_settings"]->invoice_mail_subject, $parse_data);
		$this->_ci->email->from($data["core_settings"]->email, $data["core_settings"]->company);
		if(!isset($data["invoice"]->company->client->email)){
			$this->_ci->session->set_flashdata('message', 'error:This client company has no primary contact! Just add a primary contact.');
			if($redirect) redirect('invoices/view/'.$id);
		}
		$this->_ci->email->to($data["invoice"]->company->client->email);
		$this->_ci->email->subject($subject);
		$this->_ci->email->attach("files/temp/".$filename.".pdf");

		$email_invoice = read_file('./application/views/'.$data["core_settings"]->template.'/templates/email_invoice.html');
		$message = $this->_ci->parser->parse_string($email_invoice, $parse_data);
		$this->_ci->email->message($message);
		if($this->_ci->email->send()){
			$this->_ci->session->set_flashdata('message', 'success:'.$this->_ci->lang->line('messages_send_invoice_success'));
			$data["invoice"]->update_attributes(array('status' => 'Sent', 'sent_date' => date("Y-m-d")));
			log_message('error', 'Invoice #'.$data["invoice"]->reference.' has been send to '.$data["invoice"]->company->client->email);
		}
		else{$this->_ci->session->set_flashdata('message', 'error:'.$this->_ci->lang->line('messages_send_invoice_error'));
			log_message('error', 'ERROR: Invoice #'.$data["invoice"]->reference.' has not been send to '.$data["invoice"]->company->client->email.'. Please check your servers email settings.');
		}
		unlink("files/temp/".$filename.".pdf");
		if($redirect) redirect('invoices/view/'.$id);
	}
}