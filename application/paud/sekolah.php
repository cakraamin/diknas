<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Sekolah extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->model('mmaster','',TRUE);

		$this->load->library(array('page','SimpleLoginSecure','arey'));



		$this->load->library('acl',$this->session->userdata('user_id'));



		if(!$this->session->userdata('logged_in')) 

		{

			redirect('home');

		}

	}

	function index()
	{
		redirect('paud/sekolah/daftar');
	}

	function daftar($kec=0,$short_by='id_school',$short_order='desc',$page=0)

	{

		$per_page = 20;

		$total_page = $this->mmaster->getNumSkulPaud($kec);

		$url = 'paud/sekolah/daftar/'.$short_by.'/'.$short_order.'/';

		

		$query = $this->mmaster->getSkulPaud($kec,$per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('paud/sekolah/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),

			'main'			=> 'paud/schools',

			'sekolah'		=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page,			

			'kecamatan'		=> $this->mmaster->getSelekKec(),

			'kec'			=> $kec

		);



		$this->load->view('paud/template',$data);

	}

	function tambah_paud()

	{

		$data = array(	  		

			'main'			=> 'paud/formSekolah',

			'ket'			=> 'Form Master PAUD',

			'jenis'			=> 'Tambah',

			'sekolah'		=> 'select',

			'link'			=> 'simpan_paud',

			'status'		=> $this->arey->getStatus(),

			'milik'			=> $this->arey->getPemilikan(),

			'kecamatan'		=> $this->mmaster->getSelekKec(),

			'jenise'		=> $this->arey->getJenisPaud()
		);

			

		$this->load->view('paud/template',$data);

	}

	function import_paud()

	{

		$data = array(	  		

			'main'			=> 'paud/importPaud',

			'ket'			=> 'Form Import PAUD',

			'jenis'			=> 'Import',

			'sekolah'		=> 'select',

			'link'			=> 'upload_paud',			
		);

			

		$this->load->view('paud/template',$data);

	}

	function upload_paud()
	{
		$config['upload_path'] = './uploads/import/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size']	= '10000';		
		$config['encrypt_name']	= TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{			
			$this->message->set('notice',$this->upload->display_errors());
		}
		else
		{
			$hasil = $this->upload->data();
			
			$this->load->library('excel');
			$uploadpath = "./uploads/import/".$hasil['file_name'];
								
			$objPHPExcel = PHPExcel_IOFactory::load($uploadpath);										
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
					 					
			foreach ($cell_collection as $cell) 
			{
			    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					 					 
			    if ($row == 1) 
			    {
			        $header[$row][$column] = $data_value;
			    } 
			    else 
			    {
			        $arr_data[$row][$column] = $data_value;
			    }
			}
					 			
			$data['header'] = $header;
			$data['values'] = $arr_data;					

			$no = 1;
			foreach($data['values'] as $value)
			{
				if($value['A'] != "")	
				{						
					if($this->mmaster->cekNpsnPaudAuto($value['C']) == 0)
					{						
						$data = array(
							'id_pauds'		=> '',
							'id_kecamatan'	=> $this->mmaster->getIdKec($value['E']),
							'nama_paud'		=> strip_tags(ascii_to_entities(addslashes($value['B']))),
							'status_paud'	=> $this->arey->setStatus(ucwords(strtolower($value['G']))),
							'npns_paud'		=> strip_tags(ascii_to_entities(addslashes($value['C']))),
							'alamat_paud'	=> strip_tags(ascii_to_entities(addslashes($value['D']))),
							'jenis_paud'	=> $this->arey->setjenisPaud(strtoupper($value['F'])),
							'milik_paud'	=> $this->arey->setPemilikan(ucwords(strtolower($value['H']))),
							'yayasan_paud'	=> strip_tags(ascii_to_entities(addslashes($value['K']))),
							'kepala_paud'	=> strip_tags(ascii_to_entities(addslashes($value['I']))),
							'ijin_paud'		=> strip_tags(ascii_to_entities(addslashes($value['J'])))
						);

						$this->mmaster->importPaud($data);
					}										
				}
				$no++;
			}			
			unlink($uploadpath);
			$this->message->set('succes','Import Data PAUD Berhasil');			
		}
		redirect('paud/sekolah/daftar');
	}

	function sample()
	{
		$url = "./uploads/sample/sekolah.xlsx";
		$this->load->helper('download');
		$data = file_get_contents($url);
		$name = "sekolah.xlsx";
		
		force_download($name, $data); 
	}

	function edit_paud($id="")

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('paud/sekolah/daftar');

		}



		$data = array(	  	

			'main'			=> 'paud/formSekolah',

			'ket'			=> 'Form Master Sekolah',

			'jenis'			=> 'Edit',

			'master'		=> 'select',

			'link'			=> 'update_paud/'.$id,

			'kueri'			=> $this->mmaster->editPaud($id),

			'status'		=> $this->arey->getStatus(),

			'milik'			=> $this->arey->getPemilikan(),

			'kecamatan'		=> $this->mmaster->getSelekKec(),

			'jenise'		=> $this->arey->getJenisPaud(),

			'id'			=> $id
		);

		$this->load->view('paud/template',$data);

	}

	function simpan_paud()

	{

		if($this->mmaster->cekNpsnPaud() > 0)

		{

			$this->message->set('notice','NSPN atau Nama Sekolah Tidak boleh sama');	

			redirect('paud/sekolah/daftar');

		}



		$this->mmaster->addPaud();



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','PAUD berhasil dibuat');

		}

		else

		{

			$this->message->set('notice','PAUD gagal dibuat');

		}



		redirect('paud/sekolah/daftar');

	}

	function update_paud($id)

	{

		if($this->mmaster->cekNpsnsPaud($id))

		{

			$this->message->set('notice','Maaf NPSN tidak boleh sama');

			redirect('paud/sekolah/daftar');	

		}

	

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('paud/sekolah/daftar');

		}



		$this->mmaster->updatePaud($id);



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','Data PAUD berhasil diupdate');

		}

		else

		{

			$this->message->set('notice','Data PAUD gagal diupdate');

		}

		redirect('paud/sekolah/daftar');

	}

	function hapus_paud($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('paud/sekolah/daftar');

		}



		if($this->mmaster->deletePaud($id))

		{

			$this->message->set('succes','Data sekolah berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','Data sekolah gagal dihapus');

		}

		redirect('paud/sekolah/daftar');

	}

	function all_paud()

	{		

		$cek = $this->input->post('check');

		if(!is_array($cek))

		{

			$kec = $this->input->post('kecamatan',TRUE);

			redirect('paud/sekolah/daftar/'.$kec);			

			//$this->message->set('notice','Tidak ada data sekolah yang dipilih');

			//redirect('masters/sekolah');

		}

		foreach($cek as $dt_cek)

		{

			$this->mmaster->deletePaud($dt_cek);

		}

		$this->message->set('succes','Data sekolah berhasil dihapus');

		redirect('paud/sekolah/daftar/');

	}

}