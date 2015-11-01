<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembiayaan extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('mbiaya','',TRUE);
		$this->load->library(array('page','SimpleLoginSecure','arey'));

		$this->load->library('acl',$this->session->userdata('user_id'));

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('pembiayaan/masuk');
	}

	function masuk()
	{
		$kelas = 0;

		$tingkat = $this->mbiaya->getTingkatSchool($this->session->userdata('id_school'));		

		if($tingkat['tingkat'] == 0)
		{
			$this->message->set('notice','Maaf jenjang sekolah belum ditentukan');
			redirect('dashboard');
		}

		$ta_aktif = $this->mbiaya->getTaAktif();

		$data = array(	  		
			'main'			=> 'formMasuk',
			'ket'			=> 'Form Data Pembiayaan',
			'jenise'		=> 'Masuk',
			'biaya'			=> 'select',
			'link'			=> 'simpan_masuk/'.$ta_aktif['tahun'],						
			'kueri'			=> $this->mbiaya->getDetailMasukSiswa($ta_aktif['tahun'],$kelas,$tingkat['tingkat'],$tingkat['kelompok'],$tingkat['jenis']),
			'jenis'			=> $tingkat['jenis'],			
		);		
		$this->load->view('template',$data);
	}

	function keluar()
	{
		$kelas = 0;

		$tingkat = $this->mbiaya->getTingkatSchool($this->session->userdata('id_school'));		

		if($tingkat['tingkat'] == 0)
		{
			$this->message->set('notice','Maaf jenjang sekolah belum ditentukan');
			redirect('dashboard');
		}

		$ta_aktif = $this->mbiaya->getTaAktif();		

		$data = array(	  		
			'main'			=> 'formKeluar',
			'ket'			=> 'Form Data Pembiayaan',
			'jenise'		=> 'Keluar',
			'keluar'		=> 'select',
			'link'			=> 'simpan_keluar/'.$ta_aktif['tahun'],			
			'kueri'			=> $this->mbiaya->getDetailKeluarSiswa($ta_aktif['tahun'],$kelas,$tingkat['tingkat'],$tingkat['kelompok'],$tingkat['jenis']),
			'jenis'			=> $tingkat['jenis'],			
		);		
		$this->load->view('template',$data);
	}

	function simpan_masuk($id="",$kode=0)
	{	
		$ta_aktif = $this->mbiaya->getTaAktif();

		if($kode == 0)
		{
			$kueri = $this->mbiaya->addBiayaMasuk($ta_aktif['tahun']);			
		}
		else
		{
			$kueri = $this->mbiaya->updateBiayaMasuk($ta_aktif['tahun'],$kode);			
		}				
		
		if($this->db->affected_rows() > 0)
		{		
			$this->message->set('succes','Data Pembiayaan Berhasil Ditambahkan');
			redirect('pembiayaan/masuk');			
		}
		else
		{
			$this->message->set('notice','Data Pembiayaan gagal ditambahkan');
			redirect('pembiayaan/masuk');
		}
	}

	function simpan_keluar($id="",$kode=0)
	{	
		$ta_aktif = $this->mbiaya->getTaAktif();

		if($kode == 0)
		{
			$kueri = $this->mbiaya->addBiayaKeluar($ta_aktif['tahun']);		
		}
		else
		{
			$kueri = $this->mbiaya->updateBiayaKeluar($ta_aktif['tahun'],$kode);		
		}			
		
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data pembiayaan berhasil disimpan');
			redirect('pembiayaan/keluar');			
		}
		else
		{
			$this->message->set('notice','Data pembiayaan gagal disimpan');
			redirect('pembiayaan/keluar');			
		}
	}
}