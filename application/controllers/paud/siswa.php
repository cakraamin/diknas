<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('msiswa','',TRUE);
		$this->load->library(array('page','SimpleLoginSecure','arey'));

		$this->load->library('acl',$this->session->userdata('user_id'));

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{	
		redirect('paud/siswa/daftar');
	}

	function daftar($short_by='id_school',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$ta_aktif = $this->msiswa->getTaAktif();
		$total_page = $this->msiswa->getJumSiswaPaud($ta_aktif['tahun']);

		$url = 'paud/siswa/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->msiswa->getSiswaPaud($ta_aktif['tahun'],$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('paud/siswa/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}			

		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'paud/siswa',
			'siswa'			=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);

		$this->load->view('paud/template',$data);

	}

	function tambah_siswa()
	{

		$ta_aktif = $this->msiswa->getTaAktif();

		$data = array(	  		
			'main'			=> 'paud/formSiswa',
			'ket'			=> 'Form Data Siswa',
			'jenis'			=> 'Tambah',
			'siswa'			=> 'select',
			'link'			=> 'simpan_siswa/'.$ta_aktif['tahun'],
			'skuls'			=> $this->msiswa->getDaftarSkul()
		);		

		$this->load->view('paud/template',$data);
	}

	function simpan_siswa($id)
	{			
		$this->msiswa->addSiswaPaud($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data siswa berhasil ditambahkan');			
		}
		else
		{
			$this->message->set('notice','Data siswa gagal ditambahkan');				
		}
		redirect('paud/siswa/daftar');
	}

	function edit_siswa($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('paud/siswa/daftar');
		}

		$ta_aktif = $this->msiswa->getTaAktif();

		$data = array(	  	
			'main'			=> 'paud/formSiswa',
			'ket'			=> 'Form Data Guru',
			'jenis'			=> 'Edit',
			'siswa'			=> 'select',
			'link'			=> 'update_siswa/'.$id.'/'.$ta_aktif['tahun'],
			'kueri'			=> $this->msiswa->editSiswaPaud($id),
			'skuls'			=> $this->msiswa->getDaftarSkul()
		);

		$this->load->view('paud/template',$data);
	}

	function update_siswa($id,$ta)

	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('paud/siswa/daftar');
		}

		$this->msiswa->updateSiswaPaud($id,$ta);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data siswa berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data siswa gagal diupdate');
		}

		redirect('paud/siswa/daftar');
	}

	function hapus_siswa($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('paud/siswa/daftar');
		}

		if($this->msiswa->deleteSiswaPaud($id))
		{
			$this->message->set('succes','Data siswa berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data siswa gagal dihapus');
		}
		redirect('paud/siswa/daftar');
	}

	function all_siswa()
	{
		$cek = $this->input->post('check');

		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data siswa yang dipilih');
			redirect('paud/siswa/daftar');
		}

		foreach($cek as $dt_cek)
		{
			$this->msiswa->deleteSiswaPaud($dt_cek);
		}
		$this->message->set('succes','Data guru berhasil dihapus');
		redirect('paud/siswa/daftar');
	}
}