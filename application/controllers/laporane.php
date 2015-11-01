<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporans extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library(array('arey','excel'));
		$this->load->helper(array('tanggal','terbilang'));
		$this->load->model('mlaporan','',TRUE);

		if($this->session->userdata('user_level') == "")
		{
			redirect('dashboard');
		}
	}

	function index()
	{		
		$data = array(
			'main'			=> 'laporan',
			'laporan'		=> 'select',			
			'tahun'			=> $this->mlaporan->getTahun(),
			'jenjang'		=> $this->arey->getJenjang(),
			'jenis'			=> $this->arey->getJenisLap(),
			'kecamatan'		=> $this->mlaporan->getKecamatanSelekLap()
		);

		$this->load->view('template',$data);		
	}

	function spm()
	{		
		$data = array(
			'main'			=> 'spm',
			'laporan'		=> 'select',			
			'tahun'			=> $this->mlaporan->getTahun(),
			'ket'			=> 'Laporan SPM'
		);

		$this->load->view('template',$data);
	}

	function skul($id=0)
	{		
		$judul = array('Laporan Profil Sekolah','Laporan Data Guru','Laporan Data Siswa','Laporan Data Sarpras');

		$data = array(
			'main'			=> 'lapSkul',
			'laporan'		=> 'select',
			'kode'			=> 'generate_'.$id,
			'tahun'			=> $this->mlaporan->getTahun(),
			'jenis'			=> $this->arey->getJenisLapse(),
			'jenjang'		=> $this->arey->getJenjang(),
			'ket'			=> $judul[$id-1],
			'kecamatan'		=> $this->mlaporan->getKecamatanSelekLap()
		);

		$this->load->view('template',$data);
	}	

	function generate()
	{
		$jenis = $this->input->post('jenis');
		if($jenis == 1)
		{
			$this->generate_spm();
		}
		elseif($jenis == 2)
		{
			$this->generate_rk1();
		}
		elseif($jenis == 3)
		{
			$this->generate_rk2();
		}		
		elseif($jenis == 4)
		{
			$this->generate_rk3();
		}
		else
		{
			$this->generate_rk4();
		}
	}

	function generate_1()
	{
		$jenis = $this->input->post('jenis',TRUE);

		if($jenis == 1)
		{
			$kolomsss = array();
			$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP');
			$abjad = array('I','II','III','IV','V');
			$jenjang = $this->input->post('jenjang',TRUE);

			//sheet pertama
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$this->excel->getActiveSheet()->setTitle("Profil Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A4');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B4');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:D4');
			$this->excel->getActiveSheet()->setCellValue('D3', 'JUMLAH SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('E3:I3');
			$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
			$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E4', 'A');
			$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F4', 'B');
			$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G4', 'C');
			$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
			$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
			$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('J3:M3');
			$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
			$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
			$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
			$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
			$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
			$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('N3:Q3');
			$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
			$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
			$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
			$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
			$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
			$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('R3:R4');
			$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('S3:V3');
			$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
			$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('S4', '1994');
			$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T4', '2004');
			$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
			$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
			$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->mergeCells('A1:V1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH SE KABUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:D4');
			$this->excel->getActiveSheet()->setCellValue('D3', 'JUMLAH SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('E3:I3');
			$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
			$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E4', 'A');
			$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F4', 'B');
			$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G4', 'C');
			$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
			$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
			$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('J3:M3');
			$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
			$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
			$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
			$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
			$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
			$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('N3:Q3');
			$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
			$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
			$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
			$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
			$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
			$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('R3:R4');
			$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('S3:V3');
			$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
			$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('S4', '1994');
			$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T4', '2004');
			$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
			$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
			$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$baris = 5;
			$kecamatan = $this->mlaporan->getKecamatan();
			$no = 1;
			foreach($kecamatan as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);			
				//$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_kecamatan->kode_kecamatan);						
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$jumSek = $this->mlaporan->getJumSekolah($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumSek);	
				$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$akred = $this->mlaporan->getJumAkre($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $akred[0]);	
				$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, $akred[1]);	
				$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, $akred[2]);	
				$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, $akred[3]);	
				$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(E".$baris.":H".$baris.")");	
				$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$waktu = $this->mlaporan->getJumWaktu($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, $waktu[0]);	
				$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, $waktu[1]);	
				$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, $waktu[2]);				
				$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, "=SUM(J".$baris.":L".$baris.")");	
				$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$gugus = $this->mlaporan->getJumGugus($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, $gugus[0]);	
				$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, $gugus[1]);	
				$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, $gugus[2]);				
				$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('Q'.$baris, "=SUM(N".$baris.":P".$baris.")");	
				$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$mbs = $this->mlaporan->getJumMbs($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('R'.$baris, $mbs);	
				$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$kur = $this->mlaporan->getJumKur($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('S'.$baris, $kur[0]);	
				$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('T'.$baris, $kur[1]);	
				$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('U'.$baris, $kur[2]);							
				$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('V'.$baris, $kur[3]);
				$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$no++;
				$baris++;
			}
			$terakhir = $baris - 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, '=SUM(E5:E'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, '=SUM(F5:F'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, '=SUM(G5:G'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, '=SUM(H5:H'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, '=SUM(I5:I'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, '=SUM(J5:J'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, '=SUM(K5:K'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, '=SUM(L5:L'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, '=SUM(M5:M'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, '=SUM(N5:N'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O'.$baris, '=SUM(O5:O'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P'.$baris, '=SUM(P5:P'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q'.$baris, '=SUM(Q5:Q'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('R'.$baris, '=SUM(R5:R'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('S'.$baris, '=SUM(S5:S'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T'.$baris, '=SUM(T5:T'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U'.$baris, '=SUM(U5:U'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V'.$baris, '=SUM(V5:V'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$brs_bwh = $baris;
			$this->excel->getActiveSheet()->getStyle('A3:V'.$brs_bwh)->applyFromArray($styleArray);			

			//sheet keempat
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(1);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);						

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$this->excel->getActiveSheet()->mergeCells('A1:F1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA STATUS SEKOLAH SE KABUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Status Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A4');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B4');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:E3');
			$this->excel->getActiveSheet()->setCellValue('D3', 'STATUS SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->setCellValue('D4', 'SEKOLAH NEGERI');
			$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->setCellValue('E4', 'SEKOLAH SWASTA');
			$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->mergeCells('F3:F4');
			$this->excel->getActiveSheet()->setCellValue('F3', 'JUMLAH');
			$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			

			$baris = 5;
			$kecamatan = $this->mlaporan->getKecamatan();
			$no = 1;
			foreach($kecamatan as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);						
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$statusSek = $this->mlaporan->getStatusSek($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $statusSek['negeri']);	
				$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $statusSek['swasta']);
				$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(D".$baris.":E".$baris.")");
				$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$no++;
				$baris++;
			}
			$barise = $baris - 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'TOTAL');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, "=SUM(D3:D".$barise.")");	
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(E3:E".$barise.")");	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(F3:F".$barise.")");	
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$brs_bwh = $baris;
			$this->excel->getActiveSheet()->getStyle('A3:F'.$brs_bwh)->applyFromArray($styleArray);

			//sheet kelima		
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(2);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);						

			$jumJenjang = ($jenjang == 1)?6:3;
			$kolJenjang = ($jenjang == 1)?"I":"F";
			$akhirJenjang = ($jenjang == 1)?"J":"G";

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$this->excel->getActiveSheet()->mergeCells('A1:'.$akhirJenjang.'1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA STATUS SEKOLAH SE KABUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Rombel Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A4');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B4');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:'.$kolJenjang.'3');
			$this->excel->getActiveSheet()->setCellValue('D3', 'JENJANG SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			$this->excel->getActiveSheet()->mergeCells($akhirJenjang.'3:'.$akhirJenjang.'4');
			$this->excel->getActiveSheet()->setCellValue($akhirJenjang.'3', 'JUMLAH');
			$this->excel->getActiveSheet()->getStyle($akhirJenjang.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle($akhirJenjang.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$klms = 2;
			for($i=1;$i<=$jumJenjang;$i++)
			{
				$hurufe = $huruf[$klms+$i];
				$this->excel->getActiveSheet()->setCellValue($hurufe.'4', "Kelas ".$i);
				$this->excel->getActiveSheet()->getStyle($hurufe.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			}
			

			$baris = 5;
			$kecamatan = $this->mlaporan->getKecamatan();
			$no = 1;
			$thun = $this->mlaporan->getTaAktif();
			foreach($kecamatan as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);						
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				for($i=1;$i<=$jumJenjang;$i++)
				{
					$hurufe = $huruf[$klms+$i];
					$getJumRombel = $this->mlaporan->getJumRombel($dt_kecamatan->id_kecamatan,$jenjang,$thun['tahun'],$i);
					$this->excel->getActiveSheet()->setCellValue($hurufe.$baris, $getJumRombel);
					$this->excel->getActiveSheet()->getStyle($hurufe.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
				}
				$this->excel->getActiveSheet()->setCellValue($akhirJenjang.$baris, "=SUM(D".$baris.":".$kolJenjang.$baris.")");
				$this->excel->getActiveSheet()->getStyle($akhirJenjang.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$no++;
				$baris++;
			}
			$barise = $baris - 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'TOTAL');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			for($i=1;$i<=$jumJenjang;$i++)
			{
				$hurufe = $huruf[$klms+$i];			
				$this->excel->getActiveSheet()->setCellValue($hurufe.$baris, "=SUM(".$hurufe."5:".$hurufe.$barise.")");
				$this->excel->getActiveSheet()->getStyle($hurufe.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			}		

			$brs_bwh = $baris;
			$this->excel->getActiveSheet()->getStyle('A3:'.$akhirJenjang.$brs_bwh)->applyFromArray($styleArray);

			$filename='RK Dinpendik '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';			
		}
		else
		{
			$kolomsss = array();
			$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP');
			$abjad = array('I','II','III','IV','V');
			$jenjang = $this->input->post('jenjang',TRUE);
			$camate = $this->input->post('kecamatan',TRUE);
			$namaKec = $this->mlaporan->getNamaKec($camate);

			//sheet pertama
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);		
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$this->excel->getActiveSheet()->setTitle("Profil Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A4');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B4');
			$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:D4');
			$this->excel->getActiveSheet()->setCellValue('D3', 'KODE KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('E3:I3');
			$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
			$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E4', 'A');
			$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F4', 'B');
			$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G4', 'C');
			$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
			$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
			$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('J3:M3');
			$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
			$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
			$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
			$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
			$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
			$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('N3:Q3');
			$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
			$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
			$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
			$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
			$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
			$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('R3:R4');
			$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('S3:U3');
			$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
			$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('S4', '1994');
			$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T4', '2004');
			$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
			$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
			$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->mergeCells('A1:V1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH SE KABUPATEN REMBANG KECAMATAN '.$namaKec);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:D4');
			$this->excel->getActiveSheet()->setCellValue('D3', 'KODE KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('E3:I3');
			$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
			$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E4', 'A');
			$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F4', 'B');
			$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G4', 'C');
			$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
			$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
			$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('J3:M3');
			$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
			$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
			$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
			$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
			$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
			$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('N3:Q3');
			$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
			$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
			$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
			$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
			$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
			$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('R3:R4');
			$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('S3:V3');
			$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
			$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('S4', '1994');
			$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T4', '2004');
			$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
			$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
			$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$baris = 5;		
			$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
			$no = 1;
			foreach($skulKec as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);						
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->nama_kecamatan);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$akred = $this->mlaporan->getJumAkreSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $akred[0]);	
				$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, $akred[1]);	
				$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, $akred[2]);	
				$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, $akred[3]);	
				$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(E".$baris.":H".$baris.")");	
				$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$waktu = $this->mlaporan->getJumWaktuSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, $waktu[0]);	
				$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, $waktu[1]);	
				$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, $waktu[2]);				
				$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, "=SUM(J".$baris.":L".$baris.")");	
				$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$gugus = $this->mlaporan->getJumGugusSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, $gugus[0]);	
				$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, $gugus[1]);	
				$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, $gugus[2]);				
				$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('Q'.$baris, "=SUM(N".$baris.":P".$baris.")");	
				$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$mbs = $this->mlaporan->getJumMbsSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
				$this->excel->getActiveSheet()->setCellValue('R'.$baris, $mbs);	
				$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$kur = $this->mlaporan->getJumKurSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
				$this->excel->getActiveSheet()->setCellValue('S'.$baris, $kur[0]);	
				$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('T'.$baris, $kur[1]);	
				$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('U'.$baris, $kur[2]);							
				$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('V'.$baris, $kur[3]);
				$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$no++;
				$baris++;
			}
			$terakhir = $baris - 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, '=SUM(E5:E'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, '=SUM(F5:F'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, '=SUM(G5:G'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, '=SUM(H5:H'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, '=SUM(I5:I'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, '=SUM(J5:J'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, '=SUM(K5:K'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, '=SUM(L5:L'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, '=SUM(M5:M'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, '=SUM(N5:N'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O'.$baris, '=SUM(O5:O'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P'.$baris, '=SUM(P5:P'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q'.$baris, '=SUM(Q5:Q'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('R'.$baris, '=SUM(R5:R'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('S'.$baris, '=SUM(S5:S'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T'.$baris, '=SUM(T5:T'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U'.$baris, '=SUM(U5:U'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V'.$baris, '=SUM(V5:V'.$terakhir.')');
			$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$brs_bwh = $baris;
			$this->excel->getActiveSheet()->getStyle('A3:V'.$brs_bwh)->applyFromArray($styleArray);			

			//sheet keempat
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(1);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);						

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$this->excel->getActiveSheet()->mergeCells('A1:F1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA STATUS SEKOLAH SE KABUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Status Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A4');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B4');
			$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:E3');
			$this->excel->getActiveSheet()->setCellValue('D3', 'STATUS SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->setCellValue('D4', 'SEKOLAH NEGERI');
			$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->setCellValue('E4', 'SEKOLAH SWASTA');
			$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->mergeCells('F3:F4');
			$this->excel->getActiveSheet()->setCellValue('F3', 'JUMLAH');
			$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		

			$baris = 5;
			$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
			$no = 1;
			foreach($skulKec as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_kecamatan->nama_kecamatan);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$statusSek = $this->mlaporan->getStatusSekSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $statusSek['negeri']);	
				$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $statusSek['swasta']);
				$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(D".$baris.":E".$baris.")");
				$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$no++;
				$baris++;
			}
			$barise = $baris - 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'TOTAL');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, "=SUM(D3:D".$barise.")");	
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(E3:E".$barise.")");	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(F3:F".$barise.")");	
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$brs_bwh = $baris;
			$this->excel->getActiveSheet()->getStyle('A3:F'.$brs_bwh)->applyFromArray($styleArray);

			//sheet kelima		
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(2);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);						
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);						

			$jumJenjang = ($jenjang == 1)?6:3;
			$kolJenjang = ($jenjang == 1)?"I":"F";
			$akhirJenjang = ($jenjang == 1)?"J":"G";

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$this->excel->getActiveSheet()->mergeCells('A1:'.$akhirJenjang.'1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA STATUS SEKOLAH SE KABUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Rombel Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A4');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B4');
			$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C3:C4');
			$this->excel->getActiveSheet()->setCellValue('C3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('D3:'.$kolJenjang.'3');
			$this->excel->getActiveSheet()->setCellValue('D3', 'JENJANG SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			$this->excel->getActiveSheet()->mergeCells($akhirJenjang.'3:'.$akhirJenjang.'4');
			$this->excel->getActiveSheet()->setCellValue($akhirJenjang.'3', 'JUMLAH');
			$this->excel->getActiveSheet()->getStyle($akhirJenjang.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle($akhirJenjang.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$klms = 2;
			for($i=1;$i<=$jumJenjang;$i++)
			{
				$hurufe = $huruf[$klms+$i];
				$this->excel->getActiveSheet()->setCellValue($hurufe.'4', "Kelas ".$i);
				$this->excel->getActiveSheet()->getStyle($hurufe.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			}
			

			$baris = 5;
			$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
			$no = 1;
			$thun = $this->mlaporan->getTaAktif();
			foreach($skulKec as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);						
				$this->excel->getActiveSheet()->setCellValue('C'.$baris,  $dt_kecamatan->nama_kecamatan);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				for($i=1;$i<=$jumJenjang;$i++)
				{
					$hurufe = $huruf[$klms+$i];
					$getJumRombel = $this->mlaporan->getJumRombelSkul($dt_kecamatan->id_kecamatan,$jenjang,$thun['tahun'],$i,$dt_kecamatan->id_school);
					$this->excel->getActiveSheet()->setCellValue($hurufe.$baris, $getJumRombel);
					$this->excel->getActiveSheet()->getStyle($hurufe.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
				}
				$this->excel->getActiveSheet()->setCellValue($akhirJenjang.$baris, "=SUM(D".$baris.":".$kolJenjang.$baris.")");
				$this->excel->getActiveSheet()->getStyle($akhirJenjang.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$no++;
				$baris++;
			}
			$barise = $baris - 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'TOTAL');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			for($i=1;$i<=$jumJenjang;$i++)
			{
				$hurufe = $huruf[$klms+$i];			
				$this->excel->getActiveSheet()->setCellValue($hurufe.$baris, "=SUM(".$hurufe."5:".$hurufe.$barise.")");
				$this->excel->getActiveSheet()->getStyle($hurufe.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			}		

			$brs_bwh = $baris;
			$this->excel->getActiveSheet()->getStyle('A3:'.$akhirJenjang.$brs_bwh)->applyFromArray($styleArray);

			$filename='RK Dinpendik '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';			
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
					             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_2()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		$jenis = $this->input->post('jenis',TRUE);
		$jenjang = $this->input->post('jenjang',TRUE);
		$kecamatan = $this->mlaporan->getKecamatan();

		if($jenis == 1)
		{						
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$guru = $this->mlaporan->getGuru($jenjang);	
			$pendidikan = $this->arey->getPendidikan();	
			$kolls = 8+count($guru)+(count($pendidikan)*2);
			$kollomms = $huruf[$kolls];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU DAN KEPALA SEKOLAH SE KEBUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Kepala Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
			$this->excel->getActiveSheet()->mergeCells('C4:D4');
			$this->excel->getActiveSheet()->setCellValue('C4', 'KEPALA SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue('C5', 'PNS');
			$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue('D5', 'CPNS');
			$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			
			$nkolom = 4;				
			foreach($guru as $dt_guru)
			{
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $this->arey->getJabatan($dt_guru->id_jabatan,1));
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "PNS");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "CPNS");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}
			$awale = $huruf[2];
			$akhire = $huruf[$nkolom-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
			$this->excel->getActiveSheet()->setCellValue($awale.'3', "GURU DAN KEPALA SEKOLAH");
			$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$this->excel->getActiveSheet()->setCellValue($akhire.'3', 'ok');
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$awal.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "JUMLAH KS DAN GURU");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "PNS");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "CPNS");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom = $nkolom + 2;
			$awale = $huruf[$nkolom];				
			foreach($pendidikan as $dt_pendidikan)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_pendidikan);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}
			$akhire = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
			$this->excel->getActiveSheet()->setCellValue($awale.'3', "PENDIDIKAN TERAKHIR KEPALA SEKOLAH");
			$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', "JUMLAH");
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom = $nkolom + 2;			
			$no = 1;
			$baris = 6;		
			foreach($kecamatan as $dt_kecamatan)
			{
				$pns = 0;
				$bpns = 0;
				$klaki = 0;
				$kpr = 0;
				$keplaki = 0;
				$keppr = 0;
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);							

				$kepala = $this->mlaporan->getKepala($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $kepala['pns']);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $kepala['bpns']);
				$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$pns = $pns + $kepala['pns'];
				$bpns = $bpns + $kepala['bpns'];

				$nkolom = 4;
				foreach($guru as $dt_guru)
				{
					$guruPel = $this->mlaporan->getGuruPel($dt_kecamatan->id_kecamatan,$jenjang,$dt_guru->id_jabatan);
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];				
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $guruPel['pns']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $guruPel['bpns']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$pns = $pns + $guruPel['pns'];
					$bpns = $bpns + $guruPel['bpns'];				
					$nkolom += 2;
				}			
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pns);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $bpns);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom = $nkolom + 2;			
				foreach($pendidikan as $key => $dt_pendidikan)
				{	
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];

					$pendidik = $this->mlaporan->getKepalaPendik($dt_kecamatan->id_kecamatan,$jenjang,$key);

					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pendidik['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $pendidik['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$klaki = $klaki + $pendidik['laki'];
					$kpr = $kpr + $pendidik['pr'];
					$nkolom += 2;
				}
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];			
				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $klaki);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $kpr);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
				$no++;
				$baris++;
			}
			$brs_bwh = $baris - 1;
			$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom+1].$brs_bwh)->applyFromArray($styleArray);

			//sheet ketiga
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(1);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);
			
			$pendidikan = $this->arey->getPendidikan();	
			$kolls = 3+(count($pendidikan)*2);
			$kollomms = $huruf[$kolls];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU SE KEBUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Guru Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);						
			
			$nkolom = "B";
			$nkolom = $nkolom + 2;
			$awale = $huruf[$nkolom];				
			foreach($pendidikan as $dt_pendidikan)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_pendidikan);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}
			$akhire = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
			$this->excel->getActiveSheet()->setCellValue($awale.'3', "PENDIDIKAN TERAKHIR GURU");
			$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', "JUMLAH");
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$nkolom = $nkolom + 2;		
			$awale = $huruf[$nkolom];	
			$statuse = $this->arey->getStatusPeg();
			foreach($statuse as $dt_statuse)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_statuse);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}
			$akhire = $huruf[$nkolom-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
			$this->excel->getActiveSheet()->setCellValue($awale.'3', "STATUS GURU");
			$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$no = 1;
			$baris = 6;			
			foreach($kecamatan as $dt_kecamatan)
			{			
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);			
				
				$nkolom = 2;
				$awale = 2;	
				$klaki = 0;		
				$kpr = 0;
				foreach($pendidikan as $key => $dt_pendidikan)
				{	
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];

					$pendidik = $this->mlaporan->getGuruPendik($dt_kecamatan->id_kecamatan,$jenjang,$key);

					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pendidik['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $pendidik['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$klaki = $klaki + $pendidik['laki'];
					$kpr = $kpr + $pendidik['pr'];
					$nkolom += 2;
				}
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];			
				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $klaki);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $kpr);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$nkolom = $nkolom + 2;		
				$awale = $huruf[$nkolom];	
				foreach($statuse as $keys => $dt_statuse)
				{	
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];
					$status_peg = $this->mlaporan->getStatuseGuru($dt_kecamatan->id_kecamatan,$jenjang,$keys);
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $status_peg['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $status_peg['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$nkolom += 2;
				}

				$no++;
				$baris++;
			}
			$brs_bwh = $baris - 1;
			$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom-1].$brs_bwh)->applyFromArray($styleArray);

			$filename='RK Dinpendik Data Guru '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		}
		else
		{
			$camate = $this->input->post('kecamatan',TRUE);

			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);
			
			$pendidikan = $this->arey->getPendidikan();	
			$kolls = 3+(count($pendidikan)*2);
			$kollomms = $huruf[$kolls];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU SE KEBUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Guru Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);						
			
			$nkolom = "B";
			$nkolom = $nkolom + 2;
			$awale = $huruf[$nkolom];				
			foreach($pendidikan as $dt_pendidikan)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_pendidikan);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}
			$akhire = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
			$this->excel->getActiveSheet()->setCellValue($awale.'3', "PENDIDIKAN TERAKHIR GURU");
			$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', "JUMLAH");
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$nkolom = $nkolom + 2;		
			$awale = $huruf[$nkolom];	
			$statuse = $this->arey->getStatusPeg();
			foreach($statuse as $dt_statuse)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_statuse);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}
			$akhire = $huruf[$nkolom-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
			$this->excel->getActiveSheet()->setCellValue($awale.'3', "STATUS GURU");
			$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$no = 1;
			$baris = 6;		
			$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);	

			foreach($skulKec as $dt_kecamatan)
			{			
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);			
				
				$nkolom = 2;
				$awale = 2;	
				$klaki = 0;		
				$kpr = 0;
				foreach($pendidikan as $key => $dt_pendidikan)
				{	
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];

					$pendidik = $this->mlaporan->getGuruPendikSkul($dt_kecamatan->id_kecamatan,$jenjang,$key,$dt_kecamatan->id_school);

					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pendidik['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $pendidik['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$klaki = $klaki + $pendidik['laki'];
					$kpr = $kpr + $pendidik['pr'];
					$nkolom += 2;
				}
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];			
				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $klaki);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $kpr);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$nkolom = $nkolom + 2;		
				$awale = $huruf[$nkolom];	
				foreach($statuse as $keys => $dt_statuse)
				{	
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];
					$status_peg = $this->mlaporan->getStatuseGuruSkul($dt_kecamatan->id_kecamatan,$jenjang,$keys,$dt_kecamatan->id_school);
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $status_peg['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $status_peg['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
					$nkolom += 2;
				}

				$no++;
				$baris++;
			}
			$brs_bwh = $baris - 1;
			$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom-1].$brs_bwh)->applyFromArray($styleArray);

			$filename='RK Dinpendik Data Guru '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
					             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_3()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		$jenis = $this->input->post('jenis',TRUE);
		$jenjang = $this->input->post('jenjang',TRUE);
		$kecamatan = $this->mlaporan->getKecamatan();

		if($jenis == 1)
		{						
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$umur = $this->mlaporan->getDetailUmur($jenjang);
			$tingkat = ($jenjang == 1)?6:3;

			$this->excel->getActiveSheet()->setTitle("Profil Siswa Sekolah");		

			$kolomsss = 1+(count($umur)*2);
			$kolummm = $huruf[$kolomsss];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				
			if(count($umur) > 0)
			{
				$current = $this->excel->getActiveSheet()->getActiveCell();
				$current = substr($current, 0,1);
				$cari = array_search($current, $huruf);
				$nkolom = $cari+1;
				$awal = $huruf[$nkolom];			
				$akhir = $huruf[$nkolom+(count($umur)*2)-1];
				$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
				$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN UMUR DAN JENIS KELAMIN");
				$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				for($t=0;$t<count($umur);$t++)
				{			
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];
					$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
					$this->excel->getActiveSheet()->setCellValue($awal.'4', $umur[$t]['batas']);
					$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($awal.'5', 'L');
					$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($akhir.'5', 'P');
					$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom += 2;
				}			
			}							

			$baris = 6;
			$kecamatan = $this->mlaporan->getKecamatan();
			$no = 1;
			foreach($kecamatan as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);
				
				if(count($umur) > 0)
				{
					$current = $this->excel->getActiveSheet()->getActiveCell();
					$current = substr($current, 0,1);
					$cari = array_search($current, $huruf);
					$nkolom = $cari+2;							
					for($t=0;$t<count($umur);$t++)
					{			
						$detailUmur = $this->mlaporan->getDetailUmurTotal($umur[$t]['id_detail_umur'],$dt_kecamatan->id_kecamatan);

						$awal = $huruf[$nkolom];
						$akhir = $huruf[$nkolom+1];					
						$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailUmur['laki']);
						$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailUmur['pr']);
						$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$nkolom += 2;
					}				
				}
				else
				{
					$akhir = 4;
				}

				$no++;
				$baris++;
			}		

			$brs_bwh = $baris - 1;
			if($jenjang == 1)
			{
				$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
			}
			elseif($jenjang == 2)
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}		
			else
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek+1];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}

			//sheet ketiga
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(1);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

			$this->excel->getActiveSheet()->setTitle("Profil Tingkat Sekolah");

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$tingkat = ($jenjang == 1)?6:3;
			$kolomsss = 1+($tingkat*2);
			$kolummm = $huruf[$kolomsss];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG(II)');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		

			$nkolom = 2;
			$awal = $huruf[$nkolom];			
			$akr = $nkolom+($tingkat*2)-1;
			$akhir = $huruf[$akr];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN TINGKAT DAN JENIS KELAMIN");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			for($t=1;$t<=$tingkat;$t++)
			{			
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];			
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', "Tk ".$t);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom += 2;
			}

			$baris = 6;
			$kecamatan = $this->mlaporan->getKecamatan();
			$no = 1;
			foreach($kecamatan as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);
							
				if($tingkat > 0)
				{
					$nkolom = 2;				
					for($w=1;$w<=$tingkat;$w++)
					{			
						$detailTingkat = $this->mlaporan->getDetailTingkat($dt_kecamatan->id_kecamatan,$tingkat);

						$awal = $huruf[$nkolom];
						$akhir = $huruf[$nkolom+1];					
						$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailTingkat[$w]['laki']);
						$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailTingkat[$w]['pr']);
						$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$nkolom += 2;
					}
				}

				$no++;
				$baris++;
			}		

			$brs_bwh = $baris - 1;
			if($jenjang == 1)
			{
				$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
			}
			elseif($jenjang == 2)
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}		
			else
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}

			$filename='RK Dinpendik Data Siswa '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		}
		else
		{
			$camate = $this->input->post('kecamatan',TRUE);
			$namaKec = $this->mlaporan->getNamaKec($camate);
			
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$umur = $this->mlaporan->getDetailUmur($jenjang);
			$tingkat = ($jenjang == 1)?6:3;

			$this->excel->getActiveSheet()->setTitle("Profil Siswa Sekolah");		

			$kolomsss = 1+(count($umur)*2);
			$kolummm = $huruf[$kolomsss];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG KECAMATAN '.$namaKec);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				
			if(count($umur) > 0)
			{
				$current = $this->excel->getActiveSheet()->getActiveCell();
				$current = substr($current, 0,1);
				$cari = array_search($current, $huruf);
				$nkolom = $cari+1;
				$awal = $huruf[$nkolom];			
				$akhir = $huruf[$nkolom+(count($umur)*2)-1];
				$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
				$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN UMUR DAN JENIS KELAMIN");
				$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				for($t=0;$t<count($umur);$t++)
				{			
					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];
					$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
					$this->excel->getActiveSheet()->setCellValue($awal.'4', $umur[$t]['batas']);
					$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($awal.'5', 'L');
					$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($akhir.'5', 'P');
					$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom += 2;
				}			
			}							

			$baris = 6;		
			$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
			$no = 1;
			foreach($skulKec as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);
				
				if(count($umur) > 0)
				{
					$current = $this->excel->getActiveSheet()->getActiveCell();
					$current = substr($current, 0,1);
					$cari = array_search($current, $huruf);
					$nkolom = $cari+2;							
					for($t=0;$t<count($umur);$t++)
					{			
						$detailUmur = $this->mlaporan->getDetailUmurTotalSkul($umur[$t]['id_detail_umur'],$dt_kecamatan->id_kecamatan,$dt_kecamatan->id_school);

						$awal = $huruf[$nkolom];
						$akhir = $huruf[$nkolom+1];					
						$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailUmur['laki']);
						$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailUmur['pr']);
						$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$nkolom += 2;
					}				
				}
				else
				{
					$akhir = 4;
				}

				$no++;
				$baris++;
			}		

			$brs_bwh = $baris - 1;
			if($jenjang == 1)
			{
				$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
			}
			elseif($jenjang == 2)
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}		
			else
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek+1];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}
			
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(1);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$umur = $this->mlaporan->getDetailUmur($jenjang);
			$tingkat = ($jenjang == 1)?6:3;

			$this->excel->getActiveSheet()->setTitle("Profil Tingkat Sekolah");		

			$kolomsss = 1+($tingkat*2);
			$kolummm = $huruf[$kolomsss];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG KECAMATAN(II) '.$namaKec);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						
			$nkolom = 2;
			$awal = $huruf[$nkolom];			
			$akr = $nkolom+($tingkat*2)-1;
			$akhir = $huruf[$akr];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN TINGKAT DAN JENIS KELAMIN");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			for($t=1;$t<=$tingkat;$t++)
			{			
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];			
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', "Tk ".$t);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$nkolom += 2;
			}

			$baris = 6;		
			$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
			$no = 1;
			foreach($skulKec as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);
							
				if($tingkat > 0)
				{				
					$nkolom = 2;				
					for($w=1;$w<=$tingkat;$w++)
					{			
						$detailTingkat = $this->mlaporan->getDetailTingkatSkul($dt_kecamatan->id_kecamatan,$tingkat,$dt_kecamatan->id_school);

						$awal = $huruf[$nkolom];
						$akhir = $huruf[$nkolom+1];					
						$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailTingkat[$w]['laki']);
						$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailTingkat[$w]['pr']);
						$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$nkolom += 2;
					}
				}

				$no++;
				$baris++;
			}		

			$brs_bwh = $baris - 1;
			if($jenjang == 1)
			{
				$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
			}
			elseif($jenjang == 2)
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}		
			else
			{
				$golek = array_search($akhir, $huruf);
				$kollsss = $huruf[$golek];
				$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
			}

			$filename='RK Dinpendik Data Siswa '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
					             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_4()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		$jenis = $this->input->post('jenis',TRUE);
		$jenjang = $this->input->post('jenjang',TRUE);
		$kecamatan = $this->mlaporan->getKecamatan();
		$tingkat = ($jenjang == 1)?6:3;

		if($jenis == 1)
		{						
			$this->excel->createSheet();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(14);		
			$this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(14);		

			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$ujian = $this->mlaporan->getUjian($jenjang);
			$ruang = $this->mlaporan->getRuangHead($jenjang);		
			$buku = $this->mlaporan->getBukuHead($jenjang);
			$kolls = 7+count($ujian)+5+count($buku);
			$kollomms = $huruf[$kolls];

			$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
			$this->excel->getActiveSheet()->setCellValue('A1', 'DATA SEKOLAH SE KEBUPATEN REMBANG');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setTitle("Data Sekolah");		
			$this->excel->getActiveSheet()->mergeCells('A3:A5');
			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B3:B5');
			$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
			$this->excel->getActiveSheet()->mergeCells('C3:H3');
			$this->excel->getActiveSheet()->setCellValue('C3', 'UJIAN AKHIR SEKOLAH');
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('C4:E4');
			$this->excel->getActiveSheet()->setCellValue('C4', 'PESERTA');
			$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('F4:H4');
			$this->excel->getActiveSheet()->setCellValue('F4', 'LULUSAN');
			$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('C5', 'L');
			$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D5', 'P');
			$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E5', 'L+P');
			$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F5', 'L');
			$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G5', 'P');
			$this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H5', 'L+P');
			$this->excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$nkolom = 8;
			if(count($ujian) > 0)
			{			
				foreach($ujian as $dt_ujian)
				{
					$kolom = $huruf[$nkolom];
					$this->excel->getActiveSheet()->mergeCells($kolom.'4:'.$kolom.'5');
					$this->excel->getActiveSheet()->setCellValue($kolom.'4', $this->arey->getJabatan($dt_ujian->nama_mapel,1));
					$this->excel->getActiveSheet()->getStyle($kolom.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom++;
				}
			}
			$nkolom = 8;
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+count($ujian)-2];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "NILAI UJIAN");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('K3:N3');
			$this->excel->getActiveSheet()->setCellValue('K3', "JUMLAH RUANG KELAS");
			$this->excel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->mergeCells('K4:K5');
			$this->excel->getActiveSheet()->setCellValue('K4', "BAIK");
			$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('L4:L5');
			$this->excel->getActiveSheet()->setCellValue('L4', "RUSAK RINGAN");
			$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('M4:M5');
			$this->excel->getActiveSheet()->setCellValue('M4', "RUSAK BERAT");
			$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('N4:N5');
			$this->excel->getActiveSheet()->setCellValue('N4', "SUB JUMLAH");
			$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('O3:O5');
			$this->excel->getActiveSheet()->setCellValue('O3', "BUKAN HAK MILIK");
			$this->excel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			if(count($ruang) > 0)
			{			
				$nkolom = 15;
				foreach($ruang as $dt_ruang)
				{
					$awal = $huruf[$nkolom];
					$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$awal.'5');
					$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_ruang->nama_fasilitas);
					$nkolom++;
				}			
			}
			$awal = $huruf[$nkolom-count($ruang)];
			$akhir = $huruf[$nkolom-1];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "JUMLAH RUANG");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			
			if(count($buku) > 0)
			{
				$currentCell = $this->excel->getActiveSheet()->getActiveCell();
				$kolom = (strlen($currentCell) > 2)?substr($currentCell, 0,2):substr($currentCell, 0,1);
				$cari = array_search($kolom, $huruf);

				$nkolom = $cari+1+count($ruang);
				$awalb = $huruf[$nkolom-1];
				foreach($buku as $dt_buku)
				{
					$awal = $huruf[$nkolom-1];
					$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$awal.'5');
					$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_buku->nama_fasilitas);
					$nkolom++;
				}			

				//$awal = $huruf[$nkolom-count($dt_buku)-1];
				$akhir = $huruf[$nkolom-2];
				$this->excel->getActiveSheet()->mergeCells($awalb.'3:'.$akhir.'3');
				$this->excel->getActiveSheet()->setCellValue($awalb.'3', "JUMLAH BUKU");
				$this->excel->getActiveSheet()->getStyle($awalb.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}		

			$no = 1;
			$baris = 6;
			foreach($kecamatan as $dt_kecamatan)
			{
				$total = 0;
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);				

				$jumUn = $this->mlaporan->getJumUn($dt_kecamatan->id_kecamatan,$tingkat,$jenjang);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $jumUn['peserta_l']);
				$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumUn['peserta_p']);
				$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(C".$baris.":D".$baris.")");
				$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, $jumUn['lulus_l']);
				$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, $jumUn['lulus_p']);
				$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, "=SUM(F".$baris.":G".$baris.")");
				$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$nkolom = 8;
				if(count($ujian) > 0)
				{				
					foreach($ujian as $dt_ujian)
					{
						$kolom = $huruf[$nkolom];					
						$rataNilai = $this->mlaporan->getJumNilaiUn($dt_kecamatan->id_kecamatan,$dt_ujian->id_detail_mapel,$jenjang);
						$this->excel->getActiveSheet()->setCellValue($kolom.$baris, $rataNilai);
						$this->excel->getActiveSheet()->getStyle($kolom.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
						$nkolom++;
					}
				}			
				$satu = $nkolom;
				$kelas = $this->mlaporan->getJumKelas($dt_kecamatan->id_kecamatan,$jenjang);
				$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['baik']);
				$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom = $nkolom+1;
				$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['rusak_ringan']);
				$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$nkolom = $nkolom+1;
				$dua = $nkolom;
				$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['rusak_berat']);
				$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$nkolom = $nkolom+1;
				$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, "=SUM(".$huruf[$satu].$baris.":".$huruf[$dua].$baris.")");
				$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$nkolom = $nkolom+1;
				$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['bukan_milik']);
				$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom = $nkolom+1;
				if(count($ruang) > 0)
				{			
					$nkolom = 15;
					foreach($ruang as $dt_ruang)
					{
						$fasilitas = $this->mlaporan->getJumFasilitas($dt_kecamatan->id_kecamatan,$dt_ruang->id_detail_fasilitas,$jenjang);

						$awal = $huruf[$nkolom];					
						$this->excel->getActiveSheet()->setCellValue($awal.$baris, $fasilitas);
						$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$nkolom++;
					}			
				}			
				
				if(count($buku) > 0)
				{				
					foreach($buku as $dt_buku)
					{
						$fasilitas = $this->mlaporan->getJumFasilitas($dt_kecamatan->id_kecamatan,$dt_buku->id_detail_fasilitas,$jenjang);

						$awal = $huruf[$nkolom];					
						$this->excel->getActiveSheet()->setCellValue($awal.$baris, $fasilitas);
						$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$nkolom++;
					}			
				}

				$no++;
				$baris++;
			}

			//$baris = 5;
			$brs_bwh = $baris - 1;
			$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom-1].$brs_bwh)->applyFromArray($styleArray);

			$filename='RK Dinpendik Data Sarpras '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		}
		else
		{
			$camate = $this->input->post('kecamatan',TRUE);
			$namaKec = $this->mlaporan->getNamaKec($camate);
			
			$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->setTitle("Profil Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:D4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E3:I3');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E4', 'A');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'B');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'C');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J3:M3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N3:Q3');
		$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
		$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
		$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
		$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R3:R4');
		$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S3:U3');
		$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
		$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S4', '1994');
		$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T4', '2004');
		$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
		$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
		$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->mergeCells('A1:V1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH SE KABUPATEN REMBANG KECAMATAN '.$namaKec);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:D4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E3:I3');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E4', 'A');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'B');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'C');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J3:M3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N3:Q3');
		$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
		$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
		$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
		$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R3:R4');
		$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S3:V3');
		$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
		$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S4', '1994');
		$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T4', '2004');
		$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
		$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
		$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris = 5;		
		$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
		$no = 1;
		foreach($skulKec as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);						
			$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->nama_kecamatan);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValueExplicit('D'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$akred = $this->mlaporan->getJumAkreSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $akred[0]);	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $akred[1]);	
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $akred[2]);	
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $akred[3]);	
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(E".$baris.":H".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$waktu = $this->mlaporan->getJumWaktuSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $waktu[0]);	
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, $waktu[1]);	
			$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, $waktu[2]);				
			$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, "=SUM(J".$baris.":L".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$gugus = $this->mlaporan->getJumGugusSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, $gugus[0]);	
			$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O'.$baris, $gugus[1]);	
			$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P'.$baris, $gugus[2]);				
			$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q'.$baris, "=SUM(N".$baris.":P".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$mbs = $this->mlaporan->getJumMbsSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('R'.$baris, $mbs);	
			$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$kur = $this->mlaporan->getJumKurSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('S'.$baris, $kur[0]);	
			$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T'.$baris, $kur[1]);	
			$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U'.$baris, $kur[2]);							
			$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V'.$baris, $kur[3]);
			$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$no++;
			$baris++;
		}
		$terakhir = $baris - 1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, '=SUM(E5:E'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, '=SUM(F5:F'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G'.$baris, '=SUM(G5:G'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H'.$baris, '=SUM(H5:H'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I'.$baris, '=SUM(I5:I'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J'.$baris, '=SUM(J5:J'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K'.$baris, '=SUM(K5:K'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L'.$baris, '=SUM(L5:L'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M'.$baris, '=SUM(M5:M'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N'.$baris, '=SUM(N5:N'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O'.$baris, '=SUM(O5:O'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P'.$baris, '=SUM(P5:P'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q'.$baris, '=SUM(Q5:Q'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('R'.$baris, '=SUM(R5:R'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S'.$baris, '=SUM(S5:S'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T'.$baris, '=SUM(T5:T'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U'.$baris, '=SUM(U5:U'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V'.$baris, '=SUM(V5:V'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$brs_bwh = $baris;
		$this->excel->getActiveSheet()->getStyle('A3:V'.$brs_bwh)->applyFromArray($styleArray);

			$filename='RK Dinpendik Data Siswa '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
					             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_spm()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');
		$jenjang = $this->input->post('jenjang',TRUE);

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$jumlah_kols = count($this->input->post('tahun',TRUE));
		$jumlah_kols = 3+(3*$jumlah_kols);
		$kol_akhir = $huruf[$jumlah_kols-1];
		
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);
		$this->excel->getActiveSheet()->setTitle("Data");

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/rembang.jpg');
		$objDrawing->setWidth(70);		
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		//format number
		//$this->excel->getActiveSheet()->getStyle($nkolom.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		//background
		//$this->excel->getActiveSheet()->getStyle('A'.$baris.':O'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FAE502');
		//border
		//$this->excel->getActiveSheet()->getStyle('A6:O'.$baris)->applyFromArray($styleArray);

		$this->excel->getActiveSheet()->mergeCells('B1:'.$kol_akhir.'1');		
		$this->excel->getActiveSheet()->setCellValue('B1', 'PEMERINTAH KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B2:'.$kol_akhir.'2');		
		$this->excel->getActiveSheet()->setCellValue('B2', 'DINAS PENDIDIKAN');
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:'.$kol_akhir.'3');		
		$this->excel->getActiveSheet()->setCellValue('B3', 'Jalan Pemuda Km. 2 Telp (0295) 691326; 692172 Kode Pos 59218');
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B4:'.$kol_akhir.'4');		
		$this->excel->getActiveSheet()->setCellValue('B4', 'Email : dinpendik@rembangkab.go.id website : dinpendik.rembangkab.go.id');
		$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('A6:'.$kol_akhir.'6');		
		$this->excel->getActiveSheet()->setCellValue('A6', 'DATA DASAR SPM PENDIDIKAN DASAR');
		$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(12);
		$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);				
		$this->excel->getActiveSheet()->mergeCells('A7:'.$kol_akhir.'7');		
		$this->excel->getActiveSheet()->setCellValue('A7', 'BERDASARKAN PERATURAN MENTERI PENDIDIKAN DAN KEBUDAYAAN NOMOR 23 TAHUN 2013');
		$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(12);
		$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('A8:B8');
		$this->excel->getActiveSheet()->mergeCells('A8:A9');
		$this->excel->getActiveSheet()->setCellValue('A8', 'JENIS PELAYANAN DASAR/INDIKATOR SPM');
		$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
		$this->excel->getActiveSheet()->mergeCells('C8:C9');
		$this->excel->getActiveSheet()->setCellValue('C8', 'TINGKAT');
		$this->excel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$baris = 8;
		$kolom = "C";
		$cari = array_search($kolom, $huruf);
		$tahun = $this->input->post('tahun');		
		foreach($tahun as $dt_tahun)
		{			
			$awal = $huruf[$cari+1];
			$kedua = $huruf[$cari+2];
			$akhir = $huruf[$cari+3];
			$barDua = $baris+1;
			$this->excel->getActiveSheet()->mergeCells($awal.$baris.':'.$akhir.$baris);
			$this->excel->getActiveSheet()->setCellValue($awal.$baris, $this->mlaporan->setTahun($dt_tahun));
			$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($awal.$barDua, 'Pembilang(a)');
			$this->excel->getActiveSheet()->getStyle($awal.$barDua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($kedua.$barDua, 'Penyebut(b)');
			$this->excel->getActiveSheet()->getStyle($kedua.$barDua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($akhir.$barDua, 'CAPAIAN');
			$this->excel->getActiveSheet()->getStyle($akhir.$barDua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$baris.':'.$akhir.$barDua)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('538dd5');
			$cari+=3;
		}				
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$akhhir = substr($currentCell, 0,1);
		$baris = 10;
		$header = $this->arey->getJenisKue();
		$indeks = 0;
		$aka = 0;
		$no = 1;
		foreach($header as $key => $value)
		{
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':'.$kol_akhir.$baris);		
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $huruf[$aka].'. '.$value);	
			$this->excel->getActiveSheet()->getStyle('A'.$baris.':A'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('5bd4ff');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setWrapText(true);				
			$baris++;
			$indeks++;
			$headers = $this->mlaporan->getHeaderLap($key);		
			foreach($headers as $dt_headers)
			{
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no.'.');
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->mergeCells('B'.$baris.':'.$kol_akhir.$baris);
				$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setWrapText(true);				
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, trim($dt_headers->text_kuesioner));
				$this->excel->getActiveSheet()->getStyle('A'.$baris.':B'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffff99');
				$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$baris++;
				$indeks++;
				$detilSoal = $this->mlaporan->getAllTotalSoal($dt_headers->id_kuesioner,$no);				
				$getStatusJawab = $this->mlaporan->getStatusJawab($dt_headers->id_kuesioner);
				$jenjang = $this->mlaporan->getJenjang($dt_headers->id_kuesioner);				
				$total = $this->mlaporan->getTotalSoal($dt_headers->id_kuesioner,$getStatusJawab);
				$ttl = $this->mlaporan->getTotalSoalJenjang($dt_headers->id_kuesioner);
				$totSol = $this->mlaporan->getTotalSoals($dt_headers->id_kuesioner);
				$kelipatan = ($total > $ttl)?2:1;
				$tingkats = 1;
				for($j=1;$j<=$kelipatan;$j++)
				{
					$u = 0;
					foreach($jenjang as $key => $dt_jenjang)
					{																												
						$this->excel->getActiveSheet()->setCellValue('C'.$baris, $this->arey->getDetailJenjang($dt_jenjang->jenjang_school,$dt_jenjang->detail_jenjang_kuesioner));
						$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$klom = "D";
						$index = array_search($klom, $huruf);
						$tahun = $this->input->post('tahun');
						foreach($tahun as $dt_tahun)
						{							
							$o = 0;
							for($i=$index;$i<$index+3;$i++)
							{								
								$indekss = $no - 1;
								$indess = $j - 1;								
								$klm = $huruf[$i];
								$soalTulis = $this->mlaporan->getJumSoalTulis($dt_headers->id_kuesioner);
								$soalTulis = $soalTulis*2;															
								$jawaban = $this->mlaporan->getJawaban($dt_headers->id_kuesioner);
								$jenis_ket_kuesioner = $this->mlaporan->getJenisKetKue($dt_headers->id_kuesioner);
								//$jawab = ($jawaban == 2)? $this->mlaporan->getManual($dt_headers->id_kuesioner,$dt_headers->jenis_kuesioner,$jenis_ket_kuesioner,$tingkats,$dt_jenjang->jenjang_school,$dt_tahun) : $this->mlaporan->getTotal($dt_jenjang->jenjang_school,$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,$jenjang,$jenis_ket_kuesioner);
								$jawab = ($jawaban == 2)? $this->mlaporan->getManual($dt_headers->id_kuesioner,$dt_headers->jenis_kuesioner,$jenis_ket_kuesioner,$tingkats,$dt_jenjang->jenjang_school,$dt_tahun) : $this->mlaporan->getTotal($dt_jenjang->jenjang_school,$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,$jenjang,$jenis_ket_kuesioner);
								//$pembilang = ($jawaban == 2)? $this->mlaporan->getManualTotal($dt_jenjang->id_detail_kuesioner,$dt_tahun,$this->session->userdata('id_school'),$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,$jenjang,$jenis_ket_kuesioner,$tingkats) : $this->mlaporan->getTotalPem($dt_jenjang->id_detail_kuesioner,$dt_tahun,$this->session->userdata('id_school'),$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,count($jenjang));								
								$pembilang = ($jawaban == 2)? $this->mlaporan->getManualTotal($dt_jenjang->id_detail_kuesioner,$dt_tahun,$this->session->userdata('id_school'),$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,$jenjang,$jenis_ket_kuesioner,$tingkats) : $this->mlaporan->getTotalPem($dt_jenjang->id_detail_kuesioner,$dt_tahun,$this->session->userdata('id_school'),$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,count($jenjang));								
								$kueris1 = $this->mlaporan->getDetailLaporan($dt_tahun);																								
								$jwb = ($jawab == 0)?1:$jawab;
								$pembilang = ($pembilang <= 0)?1:$pembilang;
								$pembil = round($pembilang/$jwb * 100,2);																
								if($o == 0)
								{
									$this->excel->getActiveSheet()->setCellValue($klm.$baris, $pembilang);
								}
								elseif($o == 1)
								{
									$this->excel->getActiveSheet()->setCellValue($klm.$baris, $jawab);
								}
								else
								{
									$this->excel->getActiveSheet()->setCellValue($klm.$baris, (float)$pembil);
								}
								$o++;
							}					
							$index+=3;
						}
						$u++;
						$baris++;
						$indeks++;
						$tingkats++;

						$jumlah = count($jenjang);	

						$pembilang = $this->mlaporan->getPembilang($dt_jenjang->id_kuesioner);
						$penyebut = $this->mlaporan->getPenyebut($dt_jenjang->id_kuesioner);

						$butuh = (count($penyebut) > 0)?count($pembilang) * 2:count($pembilang);

					}
				}				
	
				$jum_soal = $this->mlaporan->getJumSoale($dt_headers->id_kuesioner,$getStatusJawab);
				$jum_sok = count($detilSoal);
				$jum_soal = $jum_soal*2;
				$mulai = $baris - $total;
				$akhr = $baris - 1;
				$jarak = $akhr - $mulai + 1;
				//$totSol = ($totSol <= 0)?1:$totSol;
				//$total = ($total <= 0)?1:$total;
				//$kel = round($total/$jum_soal, 0);				
				$kel = round($jarak/$jum_sok, 0);				
				//$kel = round($jarak/$total, 0);
				//print_r($detilSoal);				
				//echo $getStatusJawab."-".$total."-".$jum_soal."-".$kel."-".$jarak."-".$jum_sok;				
				//echo "<br/>";				
				$t = 0;
				if(count($detilSoal) > 1)
				{
					for($w=$mulai;$w<=$akhr;$w+=$kel)
					{
						$ak = $w + $kel - 1;
						$this->excel->getActiveSheet()->mergeCells('B'.$w.':B'.$ak);		
						$this->excel->getActiveSheet()->setCellValue('B'.$w, $detilSoal[$t]);
						$this->excel->getActiveSheet()->getStyle('B'.$w)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$t++;
					}				
				}
				else
				{
					$ak = $mulai + $total - 1;
					$this->excel->getActiveSheet()->mergeCells('B'.$mulai.':B'.$ak);		
					$this->excel->getActiveSheet()->setCellValue('B'.$mulai, $detilSoal[0]);
					$this->excel->getActiveSheet()->getStyle('B'.$mulai)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				}
				$this->excel->getActiveSheet()->mergeCells('A'.$mulai.':A'.$akhr);
	
				$no++;										
			}
			$aka++;									
		}
		//exit();

		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A8:'.$klm.$brs_bwh)->applyFromArray($styleArray);		

		
		//sheet kedua
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);
		$this->excel->getActiveSheet()->setTitle("Profil");

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$jumlah_kols = count($this->input->post('tahun',TRUE));
		$jumlah_kols = 4+$jumlah_kols;
		$kol_akhir = $huruf[$jumlah_kols-1];

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/rembang.jpg');
		$objDrawing->setWidth(70);		
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		$this->excel->getActiveSheet()->mergeCells('B1:'.$kol_akhir.'1');		
		$this->excel->getActiveSheet()->setCellValue('B1', 'PEMERINTAH KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B2:'.$kol_akhir.'2');		
		$this->excel->getActiveSheet()->setCellValue('B2', 'DINAS PENDIDIKAN');
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:'.$kol_akhir.'3');		
		$this->excel->getActiveSheet()->setCellValue('B3', 'Jalan Pemuda Km. 2 Telp (0295) 691326; 692172 Kode Pos 59218');
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B4:'.$kol_akhir.'4');		
		$this->excel->getActiveSheet()->setCellValue('B4', 'Email : dinpendik@rembangkab.go.id website : dinpendik.rembangkab.go.id');
		$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('A6:'.$kol_akhir.'6');		
		$this->excel->getActiveSheet()->setCellValue('A6', 'PROFIL SPM BIDANG PENDIDIKAN DASAR');
		$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(12);
		$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);				
		$this->excel->getActiveSheet()->mergeCells('A7:'.$kol_akhir.'7');		
		$this->excel->getActiveSheet()->setCellValue('A7', 'KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(12);
		$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->mergeCells('B8:C8');
		$this->excel->getActiveSheet()->mergeCells('B8:B9');
		$this->excel->getActiveSheet()->setCellValue('B8', 'JENIS PELAYANAN DASAR/INDIKATOR SPM');
		$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
		$baris = 8;
		$kolom = "C";
		$cari = array_search($kolom, $huruf);
		$tahun = $this->input->post('tahun');
		$jumlah = $cari+count($tahun)+1;
		$this->excel->getActiveSheet()->mergeCells('B5:C5');
		$awal = $huruf[$cari+1];
		$akhir = $huruf[$jumlah];
		$berikut = $baris+1;
		$this->excel->getActiveSheet()->mergeCells($awal.$baris.':'.$akhir.$baris);
		$this->excel->getActiveSheet()->setCellValue($awal.$baris, 'PERHITUNGAN(%)');
		$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue($awal.$berikut, 'TINGKAT');
		$this->excel->getActiveSheet()->getStyle($awal.$berikut)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('B'.$baris.':'.$awal.$berikut)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('538dd5');
		$awal = $awal+4;
		foreach($tahun as $dt_tahun)
		{						
			$thn = $huruf[$awal];					
			$this->excel->getActiveSheet()->setCellValue($thn.$berikut, substr($this->mlaporan->setTahun($dt_tahun), 0,4));
			$this->excel->getActiveSheet()->getStyle($thn.$berikut)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			$awal++;
		}
		$this->excel->getActiveSheet()->getStyle('B'.$baris.':'.$thn.$berikut)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('538dd5');

		$baris = 10;
		$header = $this->arey->getJenisKue();
		$indeks = 0;
		$aka = 0;
		foreach($header as $key => $value)
		{
			$this->excel->getActiveSheet()->mergeCells('B'.$baris.':'.$kol_akhir.$baris);		
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $abjad[$aka].'. '.$value);
			$this->excel->getActiveSheet()->getStyle('B'.$baris.':'.$kol_akhir.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('5bd4ff');	
			$baris++;
			$indeks++;
			$headers = $this->mlaporan->getHeaderLap($key);
			$no = 1;
			foreach($headers as $dt_headers)
			{				
				$indeks++;
				$detilSoal = $this->mlaporan->getAllTotalSoal($dt_headers->id_kuesioner,$no);
				$getStatusJawab = $this->mlaporan->getStatusJawab($dt_headers->id_kuesioner);
				$jenjang = $this->mlaporan->getJenjang($dt_headers->id_kuesioner);
				$total = $this->mlaporan->getTotalSoal($dt_headers->id_kuesioner,$getStatusJawab);
				$ttl = $this->mlaporan->getTotalSoalJenjang($dt_headers->id_kuesioner);
				$totSol = $this->mlaporan->getTotalSoals($dt_headers->id_kuesioner);
				$kelipatan = ($total > $ttl)?2:1;	
				$y = 1;		
				$tingkats = 1;	
				for($j=1;$j<=$kelipatan;$j++)
				{
					foreach($jenjang as $key => $dt_jenjang)
					{									
						$this->excel->getActiveSheet()->setCellValue('D'.$baris, $this->arey->getDetailJenjang($dt_jenjang->jenjang_school,$dt_jenjang->detail_jenjang_kuesioner));
						$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$klom = "E";
						$index = array_search($klom, $huruf);
						$tahun = $this->input->post('tahun');
						foreach($tahun as $dt_tahun)
						{
							$indekss = $no - 1;
							$indess = $j - 1;							
							$jawaban = $this->mlaporan->getJawaban($dt_headers->id_kuesioner);
							$jenis_ket_kuesioner = $this->mlaporan->getJenisKetKue($dt_headers->id_kuesioner);
							$jawab = ($jawaban == 2)? $this->mlaporan->getManual($dt_headers->id_kuesioner,$dt_headers->jenis_kuesioner,$jenis_ket_kuesioner,$tingkats,$dt_jenjang->jenjang_school,$dt_tahun) : $this->mlaporan->getTotal($dt_jenjang->jenjang_school,$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,$jenjang,$jenis_ket_kuesioner);
							$pembilang = ($jawaban == 2)? $this->mlaporan->getManualTotal($dt_jenjang->id_detail_kuesioner,$dt_tahun,$this->session->userdata('id_school'),$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,$jenjang,$jenis_ket_kuesioner,$tingkats) : $this->mlaporan->getTotalPem($dt_jenjang->id_detail_kuesioner,$dt_tahun,$this->session->userdata('id_school'),$dt_headers->jenis_kuesioner,count($detilSoal),$soalTulis,count($jenjang));
							$kueris1 = $this->mlaporan->getDetailLaporan($dt_tahun);								
							$jwb = ($jawab == 0)?1:$jawab;
							$pembilang = ($pembilang <= 0)?1:$pembilang;
							$pembil = round($pembilang/$jwb * 100,2);
							$this->excel->getActiveSheet()->setCellValue($huruf[$index].$baris, $pembil);
							$index++;							
						}					
						$baris++;
						$indeks++;
						$tingkats++;

						$jumlah = count($jenjang);	

						$pembilang = $this->mlaporan->getPembilang($dt_jenjang->id_kuesioner);
						$penyebut = $this->mlaporan->getPenyebut($dt_jenjang->id_kuesioner);

						$butuh = (count($penyebut) > 0)?count($pembilang) * 2:count($pembilang);												
						$y++;
					}					
				}
				$tmp = $y-1;
				$awal = $baris - $tmp;
				$akhir = $baris - 1;
				$this->excel->getActiveSheet()->mergeCells('C'.$awal.':C'.$akhir);
				$this->excel->getActiveSheet()->setCellValue('C'.$awal, trim($dt_headers->text_kuesioner));
				$this->excel->getActiveSheet()->getStyle('C'.$awal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);		
				$no++;											
			}
			$aka++;
		}
		$brs_bwh = $baris - 1;		
		$this->excel->getActiveSheet()->getStyle('B8:'.$huruf[$jumlah_kols-1].$brs_bwh)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('C8:C'.$this->excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);


		//sheet ketiga
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->setTitle("Guru");
		$this->excel->getActiveSheet()->mergeCells('A1:E1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$baris = 3;

		$jenjang = $this->arey->getJenjang();
		foreach($jenjang as $key => $dt_jenjang)
		{
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':E'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $dt_jenjang);
			$baris++;
			$kedua = $baris+1;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'NO');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':A'.$kedua);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, 'NAMA MAPEL');
			$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('B'.$baris.':B'.$kedua);
			$this->excel->getActiveSheet()->mergeCells('C'.$baris.':D'.$baris);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, 'JUMLAH');
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValue('C'.$kedua, 'LAKI-LAKI');
			$this->excel->getActiveSheet()->getStyle('C'.$kedua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('D'.$kedua, 'PEREMPUAN');
			$this->excel->getActiveSheet()->getStyle('D'.$kedua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('E'.$baris.':E'.$kedua);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, 'TOTAL');
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$baris+=2;
			$mapel = $this->mlaporan->getMapelAll($key);		
			$thun = $this->mlaporan->getTaAktif();
			$laki2 = 0;
			$peremp = 0;
			$tot = 0;
			$u = 1;
			foreach($mapel as $dt_mapel)
			{					
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $u);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $this->arey->getJabatan($dt_mapel->id_jabatan,1));
				$laki = $this->mlaporan->getJumMapelAll($dt_mapel->id_jabatan,'1',$key);
				$laki2 = $laki2 + $laki;
				$perempuan = $this->mlaporan->getJumMapelAll($dt_mapel->id_jabatan,'2',$key);
				$peremp = $peremp + $perempuan;
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $laki);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $perempuan);
				$total = $laki+$perempuan;
				$tot = $tot + $total;
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $total);
				$u++;				
				$baris++;
			}			
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, "Jumlah");
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $laki2);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $peremp);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $tot);
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$baris+=2;
		}	

		$this->excel->getActiveSheet()->getStyle('A3:E'.$baris)->applyFromArray($styleArray);


		//sheet keempat
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(3);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);		
		$this->excel->getActiveSheet()->setTitle("Siswa");		
		$this->excel->getActiveSheet()->mergeCells('A1:F1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA SISWA SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$baris = 3;

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$jenjang = $this->arey->getJenjang();
		foreach($jenjang as $key => $dt_jenjang)
		{
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':F'.$baris);
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $dt_jenjang);
			$baris++;
			$awale = $baris;
			$kedua = $baris+1;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'NO');
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('A'.$baris.':A'.$kedua);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, 'KELAS');
			$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('B'.$baris.':B'.$kedua);
			$this->excel->getActiveSheet()->mergeCells('C'.$baris.':D'.$baris);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, 'JUMLAH');
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValue('C'.$kedua, 'LAKI-LAKI');
			$this->excel->getActiveSheet()->getStyle('C'.$kedua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('D'.$kedua, 'PEREMPUAN');
			$this->excel->getActiveSheet()->getStyle('D'.$kedua)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('E'.$baris.':E'.$kedua);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, 'TOTAL');
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->mergeCells('F'.$baris.':F'.$kedua);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, 'DETAIL UMUR');
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();			
			$kolom = substr($currentCell, 0,1);
			$cari = array_search($kolom, $huruf);
			$jumProdi = $this->mlaporan->getProdiAll($key);
			$current = $cari + 1;			
			if(count($jumProdi) > 0)
			{			
				$kolAwal = $huruf[$cari+1];			
				$akhir = $cari+count($jumProdi);
				$kolAkhir = $huruf[$akhir];			
				$atas = $baris;
				$bawah = $baris+1;
				$this->excel->getActiveSheet()->mergeCells($kolAwal.$atas.':'.$kolAkhir.$atas);
				$this->excel->getActiveSheet()->setCellValue($kolAwal.$atas, "PROGRAM STUDI");
				$this->excel->getActiveSheet()->getStyle($kolAwal.$atas)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				$o = $cari+1;
				foreach($jumProdi as $dt_jumProdi)
				{
					$kolum = $huruf[$o];
					$kolomsss[] = $kolum;
					$this->excel->getActiveSheet()->setCellValue($kolum.$bawah, $dt_jumProdi->kode_prodi);
					$this->excel->getActiveSheet()->getColumnDimension($kolum)->setWidth(14);
					$this->excel->getActiveSheet()->getStyle($kolum.$bawah)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
					$o++;
				}
			}
			$baris+=2;
			if($key == 1)
			{
				for($i=1;$i<=6;$i++)
				{
					$this->excel->getActiveSheet()->setCellValue('A'.$baris, $i);
					$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue('B'.$baris, 'Kelas '.$i);
					$thn = $thun['tahun'];			
					$ids = $this->session->userdata('id_school');			
					$jumlah = $this->mlaporan->getJumMuridAll($key,$i,$thn);
					$this->excel->getActiveSheet()->setCellValue('C'.$baris, $jumlah['laki']);
					$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
					$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumlah['perempuan']);
					$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
					$total = $jumlah['perempuan']+$jumlah['laki'];
					$this->excel->getActiveSheet()->setCellValue('E'.$baris, $total);
					$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
					$detail = $this->mlaporan->getDetailMuridAll($key,$i,$thn);
					$this->excel->getActiveSheet()->setCellValue('F'.$baris, $detail);	
					$this->excel->getActiveSheet()->getStyle('F'.$baris, $detail)->getAlignment()->setWrapText(true);				
					$baris++;
				}
			}
			else
			{
				for($i=1;$i<=3;$i++)
				{
					$this->excel->getActiveSheet()->setCellValue('A'.$baris, $i);
					$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue('B'.$baris, 'Kelas '.$i);					
					if(count($jumProdi) > 0)
					{								
						foreach($jumProdi as $kuncis => $dt_jumProdi)
						{
							$colum = $kolomsss[$kuncis];
							$isi_jur = $this->mlaporan->getDetailJurAll($dt_jumProdi->id_prodi,$key,$i,$thn);
							$this->excel->getActiveSheet()->setCellValue($colum.$baris, $isi_jur );
							$this->excel->getActiveSheet()->getStyle($colum.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
							$kolAwal++;
						}
					}
					$baris++;
				}
			}
			if($key == 4)
			{
				$this->excel->getActiveSheet()->getStyle('A'.$awale.':'.$colum.$baris)->applyFromArray($styleArray);
			}
			else
			{
				$this->excel->getActiveSheet()->getStyle('A'.$awale.':F'.$baris)->applyFromArray($styleArray);
			}			
			$baris++;
		}		

		//sheet kelima
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(4);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);		
		$this->excel->getActiveSheet()->setTitle("Sekolah");
		$this->excel->getActiveSheet()->mergeCells('A1:J1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'JUMLAH GURU BERDASARKAN KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:J3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'JENJANG');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C4:D4');
		$this->excel->getActiveSheet()->setCellValue('C4', 'SD/MI');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C5', 'L');
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D5', 'P');
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E4:F4');
		$this->excel->getActiveSheet()->setCellValue('E4', 'SMP/MTs');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E5', 'L');
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F5', 'P');
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('G4:H4');
		$this->excel->getActiveSheet()->setCellValue('G4', 'SMA/MA');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G5', 'L');
		$this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H5', 'P');
		$this->excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('I4:J4');
		$this->excel->getActiveSheet()->setCellValue('I4', 'SMK');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I5', 'L');
		$this->excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J5', 'P');
		$this->excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$baris = 6;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;		
		foreach($kecamatan as $dt_kecamatan)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);
			$jumlah = $this->mlaporan->getJumGuruSkul($dt_kecamatan->id_kecamatan);			
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $jumlah[1]['lk']);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumlah[1]['pr']);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $jumlah[2]['lk']);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $jumlah[2]['pr']);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $jumlah[3]['lk']);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $jumlah[3]['pr']);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, $jumlah[4]['lk']);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $jumlah[4]['pr']);			
			$no++;
			$baris++;
		}
		$akhire = $baris-1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, "JUMLAH");
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->setCellValue('C'.$baris, "=SUM(C6:C".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('D'.$baris, "=SUM(D6:D".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(E6:E".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(F6:F".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('G'.$baris, "=SUM(G6:G".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('H'.$baris, "=SUM(H6:CH".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(I6:I".$akhire.")");
		$this->excel->getActiveSheet()->setCellValue('J'.$baris, "=SUM(J6:J".$akhire.")");

		$this->excel->getActiveSheet()->getStyle('A3:J'.$baris)->applyFromArray($styleArray);

		//sheet keenam
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(5);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->setTitle("Guru Kecamatan");
		$this->excel->getActiveSheet()->mergeCells('A1:N1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'PTK BERDASARKAN STATUS');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:N3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'PTK BERDASARKAN STATUS');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C4:D4');
		$this->excel->getActiveSheet()->setCellValue('C4', 'PNS');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C5', 'L');
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D5', 'P');
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E4:F4');
		$this->excel->getActiveSheet()->setCellValue('E4', 'CPNS');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E5', 'L');
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F5', 'P');
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('G4:H4');
		$this->excel->getActiveSheet()->setCellValue('G4', 'GTT');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G5', 'L');
		$this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H5', 'P');
		$this->excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('I4:J4');
		$this->excel->getActiveSheet()->setCellValue('I4', 'PTT');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I5', 'L');
		$this->excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J5', 'P');
		$this->excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('K4:L4');
		$this->excel->getActiveSheet()->setCellValue('K4', 'GTY');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K5', 'L');
		$this->excel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L5', 'P');
		$this->excel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('M4:N4');
		$this->excel->getActiveSheet()->setCellValue('M4', 'PTY');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M5', 'L');
		$this->excel->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N5', 'P');
		$this->excel->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$baris = 6;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;		
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);
			$detailpeg = $this->mlaporan->getDetailPegStatus($dt_kecamatan->id_kecamatan);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $detailpeg['pns_lk']);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $detailpeg['pns_pr']);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $detailpeg['cpns_lk']);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $detailpeg['cpns_pr']);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $detailpeg['gtt_lk']);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $detailpeg['gtt_pr']);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, $detailpeg['ptt_lk']);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $detailpeg['ptt_pr']);
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, $detailpeg['gty_lk']);
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, $detailpeg['gty_pr']);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, $detailpeg['pty_lk']);			
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, $detailpeg['pty_pr']);						
			$no++;
			$baris++;
		}
		$akhiripun = $baris - 1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->setCellValue('C'.$baris, "=SUM(C6:C".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('D'.$baris, "=SUM(D6:D".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(E6:E".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(F6:F".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('G'.$baris, "=SUM(G6:G".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('H'.$baris, "=SUM(H6:H".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(I6:I".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('J'.$baris, "=SUM(J6:J".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('K'.$baris, "=SUM(K6:K".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('L'.$baris, "=SUM(L6:L".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('M'.$baris, "=SUM(M6:M".$akhiripun.")");
		$this->excel->getActiveSheet()->setCellValue('N'.$baris, "=SUM(N6:N".$akhiripun.")");		

		$this->excel->getActiveSheet()->getStyle('A3:N'.$baris)->applyFromArray($styleArray);

		$baris = $baris + 4;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':J'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'GURU BERDASARKAN SERTIFIKASI');
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$baris = $baris + 1;
		$baris1 = $baris + 1;
		$baris2 = $baris + 2;
		$awalipun = $baris2;
		$awal2 = $baris;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':A'.$baris2);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'NO');
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B'.$baris.':B'.$baris2);
		$this->excel->getActiveSheet()->setCellValue('B'.$baris, 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C'.$baris.':J'.$baris);
		$this->excel->getActiveSheet()->setCellValue('C'.$baris, 'GURU BERDASARKAN SERTIFIKAT');
		$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C'.$baris1.':D'.$baris1);
		$this->excel->getActiveSheet()->setCellValue('C'.$baris1, 'PNS SERTIFIKASI');
		$this->excel->getActiveSheet()->getStyle('C'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C'.$baris2, 'L');
		$this->excel->getActiveSheet()->getStyle('C'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D'.$baris2, 'P');
		$this->excel->getActiveSheet()->getStyle('D'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E'.$baris1.':F'.$baris1);
		$this->excel->getActiveSheet()->setCellValue('E'.$baris1, 'Non PNS SERTIFIKASI');	
		$this->excel->getActiveSheet()->getStyle('E'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E'.$baris2, 'L');
		$this->excel->getActiveSheet()->getStyle('E'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$baris2, 'P');
		$this->excel->getActiveSheet()->getStyle('F'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('G'.$baris1.':H'.$baris1);
		$this->excel->getActiveSheet()->setCellValue('G'.$baris1, 'PNS BELUM SERTIFIKASI');
		$this->excel->getActiveSheet()->getStyle('G'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G'.$baris2, 'L');
		$this->excel->getActiveSheet()->getStyle('G'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H'.$baris2, 'P');
		$this->excel->getActiveSheet()->getStyle('H'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('I'.$baris1.':J'.$baris1);
		$this->excel->getActiveSheet()->setCellValue('I'.$baris1, 'Non PNS BELUM SERTIFIKASI');
		$this->excel->getActiveSheet()->getStyle('I'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue('I'.$baris2, 'L');
		$this->excel->getActiveSheet()->getStyle('I'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J'.$baris2, 'P');
		$this->excel->getActiveSheet()->getStyle('J'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$baris = $baris2 + 1;
		$no = 1;		
		foreach($kecamatan as $dt_kecamatan)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);	
			$sertifikasi = $this->mlaporan->getSertifikasi($dt_kecamatan->id_kecamatan);			
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $sertifikasi['pns_ser_lk']);			
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $sertifikasi['pns_ser_pr']);			
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $sertifikasi['non_pns_ser_lk']);						
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $sertifikasi['non_pns_ser_pr']);			
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $sertifikasi['pns_bel_lk']);						
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $sertifikasi['pns_bel_pr']);			
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, $sertifikasi['non_pns_bel_lk']);			
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $sertifikasi['non_pns_bel_pr']);			
			$no++;
			$baris++;
		}
		$akhiripun = $baris-1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
		$this->excel->getActiveSheet()->setCellValue('C'.$baris, "=SUM(C".$awalipun.":C".$akhiripun.")");		
		$this->excel->getActiveSheet()->setCellValue('D'.$baris, "=SUM(D".$awalipun.":D".$akhiripun.")");		
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(E".$awalipun.":E".$akhiripun.")");					
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(F".$awalipun.":F".$akhiripun.")");		
		$this->excel->getActiveSheet()->setCellValue('G'.$baris, "=SUM(G".$awalipun.":G".$akhiripun.")");					
		$this->excel->getActiveSheet()->setCellValue('H'.$baris, "=SUM(H".$awalipun.":H".$akhiripun.")");					
		$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(I".$awalipun.":I".$akhiripun.")");		
		$this->excel->getActiveSheet()->setCellValue('J'.$baris, "=SUM(J".$awalipun.":J".$akhiripun.")");					

		$this->excel->getActiveSheet()->getStyle('A'.$awal2.':J'.$baris)->applyFromArray($styleArray);

		$filename='SPM Dinpendik Rembang '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}	

	function sekolah($id="")
	{		
		if($id == "")
		{
			$this->message->set('notice','Maaf Parameter Laporan Salah, Silahkan Login Terlebih Dahulu');
			redirect('dashboard');	
		}

		$data = array(
			'main'			=> 'formLaporan',
			'laporan'		=> 'select',			
			'id'			=> $id
		);

		$this->load->view('template',$data);
	}

	function generate_sekolah($id)
	{
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->setTitle("Profil");
		$this->excel->getActiveSheet()->mergeCells('A1:C1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sekolah = $this->mlaporan->getDetailSchool($id);
		foreach($sekolah as $dt_sekolah)
		{
			$this->excel->getActiveSheet()->mergeCells('A3:B3');			
			$this->excel->getActiveSheet()->setCellValue('A3', "Nama Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C3', $dt_sekolah->nama_school);
			$this->excel->getActiveSheet()->getRowDimension('4')->setRowHeight(4);			
			$this->excel->getActiveSheet()->setCellValue('B5', "Kepala Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C5', $this->mlaporan->getKepsek($dt_sekolah->id_guru));
			$this->excel->getActiveSheet()->getRowDimension('6')->setRowHeight(4);			
			$this->excel->getActiveSheet()->setCellValue('B7', "Status Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C7', $this->arey->getStatus($dt_sekolah->status_school));
			$this->excel->getActiveSheet()->getRowDimension('8')->setRowHeight(4);			
			$this->excel->getActiveSheet()->setCellValue('B9', "Jenjang Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C9', $this->arey->getJenjang($dt_sekolah->jenjang_school)." pada tingkat ".$this->arey->getDetailJenjang($dt_sekolah->jenjang_school,$dt_sekolah->tingkat_school));
			$this->excel->getActiveSheet()->getRowDimension('10')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B11', "NSS Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C11', $dt_sekolah->nss_school." ".$dt_sekolah->nss_school);
			$this->excel->getActiveSheet()->getRowDimension('12')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B13', "NPSN Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C13', $dt_sekolah->npsn_school." ".$dt_sekolah->npsn_school);
			$this->excel->getActiveSheet()->getRowDimension('14')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B15', "Kelompok Sekolah(Khusus SMK)");
			$this->excel->getActiveSheet()->setCellValue('C15', $this->arey->getKelompok($dt_sekolah->kelompok_school));
			$this->excel->getActiveSheet()->getRowDimension('16')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A17:B17');
			$this->excel->getActiveSheet()->setCellValue('A17', "Alamat");			
			$this->excel->getActiveSheet()->getRowDimension('18')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B19', "Alamat");
			$this->excel->getActiveSheet()->setCellValue('C19', $dt_sekolah->alamat_school);
			$this->excel->getActiveSheet()->getRowDimension('20')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B21', "Desa");
			$this->excel->getActiveSheet()->setCellValue('C21', $dt_sekolah->desa_school);
			$this->excel->getActiveSheet()->getRowDimension('22')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B23', "Jenis Desa");
			$this->excel->getActiveSheet()->setCellValue('C23', $this->arey->getDesa($dt_sekolah->desa_pil));
			$this->excel->getActiveSheet()->getRowDimension('24')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B25', "Kecamatan");
			$detilse = $this->mlaporan->getDetailSekali($dt_sekolah->id_kecamatan);
			$this->excel->getActiveSheet()->setCellValue('C25', $detilse['kecamatan']);
			$this->excel->getActiveSheet()->getRowDimension('26')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B27', "Kabupaten");
			$this->excel->getActiveSheet()->setCellValue('C27', $detilse['kabupaten']);
			$this->excel->getActiveSheet()->getRowDimension('28')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B29', "Provinsi");
			$this->excel->getActiveSheet()->setCellValue('C29', $detilse['propinsi']);
			$this->excel->getActiveSheet()->getRowDimension('30')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B31', "Klasifikasi Geografis");
			$this->excel->getActiveSheet()->setCellValue('C31', $this->arey->getGeografis($dt_sekolah->klasifikasi_school));
			$this->excel->getActiveSheet()->getRowDimension('32')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B33', "Kode POS");
			$this->excel->getActiveSheet()->setCellValue('C33', $dt_sekolah->kode_pos);
			$this->excel->getActiveSheet()->getStyle('C33')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
			$this->excel->getActiveSheet()->getRowDimension('34')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B35', "Kode Area Telp");
			$this->excel->getActiveSheet()->setCellValue('C35', $dt_sekolah->kode_area_tlp);
			$this->excel->getActiveSheet()->getStyle('C35')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
			$this->excel->getActiveSheet()->getRowDimension('36')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B37', "Kode Area Fax");
			$this->excel->getActiveSheet()->setCellValue('C37', $dt_sekolah->kode_area_fax);
			$this->excel->getActiveSheet()->getStyle('C37')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
			$this->excel->getActiveSheet()->getRowDimension('38')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B39', "Akses Internet");
			$this->excel->getActiveSheet()->setCellValue('C39', $this->arey->getadaTidak($dt_sekolah->akses_inet));
			$this->excel->getActiveSheet()->getRowDimension('40')->setRowHeight(4);			
			$this->excel->getActiveSheet()->setCellValue('B41', "Provider");
			$this->excel->getActiveSheet()->setCellValue('C41', $this->arey->getProvider($dt_sekolah->provider));
			$this->excel->getActiveSheet()->getRowDimension('42')->setRowHeight(4);

			$this->excel->getActiveSheet()->setCellValue('B43', "E-mail");
			$this->excel->getActiveSheet()->setCellValue('C43', $dt_sekolah->email);
			$this->excel->getActiveSheet()->getRowDimension('44')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B45', "Website");
			$this->excel->getActiveSheet()->setCellValue('C45', $dt_sekolah->website);
			$this->excel->getActiveSheet()->getRowDimension('46')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B47', "Jarak Sekolah Sejenis");
			$this->excel->getActiveSheet()->setCellValue('C47', $dt_sekolah->jarak_school." km");
			$this->excel->getActiveSheet()->getRowDimension('48')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A49:B49');
			$this->excel->getActiveSheet()->setCellValue('A49', "Yayasan");			
			$this->excel->getActiveSheet()->getRowDimension('50')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B51', "Nama Yayasan");
			$this->excel->getActiveSheet()->setCellValue('C51', $dt_sekolah->nama_y);
			$this->excel->getActiveSheet()->getRowDimension('52')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B53', "Alamat Yayasan");
			$this->excel->getActiveSheet()->setCellValue('C53', $dt_sekolah->alamat_y);
			$this->excel->getActiveSheet()->getRowDimension('54')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B55', "Desa Yayasan");
			$this->excel->getActiveSheet()->setCellValue('C55', $dt_sekolah->desa_y);
			$this->excel->getActiveSheet()->getRowDimension('56')->setRowHeight(4);
			$detilsy = $this->mlaporan->getDetailSekali($dt_sekolah->id_kecamatan_y);
			$this->excel->getActiveSheet()->setCellValue('B57', "Kecamatan");
			$this->excel->getActiveSheet()->setCellValue('C57', $detilsy['kecamatan']);
			$this->excel->getActiveSheet()->getRowDimension('58')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B59', "Kabupaten");
			$this->excel->getActiveSheet()->setCellValue('C59', $detilsy['kabupaten']);
			$this->excel->getActiveSheet()->getRowDimension('60')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B61', "Provinsi");
			$this->excel->getActiveSheet()->setCellValue('C61', $detilsy['propinsi']);
			$this->excel->getActiveSheet()->getRowDimension('62')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B63', "No. Telp");
			$this->excel->getActiveSheet()->setCellValue('C63', $dt_sekolah->telp_y);
			$this->excel->getActiveSheet()->getRowDimension('64')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B65', "Akte Yayasan");
			$yayasan = explode("&", $dt_sekolah->akte_y);
			$yayasan = ($dt_sekolah->status_school == 2)?"No ".$yayasan[0]." Tanggal ".$yayasan[1]:"";
			$this->excel->getActiveSheet()->setCellValue('C65', $yayasan);
			$this->excel->getActiveSheet()->getRowDimension('66')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B67', "Kelompok");			
			$kelompok = ($dt_sekolah->status_school == 2)?$this->arey->getKelompokY($dt_sekolah->kelompok_y):"";
			$this->excel->getActiveSheet()->setCellValue('C67', $kelompok);
			$this->excel->getActiveSheet()->getRowDimension('68')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A69:B69');
			$this->excel->getActiveSheet()->setCellValue('A69', "Tahun Berdiri");			
			$this->excel->getActiveSheet()->setCellValue('C69', $dt_sekolah->tahun_diri);
			$this->excel->getActiveSheet()->getStyle('C69')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
			$this->excel->getActiveSheet()->getRowDimension('70')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A71:B71');
			$this->excel->getActiveSheet()->setCellValue('A71', "Tahun Terakhir Renovasi");			
			$this->excel->getActiveSheet()->setCellValue('C71', $dt_sekolah->tahun_renov);
			$this->excel->getActiveSheet()->getStyle('C71')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
			$this->excel->getActiveSheet()->getRowDimension('72')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A73:B73');
			$this->excel->getActiveSheet()->setCellValue('A73', "Akreditasi Sekolah");			
			$this->excel->getActiveSheet()->setCellValue('C73', $this->arey->getAkreditasi($dt_sekolah->akre_school));
			$this->excel->getActiveSheet()->getRowDimension('74')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('A75', "SK Akreditas Sekolah");			
			$akreditasi = explode("&", $dt_sekolah->akte_akre);
			$this->excel->getActiveSheet()->setCellValue('C75', "No ".$akreditasi[0]." Tanggal ".$akreditasi[1]);
			$this->excel->getActiveSheet()->getRowDimension('76')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A77:B77');
			$this->excel->getActiveSheet()->setCellValue('A77', "Status Mutu Sekolah");			
			$this->excel->getActiveSheet()->setCellValue('C77', $this->arey->getStatusMutu($dt_sekolah->status_mutu));
			$this->excel->getActiveSheet()->getRowDimension('78')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A79:B79');
			$this->excel->getActiveSheet()->setCellValue('A79', "Kategori Sekolah(Khusus SMP)");			
			$this->excel->getActiveSheet()->setCellValue('C79', $this->arey->getKetegori($dt_sekolah->kategori_school));
			$this->excel->getActiveSheet()->getRowDimension('80')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A81:B81');
			$this->excel->getActiveSheet()->setCellValue('A81', "Waktu Penyelenggaraan");			
			$this->excel->getActiveSheet()->setCellValue('C81', $this->arey->getWaktu($dt_sekolah->waktu_school));
			$this->excel->getActiveSheet()->getRowDimension('82')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A83:B83');
			$this->excel->getActiveSheet()->setCellValue('A83', "SK Terakhir Status Sekolah");			
			$status = explode("&", $dt_sekolah->sk_status);
			$this->excel->getActiveSheet()->setCellValue('C83', "No ".$status[0]." Tanggal ".$status[1]);
			$this->excel->getActiveSheet()->getRowDimension('84')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B85', "Keterangan");			
			$this->excel->getActiveSheet()->setCellValue('C85', $this->arey->getKetSK($dt_sekolah->ket_sk_status));
			$this->excel->getActiveSheet()->getRowDimension('86')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A87:B87');
			$this->excel->getActiveSheet()->setCellValue('A87', "Sekolah Mengadakan Inklusi");			
			$this->excel->getActiveSheet()->setCellValue('C87', $this->arey->YaTidak($dt_sekolah->inklusi));
			$this->excel->getActiveSheet()->getRowDimension('88')->setRowHeight(4);
			$this->excel->getActiveSheet()->setCellValue('B89', "SK Sekolah Inklusi");			
			$inklusi = explode("&", $dt_sekolah->sk_inklusi);
			$this->excel->getActiveSheet()->setCellValue('C89', 'No '.$inklusi[0]." Tanggal ".$inklusi[1]);
			$this->excel->getActiveSheet()->getRowDimension('90')->setRowHeight(4);
			$this->excel->getActiveSheet()->mergeCells('A91:B91');
			$this->excel->getActiveSheet()->setCellValue('A91', "SK Pendirian Sekolah");			
			$pendirian = explode("&", $dt_sekolah->sk_pendirian);
			$this->excel->getActiveSheet()->setCellValue('C91', 'No '.$pendirian[0]." Tanggal ".$pendirian[1]);
			$this->excel->getActiveSheet()->getRowDimension('92')->setRowHeight(4);		
		}			
		$this->excel->getActiveSheet()->getStyle('A1:C91')->applyFromArray($styleArray);


		//Data guru

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->setTitle("Guru");
		$this->excel->getActiveSheet()->mergeCells('A1:E1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA MAPEL');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->mergeCells('C3:D3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->setCellValue('C4', 'LAKI-LAKI');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->setCellValue('D4', 'PEREMPUAN');
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('E3:E4');
		$this->excel->getActiveSheet()->setCellValue('E3', 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
		$baris = 5;
		$mapel = $this->mlaporan->getMapel($id);		
		$thun = $this->mlaporan->getTaAktif();		
		$no = 1;
		foreach($mapel as $dt_mapel)
		{				
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $this->arey->getJabatan($dt_mapel->id_jabatan,2));
			$laki = $this->mlaporan->getJumMapel($dt_mapel->id_jabatan,$id,'1');
			$perempuan = $this->mlaporan->getJumMapel($dt_mapel->id_jabatan,$id,'2');
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $laki);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $perempuan);
			$total = $laki+$perempuan;
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $total);
			$baris++;
			$no++;
		}		
		
		$baris_bawah = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:E'.$baris_bawah)->applyFromArray($styleArray);

		//Data siswa

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);		
		$this->excel->getActiveSheet()->setTitle("Siswa");
		$this->excel->getActiveSheet()->mergeCells('A1:F1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA SISWA SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KELAS');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->mergeCells('C3:D3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->setCellValue('C4', 'LAKI-LAKI');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->setCellValue('D4', 'PEREMPUAN');
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('E3:E4');
		$this->excel->getActiveSheet()->setCellValue('E3', 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('F3:F4');
		$this->excel->getActiveSheet()->setCellValue('F3', 'DETAIL UMUR');
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$kolom = substr($currentCell, 0,1);
		$cari = array_search($kolom, $huruf);
		$jumProdi = $this->mlaporan->getProdi($id);
		if(count($jumProdi) > 0)
		{			
			$kolAwal = $huruf[$cari+1];			
			$akhir = $cari+count($jumProdi);
			$kolAkhir = $huruf[$akhir];			
			$this->excel->getActiveSheet()->mergeCells($kolAwal.'3:'.$kolAkhir.'3');
			$this->excel->getActiveSheet()->setCellValue($kolAwal.'3', "PROGRAM STUDI");
			$this->excel->getActiveSheet()->getStyle($kolAwal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$o = $cari+1;
			foreach($jumProdi as $dt_jumProdi)
			{
				$kolum = $huruf[$o];
				$kolomsss[] = $kolum;
				$this->excel->getActiveSheet()->setCellValue($kolum.'4', $dt_jumProdi->kode_prodi);
				$this->excel->getActiveSheet()->getColumnDimension($kolum)->setWidth(14);
				$this->excel->getActiveSheet()->getStyle($kolum.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				$o++;
			}
		}		
		$baris = 4;
		$tingkat = $this->mlaporan->getTingkat($id);
		$jenjang = ($tingkat == 1)?6:3;
		$thun = $this->mlaporan->getTaAktif();
		for($i=1;$i<=$jenjang;$i++)
		{
			$brs = $baris+$i;
			$this->excel->getActiveSheet()->setCellValue('A'.$brs, $i);
			$this->excel->getActiveSheet()->getStyle('A'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('B'.$brs, 'Kelas '.$i);
			$thn = $thun['tahun'];			
			$ids = $this->session->userdata('id_school');			
			$jumlah = $this->mlaporan->getJumMurid($ids,$i,$thn);
			$this->excel->getActiveSheet()->setCellValue('C'.$brs, $jumlah['laki']);
			$this->excel->getActiveSheet()->getStyle('C'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('D'.$brs, $jumlah['perempuan']);
			$this->excel->getActiveSheet()->getStyle('D'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$total = $jumlah['perempuan']+$jumlah['laki'];
			$this->excel->getActiveSheet()->setCellValue('E'.$brs, $total);
			$this->excel->getActiveSheet()->getStyle('E'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$detail = $this->mlaporan->getDetailMurid($ids,$i,$thn);
			$this->excel->getActiveSheet()->setCellValue('F'.$brs, $detail);
			$this->excel->getActiveSheet()->getStyle('F'.$brs)->getAlignment()->setWrapText(true);	
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();
			$kolom = substr($currentCell, 0,1);
				$cari = array_search($kolom, $huruf);
				$kolAwal = $huruf[$cari+2];							
				$this->excel->getActiveSheet()->setCellValue("I30", "okelah");
			if(count($jumProdi) > 0)
			{							
				$kolom = substr($currentCell, 0,1);
				$cari = array_search($kolom, $huruf);
				$kolAwal = $huruf[$cari+2];							
				$this->excel->getActiveSheet()->setCellValue("I30", "okelah");
				foreach($jumProdi as $dt_jumProdi)
				{
					$isi_jur = $this->mlaporan->getDetailJurAll($dt_jumProdi->id_prodi,$id,$i,$thn);
					$this->excel->getActiveSheet()->setCellValue($kolAwal.$baris, print_r($kolomsss) );
					$this->excel->getActiveSheet()->getStyle($kolAwal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
					$kolAwal++;
				}
			}	
		}	
		
		$this->excel->getActiveSheet()->getStyle('A3:F10')->applyFromArray($styleArray);
		
		$tahun = $this->mlaporan->getTaAktif();				
		//sheet ketiga
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(3);	

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		
		$this->excel->getActiveSheet()->setTitle("Ruang");		
		$current = 1;
		$this->excel->getActiveSheet()->mergeCells('A1:L1');
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "RUANG SEKOLAH");				
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getFont()->setBold(true);		
		$current = $current + 1;
		$current1 = $current + 1;
		$current2 = $current + 2;
		$this->excel->getActiveSheet()->mergeCells('A'.$current.':A'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "NO");		
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B'.$current.':D'.$current);			
		$this->excel->getActiveSheet()->mergeCells('B'.$current.':B'.$current2);			
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "Jenis Ruang");		
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E'.$current.':J'.$current);
		$this->excel->getActiveSheet()->setCellValue('E'.$current, "Milik");	
		$this->excel->getActiveSheet()->getStyle('E'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E'.$current1.':F'.$current1);	
		$this->excel->getActiveSheet()->setCellValue('E'.$current1, "Baik");	
		$this->excel->getActiveSheet()->getStyle('E'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E'.$current2, "Jumlah");	
		$this->excel->getActiveSheet()->getStyle('E'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$current2, "Luas");	
		$this->excel->getActiveSheet()->getStyle('F'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('G'.$current1.':H'.$current1);	
		$this->excel->getActiveSheet()->setCellValue('G'.$current1, "Rusak Ringan");	
		$this->excel->getActiveSheet()->getStyle('G'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G'.$current2, "Jumlah");	
		$this->excel->getActiveSheet()->getStyle('G'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H'.$current2, "Luas");	
		$this->excel->getActiveSheet()->getStyle('H'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('I'.$current1.':J'.$current1);	
		$this->excel->getActiveSheet()->setCellValue('I'.$current1, "Rusak Ringan");	
		$this->excel->getActiveSheet()->getStyle('I'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I'.$current2, "Jumlah");	
		$this->excel->getActiveSheet()->getStyle('I'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J'.$current2, "Luas");	
		$this->excel->getActiveSheet()->getStyle('J'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('K'.$current.':L'.$current);	
		$this->excel->getActiveSheet()->setCellValue('K'.$current, "Bukan Milik");	
		$this->excel->getActiveSheet()->getStyle('K'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('K'.$current1.':K'.$current2);	
		$this->excel->getActiveSheet()->setCellValue('K'.$current1, "Jumlah");	
		$this->excel->getActiveSheet()->getStyle('K'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('K'.$current1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('L'.$current1.':L'.$current2);	
		$this->excel->getActiveSheet()->setCellValue('L'.$current1, "Luas");	
		$this->excel->getActiveSheet()->getStyle('L'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('L'.$current1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$current = $current2 + 1;
		$ruang = $this->mlaporan->getRuang($tingkat);		
		$i = 1;
		$currentCell = "E5";
		$indeks = substr($currentCell, 0, 1);
		$cari = array_search($indeks, $huruf);
		$baris = substr($currentCell, 1, 2);		
		foreach($ruang as $dt_ruang)
		{
			$tkt = 1;	
			$this->excel->getActiveSheet()->setCellValue('A'.$current, $i);
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B'.$current.':D'.$current);
			$this->excel->getActiveSheet()->setCellValue('B'.$current, $dt_ruang->nama_fasilitas);
			for($r=$baris-1;$r<$baris+7;$r++)
			{
				$hurup = $huruf[$r];
				$isi = $this->mlaporan->getDetailBangunan($dt_ruang->id_detail_fasilitas,$tahun['tahun'],$id,$tkt);
				$this->excel->getActiveSheet()->setCellValue($hurup.$current, $isi);
				$this->excel->getActiveSheet()->getStyle($hurup.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$cari++;
				$tkt++;				
			}
			$i++;			
			$current++;
		}
		$brs_bawah = $current - 1;
		$this->excel->getActiveSheet()->getStyle('A2:L'.$brs_bawah)->applyFromArray($styleArray);

		$current = $current + 1;				
		$awalKol = $current;
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "NO");		
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B'.$current.':E'.$current);	
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "NAMA BARANG");			
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$current, "JUMLAH");		
		$this->excel->getActiveSheet()->getStyle('F'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$administrasi = $this->mlaporan->getAdministrasi($tingkat);
		$current = $current + 1;
		$i = 1;
		foreach($administrasi as $dt_administrasi)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$current, $i);				
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->mergeCells('B'.$current.':E'.$current);		
			$this->excel->getActiveSheet()->setCellValue('B'.$current, $dt_administrasi->nama_fasilitas);							
			$isi = $this->mlaporan->getDetailBangunan($dt_administrasi->id_detail_fasilitas,$tahun['tahun'],$id,1);			
			$this->excel->getActiveSheet()->setCellValue('F'.$current, $isi);
			$this->excel->getActiveSheet()->getStyle('F'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$current++;
			$i++;
		}

		$brs_bwh = $current - 1;
		$this->excel->getActiveSheet()->getStyle('A'.$awalKol.':F'.$brs_bwh)->applyFromArray($styleArray);

		//sheet kelima
		/*$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(4);
		$this->excel->getActiveSheet()->setTitle("Nilai dan Fasilitas");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);					

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->mergeCells('A1:I1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'NILAI DAN FASILITAS SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A3:A4');		
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');				
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');		
		$this->excel->getActiveSheet()->setCellValue('B3', 'PROGRAM STUDI/PROGRAM KEAHLIAN');		
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');		
		$this->excel->getActiveSheet()->setCellValue('C3', 'KODE PROGRAM STUDI');				
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:F3');		
		$this->excel->getActiveSheet()->setCellValue('D3', 'PESERTA');				
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D4', 'L');	
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->setCellValue('E4', 'P');				
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'L+P');				
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('G3:I3');		
		$this->excel->getActiveSheet()->setCellValue('G3', 'LULUSAN');				
		$this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'L');				
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'P');				
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'L+P');				
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$baris = substr($currentCell, 1,1);
		$brs = $baris+1;
		$prodi = $this->mlaporan->getProdi($id);				
		if(count($prodi) > 0)
		{
			foreach($prodi as $dt_prodi)
			{
				$this->excel->getActiveSheet()->setCellValue('A'.$brs, '1');
				$this->excel->getActiveSheet()->getStyle('A'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$brs, $dt_prodi->nama_prodi);
				$this->excel->getActiveSheet()->getStyle('B'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('C'.$brs, $dt_prodi->kode_prodi);
				$this->excel->getActiveSheet()->getStyle('C'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$brs++;
			}
		}
		else
		{
			$non_prodi = $this->mlaporan->getLapJumNonProdi($tahun['tahun'],$id);
			$peserta_l = (isset($non_prodi->peserta_l))?$non_prodi->peserta_l:0;
			$peserta_p = (isset($non_prodi->peserta_p))?$non_prodi->peserta_p:0;
			$jum_pes = $peserta_l+$peserta_p;
			$lulus_l = (isset($non_prodi->lulus_l))?$non_prodi->lulus_l:0;
			$lulus_p = (isset($non_prodi->lulus_p))?$non_prodi->lulus_p:0;
			$jum_lus = $lulus_l+$lulus_p;

			$this->excel->getActiveSheet()->setCellValue('A'.$brs, '1');
			$this->excel->getActiveSheet()->getStyle('A'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$brs, 'Kelas VI');
			$this->excel->getActiveSheet()->getStyle('B'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('C'.$brs, 'VI');
			$this->excel->getActiveSheet()->getStyle('C'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D'.$brs, $peserta_l);
			$this->excel->getActiveSheet()->getStyle('D'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$brs, $peserta_p);
			$this->excel->getActiveSheet()->getStyle('E'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$brs, $jum_pes);
			$this->excel->getActiveSheet()->getStyle('F'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$brs, $lulus_l);
			$this->excel->getActiveSheet()->getStyle('G'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$brs, $lulus_p);
			$this->excel->getActiveSheet()->getStyle('H'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$brs, $jum_lus);
			$this->excel->getActiveSheet()->getStyle('I'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();
			$kolom = substr($currentCell, 1,1);
			$current = $kolom + 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$current.':C'.$current);
			$this->excel->getActiveSheet()->setCellValue('A'.$current, 'Jumlah');
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			$this->excel->getActiveSheet()->setCellValue('D'.$current, $peserta_l);
			$this->excel->getActiveSheet()->getStyle('D'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$current, $peserta_p);
			$this->excel->getActiveSheet()->getStyle('E'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$current, $jum_pes);
			$this->excel->getActiveSheet()->getStyle('F'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$current, $lulus_l);
			$this->excel->getActiveSheet()->getStyle('G'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$current, $lulus_p);
			$this->excel->getActiveSheet()->getStyle('H'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$current, $jum_lus);
			$this->excel->getActiveSheet()->getStyle('I'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$this->excel->getActiveSheet()->getStyle('A3:I'.$current)->applyFromArray($styleArray);

		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$kolom = substr($currentCell, 1,1);
		$current = $kolom + 2;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, 'Nilai Ujian Nasionale Tiap Mata Pelajaran Tahun Pelajaran Sebelumnya');
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setWrapText(true);	
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getFont()->setBold(true);	
		$current = $current+1;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, $this->arey->getJenjang($tingkat));		
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getFont()->setBold(true);	
		$current = $current+1;
		$kolawals = $current;
		$this->excel->getActiveSheet()->setCellValue('A'.$current, 'NO');		
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('B'.$current, 'Mata Pelajaran');		
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C'.$current, 'Nilai Rata-Rata');		
		$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$current = $current+1;
		$mapel = $this->mlaporan->getMapelUN($tingkat);
		$no = 1;
		foreach($mapel as $dt_mapel)
		{	
			$this->excel->getActiveSheet()->setCellValue('A'.$current, $no);		
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$current, $this->arey->getJabatan($dt_mapel->nama_mapel,1));		
			$nilai_mapel = $this->mlaporan->getNilaiMapel($dt_mapel->id_detail_mapel,$id,$tahun['tahun']);
			$this->excel->getActiveSheet()->setCellValue('C'.$current, $nilai_mapel);		
			$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$current++;
			$no++;
		}		

		$kolbawahs = $current - 1;
		$this->excel->getActiveSheet()->getStyle('A'.$kolawals.':C'.$kolbawahs)->applyFromArray($styleArray);


		$current = $current + 1;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "FASILITAS");
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getFont()->setBold(true);				
		$current = $current + 1;
		$tanah = $this->mlaporan->getTanah($id,$tahun['tahun']);
		$tanah = (isset($tanah->luas_tanah))?$tanah->luas_tanah:0;
		$pagar = (isset($tanah->pagar_tanah))?$tanah->pagar_tanah:0;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "Keliling tanah seluruhnya ".$tanah.", yang sudah dipagar permanen(termasuk pagar hidup) ".$pagar);
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setWrapText(true);
		$current+=2;
		$awalbagun = $current;
		$currents = $current+1;	
		$this->excel->getActiveSheet()->mergeCells('A'.$current.':B'.$current);		
		$this->excel->getActiveSheet()->mergeCells('A'.$current.':A'.$currents);		
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "Status Pemilikan");
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C'.$current.':C'.$currents);		
		$this->excel->getActiveSheet()->setCellValue('C'.$current, "Luas Tanah");
		$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$penggunaan = $this->mlaporan->getPenggunaan($tingkat);		
		if(count($penggunaan) > 1)
		{
			$cari = array_search("D", $huruf);
			$akhir = $cari+count($penggunaan)-1;
			$hurup = $huruf[$akhir];
			$this->excel->getActiveSheet()->mergeCells('D'.$current.':'.$hurup.$current);		
		}		
		$this->excel->getActiveSheet()->setCellValue('D'.$current, "Penggunaan".$cari);
		$this->excel->getActiveSheet()->getStyle('D'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D'.$currents, "Bangunan");
		$this->excel->getActiveSheet()->getStyle('D'.$currents)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$indeks = substr($currentCell, 0, 1);
		$cari = array_search($indeks, $huruf);
		foreach($penggunaan as $dt_penggunaan)
		{									
			$hurup = $huruf[$cari];
			$this->excel->getActiveSheet()->setCellValue($hurup.$currents, $dt_penggunaan->nama_fasilitas);
			$this->excel->getActiveSheet()->getStyle($hurup.$currents)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$cari++;
		}
		$current = $currents+1;
		$currents = $current+1;
		$this->excel->getActiveSheet()->mergeCells('A'.$current.':A'.$currents);		
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "Milik");
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "Sertifikat");
		$this->excel->getActiveSheet()->setCellValue('B'.$currents, "Belum Sertifikat");
		$current = $currents+1;
		$this->excel->getActiveSheet()->mergeCells('A'.$current.':B'.$current);		
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "Bukan Milik");
		$currentCell = "D19";
		$indeks = substr($currentCell, 0, 1);
		$cari = array_search($indeks, $huruf);
		$baris = substr($currentCell, 1, 2);		
		foreach($penggunaan as $dt_penggunaan)
		{						
			$tkt = 1;	
			for($r=$baris;$r<=$baris+2;$r++)
			{
				$hurup = $huruf[$cari];
				$isi = $this->mlaporan->getDetailBangunan($dt_penggunaan->id_detail_fasilitas,$tahun['tahun'],$id,$tkt);
				$this->excel->getActiveSheet()->setCellValue($hurup.$r, $isi);
				$this->excel->getActiveSheet()->getStyle($hurup.$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$tkt++;
			}			
			$cari++;
		}

		$barias = $r - 1;
		$this->excel->getActiveSheet()->getStyle('A'.$awalbagun.':'.$hurup.$barias)->applyFromArray($styleArray);

		$current = $current+2;
		$barmapel = $current;
		$current1 = $current + 1;
		$current2 = $current + 2;
		$this->excel->getActiveSheet()->mergeCells('A'.$current.':A'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('A'.$current, "NO");
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B'.$current.':B'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "Mata Pelajaran");
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C'.$current.':M'.$current);		
		$this->excel->getActiveSheet()->setCellValue('C'.$current, "Buku");		
		$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C'.$current1.':E'.$current1);		
		$this->excel->getActiveSheet()->setCellValue('C'.$current1, "Pegangan Guru");
		$this->excel->getActiveSheet()->getStyle('C'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('F'.$current1.':I'.$current1);	
		$this->excel->getActiveSheet()->setCellValue('F'.$current1, "Teks Siswa");	
		$this->excel->getActiveSheet()->getStyle('F'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J'.$current1.':M'.$current1);	
		$this->excel->getActiveSheet()->setCellValue('J'.$current1, "Penunjang");	
		$this->excel->getActiveSheet()->getStyle('J'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C'.$current2, "Jumlah Judul");
		$this->excel->getActiveSheet()->getStyle('C'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D'.$current2.':E'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('D'.$current2, "Jumlah Eks");
		$this->excel->getActiveSheet()->getStyle('D'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('F'.$current2.':G'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('F'.$current2, "Jumlah Judul");
		$this->excel->getActiveSheet()->getStyle('F'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('H'.$current2.':I'.$current2);
		$this->excel->getActiveSheet()->setCellValue('H'.$current2, "Jumlah Eks");		
		$this->excel->getActiveSheet()->getStyle('H'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J'.$current2.':K'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('J'.$current2, "Jumlah Judul");
		$this->excel->getActiveSheet()->getStyle('J'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('L'.$current2.':M'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('L'.$current2, "Jumlah Eks");
		$this->excel->getActiveSheet()->getStyle('L'.$current2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N'.$current.':S'.$current);				
		$this->excel->getActiveSheet()->setCellValue('N'.$current, "Alat Pendidikan");				
		$this->excel->getActiveSheet()->getStyle('N'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N'.$current1.':O'.$current1);				
		$this->excel->getActiveSheet()->mergeCells('N'.$current1.':N'.$current2);
		$this->excel->getActiveSheet()->setCellValue('N'.$current1, "% peraga terhadap kebutuhan standard");				
		$this->excel->getActiveSheet()->getStyle('N'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('P'.$current1.':Q'.$current1);		
		$this->excel->getActiveSheet()->mergeCells('P'.$current1.':P'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('P'.$current1, "Praktik(paket)");				
		$this->excel->getActiveSheet()->getStyle('P'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R'.$current1.':S'.$current1);		
		$this->excel->getActiveSheet()->mergeCells('R'.$current1.':R'.$current2);		
		$this->excel->getActiveSheet()->setCellValue('R'.$current1, "Multimedia Base Content");				
		$this->excel->getActiveSheet()->getStyle('R'.$current1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$current = $current2 + 1;
		$buku = $this->mlaporan->getBuku($tingkat);		
		$i = 1;
		$currentCell = "C26";
		$indeks = substr($currentCell, 0, 1);
		$cari = array_search($indeks, $huruf);
		$baris = substr($currentCell, 1, 2);		
		foreach($buku as $dt_buku)
		{
			$tkt = 1;	
			$this->excel->getActiveSheet()->setCellValue('A'.$current, $i);
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$current, $dt_buku->nama_fasilitas);
			for($r=$baris;$r<=$baris+8;$r++)
			{
				$hurup = $huruf[$cari];
				$isi = $this->mlaporan->getDetailBangunan($dt_buku->id_detail_fasilitas,$tahun['tahun'],$id,$tkt);
				$this->excel->getActiveSheet()->setCellValue($hurup.$baris, $isi);
				$this->excel->getActiveSheet()->getStyle($hurup.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				if($hurup == 'C')
				{
					$cari++;
				}
				else
				{
					$cari++;
					$kedua = $huruf[$cari];
					$this->excel->getActiveSheet()->mergeCells($hurup.$baris.':'.$kedua.$baris);		
					$cari++;
				}				
				$tkt++;				
			}						
			$i++;
			$baris++;
		}		

		$brs_bawah = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A'.$barmapel.':'.$kedua.$brs_bawah)->applyFromArray($styleArray);*/

		$filename='Laporan Sekolah '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}	

	function cetak_blk($id)
	{
		$tingkat = $this->mlaporan->getTingkat($id);
		$tahun = $this->mlaporan->getTaAktif();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');

		//sheet pertama

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);				
		$this->excel->getActiveSheet()->mergeCells('A1:C1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$sekolah = $this->mlaporan->getDetailSchool($id);
		foreach($sekolah as $dt_sekolah)
		{
			$this->excel->getActiveSheet()->setCellValue('B3', "Nama Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C3', $dt_sekolah->nama_school);
			$this->excel->getActiveSheet()->setCellValue('B5', "Status Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C5', $this->arey->getStatus($dt_sekolah->status_school));
			$this->excel->getActiveSheet()->setCellValue('B7', "Jenjang Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C7', $this->arey->getJenjang($dt_sekolah->jenjang_school));
			$this->excel->getActiveSheet()->setCellValue('B9', "NSS Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C9', $dt_sekolah->nss_school);
			$this->excel->getActiveSheet()->setCellValue('B11', "NPSN Sekolah");
			$this->excel->getActiveSheet()->setCellValue('C11', $dt_sekolah->npsn_school);
		}	
		//sheet kedua

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);					
		$this->excel->getActiveSheet()->mergeCells('A3:A4');		
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');				
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');		
		$this->excel->getActiveSheet()->setCellValue('B3', 'PROGRAM STUDI/PROGRAM KEAHLIAN');		
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');		
		$this->excel->getActiveSheet()->setCellValue('C3', 'KODE PROGRAM STUDI');				
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:F3');		
		$this->excel->getActiveSheet()->setCellValue('D3', 'PESERTA');				
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D4', 'L');	
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->setCellValue('E4', 'P');				
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'L+P');				
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('G3:I3');		
		$this->excel->getActiveSheet()->setCellValue('G3', 'LULUSAN');				
		$this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'L');				
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'P');				
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'L+P');				
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$baris = substr($currentCell, 1,1);
		$brs = $baris+1;
		$prodi = $this->mlaporan->getProdi($id);				
		if(count($prodi) > 0)
		{
			foreach($prodi as $dt_prodi)
			{
				$this->excel->getActiveSheet()->setCellValue('A'.$brs, '1');
				$this->excel->getActiveSheet()->getStyle('A'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('B'.$brs, $dt_prodi->nama_prodi);
				$this->excel->getActiveSheet()->getStyle('B'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('C'.$brs, $dt_prodi->kode_prodi);
				$this->excel->getActiveSheet()->getStyle('C'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$brs++;
			}
		}
		else
		{
			$non_prodi = $this->mlaporan->getLapJumNonProdi($tahun['tahun'],$id);
			$peserta_l = (isset($non_prodi->peserta_l))?$non_prodi->peserta_l:0;
			$peserta_p = (isset($non_prodi->peserta_p))?$non_prodi->peserta_p:0;
			$jum_pes = $peserta_l+$peserta_p;
			$lulus_l = (isset($non_prodi->lulus_l))?$non_prodi->lulus_l:0;
			$lulus_p = (isset($non_prodi->lulus_p))?$non_prodi->lulus_p:0;
			$jum_lus = $lulus_l+$lulus_p;

			$this->excel->getActiveSheet()->setCellValue('A'.$brs, '1');
			$this->excel->getActiveSheet()->getStyle('A'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$brs, 'Kelas VI');
			$this->excel->getActiveSheet()->getStyle('B'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('C'.$brs, 'VI');
			$this->excel->getActiveSheet()->getStyle('C'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D'.$brs, $peserta_l);
			$this->excel->getActiveSheet()->getStyle('D'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$brs, $peserta_p);
			$this->excel->getActiveSheet()->getStyle('E'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$brs, $jum_pes);
			$this->excel->getActiveSheet()->getStyle('F'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$brs, $lulus_l);
			$this->excel->getActiveSheet()->getStyle('G'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$brs, $lulus_p);
			$this->excel->getActiveSheet()->getStyle('H'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$brs, $jum_lus);
			$this->excel->getActiveSheet()->getStyle('I'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();
			$kolom = substr($currentCell, 1,1);
			$current = $kolom + 1;
			$this->excel->getActiveSheet()->mergeCells('A'.$current.':C'.$current);
			$this->excel->getActiveSheet()->setCellValue('A'.$current, 'Jumlah');
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			$this->excel->getActiveSheet()->setCellValue('D'.$current, $peserta_l);
			$this->excel->getActiveSheet()->getStyle('D'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$current, $peserta_p);
			$this->excel->getActiveSheet()->getStyle('E'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$current, $jum_pes);
			$this->excel->getActiveSheet()->getStyle('F'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$current, $lulus_l);
			$this->excel->getActiveSheet()->getStyle('G'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$current, $lulus_p);
			$this->excel->getActiveSheet()->getStyle('H'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$current, $jum_lus);
			$this->excel->getActiveSheet()->getStyle('I'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$kolom = substr($currentCell, 1,1);
		$current = $kolom + 2;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, 'Nilai Ujian Nasionale Tiap Mata Pelajaran Tahun Pelajaran Sebelumnya');
		$current = $current+1;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, $this->arey->getJenjang($tingkat));		
		$current = $current+1;
		$this->excel->getActiveSheet()->setCellValue('A'.$current, 'NO');		
		$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('B'.$current, 'Mata Pelajaran');		
		$this->excel->getActiveSheet()->getStyle('B'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C'.$current, 'Nilai Rata-Rata');		
		$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$current = $current+1;
		$mapel = $this->mlaporan->getMapelUN($tingkat);
		$no = 1;
		foreach($mapel as $dt_mapel)
		{	
			$this->excel->getActiveSheet()->setCellValue('A'.$current, $no);		
			$this->excel->getActiveSheet()->getStyle('A'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$current, $this->arey->getJabatan($dt_mapel->nama_mapel,1));		
			$nilai_mapel = $this->mlaporan->getNilaiMapel($dt_mapel->id_detail_mapel,$id,$tahun['tahun']);
			$this->excel->getActiveSheet()->setCellValue('C'.$current, $nilai_mapel);		
			$this->excel->getActiveSheet()->getStyle('C'.$current)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$current++;
			$no++;
		}		
		$current = $current + 1;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "FASILITAS");
		$current = $current + 1;
		$tanah = $this->mlaporan->getTanah($id,$tahun['tahun']);
		$tanah = (isset($tanah->luas_tanah))?$tanah->luas_tanah:0;
		$pagar = (isset($tanah->pagar_tanah))?$tanah->pagar_tanah:0;
		$this->excel->getActiveSheet()->setCellValue('B'.$current, "Keliling tanah seluruhnya ".$tanah.", yang sudah dipagar permanen(termasuk pagar hidup) ".$pagar);

				

		//Data siswa

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);		
		$this->excel->getActiveSheet()->setTitle("Siswa");
		$this->excel->getActiveSheet()->mergeCells('A1:E1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA SISWA SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KELAS');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->mergeCells('C3:D3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->setCellValue('C4', 'LAKI-LAKI');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->setCellValue('D4', 'PEREMPUAN');
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('E3:E4');
		$this->excel->getActiveSheet()->setCellValue('E3', 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$this->excel->getActiveSheet()->mergeCells('F3:F4');
		$this->excel->getActiveSheet()->setCellValue('F3', 'DETAIL UMUR');
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$currentCell = $this->excel->getActiveSheet()->getActiveCell();
		$kolom = substr($currentCell, 0,1);
		$cari = array_search($kolom, $huruf);
		$jumProdi = $this->mlaporan->getProdi($id);
		if(count($jumProdi) > 0)
		{			
			$kolAwal = $huruf[$cari+1];			
			$akhir = $cari+count($jumProdi);
			$kolAkhir = $huruf[$akhir];			
			$this->excel->getActiveSheet()->mergeCells($kolAwal.'3:'.$kolAkhir.'3');
			$this->excel->getActiveSheet()->setCellValue($kolAwal.'3', "PROGRAM STUDI");
			$this->excel->getActiveSheet()->getStyle($kolAwal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$o = $cari+1;
			foreach($jumProdi as $dt_jumProdi)
			{
				$kolum = $huruf[$o];
				$this->excel->getActiveSheet()->setCellValue($kolum.'4', $dt_jumProdi->kode_prodi);
				$this->excel->getActiveSheet()->getColumnDimension($kolum)->setWidth(14);
				$this->excel->getActiveSheet()->getStyle($kolum.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				$o++;
			}
		}		
		$baris = 4;		
		$jenjang = ($tingkat == 1)?6:3;
		$thun = $this->mlaporan->getTaAktif();
		for($i=1;$i<=$jenjang;$i++)
		{
			$brs = $baris+$i;
			$this->excel->getActiveSheet()->setCellValue('A'.$brs, $i);
			$this->excel->getActiveSheet()->getStyle('A'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('B'.$brs, 'Kelas '.$i);
			$thn = $thun['tahun'];			
			$ids = $this->session->userdata('id_school');			
			$jumlah = $this->mlaporan->getJumMurid($ids,$i,$thn);
			$this->excel->getActiveSheet()->setCellValue('C'.$brs, $jumlah['laki']);
			$this->excel->getActiveSheet()->getStyle('C'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('D'.$brs, $jumlah['perempuan']);
			$this->excel->getActiveSheet()->getStyle('D'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$total = $jumlah['perempuan']+$jumlah['laki'];
			$this->excel->getActiveSheet()->setCellValue('E'.$brs, $total);
			$this->excel->getActiveSheet()->getStyle('E'.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
			$detail = $this->mlaporan->getDetailMurid($ids,$i,$thn);
			$this->excel->getActiveSheet()->setCellValue('F'.$brs, $detail);
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();
			if(count($jumProdi) > 0)
			{							
				$kolom = substr($currentCell, 0,1);
				$cari = array_search($kolom, $huruf);
				$kolAwal = $huruf[$cari+2];							
				foreach($jumProdi as $dt_jumProdi)
				{
					$isi_jur = $this->mlaporan->getDetailJur($dt_jumProdi->id_prodi,$id,$i,$thn);
					$this->excel->getActiveSheet()->setCellValue($kolAwal.$brs, $isi_jur );
					$this->excel->getActiveSheet()->getStyle($kolAwal.$brs)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
					$kolAwal++;
				}
			}	
		}		


		$filename='BLK '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_rk1()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP');
		$abjad = array('I','II','III','IV','V');
		$jenjang = $this->input->post('jenjang',TRUE);

		//sheet pertama
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->setTitle("Profil Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:D4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'JUMLAH SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E3:I3');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E4', 'A');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'B');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'C');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J3:M3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N3:Q3');
		$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
		$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
		$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
		$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R3:R4');
		$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S3:U3');
		$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
		$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S4', '1994');
		$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T4', '2004');
		$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
		$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
		$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->mergeCells('A1:V1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH SE KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:D4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'JUMLAH SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E3:I3');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E4', 'A');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'B');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'C');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J3:M3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N3:Q3');
		$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
		$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
		$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
		$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R3:R4');
		$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S3:V3');
		$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
		$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S4', '1994');
		$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T4', '2004');
		$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
		$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
		$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris = 5;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);			
			//$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_kecamatan->kode_kecamatan);						
			$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$jumSek = $this->mlaporan->getJumSekolah($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumSek);	
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$akred = $this->mlaporan->getJumAkre($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $akred[0]);	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $akred[1]);	
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $akred[2]);	
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $akred[3]);	
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(E".$baris.":H".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$waktu = $this->mlaporan->getJumWaktu($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $waktu[0]);	
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, $waktu[1]);	
			$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, $waktu[2]);				
			$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, "=SUM(J".$baris.":L".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$gugus = $this->mlaporan->getJumGugus($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, $gugus[0]);	
			$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O'.$baris, $gugus[1]);	
			$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P'.$baris, $gugus[2]);				
			$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q'.$baris, "=SUM(N".$baris.":P".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$mbs = $this->mlaporan->getJumMbs($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('R'.$baris, $mbs);	
			$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$kur = $this->mlaporan->getJumKur($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('S'.$baris, $kur[0]);	
			$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T'.$baris, $kur[1]);	
			$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U'.$baris, $kur[2]);							
			$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V'.$baris, $kur[3]);
			$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$no++;
			$baris++;
		}
		$terakhir = $baris - 1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, '=SUM(E5:E'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, '=SUM(F5:F'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G'.$baris, '=SUM(G5:G'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H'.$baris, '=SUM(H5:H'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I'.$baris, '=SUM(I5:I'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J'.$baris, '=SUM(J5:J'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K'.$baris, '=SUM(K5:K'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L'.$baris, '=SUM(L5:L'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M'.$baris, '=SUM(M5:M'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N'.$baris, '=SUM(N5:N'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O'.$baris, '=SUM(O5:O'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P'.$baris, '=SUM(P5:P'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q'.$baris, '=SUM(Q5:Q'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('R'.$baris, '=SUM(R5:R'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S'.$baris, '=SUM(S5:S'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T'.$baris, '=SUM(T5:T'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U'.$baris, '=SUM(U5:U'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V'.$baris, '=SUM(V5:V'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$brs_bwh = $baris;
		$this->excel->getActiveSheet()->getStyle('A3:V'.$brs_bwh)->applyFromArray($styleArray);


		//sheet kedua
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$umur = $this->mlaporan->getDetailUmur($jenjang);
		$tingkat = ($jenjang == 1)?6:3;

		$this->excel->getActiveSheet()->setTitle("Profil Siswa Sekolah");		

		$kolomsss = 1+(count($umur)*2);
		$kolummm = $huruf[$kolomsss];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
			
		if(count($umur) > 0)
		{
			$current = $this->excel->getActiveSheet()->getActiveCell();
			$current = substr($current, 0,1);
			$cari = array_search($current, $huruf);
			$nkolom = $cari+1;
			$awal = $huruf[$nkolom];			
			$akhir = $huruf[$nkolom+(count($umur)*2)-1];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN UMUR DAN JENIS KELAMIN");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			for($t=0;$t<count($umur);$t++)
			{			
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $umur[$t]['batas']);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($awal.'5', 'L');
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', 'P');
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom += 2;
			}			
		}							

		$baris = 6;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);
			
			if(count($umur) > 0)
			{
				$current = $this->excel->getActiveSheet()->getActiveCell();
				$current = substr($current, 0,1);
				$cari = array_search($current, $huruf);
				$nkolom = $cari+2;							
				for($t=0;$t<count($umur);$t++)
				{			
					$detailUmur = $this->mlaporan->getDetailUmurTotal($umur[$t]['id_detail_umur'],$dt_kecamatan->id_kecamatan);

					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailUmur['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailUmur['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom += 2;
				}				
			}
			else
			{
				$akhir = 4;
			}

			$no++;
			$baris++;
		}		

		$brs_bwh = $baris - 1;
		if($jenjang == 1)
		{
			$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
		}
		elseif($jenjang == 2)
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}		
		else
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek+1];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}

		//sheet ketiga
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

		$this->excel->getActiveSheet()->setTitle("Profil Tingkat Sekolah");

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$tingkat = ($jenjang == 1)?6:3;
		$kolomsss = 1+($tingkat*2);
		$kolummm = $huruf[$kolomsss];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG(II)');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		

		$nkolom = 2;
		$awal = $huruf[$nkolom];			
		$akr = $nkolom+($tingkat*2)-1;
		$akhir = $huruf[$akr];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN TINGKAT DAN JENIS KELAMIN");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		for($t=1;$t<=$tingkat;$t++)
		{			
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];			
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', "Tk ".$t);
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$nkolom += 2;
		}

		$baris = 6;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);
						
			if($tingkat > 0)
			{
				$nkolom = 2;				
				for($w=1;$w<=$tingkat;$w++)
				{			
					$detailTingkat = $this->mlaporan->getDetailTingkat($dt_kecamatan->id_kecamatan,$tingkat);

					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailTingkat[$w]['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailTingkat[$w]['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom += 2;
				}
			}

			$no++;
			$baris++;
		}		

		$brs_bwh = $baris - 1;
		if($jenjang == 1)
		{
			$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
		}
		elseif($jenjang == 2)
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}		
		else
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}

		//sheet keempat
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(3);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);						
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);						

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA STATUS SEKOLAH SE KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setTitle("Status Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:E3');
		$this->excel->getActiveSheet()->setCellValue('D3', 'STATUS SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->setCellValue('D4', 'SEKOLAH NEGERI');
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->setCellValue('E4', 'SEKOLAH SWASTA');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->mergeCells('F3:F4');
		$this->excel->getActiveSheet()->setCellValue('F3', 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		

		$baris = 5;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);						
			$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$statusSek = $this->mlaporan->getStatusSek($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $statusSek['negeri']);	
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $statusSek['swasta']);
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(D".$baris.":E".$baris.")");
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$no++;
			$baris++;
		}
		$barise = $baris - 1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->setCellValue('D'.$baris, "=SUM(D3:D".$barise.")");	
		$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(E3:E".$barise.")");	
		$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, "=SUM(F3:F".$barise.")");	
		$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$brs_bwh = $baris;
		$this->excel->getActiveSheet()->getStyle('A3:F'.$brs_bwh)->applyFromArray($styleArray);

		//sheet kelima		
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(4);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);						
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);						
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);						
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);						
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);						
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);						

		$jumJenjang = ($jenjang == 1)?6:3;
		$kolJenjang = ($jenjang == 1)?"I":"F";
		$akhirJenjang = ($jenjang == 1)?"J":"G";

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->mergeCells('A1:'.$akhirJenjang.'1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA STATUS SEKOLAH SE KABUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setTitle("Rombel Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:'.$kolJenjang.'3');
		$this->excel->getActiveSheet()->setCellValue('D3', 'JENJANG SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
		$this->excel->getActiveSheet()->mergeCells($akhirJenjang.'3:'.$akhirJenjang.'4');
		$this->excel->getActiveSheet()->setCellValue($akhirJenjang.'3', 'JUMLAH');
		$this->excel->getActiveSheet()->getStyle($akhirJenjang.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle($akhirJenjang.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$klms = 2;
		for($i=1;$i<=$jumJenjang;$i++)
		{
			$hurufe = $huruf[$klms+$i];
			$this->excel->getActiveSheet()->setCellValue($hurufe.'4', "Kelas ".$i);
			$this->excel->getActiveSheet()->getStyle($hurufe.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
		}
		

		$baris = 5;
		$kecamatan = $this->mlaporan->getKecamatan();
		$no = 1;
		$thun = $this->mlaporan->getTaAktif();
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);						
			$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			for($i=1;$i<=$jumJenjang;$i++)
			{
				$hurufe = $huruf[$klms+$i];
				$getJumRombel = $this->mlaporan->getJumRombel($dt_kecamatan->id_kecamatan,$jenjang,$thun['tahun'],$i);
				$this->excel->getActiveSheet()->setCellValue($hurufe.$baris, $getJumRombel);
				$this->excel->getActiveSheet()->getStyle($hurufe.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
			}
			$this->excel->getActiveSheet()->setCellValue($akhirJenjang.$baris, "=SUM(D".$baris.":".$kolJenjang.$baris.")");
			$this->excel->getActiveSheet()->getStyle($akhirJenjang.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$no++;
			$baris++;
		}
		$barise = $baris - 1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		for($i=1;$i<=$jumJenjang;$i++)
		{
			$hurufe = $huruf[$klms+$i];			
			$this->excel->getActiveSheet()->setCellValue($hurufe.$baris, "=SUM(".$hurufe."5:".$hurufe.$barise.")");
			$this->excel->getActiveSheet()->getStyle($hurufe.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
		}		

		$brs_bwh = $baris;
		$this->excel->getActiveSheet()->getStyle('A3:'.$akhirJenjang.$brs_bwh)->applyFromArray($styleArray);


		$filename='RK Dinpendik '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_rk2()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		$abjad = array('I','II','III','IV','V');
		$jenjang = $this->input->post('jenjang',TRUE);
		$kecamatan = $this->mlaporan->getKecamatan();
		$tingkat = ($jenjang == 1)?6:3;

		//sheet pertama
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$ujian = $this->mlaporan->getUjian($jenjang);
		$ruang = $this->mlaporan->getRuangHead($jenjang);		
		$buku = $this->mlaporan->getBukuHead($jenjang);
		$kolls = 7+count($ujian)+5+count($buku);
		$kollomms = $huruf[$kolls];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA SEKOLAH SE KEBUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setTitle("Data Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$this->excel->getActiveSheet()->mergeCells('C3:H3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'UJIAN AKHIR SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C4:E4');
		$this->excel->getActiveSheet()->setCellValue('C4', 'PESERTA');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('F4:H4');
		$this->excel->getActiveSheet()->setCellValue('F4', 'LULUSAN');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C5', 'L');
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D5', 'P');
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E5', 'L+P');
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F5', 'L');
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G5', 'P');
		$this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H5', 'L+P');
		$this->excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$nkolom = 8;
		if(count($ujian) > 0)
		{			
			foreach($ujian as $dt_ujian)
			{
				$kolom = $huruf[$nkolom];
				$this->excel->getActiveSheet()->mergeCells($kolom.'4:'.$kolom.'5');
				$this->excel->getActiveSheet()->setCellValue($kolom.'4', $this->arey->getJabatan($dt_ujian->nama_mapel,1));
				$this->excel->getActiveSheet()->getStyle($kolom.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom++;
			}
		}
		$nkolom = 8;
		$awal = $huruf[$nkolom];
		$akhir = $huruf[$nkolom+count($ujian)-2];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "NILAI UJIAN");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('K3:N3');
		$this->excel->getActiveSheet()->setCellValue('K3', "JUMLAH RUANG KELAS");
		$this->excel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('K4:K5');
		$this->excel->getActiveSheet()->setCellValue('K4', "BAIK");
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('L4:L5');
		$this->excel->getActiveSheet()->setCellValue('L4', "RUSAK RINGAN");
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('M4:M5');
		$this->excel->getActiveSheet()->setCellValue('M4', "RUSAK BERAT");
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N4:N5');
		$this->excel->getActiveSheet()->setCellValue('N4', "SUB JUMLAH");
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('O3:O5');
		$this->excel->getActiveSheet()->setCellValue('O3', "BUKAN HAK MILIK");
		$this->excel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		if(count($ruang) > 0)
		{			
			$nkolom = 15;
			foreach($ruang as $dt_ruang)
			{
				$awal = $huruf[$nkolom];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$awal.'5');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_ruang->nama_fasilitas);
				$nkolom++;
			}			
		}
		$awal = $huruf[$nkolom-count($ruang)];
		$akhir = $huruf[$nkolom-1];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "JUMLAH RUANG");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		
		if(count($buku) > 0)
		{
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();
			$kolom = (strlen($currentCell) > 2)?substr($currentCell, 0,2):substr($currentCell, 0,1);
			$cari = array_search($kolom, $huruf);

			$nkolom = $cari+1+count($ruang);
			$awalb = $huruf[$nkolom-1];
			foreach($buku as $dt_buku)
			{
				$awal = $huruf[$nkolom-1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$awal.'5');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_buku->nama_fasilitas);
				$nkolom++;
			}			

			//$awal = $huruf[$nkolom-count($dt_buku)-1];
			$akhir = $huruf[$nkolom-2];
			$this->excel->getActiveSheet()->mergeCells($awalb.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awalb.'3', "JUMLAH BUKU");
			$this->excel->getActiveSheet()->getStyle($awalb.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}		

		$no = 1;
		$baris = 6;
		foreach($kecamatan as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);				

			$jumUn = $this->mlaporan->getJumUn($dt_kecamatan->id_kecamatan,$tingkat,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $jumUn['peserta_l']);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumUn['peserta_p']);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(C".$baris.":D".$baris.")");
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $jumUn['lulus_l']);
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $jumUn['lulus_p']);
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, "=SUM(F".$baris.":G".$baris.")");
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$nkolom = 8;
			if(count($ujian) > 0)
			{				
				foreach($ujian as $dt_ujian)
				{
					$kolom = $huruf[$nkolom];					
					$rataNilai = $this->mlaporan->getJumNilaiUn($dt_kecamatan->id_kecamatan,$dt_ujian->id_detail_mapel,$jenjang);
					$this->excel->getActiveSheet()->setCellValue($kolom.$baris, $rataNilai);
					$this->excel->getActiveSheet()->getStyle($kolom.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
					$nkolom++;
				}
			}			
			$satu = $nkolom;
			$kelas = $this->mlaporan->getJumKelas($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['baik']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$nkolom = $nkolom+1;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['rusak_ringan']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom = $nkolom+1;
			$dua = $nkolom;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['rusak_berat']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom = $nkolom+1;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, "=SUM(".$huruf[$satu].$baris.":".$huruf[$dua].$baris.")");
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom = $nkolom+1;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['bukan_milik']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$nkolom = $nkolom+1;
			if(count($ruang) > 0)
			{			
				$nkolom = 15;
				foreach($ruang as $dt_ruang)
				{
					$fasilitas = $this->mlaporan->getJumFasilitas($dt_kecamatan->id_kecamatan,$dt_ruang->id_detail_fasilitas,$jenjang);

					$awal = $huruf[$nkolom];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $fasilitas);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom++;
				}			
			}			
			
			if(count($buku) > 0)
			{				
				foreach($buku as $dt_buku)
				{
					$fasilitas = $this->mlaporan->getJumFasilitas($dt_kecamatan->id_kecamatan,$dt_buku->id_detail_fasilitas,$jenjang);

					$awal = $huruf[$nkolom];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $fasilitas);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom++;
				}			
			}

			$no++;
			$baris++;
		}

		//$baris = 5;
		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom-1].$brs_bwh)->applyFromArray($styleArray);

		//sheet kedua
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$guru = $this->mlaporan->getGuru($jenjang);	
		$pendidikan = $this->arey->getPendidikan();	
		$kolls = 8+count($guru)+(count($pendidikan)*2);
		$kollomms = $huruf[$kolls];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU DAN KEPALA SEKOLAH SE KEBUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setTitle("Kepala Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$this->excel->getActiveSheet()->mergeCells('C4:D4');
		$this->excel->getActiveSheet()->setCellValue('C4', 'KEPALA SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue('C5', 'PNS');
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue('D5', 'CPNS');
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		
		$nkolom = 4;				
		foreach($guru as $dt_guru)
		{
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', $this->arey->getJabatan($dt_guru->id_jabatan,1));
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "PNS");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "CPNS");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom += 2;
		}
		$awale = $huruf[2];
		$akhire = $huruf[$nkolom-1];
		$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
		$this->excel->getActiveSheet()->setCellValue($awale.'3', "GURU DAN KEPALA SEKOLAH");
		$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->setCellValue($akhire.'3', 'ok');
		$awal = $huruf[$nkolom];
		$akhir = $huruf[$nkolom+1];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$awal.'4');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "JUMLAH KS DAN GURU");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue($awal.'5', "PNS");
		$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue($akhir.'5', "CPNS");
		$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$nkolom = $nkolom + 2;
		$awale = $huruf[$nkolom];				
		foreach($pendidikan as $dt_pendidikan)
		{	
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_pendidikan);
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom += 2;
		}
		$akhire = $huruf[$nkolom+1];
		$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
		$this->excel->getActiveSheet()->setCellValue($awale.'3', "PENDIDIKAN TERAKHIR KEPALA SEKOLAH");
		$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$awal = $huruf[$nkolom];
		$akhir = $huruf[$nkolom+1];
		$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
		$this->excel->getActiveSheet()->setCellValue($awal.'4', "JUMLAH");
		$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
		$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
		$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$nkolom = $nkolom + 2;		
		$no = 1;
		$baris = 6;		
		foreach($kecamatan as $dt_kecamatan)
		{
			$pns = 0;
			$bpns = 0;
			$klaki = 0;
			$kpr = 0;
			$keplaki = 0;
			$keppr = 0;
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);							

			$kepala = $this->mlaporan->getKepala($dt_kecamatan->id_kecamatan,$jenjang);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $kepala['pns']);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $kepala['bpns']);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$pns = $pns + $kepala['pns'];
			$bpns = $bpns + $kepala['bpns'];

			$nkolom = 4;
			foreach($guru as $dt_guru)
			{
				$guruPel = $this->mlaporan->getGuruPel($dt_kecamatan->id_kecamatan,$jenjang,$dt_guru->id_jabatan);
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];				
				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $guruPel['pns']);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $guruPel['bpns']);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$pns = $pns + $guruPel['pns'];
				$bpns = $bpns + $guruPel['bpns'];				
				$nkolom += 2;
			}			
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pns);
			$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $bpns);
			$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom = $nkolom + 2;			
			foreach($pendidikan as $key => $dt_pendidikan)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];

				$pendidik = $this->mlaporan->getKepalaPendik($dt_kecamatan->id_kecamatan,$jenjang,$key);

				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pendidik['laki']);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $pendidik['pr']);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$klaki = $klaki + $pendidik['laki'];
				$kpr = $kpr + $pendidik['pr'];
				$nkolom += 2;
			}
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];			
			$this->excel->getActiveSheet()->setCellValue($awal.$baris, $klaki);
			$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $kpr);
			$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
			$no++;
			$baris++;
		}
		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom+1].$brs_bwh)->applyFromArray($styleArray);

		//sheet ketiga
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		
		$pendidikan = $this->arey->getPendidikan();	
		$kolls = 3+(count($pendidikan)*2);
		$kollomms = $huruf[$kolls];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA GURU SE KEBUPATEN REMBANG');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setTitle("Guru Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);						
		
		$nkolom = "B";
		$nkolom = $nkolom + 2;
		$awale = $huruf[$nkolom];				
		foreach($pendidikan as $dt_pendidikan)
		{	
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_pendidikan);
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom += 2;
		}
		$akhire = $huruf[$nkolom+1];
		$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
		$this->excel->getActiveSheet()->setCellValue($awale.'3', "PENDIDIKAN TERAKHIR GURU");
		$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$awal = $huruf[$nkolom];
		$akhir = $huruf[$nkolom+1];
		$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
		$this->excel->getActiveSheet()->setCellValue($awal.'4', "JUMLAH");
		$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
		$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
		$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$nkolom = $nkolom + 2;		
		$awale = $huruf[$nkolom];	
		$statuse = $this->arey->getStatusPeg();
		foreach($statuse as $dt_statuse)
		{	
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_statuse);
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$nkolom += 2;
		}
		$akhire = $huruf[$nkolom-1];
		$this->excel->getActiveSheet()->mergeCells($awale.'3:'.$akhire.'3');
		$this->excel->getActiveSheet()->setCellValue($awale.'3', "STATUS GURU");
		$this->excel->getActiveSheet()->getStyle($awale.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$no = 1;
		$baris = 6;			
		foreach($kecamatan as $dt_kecamatan)
		{			
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_kecamatan);			
			
			$nkolom = 2;
			$awale = 2;	
			$klaki = 0;		
			$kpr = 0;
			foreach($pendidikan as $key => $dt_pendidikan)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];

				$pendidik = $this->mlaporan->getGuruPendik($dt_kecamatan->id_kecamatan,$jenjang,$key);

				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $pendidik['laki']);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $pendidik['pr']);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$klaki = $klaki + $pendidik['laki'];
				$kpr = $kpr + $pendidik['pr'];
				$nkolom += 2;
			}
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];			
			$this->excel->getActiveSheet()->setCellValue($awal.$baris, $klaki);
			$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $kpr);
			$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$nkolom = $nkolom + 2;		
			$awale = $huruf[$nkolom];	
			foreach($statuse as $keys => $dt_statuse)
			{	
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$status_peg = $this->mlaporan->getStatuseGuru($dt_kecamatan->id_kecamatan,$jenjang,$keys);
				$this->excel->getActiveSheet()->setCellValue($awal.$baris, $status_peg['laki']);
				$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $status_peg['pr']);
				$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$nkolom += 2;
			}

			$no++;
			$baris++;
		}
		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom-1].$brs_bwh)->applyFromArray($styleArray);


		$filename='RK Dinpendik '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_rk3()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP');
		$abjad = array('I','II','III','IV','V');
		$jenjang = $this->input->post('jenjang',TRUE);
		$camate = $this->input->post('kecamatan',TRUE);
		$namaKec = $this->mlaporan->getNamaKec($camate);

		//sheet pertama
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$this->excel->getActiveSheet()->setTitle("Profil Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:D4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E3:I3');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E4', 'A');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'B');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'C');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J3:M3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N3:Q3');
		$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
		$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
		$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
		$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R3:R4');
		$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S3:U3');
		$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
		$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S4', '1994');
		$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T4', '2004');
		$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
		$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
		$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->mergeCells('A1:V1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SEKOLAH SE KABUPATEN REMBANG KECAMATAN '.$namaKec);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('C3:C4');
		$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D3:D4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'KODE KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E3:I3');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Status Akreditasi Sekolah');
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E4', 'A');
		$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F4', 'B');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G4', 'C');
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H4', 'TT');
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JML');
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J3:M3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'Waktu Penyelanggaraan');
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J4', 'Pagi');
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K4', 'Siang');
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L4', 'Kombinasi');
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M4', 'JML');
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N3:Q3');
		$this->excel->getActiveSheet()->setCellValue('N3', 'Gugus Sekolah');
		$this->excel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N4', 'Inti');
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O4', 'Imbas');
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P4', 'Belum Ikut');
		$this->excel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q4', 'JML');
		$this->excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R3:R4');
		$this->excel->getActiveSheet()->setCellValue('R3', 'Melaksanakan MBS');
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S3:V3');
		$this->excel->getActiveSheet()->setCellValue('S3', 'Kurikulum Yang Dipakai');
		$this->excel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S4', '1994');
		$this->excel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T4', '2004');
		$this->excel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U4', 'KTSP');
		$this->excel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V4', 'K 2013');
		$this->excel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris = 5;		
		$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
		$no = 1;
		foreach($skulKec as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);						
			$this->excel->getActiveSheet()->setCellValueExplicit('C'.$baris,  $dt_kecamatan->nama_kecamatan);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->setCellValueExplicit('D'.$baris,  $dt_kecamatan->kode_kecamatan, PHPExcel_Cell_DataType::TYPE_STRING);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$akred = $this->mlaporan->getJumAkreSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $akred[0]);	
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $akred[1]);	
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $akred[2]);	
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $akred[3]);	
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, "=SUM(E".$baris.":H".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$waktu = $this->mlaporan->getJumWaktuSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $waktu[0]);	
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, $waktu[1]);	
			$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, $waktu[2]);				
			$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, "=SUM(J".$baris.":L".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$gugus = $this->mlaporan->getJumGugusSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, $gugus[0]);	
			$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('O'.$baris, $gugus[1]);	
			$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('P'.$baris, $gugus[2]);				
			$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('Q'.$baris, "=SUM(N".$baris.":P".$baris.")");	
			$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$mbs = $this->mlaporan->getJumMbsSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('R'.$baris, $mbs);	
			$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$kur = $this->mlaporan->getJumKurSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('S'.$baris, $kur[0]);	
			$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('T'.$baris, $kur[1]);	
			$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('U'.$baris, $kur[2]);							
			$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('V'.$baris, $kur[3]);
			$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$no++;
			$baris++;
		}
		$terakhir = $baris - 1;
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
		$this->excel->getActiveSheet()->setCellValue('A'.$baris, 'JUMLAH');
		$this->excel->getActiveSheet()->setCellValue('E'.$baris, '=SUM(E5:E'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F'.$baris, '=SUM(F5:F'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G'.$baris, '=SUM(G5:G'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H'.$baris, '=SUM(H5:H'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('I'.$baris, '=SUM(I5:I'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('J'.$baris, '=SUM(J5:J'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('K'.$baris, '=SUM(K5:K'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L'.$baris, '=SUM(L5:L'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M'.$baris, '=SUM(M5:M'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('N'.$baris, '=SUM(N5:N'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('O'.$baris, '=SUM(O5:O'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P'.$baris, '=SUM(P5:P'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q'.$baris, '=SUM(Q5:Q'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('R'.$baris, '=SUM(R5:R'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S'.$baris, '=SUM(S5:S'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T'.$baris, '=SUM(T5:T'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('U'.$baris, '=SUM(U5:U'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('U'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('V'.$baris, '=SUM(V5:V'.$terakhir.')');
		$this->excel->getActiveSheet()->getStyle('V'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$brs_bwh = $baris;
		$this->excel->getActiveSheet()->getStyle('A3:V'.$brs_bwh)->applyFromArray($styleArray);


		//sheet kedua
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$umur = $this->mlaporan->getDetailUmur($jenjang);
		$tingkat = ($jenjang == 1)?6:3;

		$this->excel->getActiveSheet()->setTitle("Profil Siswa Sekolah");		

		$kolomsss = 1+(count($umur)*2);
		$kolummm = $huruf[$kolomsss];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG KECAMATAN '.$namaKec);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
			
		if(count($umur) > 0)
		{
			$current = $this->excel->getActiveSheet()->getActiveCell();
			$current = substr($current, 0,1);
			$cari = array_search($current, $huruf);
			$nkolom = $cari+1;
			$awal = $huruf[$nkolom];			
			$akhir = $huruf[$nkolom+(count($umur)*2)-1];
			$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN UMUR DAN JENIS KELAMIN");
			$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			for($t=0;$t<count($umur);$t++)
			{			
				$awal = $huruf[$nkolom];
				$akhir = $huruf[$nkolom+1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $umur[$t]['batas']);
				$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($awal.'5', 'L');
				$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($akhir.'5', 'P');
				$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom += 2;
			}			
		}							

		$baris = 6;		
		$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
		$no = 1;
		foreach($skulKec as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);
			
			if(count($umur) > 0)
			{
				$current = $this->excel->getActiveSheet()->getActiveCell();
				$current = substr($current, 0,1);
				$cari = array_search($current, $huruf);
				$nkolom = $cari+2;							
				for($t=0;$t<count($umur);$t++)
				{			
					$detailUmur = $this->mlaporan->getDetailUmurTotalSkul($umur[$t]['id_detail_umur'],$dt_kecamatan->id_kecamatan,$dt_kecamatan->id_school);

					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailUmur['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailUmur['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom += 2;
				}				
			}
			else
			{
				$akhir = 4;
			}

			$no++;
			$baris++;
		}		

		$brs_bwh = $baris - 1;
		if($jenjang == 1)
		{
			$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
		}
		elseif($jenjang == 2)
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}		
		else
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek+1];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}

		//sheet ketiga
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$umur = $this->mlaporan->getDetailUmur($jenjang);
		$tingkat = ($jenjang == 1)?6:3;

		$this->excel->getActiveSheet()->setTitle("Profil Tingkat Sekolah");		

		$kolomsss = 1+($tingkat*2);
		$kolummm = $huruf[$kolomsss];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kolummm.'1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA PROFIL SISWA SEKOLAH SE KABUPATEN REMBANG KECAMATAN(II) '.$namaKec);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
					
		$nkolom = 2;
		$awal = $huruf[$nkolom];			
		$akr = $nkolom+($tingkat*2)-1;
		$akhir = $huruf[$akr];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "SISWA BERDASARKAN TINGKAT DAN JENIS KELAMIN");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		for($t=1;$t<=$tingkat;$t++)
		{			
			$awal = $huruf[$nkolom];
			$akhir = $huruf[$nkolom+1];			
			$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$akhir.'4');
			$this->excel->getActiveSheet()->setCellValue($awal.'4', "Tk ".$t);
			$this->excel->getActiveSheet()->getStyle($awal.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($awal.'5', "L");
			$this->excel->getActiveSheet()->getStyle($awal.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue($akhir.'5', "P");
			$this->excel->getActiveSheet()->getStyle($akhir.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom += 2;
		}

		$baris = 6;		
		$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
		$no = 1;
		foreach($skulKec as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);
						
			if($tingkat > 0)
			{				
				$nkolom = 2;				
				for($w=1;$w<=$tingkat;$w++)
				{			
					$detailTingkat = $this->mlaporan->getDetailTingkatSkul($dt_kecamatan->id_kecamatan,$tingkat,$dt_kecamatan->id_school);

					$awal = $huruf[$nkolom];
					$akhir = $huruf[$nkolom+1];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $detailTingkat[$w]['laki']);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue($akhir.$baris, $detailTingkat[$w]['pr']);
					$this->excel->getActiveSheet()->getStyle($akhir.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom += 2;
				}
			}

			$no++;
			$baris++;
		}		

		$brs_bwh = $baris - 1;
		if($jenjang == 1)
		{
			$this->excel->getActiveSheet()->getStyle('A3:'.$akhir.$brs_bwh)->applyFromArray($styleArray);
		}
		elseif($jenjang == 2)
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}		
		else
		{
			$golek = array_search($akhir, $huruf);
			$kollsss = $huruf[$golek];
			$this->excel->getActiveSheet()->getStyle('A3:'.$kollsss.$brs_bwh)->applyFromArray($styleArray);
		}

		$filename='RK Dinpendik '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function generate_rk4()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		$abjad = array('I','II','III','IV','V');
		$jenjang = $this->input->post('jenjang',TRUE);
		$kecamatan = $this->mlaporan->getKecamatan();
		$tingkat = ($jenjang == 1)?6:3;
		$camate = $this->input->post('kecamatan',TRUE);
		$namaKec = $this->mlaporan->getNamaKec($camate);

		//sheet pertama
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);				
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(14);		
		$this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(14);		

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$ujian = $this->mlaporan->getUjian($jenjang);
		$ruang = $this->mlaporan->getRuangHead($jenjang);		
		$buku = $this->mlaporan->getBukuHead($jenjang);
		$kolls = 7+count($ujian)+5+count($buku);
		$kollomms = $huruf[$kolls];

		$this->excel->getActiveSheet()->mergeCells('A1:'.$kollomms.'1');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DATA SEKOLAH SE KEBUPATEN REMBANG KECAMATAN '.$namaKec);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setTitle("Data Sekolah");		
		$this->excel->getActiveSheet()->mergeCells('A3:A5');
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B3:B5');
		$this->excel->getActiveSheet()->setCellValue('B3', 'KECAMATAN');
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$this->excel->getActiveSheet()->mergeCells('C3:H3');
		$this->excel->getActiveSheet()->setCellValue('C3', 'UJIAN AKHIR SEKOLAH');
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C4:E4');
		$this->excel->getActiveSheet()->setCellValue('C4', 'PESERTA');
		$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('F4:H4');
		$this->excel->getActiveSheet()->setCellValue('F4', 'LULUSAN');
		$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C5', 'L');
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D5', 'P');
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E5', 'L+P');
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F5', 'L');
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G5', 'P');
		$this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('H5', 'L+P');
		$this->excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$nkolom = 8;
		if(count($ujian) > 0)
		{			
			foreach($ujian as $dt_ujian)
			{
				$kolom = $huruf[$nkolom];
				$this->excel->getActiveSheet()->mergeCells($kolom.'4:'.$kolom.'5');
				$this->excel->getActiveSheet()->setCellValue($kolom.'4', $this->arey->getJabatan($dt_ujian->nama_mapel,1));
				$this->excel->getActiveSheet()->getStyle($kolom.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$nkolom++;
			}
		}
		$nkolom = 8;
		$awal = $huruf[$nkolom];
		$akhir = $huruf[$nkolom+count($ujian)-2];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "NILAI UJIAN");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('K3:N3');
		$this->excel->getActiveSheet()->setCellValue('K3', "JUMLAH RUANG KELAS");
		$this->excel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->mergeCells('K4:K5');
		$this->excel->getActiveSheet()->setCellValue('K4', "BAIK");
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('L4:L5');
		$this->excel->getActiveSheet()->setCellValue('L4', "RUSAK RINGAN");
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('M4:M5');
		$this->excel->getActiveSheet()->setCellValue('M4', "RUSAK BERAT");
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N4:N5');
		$this->excel->getActiveSheet()->setCellValue('N4', "SUB JUMLAH");
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('O3:O5');
		$this->excel->getActiveSheet()->setCellValue('O3', "BUKAN HAK MILIK");
		$this->excel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		if(count($ruang) > 0)
		{			
			$nkolom = 15;
			foreach($ruang as $dt_ruang)
			{
				$awal = $huruf[$nkolom];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$awal.'5');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_ruang->nama_fasilitas);
				$nkolom++;
			}			
		}
		$awal = $huruf[$nkolom-count($ruang)];
		$akhir = $huruf[$nkolom-1];
		$this->excel->getActiveSheet()->mergeCells($awal.'3:'.$akhir.'3');
		$this->excel->getActiveSheet()->setCellValue($awal.'3', "JUMLAH RUANG");
		$this->excel->getActiveSheet()->getStyle($awal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		
		if(count($buku) > 0)
		{
			$currentCell = $this->excel->getActiveSheet()->getActiveCell();
			$kolom = (strlen($currentCell) > 2)?substr($currentCell, 0,2):substr($currentCell, 0,1);
			$cari = array_search($kolom, $huruf);

			$nkolom = $cari+1+count($ruang);
			$awalb = $huruf[$nkolom-1];
			foreach($buku as $dt_buku)
			{
				$awal = $huruf[$nkolom-1];
				$this->excel->getActiveSheet()->mergeCells($awal.'4:'.$awal.'5');
				$this->excel->getActiveSheet()->setCellValue($awal.'4', $dt_buku->nama_fasilitas);
				$nkolom++;
			}			

			//$awal = $huruf[$nkolom-count($dt_buku)-1];
			$akhir = $huruf[$nkolom-2];
			$this->excel->getActiveSheet()->mergeCells($awalb.'3:'.$akhir.'3');
			$this->excel->getActiveSheet()->setCellValue($awalb.'3', "JUMLAH BUKU");
			$this->excel->getActiveSheet()->getStyle($awalb.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}		

		$no = 1;
		$baris = 6;
		$skulKec = $this->mlaporan->getSkulKec($camate,$jenjang);
		foreach($skulKec as $dt_kecamatan)
		{
			$total = 0;
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kecamatan->nama_school);				

			$jumUn = $this->mlaporan->getJumUnSkul($dt_kecamatan->id_kecamatan,$tingkat,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $jumUn['peserta_l']);
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $jumUn['peserta_p']);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, "=SUM(C".$baris.":D".$baris.")");
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $jumUn['lulus_l']);
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $jumUn['lulus_p']);
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, "=SUM(F".$baris.":G".$baris.")");
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$nkolom = 8;
			if(count($ujian) > 0)
			{				
				foreach($ujian as $dt_ujian)
				{
					$kolom = $huruf[$nkolom];					
					$rataNilai = $this->mlaporan->getJumNilaiUnSkul($dt_kecamatan->id_kecamatan,$dt_ujian->id_detail_mapel,$jenjang,$dt_kecamatan->id_school);
					$this->excel->getActiveSheet()->setCellValue($kolom.$baris, $rataNilai);
					$this->excel->getActiveSheet()->getStyle($kolom.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
					$nkolom++;
				}
			}			
			$satu = $nkolom;
			$kelas = $this->mlaporan->getJumKelasSkul($dt_kecamatan->id_kecamatan,$jenjang,$dt_kecamatan->id_school);
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['baik']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$nkolom = $nkolom+1;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['rusak_ringan']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom = $nkolom+1;
			$dua = $nkolom;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['rusak_berat']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom = $nkolom+1;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, "=SUM(".$huruf[$satu].$baris.":".$huruf[$dua].$baris.")");
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$nkolom = $nkolom+1;
			$this->excel->getActiveSheet()->setCellValue($huruf[$nkolom].$baris, $kelas['bukan_milik']);
			$this->excel->getActiveSheet()->getStyle($huruf[$nkolom].$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$nkolom = $nkolom+1;
			if(count($ruang) > 0)
			{			
				$nkolom = 15;
				foreach($ruang as $dt_ruang)
				{
					$fasilitas = $this->mlaporan->getJumFasilitasSkul($dt_kecamatan->id_kecamatan,$dt_ruang->id_detail_fasilitas,$jenjang,$dt_kecamatan->id_school);

					$awal = $huruf[$nkolom];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $fasilitas);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom++;
				}			
			}			
			
			if(count($buku) > 0)
			{				
				foreach($buku as $dt_buku)
				{
					$fasilitas = $this->mlaporan->getJumFasilitasSkul($dt_kecamatan->id_kecamatan,$dt_buku->id_detail_fasilitas,$jenjang,$dt_kecamatan->id_school);

					$awal = $huruf[$nkolom];					
					$this->excel->getActiveSheet()->setCellValue($awal.$baris, $fasilitas);
					$this->excel->getActiveSheet()->getStyle($awal.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$nkolom++;
				}			
			}

			$no++;
			$baris++;
		}

		//$baris = 5;
		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:'.$huruf[$nkolom-1].$brs_bwh)->applyFromArray($styleArray);				

		$filename='RK Dinpendik '.$this->arey->getJenjang($jenjang).' Rembang '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}
}