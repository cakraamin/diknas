<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Globals
{
	public function Globals()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('mglobal','',TRUE);
	}

	function getStatuseSkule($id)
	{
		$query = $this->ci->mglobal->getStatusSkule($id);
		return $query;
	}	

	function getUsernameE($id)
	{
		$kueri = $this->ci->mglobal->getNamaSkulUser($id);
		return $kueri;
	}
}
