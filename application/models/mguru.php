<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Mguru extends CI_Model{



	function __construct()

	{

		parent::__construct();

	}



	function cekNipGuru()
	{
		$nip = strip_tags(ascii_to_entities(addslashes($this->input->post('nik',TRUE))));

		$kueri = $this->db->query("SELECT * FROM guru WHERE nik_guru='$nip'");

		return $kueri->num_rows();

	}	

	function cekNuptkGuru()
	{
		$nuptk = strip_tags(ascii_to_entities(addslashes($this->input->post('nuptk',TRUE))));

		$kueri = $this->db->query("SELECT * FROM guru WHERE nuptk_guru='$nuptk'");

		return $kueri->num_rows();

	}

	function addGuru($id)
	{
		if($this->input->post('induk',TRUE) == 1)
		{			
			$induk = $id;
			$ampu = 0;
		}
		else
		{		
			$induk = $this->input->post('Sekinduk',TRUE);
			$ampu = $id;
		}

		$data = array(

		   'id_guru' 			=> '' ,

		   'id_school'			=> $induk,

		   'nik_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nik',TRUE)))),

		   'nuptk_guru'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nuptk',TRUE)))),

		   'nama_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),

		   'tempat_lahir'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('tempat_lahir',TRUE)))),

		   'status_induk'		=> $this->input->post('induk',TRUE),

		   'induk_school'		=> $ampu,

		   'tgl_lahir'			=> $this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('tanggal',TRUE),

		   'pend_guru'			=> $this->input->post('pend_guru',TRUE),

		   'tmt_guru'			=> $this->input->post('tahund',TRUE)."-".$this->input->post('buland',TRUE)."-".$this->input->post('tanggald',TRUE),

		   'jenis_kel'			=> $this->input->post('jenisKel',TRUE),

		   'status_guru'		=> $this->input->post('status',TRUE),		   

		   'status_peg'			=> $this->input->post('statuspeg',TRUE),

		   'jenis_tenaga'		=> $this->input->post('tenaga',TRUE),

		   'tunjangan_guru'		=> $this->input->post('tunjangan',TRUE),

		   'tahun_tunjangan'	=> $this->input->post('sertif',TRUE),

		   'id_jabatan'			=> $this->input->post('jabatan',TRUE),

		   'jenis_kendaraan'	=> $this->input->post('kendaraan',TRUE),

		   'jarak'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('jarak',TRUE))))

		);



		$this->db->insert('guru', $data); 

	}

	function getSekolah($id)
	{
		$query = $this->db->query("SELECT * FROM schools WHERE id_school='".$this->session->userdata('id_school')."' ORDER BY id_school ASC");

		if ($query->num_rows()> 0)
		{
			$data[] = "Pilih salah satu";
			foreach ($query->result_array() as $row)
			{
				$npsn = ($row['npsn_school'] == "")?"Kosong":$row['npsn_school'];
				$data[$row['id_school']] = $npsn." | ".$row['nama_school'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();

		return $data;
	}

	function getSekolahLiyane($id)
	{		
		if(is_numeric($id))
		{
			$id = $id;			
		}
		else
		{			
			$id = get_object_vars($id);
			$id = (isset($id->induk_school))?$id->induk_school:0;
		}

		$sql = "SELECT * FROM schools WHERE id_school<>'$id' ORDER BY id_school ASC";			
		$query = $this->db->query($sql);

		if ($query->num_rows()> 0)
		{
			$data[] = "Pilih salah satu";
			foreach ($query->result_array() as $row)
			{
				$npsn = ($row['npsn_school'] == "")?"Kosong":$row['npsn_school'];
				$data[$row['id_school']] = $npsn." | ".$row['nama_school'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();

		return $data;
	}

	function addGuruPaud()
	{		
		$data = array(

		   'id_guru' 			=> '' ,

		   'id_school'			=> $this->session->userdata('id_school'),

		   'nik_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nik',TRUE)))),

		   'nuptk_guru'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nuptk',TRUE)))),

		   'nama_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),

		   'tempat_lahir'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('tempat_lahir',TRUE)))),

		   'status_induk'		=> $this->input->post('induk',TRUE),

		   'induk_school'		=> 0,

		   'tgl_lahir'			=> $this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('tanggal',TRUE),

		   'pend_guru'			=> $this->input->post('pend_guru',TRUE),

		   'tmt_guru'			=> $this->input->post('tahund',TRUE)."-".$this->input->post('buland',TRUE)."-".$this->input->post('tanggald',TRUE),

		   'jenis_kel'			=> $this->input->post('jenisKel',TRUE),

		   'status_guru'		=> $this->input->post('status',TRUE),

		   'status_peg'			=> $this->input->post('statuspeg',TRUE),

		   'tunjangan_guru'		=> '',

		   'tahun_tunjangan'	=> '',

		   'id_jabatan'			=> '',

		   'jenis_kendaraan'	=> 100,

		   'jarak'				=> $this->input->post('pendidik',TRUE)."-".$this->input->post('pelatihan',TRUE)

		);



		$this->db->insert('guru', $data); 

	}

	function getGuru($num,$offset,$sort_by,$sort_order)//menu admin

	{

		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$sort_columns = array('guru.id_guru');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'guru.id_guru';

		$sql = "SELECT * FROM guru WHERE id_school='".$this->session->userdata('id_school')."' OR induk_school='".$this->session->userdata('id_school')."' ORDER BY $sort_by $sort_order LIMIT $offset,$num";

		$query = $this->db->query($sql);

		return $query->result();

	}

	function getGuruPaud($kec,$num,$offset,$sort_by,$sort_order)//menu admin

	{

		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$sort_columns = array('a.id_guru');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.id_guru';

		if($kec == 0)
		{
			$sql = "SELECT * FROM guru a,pauds b WHERE a.id_school=b.id_pauds AND a.jenis_kendaraan='100' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		}
		else
		{
			$sql = "SELECT * FROM guru a,pauds b WHERE a.id_school=b.id_pauds AND a.jenis_kendaraan='100' AND b.id_kecamatan='$kec' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		}			

		$query = $this->db->query($sql);

		return $query->result();

	}

	function getNumGuruPaud($kec)
	{		
		if($kec == 0)
		{
			$sql = "SELECT * FROM guru a,pauds b WHERE a.id_school=b.id_pauds AND a.jenis_kendaraan='100'";
		}
		else
		{
			$sql = "SELECT * FROM guru a,pauds b WHERE a.id_school=b.id_pauds AND a.jenis_kendaraan='100' AND b.id_kecamatan='$kec'";
		}		

		$query = $this->db->query($sql);

		return $query->num_rows();

	}



	function editGUru($id)

	{

		$kueri = $this->db->query("SELECT * FROM guru WHERE id_guru='$id'");

		return $kueri->row();

	}



	function updateGuru($id)
	{
		if($this->input->post('induk',TRUE) == 1)
		{			
			$induk = $this->session->userdata('id_school');
			$ampu = 0;
		}
		else
		{		
			$induk = $this->input->post('Sekinduk',TRUE);
			$ampu = $this->session->userdata('id_school');
		}

		$data = array(		   

		   'id_school'			=> $induk,		   

		   'nik_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nik',TRUE)))),

		   'nuptk_guru'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nuptk',TRUE)))),

		   'nama_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),

		   'tempat_lahir'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('tempat_lahir',TRUE)))),

		   'status_induk'		=> $this->input->post('induk',TRUE),

		   'induk_school'		=> $ampu,

		   'tgl_lahir'			=> $this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('tanggal',TRUE),

		   'pend_guru'			=> $this->input->post('pend_guru',TRUE),

		   'tmt_guru'			=> $this->input->post('tahund',TRUE)."-".$this->input->post('buland',TRUE)."-".$this->input->post('tanggald',TRUE),

		   'jenis_kel'			=> $this->input->post('jenisKel',TRUE),

		   'status_guru'		=> $this->input->post('status',TRUE),

		   'status_peg'			=> $this->input->post('statuspeg',TRUE),

		   'jenis_tenaga'		=> $this->input->post('tenaga',TRUE),

		   'tunjangan_guru'		=> $this->input->post('tunjangan',TRUE),

		   'tahun_tunjangan'	=> $this->input->post('sertif',TRUE),

		   'id_jabatan'			=> $this->input->post('jabatan',TRUE),

		   'jenis_kendaraan'	=> $this->input->post('kendaraan',TRUE),

		   'jarak'				=> strip_tags(ascii_to_entities(addslashes($this->input->post('jarak',TRUE))))

		);



		$this->db->where('id_guru', $id);

		$this->db->update('guru', $data); 

	}

	function updateGuruPaud($id)

	{

		$data = array(		   

			'id_school'			=> $this->session->userdata('id_school'),

		   'nuptk_guru'			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nuptk',TRUE)))),

		   'nik_guru' 			=> '',

		   'nama_guru' 			=> strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),

		   'tempat_lahir'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('tempat_lahir',TRUE)))),

		   'tgl_lahir'			=> $this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('tanggal',TRUE),

		   'pend_guru'			=> $this->input->post('pend_guru',TRUE),

		   'tmt_guru'			=> $this->input->post('tahund',TRUE)."-".$this->input->post('buland',TRUE)."-".$this->input->post('tanggald',TRUE),

		   'jenis_kel'			=> $this->input->post('jenisKel',TRUE),

		   'status_guru'		=> $this->input->post('status',TRUE),

		   'status_peg'			=> $this->input->post('statuspeg',TRUE),

		   'tunjangan_guru'		=> '',

		   'tahun_tunjangan'	=> '',

		   'id_jabatan'			=> '',

		   'jenis_kendaraan'	=> '100',

		   'jarak'				=> $this->input->post('pendidik',TRUE)."-".$this->input->post('pelatihan',TRUE)

		);



		$this->db->where('id_guru', $id);

		$this->db->update('guru', $data); 

	}



	function deleteGuru($id)

	{

		$kueri = $this->db->query("DELETE FROM guru WHERE id_guru='$id'");

		return $kueri;

	}



	function getIdSekolah($id)	

	{

		$kueri = $this->db->query("");

		return $kueri->row();

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