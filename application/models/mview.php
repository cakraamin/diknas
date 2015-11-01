<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mview extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	public function getKecamatanAll()
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
			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec'");
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

			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' AND jenjang_school='$id'");
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

			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' AND jenjang_school='$id'");
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

			$kueri = $this->db->query("SELECT * FROM schools WHERE id_kecamatan='$kec' AND jenjang_school='$id'");
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

	public function getListGuru($viewer,$kec,$id,$jk,$stat,$tingkat)
	{
		$data = array();

		if($viewer == 1)
		{
			$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$kec."' AND b.jenjang_school='".$id."' AND a.jenis_kel='".$jk."'");
			$query = $que_guru->result();				
		}
		elseif($viewer == 2)
		{
			$tamb = ($stat == 0)?"AND b.id_kecamatan='$kec'":"AND b.id_school='$kec'";

			if($id == 'tt')
			{				
				$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school $tamb AND a.jenis_kel='$jk' AND (a.status_guru=3 OR a.status_guru=4)");
			}
			elseif($id == 'ty')
			{				
				$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school $tamb AND a.jenis_kel='$jk' AND (a.status_guru=5 OR (a.status_guru=2 AND a.status_peg=5))");
			}
			else
			{				
				$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school $tamb AND a.jenis_kel='$jk' AND (a.status_guru=1 OR (a.status_guru=2 AND a.status_peg<>5))");
			}

			$query = $que_guru->result();						
		}
		elseif($viewer == 3)
		{			
			$tamb = ($stat == 0)?"AND b.id_kecamatan='$kec'":"AND b.id_school='$kec'";
			$que = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school $tamb AND a.jenis_kel='$jk' AND a.status_peg='$tingkat' AND b.jenjang_school='$id'");
			$query = $que->result();			
		}
		elseif($viewer == 4)
		{			
			$tamb = ($stat == 0)?"AND b.id_kecamatan='$kec'":"AND b.id_school='$kec'";
			$que = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school $tamb AND a.jenis_kel='$jk' AND a.pend_guru='$tingkat' AND b.jenjang_school='$id'");
			$query = $que->result();			
		}					
		elseif($viewer == 5)
		{
			$tamb = ($stat == 0)?"AND b.id_kecamatan='$kec'":"AND b.id_school='$kec'";			
			$que = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school $tamb AND b.jenjang_school='$id' AND a.tunjangan_guru=1 AND a.tahun_tunjangan='$tingkat'");
			$query = $que->result();			
		}
		else
		{
			$que_guru = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.id_kecamatan='".$kec."' AND b.jenjang_school='".$id."' AND a.jenis_kel='".$jk."' AND tgl_lahir <= now() - INTERVAL 60 YEAR");
			$query = $que_guru->result();				
		}

		return $query;
	}

}
?>