<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Guru extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->model('mguru','',TRUE);

		$this->load->library(array('page','SimpleLoginSecure','arey'));

		$this->load->library('acl',$this->session->userdata('user_id'));		
		$this->acl->getAkses();		

		if(!$this->session->userdata('logged_in')) 

		{

			redirect('home');

		}
	}



	function index()

	{

		redirect('paud/guru/daftar');

	}



	function daftar($kec=0,$short_by='id_school',$short_order='desc',$page=0)

	{

		$per_page = 20;

		$total_page = $this->mguru->getNumGuruPaud($kec);

		$url = 'paud/guru/daftar/'.$short_by.'/'.$short_order.'/';

		

		$query = $this->mguru->getGuruPaud($kec,$per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('paud/guru/daftar/'.$kec.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),

			'main'			=> 'paud/guru',

			'guru'			=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page,

			'kecamatan'		=> $this->mguru->getSelekKec()
		);

		$this->load->view('paud/template',$data);

	}



	function tambah_guru()

	{		

		$data = array(	  		

			'main'			=> 'paud/formGuru',

			'ket'			=> 'Form Guru',

			'jenis'			=> 'Tambah',

			'guru'			=> 'select',

			'link'			=> 'simpan_guru',

			'jabatan'		=> $this->arey->getJabatan(),

			'status'		=> $this->arey->getStatusGuru(),			

			'tanggal'		=> $this->arey->getTanggal(),

			'bulan'			=> $this->arey->getBulan(),

			'tahun'			=> $this->arey->getTahun(),

			'statuspeg'		=> $this->arey->getStatusPeg(),		

			'jenisKel'		=> $this->arey->getJenisKel(),

			'pendidikan'	=> $this->arey->getPendidikan(),

			'skuls'			=> $this->mguru->getDaftarSkul()

		);		

			

		$this->load->view('paud/template',$data);

	}



	function edit_guru($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('paud/guru/daftar');

		}



		$data = array(	  	

			'main'			=> 'paud/formGuru',

			'ket'			=> 'Form Data Guru',

			'jenis'			=> 'Edit',

			'guru'			=> 'select',

			'link'			=> 'update_guru/'.$id,

			'kueri'			=> $this->mguru->editGUru($id),

			'jabatan'		=> $this->arey->getJabatan(),

			'status'		=> $this->arey->getStatusGuru(),

			'kendaraan'		=> $this->arey->getKendaraan(),

			'tanggal'		=> $this->arey->getTanggal(),

			'bulan'			=> $this->arey->getBulan(),

			'tahun'			=> $this->arey->getTahun(),

			'statuspeg'		=> $this->arey->getStatusPeg(),

			'tunjangan'		=> $this->arey->getTunjangan(),

			'sertif'		=> $this->arey->tahunSertif(),

			'jenisKel'		=> $this->arey->getJenisKel(),

			'pendidikan'	=> $this->arey->getPendidikan(),

			'skuls'			=> $this->mguru->getDaftarSkul()

		);

			

		$this->load->view('paud/template',$data);

	}



	function simpan_guru()

	{
		if($this->mguru->cekNuptkGuru() > 0)
		{
			$this->message->set('notice','Maaf NUPTK tidak boleh sama');
			redirect('paud/guru/tambah_guru');
		}

		$this->mguru->addGuruPaud();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data guru berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Data guru gagal dibuat');
		}

		redirect('paud/guru/daftar');
	}



	function update_guru($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('paud/guru/daftar');

		}



		$this->mguru->updateGuruPaud($id);



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','Data guru berhasil diupdate');

		}

		else

		{

			$this->message->set('notice','Data guru gagal diupdate');

		}

		redirect('paud/guru/daftar');

	}



	function hapus_guru($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('paud/guru/daftar');

		}



		if($this->mguru->deleteGuru($id))

		{

			$this->message->set('succes','Data guru berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','Data guru gagal dihapus');

		}

		redirect('paud/guru/daftar');

	}



	function all_sekolah()

	{

		$cek = $this->input->post('check');

		if(!is_array($cek))

		{

			$this->message->set('notice','Tidak ada data guru yang dipilih');

			redirect('paud/guru/daftar');

		}

		foreach($cek as $dt_cek)

		{

			$this->mguru->deleteGuru($dt_cek);

		}

		$this->message->set('succes','Data guru berhasil dihapus');

		redirect('paud/guru/daftar');

	}

}