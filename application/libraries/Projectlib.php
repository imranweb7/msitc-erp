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
	private $_item_status = array('pending'=>'Pending', 'paid'=>'Paid');


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

}