<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mglobal extends CI_Model
{
	function Mglobal()
	{
		parent::__construct();
	}

	function getStatusSkule($id)	
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_school='$id'");
		$hasil = $kueri->row();

		if(isset($hasil->jenjang_school) && ($hasil->jenjang_school == 3 || $hasil->jenjang_school == 4))
		{
			$statuse = 1;
		}
		else
		{
			$statuse = 0;	
		}

		return $statuse;
	}

	function getNamaSkulUser($id)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE npsn_school='$id'");
		$data = $kueri->row();
		$nilai = (isset($data->nama_school))?$data->nama_school:"Maaf";
		return $nilai;
	}
}
?>