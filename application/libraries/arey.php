<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Arey
{
	function Arey()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('marey','',TRUE);
	}
	
	function skpd($id="")
	{
		$arey = array(
			'all'			=> 'All',
			'1-150'			=> 'Dinas Pendidikan',
			'151-300'		=> 'BPBD',
			'301-450'		=> 'Dinsonakertrans',
			'451-600'		=> 'Dinpertan',
			'601-750'		=> 'Capil',
			'751-900'		=> 'Dinlutkan',
			'901-1050'		=> 'DPPKAD',
			'1051-1200'		=> 'Disbudpora',
			'1201-1350'		=> 'Disperindag',
			'1351-1500'		=> 'BPMPKB',
			'3601-3900'		=> 'SETDA',
			'1501-1650'		=> 'Dinas Kesehatan',
			'1651-1800'		=> 'Satpol PP',
			'1801-1950'		=> 'Dinas Ketahanan Pangan',
			'1951-2250'		=> 'Dinas Pekerjaan Umum',
			'2251-2400'		=> 'Dishubkominfo',
			'2401-2500'		=> 'Kec. Rembang',
			'2501-2600'		=> 'Kec. Sumber',
			'2601-2700'		=> 'Kec. Bulu',
			'2701-2800'		=> 'Kec. Sulang',
			'2801-2900'		=> 'Kec. Gunem',
			'2901-3000'		=> 'Kec. Pamotan',
			'3001-3100'		=> 'Kec. Sluke',
			'3101-3200'		=> 'Kec. Kragan',
			'3201-3300'		=> 'Kec. Sarang',
			'3301-3400'		=> 'Kec. Sedan',
			'3401-3500'		=> 'Kec. Pancur',
			'3501-3600'		=> 'Kec. Lasem'
		);

		if($id == "")
		{
			return $arey;
		}
		else
		{
			return $arey[$id];
		}
	}

	function all()
	{
		$arey = array('1-150','151-300','301-450','451-600','601-750','751-900','901-1050','1051-1200','1201-1350','1351-1500','3601-3900','1501-1650','1651-1800','1801-1950','1951-2250','2251-2400','2401-2500','2501-2600','2601-2700','2701-2800','2801-2900','2901-3000','3001-3100','3101-3200','3201-3300','3301-3400','3401-3500','3501-3600');

		return $arey;
	}

	function getInduk()
	{
		$data = array(
			'1'			=> 'Induk',
			'2'			=> 'Non Induk'
		);

		return $data;
	}

	function getJenisPaud($id="")
	{
		$data = array('KB','SPS','TK');

		if($id == "")
		{
			return $data;
		}		
		else
		{
			return $data[$id];
		}
	}

	function setjenisPaud($id)
	{
		$data = array('KB','SPS','TK');
		$key = array_search($id, $data); 
		return $key;
	}

	function getPemilikan($id="")
	{
		$data = array('Milik Sendiri','Pinjam Pakai/Sewa');

		if($id == "")
		{
			return $data;
		}		
		else
		{
			return $data[$id];
		}
	}

	function setPemilikan($id)
	{
		$data = array('Milik Sendiri','Pinjam Pakai/Sewa');

		$key = array_search($id, $data); 
		return $key;
	}

	function jam()
	{
		$data = array();

		for($i=1;$i<=24;$i++)
		{
			if(strlen($i) == 1)
			{
				$i = "0".$i;
			}
			else
			{
				$i = $i;
			}

			$data[$i] = $i;
		}

		return $data;
	}

	function menit()
	{
		$data = array();

		for($i=0;$i<=60;$i++)
		{
			if(strlen($i) == 1)
			{
				$i = "0".$i;
			}
			else
			{
				$i = $i;
			}
			
			$data[$i] = $i;
		}

		return $data;
	}

	function level()
	{
		$data = array(
			'2'		=> 'Operator',
			'1'		=> 'User',
			'0'		=> 'Admin'
		);
		return $data;
	}

	function getAkses()
	{
		$data = array(
			'0'			=> 'Deny',
			'1'			=> 'Allow'
		);

		return $data;
	}

	function getStatus($id="")
	{
		$data = array(
			'1'			=> 'Negeri',
			'2'			=> 'Swasta'
		);

		if($id == "")
		{
			return $data;
		}		
		else
		{
			if($id == 0)
			{
				return "Status Belum Dipilih";
			}
			else
			{
				return $data[$id];
			}			
		}
	}

	function setStatus($id)
	{
		$data = array(
			'1'			=> 'Negeri',
			'2'			=> 'Swasta'
		);

		$key = array_search($id, $data); 
		return $key;
	}

	function getStatusTa($id="")
	{
		$data = array(
			'1'			=> 'Aktif',
			'2'			=> 'Nonaktif'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}
	}

	function getJenjang($id="")
	{
		$data = array(
			'1'			=> 'SD/MI',
			'2'			=> 'SMP/MTs',
			'3'			=> 'SMA/MA',
			'4'			=> 'SMK'			
		);

		if($id == 0 OR $id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getJenjangId($id)
	{
		$data = array(
			'1'			=> 'SD/MI',
			'2'			=> 'SMP/MTs',
			'3'			=> 'SMA/MA',
			'4'			=> 'SMK'			
		);

		$nilai[$id] = $data[$id];

		return $nilai;
	}

	function getDetailJenjang($id="",$ids="")
	{		
		$data = array(
			'1'			=> array(
				'1'		=> 'SD',
				'2'		=> 'MI'
			),
			'2'			=> array(
				'1'		=> 'SMP',
				'2'		=> 'MTs'
			),
			'3'			=> array(
				'1'		=> 'SMA',
				'2'		=> 'MA'
			),
			'4'			=> array(
				'1'		=> 'SMK'				
			),
		);

		if($ids == "" && $id == "")
		{
			return $data;			
		}
		elseif($ids == "" && $id != "")
		{
			return $data[$id];
		}		
		else
		{
			return $data[$id][$ids];
		}		
	}

	function getSelekJenjang($id="")
	{
		$data = array();		

		if($id == 0)
		{
			$data = array('Data Belum Ditentukan,Silahkan hubungi administrator');
		}
		else
		{
			$sub = $this->getDetailJenjang($id);				
		
			foreach($sub as $kunci => $val)
			{				
				if(is_array($val))
				{
					foreach($val as $key => $value)	
					{						
						$data[$kunci."-".$key] = "Tingkat ".$this->getJenjang($kunci)." Jenjang ".$value;
					}
				}
				else
				{
					$main = $this->getJenjang($id);
					$data[$id."-".$kunci] = "Tingkat ".$main." Jenjang ".$val;
				}
			}					
		}		
		return $data;
	}

	function getJabatan($id="",$ids="")
	{
		$depan = ($ids == 1)?"":"Guru";

		$data = array(
			'1'			=> $depan.' Kelas',			
			'2'			=> $depan.' Penjaskes',
			'3'			=> $depan.' Agama Islam',
			'4'			=> $depan.' Agama Kristen Protestan',
			'5'			=> $depan.' Agama Katholik',
			'6'			=> $depan.' Agama Hindhu',
			'7'			=> $depan.' Agama Budha',
			'32'		=> $depan.' Agama Konghuchu',
			'8'			=> $depan.' Matematika',
			'9'			=> $depan.' Bahasa Indonesia',
			'10'		=> $depan.' IPA',
			'11'		=> $depan.' IPS',
			'12'		=> $depan.' PKn',
			'13'		=> $depan.' Bahasa Jawa',
			'14'		=> $depan.' SBK',
			'15'		=> $depan.' Fisika',
			'16'		=> $depan.' Kimia',
			'17'		=> $depan.' Bahasa Inggris',
			'18'		=> $depan.' Produktif',
			'19'		=> $depan.' BK',
			'20'		=> $depan.' Sosiologi',
			'21'		=> $depan.' Geografi',
			'22'		=> $depan.' Sejarah Nasional Umum',			
			'26'		=> $depan.' Kewirausahaan',
			'27'		=> $depan.' Prakarya',
			'28'		=> $depan.' TIK',
			'29'		=> $depan.' Ekonomi',
			'30'		=> $depan.' Biologi',
			'31'		=> $depan.' Mulok',
			'33'		=> $depan.' Biologi',
			'34'		=> $depan.' Sejarah Budaya',
			'35'		=> $depan.' Tata Negara',
			'36'		=> $depan.' Antro-pologi',
			'37'		=> $depan.' Pendidikan Seni',
			'38'		=> $depan.' Bahasa Asing Lain',
			'39'		=> $depan.' KTK',
		);

		if($id == "")
		{
			return $data;
		}
		elseif($id == 0)
		{
			return "Guru Kosong";
		}
		else
		{
			if (array_key_exists($id, $data)) {
			    return $data[$id];
			}else{
				return $data['1'];
			}			
		}		
	}

	function getStatusGuru($id="")
	{
		$data = array(
			'1'			=> 'Tenaga Administrasi[PNS]',
			'2'			=> 'Guru Tetap',
			'3'			=> 'Guru Tidak Tetap/Honor',			
			'4'			=> 'Tenaga Administrasi[Non PNS]',			
			'5'			=> 'Guru Bantu Pusat',
			'6'			=> 'Guru Bantu Daerah'
		);

		if($id == "")
		{
			return $data;
		}		
		else
		{
			return $data[$id];
		}
	}

	function getTenaga()
	{
		$data = array(
			'1'			=> 'Kepala Tata Usaha',
			'2'			=> 'Bendahara',
			'3'			=> 'Petugas Instalasi',
			'4'			=> 'Laboran',
			'5'			=> 'Petugas Perpustakaan',
			'6'			=> 'Juru Bengkel',
			'7'			=> 'Staff TU',
			'8'			=> 'Pesuruh/Penjaga',
			'9'			=> 'Perawat',
			'10'		=> 'Dokter'
		);

		return $data;
	}

	function getKendaraan()
	{
		$data = array(
			'1'			=> 'Jalan Kaki',
			'2'			=> 'Sepeda',
			'3'			=> 'Sepeda Motor',
			'4'			=> 'Angkutan Umum',
			'5'			=> 'Mobil'
		);

		return $data;
	}

	function getTingkatKelas()
	{
		$data = array(
			'1'			=> 'I',
			'2'			=> 'II',
			'3'			=> 'III',
			'4'			=> 'IV',
			'5'			=> 'V',
			'6'			=> 'VI'
		);

		return $data;
	}

	function getOperasi()
	{
		$data = array(
			'0'			=> 'Sama Dengan',
			'1'			=> 'Lebih kecil',
			'2'			=> 'Antara',
			'3'			=> 'Lebih besar'
		);

		return $data;
	}

	function getKelompok($id="")
	{
		$data = array(
			'1'			=> 'Teknologi dan Rekayasa',
			'2'			=> 'Teknologi Informasi dan Teknologi',
			'3'			=> 'Kesehatan',
			'4'			=> 'Seni, Kerajinan, dan Pariwisata',
			'5'			=> 'Agrobisnis dan Agroteknologi',
			'6'			=> 'Bisnis dan Manajemen'
		);
		
		if($id == "")
		{
			return $data;
		}
		elseif($id == 0)
		{
			return "Kelompok Tidak Ditemukan";	
		}
		else
		{
			return $data[$id];
		}		
	}

	function getSertifikat($id="")
	{
		$data = array(
			'1'			=> 'Belum Tersertifikasi',
			'2'			=> 'Dalam Prosesi Sertifikasi',
			'3'			=> '9001:2008',
			'4'			=> '9001:2000'
		);

		if($id == "")
		{
			return $data;
		}
		elseif($id == 0)
		{
			return $data['1'];
		}
		else
		{
			return $data[$id];
		}	
	}

	function getKlasifikasi()
	{
		$data = array(
			'1'			=> 'Terpencil',
			'2'			=> 'Daerah Sulit',
			'3'			=> 'Perkotaan',
			'4'			=> 'Pedesaan'
		);

		return $data;
	}

	function getAkreditasi($id="")
	{
		$data = array(
			'1'			=> 'A',
			'2'			=> 'B',
			'3'			=> 'C',
			'4'			=> 'Belum Akreditasi'
		);

		if($id == "")
		{
			return $data;
		}		
		else
		{
			if (array_key_exists($id, $data)) {
			    return $data[$id];
			}else{
				return $data['4'];
			}			
		}		
	}

	function getTanggal()
	{
		$data = array();

		for($i=1;$i<=31;$i++)
		{
			$data[$i] = $i;
		}

		return $data;
	}

	function getBulan()
	{
		$data = array();

		for($i=1;$i<=12;$i++)
		{
			$data[$i] = $i;
		}

		return $data;	
	}

	function getTahun()
	{
		$data = array();
		$thn = date("Y");

		for($i=$thn;$i>=$thn-100;$i--)
		{
			$data[$i] = $i;
		}

		return $data;	
	}

	function getTahunDiri()
	{
		$data = array();
		$thn = date("Y");

		for($i=$thn;$i>=$thn-150;$i--)
		{
			$data[$i] = $i;
		}

		return $data;
	}

	function getStatusPeg()
	{
		$data = array(
			'1'			=> 'Gol I',
			'2'			=> 'Gol II',
			'3'			=> 'Gol III',
			'4'			=> 'Gol IV',
			'5'			=> 'Yayasan',
			'6'			=> 'CPNS'
		);

		return $data;
	}

	function getStatusPegView()
	{
		$data = array(
			'1'			=> 'Gol I',
			'2'			=> 'Gol II',
			'3'			=> 'Gol III',
			'4'			=> 'Gol IV',
		);

		return $data;
	}

	function getJenis($id="")
	{
		$data = array(			
			'1'			=> 'Pemilikan dan Penggunaan',
			'2'			=> 'Buku dan Alat Pendidikan',
			'3'			=> 'Perlengkapan Administrasi',
			'4'			=> 'Ruang',
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}
	}

	function getKategori($id="")
	{
		$data = array(
			'1'			=> 'Hak Milik',
			'2'			=> 'Bukan Hak Milik',
			'3'			=> 'Pegangan Guru',
			'4'			=> 'Teks Siswa',
			'5'			=> 'Penunjang',
			'6'			=> 'Peraga Terhadap Kebutuhan Standard',
			'7'			=> 'Praktik(Paket)',
			'8'			=> 'Multimedia Base Content'			
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getSubsKategori($id="")
	{
		$data = array(
			'1'			=> 'Sertifikat',
			'2'			=> 'Belum Sertifikat',
			'3'			=> 'Jumlah Judul',
			'4'			=> 'Jumlah Eksemplar',
			'5'			=> 'Baik',
			'6'			=> 'Rusak Ringan',
			'7'			=> 'Rusak Berat'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getCobas($id="")
	{
		$data = array(
			'1'			=> 'Hak Milik',
			'2'			=> 'Bukan Hak Milik',
			'3'			=> 'Pegangan Guru',
			'4'			=> 'Teks Siswa',
			'5'			=> 'Penunjang',
			'6'			=> 'Peraga Terhadap Kebutuhan Standard',
			'7'			=> 'Praktik(Paket)',
			'8'			=> 'Multimedia Base Content',
			'9'			=> 'Sertifikat',
			'10'		=> 'Belum Sertifikat',
			'11'		=> 'Jumlah Judul',
			'12'		=> 'Jumlah Eksemplar',
			'13'		=> 'Baik',
			'14'		=> 'Rusak Ringan',
			'15'		=> 'Rusak Berat',
			'16'		=> 'Buku',
			'17'		=> 'Alat Pendidikan',
			'18'		=> 'Jumlah',
			'19'		=> 'Luas'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}
	}

	function getCoba($id="")
	{
		$data = array(
			'1'			=> array(
				'1'		=> array(
					'0'	=> '1',
					'1'	=> '9',
					'2'	=> '10'
				),
				'2'		=> '2'
			),
			'2'			=> array(
				'1'		=> array(
					'0'	=> '16',
					'1'	=> array(
						'0'	=> '3',
						'1'	=> '11',
						'2'	=> '12'
					),
					'2'	=> array(
						'0'	=> '4',
						'1'	=> '11',
						'2'	=> '12'
					),
					'3'	=> array(
						'0'	=> '5',
						'1'	=> '11',
						'2'	=> '12'
					)
				),
				'2'		=> array(
					'0'	=> '17',
					'1'	=> '6',
					'2'	=> '7',
					'3'	=> '8'
				)
			),
			'3'			=> '18',
			'4'			=> array(
				'1'		=> array(
					'0'	=> '1',
					'1'	=> array(
						'0'	=> '13',
						'1'	=> '18',
						'2'	=> '19'
					),
					'2'	=> array(
						'0'	=> '14',
						'1'	=> '18',
						'2'	=> '19'
					),
					'3'	=> array(
						'0'	=> '15',
						'1'	=> '18',
						'2'	=> '19'
					)
				),
				'2'		=> array(
					'0'	=> '2',
					'1'	=> '18',
					'2'	=> '19'
				)
			)
		);

		if($id == "")
		{
			return $data;
		}		
		else
		{
			return $data[$id];
		}
	}

	function getMenu($id)
	{
		return $this->ci->marey->getMenu($id);
	}

	function getJenisKue()
	{
		$data = array(
			'1'			=> 'Pendidikan Dasar oleh Kabupaten/Kota',
			'2'			=> 'Pendidikan Dasar oleh Satuan Pendidikan'
		);

		return $data;
	}

	function getPembilang()
	{
		$data = array();

		for($i=0;$i<5;$i++)
		{
			$data[$i] = $i;
		}

		return $data;
	}

	function getTunjangan()
	{
		$data = array(
			'0'			=> 'Tidak Mendapat Tunjangan',
			'1'			=> 'Mendapat Tunjangan Sertifikasi'
		);

		return $data;
	}

	function tahunSertif()
	{
		$data = array();
		$thn = date("Y");
		$awal = "2006";

		for($i=$thn;$i>=$awal;$i--)
		{
			$data[$i] = $i;
		}

		return $data;
	}

	function getJenisKel()
	{
		$data = array(
			'1'			=> 'Laki-laki',
			'2'			=> 'Perempuan'
		);

		return $data;
	}

	function getProvider($id="")
	{
		$data = array(
			'1'			=> 'Jardiknas',
			'2'			=> 'Telkom',
			'3'			=> 'Lainnya'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getKelompokY($id="")
	{
		$data = array(
			'1'			=> 'Aisyah',
			'2'			=> 'MPK Muhammadiyah',
			'3'			=> 'LP Maarif',
			'4'			=> 'ML Taman Siswa',
			'5'			=> 'MPPK',
			'6'			=> 'MNPK',
			'7'			=> 'Perwari',
			'8'			=> 'Dharma Pertiwi',
			'9'			=> 'YPLP PGRI',
			'10'		=> 'Lainnya'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}			
	}

	function getStatusMutu($id="")
	{
		$data = array(
			'1'			=> 'SPM',
			'2'			=> 'Pra SSN',
			'3'			=> 'SSN',
			'4'			=> 'RSBI',
			'5'			=> 'SBI'
		);

		if($id == "")
		{
			return $data;
		}
		elseif($id == 0)
		{
			return $data['1'];
		}
		else
		{
			return $data[$id];
		}		
	}

	function getKetegori($id="")
	{
		$data = array(
			'1'			=> 'SMP satu atap',
			'2'			=> 'Biasa',
			'3'			=> 'Terbuka'
		);

		if($id == "")
		{
			return $data;
		}
		elseif($id == 0)
		{
			return "";
		}
		else
		{
			return $data[$id];
		}		
	}

	function getWaktu($id="")
	{
		$data = array(
			'1'			=> 'Pagi',
			'2'			=> 'Siang',
			'3'			=> 'Kombinasi'
		);

		if($id == "")
		{
			return $data;
		}
		elseif($id == 0)
		{
			return $data['1'];
		}
		else
		{	
			return $data[$id];
		}		
	}

	function getWaktuWp()
	{
		$data = array(
			'1'			=> 'Sekolah Sendiri',
			'2'			=> 'Tempat Lain'
		);

		return $data;
	}

	function getWaktuPra()
	{
		$data = array(
			'1'			=> 'Lembaga Pemerintah',
			'2'			=> 'Lembaga Lain',
			'3'			=> 'Gabungan',
			'4'			=> 'Tidak Ada'
		);

		return $data;
	}

	function getKetSK($id="")
	{
		$data = array(
			'1'			=> 'Pemutihan',
			'2'			=> 'Penegerian',
			'3'			=> 'Alih Fungsi',
			'4'			=> 'Sekolah Baru',
			'5'			=> 'Perubahan Nama'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function YaTidak($id="")
	{
		$data = array(
			'1'			=> 'Ya',
			'2'			=> 'Tidak'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getDesa($id="")
	{
		$data = array(
			'1'			=> 'Desa',
			'2'			=> 'Kelurahan'
		);

		return $data[$id];
	}

	function getGeografis($id="")
	{
		$data = array(
			'1'			=> 'Terpencil',
			'2'			=> 'Daerah Terpencil',
			'3'			=> 'Perkotaan',
			'4'			=> 'Pedesaan'
		);

		return $data[$id];
	}

	function getadaTidak($id="")
	{
		$data = array(
			'1'			=> 'Ada',
			'2'			=> 'Tidak Ada'
		);

		if($id == 0)
		{
			return "Belum Ditentukan";
		}
		else
		{
			return $data[$id];
		}
	}

	function getGugus()
	{
		$data = array(
			'1'			=> 'Inti',
			'2'			=> 'Imbas',
			'3'			=> 'Belum Ikut'
		);

		return $data;
	}

	function getKurikulum()
	{
		$data = array(
			'3'			=> 'KTSP',			
			'4'			=> 'Kurikulum 2013',
			'2'			=> '2004(KBK)',						
		);

		return $data;
	}

	function getPendidikan($id="")
	{
		$data = array(
			'12'		=> 'Sekolah Dasar',
			'13'		=> 'SMP',
			'1'			=> 'SLTA Keguruan',
			'2'			=> 'SLTA Non Keguruan',
			'3'			=> 'Diploma 1',
			'4'			=> 'Diploma 2',
			'5'			=> 'Diploma 3 Keguruan',
			'6'			=> 'Diploma 3 Non Keguruan',
			'7'			=> 'Sarjana Keguruan',
			'8'			=> 'Sarjana Non Keguruan',
			'9'			=> 'S2 Keguruan',
			'10'		=> 'S2 Non Keguruan',
			'11'		=> 'S3'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getJenisLap()
	{
		/*$data = array(
			'1'			=> 'Laporan Kabupaten',
			'2'			=> 'Laporan Kecamatan'
		);*/

		$data = array(
			'1'			=> 'SPM dan Profil',
			'2'			=> 'Laporan RK 1 & 2',
			'3'			=> 'Laporan RK 3 & 4',
			'4'			=> 'Laporan RK 1 & 2 Kecamatan',
			'5'			=> 'Laporan RK 3 & 4 Kecamatan'
		);

		return $data;
	}

	function getJenisLapse()
	{
		$data = array(
			'1'			=> 'Laporan Kabupaten',
			'2'			=> 'Laporan Kecamatan'
		);

		return $data;
	}	

	function getJenisViewer()
	{
		$data = array(
			'1'			=> 'All',
			'2'			=> 'Berdasarkan Status',
			'3'			=> 'Berdasarkan Golongan',
			'4'			=> 'Berdasarkan Pendidikan',			
			'5'			=> 'Berdasarkan Sertifikasi',
			'6'			=> 'Guru Pensiun'
		);

		return $data;
	}

	function getNamaSebelumnya($id)
	{
		$hasil = array(
			'1'		=> array(
				'1'			=> 'Pendaftar Dari TK(Laki-Laki)',
				'2'			=> 'Pendaftar Dari TK(Perempuan)',
				'3'			=> 'Pendaftar Dari Bukan TK(Laki-laki)',
				'4'			=> 'Pendaftar Dari Bukan TK(Perempuan)',
				'5'			=> 'Siswa Dari TK(Laki-laki)',
				'6'			=> 'Siswa Dari TK(Perempuan)',
				'7'			=> 'Siswa Bukan Dari TK(Laki-laki)',
				'8'			=> 'Siswa Bukan Dari TK(Perempuan)'
			),
			'2'		=> array(
				'1'			=> 'Rencana Pendaftar (Laki-Laki)',
				'2'			=> 'Rencana Pendaftar (Perempuan)',
				'3'			=> 'Siswa Dari SD(Laki-laki)',
				'4'			=> 'Siswa Dari SD(Perempuan)',
				'5'			=> 'Siswa Dari MI(Laki-laki)',
				'6'			=> 'Siswa Dari MI(Perempuan)',
				'7'			=> 'Siswa Dari Kejar Paket A(Laki-laki)',
				'8'			=> 'Siswa Dari Kejar Paket A(Perempuan)'
			),
			'3'		=> array(
				'1'			=> 'Rencana Pendaftar (Laki-Laki)',
				'2'			=> 'Rencana Pendaftar (Perempuan)',
				'3'			=> 'Siswa Dari SMP(Laki-laki)',
				'4'			=> 'Siswa Dari SMP(Perempuan)',
				'5'			=> 'Siswa Dari MTs(Laki-laki)',
				'6'			=> 'Siswa Dari MTs(Perempuan)',
				'7'			=> 'Siswa Dari Kejar Paket B(Laki-laki)',
				'8'			=> 'Siswa Dari Kejar Paket B(Perempuan)'
			),
			'4'		=> array(
				'1'			=> 'Rencana Pendaftar (Laki-Laki)',
				'2'			=> 'Rencana Pendaftar (Perempuan)',
				'3'			=> 'Siswa Dari SMP(Laki-laki)',
				'4'			=> 'Siswa Dari SMP(Perempuan)',
				'5'			=> 'Siswa Dari MTs(Laki-laki)',
				'6'			=> 'Siswa Dari MTs(Perempuan)',
				'7'			=> 'Siswa Dari Kejar Paket(Laki-laki)',
				'8'			=> 'Siswa Dari Kejar Paket(Perempuan)'
			),
		);

		return $hasil[$id];
	}
}
