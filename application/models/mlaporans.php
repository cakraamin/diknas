<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlaporans extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}	

	public function getTahun()
	{
		$query = $this->db->query("SELECT * FROM tahun_ajaran ORDER BY id_ta ASC");

		if ($query->num_rows()> 0)
		{
			foreach ($query->result_array() as $row)
			{
				$tahun = substr($row['nama_ta'], 0,4);				
				$tahuns = intval($tahun)+1;
				$data[$row['id_ta']] = $tahun." / ".$tahuns;
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	public function getTahune($id)
	{
		$kueri = $this->db->query("SELECT * FROM tahun_ajaran WHERE id_ta='$id'");
		$row = $kueri->row();
		$dt_tahun = (isset($row->nama_ta))?$row->nama_ta:"2014";
		$tahun = substr($dt_tahun, 0,4);				
		$tahuns = intval($tahun)+1;
		$tahune = $tahun." / ".$tahuns;
		return $tahune;
	}

	public function getSdNegeri($status)
	{
		$hasil = array();
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumSd($dt_kec->id_kecamatan,1,$status),
				'2'			=> $this->getAkre($dt_kec->id_kecamatan,1,$status),
				'3'			=> $this->getWaktu($dt_kec->id_kecamatan,1,$status),
				'4'			=> $this->getGugus($dt_kec->id_kecamatan,1,$status),
				'5'			=> $this->getMbs($dt_kec->id_kecamatan,1,$status),
				'6'			=> $this->getKurikulum($dt_kec->id_kecamatan,1,$status),
			);
		}

		return $hasil;
	}	

	private function jumSd($id,$kode,$status)
	{
		$status = ($status == 3)?"":" AND status_school='$status' ";
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' $status AND jenjang_school='1'");
		return $kueri->num_rows();
	}

	private function getAkre($id,$kode,$status)
	{
		$hasil = array();
		$akre = $this->arey->getAkreditasi();
		$status = ($status == 3)?"":" AND status_school='$status' ";
		foreach($akre as $key => $dt_akre)
		{
			$akk = $this->db->query("SELECT * FROM schools WHERE akre_school='$key' AND id_kecamatan='$id' $status AND jenjang_school='1'");
			$hasil[$key] = $akk->num_rows();
		}
		return $hasil;
	}

	private function getWaktu($id,$kode,$status)
	{
		$hasil = array();
		$waktu = $this->arey->getWaktu();
		$status = ($status == 3)?"":" AND status_school='$status' ";
		foreach($waktu as $key => $dt_waktu)
		{
			$wkt = $this->db->query("SELECT * FROM schools WHERE waktu_wp='$key' AND id_kecamatan='$id' $status AND jenjang_school='1'");
			$hasil[$key] = $wkt->num_rows();
		}
		return $hasil;
	}

	private function getGugus($id,$kode,$status)
	{
		$hasil = array();
		$gugus = $this->arey->getGugus();
		$status = ($status == 3)?"":" AND status_school='$status' ";
		foreach($gugus as $key => $dt_gugus)
		{
			$ggs = $this->db->query("SELECT * FROM schools WHERE gugus_school='$key' AND id_kecamatan='$id' $status AND jenjang_school='1'");
			$hasil[$key] = $ggs->num_rows();
		}
		return $hasil;
	}

	private function getMbs($id,$kode,$status)
	{
		$status = ($status == 3)?"":" AND status_school='$status' ";
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND mbs_school='1' $status AND jenjang_school='1'");
		return $kueri->num_rows();
	}

	private function getKurikulum($id,$kode,$status)
	{
		$hasil = array();
		$kurik = $this->arey->getKurikulum();
		$status = ($status == 3)?"":" AND status_school='$status' ";
		foreach($kurik as $key => $dt_kurik)
		{
			$kur = $this->db->query("SELECT * FROM schools WHERE kurikulum_school='$key' AND id_kecamatan='$id' $status AND jenjang_school='1'");
			$hasil[$key] = $kur->num_rows();
		}
		return $hasil;
	}

	public function getSheedDuaNegeri($tahun,$status)
	{
		$hasil = array();				
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumDaftarSd($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'2'			=> $this->getUmur($dt_kec->id_kecamatan,1,$tahun,1,1,1,$status),
				'3'			=> $this->getTingkat($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'4'			=> $this->getUmur($dt_kec->id_kecamatan,1,$tahun,2,1,1,$status)
			);
		}

		return $hasil;
	}

	private function jumDaftarSd($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();
		$status = ($status == 3)?"":" AND a.status_school='$status' ";
		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$sql = "SELECT SUM(c.daftar_no_tk_lk) as satu,SUM(c.daftar_no_tk_pr) as dua,SUM(c.daftar_tk_lk) as tiga,SUM(c.daftar_tk_pr) as empat,SUM(c.peserta_no_tk_lk) as lima,SUM(c.peserta_no_tk_pr) as enam,SUM(c.peserta_tk_lk) as tujuh,SUM(c.peserta_tk_pr) as delapan FROM schools a,siswa b,tk c WHERE a.id_school=b.id_school AND b.id_siswa=c.id_siswa AND b.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'1'		=> (isset($data->satu))?$data->satu:0,
			'2'		=> (isset($data->dua))?$data->dua:0,
			'3'		=> (isset($data->tiga))?$data->tiga:0,
			'4'		=> (isset($data->empat))?$data->empat:0,
			'5'		=> (isset($data->lima))?$data->lima:0,
			'6'		=> (isset($data->enam))?$data->enam:0,
			'7'		=> (isset($data->tujuh))?$data->tujuh:0,
			'8'		=> (isset($data->delapan))?$data->delapan:0,
		);

		return $hasil;
	}

	private function getUmur($id,$kode,$tahun,$jenis,$ids,$jenjang,$statuse)
	{
		if($jenis == 1)
		{
			$umur = array(16,17,18,19,20,21);
		}	
		elseif($jenis == 2)
		{			
			$umur = array(22,23,24,25,26,27,28,29);
		}
		elseif($jenis == 3)
		{			
			$umur = array(37,38,39,40,41,42,43,44,45,46,47);
		}
		else
		{
			$umur = array(30,31,32,33,34,35,36);	
		}
		$hasil = array();

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";		

		foreach($umur as $detail)
		{
			$sql = "SELECT SUM(c.laki_detail_siswa) as lk,SUM(c.pr_detail_siswa) as pr FROM umur a,detail_umur b,detail_siswa c,siswa d,schools e WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_siswa=d.id_siswa AND d.id_school=e.id_school AND d.id_ta='$tahun' AND e.id_kecamatan='$id' AND e.status_school='$statuse' AND a.id_umur='$detail' AND e.jenjang_school='$jenjang'";
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[] = array(
				'1'		=> (isset($data->lk))?$data->lk:0,
				'2'		=> (isset($data->pr))?$data->pr:0,				
			);			
		}		

		return $hasil;
	}

	private function getTingkat($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();

		$jum = ($jenjang == 1)?6:3;
		$ids = ($ids == 1)?"AND b.id_kecamatan='$id'":"AND b.id_school='$id'";		

		for($i=1;$i<=$jum;$i++)
		{
			if($status == 1 || $status == 2)
			{
				$sql = "SELECT SUM(a.laki_siswa) as lk,SUM(perempuan_siswa) as pr FROM siswa a,schools b WHERE a.id_school=b.id_school AND a.id_ta='$tahun' $ids AND a.id_tingkat='$i' AND b.jenjang_school='1' AND b.status_school='$status'";
			}			
			else
			{
				$sql = "SELECT SUM(a.laki_siswa) as lk,SUM(perempuan_siswa) as pr FROM siswa a,schools b WHERE a.id_school=b.id_school AND a.id_ta='$tahun' $ids AND a.id_tingkat='$i' AND b.jenjang_school='1'";
			}
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[] = array(
				'1'		=> (isset($data->lk))?$data->lk:0,
				'2'		=> (isset($data->pr))?$data->pr:0,				
			);
		}

		return $hasil;
	}

	public function getSheedTigaNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumAgama($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'2'			=> $this->jumMasalah($dt_kec->id_kecamatan,1,$tahun,'b.mengulang_siswa',1,1,$status),
				'3'			=> $this->jumMasalah($dt_kec->id_kecamatan,1,$tahun,'b.putus_siswa',1,1,$status),
				'4'			=> $this->jumRombel($dt_kec->id_kecamatan,1,$tahun,1,1,$status)
			);
		}

		return $hasil;
	}	

	private function jumAgama($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();
		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";
		$sql = "SELECT SUM(b.islam) as islam,SUM(b.kristen) as kristen,SUM(b.katholik) as katholik,SUM(b.budha) as budha,SUM(b.hindu) as hindu,SUM(b.konghuchu) as konghuchu FROM schools a,agama b WHERE a.id_school=b.id_school AND b.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'1'		=> (isset($data->islam))?$data->islam:0,
			'2'		=> (isset($data->kristen))?$data->kristen:0,
			'3'		=> (isset($data->katholik))?$data->katholik:0,
			'4'		=> (isset($data->budha))?$data->budha:0,
			'5'		=> (isset($data->hindu))?$data->hindu:0,
			'6'		=> (isset($data->konghuchu))?$data->konghuchu:0,			
		);

		return $hasil;
	}

	private function jumMasalah($id,$kode,$tahun,$ket,$ids,$jenjang,$status)
	{		
		$hasil = array();

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";		
		$jjg = ($jenjang == 1)?6:3;
		for($i=1;$i<=$jjg;$i++)
		{
			if($status == 1 || $status == 2)
			{
				$sql = "SELECT SUM(".$ket."_laki) as laki,SUM(".$ket."_pr) as pr FROM schools a,siswa b WHERE a.id_school=b.id_school AND b.id_ta='$tahun' $ids AND b.id_tingkat='$i' AND a.jenjang_school='$jenjang' AND a.status_school='$status'";			
			}
			else
			{
				$sql = "SELECT SUM(".$ket."_laki) as laki,SUM(".$ket."_pr) as pr FROM schools a,siswa b WHERE a.id_school=b.id_school AND b.id_ta='$tahun' $ids AND b.id_tingkat='$i' AND a.jenjang_school='$jenjang'";			
			}			
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[$i] = array(
				'lk'		=> (isset($data->laki))?$data->laki:0,
				'pr'		=> (isset($data->pr))?$data->pr:0,				
			);
		}		

		return $hasil;
	}

	private function jumRombel($id,$kode,$tahun,$ids,$jenjang,$status)
	{		
		$hasil = array();
		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		$jum = ($jenjang == 1)?6:3;
		for($i=1;$i<=$jum;$i++)
		{
			$sql = "SELECT SUM(b.rombel_siswa) as jumlah FROM schools a,siswa b WHERE a.id_school=b.id_school AND b.id_ta='$tahun' $ids AND b.id_tingkat='$i' AND a.jenjang_school='$jenjang' $status";			
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[$i] = (isset($data->jumlah))?$data->jumlah:0;
		}		

		return $hasil;
	}

	public function getSheedEmpatNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumPesertaLulus($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'2'			=> $this->jumMapelSd($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'3'			=> $this->jumRuangKelas($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'4'			=> $this->jumSarpras($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
				'5'			=> $this->jumAsal($dt_kec->id_kecamatan,$tahun,1,1,$status)
			);
		}

		return $hasil;		
	}

	private function jumAsal($id,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();			
		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		$sql = "SELECT SUM(b.dalam_kota) as dalam,SUM(b.luar_kota) as luar FROM schools a,asal_school b WHERE a.id_school=b.id_school AND b.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status ";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'dalam'		=> (isset($data->dalam))?$data->dalam:0,
			'luar'		=> (isset($data->luar))?$data->luar:0
		);		

		return $hasil;		
	}

	private function jumPesertaLulus($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();
		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";
		$sql = "SELECT SUM(b.peserta_l) as peserta_l,SUM(b.peserta_p) as peserta_p,SUM(b.lulus_l) as lulus_l,SUM(b.lulus_p) as lulus_p FROM schools a,prodi_school b,siswa c WHERE a.id_school=b.id_school AND b.id_siswa=c.id_siswa AND c.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status ";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'1'		=> (isset($data->peserta_l))?$data->peserta_l:0,
			'2'		=> (isset($data->peserta_p))?$data->peserta_p:0,
			'3'		=> (isset($data->lulus_l))?$data->lulus_l:0,
			'4'		=> (isset($data->lulus_p))?$data->lulus_p:0,			
		);

		return $hasil;
	}

	private function jumMapelSd($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();

		if($jenjang == 1)
		{
			$mapel = array(10,11,12,13,14,15,16,17,18,20);
		}
		else
		{
			$mapel = array(9,10,11);
		}		

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($mapel as $i => $detail_mapel)
		{
			$sql = "SELECT SUM(d.nilai_mapel) as jumlah FROM schools a,mapel b,detail_mapel c,mapel_school d WHERE a.id_school=d.id_school AND b.id_mapel=c.id_mapel AND c.id_detail_mapel=d.id_detail_mapel AND d.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status ";
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[$i] = (isset($data->jumlah))?$data->jumlah:0;			
		}

		return $hasil;
	}

	private function jumRuangKelas($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		$sql = "SELECT SUM(b.j_baik) as j_baik,SUM(b.j_rusak_ringan) as j_rusak_ringan,SUM(b.j_rusak_berat) as j_rusak_berat,SUM(b.j_bukan_milik) as j_bukan_milik,SUM(b.l_baik) as l_baik,SUM(b.l_rusak_ringan) as l_rusak_ringan,SUM(b.l_rusak_berat) as l_rusak_berat,SUM(b.l_bukan_milik) as l_bukan_milik FROM schools a,ruang_kelas b WHERE a.id_school=b.id_school AND b.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status ";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'1'		=> array(
					'jumlah'	=> (isset($data->j_baik))?$data->j_baik:0,
					'luas'		=> (isset($data->l_baik))?$data->l_baik:0,
				),
			'2'		=> array(
					'jumlah'	=> (isset($data->j_rusak_ringan))?$data->j_rusak_ringan:0,
					'luas'		=> (isset($data->l_rusak_ringan))?$data->l_rusak_ringan:0,
				),
			'3'		=> array(
					'jumlah'	=> (isset($data->j_rusak_berat))?$data->j_rusak_berat:0,
					'luas'		=> (isset($data->l_rusak_berat))?$data->l_rusak_berat:0,
				),
			'4'		=> array(
					'jumlah'	=> (isset($data->j_bukan_milik))?$data->j_bukan_milik:0,
					'luas'		=> (isset($data->l_bukan_milik))?$data->l_bukan_milik:0,
				)			
		);

		return $hasil;
	}

	private function jumSarpras($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();
		if($jenjang == 1)
		{
			$mapel = array(89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105);
		}
		else
		{
			$mapel = array(90,128,129,130,131,132,93,134,89,106,107,95,108,109,135,110,136,111,112,91,92,113,133,114,115,116,117,98,94,118,119,120,121,122,123,124,125,126,127);
		}		
		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($mapel as $i => $detail_mapel)
		{
			$sql = "SELECT SUM(d.jumlah_fasilitas) as jumlah FROM schools a,fasilitas b,detail_fasilitas c,fasilitas_school d WHERE a.id_school=d.id_school AND b.id_fasilitas=c.id_fasilitas AND c.id_detail_fasilitas=d.id_detail_fasilitas AND d.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status ";		
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[$i] = (isset($data->jumlah))?$data->jumlah:0;			
		}

		return $hasil;		
	}

	public function getSheedLimaNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumKepsek($dt_kec->id_kecamatan,1,$tahun,$status),
				'2'			=> $this->jumKepsekGuru($dt_kec->id_kecamatan,1,$status),
				'3'			=> $this->jumKepsekDidik($dt_kec->id_kecamatan,1,$tahun,$status),
				'4'			=> $this->jumKepsekStatus($dt_kec->id_kecamatan,1,$tahun,$status),
				'5'			=> $this->jumKepsekUmur($dt_kec->id_kecamatan,1,$tahun,$status)
			);
		}

		return $hasil;
	}	

	private function jumKepsek($id,$kode,$tahun,$status)
	{
		$hasil = array();
		$kepsek = array(" AND c.status_guru='2' AND c.status_peg<>'5' "," AND c.status_guru='2' AND c.status_peg='5' ");
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($kepsek as $detail)
		{
			$sql = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' $detail GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri = $this->db->query($sql);
			$hasil[] = $kueri->num_rows();
		}		

		return $hasil;
	}

	private function jumKepsekGuru($id,$kode,$status)
	{
		$hasil = array();
		$guru = array("1","3","2","17","31");
		$status = ($status == 3)?"":" AND a.status_school='$status' ";
		$kepsek = array(" AND b.status_guru='2' AND b.status_peg<>'5' "," AND b.status_guru='2' AND b.status_peg='5' ");

		foreach($guru as $i => $dt_guru)
		{
			unset($jumlahe);
			$jumlahe = array();
			foreach($kepsek as $detail)
			{
				$sql = "SELECT b.id_guru FROM schools a,guru b WHERE a.id_school=b.id_school AND a.id_kecamatan='$id' $status $detail AND b.id_jabatan='$dt_guru' AND a.jenjang_school='1'";		
				$kueri = $this->db->query($sql);
				$jumlahe[] = $kueri->num_rows();

			}
			$hasil[$i] = $jumlahe;
		}

		return $hasil;
	}

	private function jumKepsekDidik($id,$kode,$tahun,$status)
	{
		$hasil = array();
		$pendidikan = $this->arey->getPendidikan();
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($pendidikan as $i => $detail)
		{
			$sql_lk = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' AND c.pend_guru='$i' AND c.jenis_kel<>'2' GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri_lk = $this->db->query($sql_lk);
			$sql_pr = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' AND c.pend_guru='$i' AND c.jenis_kel='2' GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri_pr = $this->db->query($sql_pr);
			$hasil[] = array(
				'lk'		=> $kueri_lk->num_rows(),
				'pr'		=> $kueri_pr->num_rows()
			);
		}		

		return $hasil;
	}

	private function jumKepsekStatus($id,$kode,$tahun,$status)
	{
		$hasil = array();
		$status = array('2','3','4','5');
		$statuse = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($status as $detail)
		{
			$sql_lk = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $statuse AND a.jenjang_school='1' AND c.status_guru='2' AND c.status_peg='$detail' AND c.jenis_kel<>'2' GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri_lk = $this->db->query($sql_lk);
			$sql_pr = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $statuse AND a.jenjang_school='1' AND c.status_guru='2' AND c.status_peg='$detail' AND c.jenis_kel='2' GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri_pr = $this->db->query($sql_pr);
			$hasil[] = array(
				'lk'		=> $kueri_lk->num_rows(),
				'pr'		=> $kueri_pr->num_rows()
			);
		}		

		return $hasil;
	}

	private function jumKepsekUmur($id,$kode,$tahun,$status)
	{
		$hasil = array();
		$umur = array(' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<20 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>20 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<29 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>30 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<39 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>40 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<49 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>50 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<59 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>59 ');
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($umur as $detail)
		{
			$sql_lk = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' AND c.jenis_kel<>'2' $detail GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri_lk = $this->db->query($sql_lk);
			$sql_pr = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' AND c.jenis_kel='2' $detail GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri_pr = $this->db->query($sql_pr);
			$hasil[] = array(
				'lk'		=> $kueri_lk->num_rows(),
				'pr'		=> $kueri_pr->num_rows()
			);
		}		

		return $hasil;
	}

	public function getSheedEnamNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumKepsekTmt($dt_kec->id_kecamatan,1,$tahun,$status),				
				'2'			=> $this->jumGuruDidik($dt_kec->id_kecamatan,1,1,1,$status),
				'3'			=> $this->jumGuruStatus($dt_kec->id_kecamatan,1,1,1,$status)				
			);
		}

		return $hasil;
	}	

	private function jumKepsekTmt($id,$kode,$tahun,$status)
	{
		$hasil = array();
		$umur = array(' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<5 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>5 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<9 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>10 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<14 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>15 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<19 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>20 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<24 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>24 ');
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($umur as $detail)
		{
			$sql = "SELECT a.id_school FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND b.id_ta_school='$tahun' AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' $detail GROUP BY a.id_school ORDER BY id_detail_school DESC";		
			$kueri = $this->db->query($sql);			
			$hasil[] = $kueri->num_rows();
		}		

		return $hasil;
	}

	private function jumGuruDidik($id,$kode,$ids,$jenjang,$status)
	{
		$hasil = array();
		$pendidikan = $this->arey->getPendidikan();

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($pendidikan as $i => $detail)
		{
			$sql_lk = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND c.pend_guru='$i' AND c.jenis_kel<>'2' AND (c.status_guru='2' OR c.status_guru='3') AND a.jenjang_school='$jenjang' $status";					
			$kueri_lk = $this->db->query($sql_lk);
			$sql_pr = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND c.pend_guru='$i' AND c.jenis_kel='2' AND (c.status_guru='2' OR c.status_guru='3') AND a.jenjang_school='$jenjang' $status ";		
			$kueri_pr = $this->db->query($sql_pr);
			$hasil[] = array(
				'lk'		=> $kueri_lk->num_rows(),
				'pr'		=> $kueri_pr->num_rows()
			);
		}		

		return $hasil;
	}

	private function jumGuruStatus($id,$kode,$ids,$jenjang,$status)
	{
		$hasil = array();
		$umur = array(' AND c.status_guru="2" AND c.status_peg="2" ',' AND c.status_guru="2" AND c.status_peg="3" ',' AND c.status_guru="2" AND c.status_peg="4" ',' AND c.status_guru="2" AND c.status_peg="5" ',' AND c.status_guru="3" ',' AND c.status_guru="6" ',' AND c.status_guru="7" ');

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($umur as $detail)
		{
			$sql_lk = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND c.jenis_kel<>'2' $status  AND a.jenjang_school='$jenjang' $detail";					
			$kueri_lk = $this->db->query($sql_lk);
			$sql_pr = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND c.jenis_kel='2' $status AND a.jenjang_school='$jenjang' $detail";		
			$kueri_pr = $this->db->query($sql_pr);
			$hasil[] = array(
				'lk'		=> $kueri_lk->num_rows(),
				'pr'		=> $kueri_pr->num_rows()
			);
		}		

		return $hasil;
	}

	public function getSheedTujuhNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumGuruUmur($dt_kec->id_kecamatan,1,1,1,$status),				
				'2'			=> $this->jumGuruTmt($dt_kec->id_kecamatan,1,1,1,$status),
				'3'			=> $this->jumTenagaAdministrasi($dt_kec->id_kecamatan,1,$status),
				'4'			=> $this->jumGolAdministrasi($dt_kec->id_kecamatan,1,1,1,1,$status),
				'5'			=> $this->jumHonorAdministrasi($dt_kec->id_kecamatan,1,1,1,1,$status)
			);
		}

		return $hasil;
	}	

	private function jumGuruUmur($id,$kode,$ids,$jenjang,$status)
	{
		$hasil = array();
		$umur = array(' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<20 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>20 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<29 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>30 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<39 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>40 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<49 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>50 AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())<59 ',' AND TIMESTAMPDIFF(YEAR,c.tgl_lahir,CURDATE())>59 ');

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($umur as $detail)
		{
			$sql_lk = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND c.jenis_kel<>'2' $status AND a.jenjang_school='$jenjang' $detail";		
			$kueri_lk = $this->db->query($sql_lk);
			$sql_pr = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND c.jenis_kel='2' $status AND a.jenjang_school='$jenjang' $detail";		
			$kueri_pr = $this->db->query($sql_pr);
			$hasil[] = array(
				'lk'		=> $kueri_lk->num_rows(),
				'pr'		=> $kueri_pr->num_rows()
			);
		}		

		return $hasil;
	}

	private function jumGuruTmt($id,$kode,$ids,$jenjang,$status)
	{
		$hasil = array();
		$umur = array(' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<5 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>5 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<9 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>10 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<14 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>15 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<19 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>20 AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())<24 ',' AND TIMESTAMPDIFF(YEAR,c.tmt_guru,CURDATE())>24 ');

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";		

		foreach($umur as $detail)
		{
			if($status == 1 || $status == 2)
			{
				$sql = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND a.status_school='$status' AND a.jenjang_school='$jenjang' $detail";		
			}			
			else
			{
				$sql = "SELECT a.id_school FROM schools a,guru c WHERE a.id_school=c.id_school $ids AND a.jenjang_school='$jenjang' $detail";		
			}
			$kueri = $this->db->query($sql);			
			$hasil[] = $kueri->num_rows();
		}		

		return $hasil;
	}

	private function jumTenagaAdministrasi($id,$kode,$status)
	{
		$hasil = array();
		$tenaga = array(' AND (b.status_guru="1" OR b.status_guru="4" OR b.status_guru="5") ',' AND (b.status_guru="1" OR b.status_guru="4" OR b.status_guru="5") AND b.status_peg="5" ',' AND (b.status_guru="1" OR b.status_guru="4" OR b.status_guru="5") AND b.status_peg="8" ');
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($tenaga as $dt_tenaga)
		{
			unset($detil);
			$detil = array();
			$didik = array(' AND (b.pend_guru="10" OR b.pend_guru="11")  ',' AND (b.pend_guru="1" OR b.pend_guru="2") ',' AND (b.pend_guru<>"1" OR b.pend_guru<>"2" OR b.pend_guru<>"10" OR b.pend_guru<>"11") ');
			foreach($didik as $dt_didik)
			{
				$sql = "SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND a.id_kecamatan='$id' $status AND a.jenjang_school='1' $dt_tenaga $dt_didik";
				$kueri = $this->db->query($sql);
				$detil[] = $kueri->num_rows();
			}
			$hasil[] = $detil;
		}

		return $hasil;
	}

	private function jumGolAdministrasi($id,$kode,$jenis,$ids,$jenjang,$status)
	{
		$hasil = array();
		if($jenis == 1)
		{
			$tenaga = array(' AND (b.status_guru="1" OR b.status_guru="4" OR b.status_guru="5") ',' AND (b.status_guru="1" OR b.status_guru="4" OR b.status_guru="5") AND b.status_peg="5" ');
		}
		else
		{
			$tenaga = array(' AND (b.status_guru="1" OR b.status_guru="4" OR b.status_guru="5") AND b.status_peg="8" ');
		}		

		$ids = ($ids == 1)?"a.id_kecamatan='$id'":"a.id_school='$id'";		

		foreach($tenaga as $dt_tenaga)
		{
			unset($detil);
			$detil = array();
			$didik = array(' AND b.status_peg="1" ',' AND b.status_peg="2" ',' AND b.status_peg="3" ',' AND b.status_peg="4" ',' AND b.status_peg="5" ');
			foreach($didik as $dt_didik)
			{
				if($status == 1 || $status == 2)
				{
					$sql = "SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND $ids AND a.status_school='$status' AND a.jenjang_school='$jenjang' $dt_tenaga $dt_didik";
				}				
				else
				{
					$sql = "SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND $ids AND a.jenjang_school='$jenjang' $dt_tenaga $dt_didik";
				}
				$kueri = $this->db->query($sql);
				$detil[] = $kueri->num_rows();
			}
			$hasil[] = $detil;
		}

		return $hasil;
	}

	private function jumHonorAdministrasi($id,$kode,$jenis,$ids,$jenjang,$status)
	{
		$hasil = array();
		if($jenis == 1)
		{
			$tenaga = array(' AND b.status_guru="4" ',' AND b.status_guru="4" AND b.status_peg="5" ');
		}
		else
		{
			$tenaga = array(' AND b.status_guru="4" AND b.status_peg="8" ');
		}		

		$ids = ($ids == 1)?"a.id_kecamatan='$id'":"a.id_school='$id'";		

		foreach($tenaga as $dt_tenaga)
		{
			if($status == 1 || $status == 2)
			{
				$sql = "SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND $ids AND a.status_school='$status' AND a.jenjang_school='$jenjang' $dt_tenaga";
			}			
			else
			{
				$sql = "SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND $ids AND a.jenjang_school='$jenjang' $dt_tenaga";
			}
			$kueri = $this->db->query($sql);			
			$hasil[] = $kueri->num_rows();
		}

		return $hasil;
	}

	public function getSheedDelepanNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumGolAdministrasi($dt_kec->id_kecamatan,1,2,1,1,$status),
				'2'			=> $this->jumHonorAdministrasi($dt_kec->id_kecamatan,1,2,1,1,$status),
				'3'			=> $this->jumPenerimaan($dt_kec->id_kecamatan,1,$tahun,1,1,$status)				
			);
		}

		return $hasil;
	}	

	private function jumPenerimaan($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();

		$this->db->select_sum('kmasuk.saldo_awal');
		$this->db->select_sum('kmasuk.pemda');
		$this->db->select_sum('kmasuk.prov');
		$this->db->select_sum('kmasuk.bos');
		$this->db->select_sum('kmasuk.bos_buku');
		$this->db->select_sum('kmasuk.bomm');
		$this->db->select_sum('kmasuk.bkm');
		$this->db->select_sum('kmasuk.bop');
		$this->db->select_sum('kmasuk.yayasan');
		$this->db->select_sum('kmasuk.lembaga_swasta');
		$this->db->select_sum('kmasuk.orang_tua');
		$this->db->select_sum('kmasuk.up_smk');
		$this->db->select_sum('kmasuk.sumber_lain');
		$this->db->from('schools');
		$this->db->join('kmasuk', 'schools.id_school = kmasuk.id_school');
		if($ids == 1)
		{
			$this->db->where('schools.id_kecamatan', $id); 
		}
		else
		{
			$this->db->where('schools.id_school', $id); 
		}
		$this->db->where('schools.jenjang_school', $jenjang); 		

		if($status == 1 || $status == 2)
		{
			$this->db->where('schools.status_school', $status);
		}

		$this->db->where('kmasuk.id_ta', $tahun); 
		$kueri = $this->db->get();
		foreach($kueri->result() as $detail)
		{
			$hasil[] = array(
				'1'			=> (isset($detail->saldo_awal))?$detail->saldo_awal:0,
				'2'			=> (isset($detail->bos))?$detail->bos:0,
				'3'			=> (isset($detail->prov))?$detail->prov:0,
				'4'			=> (isset($detail->pemda))?$detail->pemda:0,
				'5'			=> (isset($detail->orang_tua))?$detail->orang_tua:0,
				'6'			=> (isset($detail->yayasan))?$detail->yayasan:0,
				'7'			=> (isset($detail->sumber_lain))?$detail->sumber_lain:0,
				'8'			=> (isset($detail->bos_buku))?$detail->bos_buku:0,
				'9'			=> (isset($detail->bomm))?$detail->bomm:0,
				'10'		=> (isset($detail->bkm))?$detail->bkm:0,
				'11'		=> (isset($detail->bop))?$detail->bop:0,				
				'12'		=> (isset($detail->lembaga_swasta))?$detail->lembaga_swasta:0,	
				'13'		=> (isset($detail->up_smk))?$detail->up_smk:0,	
			);
		}

		return $hasil;		
	}

	public function getSheedSembilanNegeri($tahun,$status)
	{
		$hasil = array();		
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");

		$kec = $kueri->result();
		foreach($kec as $dt_kec)
		{
			$hasil[] = array(
				'nama'		=> $dt_kec->nama_kecamatan,
				'kode'		=> $dt_kec->kode_kecamatan,
				'1'			=> $this->jumPengeluaran($dt_kec->id_kecamatan,1,$tahun,1,1,$status),
			);
		}

		return $hasil;
	}	

	private function jumPengeluaran($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();

		$this->db->select_sum('kkeluar.gaji_guru');
		$this->db->select_sum('kkeluar.gaji_karyawan');
		$this->db->select_sum('kkeluar.kbm');
		$this->db->select_sum('kkeluar.sarpras');
		$this->db->select_sum('kkeluar.rehab');
		$this->db->select_sum('kkeluar.pengadaan_sarpras');
		$this->db->select_sum('kkeluar.ekstra');
		$this->db->select_sum('kkeluar.jasa');
		$this->db->select_sum('kkeluar.tu');
		$this->db->select_sum('kkeluar.lain');
		$this->db->select_sum('kkeluar.saldo');		
		$this->db->from('schools');
		$this->db->join('kkeluar', 'schools.id_school = kkeluar.id_school');
		if($ids == 1)
		{
			$this->db->where('schools.id_kecamatan', $id); 
		}
		else
		{
			$this->db->where('schools.id_school', $id); 
		}		
		$this->db->where('schools.jenjang_school', $jenjang); 

		if($status == 1 || $status == 2)
		{
			$this->db->where('schools.status_school', $status);
		}
		
		$this->db->where('kkeluar.id_ta', $tahun); 
		$kueri = $this->db->get();
		foreach($kueri->result() as $detail)
		{
			$hasil[] = array(
				'1'			=> (isset($detail->gaji_guru) && isset($detail->gaji_karyawan))?$detail->gaji_guru+$detail->gaji_karyawan:0,				
				'2'			=> (isset($detail->gaji_karyawan))?$detail->gaji_karyawan:0,
				'3'			=> (isset($detail->kbm))?$detail->kbm:0,
				'4'			=> (isset($detail->sarpras))?$detail->sarpras:0,
				'5'			=> (isset($detail->rehab))?$detail->rehab:0,
				'6'			=> (isset($detail->ekstra))?$detail->ekstra:0,
				'7'			=> (isset($detail->jasa))?$detail->jasa:0,
				'8'			=> (isset($detail->tu))?$detail->tu:0,
				'9'			=> (isset($detail->lain))?$detail->lain:0,
				'10'		=> (isset($detail->saldo))?$detail->saldo:0,
				'11'		=> (isset($detail->pengadaan_sarpras))?$detail->pengadaan_sarpras:0,
			);
		}

		return $hasil;		
	}

	//sekolah dengan tingkat lain
	public function getSheetLainSembilanNegeri($id,$status)
	{
		$hasil = array();		
		$status = ($status == 3)?"":"AND status_school='$status'";
		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' ".$status." ORDER BY nama_school DESC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,
				//error
				'1'			=> $this->jumGolAdministrasi($dt->id_school,1,1,2,$id,$status),
				'2'			=> $this->jumHonorAdministrasi($dt->id_school,1,1,2,$id,$status),
				'3'			=> $this->getTenagaLain($dt->id_school,1,$status),
				'4'			=> $this->getGuruLain($dt->id_school,1,$status)
			);			
		}

		return $hasil;
	}

	private function getTenagaLain($id,$kode,$status)
	{
		$hasil = array();		

		$tenaga = $this->arey->getTenaga();
		foreach($tenaga as $detail)
		{
			$kueri = $this->db->query("SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND a.id_school='$id' AND (b.status_guru='1' OR b.status_guru='4') AND b.status_peg='$detail'");
			$hasil[] = $kueri->num_rows();
		}

		return $hasil;
	}

	private function getGuruLain($id,$kode,$status)
	{
		$hasil = array();		

		$guru = array(12,3,4,5,6,7,32,9,17,22,2,8,15,33,16,29,20,21,34,35,36,28,37,38,19,31,39,26,18);
		foreach($guru as $detail)
		{
			$kueri = $this->db->query("SELECT * FROM schools a,guru b WHERE a.id_school=b.id_school AND a.id_school='$id' AND (b.status_guru='2' OR b.status_guru='3' OR b.status_guru='5' OR b.status_guru='6') AND b.id_jabatan='$detail' ");
			$hasil[] = $kueri->num_rows();
		}

		return $hasil;
	}

	public function getSheetLainDelapanNegeri($id,$status)
	{
		$hasil = array();
		if($status == 1 || $status == 2)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' AND status_school='$status' ORDER BY nama_school DESC");
		}
		else
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' ORDER BY nama_school DESC");
		}				
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,				
				'1'			=> $this->jumGuruUmur($dt->id_school,1,2,$id,$status),				
				'2'			=> $this->jumGuruTmt($dt->id_school,1,2,$id,$status),
				//error
				'3'			=> $this->jumGuruDidik($dt->id_school,1,2,$id,$status),
			);
		}

		return $hasil;
	}

	public function getSheetLainTujuhNegeri($id,$status)
	{
		$hasil = array();				
		if($status == 1 || $status == 2)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' AND status_school='$status' ORDER BY nama_school DESC");
		}
		else
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' ORDER BY nama_school DESC");
		}
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,				
				'1'			=> $this->jumDetailKepsek($dt->id_school,$status),				
				'2'			=> $this->jumGuruStatus($dt->id_school,1,2,$id,$status)				
			);
		}

		return $hasil;
	}

	private function jumDetailKepsek($id,$status)
	{
		$hasil = array();		

		$kueri = $this->db->query("SELECT b.jenis_kel,b.status_peg,b.pend_guru,TIMESTAMPDIFF(YEAR, b.tgl_lahir, NOW()) AS lahir,TIMESTAMPDIFF(YEAR, b.tmt_guru, NOW()) AS tmt FROM detail_schools a,guru b WHERE a.id_guru=b.id_guru AND a.id_school='$id' ORDER BY a.id_detail_school DESC");
		$data = $kueri->row();

		$hasil = array(
			'jk'		=> (isset($data->jenis_kel))?$data->jenis_kel:0,
			'golongan'	=> (isset($data->status_peg))?$data->status_peg:0,
			'umur'		=> (isset($data->lahir))?$data->lahir:0,
			'tmt'		=> (isset($data->tmt))?$data->tmt:0,
			'ijazah'	=> (isset($data->pend_guru))?$data->pend_guru:0,
		);

		return $hasil;
	}

	public function getSheedEnamLainNegeri($id,$tahun,$status)
	{
		$hasil = array();	
		$statuse = ($status == 3)?"":" AND status_school='$status' ";	
		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' $statuse ORDER BY nama_school DESC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,				
				'1'			=> $this->jumPengeluaran($dt->id_school,1,$tahun,2,$id,$status),
			);
		}

		return $hasil;
	}

	public function getSheedLimaLainNegeri($id,$tahun,$status)
	{
		$hasil = array();	
		if($status == 1|| $status == 2)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' AND status_school='$status' ORDER BY nama_school DESC");
		}
		else
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' ORDER BY nama_school DESC");
		}		
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,				
				'1'			=> $this->getKurikulumLain($dt->id_school,$status),
				'2'			=> $this->jumPenerimaan($dt->id_school,1,$tahun,2,$id,$status)
			);
		}

		return $hasil;
	}

	private function getKurikulumLain($id,$status)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM schools WHERE id_school='$id'");
		$data = $kueri->row();

		$hasil = array(
			'kuri'		=> (isset($data->kurikulum_school))?$data->kurikulum_school:0
		);

		return $hasil;
	}

	public function getSheedEmpatLainNegeri($id,$tahun,$status)
	{
		$hasil = array();	
		$statuse = ($status == 3)?"":" AND status_school='$status' ";	
		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' $statuse ORDER BY nama_school DESC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,
				'1'			=> $this->jumMasalah($dt->id_school,1,$tahun,'b.putus_siswa',2,$id,$status),
				'2'			=> $this->jumPesertaLulus($dt->id_school,1,$tahun,2,$id,$status),
				//error
				'3'			=> $this->jumMapelLain($dt->id_school,1,$tahun,2,$id,$status),
				'4'			=> $this->jumRuangKelas($dt->id_school,1,$tahun,2,$id,$status),
				'5'			=> $this->jumSarpras($dt->id_school,1,$tahun,2,$id,$status)
			);
		}

		return $hasil;
	}

	private function jumMapelLain($id,$kode,$tahun,$ids,$jenjang,$status)
	{
		$hasil = array();

		if($jenjang == 1)
		{
			$mapel = array(10,11,12,13,14,15,16,17,18,20);
		}
		else
		{
			$mapel = array(9,10,11);
		}		

		$ids = ($ids == 1)?"AND a.id_kecamatan='$id'":"AND a.id_school='$id'";
		$status = ($status == 3)?"":" AND a.status_school='$status' ";

		foreach($mapel as $i => $detail_mapel)
		{
			$sql = "SELECT SUM(d.nilai_mapel) as jumlah FROM schools a,mapel b,detail_mapel c,mapel_school d WHERE a.id_school=d.id_school AND b.id_mapel=c.id_mapel AND c.id_detail_mapel=d.id_detail_mapel AND d.id_ta='$tahun' $ids AND a.jenjang_school='$jenjang' $status ";
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[$i] = (isset($data->jumlah))?$data->jumlah:0;			
		}

		return $hasil;
	}

	public function getSheedTigaLainNegeri($id,$tahun,$status)
	{
		$hasil = array();
		$statuse = ($status == 3)?"":" AND status_school='$status' ";		
		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' $statuse ORDER BY nama_school DESC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,				
				'1'			=> $this->getTingkat($dt->id_school,1,$tahun,2,$id,$status),
				'2'			=> $this->getUmurLainAll($dt->id_school,$tahun,$status,$id),
				'3'			=> $this->jumMasalah($dt->id_school,1,$tahun,'b.mengulang_siswa',2,$id,$status),
			);
		}

		return $hasil;
	}

	private function getUmurLainAll($id,$tahun,$statuse,$ids)
	{
		if($ids == 2)
		{
			$umur = array(37,38,39,40,48);
		}		
		else
		{
			$umur = array(37,38,39,40,41,42,43,45);
		}
		$hasil = array();		

		foreach($umur as $detail)
		{
			if($statuse == 1 || $statuse == 2)
			{
				$sql = "SELECT SUM(c.laki_detail_siswa) as lk,SUM(c.pr_detail_siswa) as pr FROM umur a,detail_umur b,detail_siswa c,siswa d,schools e WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_siswa=d.id_siswa AND d.id_school=e.id_school AND d.id_ta='$tahun' AND e.id_school='$id' AND e.status_school='$statuse' AND a.id_umur='$detail'";
			}
			else
			{
				$sql = "SELECT SUM(c.laki_detail_siswa) as lk,SUM(c.pr_detail_siswa) as pr FROM umur a,detail_umur b,detail_siswa c,siswa d,schools e WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_siswa=d.id_siswa AND d.id_school=e.id_school AND d.id_ta='$tahun' AND e.id_school='$id' AND a.id_umur='$detail'";
			}			
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			$hasil[] = array(
				'1'		=> (isset($data->lk))?$data->lk:0,
				'2'		=> (isset($data->pr))?$data->pr:0			
			);			
		}		

		return $hasil;
	}

	public function getSheedDuaLainNegeri($id,$tahun,$status)
	{
		$hasil = array();	
		$statuse = ($status == 3)?"":" AND status_school='$status' ";	
		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' $statuse ORDER BY nama_school DESC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nama'		=> $dt->nama_school,								
				'1'			=> $this->getUmur($dt->id_school,1,$tahun,4,2,$id,$status),
				'2'			=> $this->jumAgama($dt->id_school,1,$tahun,2,$id,$status),				
				'3'			=> $this->jumRombel($dt->id_school,2,$tahun,2,$id,$status),
				'4'			=> $this->jumAsal($dt->id_school,$tahun,2,$id,$status),
			);
		}

		return $hasil;
	}

	public function getSheedSatuLainNegeri($id,$tahun,$status)
	{
		$hasil = array();	
		$statuse = ($status == 3)?"":" AND status_school='$status' ";	
		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' $statuse ORDER BY nama_school DESC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nss'		=> $dt->nss_school,								
				'nama'		=> $dt->nama_school,								
				'alamat'	=> $dt->alamat_school,	
				'akre'		=> $dt->akre_school,	
				'waktu'		=> $dt->waktu_school,	
				'mutu'		=> $dt->status_mutu,	
				'iso'		=> $dt->iso_school,	
				//'program'	=> $dt->waktu_school,	
				'kelompok'	=> explode("-", $dt->kelompok_school),	
				'1'			=> $this->jumDaftarSd( $dt->id_school,1,$tahun,2,$id,$status),
			);
		}

		return $hasil;
	}
}
?>
