<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('muser','',TRUE);
		$this->load->library(array('page','SimpleLoginSecure','arey'));

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{		

	}	

	function edit($id,$nama="")
	{
		if($id == '')
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('user');
		}

		if($nama == "")
		{
			$re = "paud/user";
		}
		else
		{
			$re = "paud/dashboard";
		}

		$data = array(	  
			'user'			=> 'select',
			'main'			=> 'paud/editUsers',
			'ket'			=> 'Form User',
			'jenis'			=> 'Edit',
			'kueri'			=> $this->muser->editUser($id),
			'link'			=> 'update/'.$id,
			're'			=> $re,
			'nama'			=> $nama,
			'id'			=> $id
		);			

		$this->load->view('paud/template',$data);
	}

	function update($id)
	{
		$username = $this->input->post('username',TRUE);
		$old = $this->input->post('oldpassword',TRUE);
		$new = $this->input->post('password',TRUE);
		$re = $this->input->post('re',TRUE);

		if($this->simpleloginsecure->edit_password($username, $old, $new))
		{
			$this->message->set('succes','Update password user berhasil');
		}
		else
		{
			$this->message->set('notice','Maaf update password user gagal');
		}
		redirect($re);
	}
}