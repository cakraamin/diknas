<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mhome extends CI_Model
{
	function Mhome()
	{
		parent::__construct();
	}	

	public function getSess($user)
	{
		$kueri = $this->db->query("SELECT * FROM users WHERE user_email='$user'");

		return $kueri->row();
	}

	public function getCekSess($user,$token)
	{
		$sql = "SELECT * FROM token WHERE kode_token='$token' AND username='$user'";		

		$kueri = $this->db->query($sql);

		if(count($kueri->result()) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getAkhirSess($id)
	{
		$kueri = $this->db->query("SELECT * FROM token WHERE username='$id' ORDER BY id_tokens DESC");

		return $kueri->row();

		//umur guru
		//SELECT nama_guru, TIMESTAMPDIFF( YEAR, tgl_lahir, CURDATE( ) ) AS age FROM guru WHERE tgl_lahir <= now() - INTERVAL 50 YEAR
	}

	public function getAkhirUser()
	{
		$kueri = $this->db->query("SELECT c.nama_school,a.date_token FROM token a,users b,schools c WHERE a.username=b.user_email AND b.id_school=c.id_school GROUP BY a.username ORDER BY a.id_tokens DESC LIMIT 0,5");

		return $kueri->result();
	}

	public function getGraphicHome()
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM kecamatan");
		$data = $kueri->result();
		foreach($data as $key => $dt)
		{
			$hasil[$dt->nama_kecamatan] = array(
				'smk'		=> $this->jumSkulKec($dt->id_kecamatan,4),
				'smama'		=> $this->jumSkulKec($dt->id_kecamatan,3),
				'smpmts'	=> $this->jumSkulKec($dt->id_kecamatan,2),
				'sdmi'		=> $this->jumSkulKec($dt->id_kecamatan,1),
			);
		}

		return $hasil;
	}

	private function jumSkulKec($id,$kode)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$id' AND jenjang_school='$kode'");
		return $kueri->num_rows();
	}

	public function getStatusSek($id)
	{
		$sql = "SELECT * FROM users a,schools b WHERE a.id_school=b.id_school AND a.user_email='$id'";		
		$kueri = $this->db->query($sql);

		if($kueri->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function getGuru($viewer)
	{
		$data = array();

		if($viewer == 1)
		{
			$kueri = $this->db->query("SELECT * FROM kecamatan");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				unset($jk);
				$jk = array();

				$jenjang = $this->arey->getJenjang();
				foreach($jenjang as $key => $dt_jenjang)
				{
					$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='".$key."' AND a.jenis_kel=1");
					$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='".$key."' AND a.jenis_kel=2");

					$jk[$key] = array(
						'laki'		=> $que_guru_laki->num_rows(),
						'peremp'	=> $que_guru_premp->num_rows()
					);
				}				

				$data[$dt_kueri->nama_kecamatan."-".$dt_kueri->id_kecamatan] = $jk;
			}			
		}
		elseif($viewer == 2)
		{
			$kueri = $this->db->query("SELECT * FROM kecamatan");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				$que_tt_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=1 AND (a.status_guru=3 OR a.status_guru=4)");
				$que_tt_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=2 AND (a.status_guru=3 OR a.status_guru=4)");

				$que_ty_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=1 AND (a.status_guru=5 OR (a.status_guru=2 AND a.status_peg=5))");
				$que_ty_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=2 AND (a.status_guru=5 OR (a.status_guru=2 AND a.status_peg=5))");

				$que_pns_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=1 AND (a.status_guru=1 OR (a.status_guru=2 AND a.status_peg<>5))");
				$que_pns_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=2 AND (a.status_guru=1 OR (a.status_guru=2 AND a.status_peg<>5))");

				$data[$dt_kueri->nama_kecamatan."-".$dt_kueri->id_kecamatan] = array(
					'tt'	=> array(
						'laki'		=> $que_tt_laki->num_rows(),
						'peremp'	=> $que_tt_premp->num_rows()
					),
					'ty'	=> array(
						'laki'		=> $que_ty_laki->num_rows(),
						'peremp'	=> $que_ty_premp->num_rows()
					),
					'pns'	=> array(
						'laki'		=> $que_pns_laki->num_rows(),
						'peremp'	=> $que_pns_premp->num_rows()
					)
				);
			}								
		}
		elseif($viewer == 3)
		{
			$jenjang = $this->arey->getJenjang();
			foreach($jenjang as $key => $dt_jenjang)
			{
				unset($camat);
				$camat = array();

				$kueri = $this->db->query("SELECT * FROM kecamatan");
				$h_kueri = $kueri->result();
				foreach($h_kueri as $dt_kueri)
				{
					unset($jk);
					$jk = array();

					$golongan = $this->arey->getStatusPegView();
					foreach($golongan as $kunci => $dt_gol)
					{
						$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=1 AND a.status_peg='$kunci' AND b.jenjang_school='$key'");
						$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=2 AND a.status_peg='$kunci' AND b.jenjang_school='$key'");

						$jk[$dt_gol."-".$kunci] = array(
							'laki'		=> $que_guru_laki->num_rows(),
							'peremp'	=> $que_guru_premp->num_rows()
						);
					}

					$camat[$dt_kueri->nama_kecamatan."-".$dt_kueri->id_kecamatan] = $jk;
				}

				$data[$dt_jenjang."-".$key] = $camat;
			}							
		}
		elseif($viewer == 4)
		{
			$jenjang = $this->arey->getJenjang();
			foreach($jenjang as $key => $dt_jenjang)
			{
				unset($camat);
				$camat = array();

				$kueri = $this->db->query("SELECT * FROM kecamatan");
				$h_kueri = $kueri->result();
				foreach($h_kueri as $dt_kueri)
				{
					unset($jk);
					$jk = array();
					
					$didik = array(
						'1'			=> array(
								'kue'		=> "AND (a.pend_guru='1' OR a.pend_guru='2')",
								'judul'		=> "SLTA"
							),
						'2'			=> array(
								'kue'		=> "AND (a.pend_guru='7' OR a.pend_guru='8')",
								'judul'		=> 'Sarjana'
							),
						'3'			=> array(
								'kue'		=> "AND (a.pend_guru='5' OR a.pend_guru='6')",
								'judul'		=> 'Diploma'
							),
						'4'			=> array(
								'kue'		=> "AND (a.pend_guru='9' OR a.pend_guru='10')",
								'judul'		=> 'Magister'
							),
						'5'			=> array(
								'kue'		=> "AND a.pend_guru='11'",
								'judul'		=> 'Doktor'
							)
					);
					foreach($didik as $kunci => $dt_didik)
					{
						$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=1 ".$dt_didik['kue']." AND b.jenjang_school='$key'");
						$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND a.jenis_kel=2 ".$dt_didik['kue']." AND b.jenjang_school='$key'");

						$jk[$dt_didik['judul']."-".$kunci] = array(
							'laki'		=> $que_guru_laki->num_rows(),
							'peremp'	=> $que_guru_premp->num_rows()
						);
					}

					$camat[$dt_kueri->nama_kecamatan."-".$dt_kueri->id_kecamatan] = $jk;
				}

				$data[$dt_jenjang."-".$key] = $camat;
			}							
		}
		elseif($viewer == 5)
		{
			$jenjang = $this->arey->getJenjang();
			foreach($jenjang as $key => $dt_jenjang)
			{
				unset($camat);
				$camat = array();

				$kueri = $this->db->query("SELECT * FROM kecamatan");
				$h_kueri = $kueri->result();
				foreach($h_kueri as $dt_kueri)
				{
					unset($jk);
					$jk = array();

					for($i=2006;$i<=2014;$i++)
					{
						$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='$key' AND a.tunjangan_guru=1 AND a.tahun_tunjangan='$i'");						

						$jk[$i] = array(
							'jumlah'		=> $que_guru->num_rows(),							
						);
					}

					$camat[$dt_kueri->nama_kecamatan."-".$dt_kueri->id_kecamatan] = $jk;
				}

				$data[$dt_jenjang."-".$key] = $camat;
			}	
		}
		else
		{
			$kueri = $this->db->query("SELECT * FROM kecamatan");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				unset($jk);
				$jk = array();

				$jenjang = $this->arey->getJenjang();
				foreach($jenjang as $key => $dt_jenjang)
				{
					$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='".$key."' AND a.jenis_kel=1 AND a.tgl_lahir <= now() - INTERVAL 60 YEAR");
					$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='".$key."' AND a.jenis_kel=2 AND a.tgl_lahir <= now() - INTERVAL 60 YEAR");

					$jk[$key] = array(
						'laki'		=> $que_guru_laki->num_rows(),
						'peremp'	=> $que_guru_premp->num_rows()
					);
				}				

				$data[$dt_kueri->nama_kecamatan."-".$dt_kueri->id_kecamatan] = $jk;
			}	
		}

		return $data;
	}

	public function getDetailGuru($viewer,$kec,$id)
	{
		$data = array();

		if($viewer == 1)
		{
			$kueri = $this->db->query("SELECT * FROM kecamatan");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				unset($jk);
				$jk = array();

				$jenjang = $this->arey->getJenjang();
				foreach($jenjang as $key => $dt_jenjang)
				{
					$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='".$key."' AND a.jenis_kel=1");
					$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$dt_kueri->id_kecamatan."' AND b.jenjang_school='".$key."' AND a.jenis_kel=2");

					$jk[$key] = array(
						'laki'		=> $que_guru_laki->num_rows(),
						'peremp'	=> $que_guru_premp->num_rows()
					);
				}				

				$data[$dt_kueri->nama_kecamatan] = $jk;
			}			
		}
		elseif($viewer == 2)
		{
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' ORDER BY nama_school ASC");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				$que_tt_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=1 AND (a.status_guru=3 OR a.status_guru=4)");
				$que_tt_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=2 AND (a.status_guru=3 OR a.status_guru=4)");

				$que_ty_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=1 AND (a.status_guru=5 OR (a.status_guru=2 AND a.status_peg=5))");
				$que_ty_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=2 AND (a.status_guru=5 OR (a.status_guru=2 AND a.status_peg=5))");

				$que_pns_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=1 AND (a.status_guru=1 OR (a.status_guru=2 AND a.status_peg<>5))");
				$que_pns_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=2 AND (a.status_guru=1 OR (a.status_guru=2 AND a.status_peg<>5))");

				$data[$dt_kueri->nama_school."-".$dt_kueri->id_school] = array(
					'tt'	=> array(
						'laki'		=> $que_tt_laki->num_rows(),
						'peremp'	=> $que_tt_premp->num_rows()
					),
					'ty'	=> array(
						'laki'		=> $que_ty_laki->num_rows(),
						'peremp'	=> $que_ty_premp->num_rows()
					),
					'pns'	=> array(
						'laki'		=> $que_pns_laki->num_rows(),
						'peremp'	=> $que_pns_premp->num_rows()
					)
				);
			}								
		}
		elseif($viewer == 3)
		{			
			unset($camat);
			$camat = array();

			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' AND jenjang_school='$id' ORDER BY nama_school ASC");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				unset($jk);
				$jk = array();

				$golongan = $this->arey->getStatusPegView();
				foreach($golongan as $kunci => $dt_gol)
				{
					$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=1 AND a.status_peg='$kunci' AND b.jenjang_school='$id'");
					$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=2 AND a.status_peg='$kunci' AND b.jenjang_school='$id'");

					$jk[$dt_gol."-".$kunci] = array(
						'laki'		=> $que_guru_laki->num_rows(),
						'peremp'	=> $que_guru_premp->num_rows()
					);
				}

				$data[$dt_kueri->nama_school."-".$dt_kueri->id_school] = $jk;
			}			
		}
		elseif($viewer == 4)
		{			
			unset($camat);
			$camat = array();

			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' AND jenjang_school='$id' ORDER BY nama_school ASC");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				unset($jk);
				$jk = array();

				//$didik = $this->arey->getPendidikan();
				$didik = array(
						'1'			=> array(
								'kue'		=> "AND (a.pend_guru='1' OR a.pend_guru='2')",
								'judul'		=> "SLTA"
							),
						'2'			=> array(
								'kue'		=> "AND (a.pend_guru='7' OR a.pend_guru='8')",
								'judul'		=> 'Sarjana'
							),
						'3'			=> array(
								'kue'		=> "AND (a.pend_guru='5' OR a.pend_guru='6')",
								'judul'		=> 'Diploma'
							),
						'4'			=> array(
								'kue'		=> "AND (a.pend_guru='9' OR a.pend_guru='10')",
								'judul'		=> 'Magister'
							),
						'5'			=> array(
								'kue'		=> "AND a.pend_guru='11'",
								'judul'		=> 'Doktor'
							)
					);
				foreach($didik as $kunci => $dt_didik)
				{
					$que_guru_laki = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=1 ".$dt_didik['kue']." AND b.jenjang_school='$id'");
					$que_guru_premp = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND a.jenis_kel=2 ".$dt_didik['kue']." AND b.jenjang_school='$id'");

					$jk[$dt_didik['judul']."-".$kunci] = array(
						'laki'		=> $que_guru_laki->num_rows(),
						'peremp'	=> $que_guru_premp->num_rows()
					);
				}

				$data[$dt_kueri->nama_school."-".$dt_kueri->id_school] = $jk;
			}						
		}
		else
		{
			unset($camat);
			$camat = array();

			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' AND jenjang_school='$id' ORDER BY nama_school ASC");
			$h_kueri = $kueri->result();
			foreach($h_kueri as $dt_kueri)
			{
				unset($jk);
				$jk = array();

				for($i=2006;$i<=2014;$i++)
				{
					$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_school='".$dt_kueri->id_school."' AND b.jenjang_school='$id' AND a.tunjangan_guru=1 AND a.tahun_tunjangan='$i'");

					$jk[$i] = array(
						'jumlah'		=> $que_guru->num_rows(),							
					);
				}			

				$data[$dt_kueri->nama_school."-".$dt_kueri->id_school] = $jk;
			}	
		}

		return $data;
	}

	function getLokasiAll()
	{
		$data = array();
		$kueri = $this->db->query("SELECT lintang_school as lintang,bujur_school as bujur,nama_school,npsn_school,nss_school,alamat_school FROM schools WHERE lintang_school<>'' AND bujur_school<>'' LIMIT 0,20 ");
		foreach($kueri->result() as $detail)
		{
			$data[] = array(
				'titik'		=> $detail->lintang.','.$detail->bujur,
				'ket'		=> '<h5>'.$detail->nama_school.'</h5><p>NPSN : '.$detail->npsn_school.'</p><p>NSS : '.$detail->nss_school.'</p>'
			);
		}

		return $data;
	}
}
?>
