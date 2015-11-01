<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mglobal extends CI_Model
{
	function Mglobal()
	{
		parent::__construct();
	}

	function getLinks()
	{
		$query = $this->db->query('SELECT * FROM link');
		return $query->result();
	}

	function getAgenda()
	{
		$query = $this->db->query("SELECT * FROM eventcal WHERE eventDate >= NOW()");
		return $query->result();
	}

	function getMenuUtama()
	{
		$nilai = array();

		$query = $this->db->query("SELECT * FROM menu WHERE parent='0' AND posisi_menu='2' AND status='Y' ORDER BY urutan ASC");
		$data = $query->result();
		foreach($data as $dt)
		{
			$kueri = $this->db->query("SELECT * FROM menu WHERE parent='".$dt->id_menu."' AND status='Y' ORDER BY urutan ASC");
			$datas = $kueri->result();

			unset($anak);
			$anak = array();

			foreach($datas as $dts)
			{				
				$kueri1 = $this->db->query("SELECT * FROM menu WHERE parent='".$dts->id_menu."' AND status='Y' ORDER BY urutan ASC");
				$datas1 = $kueri1->result();

				unset($subs);
				$subs = array();

				foreach($datas1 as $dt1)
				{
					$subs[] = array(
						'id_menu'		=> $dts->id_menu,
						'menu'			=> $dts->menu,
						'artikelM'		=> $dts->artikelM
					);
				}

				$anak[] = array(
					'id_menu'		=> $dts->id_menu,
					'menu'			=> $dts->menu,
					'artikelM'		=> $dts->artikelM,
					'subs'			=> $subs
				);
			}

			$nilai[] = array(
				'id_menu'		=> $dt->id_menu,
				'menu'			=> $dt->menu,
				'artikelM'		=> $dt->artikelM,
				'anak'			=> $anak
			);
		}

		return $nilai;
	}

	function getMenuToolbar()
	{
		$query = $this->db->query("SELECT * FROM menu WHERE parent='0' AND posisi_menu='1' AND status='Y' ORDER BY urutan ASC");
		return $query->result();
	}

	function getContact()
	{
		$query = $this->db->query("SELECT * FROM contact");
		return $query->row();
	}

	function getHeader()
	{
		$header = array();

		$query = $this->db->query("SELECT * FROM header");
		$hasil = $query->result();
		foreach($hasil as $dt_hasil)
		{
			$subs = $this->db->query("SELECT * FROM detil_header WHERE id_header='".$dt_hasil->id_header."'");

			$header[] = array(
				'header'		=> $dt_hasil->back_header,
				'subs'			=> $subs->result()
			);
		}

		return $header;
	}
}
?>