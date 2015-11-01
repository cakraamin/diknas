<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mfasilitas extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function getTingkatSchool($id)
	{
		$sql = "SELECT * FROM schools WHERE id_school='$id'";		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$hasil = $kueri->row();
			$data = array(
				'tingkat'		=> $hasil->jenjang_school
			);
		}
		else
		{
			$data = array(
				'tingkat'		=> 0
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

	function getListFasilitas($ta,$tingkat,$kode,$ids)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND b.jenjang_school='$tingkat' AND a.jenis_fasilitas='$ids'");
		$kueris = $kueri->result();
		foreach($kueris as $dt_kueris)
		{
			unset($detil);
			$detil = array();

			$detils = $this->db->query("SELECT * FROM fasilitas_school WHERE id_school='".$kode."' AND id_detail_fasilitas='".$dt_kueris->id_detail_fasilitas."' AND id_ta='$ta' ORDER BY id_fasilitas_school ASC");	
			$detile = $detils->result();			
			foreach($detile as $dt_detils)
			{
				$detil[$dt_detils->tingkat] = $dt_detils->jumlah_fasilitas;
			}

			$hasil[] = array(
				'nama_fasilitas'			=> $dt_kueris->nama_fasilitas,
				'id_fasilitas'				=> $dt_kueris->id_fasilitas,
				'id_detail_fasilitas'		=> $dt_kueris->id_detail_fasilitas,
				'detil'						=> $detil
			);
		}

		return $hasil;
	}

	function addDetailFasilitas($kode,$tahun,$no,$input)
	{
		$data = array(
			'id_fasilitas_school'		=> '',
			'id_ta'						=> $tahun,
			'id_school'					=> $this->session->userdata('id_school'),
			'id_detail_fasilitas'		=> $kode,
			'tingkat'					=> $no,
			'jumlah_fasilitas'			=> strip_tags(ascii_to_entities(addslashes($input)))
		);

		$this->db->insert('fasilitas_school', $data); 
	}

	function addTanahSekolah($id,$thn)
	{
		$data = array(
		   'id_tanah' 			=> '',
		   'id_ta'				=> $thn,
		   'id_school' 			=> $id,
		   'luas_tanah' 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('luas')))),
		   'pagar_tanah'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('pagar'))))
		);

		$this->db->insert('tanah', $data); 
	}

	function addRuangSekolah($id,$thn)
	{
		$data = array(
		   'id_ruang_kelas'		=> '',
		   'id_ta'				=> $thn,
		   'id_school' 			=> $id,
		   'j_baik'		 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('j_baik')))),
		   'l_baik'		 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('l_baik')))),
		   'j_rusak_ringan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('j_ringan')))),
		   'l_rusak_ringan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('l_ringan')))),
		   'j_rusak_berat'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('j_berat')))),
		   'l_rusak_berat'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('l_berat')))),
		   'j_bukan_milik'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('j_bukan')))),
		   'l_bukan_milik'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('l_bukan'))))
		);

		$this->db->insert('ruang_kelas', $data); 
	}

	function getListTanah($id,$thn)
	{
		$kueri = $this->db->query("SELECT * FROM tanah WHERE id_school='$id' AND id_ta='$thn' ORDER BY id_tanah DESC");
		return $kueri->row();
	}

	function getListRuang($id,$thn)
	{
		$kueri = $this->db->query("SELECT * FROM ruang_kelas WHERE id_school='$id' AND id_ta='$thn' ORDER BY id_ruang_kelas DESC");
		return $kueri->row();
	}
}
?>