<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Project user common behaviors
 *
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author		Muhammed Imran Hussain (imranweb7@gmail.com)
 * @link		http://www.ihussain.info/
 */
class Userlib
{
	function __construct($url = '')
	{
		$this->_ci = & get_instance();
	}


	/*
	 * Get all admins
	 *
	 * @param bool $module_id the module id
	 *
	 * @return array
	 */
	public function getAdmins($module_id=FALSE)
	{
		$admins = User::find(
			'all',
			array(
				'conditions' => array(
					'admin=? AND status=?','1','active'
				)
			)
		);


		if(!count($admins)){
			return array();
		}

		$list = array();
		foreach($admins as $admin){
			$access_to = explode(',',$admin->access);
			if($module_id && !in_array($module_id, $access_to)){
				continue;
			}

			$list[$admin->email] = $admin->firstname.' '.$admin->lastname;
		}

		return $list;
	}
}