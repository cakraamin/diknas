<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{
		
	}

	function edit($id)
	{
		$data = array(
			'main'		=> 'setting'
		);

		$this->load->view('template',$data);
	}
}