<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpeta extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getLokasi($id="")	
	{
		if($id == "")
		{
			$kueri = $this->db->query("SELECT lintang_school,bujur_school,website,id_school,nss_school,npsn_school,alamat_school,nama_school FROM schools WHERE lintang_school<>'' AND bujur_school<>'' LIMIT 0,10");
		}
		else
		{
			$kueri = $this->db->query("SELECT lintang_school,bujur_school,website,id_school,nss_school,npsn_school,alamat_school,nama_school FROM schools WHERE id_school='$id'");
		}		
		$hasil = $kueri->result();

		$json = '{"wilayah": {';
		$json .= '"petak":[ ';
		foreach($hasil as $dt_hasil)
		{
			$website = isset($dt_hasil->website)?$dt_hasil->website:"-";

			$isi = "<table cellpadding='2px' cellspacing='2px'>";
			$isi .= "<tr><td width='200px'>Nama Sekolah</td><td>".$dt_hasil->nama_school."</td></tr>";
			$isi .= "<tr><td width='200px'>Nama Kepala Sekolah</td><td>".$this->getKepalaSekolah($dt_hasil->id_school)."</td></tr>";
			$isi .= "<tr><td width='200px'>NSS Sekolah</td><td>".$dt_hasil->nss_school."</td></tr>";
			$isi .= "<tr><td width='200px'>NPSN Sekolah</td><td>".$dt_hasil->npsn_school."</td></tr>";
			$isi .= "<tr><td width='200px'>Alamat Sekolah</td><td>".$dt_hasil->alamat_school."</td></tr>";
			$isi .= "<tr><td width='200px'>Website Sekolah</td><td>".$website."</td></tr>";
			$isi .= "</table>";

		    $json .= '{';
		    $json .= '"id":"'.$dt_hasil->id_school.'",
		        "judul":"'.$dt_hasil->nama_school.'",		        
		        "nss":"'.$dt_hasil->nss_school.'",
		        "npns":"'.$dt_hasil->npsn_school.'",
		        "alamat":"'.$dt_hasil->alamat_school.'",
		        "kepala":"'.$dt_hasil->nama_school.'",
		        "deskripsi":"'.$isi.'",
		        "website":"'.$website.'",
		        "x":"'.$dt_hasil->lintang_school.'",
		        "y":"'.$dt_hasil->bujur_school.'",
		        "jenis":"sekolah"
		    },';
		}
		$json = substr($json,0,strlen($json)-1);
		$json .= ']';

		$json .= '}}';
		return $json;
	}

	function getKepalaSekolah($id)
	{
		$kueri = $this->db->query("SELECT * FROM detail_schools a,guru b WHERE a.id_guru=b.id_guru AND a.id_school='$id' ORDER BY a.id_detail_school DESC LIMIT 0,1");
		$data = $kueri->row();
		$hasil = isset($data->nama_guru)?$data->nama_guru:"-";
		return $hasil;
	}	
}
?>