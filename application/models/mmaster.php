<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmaster extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function getSkul($kec,$kunci,$id,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		$data = array();

		if (empty($offset))
		{
			$offset=0;
		}

		$kunci = ($kunci != "kosong")?str_replace("-", " ", $kunci):"";
		$kunci = ($kunci == "kosong")?"":" AND nama_school LIKE '%".$kunci."%' ";

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('id_school');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'id_school';
		if($kec == 0)
		{
			$sql = "SELECT * FROM schools WHERE jenjang_school='$id' $kunci ORDER BY $sort_by $sort_order LIMIT $offset,$num";			
		}
		else
		{			
			$sql = "SELECT * FROM schools WHERE jenjang_school='$id' AND id_kecamatan='$kec' $kunci ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		}				
		$query = $this->db->query($sql);
		$hasil = $query->result();

		foreach($hasil as $dt_hasil)
		{
			$kuerikec = $this->db->query("SELECT * FROM kecamatan WHERE id_kecamatan='".$dt_hasil->id_kecamatan."'");
			$hasilkec = $kuerikec->row();
			$kecamatan = (isset($hasilkec->nama_kecamatan))?$hasilkec->nama_kecamatan:"";

			$data[] = array(
				'id_school'			=> $dt_hasil->id_school,
				'nama_school'		=> $dt_hasil->nama_school,
				'nama_kecamatan'	=> $kecamatan,
				'npsn_school'		=> $dt_hasil->npsn_school
			);
		}

		return $data;
	}

	function getNumJur($id)
	{
		$kueri = $this->db->query("SELECT * FROM prodi_sekolah WHERE id_school='$id'");
		return $kueri->num_rows();
	}

	/*function getJurSkule($id)
	{

	}*/

	function getNumSkul($id,$kec,$kunci)
	{
		$kunci = ($kunci != "kosong")?str_replace("-", " ", $kunci):"";
		$kunci = ($kunci == "kosong")?"":" AND nama_school LIKE '%".$kunci."%' ";

		if($kec == 0)
		{
			$sql = "SELECT * FROM schools WHERE jenjang_school='$id' $kunci";			
		}
		else
		{			
			$sql = "SELECT * FROM schools WHERE jenjang_school='$id' AND id_kecamatan='$kec' $kunci";
		}

		$kueri = $this->db->query($sql);
		//echo $kueri->num_rows();
		//exit();
		return $kueri->num_rows();
	}

	function getSkulPaud($kec,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('pauds.id_pauds');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'pauds.id_pauds';
		if($kec == 0)
		{
			$sql = "SELECT * FROM pauds ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		}
		else
		{
			$sql = "SELECT * FROM pauds WHERE id_kecamatan='$kec' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		}		
		$query = $this->db->query($sql);
		return $query->result();
	}	

	function getNumSkulPaud($kec)
	{	
		if($kec == 0)
		{
			$sql = "SELECT * FROM pauds";
		}
		else
		{
			$sql = "SELECT * FROM pauds WHERE id_kecamatan='$kec'";
		}		
		$kueri = $this->db->query($sql);
		return $kueri->num_rows();
	}

	function getPropinsi($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('propinsi.id_propinsi');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'propinsi.id_propinsi';
		$sql = "SELECT * FROM propinsi ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getKabupaten($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('kabupaten.id_kabupaten');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'kabupaten.id_kabupaten';
		$sql = "SELECT * FROM kabupaten INNER JOIN propinsi ON kabupaten.id_propinsi=propinsi.id_propinsi ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getKecamatan($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('kecamatan.id_kecamatan');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'kecamatan.id_kecamatan';
		$sql = "SELECT * FROM kecamatan INNER JOIN kabupaten ON kecamatan.id_kabupaten=kabupaten.id_kabupaten ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getTa($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('tahun_ajaran.id_ta');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'tahun_ajaran.id_ta';
		$sql = "SELECT * FROM tahun_ajaran ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getFasilitas($jenjang,$num,$offset,$sort_by,$sort_order)//menu admin
	{		
		$nilai = array();

		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('id_fasilitas');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'id_fasilitas';

		$sql = "SELECT * FROM fasilitas ORDER BY $sort_by $sort_order";		
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$jenjange = ($jenjang == 0)?"":" AND jenjang_school='$jenjang' ";
			
			$sql_detail = "SELECT * FROM detail_fasilitas WHERE id_fasilitas='".$dt->id_fasilitas."' $jenjange ";
			$detil = $this->db->query($sql_detail);
			$detils = $detil->result();

			if(count($detils) > 0)
			{
				$nilai[] = array(
					'id_fasilitas'			=> $dt->id_fasilitas,
					'nama_fasilitas'		=> $dt->nama_fasilitas,
					'jumlah_min_fasilitas'	=> $dt->jumlah_min_fasilitas,
					'jenis_fasilitas'		=> $dt->jenis_fasilitas,
					'detil'					=> $detils
				);
			}							
		}

		return array_slice($nilai, $offset, $num);
	}

	function getNumFasilitas($jenjang)//menu admin
	{		
		$nilai = array();
		
		$sql = "SELECT * FROM fasilitas";
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$jenjange = ($jenjang == 0)?"":" AND jenjang_school='$jenjang' ";

			$detil = $this->db->query("SELECT * FROM detail_fasilitas WHERE id_fasilitas='".$dt->id_fasilitas."' $jenjange ");
			$detils = $detil->result();

			if(count($detils) > 0)
			{
				$nilai[] = array(
					'id_fasilitas'			=> $dt->id_fasilitas,
					'nama_fasilitas'		=> $dt->nama_fasilitas,
					'jumlah_min_fasilitas'	=> $dt->jumlah_min_fasilitas,
					'detil'					=> $detils
				);
			}			
		}

		return count($nilai);
	}

	function getKuesioner($num,$offset,$sort_by,$sort_order)//menu admin
	{
		$nilai = array();

		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('kuesioner.id_kuesioner');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'kuesioner.id_kuesioner';
		$sql = "SELECT * FROM kuesioner ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$detil = $this->db->query("SELECT * FROM detail_kuesioner WHERE id_kuesioner='".$dt->id_kuesioner."'");
			$detils = $detil->result();

			$nilai[] = array(
				'id_kuesioner'			=> $dt->id_kuesioner,
				'text_kuesioner'		=> $dt->text_kuesioner,
				'jenis_kuesioner'		=> $dt->jawaban,
				'detil'					=> $detils
			);
		}

		return $nilai;
	}

	function getUmur($num,$offset,$sort_by,$sort_order)//menu admin
	{
		$nilai = array();

		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('umur.id_umur');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'umur.id_umur';
		$sql = "SELECT * FROM umur ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$detil = $this->db->query("SELECT * FROM detail_umur WHERE id_umur='".$dt->id_umur."'");
			$detils = $detil->result();

			if($dt->operasi_umur == 1)
			{
				$batas = "Kurang dari ".$dt->batas_awal." Tahun";
			}
			elseif($dt->operasi_umur == 2)
			{
				$batas = "Antara ".$dt->batas_awal." Tahun sampai ".$dt->batas_akhir." Tahun";
			}
			elseif($dt->operasi_umur == 3)
			{
				$batas = "Lebih dari dari ".$dt->batas_akhir." Tahun";
			}
			else
			{
				$batas = "Sama dengan ".$dt->batas_awal." Tahun";
			}

			$nilai[] = array(
				'id_umur'				=> $dt->id_umur,
				'id_tingkat'			=> $dt->id_tingkat,
				'jenis_umur'			=> $dt->jenis_umur,
				'batas'					=> $batas,
				'detil'					=> $detils
			);
		}

		return $nilai;
	}

	function getMapel($num,$offset,$sort_by,$sort_order)//menu admin
	{
		$nilai = array();

		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('mapel.id_mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'mapel.id_mapel';
		$sql = "SELECT * FROM mapel ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$detil = $this->db->query("SELECT * FROM detail_mapel WHERE id_mapel='".$dt->id_mapel."'");
			$detils = $detil->result();

			$nilai[] = array(
				'id_mapel'				=> $dt->id_mapel,				
				'nama_mapel'			=> $dt->nama_mapel,	
				'detil'					=> $detils
			);
		}

		return $nilai;		
	}

	function getProdi($num,$offset,$sort_by,$sort_order)//menu admin
	{
		$nilai = array();

		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('prodi.id_prodi');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'prodi.id_prodi';
		$sql = "SELECT * FROM prodi ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$detil = $this->db->query("SELECT * FROM detail_prodi WHERE id_prodi='".$dt->id_prodi."'");
			$detils = $detil->result();

			$nilai[] = array(
				'id_prodi'				=> $dt->id_prodi,				
				'bidang_prodi'			=> $dt->bidang_prodi,	
				'nama_prodi'			=> $dt->nama_prodi,	
				'kode_prodi'			=> $dt->kode_prodi,	
				'detil'					=> $detils
			);
		}

		return $nilai;		
	}

	function addSekolah()
	{
		$data = array(
			'id_school'			=> '',
			'nama_school'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'email_school'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('email',TRUE)))),
			'npsn_school'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE)))),
			'jenjang_school'	=> $this->input->post('jenjang',TRUE),
			'id_kecamatan'		=> $this->input->post('kecamatan',TRUE)
		);

		$this->db->insert('schools', $data); 
	}

	function importSekolah($data)
	{
		$this->db->insert('schools', $data); 	
	}

	function addPaud()
	{
		$data = array(
			'id_pauds'		=> '',
			'id_kecamatan'	=> $this->input->post('kecamatan',TRUE),
			'nama_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'status_paud'	=> $this->input->post('status',TRUE),
			'npns_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE)))),
			'alamat_paud'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE)))),
			'jenis_paud'	=> $this->input->post('jenis',TRUE),
			'milik_paud'	=> $this->input->post('milik',TRUE),
			'yayasan_paud'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama_y',TRUE)))),
			'kepala_paud'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama_p',TRUE)))),
			'ijin_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nomor_izin',TRUE))))
		);

		$this->db->insert('pauds', $data); 
	}

	function importPaud($data)
	{
		$this->db->insert('pauds', $data); 
	}

	function getIdKec($id)
	{
		$id = strtolower($id);
		$id = ucwords($id);
		$kueri = $this->db->query("SELECT * FROM kecamatan WHERE nama_kecamatan='$id'");
		$hasil = $kueri->row();
		$kode = (isset($hasil->id_kecamatan))?$hasil->id_kecamatan:1;
		return $kode;
	}

	function updatePaud($id)
	{
		$data = array(			
			'id_kecamatan'	=> $this->input->post('kecamatan',TRUE),
			'nama_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'status_paud'	=> $this->input->post('status',TRUE),
			'npns_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE)))),
			'alamat_paud'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE)))),
			'jenis_paud'	=> $this->input->post('jenis',TRUE),
			'milik_paud'	=> $this->input->post('milik',TRUE),
			'yayasan_paud'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama_y',TRUE)))),
			'kepala_paud'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama_p',TRUE)))),
			'ijin_paud'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nomor_izin',TRUE))))
		);

		$this->db->where('id_pauds', $id);
		$this->db->update('pauds', $data); 
	}

	function cekNpsn()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$npsn = strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE))));

		$kueri = $this->db->query("SELECT * FROM schools WHERE npsn_school='$npsn'");
		return $kueri->num_rows();
	}

	function cekNpsnAuto($id)
	{		
		$npsn = strip_tags(ascii_to_entities(addslashes($id)));

		$kueri = $this->db->query("SELECT * FROM schools WHERE npsn_school='$npsn'");
		return $kueri->num_rows();
	}

	function cekNpsnPaud()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$npsn = strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE))));

		$kueri = $this->db->query("SELECT * FROM pauds WHERE nama_paud='$nama' AND npns_paud='$npsn'");
		return $kueri->num_rows();
	}

	function cekNpsnPaudAuto($id)
	{
		$npsn = strip_tags(ascii_to_entities(addslashes($this->input->post($id,TRUE))));		

		$kueri = $this->db->query("SELECT * FROM pauds WHERE npns_paud='$npsn'");
		return $kueri->num_rows();
	}

	function addFasilitas()
	{
		$data = array(
			'id_fasilitas'			=> '',
			'jenis_fasilitas'		=> $this->input->post('jenis'),
			'nama_fasilitas'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'jumlah_min_fasilitas'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('jumlah',TRUE)))),
			'jum_penggunaan'		=> $this->input->post('penggunaan',TRUE)
		);

		$this->db->insert('fasilitas', $data); 
		
		$kode = $this->db->insert_id();		
		$jenjang = $this->input->post('jenjang');		
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_fasilitas'	=> '',
				'id_fasilitas'			=> $kode,				
				'jenjang_school'		=> $dt_jenjang
			);	

			$this->db->insert('detail_fasilitas', $data);
		}		
	}

	function addKuesioner()
	{
		$keterangan = $this->input->post('keterangan');

		if($this->input->post('pilihan',TRUE) == 1)
		{
			$pembilang = count($keterangan) - 1;
			$penyebut = 1;
		}
		else
		{
			$pembilang = count($keterangan);
			$penyebut = 0;
		}

		$data = array(
			'id_kuesioner'			=> '',
			'jenis_kuesioner'		=> $this->input->post('jenis',TRUE),
			'text_kuesioner'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('kuesioner',TRUE)))),
			'pembilang'				=> $pembilang,
			'penyebut'				=> $penyebut,
			'jawaban'				=> $this->input->post('jawaban',TRUE)
		);

		$this->db->insert('kuesioner', $data);

		$jenjang = $this->input->post('jenjang');
		$kode = $this->db->insert_id();						
				
		$no = 1;	
		foreach($keterangan as $key => $value)
		{
			$keterangan = strip_tags(ascii_to_entities(addslashes($value)));			
			$keterangan = trim($keterangan);

			if($keterangan != "")
			{
				$data = array(
					'id_ket_kuesioner'		=> '',
					'id_kuesioner'			=> $kode,					
					'level_ket_kuesioner'	=> $no,
					'text_ket_kuesioner'	=> $keterangan,
					'jenis_ket_kuesioner'	=> $this->input->post('provider',TRUE),
					'stat_ket_kuesioner'	=> $this->input->post('stat'.$key,TRUE),
					'ket_ket_kuesioner'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('keter',TRUE))))
				);			

				$this->db->insert('ket_kuesioner', $data);
				$kode1 = $this->db->insert_id();						

				//echo $this->input->post('stat'.$key,TRUE);

				if($this->input->post('stat'.$key,TRUE) == 2)
				{
					foreach($jenjang as $dt_jenjang)
					{					
						$detail = $this->arey->getDetailJenjang($dt_jenjang);

						foreach($detail as $kunci => $dt_detail)
						{	
							$data = array(
								'id_detail_kuesioner'			=> '',
								'id_ket_kuesioner'				=> $kode1,
								'id_kuesioner'					=> $kode,
								'jenjang_school'				=> $dt_jenjang,
								'detail_jenjang_kuesioner'		=> $kunci,
								'id_detail_jenjang'				=> $key
							);

							$this->db->insert('detail_kuesioner', $data);
						}
					}
				}													
				else
				{					
					foreach($jenjang as $dt_jenjang)
					{					
						$detail = $this->arey->getDetailJenjang($dt_jenjang);

						foreach($detail as $kunci => $dt_detail)
						{	
							if(preg_match("/".$dt_detail."/", $keterangan))
							{
								$data = array(
									'id_detail_kuesioner'		=> '',
									'id_ket_kuesioner'			=> $kode1,
									'id_kuesioner'				=> $kode,
									'jenjang_school'			=> $dt_jenjang,
									'detail_jenjang_kuesioner'	=> $kunci,
									'id_detail_jenjang'			=> $key
								);
					
								$this->db->insert('detail_kuesioner', $data);								
							}		
						}
					}
				}
				$no++;
			}
		}

		//exit();
	}

	function addPropinsi()
	{
		$data = array(
			'id_propinsi'			=> '',
			'nama_propinsi'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))
		);

		$this->db->insert('propinsi', $data); 
	}	

	function addKabupaten()
	{
		$data = array(
			'id_kabupaten'			=> '',
			'id_propinsi'			=> $this->input->post('propinsi',TRUE),
			'nama_kabupaten'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))
		);

		$this->db->insert('kabupaten', $data); 
	}

	function addKecamatan()
	{
		$data = array(
			'id_kecamatan'			=> '',
			'id_kabupaten'			=> $this->input->post('kabupaten',TRUE),
			'nama_kecamatan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'kode_kecamatan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('kode',TRUE))))
		);

		$this->db->insert('kecamatan', $data); 
	}

	function addTahun()
	{
		if($this->input->post('status',TRUE) == 1)
		{
			$kueri = $this->db->query("UPDATE tahun_ajaran SET status_ta='2'");
		}

		$data = array(
			'id_ta'				=> '',
			'nama_ta'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'status_ta'			=> $this->input->post('status',TRUE)
		);

		$this->db->insert('tahun_ajaran', $data); 
	}

	function addUmur()
	{
		$data = array(
			'id_umur'				=> '',			
			'id_tingkat'			=> $this->input->post('tingkat',TRUE),			
			'jenis_umur'			=> $this->input->post('jenis',TRUE),
			'batas_awal'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('awal',TRUE)))),
			'batas_akhir'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('akhir',TRUE)))),
			'operasi_umur'			=> $this->input->post('operasi',TRUE),
		);

		$this->db->insert('umur', $data); 	

		$jenjang = $this->input->post('jenjang');
		$kode = $this->db->insert_id();
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_umur'		=> '',
				'id_umur'				=> $kode,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_umur', $data);
		}	
	}

	function addMapel()
	{
		$data = array(
			'id_mapel'			=> '',
			'nama_mapel'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))
		);

		$this->db->insert('mapel', $data); 

		$jenjang = $this->input->post('jenjang');
		$kode = $this->db->insert_id();
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_mapel'		=> '',
				'id_mapel'				=> $kode,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_mapel', $data);
		}
	}

	function addProdi()
	{
		$data = array(
			'id_prodi'			=> '',
			'bidang_prodi'		=> $this->input->post('kelompok',TRUE),
			'nama_prodi'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'kode_prodi'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('kode',TRUE))))
		);

		$this->db->insert('prodi', $data); 

		$jenjang = $this->input->post('jenjang');
		$kode = $this->db->insert_id();
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_prodi'		=> '',
				'id_prodi'				=> $kode,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_prodi', $data);
		}
	}

	function editSekolah($id)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_school='$id'");
		return $kueri->row();
	}

	function editPaud($id)
	{
		$kueri = $this->db->query("SELECT * FROM pauds WHERE id_pauds='$id'");
		return $kueri->row();
	}

	function editPropinsi($id)
	{
		$kueri = $this->db->query("SELECT * FROM propinsi WHERE id_propinsi='$id'");
		return $kueri->row();
	}

	function editFasilitas($id)
	{
		$detail = array();

		$kueri = $this->db->query("SELECT * FROM fasilitas WHERE id_fasilitas='$id'");
		$data = $kueri->row();
		$detil = $this->db->query("SELECT jenjang_school FROM detail_fasilitas WHERE id_fasilitas='".$data->id_fasilitas."'");
		$detils = $detil->result();
		foreach($detils as $dt_detils)
		{
			$detail[] = $dt_detils->jenjang_school;
		}

		$hasil = array(
			'id_fasilitas'			=> $data->id_fasilitas,
			'nama_fasilitas'		=> $data->nama_fasilitas,
			'jumlah_min_fasilitas'	=> $data->jumlah_min_fasilitas,
			'jum_penggunaan'		=> $data->jum_penggunaan,
			'jenis_fasilitas'		=> $data->jenis_fasilitas,
			'detil'					=> $detail
		);

		return $hasil;
	}

	function editKuesioner($id)
	{
		$detail = array();

		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE id_kuesioner='$id'");
		$data = $kueri->row();
		$detil = $this->db->query("SELECT jenjang_school FROM detail_kuesioner WHERE id_kuesioner='".$data->id_kuesioner."'");
		$detils = $detil->result();
		foreach($detils as $dt_detils)
		{
			$detail[] = $dt_detils->jenjang_school;
		}

		$hasil = array(
			'id_kuesioner'			=> $data->id_kuesioner,
			'text_kuesioner'		=> $data->text_kuesioner,			
			'detil'					=> $detail
		);

		return $hasil;
	}

	function editKue($id)
	{
		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE id_kuesioner='$id'");
		$hasil = $kueri->row();

		$data = array(
			'pembilang'		=> (isset($hasil->pembilang))?$hasil->pembilang:0,
			'penyebut'		=> (isset($hasil->penyebut))?$hasil->penyebut:0
		);

		return $data;
	}

	function editUmur($id)
	{
		$detail = array();

		$kueri = $this->db->query("SELECT * FROM umur WHERE id_umur='$id'");
		$data = $kueri->row();
		$detil = $this->db->query("SELECT jenjang_school FROM detail_umur WHERE id_umur='".$data->id_umur."'");
		$detils = $detil->result();
		foreach($detils as $dt_detils)
		{
			$detail[] = $dt_detils->jenjang_school;
		}

		$hasil = array(
			'id_umur'			  	=> $data->id_umur,
			'id_tingkat'			=> $data->id_tingkat,
			'batas_awal'			=> $data->batas_awal,
			'batas_akhir'			=> $data->batas_akhir,
			'operasi_umur'			=> $data->operasi_umur,
			'jenis_umur'			=> $data->jenis_umur,
			'detil'					=> $detail
		);

		return $hasil;
	}

	function editMapel($id)
	{
		$detail = array();

		$kueri = $this->db->query("SELECT * FROM mapel WHERE id_mapel='$id'");
		$data = $kueri->row();
		$detil = $this->db->query("SELECT jenjang_school FROM detail_mapel WHERE id_mapel='".$data->id_mapel."'");
		$detils = $detil->result();
		foreach($detils as $dt_detils)
		{
			$detail[] = $dt_detils->jenjang_school;
		}

		$hasil = array(
			'id_mapel'			  	=> $data->id_mapel,
			'nama_mapel'			=> $data->nama_mapel,
			'detil'					=> $detail
		);

		return $hasil;
	}

	function editProdi($id)
	{
		$detail = array();

		$kueri = $this->db->query("SELECT * FROM prodi WHERE id_prodi='$id'");
		$data = $kueri->row();
		$detil = $this->db->query("SELECT jenjang_school FROM detail_prodi WHERE id_prodi='".$data->id_prodi."'");
		$detils = $detil->result();
		foreach($detils as $dt_detils)
		{
			$detail[] = $dt_detils->jenjang_school;
		}

		$hasil = array(
			'id_prodi'			  	=> $data->id_prodi,
			'bidang_prodi'			=> $data->bidang_prodi,
			'nama_prodi'			=> $data->nama_prodi,
			'kode_prodi'			=> $data->kode_prodi,
			'detil'					=> $detail
		);

		return $hasil;
	}

	function editKabupaten($id)
	{
		$kueri = $this->db->query("SELECT * FROM kabupaten WHERE id_kabupaten='$id'");
		return $kueri->row();
	}

	function editKecamatan($id)
	{
		$kueri = $this->db->query("SELECT * FROM kecamatan WHERE id_kecamatan='$id'");
		return $kueri->row();
	}

	function editTahun($id)
	{
		$kueri = $this->db->query("SELECT * FROM tahun_ajaran WHERE id_ta='$id'");
		return $kueri->row();
	}
	
	function cekNpsns($id)
	{
		$npsn = strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE))));

		$kueri = $this->db->query("SELECT * FROM schools WHERE npsn_school='$npsn'");
		$kueri1 = $this->db->query("SELECT * FROM schools WHERE npsn_school='$npsn' AND id_school='$id'");
		if($kueri->num_rows() > 0)
		{
			if($kueri1->num_rows() > 0)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}			
		}		
		else
		{
			return FALSE;
		}
	}

	function cekNpsnsPaud($id)
	{
		$npsn = strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE))));

		$kueri = $this->db->query("SELECT * FROM pauds WHERE npns_paud='$npsn'");
		$kueri1 = $this->db->query("SELECT * FROM pauds WHERE npns_paud='$npsn' AND id_pauds='$id'");
		if($kueri->num_rows() > 0)
		{
			if($kueri1->num_rows() > 0)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}			
		}		
		else
		{
			return FALSE;
		}
	}

	function updateSekolah($id)
	{
		$data = array(
            'nama_school'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
            'email_school'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('email',TRUE)))),
			'npsn_school'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('npsn',TRUE)))),
            'jenjang_school'	=> $this->input->post('jenjang',TRUE),
            'id_kecamatan'		=> $this->input->post('kecamatan',TRUE)
       	);

		$this->db->where('id_school', $id);
		$this->db->update('schools', $data); 
	}

	function updateFasilitas($id)
	{
		$data = array(
			'jenis_fasilitas'		=> $this->input->post('jenis'),
            'nama_fasilitas'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
            'jumlah_min_fasilitas'	=> strip_tags(ascii_to_entities(addslashes($this->input->post('jumlah',TRUE)))),
            'jum_penggunaan'		=> $this->input->post('penggunaan',TRUE)
       	);

		$this->db->where('id_fasilitas', $id);
		$this->db->update('fasilitas', $data); 

		$delete = $this->db->query("DELETE FROM detail_fasilitas WHERE id_fasilitas='".$id."'");

		$jenjang = $this->input->post('jenjang');
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_fasilitas'	=> '',
				'id_fasilitas'			=> $id,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_fasilitas', $data);
		}		
	}

	function updateKuesioner($id)
	{
		$data = array(
            'text_kuesioner'		=> $this->input->post('editor',TRUE)            
       	);

		$this->db->where('id_kuesioner', $id);
		$this->db->update('kuesioner', $data); 

		$delete = $this->db->query("DELETE FROM detail_kuesioner WHERE id_kuesioner='".$id."'");

		$jenjang = $this->input->post('jenjang');
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_kuesioner'	=> '',
				'id_kuesioner'			=> $id,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_kuesioner', $data);
		}		
	}	

	function update_kue($id)
	{
		$data = array(
            'pembilang' 	=> strip_tags(ascii_to_entities(addslashes($this->input->post('pembilang',TRUE)))),
            'penyebut' 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('penyebut',TRUE))))
        );

		$this->db->where('id_kuesioner', $id);
		$this->db->update('kuesioner', $data); 
	}

	function updatePropinsi($id)
	{
		$data = array(
            'nama_propinsi'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))
       	);

		$this->db->where('id_propinsi', $id);
		$this->db->update('propinsi', $data); 
	}

	function updateKabupaten($id)
	{
		$data = array(
			'id_propinsi'			=> $this->input->post('propinsi',TRUE),
            'nama_kabupaten'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))
       	);

		$this->db->where('id_kabupaten', $id);
		$this->db->update('kabupaten', $data); 
	}

	function updateKecamatan($id)
	{
		$data = array(
			'id_kabupaten'			=> $this->input->post('kabupaten',TRUE),
            'nama_kecamatan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
            'kode_kecamatan'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('kode',TRUE))))
       	);

		$this->db->where('id_kecamatan', $id);
		$this->db->update('kecamatan', $data); 
	}

	function updateTahun($id)
	{
		if($this->input->post('status',TRUE) == 1)
		{
			$this->db->query("UPDATE tahun_ajaran SET status_ta='2'");
		}

		$data = array(
			'nama_ta'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
            'status_ta'			=> $this->input->post('status',TRUE)
       	);

		$this->db->where('id_ta', $id);
		$this->db->update('tahun_ajaran', $data); 
	}

	function updateUmur($id)
	{
		$data = array(
            'id_tingkat'			=> $this->input->post('tingkat',TRUE),			
            'jenis_umur'			=> $this->input->post('jenis',TRUE),			
			'batas_awal'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('awal',TRUE)))),
			'batas_akhir'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('akhir',TRUE)))),
			'operasi_umur'			=> $this->input->post('operasi',TRUE),
       	);

		$this->db->where('id_umur', $id);
		$this->db->update('umur', $data); 

		$delete = $this->db->query("DELETE FROM detail_umur WHERE id_umur='".$id."'");

		$jenjang = $this->input->post('jenjang');
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_umur'		=> '',
				'id_umur'				=> $id,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_umur', $data);
		}		
	}

	function updateMapel($id)
	{
		$data = array(       
			'nama_mapel'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))
       	);

		$this->db->where('id_mapel', $id);
		$this->db->update('mapel', $data); 

		$delete = $this->db->query("DELETE FROM detail_mapel WHERE id_mapel='".$id."'");

		$jenjang = $this->input->post('jenjang');
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_mapel'		=> '',
				'id_mapel'				=> $id,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_mapel', $data);
		}
	}

	function updateProdi($id)
	{
		$data = array(       
			'bidang_prodi'			=> $this->input->post('kelompok',TRUE),
			'nama_prodi'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'kode_prodi'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('kode',TRUE))))
       	);

		$this->db->where('id_prodi', $id);
		$this->db->update('prodi', $data); 

		$delete = $this->db->query("DELETE FROM detail_prodi WHERE id_prodi='".$id."'");

		$jenjang = $this->input->post('jenjang');
		foreach($jenjang as $dt_jenjang)
		{
			$data = array(
				'id_detail_prodi'		=> '',
				'id_prodi'				=> $id,
				'jenjang_school'		=> $dt_jenjang
			);

			$this->db->insert('detail_prodi', $data);
		}
	}

	function setTahun($id,$val)
	{
		if($val == 1)
		{
			$this->db->query("UPDATE tahun_ajaran SET status_ta='2'");
		}

		$sql = "UPDATE tahun_ajaran SET status_ta='$val' WHERE id_ta='$id'";
		$this->db->query($sql);
	}

	function deleteSchool($id)
	{
		$kueri = $this->db->query("DELETE FROM schools WHERE id_school='$id'");
		return $kueri;
		$kueri1 = $this->db->query("DELETE FROM users WHERE id_school='$id'");
		return $kueri1;
	}

	function deletePaud($id)
	{
		$kueri = $this->db->query("DELETE FROM pauds WHERE id_pauds='$id'");
		return $kueri;
	}

	function deletePropinsi($id)
	{
		$kueri = $this->db->query("DELETE FROM propinsi WHERE id_propinsi='$id'");
		return $kueri;
	}

	function deleteKabupaten($id)
	{
		$kueri = $this->db->query("DELETE FROM kabupaten WHERE id_kabupaten='$id'");
		return $kueri;
	}

	function deleteKecamatan($id)
	{
		$kueri = $this->db->query("DELETE FROM kecamatan WHERE id_kecamatan='$id'");
		return $kueri;
	}

	function deleteTahun($id)
	{
		$kueri = $this->db->query("DELETE FROM tahun_ajaran WHERE id_ta='$id'");
		return $kueri;
	}

	function deleteFasilitas($id)
	{
		$kueri = $this->db->query("DELETE FROM fasilitas WHERE id_fasilitas='$id'");
		$kueri1 = $this->db->query("DELETE FROM detail_fasilitas WHERE id_fasilitas='$id'");
		return $kueri1;
	}

	function deleteKuesioner($id)
	{
		$kueri = $this->db->query("DELETE FROM kuesioner WHERE id_kuesioner='$id'");
		$kueri1 = $this->db->query("DELETE FROM detail_kuesioner WHERE id_kuesioner='$id'");
		$kueri2 = $this->db->query("DELETE FROM ket_kuesioner WHERE id_kuesioner='$id'");
		return $kueri2;
	}

	function deleteUmur($id)
	{
		$kueri = $this->db->query("DELETE FROM umur WHERE id_umur='$id'");
		$kueri1 = $this->db->query("DELETE FROM detail_umur WHERE id_umur='$id'");
		return $kueri1;
	}

	function deleteMapel($id)
	{
		$kueri = $this->db->query("DELETE FROM mapel WHERE id_mapel='$id'");
		$kueri1 = $this->db->query("DELETE FROM detail_mapel WHERE id_mapel='$id'");
		return $kueri1;
	}

	function deleteProdi($id)
	{
		$kueri = $this->db->query("DELETE FROM prodi WHERE id_prodi='$id'");
		$kueri1 = $this->db->query("DELETE FROM detail_prodi WHERE id_prodi='$id'");
		return $kueri1;
	}

	function getSelekProp()
	{
		$query = $this->db->query("SELECT * FROM propinsi ORDER BY id_propinsi ASC");

		if ($query->num_rows()> 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_propinsi']] = $row['nama_propinsi'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function getSelekKab()
	{
		$query = $this->db->query("SELECT * FROM kabupaten ORDER BY id_kabupaten ASC");

		if ($query->num_rows()> 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_kabupaten']] = $row['nama_kabupaten'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function getSelekKec()
	{
		$query = $this->db->query("SELECT * FROM kecamatan ORDER BY id_kecamatan ASC");

		if ($query->num_rows()> 0)
		{	
			$data[0] = "Pilih Kecamatan";

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
}
?>