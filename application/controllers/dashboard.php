<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('mhome','',TRUE);

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index($user="",$token="")
	{
		if($user != "")
		{
			if($token != "" && !$this->mhome->getCekSess($user,$token))
			{
				$user_data = array(
					'user'		=> "",
					'logged_in'	=> FALSE,
					'levels'	=> "",
					'id_school'	=> "",
				);	

				$this->session->unset_userdata($user_data);

				redirect('home');				
			}

			$cekSess = $this->mhome->getSess($user);

			$user_data = array(
				'user'		=> $cekSess->user_email,
				'logged_in'	=> TRUE,
				'levels'	=> $cekSess->user_level,
				'id_school'	=> $cekSess->id_school,
			);			

			$this->session->set_userdata($user_data);
		}

		$graphice = (!$this->mhome->getStatusSek($this->session->userdata('user_email')))?$this->mhome->getGraphicHome():"";

		$data = array(
			'home'			=> 'select',
			'graphic'		=> $graphice,
			'main'			=> 'home'
		);

		$this->load->view('template',$data);
	}
}
