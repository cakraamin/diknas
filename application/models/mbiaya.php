<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbiaya extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function getDetailMasukSiswa($id,$kelas,$jenjang,$kelompok,$jenis)
	{		
		$sql = "SELECT * FROM kmasuk WHERE id_ta='$id' AND id_school='".$this->session->userdata('id_school')."' ORDER BY id_kmasuk DESC LIMIT 0,1";		
		$kueri = $this->db->query($sql);	

		return $kueri->row();
	}

	function getDetailKeluarSiswa($id,$kelas,$jenjang,$kelompok,$jenis)
	{		
		$sql = "SELECT * FROM kkeluar WHERE id_ta='$id' AND id_school='".$this->session->userdata('id_school')."' ORDER BY id_keluar DESC LIMIT 0,1";		
		$kueri = $this->db->query($sql);	

		return $kueri->row();
	}

	function getTingkatSchool($id)
	{
		$sql = "SELECT * FROM schools WHERE id_school='$id'";				
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$hasil = $kueri->row();
			$data = array(
				'tingkat'		=> $hasil->jenjang_school,
				'kelompok'		=> $hasil->kelompok_school,
				'jenis'			=> $hasil->tingkat_school
			);
		}
		else
		{
			$data = array(
				'tingkat'		=> 0,
				'kelompok'		=> 0,
				'jenis'			=> 0
			);
		}

		return $data;
	}

	function getTaAktif()
	{
		$kueri = $this->db->query("SELECT * FROM tahun_ajaran WHERE status_ta='1'");
		if($kueri->num_rows() > 0)
		{
			$hasil = $kueri->row();

			$data = array(
				'tahun'		=> $hasil->id_ta
			);
		}
		else
		{
			$data = array(
				'tahun'		=> '0'
			);
		}

		return $data;
	}

	function addBiayaMasuk($id)		
	{
		$data = array(
			'id_kmasuk'		 	=> '',
		   	'id_school'		 	=> $this->session->userdata('id_school'),
		   	'id_ta'			 	=> $id,
		   	'saldo_awal'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('saldo_awal',TRUE)))),
		   	'pemda'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('pemda',TRUE)))),
		   	'prov'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('prov',TRUE)))),
		   	'bos'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bos',TRUE)))),
		   	'bos_buku'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('bos_buku',TRUE)))),
		   	'bomm'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bomm',TRUE)))),
		   	'bkm'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bkm',TRUE)))),
		   	'bop'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bop',TRUE)))),
		   	'yayasan'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('yayasan',TRUE)))),
		   	'lembaga_swasta'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('lembaga_swasta',TRUE)))),
		   	'orang_tua'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('orang_tua',TRUE)))),
		   	'up_smk'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('up_smk',TRUE)))),
		   	'sumber_lain'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('sumber_lain',TRUE)))),
		);

		$this->db->insert('kmasuk', $data);
	}

	function updateBiayaMasuk($id,$kode)		
	{
		$data = array(					   	
		   	'saldo_awal'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('saldo_awal',TRUE)))),
		   	'pemda'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('pemda',TRUE)))),
		   	'prov'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('prov',TRUE)))),
		   	'bos'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bos',TRUE)))),
		   	'bos_buku'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('bos_buku',TRUE)))),
		   	'bomm'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bomm',TRUE)))),
		   	'bkm'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bkm',TRUE)))),
		   	'bop'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('bop',TRUE)))),
		   	'yayasan'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('yayasan',TRUE)))),
		   	'lembaga_swasta'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('lembaga_swasta',TRUE)))),
		   	'orang_tua'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('orang_tua',TRUE)))),
		   	'up_smk'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('up_smk',TRUE)))),
		   	'sumber_lain'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('sumber_lain',TRUE)))),
		);
		
		$this->db->where('id_kmasuk', $kode);
		$this->db->update('kmasuk', $data); 
	}

	function addBiayaKeluar($id)		
	{
		$data = array(
			'id_keluar'		 	=> '',
		   	'id_school'		 	=> $this->session->userdata('id_school'),
		   	'id_ta'			 	=> $id,
		   	'gaji_guru'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('gaji_guru',TRUE)))),
		   	'gaji_karyawan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('gaji_karyawan',TRUE)))),
		   	'kbm'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('kbm',TRUE)))),
		   	'sarpras'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('sarpras',TRUE)))),
		   	'rehab'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('rehab',TRUE)))),
		   	'pengadaan_sarpras'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('pengadaan_sarpras',TRUE)))),
		   	'ekstra'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('ekstra',TRUE)))),
		   	'jasa'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('jasa',TRUE)))),
		   	'tu'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('tu',TRUE)))),
		   	'lain'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('lain',TRUE)))),
		   	'saldo'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('saldo',TRUE))))		   	
		);

		$this->db->insert('kkeluar', $data);
	}

	function updateBiayaKeluar($id,$kode)		
	{
		$data = array(			
		   	'gaji_guru'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('gaji_guru',TRUE)))),
		   	'gaji_karyawan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('gaji_karyawan',TRUE)))),
		   	'kbm'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('kbm',TRUE)))),
		   	'sarpras'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('sarpras',TRUE)))),
		   	'rehab'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('rehab',TRUE)))),
		   	'pengadaan_sarpras'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('pengadaan_sarpras',TRUE)))),
		   	'ekstra'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('ekstra',TRUE)))),
		   	'jasa'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('jasa',TRUE)))),
		   	'tu'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('tu',TRUE)))),
		   	'lain'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('lain',TRUE)))),
		   	'saldo'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('saldo',TRUE))))		   	
		);

		$this->db->where('id_keluar', $kode);
		$this->db->update('kkeluar', $data); 
	}
}
?>