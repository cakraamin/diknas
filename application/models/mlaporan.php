<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlaporan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}	

	function getTahun()
	{
		$query = $this->db->query("SELECT * FROM tahun_ajaran ORDER BY id_ta ASC");

		if ($query->num_rows()> 0)
		{
			foreach ($query->result_array() as $row)
			{
				$tahun = substr($row['nama_ta'], 0,4);

				$data[$row['id_ta']] = $tahun;
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
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

	function getKecamatanSelek()
	{
		$query = $this->db->query("SELECT * FROM kecamatan ORDER BY id_kecamatan ASC");

		if ($query->num_rows()> 0)
		{
			foreach ($query->result_array() as $row)
			{				
				$data[$row['id_kecamatan']] = $row['nama_kecamatan'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function getKelompok($id)
	{
		if($id == 0)
		{
			return "";
		}
		else
		{
			$pecah = explode("-", $id);
			if(count($pecah) > 1)
			{
				$kel = "";
				foreach($pecah as $dt_pecah)
				{
					if($dt_pecah != "")
					{
						$kel = $kel.", ".$this->arey->getKelompok($dt_pecah);
					}
				}

				$jumlah = strlen($kel);
				return substr($kel, 2, $jumlah);
			}
			else
			{
				return "";
			}
		}
	}

    function getKecamatanSelekLap()
	{
		$query = $this->db->query("SELECT * FROM kecamatan ORDER BY id_kecamatan ASC");

		if ($query->num_rows()> 0)
		{
                        $data[0] = "All";
			foreach ($query->result_array() as $row)
			{				
				$data[$row['id_kecamatan']] = $row['nama_kecamatan'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function setTahun($id)
	{
		$query = $this->db->query("SELECT * FROM tahun_ajaran WHERE id_ta='$id'");
		$hasil = $query->row();
		$nilai = ($hasil->nama_ta)?$hasil->nama_ta:0;
		return $nilai;
	}

	function getHeaderLap($id)
	{
		$kueri = $this->db->query("SELECT * FROM kuesioner a,ket_kuesioner b WHERE a.id_kuesioner=b.id_kuesioner AND a.jenis_kuesioner='$id' GROUP BY a.id_kuesioner ORDER BY a.id_kuesioner ASC");
		return $kueri->result();
	}

	function getJenjang($id)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.stat_ket_kuesioner='1' AND b.id_kuesioner='$id'");
		return $kueri->result();
	}

	function getSubQuest($id)
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' ORDER BY id_ket_kuesioner DESC");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$data[] = $dt_hasil->text_ket_kuesioner;
		}

		return $data;
	}

	function getPembilang($id)
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND stat_ket_kuesioner='1' ORDER BY id_ket_kuesioner DESC");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$data[] = $dt_hasil->text_ket_kuesioner;
		}

		return $data;
	}

	function getPenyebut($id)
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND stat_ket_kuesioner='2' ORDER BY id_ket_kuesioner DESC");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$data[] = $dt_hasil->text_ket_kuesioner;
		}

		return $data;
	}

	function getDetailLaporan($id)
	{
		$sql = "tahun $id";
		return 12;
	}

	function getJawaban($id)
	{
		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE id_kuesioner='$id'");
		$data = $kueri->row();
		return $data->jawaban;
	}

	/*function getManual($id,$jenis,$jenis_ket,$tingkats,$tjenjang,$tahun)
	{
		if($jenis == 2 AND $jenis_ket == 3)
		{
			if($tingkats == 1 OR $tingkats == 2)
			{
				$jumlah = 0;
				//foreach ($tjenjang as $key => $dt_jenjang) 
				//{
					$kmurid = $this->db->query("SELECT * FROM siswa a,schools b WHERE a.id_school=b.id_school AND a.id_ta='$tahun' AND b.jenjang_school='".$tjenjang."' GROUP BY a.id_school ORDER BY a.id_siswa DESC");
					$hasil_murid = $kmurid->result();
					foreach($hasil_murid as $dt_hasil_murid)
					{
						$jumlah = $jumlah + $dt_hasil_murid->laki_siswa + $dt_hasil_murid->perempuan_siswa;
					}					
				//}				
			}
			else
			{
				$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$tjenjang'");
				$jumlah = $kueri->num_rows();
			}
		}
		else
		{
			$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND level_ket_kuesioner='2' ORDER BY id_ket_kuesioner DESC LIMIT 0,1");
			$data = $kueri->row();
			$jumlah = (isset($data->ket_ket_kuesioner))?$data->ket_ket_kuesioner:1;
		}		
		return $jumlah;
	}*/

	function getManual($id,$jenis,$jenis_ket,$tingkats,$tjenjang,$tahun)
	{
		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE id_kuesioner='$id'");
		$hasil = $kueri->row();
		$data = (isset($hasil->pembilang))?$hasil->pembilang:1;
		return $data;
	}

	function getJenisKetKue($id)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' GROUP BY id_kuesioner");
		$data = $kueri->row();
		$hasil = (isset($data->jenis_ket_kuesioner))?$data->jenis_ket_kuesioner:1;
		return $hasil;
	}

	function getTotal($id,$jenis,$kue,$soal,$jenjang,$jenis_ket)
	{
		$jenjangs = array();		

		foreach ($jenjang as $key => $dt_jenjang) 
		{
			$jenjangs[] = $dt_jenjang->jenjang_school;
		}
		$jenjangu = array_unique($jenjangs);

		if($jenis == 2 AND $kue == 4 AND $soal == 2 AND count($jenjang) == 4 AND ($jenis_ket == 1 OR $jenis_ket == 4 OR $jenis_ket == 5 OR $jenis_ket == 6))
		{					
			$jumlah = 0;				
			foreach($jenjangu as $dt_jenjangu)
			{
				$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$dt_jenjangu'");
				$jumlah = $jumlah + $kueri->num_rows();
			}
		}
		elseif($jenis == 2 AND count($jenjang) == 4)
		{				
			$jumlah = 0;					
			foreach($jenjangu as $dt_jenjangu)
			{
				$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$dt_jenjangu'");
				$jumlah = $jumlah + $kueri->num_rows();
			}
		}
		elseif($jenis == 2 AND $jenis_ket == 3)
		{				
			$jumlah = 50;
			/*foreach($jenjangu as $dt_jenjangu)
			{
				$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$dt_jenjangu'");
				$jumlah = $jumlah + $kueri->num_rows();
			}*/
		}				
		else
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id'");
			$jumlah = $kueri->num_rows();
		}		
		//return $kue."-".$soal."-".count($jenjang)."-".count($jenis_ket);
		return $jumlah;
	}

	function getTotalPem($id,$ta,$ids,$jenis,$kue,$soal,$jenjang)
	{
		/*if($jenis == 2 AND $kue == 4 AND $soal == 2 AND $jenjang == 4)
		{
			$data = 101;
		}		
		else
		{
			$kueri = $this->db->query("SELECT * FROM kuesioner_school WHERE id_detail_kuesioner='$id' AND id_ta='$ta' AND ket_kuesioner_school='1'");
			$data = $kueri->num_rows();			
		}*/
		$kueri = $this->db->query("SELECT * FROM kuesioner_school WHERE id_detail_kuesioner='$id' AND id_ta='$ta' AND ket_kuesioner_school='1'");
		$data = $kueri->num_rows();			
		return $data;
	}

	/*function getManualTotal($id,$ta,$ids,$jenis,$kue,$soal,$jenjang,$jenis_ket,$tingkats)
	{
		//cek tambahan penyebut		
		//if($jenis == 2 AND $kue == 4 AND $soal == 2 AND $jenjang == 4)		
		if($jenis == 2 AND $jenis_ket == 3 AND ($tingkats == 1 OR $tingkats == 2))
		{
			$sql = "SELECT SUM(ket_kuesioner_school) as jumlah FROM kuesioner_school WHERE id_detail_kuesioner='$id' AND id_ta='$ta'";
			$kueri = $this->db->query($sql);						
			$nilai = $kueri->num_rows;			
		}
		else
		{
			$sql = "SELECT SUM(ket_kuesioner_school) as jumlah FROM kuesioner_school WHERE id_detail_kuesioner='$id' AND id_ta='$ta'";
			$kueri = $this->db->query($sql);		
			$data = $kueri->row();
			$nilai = $data->jumlah;			
		}
		return $nilai;
	}*/

	function getManualTotal($id,$ta,$ids,$jenis,$kue,$soal,$jenjang,$jenis_ket,$tingkats)
	{
		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE id_kuesioner='$id'");
		$hasil = $kueri->row();
		$data = (isset($hasil->penyebut))?$hasil->penyebut:1;
		return $data;
	}

	function getJumSoalTulis($kue)
	{
		$sql = "SELECT * FROM detail_kuesioner b,ket_kuesioner c WHERE b.id_ket_kuesioner=c.id_ket_kuesioner AND b.id_kuesioner='$kue' AND c.stat_ket_kuesioner='1' GROUP BY c.id_ket_kuesioner";
		$kueri = $this->db->query($sql);		
		$nilai = $kueri->num_rows();
		return $nilai;
	}

	function getSoal($id)
	{
		$data = array();		
		$sub = array();				

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1' ORDER BY b.jenjang_school ASC");
		$hasil = $kueri->result();
		$no = 1;
		$i = 0;
		foreach($hasil as $dt_hasil)
		{
			unset($subs);
			$subs = array();

			if($i > 0)
			{	
				$idks = $i - 1;

				if(array_search($dt_hasil->jenjang_school, $data[$idks]['0']) == 2)		
				{					
					$tambah = array(
						'1'		=> $dt_hasil->id_detail_kuesioner,
						'2'		=> $dt_hasil->jenjang_school,
						'3'		=> $dt_hasil->id_kuesioner
					);
					array_push($data[$idks], $tambah);
				}
				else
				{
					$subs[] = array(
						'1'		=> $dt_hasil->id_detail_kuesioner,
						'2'		=> $dt_hasil->jenjang_school,
						'3'		=> $dt_hasil->id_kuesioner
					);
					$data[$i] = $subs;				
					$i++;		
				}
			}
			else
			{
				$subs[] = array(
					'1'		=> $dt_hasil->id_detail_kuesioner,
					'2'		=> $dt_hasil->jenjang_school,
					'3'		=> $dt_hasil->id_kuesioner
				);
				$data[$i] = $subs;				
				$i++;
			}
			$no++;						
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

	function getTotalSoal($id,$jum)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1'");
		$hasil = $kueri->num_rows()*$jum;
		return $hasil;
	}

	function getTotalSoalJenjang($id)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1'");
		return $kueri->num_rows();	
	}

	function getTotalSoals($id)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1'");
		$hasil = $kueri->num_rows();		
		return $hasil*2;
	}

	function getStatusJawab($id)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id'");
		$hasil = $kueri->row();
		$nilai = (isset($hasil->jenis_ket_kuesioner))?$hasil->jenis_ket_kuesioner:1;
		$out = ($nilai == 3)?2:1;
		return $out;
	}

	function getJumSoale($id,$jum)
	{
		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND stat_ket_kuesioner='1'");
		$hasil = $kueri->num_rows()*$jum;
		return $hasil;
	}

	function getAllTotalSoal($id,$no)
	{
		$data = array();

		$pembilang = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1' GROUP BY a.id_ket_kuesioner");
		$hpembilang = $pembilang->result();		
		$penyebut = $this->db->query("SELECT * FROM kuesioner a,ket_kuesioner b WHERE a.id_kuesioner=b.id_kuesioner AND a.id_kuesioner='$id' AND b.stat_ket_kuesioner='2'");
		$hpenyebut = $penyebut->row();		
		$i = 0;
		foreach($hpembilang as $dt_hpembilang)
		{
			$data[] = "PEMBILANG : ".$dt_hpembilang->text_ket_kuesioner;			
			if(isset($hpenyebut->text_ket_kuesioner))
			{
				$data[] = "PENYEBUT : ".$hpenyebut->text_ket_kuesioner;
			}					
			$i++;
		}
		if(isset($hpenyebut->jenis_ket_kuesioner) && $hpenyebut->jenis_ket_kuesioner == 3 && $hpenyebut->jenis_kuesioner == 2)
		{	
			$data[] = "PEMBILANG : Jumlah sekolah yang memenuhi point ".$no.".1 di atas ";
			$data[] = "PENYEBUT : Jumlah sekolah di wilayah kabupaten/kota";
		}
		elseif(isset($hpenyebut->jenis_ket_kuesioner) && $hpenyebut->jenis_ket_kuesioner == 4 && $hpenyebut->jenis_kuesioner == 2)
		{	
			$data[] = "PEMBILANG : Jumlah SD/MI atau SMP/MTs yang memenuhi IP ".$no.",1 di atas";
			$data[] = "PENYEBUT : Jumlah SD/MI atau SMP/MTs di wil.Kab/Kota";
		}
		elseif(isset($hpenyebut->jenis_ket_kuesioner) && $hpenyebut->jenis_ket_kuesioner == 5 && $hpenyebut->jenis_kuesioner == 2)
		{	
			$data[] = "PEMBILANG : Jumlah SD/MI atau SMP/MTs yang telah memenuhi IP ".$no.",1";
			$data[] = "PENYEBUT : Jumlah SD/MI atau SMP/MTs di wil.kab/kota";
		}
		elseif(isset($hpenyebut->jenis_ket_kuesioner) && $hpenyebut->jenis_ket_kuesioner == 6 && $hpenyebut->jenis_kuesioner == 2)
		{	
			$data[] = "PEMBILANG : Jumlah SD/MI atau SMP/MTs menyelenggarakan proses pembelajaran di sekolah selama 34 minggu pertahun dengan kegiatan pembelajaran ";
			$data[] = "PENYEBUT : Jumlah SD/MI atau SMP/MTs di wil.Kab/Kota";
		}
		elseif(isset($hpenyebut->jenis_ket_kuesioner) && $hpenyebut->jenis_ket_kuesioner == 1 && $hpenyebut->jenis_kuesioner == 2 AND $hpenyebut->id_kuesioner == 72)
		{	
			$data[] = "PEMBILANG : Jumlah SD/MI atau SMP/MTs yang memenuhi IP ".$no.",1 di atas";
			$data[] = "PENYEBUT : Jumlah SD/MI atau SMP/MTs di wil.Kab/Kota";
		}

		return $data;
	}	

	function getAllTotalSoalProf($id)
	{
		$data = array();

		$pembilang = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1' GROUP BY a.id_ket_kuesioner");
		$hpembilang = $pembilang->result();				
		$i = 0;
		foreach($hpembilang as $dt_hpembilang)
		{
			$data[] = $dt_hpembilang->text_ket_kuesioner;
			$i++;			
		}

		return $data;
	}

	function getTingkat($id)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_school='$id'");
		$hasil = $kueri->row();
		$data = $hasil->jenjang_school;
		$jenjang = (isset($data))?$data:"0";
		return $jenjang;
	}

	function getJumMurid($id,$ids,$tahun)
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM siswa WHERE id_school='$id' AND id_tingkat='$ids' AND id_ta='$tahun' ORDER BY id_siswa DESC LIMIT 0,1");		
		if($kueri->num_rows() > 0)
		{
			$hasil = $kueri->row();

			$data = array(
				'laki'		=> $hasil->laki_siswa,
				'perempuan'	=> $hasil->perempuan_siswa
			);
		}
		else
		{
			$data = array(
				'laki'		=> 0,
				'perempuan'	=> 0
			);	
		}

		return $data;
	}

	function getJumMuridAll($id,$ids,$tahun)
	{
		$data = array();
		$laki = 0;
		$peremp = 0;

		$sql = "SELECT a.laki_siswa,a.perempuan_siswa FROM siswa a,schools b WHERE a.id_tingkat='$ids' AND a.id_ta='$tahun' AND b.jenjang_school='$id' GROUP BY b.id_school ORDER BY a.id_siswa DESC";				

		$kueri = $this->db->query($sql);		
		$nilai = $kueri->result();

		foreach($nilai as $dt_nilai)
		{
			$laki = $laki + intval($dt_nilai->laki_siswa);
			$peremp = $peremp + intval($dt_nilai->perempuan_siswa);
		}

		$data = array(
			'laki'		=> $laki,
			'perempuan'	=> $peremp
		);		
		
		return $data;
	} 

	function getDetailMurid($id,$ids,$tahun)
	{
		$data = "";

		$sql = "SELECT * FROM siswa a,detail_siswa b,detail_umur c,umur d WHERE a.id_school='$id' AND a.id_tingkat='$ids' AND a.id_ta='$tahun' AND a.id_siswa=b.id_siswa AND b.id_detail_umur=c.id_detail_umur AND c.id_umur=d.id_umur GROUP BY b.id_detail_umur ORDER BY b.id_detail_umur DESC";						
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$hasil = $kueri->result();
			foreach($hasil as $dt_hasil)
			{
				if($dt_hasil->operasi_umur == 1)
				{
					$batas = "Kurang dari ".$dt_hasil->batas_awal." Tahun";
				}
				elseif($dt_hasil->operasi_umur == 2)
				{
					$batas = "Antara ".$dt_hasil->batas_awal." Tahun sampai ".$dt_hasil->batas_akhir." Tahun";
				}
				elseif($dt_hasil->operasi_umur == 3)
				{
					$batas = "Lebih dari dari ".$dt_hasil->batas_akhir." Tahun";
				}
				else
				{
					$batas = "Sama dengan ".$dt_hasil->batas_awal." Tahun";
				}
				
				$jumlah = $dt_hasil->laki_detail_siswa + $dt_hasil->pr_detail_siswa;
				$data .= $batas." = ".$jumlah."; ";
			}			
		}
		else
		{
			$data = "Tidak ada detail umur";
		}

		return $data;
	}

	function getDetailMuridAll($id,$ids,$tahun)
	{
		$data = "";

		$sql = "SELECT * FROM umur a,detail_umur b,detail_siswa c,siswa d WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_siswa=d.id_siswa AND b.jenjang_school='$id' AND a.id_tingkat='$ids' AND d.id_ta='$tahun' GROUP BY b.id_detail_umur";		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$hasil = $kueri->result();
			foreach($hasil as $dt_hasil)
			{
				if($dt_hasil->operasi_umur == 1)
				{
					$batas = "Kurang dari ".$dt_hasil->batas_awal." Tahun";
				}
				elseif($dt_hasil->operasi_umur == 2)
				{
					$batas = "Antara ".$dt_hasil->batas_awal." Tahun sampai ".$dt_hasil->batas_akhir." Tahun";
				}
				elseif($dt_hasil->operasi_umur == 3)
				{
					$batas = "Lebih dari dari ".$dt_hasil->batas_akhir." Tahun";
				}
				else
				{
					$batas = "Sama dengan ".$dt_hasil->batas_awal." Tahun";
				}
				
				$jumlah = $dt_hasil->laki_detail_siswa + $dt_hasil->pr_detail_siswa;
				$data .= $batas." = ".$jumlah."; ";
			}			
		}
		else
		{
			$data = "Tidak ada detail umur";
		}

		return $data;
	}

	function getProdi($id)
	{
		$kueri = $this->db->query("SELECT * FROM prodi a,detail_prodi b,prodi_school c WHERE a.id_prodi=b.id_prodi AND b.id_detail_prodi=c.id_detail_prodi AND c.id_school='$id' GROUP BY a.id_prodi");
		return $kueri->result();
	}

	function getProdiAll($id)
	{
		$kueri = $this->db->query("SELECT * FROM prodi a,detail_prodi b WHERE a.id_prodi=b.id_prodi AND b.jenjang_school='$id'");
		return $kueri->result();
	}

	function getDetailJur($id,$ids,$tingkat,$tahun)
	{
		$sql = "SELECT * FROM prodi a,detail_prodi b,prodi_school c WHERE a.id_prodi=b.id_prodi AND b.id_detail_prodi=c.id_detail_prodi AND a.id_prodi='$id' AND c.id_school='$ids' AND c.id_tingkat='$tingkat' AND c.id_ta='$tahun' ORDER BY c.id_prodi_school DESC LIMIT 0,1";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->row();
		$data = (isset($hasil->peserta))?$hasil->peserta:"";
		return $data;
	}

	function getDetailJurAll($id,$ids,$tingkat,$tahun)
	{
		$sql = "SELECT * FROM prodi a,detail_prodi b,prodi_school c,siswa d WHERE a.id_prodi=b.id_prodi AND b.id_detail_prodi=c.id_detail_prodi AND a.id_prodi='$id' AND b.jenjang_school='$ids' AND c.id_tingkat='$tingkat' AND c.id_siswa=d.id_siswa AND d.id_ta='$tahun' ORDER BY c.id_prodi_school DESC LIMIT 0,1";						
		$kueri = $this->db->query($sql);
		$hasil = $kueri->row();
		$data = (isset($hasil->peserta))?$hasil->peserta:"0";
		return $data;
	}

	function getMapel($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru WHERE id_school='$id' AND jenis_kendaraan<>'100' GROUP BY id_jabatan");		
		return $kueri->result();
	}

	function getMapelAll($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.jenjang_school='$id' AND a.jenis_kendaraan<>'100' GROUP BY a.id_jabatan");		
		return $kueri->result();
	}

	function getJumMapelAll($ids,$jenis,$id)
	{
		$kueri = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_jabatan='$ids' AND a.jenis_kel='$jenis' AND b.jenjang_school='$id' AND a.jenis_kendaraan<>'100'");
		return $kueri->num_rows();
	}

	function getJumMapel($ids,$id,$jenis)
	{
		$kueri = $this->db->query("SELECT * FROM guru WHERE id_school='$id' AND id_jabatan='$ids' AND jenis_kel='$jenis' AND jenis_kendaraan<>'100'");
		return $kueri->num_rows();
	}

	function getDetailSchool($id)
	{
		$kueri = $this->db->query("SELECT * FROM schools a,detail_schools b WHERE a.id_school=b.id_school AND a.id_school='$id' ORDER BY b.id_detail_school LIMIT 0,5");
		return $kueri->result();
	}	

	function getLapJumNonProdi($tahun,$id)
	{
		$kueri = $this->db->query("SELECT * FROM prodi_school a,siswa b WHERE a.id_siswa=b.id_siswa AND b.id_ta='$tahun' AND a.id_school='$id' AND a.id_tingkat='6' ORDER BY a.id_prodi_school DESC LIMIT 0,1");
		return $kueri->row();
	}

	function getMapelUN($id)
	{
		$kueri = $this->db->query("SELECT * FROM mapel a,detail_mapel b WHERE a.id_mapel=b.id_mapel AND b.jenjang_school='$id'");
		return $kueri->result();
	}

	function getNilaiMapel($ids,$id,$ta)
	{
		$kueri = $this->db->query("SELECT * FROM mapel_school WHERE id_detail_mapel='$ids' AND id_school='$id' AND id_ta='$ta'");
		$hasil = $kueri->row();
		$data = (isset($hasil->nilai_mapel))?$hasil->nilai_mapel:"";
		return $data;
	}

	function getTanah($id,$ta)
	{
		$kueri = $this->db->query("SELECT * FROM tanah WHERE id_ta='$ta' AND id_school='$id'");
		return $kueri->row();

	}

	function getDetailSekali($id)
	{
		$nilai = array();

		$kueri = $this->db->query('SELECT * FROM kecamatan a,kabupaten b,propinsi c WHERE a.id_kabupaten=b.id_kabupaten AND b.id_propinsi=c.id_propinsi AND a.id_kecamatan="$id"');
		$data = $kueri->row();

		$kecamatan = isset($data->nama_kecamatan)?$data->nama_kecamatan:"";
		$kabupaten = isset($data->nama_kabupaten )?$data->nama_kabupaten :"";
		$propinsi = isset($data->nama_propinsi )?$data->nama_propinsi :"";

		$nilai = array(
			'kecamatan'		=> $kecamatan,
			'kabupaten'		=> $kabupaten,
			'propinsi'		=> $propinsi
		);

		return $nilai;
	}

	function getKepsek($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru WHERE id_guru='$id' AND jenis_kendaraan<>'100'");
		$hasil = $kueri->row();
		$data = isset($hasil->nama_guru)?$hasil->nama_guru:"";
		return $data;
	}

	function getPenggunaan($tingkat)
	{
		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='1' AND b.jenjang_school='$tingkat'";
		$kueri = $this->db->query($sql);
		return $kueri->result();
	}

	function getDetailBangunan($ids,$tahun,$id,$tingkat)
	{
		$sql = "SELECT * FROM fasilitas_school WHERE id_ta='$tahun' AND id_school='$id' AND id_detail_fasilitas='$ids' AND tingkat='$tingkat' ORDER BY id_fasilitas_school DESC LIMIT 0,1";
		$kueri = $this->db->query($sql);
		$hasil = $kueri->row();
		$data = isset($hasil->jumlah_fasilitas)?$hasil->jumlah_fasilitas:0;			
		return $data;
	}

	function getDetaileBangunan($ids,$tahun,$id)
	{
		unset($data);
		$data = array();

		for($i=1;$i<=9;$i++)
		{
			$sql = "SELECT * FROM fasilitas_school WHERE id_ta='$tahun' AND id_school='$id' AND id_detail_fasilitas='$ids' AND tingkat='$i' ORDER BY id_fasilitas_school DESC LIMIT 0,1";
			$kueri = $this->db->query($sql);
			$hasil = $kueri->row();
			$data[$i] = isset($hasil->jumlah_fasilitas)?$hasil->jumlah_fasilitas:0;
		}
				
		return $data;
	}

	function getBuku($tingkat)
	{
		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='2' AND b.jenjang_school='$tingkat'";
		$kueri = $this->db->query($sql);
		return $kueri->result();
	}

	function getRuang($tingkat)
	{
		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='4' AND b.jenjang_school='$tingkat'";
		$kueri = $this->db->query($sql);
		return $kueri->result();	
	}

	function getAdministrasi($tingkat)
	{
		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='3' AND b.jenjang_school='$tingkat'";
		$kueri = $this->db->query($sql);
		return $kueri->result();		
	}

	function getKecamatan()
	{
		$kueri = $this->db->query("SELECT * FROM kecamatan ORDER BY kode_kecamatan ASC");
		return $kueri->result();
	}

	function getJumlahSkul($id)
	{
		$data = array();

		for($i=1;$i<=4;$i++)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND jenjang_school='$i'");
			$jumlah = $kueri->num_rows();
			$data[$i] = $jumlah;
		}

		return $data;
	}

	function getJumGuruSkul($id)
	{
		$data = array();

		for($i=1;$i<=4;$i++)
		{
			$laki = 0;
			$perempuan = 0;

			$kueri = $this->db->query("SELECT * FROM schools a,guru b WHERE b.id_school=a.id_school AND a.id_kecamatan='$id' AND a.jenjang_school='$i'");
			$nilai = $kueri->result();

			foreach($nilai as $dt_nilai)
			{	
				if($dt_nilai->jenis_kel == 1)	
				{
					$laki = $laki + 1;
				}
				else
				{
					$perempuan = $perempuan + 1;
				}
			}
			$data[$i] = array(
				'lk'		=> $laki,
				'pr'		=> $perempuan
			);			
		}

		return $data;		
	}

	function getDetailPegStatus($id)
	{
		$data = array();
		$pns_lk = 0;
		$pns_pr = 0;
		$cpns_lk = 0;
		$cpns_pr = 0;
		$gtt_lk = 0;
		$gtt_pr = 0;
		$ptt_lk = 0;
		$ptt_pr = 0;
		$gty_lk = 0;
		$gty_pr = 0;
		$pty_lk = 0;
		$pty_pr = 0;

		$kueri = $this->db->query("SELECT a.status_guru,a.status_peg,a.jenis_kel FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='$id' AND a.jenis_kendaraan<>'100'");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->status_guru == 5 && $dt_hasil->jenis_kel == 1)
			{
				$pty_lk = $pty_lk + 1;
			}
			elseif($dt_hasil->status_guru == 5 && $dt_hasil->jenis_kel == 2)
			{
				$pty_pr = $pty_pr + 1;
			}
			elseif($dt_hasil->status_guru == 4 && $dt_hasil->jenis_kel == 1)
			{
				$ptt_lk = $ptt_lk + 1;
			}
			elseif($dt_hasil->status_guru == 4 && $dt_hasil->jenis_kel == 2)
			{
				$ptt_pr = $ptt_pr + 1;
			}
			elseif($dt_hasil->status_guru == 3 && $dt_hasil->jenis_kel == 1)
			{
				$gtt_lk = $gtt_lk + 1;
			}
			elseif($dt_hasil->status_guru == 3 && $dt_hasil->jenis_kel == 2)
			{
				$gtt_pr = $gtt_pr + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 5 && $dt_hasil->jenis_kel == 1)
			{
				$gty_lk = $gty_lk + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 5 && $dt_hasil->jenis_kel == 2)
			{
				$gty_lk_pr = $gty_pr + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 6 && $dt_hasil->jenis_kel == 1)
			{
				$cpns_lk = $cpns_lk + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 6 && $dt_hasil->jenis_kel == 2)
			{
				$cpns_pr = $cpns_pr + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg != 6 && $dt_hasil->status_peg != 5 && $dt_hasil->jenis_kel == 1)
			{
				$pns_lk = $pns_lk + 1;
			}
			else
			{
				$pns_pr = $pns_pr + 1;
			}
		}

		$data = array(
			'pty_lk'		=> $pty_lk,
			'pty_pr'		=> $pty_pr,
			'ptt_lk'		=> $ptt_lk,
			'ptt_pr'		=> $ptt_pr,
			'gtt_lk'		=> $gtt_lk,
			'gtt_pr'		=> $gtt_pr,
			'gty_lk'		=> $gty_lk,
			'gty_pr'		=> $gty_pr,
			'cpns_lk'		=> $cpns_lk,
			'cpns_pr'		=> $cpns_pr,
			'pns_lk'		=> $pns_lk,
			'pns_pr'		=> $pns_pr
		);

		return $data;
	}

	function getSertifikasi($id)
	{
		$data = array();
		$pns_ser_lk = 0;
		$pns_ser_pr = 0;
		$non_pns_ser_lk = 0;
		$non_pns_ser_pr = 0;
		$pns_bel_lk = 0;
		$pns_bel_pr = 0;
		$non_pns_bel_lk = 0;
		$non_pns_bel_pr = 0;

		$kueri = $this->db->query("SELECT a.status_guru,a.status_peg,a.tunjangan_guru,a.jenis_kel FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='$id' AND a.jenis_kendaraan<>'100'");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 5 && $dt_hasil->tunjangan_guru == 1 && $dt_hasil->jenis_kel == 1)
			{
				$pns_ser_lk = $pns_ser_lk + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 5 && $dt_hasil->tunjangan_guru == 1 && $dt_hasil->jenis_kel == 2)
			{
				$pns_ser_pr = $pns_ser_pr + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 5 && $dt_hasil->tunjangan_guru == 0 && $dt_hasil->jenis_kel == 1)
			{
				$non_pns_ser_lk = $non_pns_ser_lk + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg == 5 && $dt_hasil->tunjangan_guru == 0 && $dt_hasil->jenis_kel == 2)
			{
				$non_pns_ser_pr = $non_pns_ser_pr + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg != 5 && $dt_hasil->tunjangan_guru == 1 && $dt_hasil->jenis_kel == 1)
			{
				$pns_bel_lk = $pns_bel_lk + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg != 5 && $dt_hasil->tunjangan_guru == 1 && $dt_hasil->jenis_kel == 2)
			{
				$pns_bel_pr = $pns_bel_pr + 1;
			}
			elseif($dt_hasil->status_guru == 2 && $dt_hasil->status_peg != 5 && $dt_hasil->tunjangan_guru == 0 && $dt_hasil->jenis_kel == 2)
			{
				$non_pns_bel_lk = $non_pns_bel_lk + 1;
			}
			else
			{
				$non_pns_bel_pr = $non_pns_bel_pr + 1;
			}
		}

		$pns_ser_lk = 0;
		$pns_ser_pr = 0;
		$non_pns_ser_lk = 0;
		$non_pns_ser_pr = 0;
		$pns_bel_lk = 0;
		$pns_bel_pr = 0;
		$non_pns_bel_lk = 0;
		$non_pns_bel_pr = 0;

		$data = array(
			'pns_ser_lk'			=> $pns_ser_lk,
			'pns_ser_pr'			=> $pns_ser_pr,
			'non_pns_ser_lk'		=> $non_pns_ser_lk,
			'non_pns_ser_pr'		=> $non_pns_ser_pr,
			'pns_bel_lk'			=> $pns_bel_lk,
			'pns_bel_pr'			=> $pns_bel_pr,
			'non_pns_bel_lk'		=> $non_pns_bel_lk,
			'non_pns_bel_pr'		=> $non_pns_bel_pr
		);

		return $data;
	}

	function getDetailUmur($jenjang)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM umur a,detail_umur b WHERE a.id_umur=b.id_umur AND b.jenjang_school='$jenjang' ORDER BY a.id_umur ASC");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			if($dt->operasi_umur == 1)
			{
				$batas = "< ".$dt->batas_awal;
			}
			elseif($dt->operasi_umur == 2)
			{
				$batas = $dt->batas_awal." - ".$dt->batas_akhir;
			}
			elseif($dt->operasi_umur == 3)
			{
				$batas = "> ".$dt->batas_akhir;
			}
			else
			{
				$batas = "= ".$dt->batas_awal;
			}

			$hasil[] = array(
				'batas'				=> $batas,
				'id_detail_umur'	=> $dt->id_detail_umur
			);
		}
		return $hasil;
	}

	function getJumSekolah($id,$jenjang)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND jenjang_school='$jenjang'");
		return $kueri->num_rows();
	}

	function getJumAkre($id,$jenjang)
	{
		$data = array();

		$akre = $this->arey->getAkreditasi();

		foreach($akre as $key => $dt_akre)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND akre_school='$key' AND jenjang_school='$jenjang'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getJumAkreSkul($id,$jenjang,$skul)
	{
		$data = array();

		$akre = $this->arey->getAkreditasi();

		foreach($akre as $key => $dt_akre)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND akre_school='$key' AND jenjang_school='$jenjang' AND id_school='$skul'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getStatusSek($id,$jenjang)
	{
		$data = array();
		$negeri = 0;
		$swasta = 0;

		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND jenjang_school='$jenjang'");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)		
		{
			if($dt_hasil->status_school == 1)
			{
				$negeri = $negeri + 1;
			}
			else
			{	
				$swasta = $swasta + 1;
			}
		}

		$data = array(
			'negeri'		=> $negeri,
			'swasta'		=> $swasta
		);

		return $data;
	}

	function getStatusSekSkul($id,$jenjang,$ids)
	{
		$data = array();
		$negeri = 0;
		$swasta = 0;

		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND jenjang_school='$jenjang' AND id_school='$ids'");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)		
		{
			if($dt_hasil->status_school == 1)
			{
				$negeri = $negeri + 1;
			}
			else
			{	
				$swasta = $swasta + 1;
			}
		}

		$data = array(
			'negeri'		=> $negeri,
			'swasta'		=> $swasta
		);

		return $data;
	}

	function getJumRombel($id,$jenjang,$ta,$tingkat)
	{
		$kueri = $this->db->query("SELECT SUM(a.rombel_siswa) as rombel FROM siswa a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='$id' AND b.jenjang_school='$jenjang' AND a.id_ta='$ta' AND a.id_tingkat='$tingkat'");
		$hasil = $kueri->row();
		$nilai = (isset($hasil->rombel))?$hasil->rombel:0;
		return $nilai;
	}

	function getJumRombelSkul($id,$jenjang,$ta,$tingkat,$ids)
	{
		$kueri = $this->db->query("SELECT SUM(a.rombel_siswa) as rombel FROM siswa a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='$id' AND b.jenjang_school='$jenjang' AND a.id_ta='$ta' AND a.id_tingkat='$tingkat' AND b.id_school='$ids'");
		$hasil = $kueri->row();
		$nilai = (isset($hasil->rombel))?$hasil->rombel:0;
		return $nilai;
	}

	function getJumWaktu($id,$jenjang)
	{
		$data = array();

		$waktu = $this->arey->getWaktu();

		foreach($waktu as $key => $dt_waktu)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND waktu_school='$key' AND jenjang_school='$jenjang'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getJumWaktuSkul($id,$jenjang,$skul)
	{
		$data = array();

		$waktu = $this->arey->getWaktu();

		foreach($waktu as $key => $dt_waktu)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND waktu_school='$key' AND jenjang_school='$jenjang' AND id_school='$skul'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getJumGugus($id,$jenjang)
	{
		$data = array();

		$gugus = $this->arey->getGugus();

		foreach($gugus as $key => $dt_gugus)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND gugus_school='$key' AND jenjang_school='$jenjang'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getJumGugusSkul($id,$jenjang,$skul)
	{
		$data = array();

		$gugus = $this->arey->getGugus();

		foreach($gugus as $key => $dt_gugus)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND gugus_school='$key' AND jenjang_school='$jenjang' AND id_school='$skul'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getJumMbs($id,$jenjang)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND mbs_school='1' AND jenjang_school='$jenjang'");

		return $kueri->num_rows();
	}

	function getJumMbsSkul($id,$jenjang,$skul)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND mbs_school='1' AND jenjang_school='$jenjang' AND id_school='$skul'");

		return $kueri->num_rows();
	}

	function getJumKur($id,$jenjang)
	{
		$data = array();

		$kur = $this->arey->getKurikulum();

		foreach($kur as $key => $dt_kur)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND kurikulum_school='$key' AND jenjang_school='$jenjang'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getJumKurSkul($id,$jenjang,$skul)
	{
		$data = array();

		$kur = $this->arey->getKurikulum();

		foreach($kur as $key => $dt_kur)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND kurikulum_school='$key' AND jenjang_school='$jenjang' AND id_school='$skul'");

			$data[] = $kueri->num_rows();
		}

		return $data;
	}

	function getDetailUmurTotal($id,$kec)
	{
		$data = array();
		$laki = 0;
		$pr = 0;
		$sql = "SELECT c.laki_detail_siswa,c.pr_detail_siswa,d.id_school FROM umur a,detail_umur b,detail_siswa c,siswa d,schools e WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_detail_umur='$id' AND c.id_siswa=d.id_siswa AND d.id_school=e.id_school AND e.id_kecamatan='$kec' GROUP BY d.id_school ORDER BY c.id_detail_siswa DESC";
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$laki = $laki + $dt_hasil->laki_detail_siswa;
			$pr = $pr + $dt_hasil->pr_detail_siswa;
		}

		$data = array(
			'laki'		=> $laki,
			'pr'		=> $pr
		);

		return $data;
	}

	function getDetailUmurTotalSkul($id,$kec,$skul)
	{
		$data = array();
		$laki = 0;
		$pr = 0;
		$sql = "SELECT c.laki_detail_siswa,c.pr_detail_siswa,d.id_school FROM umur a,detail_umur b,detail_siswa c,siswa d,schools e WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_detail_umur='$id' AND c.id_siswa=d.id_siswa AND d.id_school=e.id_school AND e.id_kecamatan='$kec' AND e.id_school='$skul' GROUP BY d.id_school ORDER BY c.id_detail_siswa DESC";
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$laki = $laki + $dt_hasil->laki_detail_siswa;
			$pr = $pr + $dt_hasil->pr_detail_siswa;
		}

		$data = array(
			'laki'		=> $laki,
			'pr'		=> $pr
		);

		return $data;
	}	

	function getDetailTingkat($id,$tingkat)
	{
		$data = array();

		for($i=1;$i<=$tingkat;$i++)
		{
			$laki = 0;
			$pr = 0;

			$sql = "SELECT b.laki_siswa,b.perempuan_siswa FROM schools a,siswa b WHERE a.id_school=b.id_school AND b.id_tingkat='$i' AND a.id_kecamatan='$id' GROUP BY a.id_school ORDER BY b.id_siswa DESC";
			$kueri = $this->db->query($sql);
			$hasil = $kueri->result();
			foreach($hasil as $dt_hasil)
			{
				$laki = $laki + $dt_hasil->laki_siswa;
				$pr = $pr + $dt_hasil->perempuan_siswa;
			}

			$data[$i] = array(
				'laki'		=> $laki,
				'pr'		=> $pr
			);
		}

		return $data;
	}

	function getDetailTingkatSkul($id,$tingkat,$skul)
	{
		$data = array();

		for($i=1;$i<=$tingkat;$i++)
		{
			$laki = 0;
			$pr = 0;

			$sql = "SELECT b.laki_siswa,b.perempuan_siswa FROM schools a,siswa b WHERE a.id_school=b.id_school AND b.id_tingkat='$i' AND a.id_kecamatan='$id' AND a.id_school='$skul' GROUP BY a.id_school ORDER BY b.id_siswa DESC";
			$kueri = $this->db->query($sql);
			$hasil = $kueri->result();
			foreach($hasil as $dt_hasil)
			{
				$laki = $laki + $dt_hasil->laki_siswa;
				$pr = $pr + $dt_hasil->perempuan_siswa;
			}

			$data[$i] = array(
				'laki'		=> $laki,
				'pr'		=> $pr
			);
		}

		return $data;
	}

	function getUjian($id)
	{
		$kueri = $this->db->query("SELECT * FROM mapel a,detail_mapel b WHERE a.id_mapel=b.id_mapel AND b.jenjang_school='$id'");
		return $kueri->result();
	}

	function getRuangHead($id)
	{
		$kueri = $this->db->query("SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND b.jenjang_school='$id' AND a.jenis_fasilitas='4'");
		return $kueri->result();
	}

	function getBukuHead($id)
	{
		$kueri = $this->db->query("SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND b.jenjang_school='$id' AND a.jenis_fasilitas='2'");
		return $kueri->result();
	}

	function getJumTk($id)
	{
		$data = array();

		$daftar_no_tk_lk = 0;
		$daftar_no_tk_pr = 0;
		$daftar_tk_lk = 0;
		$daftar_tk_pr = 0;
		$peserta_no_tk_lk = 0;
		$peserta_no_tk_pr = 0;
		$peserta_tk_lk = 0;
		$peserta_tk_pr = 0;

		$sql = "SELECT c.daftar_no_tk_lk,c.daftar_no_tk_pr,c.daftar_tk_lk,c.daftar_tk_pr,c.peserta_no_tk_lk,c.peserta_no_tk_pr,c.peserta_tk_lk,c.peserta_tk_pr FROM schools a,siswa b,tk c WHERE a.id_school=b.id_school AND b.id_siswa=c.id_siswa AND a.id_kecamatan='$id' GROUP BY a.id_school ORDER BY c.id_tk DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$daftar_no_tk_lk = $daftar_no_tk_lk + $dt_hasil->daftar_no_tk_lk;
			$daftar_no_tk_pr = $daftar_no_tk_pr + $dt_hasil->daftar_no_tk_pr;
			$daftar_tk_lk = $daftar_tk_lk + $dt_hasil->daftar_tk_lk;
			$daftar_tk_pr = $daftar_tk_pr + $dt_hasil->daftar_tk_pr;
			$peserta_no_tk_lk = $peserta_no_tk_lk + $dt_hasil->peserta_no_tk_lk;
			$peserta_no_tk_pr = $peserta_no_tk_pr + $dt_hasil->peserta_no_tk_pr;
			$peserta_tk_lk = $peserta_tk_lk + $dt_hasil->peserta_tk_lk;
			$peserta_tk_pr = $peserta_tk_pr + $dt_hasil->peserta_tk_pr;
		}

		$data = array(
			'daftar_no_tk_lk'		=> $daftar_no_tk_lk,
			'daftar_no_tk_pr'		=> $daftar_no_tk_pr,
			'daftar_tk_lk'			=> $daftar_tk_lk,
			'daftar_tk_pr'			=> $daftar_tk_pr,
			'peserta_no_tk_lk'		=> $peserta_no_tk_lk,
			'peserta_no_tk_pr'		=> $peserta_no_tk_pr,
			'peserta_tk_lk'			=> $peserta_tk_lk,
			'peserta_tk_pr'			=> $peserta_tk_pr
		);

		return $data;
	}

	function getJumUn($id,$tingkat,$jenjang)
	{
		$data = array();

		$peserta_l = 0;
		$peserta_p = 0;
		$lulus_l = 0;
		$lulus_p = 0;		

		$sql = "SELECT * FROM prodi_school a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan AND a.id_tingkat='$tingkat' AND b.jenjang_school='$jenjang' AND b.id_kecamatan='$id' GROUP BY b.id_school ORDER BY a.id_prodi_school DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$peserta_l = $peserta_l + $dt_hasil->peserta_l;
			$peserta_p = $peserta_p + $dt_hasil->peserta_p;
			$lulus_l = $lulus_l + $dt_hasil->lulus_l;
			$lulus_p = $lulus_p + $dt_hasil->lulus_p;			
		}

		$data = array(
			'peserta_l'		=> $peserta_l,
			'peserta_p'		=> $peserta_p,
			'lulus_l'		=> $lulus_l,
			'lulus_p'		=> $lulus_p			
		);

		return $data;
	}

	function getJumUnSkul($id,$tingkat,$jenjang,$skul)
	{
		$data = array();

		$peserta_l = 0;
		$peserta_p = 0;
		$lulus_l = 0;
		$lulus_p = 0;		

		$sql = "SELECT * FROM prodi_school a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan AND a.id_tingkat='$tingkat' AND b.jenjang_school='$jenjang' AND b.id_school='$skul' GROUP BY b.id_school ORDER BY a.id_prodi_school DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$peserta_l = $peserta_l + $dt_hasil->peserta_l;
			$peserta_p = $peserta_p + $dt_hasil->peserta_p;
			$lulus_l = $lulus_l + $dt_hasil->lulus_l;
			$lulus_p = $lulus_p + $dt_hasil->lulus_p;			
		}

		$data = array(
			'peserta_l'		=> $peserta_l,
			'peserta_p'		=> $peserta_p,
			'lulus_l'		=> $lulus_l,
			'lulus_p'		=> $lulus_p			
		);

		return $data;
	}

	function getJumNilaiUn($id,$ids,$jenjang)
	{		
		$jumlah = 0;

		$sql = "SELECT c.nilai_mapel FROM mapel a,detail_mapel b, mapel_school c,schools d WHERE a.id_mapel=b.id_mapel AND b.id_detail_mapel=c.id_detail_mapel AND c.id_school=d.id_school AND d.id_kecamatan='$id' AND b.jenjang_school='$jenjang' AND c.id_detail_mapel='$ids' GROUP BY d.id_school ORDER BY c.id_mapel_school DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$jumlah = $jumlah + $dt_hasil->nilai_mapel;
		}

		$jumlah = ($jumlah > 0)?$jumlah:1;
		$bagi = (count($hasil) > 0)?count($hasil):1;
		$rata = $jumlah/$bagi;

		return $rata;
	}

	function getJumNilaiUnSkul($id,$ids,$jenjang,$skul)
	{		
		$jumlah = 0;

		$sql = "SELECT c.nilai_mapel FROM mapel a,detail_mapel b, mapel_school c,schools d WHERE a.id_mapel=b.id_mapel AND b.id_detail_mapel=c.id_detail_mapel AND c.id_school=d.id_school AND d.id_kecamatan='$id' AND b.jenjang_school='$jenjang' AND c.id_detail_mapel='$ids' AND d.id_school='$skul' GROUP BY d.id_school ORDER BY c.id_mapel_school DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$jumlah = $jumlah + $dt_hasil->nilai_mapel;
		}

		$jumlah = ($jumlah > 0)?$jumlah:1;
		$bagi = (count($hasil) > 0)?count($hasil):1;
		$rata = $jumlah/$bagi;

		return $rata;
	}

	function getJumKelas($id,$jenjang)
	{
		$data = array();

		$baik = 0;
		$rusak_ringan = 0;
		$rusak_berat = 0;
		$bukan_milik = 0;		

		$sql = "SELECT * FROM schools a,ruang_kelas b WHERE a.id_school=b.id_school AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' GROUP BY a.id_school ORDER BY b.id_ruang_kelas DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$baik = $baik + $dt_hasil->baik;
			$rusak_ringan = $rusak_ringan + $dt_hasil->rusak_ringan;
			$rusak_berat = $rusak_berat + $dt_hasil->rusak_berat;
			$bukan_milik = $bukan_milik + $dt_hasil->bukan_milik;			
		}

		$data = array(
			'baik'				=> $baik,
			'rusak_ringan'		=> $rusak_ringan,
			'rusak_berat'		=> $rusak_berat,
			'bukan_milik'		=> $bukan_milik			
		);

		return $data;
	}

	function getJumKelasSkul($id,$jenjang,$skul)
	{
		$data = array();

		$baik = 0;
		$rusak_ringan = 0;
		$rusak_berat = 0;
		$bukan_milik = 0;		

		$sql = "SELECT * FROM schools a,ruang_kelas b WHERE a.id_school=b.id_school AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND a.id_school='$skul' GROUP BY a.id_school ORDER BY b.id_ruang_kelas DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$baik = $baik + $dt_hasil->baik;
			$rusak_ringan = $rusak_ringan + $dt_hasil->rusak_ringan;
			$rusak_berat = $rusak_berat + $dt_hasil->rusak_berat;
			$bukan_milik = $bukan_milik + $dt_hasil->bukan_milik;			
		}

		$data = array(
			'baik'				=> $baik,
			'rusak_ringan'		=> $rusak_ringan,
			'rusak_berat'		=> $rusak_berat,
			'bukan_milik'		=> $bukan_milik			
		);

		return $data;
	}

	function getJumFasilitas($id,$ids,$jenjang)
	{		
		$jumlah = 0;

		$sql = "SELECT c.jumlah_fasilitas FROM fasilitas a,detail_fasilitas b,fasilitas_school c,schools d WHERE a.id_fasilitas=b.id_fasilitas AND b.id_detail_fasilitas=c.id_detail_fasilitas AND c.id_school=d.id_school AND d.id_kecamatan='$id' AND b.jenjang_school='$jenjang' AND c.id_detail_fasilitas='$ids' GROUP BY d.id_school ORDER BY c.id_fasilitas_school DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$jumlah = $jumlah + $dt_hasil->jumlah_fasilitas;
		}

		return $jumlah;
	}

	function getJumFasilitasSkul($id,$ids,$jenjang,$skul)
	{		
		$jumlah = 0;

		$sql = "SELECT c.jumlah_fasilitas FROM fasilitas a,detail_fasilitas b,fasilitas_school c,schools d WHERE a.id_fasilitas=b.id_fasilitas AND b.id_detail_fasilitas=c.id_detail_fasilitas AND c.id_school=d.id_school AND d.id_kecamatan='$id' AND b.jenjang_school='$jenjang' AND c.id_detail_fasilitas='$ids' AND d.id_school='$skul' GROUP BY d.id_school ORDER BY c.id_fasilitas_school DESC";		
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			$jumlah = $jumlah + $dt_hasil->jumlah_fasilitas;
		}

		return $jumlah;
	}

	function getKepala($id,$jenjang)
	{
		$data = array();

		$pns = 0;
		$bpns = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.jenis_kendaraan<>'100' GROUP BY a.id_school ORDER BY b.id_detail_school DESC");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->status_guru == 2 AND $dt_hasil->status_peg == 5)
			{
				$pns = $pns + 1;
			}
			elseif($dt_hasil->status_guru == 2 AND $dt_hasil->status_peg != 5)
			{
				$bpns = $bpns + 1;
			}
		}

		$data = array(
			'pns'		=> $pns,
			'bpns'		=> $bpns
		);

		return $data;
	}

	function getKepalaGol($id,$jenjang,$ids)
	{
		$data = array();

		$laki = 0;
		$pr = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND b.id_guru=c.id_guru AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.status_guru AND c.status_peg='$ids' AND c.jenis_kendaraan<>'100' GROUP BY a.id_school ORDER BY b.id_detail_school DESC");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 2)
			{
				$pr = $pr + 1;
			}
			else
			{
				$laki = $laki + 1;
			}
		}

		$data = array(
			'pr'		=> $pr,
			'laki'		=> $laki
		);

		return $data;
	}

	function getKepalaPendik($id,$jenjang,$pendik)
	{
		$data = array();

		$laki = 0;
		$pr = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,detail_schools b,guru c WHERE a.id_school=b.id_school AND c.pend_guru='$pendik' AND b.id_guru=c.id_guru AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.jenis_kendaraan<>'100' GROUP BY a.id_school ORDER BY b.id_detail_school DESC");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 2)
			{
				$pr = $pr + 1;
			}
			else
			{
				$laki = $laki + 1;
			}
		}

		$data = array(
			'pr'		=> $pr,
			'laki'		=> $laki
		);

		return $data;
	}

	function getGuruPendik($id,$jenjang,$pendik)
	{
		$data = array();

		$laki = 0;
		$pr = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,guru c WHERE a.id_school=c.id_school AND c.pend_guru='$pendik' AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.jenis_kendaraan<>'100' GROUP BY a.id_school");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 2)
			{
				$pr = $pr + 1;
			}
			else
			{
				$laki = $laki + 1;
			}
		}

		$data = array(
			'pr'		=> $pr,
			'laki'		=> $laki
		);

		return $data;
	}

	function getGuruPendikSkul($id,$jenjang,$pendik,$ids)
	{
		$data = array();

		$laki = 0;
		$pr = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,guru c WHERE a.id_school=c.id_school AND c.pend_guru='$pendik' AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.jenis_kendaraan<>'100' AND a.id_school='$ids' GROUP BY a.id_school");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 2)
			{
				$pr = $pr + 1;
			}
			else
			{
				$laki = $laki + 1;
			}
		}

		$data = array(
			'pr'		=> $pr,
			'laki'		=> $laki
		);

		return $data;
	}

	function getStatuseGuru($id,$jenjang,$status)
	{
		$data = array();

		$laki = 0;
		$pr = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,guru c WHERE a.id_school=c.id_school AND c.status_guru='2' AND c.status_peg='$status' AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.jenis_kendaraan<>'100' GROUP BY a.id_school");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 2)
			{
				$pr = $pr + 1;
			}
			else
			{
				$laki = $laki + 1;
			}
		}

		$data = array(
			'pr'		=> $pr,
			'laki'		=> $laki
		);

		return $data;
	}

	function getStatuseGuruSkul($id,$jenjang,$status,$ids)
	{
		$data = array();

		$laki = 0;
		$pr = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,guru c WHERE a.id_school=c.id_school AND c.status_guru='2' AND c.status_peg='$status' AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.jenis_kendaraan<>'100' AND a.id_school='$ids' GROUP BY a.id_school");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 2)
			{
				$pr = $pr + 1;
			}
			else
			{
				$laki = $laki + 1;
			}
		}

		$data = array(
			'pr'		=> $pr,
			'laki'		=> $laki
		);

		return $data;
	}

	function getGuruPel($id,$jenjang,$ids)
	{
		$data = array();

		$pns = 0;
		$bpns = 0;

		$kueri = $this->db->query("SELECT * FROM schools a,guru c WHERE a.id_school=c.id_school AND a.id_kecamatan='$id' AND a.jenjang_school='$jenjang' AND c.id_jabatan='$ids' AND c.jenis_kendaraan<>'100'");
		$hasil = $kueri->result();
		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->status_guru == 2 AND $dt_hasil->status_peg == 5)
			{
				$pns = $pns + 1;
			}
			elseif($dt_hasil->status_guru == 2 AND $dt_hasil->status_peg != 5)
			{
				$bpns = $bpns + 1;
			}
		}

		$data = array(
			'pns'		=> $pns,
			'bpns'		=> $bpns
		);

		return $data;
	}

	function getGuru($ids)
	{
		$kueri = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.jenjang_school='$ids' AND a.jenis_kendaraan<>'100' GROUP BY a.id_jabatan");
		return $kueri->result();
	}

	function getLapTabel1()
	{
		$kueri = $this->db->query("SELECT * FROM pauds");
		return $kueri->result();
	}

	function getLapTabel2()
	{
		$kueri = $this->db->query("SELECT * FROM pauds a,guru b WHERE a.id_pauds=b.id_school AND b.jenis_kendaraan='100'");
		return $kueri->result();
	}

	function getJumSiswaPaud($id,$ta)
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM siswa_paud WHERE id_pauds='$id' AND id_ta='$ta' ORDER BY id_siswa_paud DESC LIMIT 0,1");
		$hasil = $kueri->row();

		$data = array(
			'laki'		=> (isset($hasil->laki_paud))?$hasil->laki_paud:0,
			'perempuan'	=> $perempuan = (isset($hasil->perempuan_paud))?$hasil->perempuan_paud:0
		);

		return $data;
	}

	function getJumKelGuru($id)
	{
		$data = array();
		$laki = 0;
		$perempuan = 0;

		$kueri = $this->db->query("SELECT * FROM guru WHERE id_school='$id' AND jenis_kendaraan='100'");
		$hasil = $kueri->result();

		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->jenis_kel == 1)	
			{
				$laki = $laki + 1;
			}
			else
			{
				$perempuan = $perempuan + 1;
			}
		}

		$data = array(
			'laki'		=> $laki,
			'perempuan'	=> $perempuan
		);

		return $data;
	}

	function getJumPendikGuru($id)
	{
		$data = array();
		$sma = 0;
		$diploma = 0;
		$s1 = 0;

		$kueri = $this->db->query("SELECT * FROM guru WHERE id_school='$id' AND jenis_kendaraan='100'");
		$hasil = $kueri->result();

		foreach($hasil as $dt_hasil)
		{
			if($dt_hasil->pend_guru == 1)	
			{
				$sma = $sma + 1;
			}
			elseif($dt_hasil->pend_guru == 5)
			{
				$diploma = $diploma + 1;
			}
			else
			{
				$s1 = $s1 + 1;
			}
		}

		$data = array(
			'sma'		=> $sma,
			'diploma'	=> $diploma,
			's1'		=> $s1
		);

		return $data;
	}

	function getSkulKec($id,$jenjang)
	{
		$kec = ($id == 0)?"":" AND a.id_kecamatan='$id' ";

                $sql = "SELECT * FROM schools a,kecamatan b WHERE a.id_kecamatan=b.id_kecamatan $kec AND a.jenjang_school='$jenjang'";

                //echo $sql;

		$kueri = $this->db->query($sql);
		return $kueri->result();
	}

	function getNamaKec($id)
	{
		$kueri = $this->db->query("SELECT * FROM kecamatan WHERE id_kecamatan='$id'");
		$hasil = $kueri->row();
		$nama = isset($hasil->nama_kecamatan)?$hasil->nama_kecamatan:"";
		return $nama;
	}
}
?>
