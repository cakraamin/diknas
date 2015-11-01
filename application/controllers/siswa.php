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
		$kelas = 0;

		$tingkat = $this->msiswa->getTingkatSchool($this->session->userdata('id_school'));		

		if($tingkat['tingkat'] == 0)
		{
			$this->message->set('notice','Maaf jenjang sekolah belum ditentukan');
			redirect('dashboard');
		}

		$ta_aktif = $this->msiswa->getTaAktif();

		if($this->arey->getJenjang($tingkat['tingkat']) == "SD/MI")
		{
			$kelas = 6;
		}
		else
		{
			$kelas = 3;
		}		

		$data = array(	  		
			'main'			=> 'formSiswa',
			'ket'			=> 'Form Data Siswa',
			'jenis'			=> 'Tambah',
			'siswa'			=> 'select',
			'link'			=> 'simpan_sekolah/'.$ta_aktif['tahun'],
			'kelas'			=> $kelas,
			'jenjang'		=> $this->arey->getJenjang($tingkat['tingkat']),
			'kueri'			=> $this->msiswa->getDetailSiswa($ta_aktif['tahun'],$kelas,$tingkat['tingkat'],$tingkat['kelompok'],$tingkat['jenis']),
			'jenis'			=> $tingkat['jenis'],
			'tingkat'		=> $tingkat['tingkat'],
			//'nilai'			=> $this->msiswa->getUmur($tingkat['tingkat'],$ta_aktif['tahun']),
			//'prodi'			=> $this->msiswa->getProdi($tingkat['tingkat'],$kelas,$ta_aktif['tahun']),
			//'nonprodi'		=> $this->msiswa->getNonProdi($tingkat['tingkat'],$kelas,$ta_aktif['tahun'])
		);		
		$this->load->view('template',$data);
	}

	function agama()
	{
		$kelas = 0;

		$tingkat = $this->msiswa->getTingkatSchool($this->session->userdata('id_school'));		

		if($tingkat['tingkat'] == 0)
		{
			$this->message->set('notice','Maaf jenjang sekolah belum ditentukan');
			redirect('dashboard');
		}

		$ta_aktif = $this->msiswa->getTaAktif();

		if($this->arey->getJenjang($tingkat['tingkat']) == "SD/MI")
		{
			$kelas = 6;
		}
		else
		{
			$kelas = 3;
		}		

		$data = array(	  		
			'main'			=> 'formAgama',
			'ket'			=> 'Form Data Agama Siswa',
			'jenis'			=> 'Tambah',
			'siswa'			=> 'select',
			'link'			=> 'simpan_agama/'.$ta_aktif['tahun'],
			'kelas'			=> $kelas,
			'jenjang'		=> $this->arey->getJenjang($tingkat['tingkat']),
			'kueri'			=> $this->msiswa->getDetailAgama($ta_aktif['tahun'],$kelas,$tingkat['tingkat'],$tingkat['kelompok'],$tingkat['jenis']),
			'jenis'			=> $tingkat['jenis'],			
		);		
		$this->load->view('template',$data);
	}

	function umur()
	{
		$kelas = 0;

		$tingkat = $this->msiswa->getTingkatSchool($this->session->userdata('id_school'));		

		if($tingkat['tingkat'] == 0)
		{
			$this->message->set('notice','Maaf jenjang sekolah belum ditentukan');
			redirect('dashboard');
		}

		$ta_aktif = $this->msiswa->getTaAktif();

		$data = array(	  		
			'main'			=> 'formUmurSiswa',
			'ket'			=> 'Form Data Umur Siswa',
			'jenis'			=> 'Tambah',
			'siswa'			=> 'select',
			'link'			=> 'simpan_umur/'.$ta_aktif['tahun'],		
			'jenjang'		=> $this->arey->getJenjang($tingkat['tingkat']),
			'kueri'			=> $this->msiswa->getDetailUmurSiswa($ta_aktif['tahun'],$tingkat['tingkat'],$tingkat['kelompok'],$tingkat['jenis']),
			'jenis'			=> $tingkat['jenis'],			
		);		
		$this->load->view('template',$data);
	}

	function asal()
	{
		$kelas = 0;

		$tingkat = $this->msiswa->getTingkatSchool($this->session->userdata('id_school'));		

		if($tingkat['tingkat'] == 0)
		{
			$this->message->set('notice','Maaf jenjang sekolah belum ditentukan');
			redirect('dashboard');
		}

		$ta_aktif = $this->msiswa->getTaAktif();

		$data = array(	  		
			'main'			=> 'formAsalSiswa',
			'ket'			=> 'Form Data Umur Siswa',
			'jenis'			=> 'Tambah',
			'siswa'			=> 'select',
			'link'			=> 'simpan_umur/'.$ta_aktif['tahun'],		
			'jenjang'		=> $this->arey->getJenjang($tingkat['tingkat']),
			'kueri'			=> $this->msiswa->getDetailAsal($ta_aktif['tahun'],$this->session->userdata('id_school')),
			'jenis'			=> $tingkat['jenis'],			
		);		
		$this->load->view('template',$data);
	}

	function simpan_siswa($id="")
	{	
		$ta_aktif = $this->msiswa->getTaAktif();

		$kueri = $this->msiswa->addDetailSiswa($ta_aktif['tahun']);
		
		if($this->db->affected_rows() > 0)
		{
			if($id == "")
			{
				$this->message->set('succes','Data siswa berhasil ditambahkan');
				redirect('siswa');
			}
			else
			{
				echo "ok";
			}			
		}
		else
		{
			if($id == "")
			{
				$this->message->set('notice','Data siswa gagal ditambahkan');
				redirect('siswa');
			}
			else
			{
				echo "gagal";
			}			
		}
	}

	function simpan_agama($id="")
	{	
		$ta_aktif = $this->msiswa->getTaAktif();

		$kueri = $this->msiswa->addDetailAgama($ta_aktif['tahun']);		
		
		if($this->db->affected_rows() > 0)
		{
			if($id == "")
			{
				$this->message->set('succes','Data agama siswa berhasil ditambahkan');
				redirect('siswa/agama');
			}
			else
			{
				echo "ok";
			}			
		}
		else
		{
			if($id == "")
			{
				$this->message->set('notice','Data agama siswa gagal ditambahkan');
				redirect('siswa/agama');
			}
			else
			{
				echo "gagal";
			}			
		}
	}

	function simpan_umur()
	{	
		$ta_aktif = $this->msiswa->getTaAktif();

		$kueri = $this->msiswa->addDetailUmurSiswa($ta_aktif['tahun']);
		
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data umur siswa berhasil ditambahkan');
			redirect('siswa/umur');		
		}
		else
		{
			$this->message->set('notice','Data umur siswa gagal ditambahkan');
			redirect('siswa/umur');			
		}
	}

	function simpan_asal()
	{
		$ta_aktif = $this->msiswa->getTaAktif();

		$kueri = $this->msiswa->addAsalSiswa($ta_aktif['tahun']);
		
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data asal siswa berhasil ditambahkan');
			redirect('siswa/asal');		
		}
		else
		{
			$this->message->set('notice','Data asal siswa gagal ditambahkan');
			redirect('siswa/asal');			
		}
	}
}