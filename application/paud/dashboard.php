<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dashboard extends CI_Controller {



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

		$data = array(

			'home'			=> 'select',

			'main'			=> 'paud/home'

		);



		$this->load->view('paud/template',$data);

	}

}