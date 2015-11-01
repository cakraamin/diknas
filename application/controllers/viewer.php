<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewer extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mview','',TRUE);
		$this->load->library(array('page','SimpleLoginSecure','arey'));

		$this->load->library('acl',$this->session->userdata('user_id'));

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	public function index()
	{
		redirect('viewer/guru');
	}

	public function guru($viewer=1)
	{
		if($viewer == 1)
		{
			$tabele = 'tabelGuru';
		}
		elseif($viewer == 2)
		{
			$tabele = 'tabelStatus';	
		}
		elseif($viewer == 3)
		{
			$tabele = 'tabelGolongan';	
		}
		elseif($viewer == 4)
		{
			$tabele = 'tabelPendidikan';		
		}
		elseif($viewer == 5)
		{
			$tabele = 'tabelSertifikasi';		
		}
		else
		{
			$tabele = 'tabelGuruPensiun';
		}

		$data = array(	  		
			'main'			=> 'viewGuru',
			'ket'			=> 'Form Data Sekolah',
			'jenis'			=> 'Tambah',
			'view'			=> 'select',
			'tabele'		=> $tabele,
			'viewer'		=> $this->arey->getJenisViewer(),
			'kueri'			=> $this->mview->getGuru($viewer),
			'viewene'		=> $viewer
		);
			
		$this->load->view('template',$data);
	}

	public function detail($viewer=1,$kec=0,$id=0)
	{
		if($viewer == 1)
		{
			$tabele = 'tabelGuru';
		}
		elseif($viewer == 2)
		{
			$tabele = 'tabelStatusSkul';	
		}
		elseif($viewer == 3)
		{
			$tabele = 'tabelGolonganSkul';	
		}
		elseif($viewer == 4)
		{
			$tabele = 'tabelPendidikanSkul';		
		}
		else
		{
			$tabele = 'tabelSertifikasiSkul';	
		}

		$data = array(	  		
			'main'			=> 'viewGuru',
			'ket'			=> 'Form Data Sekolah',
			'jenis'			=> 'Tambah',
			'view'			=> 'select',
			'tabele'		=> $tabele,
			'viewer'		=> $this->arey->getJenisViewer(),
			'kueri'			=> $this->mview->getDetailGuru($viewer,$kec,$id),
			'viewene'		=> $viewer,
			'kece'			=> $kec,
			'id'			=> $id
		);
			
		$this->load->view('template',$data);
	}

	public function daftar($viewer=1,$kec=0,$id=0,$jk=1,$stat=0,$tingkat=0)
	{
		$tabele = 'listDetailGuru';

		$data = array(	  		
			'main'			=> 'viewGuru',
			'ket'			=> 'Form Data Sekolah',
			'jenis'			=> 'Tambah',
			'view'			=> 'select',
			'tabele'		=> $tabele,
			'viewer'		=> $this->arey->getJenisViewer(),
			'kueri'			=> $this->mview->getListGuru($viewer,$kec,$id,$jk,$stat,$tingkat),
			'viewene'		=> $viewer,
			'kece'			=> $kec,
			'id'			=> $id
		);
			
		$this->load->view('template',$data);
	}

	public function submit($id)
	{
		$view = $this->input->post('jenis_view',TRUE);

		redirect('viewer/guru/'.$view);
	}
}