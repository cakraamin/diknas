<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msiswa extends CI_Model{

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

	function getSelekKec()
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

	function getJumSiswaPaud($id)
	{
		$kueri = $this->db->query("SELECT * FROM siswa_paud WHERE id_ta='$id'");
		return $kueri->num_rows();
	}

	function getSiswaPaud($ta,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.id_pauds');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.id_pauds';
		$sql = "SELECT * FROM pauds a,siswa_paud b WHERE a.id_pauds=b.id_pauds AND b.id_ta='$ta' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function updateSekolah($id,$thn)
	{
		$status = $this->input->post('status');
		$jenjang = $this->input->post('jenjang');
		$lintang = strip_tags(ascii_to_entities(addslashes($this->input->post('lintang',TRUE))));
		$bujur = strip_tags(ascii_to_entities(addslashes($this->input->post('bujur',TRUE))));

		$kueri = $this->db->query("UPDATE schools SET status_school='$status',jenjang_school='$jenjang',lintang_school='$lintang',bujur_school='$bujur' WHERE id_school='$id'");

		$data = array(
			'id_detail_school'		=> '',
			'id_school'				=> $id,
			'id_guru'				=> $this->input->post('kepala',TRUE),
			'id_ta_school'			=> $thn,
			'date_school'			=> date('Y-m-d')
		);

		$this->db->insert('detail_schools', $data);
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

	function addDetailSiswa($id)
	{
		$indeks = $this->input->post('jumlah');
		$kelassss = $this->input->post('kelassss');

		$delSiswa = $this->db->query("DELETE FROM siswa WHERE id_school='".$this->session->userdata('id_school')."' AND id_ta='$id' AND id_tingkat='$indeks'");

		$data = array(
		   'id_siswa' 			=> '',
		   'id_school' 			=> $this->session->userdata('id_school'),
		   'id_ta'				=> $id,
		   'id_tingkat'			=> $indeks,
		   'laki_siswa' 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('laki_'.$indeks)))),
		   'perempuan_siswa'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('pr_'.$indeks)))),
		   'rombel_siswa'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('rombel_'.$indeks)))),
		   'mengulang_siswa_laki'=> strip_tags(ascii_to_entities(addslashes($this->input->post('mengulang_lk_'.$indeks)))),
		   'mengulang_siswa_pr'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('mengulang_pr_'.$indeks)))),
		   'putus_siswa_laki'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('kel_lk_'.$indeks)))),
		   'putus_siswa_pr'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('kel_pr_'.$indeks)))),
		   'masuk_siswa'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('masuk_'.$indeks)))),
		   'keluar_siswa'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('keluar_'.$indeks))))
		);

		$this->db->insert('siswa', $data);
		$kode = $this->db->insert_id();		

		if($indeks == 1)
		{
			$last = $this->db->insert_id();
			
			$delTkSiswa = $this->db->query("DELETE FROM tk WHERE id_siswa='$last'");

			$data = array(
			   'id_tk' 				=> '',
			   'id_siswa' 			=> $last,
			   'daftar_no_tk_lk' 	=> strip_tags(ascii_to_entities(addslashes($this->input->post('daftar_no_tk_lk_'.$indeks)))),
			   'daftar_no_tk_pr' 	=> strip_tags(ascii_to_entities(addslashes($this->input->post('daftar_no_tk_pr_'.$indeks)))),
			   'daftar_tk_lk'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('daftar_tk_lk_'.$indeks)))),
			   'daftar_tk_pr'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('daftar_tk_pr_'.$indeks)))),
			   'peserta_no_tk_lk'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('siswa_no_tk_lk_'.$indeks)))),
			   'peserta_no_tk_pr'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('siswa_no_tk_pr_'.$indeks)))),
			   'peserta_tk_lk'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('siswa_tk_lk_'.$indeks)))),
			   'peserta_tk_pr'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('siswa_tk_pr_'.$indeks))))
			);

			$this->db->insert('tk', $data); 
		}

		if($this->input->post('detilss') != "")
		{
			$detil = $this->input->post('detilss');	

			foreach($detil as $dt)
			{
				$delDetSiswa = $this->db->query("DELETE FROM detail_siswa WHERE id_siswa='$kode' AND id_detail_umur='$dt'");

				$data = array(
				   'id_detail_siswa'	=> '',
				   'id_siswa' 			=> $kode,
				   'id_detail_umur'		=> $dt,
				   'laki_detail_siswa'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('detill_'.$dt)))),
				   'pr_detail_siswa'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('detilp_'.$dt))))
				);

				$this->db->insert('detail_siswa', $data); 			
			}
		}	

		if($this->input->post('detilssp') != "")
		{
			$nilai = $this->input->post('detilssp');

			foreach($nilai as $dt_nilai)
			{
				$delDetSiswa = $this->db->query("DELETE FROM prodi_school WHERE id_detail_prodi='$dt_nilai' AND id_siswa='$kode' AND id_tingkat='$indeks' AND id_school='".$this->session->userdata('id_school')."'");

				$data = array(
				   'id_prodi_school'	=> '',
				   'id_detail_prodi'	=> $dt_nilai,
				   'id_school'			=> $this->session->userdata('id_school'),
				   'id_siswa'			=> $kode,
				   'id_tingkat'			=> $indeks,
				   'peserta_l'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('detilp_'.$dt_nilai)))),
				   'peserta_p'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('detilp_'.$dt_nilai)))),
				   'lulus_l'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('detilpl_'.$dt_nilai)))),
				   'lulus_p'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('detilpl_'.$dt_nilai))))
				);

				$this->db->insert('prodi_school', $data); 				
			}
		}		
	}

	function addDetailUmurSiswa($id)
	{		
		$delSiswa = $this->db->query("DELETE FROM siswa WHERE id_school='".$this->session->userdata('id_school')."' AND id_ta='$id' AND id_tingkat='0'");

		$data = array(
		   'id_siswa' 				=> '',
		   'id_school' 				=> $this->session->userdata('id_school'),
		   'id_ta'					=> $id,
		   'id_tingkat'				=> 0,
		   'laki_siswa' 			=> 0,
		   'perempuan_siswa'		=> 0,
		   'rombel_siswa'			=> 0,
		   'mengulang_siswa_laki'	=> 0,
		   'mengulang_siswa_pr'		=> 0,
		   'putus_siswa_laki'		=> 0,
		   'putus_siswa_pr'			=> 0,
		   'masuk_siswa'			=> 0,
		   'keluar_siswa'			=> 0
		);

		$this->db->insert('siswa', $data);
		$kode = $this->db->insert_id();				

		if($this->input->post('detilss') != "")
		{
			$detil = $this->input->post('detilss');	

			foreach($detil as $dt)
			{
				$delDetSiswa = $this->db->query("DELETE FROM detail_siswa WHERE id_siswa='$kode' AND id_detail_umur='$dt'");

				$data = array(
				   'id_detail_siswa'	=> '',
				   'id_siswa' 			=> $kode,
				   'id_detail_umur'		=> $dt,
				   'laki_detail_siswa'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('detill_'.$dt)))),
				   'pr_detail_siswa'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('detilp_'.$dt))))
				);

				$this->db->insert('detail_siswa', $data); 			
			}
		}	
	}

	function addAsalSiswa($id)
	{		
		$delSiswa = $this->db->query("DELETE FROM asal_school WHERE id_school='".$this->session->userdata('id_school')."' AND id_ta='$id'");

		$data = array(
		   'id_asal_school'			=> '',
		   'id_school' 				=> $this->session->userdata('id_school'),
		   'id_ta'					=> $id,
		   'dalam_kota'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('dalam_kota')))),
		   'luar_kota'	 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('luar_kota'))))
		);

		$this->db->insert('asal_school', $data);		
	}

	function addDetailAgama($id)
	{
		$indeks = $this->input->post('jumlah');
		$kelassss = $this->input->post('kelassss');		

		$delSiswa = $this->db->query("DELETE FROM agama WHERE id_school='".$this->session->userdata('id_school')."' AND id_ta='$id' AND id_tingkat='$indeks'");

		$data = array(
		   'id_agama' 			=> '',
		   'id_school' 			=> $this->session->userdata('id_school'),
		   'id_ta'				=> $id,
		   'id_tingkat'			=> $indeks,
		   'islam'		 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('islam_'.$indeks)))),
		   'kristen'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('kristen_'.$indeks)))),
		   'katholik'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('katholik_'.$indeks)))),
		   'budha'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('budha_'.$indeks)))),
		   'hindu'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('hindu_'.$indeks)))),
		   'konghuchu'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('konghuchu_'.$indeks)))),		   
		);

		$this->db->insert('agama', $data);		
	}

	function addSiswaPaud($id)
	{
		$data = array(
			'id_siswa_paud'			=> '',
			'id_ta'					=> $id,
			'id_pauds'				=> $this->input->post('sekolah'),
			'laki_paud'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('laki_paud')))),
			'perempuan_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('perempuan_paud'))))
		);

		$this->db->insert('siswa_paud', $data); 
	}

	function updateSiswaPaud($id,$ta)
	{
		$data = array(			
			'id_ta'					=> $ta,
			'id_pauds'				=> $this->input->post('sekolah'),
			'laki_paud'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('laki_paud')))),
			'perempuan_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('perempuan_paud'))))
		);

		$this->db->where('id_siswa_paud', $id);
		$this->db->update('siswa_paud', $data); 
	}

	function getDetailSiswa($id,$kelas,$jenjang,$kelompok,$jenis)
	{		
		unset($nilai);
		$nilai = array();			

		for($i=1;$i<=$kelas;$i++)
		{			
			unset($daftar);
			$daftar = array();				

			$sql = "SELECT * FROM siswa WHERE id_ta='$id' AND id_tingkat='$i' AND id_school='".$this->session->userdata('id_school')."' ORDER BY id_siswa DESC LIMIT 0,1";		
			$kueri = $this->db->query($sql);
			//if($kueri->num_rows() > 0)
			//{
				$data = $kueri->row();				
				$id_siswa = (isset($data->id_siswa))?$data->id_siswa:0;

				if($i == 1)
				{										
					$tk = $this->db->query("SELECT * FROM tk WHERE id_siswa='".$id_siswa."' ORDER BY id_tk DESC");
					$dt_tk = $tk->row();
					$daftar_tk_lk = (isset($dt_tk->daftar_tk_lk))?$dt_tk->daftar_tk_lk:"";
					$daftar_tk_pr = (isset($dt_tk->daftar_tk_pr))?$dt_tk->daftar_tk_pr:"";
					$daftar_no_tk_lk = (isset($dt_tk->daftar_no_tk_lk))?$dt_tk->daftar_no_tk_lk:"";
					$daftar_no_tk_pr = (isset($dt_tk->daftar_no_tk_pr))?$dt_tk->daftar_no_tk_pr:"";
					$peserta_tk_lk = (isset($dt_tk->peserta_tk_lk))?$dt_tk->peserta_tk_lk:"";
					$peserta_tk_pr = (isset($dt_tk->peserta_tk_pr))?$dt_tk->peserta_tk_pr:"";
					$peserta_no_tk_lk = (isset($dt_tk->peserta_no_tk_lk))?$dt_tk->peserta_no_tk_lk:"";
					$peserta_no_tk_pr = (isset($dt_tk->peserta_no_tk_pr))?$dt_tk->peserta_no_tk_pr:"";

					$daftar = array(
						'daftar_tk_lk'		=> $daftar_tk_lk,
						'daftar_tk_pr'		=> $daftar_tk_pr,
						'daftar_no_tk_lk'	=> $daftar_no_tk_lk,
						'daftar_no_tk_pr'	=> $daftar_no_tk_pr,
						'peserta_tk_lk'		=> $peserta_tk_lk,
						'peserta_tk_pr'		=> $peserta_tk_pr,
						'peserta_no_tk_lk'	=> $peserta_no_tk_lk,
						'peserta_no_tk_pr'	=> $peserta_no_tk_pr
					);
				}

				unset($umur);
				$umur = array();	

				$sql_umur = "SELECT * FROM umur a,detail_umur b WHERE a.id_umur=b.id_umur AND a.id_tingkat='$id' AND b.jenjang_school='$jenjang' AND a.jenis_umur='1'";				
				$kueri_umur = $this->db->query($sql_umur);
				$kueri_umur = $kueri_umur->result();
				foreach($kueri_umur as $dt_umur)
				{
					$sql_umur_siswa = $this->db->query("SELECT * FROM detail_siswa WHERE id_detail_umur='".$dt_umur->id_detail_umur."' AND id_siswa='".$id_siswa."'");
					$dsiswa = $sql_umur_siswa->row();

					$laki = (isset($dsiswa->laki_detail_siswa))?$dsiswa->laki_detail_siswa:"";
					$pr = (isset($dsiswa->pr_detail_siswa))?$dsiswa->pr_detail_siswa:"";

					if($dt_umur->operasi_umur == 1)
					{
						$batas = "Kurang dari ".$dt_umur->batas_awal." Tahun";
					}
					elseif($dt_umur->operasi_umur == 2)
					{
						$batas = "Antara ".$dt_umur->batas_awal." Tahun sampai ".$dt_umur->batas_akhir." Tahun";
					}
					elseif($dt_umur->operasi_umur == 3)
					{
						$batas = "Lebih dari dari ".$dt_umur->batas_akhir." Tahun";
					}
					else
					{
						$batas = "Sama dengan ".$dt_umur->batas_awal." Tahun";
					}

					$umur[] = array(
						'batas'				=> $batas,
						'id_detail_umur'	=> $dt_umur->id_detail_umur,
						'laki'				=> $laki,
						'pr'				=> $pr
					);
				}				

				$pprodi = explode("-", $kelompok);
				foreach($pprodi as $dt_prodi)
				{
					unset($prodi);
					$prodi = array();

					$kueri_prodi = $this->db->query("SELECT * FROM prodi a,detail_prodi b WHERE a.id_prodi=b.id_prodi AND a.bidang_prodi='$dt_prodi'");
					$hasil_prodi = $kueri_prodi->result();
					foreach($hasil_prodi as $dt_prodi_skul)
					{
						$prodi = $this->getJumSiswaProdi($dt_prodi_skul->nama_prodi,$id_siswa,$dt_prodi_skul->id_detail_prodi,$i);
					}	
				}

				$jurusan = array();
				if($jenjang == 3 && $jenis != 0)
				{
					$jurusan[] = array(
						'ipa'		=> $this->getJumSiswaProdi('ipa',$id_siswa,1001,$i),
						'ips'		=> $this->getJumSiswaProdi('ips',$id_siswa,1002,$i)
					);

					if($jenis == 1)
					{
						$jurusan[] = array(
							'bahasa'		=> $this->getJumSiswaProdi('bahasa',$id_siswa,1003,$i)					
						);
					}
					elseif($jenis == 2)
					{
						$jurusan[] = array(
							'keagamaan'		=> $this->getJumSiswaProdi('keagamaan',$id_siswa,1004,$i)					
						);
					}					
				}				

				$nilai[$i] = array(
					'laki'			=> (isset($data->laki_siswa))?$data->laki_siswa:"",
					'pr'			=> (isset($data->perempuan_siswa))?$data->perempuan_siswa:"",
					'rombel'		=> (isset($data->rombel_siswa))?$data->rombel_siswa:"",
					'ulang_lk'		=> (isset($data->mengulang_siswa_laki))?$data->mengulang_siswa_laki:"",
					'ulang_pr'		=> (isset($data->mengulang_siswa_pr))?$data->mengulang_siswa_pr:"",
					'kel_lk'		=> (isset($data->putus_siswa_laki))?$data->putus_siswa_laki:"",
					'kel_pr'		=> (isset($data->putus_siswa_pr))?$data->putus_siswa_pr:"",
					'masuk'			=> (isset($data->masuk_siswa))?$data->masuk_siswa:"",
					'keluar'		=> (isset($data->keluar_siswa))?$data->keluar_siswa:"",
					'daftar'		=> $daftar,
					'umur'			=> $umur,
					'prodi'			=> $prodi,
					'jurusn'		=> $jurusan
				);
			//}			
		}		

		return $nilai;
	}

	function getDetailUmurSiswa($id,$jenjang,$kelompok,$jenis)
	{					
		$sql = "SELECT * FROM siswa WHERE id_ta='$id' AND id_school='".$this->session->userdata('id_school')."' ORDER BY id_siswa DESC LIMIT 0,1";						
		$kueri = $this->db->query($sql);
			
		$data = $kueri->row();				
		$id_siswa = (isset($data->id_siswa))?$data->id_siswa:0;				

		unset($umur);
		$umur = array();	

		//$sql_umur = "SELECT * FROM umur a,detail_umur b WHERE a.id_umur=b.id_umur AND a.id_tingkat='$id' AND b.jenjang_school='$jenjang' AND a.jenis_umur='0'";						
		$sql_umur = "SELECT * FROM umur a,detail_umur b WHERE a.id_umur=b.id_umur AND b.jenjang_school='$jenjang' AND a.jenis_umur='0'";								
		$kueri_umur = $this->db->query($sql_umur);
		$kueri_umur = $kueri_umur->result();
		foreach($kueri_umur as $dt_umur)
		{
			$sql_umur_siswa = $this->db->query("SELECT * FROM detail_siswa WHERE id_detail_umur='".$dt_umur->id_detail_umur."' AND id_siswa='".$id_siswa."'");
			$dsiswa = $sql_umur_siswa->row();

			$laki = (isset($dsiswa->laki_detail_siswa))?$dsiswa->laki_detail_siswa:"";
			$pr = (isset($dsiswa->pr_detail_siswa))?$dsiswa->pr_detail_siswa:"";

			if($dt_umur->operasi_umur == 1)
			{
				$batas = "Kurang dari ".$dt_umur->batas_awal." Tahun";
			}
			elseif($dt_umur->operasi_umur == 2)
			{
				$batas = "Antara ".$dt_umur->batas_awal." Tahun sampai ".$dt_umur->batas_akhir." Tahun";
			}
			elseif($dt_umur->operasi_umur == 3)
			{
				$batas = "Lebih dari dari ".$dt_umur->batas_akhir." Tahun";
			}
			else
			{
				$batas = "Sama dengan ".$dt_umur->batas_awal." Tahun";
			}

			$umur[] = array(
				'batas'				=> $batas,
				'id_detail_umur'	=> $dt_umur->id_detail_umur,
				'laki'				=> $laki,
				'pr'				=> $pr
			);
		}				

		return $umur;
	}

	function getDetailAsal($ta,$id)
	{
		$kueri = $this->db->query("SELECT * FROM asal_school WHERE id_ta='$ta' AND id_school='$id'");
		$data = $kueri->row();

		$hasil = array(
			'dalam_kota'		=> (isset($data->dalam_kota))?$data->dalam_kota:"",
			'luar_kota'			=> (isset($data->luar_kota))?$data->luar_kota:"",
		);

		return $hasil;
	}

	function getDetailAgama($id,$kelas,$jenjang,$kelompok,$jenis)
	{		
		unset($nilai);
		$nilai = array();			

		for($i=1;$i<=$kelas;$i++)
		{			
			unset($daftar);
			$daftar = array();				

			$sql = "SELECT * FROM agama WHERE id_ta='$id' AND id_tingkat='$i' AND id_school='".$this->session->userdata('id_school')."' ORDER BY id_agama DESC LIMIT 0,1";								
			$kueri = $this->db->query($sql);
			$data = $kueri->row();
			
			$nilai[$i] = array(
				'islam'			=> (isset($data->islam))?$data->islam:"",
				'kristen'		=> (isset($data->kristen))?$data->kristen:"",
				'katholik'		=> (isset($data->katholik))?$data->katholik:"",
				'budha'			=> (isset($data->budha))?$data->budha:"",
				'hindu'			=> (isset($data->hindu))?$data->hindu:"",
				'konghuchu'		=> (isset($data->konghuchu))?$data->konghuchu:"",				
			);		
		}		
				
		return $nilai;
	}

	function getJumSiswaProdi($nama,$id_siswa,$detail_prodi,$i)
	{
		$prodi = array();

		$kuei_jum_prodi = $this->db->query("SELECT * FROM prodi_school WHERE id_siswa='$id_siswa' AND id_detail_prodi='$detail_prodi' AND id_school='".$this->session->userdata('id_school')."' AND id_tingkat='$i'");
		$hasil_jum_prodi = $kuei_jum_prodi->row();

		$prodi[] = array(
			'nama_prodi'		=> $nama,
			'id_detail_prodi'	=> $detail_prodi,
			'peserta'			=> (isset($hasil_jum_prodi->peserta_l))?$hasil_jum_prodi->peserta_l:"",
			'lulus'				=> (isset($hasil_jum_prodi->lulus_l))?$hasil_jum_prodi->lulus_l:""
		);

		return $prodi;
	}

	function getDetailSiswaPaud($id)
	{
		$kueri = $this->db->query("SELECT * FROM siswa_paud");	

		return $nilai;
	}

	function getUmur($id,$tahun)
	{
		$data = array();

		$kueri = $this->db->query("SELECT a.id_tingkat,b.id_detail_umur FROM umur a,detail_umur b WHERE a.id_umur=b.id_umur AND b.jenjang_school='$id' GROUP BY a.id_tingkat");
		$hasil = $kueri->result();		
		foreach($hasil as $dt_hasil)
		{
			unset($nilai);
			$nilai = array();

			$detail = $this->db->query("SELECT a.batas_awal,a.operasi_umur,a.batas_akhir,b.id_detail_umur FROM umur a,detail_umur b WHERE a.id_umur=b.id_umur AND b.jenjang_school='$id' AND a.id_tingkat='".$dt_hasil->id_tingkat."'");
			$details = $detail->result();			

			foreach($details as $dt_details)
			{
				$sql = "SELECT detail_siswa.laki_detail_siswa,detail_siswa.pr_detail_siswa FROM siswa LEFT JOIN detail_siswa ON siswa.id_siswa=detail_siswa.id_siswa WHERE siswa.id_ta='".$tahun."' AND siswa.id_tingkat='".$dt_hasil->id_tingkat."' AND siswa.id_school='".$this->session->userdata('id_school')."' AND detail_siswa.id_detail_umur='".$dt_details->id_detail_umur."' ORDER BY siswa.id_siswa DESC LIMIT 0,1";
				$siswa = $this->db->query($sql);
				$dsiswa = $siswa->row();
				$laki = (isset($dsiswa->laki_detail_siswa))?$dsiswa->laki_detail_siswa:"";
				$pr = (isset($dsiswa->pr_detail_siswa))?$dsiswa->pr_detail_siswa:"";

				if($dt_details->operasi_umur == 1)
				{
					$batas = "Kurang dari ".$dt_details->batas_awal." Tahun";
				}
				elseif($dt_details->operasi_umur == 2)
				{
					$batas = "Antara ".$dt_details->batas_awal." Tahun sampai ".$dt_details->batas_akhir." Tahun";
				}
				elseif($dt_details->operasi_umur == 3)
				{
					$batas = "Lebih dari dari ".$dt_details->batas_akhir." Tahun";
				}
				else
				{
					$batas = "Sama dengan ".$dt_details->batas_awal." Tahun";
				}

				$nilai[] = array(
					'batas'				=> $batas,
					'id_detail_umur'	=> $dt_details->id_detail_umur,
					'laki'				=> $laki,
					'pr'				=> $pr
				);				
			}

			$data[$dt_hasil->id_tingkat] = $nilai;
		}

		return $data;
	}

	function getProdi($id,$kelas,$tahun)
	{
		$data = array();

		for($i=1;$i<=$kelas;$i++)
		{
			unset($nilai);
			$nilai = array();

			$sql_skule = $this->db->query("SELECT * FROM schools WHERE id_school='".$this->session->userdata('id_school')."'");
			$query_skule = $sql_skule->row();

			if(isset($query_skule->kelompok_school))
			{
				$pecah = explode("-", $query_skule->kelompok_school);

				foreach($pecah as $dt_pecah)
				{
					if($dt_pecah != "")
					{
						$sql = "SELECT b.id_detail_prodi,a.id_prodi,a.nama_prodi,a.kode_prodi FROM prodi a,detail_prodi b WHERE a.id_prodi=b.id_prodi AND b.jenjang_school='$id' AND a.bidang_prodi='".$dt_pecah."'";
						$kueri = $this->db->query($sql);
						$hasil = $kueri->result();
						foreach($hasil as $dt_hasil)
						{				
							$sql = "SELECT * FROM detail_prodi a,prodi_school b WHERE a.id_detail_prodi=b.id_detail_prodi AND a.id_detail_prodi='".$dt_hasil->id_detail_prodi."' AND b.id_tingkat='".$i."' AND b.id_ta='$tahun' AND b.id_school='".$this->session->userdata('id_school')."' ORDER BY b.id_prodi_school DESC";
							$detail = $this->db->query($sql);
							$hasil_detail = $detail->row();
							$peserta = (isset($hasil_detail->peserta))?$hasil_detail->peserta:"";
							$lulus = (isset($hasil_detail->lulus))?$hasil_detail->lulus:"";
							
							$nilai[] = array(
								'id_prodi'			=> $dt_hasil->id_prodi,
								'id_detail_prodi'	=> $dt_hasil->id_detail_prodi,
								'nama_prodi'		=> $dt_hasil->nama_prodi,
								'kode_prodi'		=> $dt_hasil->kode_prodi,
								'peserta'			=> $peserta,
								'lulus'				=> $lulus
							);				
						}
						$data[$i] = $nilai;
					}
				}				
			}			
		}				
		return $data;
	}

	function getNonProdi($id,$kelas,$tahun)
	{
		$data = array();

		$school = $this->session->userdata('id_school');
		$sql = "SELECT * FROM prodi_school WHERE id_ta='$tahun' AND id_tingkat='$kelas' AND id_school='$school' AND id_detail_prodi='0' ORDER BY id_prodi_school DESC";
		$kueri = $this->db->query($sql);
		$hasil = $kueri->row();
		$peserta_l = (isset($hasil->peserta_l))?$hasil->peserta_l:"";
		$peserta_p = (isset($hasil->peserta_p))?$hasil->peserta_p:"";
		$lulus_l = (isset($hasil->lulus_l))?$hasil->lulus_l:"";
		$lulus_p = (isset($hasil->lulus_p))?$hasil->lulus_p:"";
		$id_detail_prodi = (isset($hasil->id_detail_prodi))?$hasil->id_detail_prodi:0;
		$data = array(
			'id_detail_prodi'	=> $id_detail_prodi,
			'peserta_l'			=> $peserta_l,
			'peserta_p'			=> $peserta_p,
			'lulus_l'			=> $lulus_l,
			'lulus_p'			=> $lulus_p
		);

		return $data;
	}

	function getDaftarSkul()
	{
		$query = $this->db->query("SELECT * FROM pauds ORDER BY id_pauds ASC");

		if ($query->num_rows()> 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_pauds']] = $row['nama_paud'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function editSiswaPaud($id)
	{
		$kueri = $this->db->query("SELECT * FROM siswa_paud WHERE id_siswa_paud='$id'");
		return $kueri->row();
	}

	function deleteSiswaPaud($id)
	{
		$kueri = $this->db->query("DELETE FROM siswa_paud WHERE id_siswa_paud='$id'");
		return $kueri;
	}
}
?>