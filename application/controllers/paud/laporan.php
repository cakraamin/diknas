<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

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
			'main'			=> 'paud/laporan',
			'laporan'		=> 'select',
			'skpd'			=> $this->arey->skpd(),
			'tahun'			=> $this->mlaporan->getTahun(),
			'jenjang'		=> $this->arey->getJenjang(),
			'jenis'			=> $this->arey->getJenisLap()
		);

		$this->load->view('paud/template',$data);
	}
	
	function generate()
	{			
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);		
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);		
		$this->excel->getActiveSheet()->setTitle("Tabel 1");
		
		$this->excel->getActiveSheet()->mergeCells('A1:J1');
		$this->excel->getActiveSheet()->setCellValue('A1','TABEL 1. DATA SATUAN PAUD');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');		
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA LEMBAGA');		
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('C3', 'JENIS SATUAN');		
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('D3', 'ALAMAT LENGKAP');		
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('E3', 'NPSN');		
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('F3', 'STATUS');		
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('G3', 'KEPEMILIKAN');		
		$this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('H3', 'NAMA YAYASAN');		
		$this->excel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('I3', 'NAMA KEPALA/PENGELOLA');		
		$this->excel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('J3', 'NOMOR IZIN PENGELOLA');		
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);		

		$baris = 4;
		$kueri = $this->mlaporan->getLapTabel1();
		$no = 1;
		foreach($kueri as $dt_kueri)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kueri->nama_paud);
			$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $this->arey->getJenisPaud($dt_kueri->jenis_paud));
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $dt_kueri->alamat_paud);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setWrapText(true);									
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $dt_kueri->npns_paud);					
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $this->arey->getStatus($dt_kueri->status_paud));
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $this->arey->getPemilikan($dt_kueri->milik_paud));
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $dt_kueri->yayasan_paud);					
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, $dt_kueri->kepala_paud);					
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $dt_kueri->ijin_paud);
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$baris++;
		}

		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:J'.$brs_bwh)->applyFromArray($styleArray);	

		//sheet 2
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);		
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);		
		$this->excel->getActiveSheet()->setTitle("Tabel 2");
		
		$this->excel->getActiveSheet()->mergeCells('A1:J1');
		$this->excel->getActiveSheet()->setCellValue('A1','TABEL 2. DATA INDIVIDUAL PENDIDIK PAUD DAN TENAGA AHLI PER LEMBAGA');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->mergeCells('A3:A4');		
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');		
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('B3:B4');				
		$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA LEMBAGA');		
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);	
		$this->excel->getActiveSheet()->mergeCells('C3:C4');			
		$this->excel->getActiveSheet()->setCellValue('C3', 'NAMA PENDIDIK/TENAGA AHLI');		
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$this->excel->getActiveSheet()->mergeCells('D3:D4');		
		$this->excel->getActiveSheet()->setCellValue('D3', 'JENIS KELAMIN');		
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('E3:E4');		
		$this->excel->getActiveSheet()->setCellValue('E3', 'PELATIHAN PENDIDIKAN PAUD');		
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);	
		$this->excel->getActiveSheet()->mergeCells('F3:F4');		
		$this->excel->getActiveSheet()->setCellValue('F3', 'PENDIDIKAN TERAKHIR');		
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);	
		$this->excel->getActiveSheet()->mergeCells('G3:H3');		
		$this->excel->getActiveSheet()->setCellValue('G3', 'LATAR BELAKANG PENDIDIKAN');		
		$this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('G4', 'KEPENDIDIKAN');		
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->setCellValue('H4', 'NON KEPENDIDIKAN');		
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('I3:I4');		
		$this->excel->getActiveSheet()->setCellValue('I3', 'STATUS PNS/NON PNS');		
		$this->excel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('I3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);			
		$this->excel->getActiveSheet()->mergeCells('J3:J4');		
		$this->excel->getActiveSheet()->setCellValue('J3', 'NUPTK');		
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);		

		$baris = 5;
		$kueri = $this->mlaporan->getLapTabel2();
		$no = 1;
		foreach($kueri as $dt_kueri)
		{
			$pel = $dt_kueri->jarak;
			$pecah = explode("-", $pel);
			$pendik = (isset($pecah[0]))?$pecah[0]:0;
            $pela = (isset($pecah[1]))?$pecah[1]:0;

			$pelatihan = ($pela == 1)?"X":"";
			$pendidikan = ($pendik == 1)?"X":"";
			$nonpendidikan = ($pendik == 1)?"":"X";

			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kueri->nama_paud);			
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_kueri->nama_guru);
			$kelamin = ($dt_kueri->jenis_kel == 1)?"Laki-laki":"Perempuan";			
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $kelamin);
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $pelatihan);
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $this->arey->getPendidikan($dt_kueri->pend_guru));			
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $pendidikan);			
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $nonpendidikan);	
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$status_guru = ($dt_kueri->status_guru == 2 AND $dt_kueri->status_peg == 5)?"NON PNS":"PNS";
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, $status_guru);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $dt_kueri->nuptk_guru);
			$baris++;
		}

		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:J'.$brs_bwh)->applyFromArray($styleArray);	

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);		
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(13);		
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(13);		
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(13);		
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(13);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(13);		
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(13);		
		$this->excel->getActiveSheet()->setTitle("Tabel 3");
		
		$this->excel->getActiveSheet()->mergeCells('A1:J1');
		$this->excel->getActiveSheet()->setCellValue('A1','TABEL 3. DATA SATUAN PAUD');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->mergeCells('A3:A4');		
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO');		
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('B3:B4');		
		$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA LEMBAGA');		
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('C3:C4');		
		$this->excel->getActiveSheet()->setCellValue('C3', 'JENIS SATUAN');		
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('D3:D4');		
		$this->excel->getActiveSheet()->setCellValue('D3', 'ALAMAT LENGKAP');		
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('E3:E4');		
		$this->excel->getActiveSheet()->setCellValue('E3', 'NPSN');		
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);				
		$this->excel->getActiveSheet()->mergeCells('F3:F4');		
		$this->excel->getActiveSheet()->setCellValue('F3', 'NAMA KEPALA/PENGELOLA');		
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);		
		$this->excel->getActiveSheet()->mergeCells('G3:I3');
		$this->excel->getActiveSheet()->setCellValue('G3', 'JUMLAH PENDIDIK');		
		$this->excel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('G4', 'LAKI-LAKI');		
		$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('H4', 'PEREMPUAN');		
		$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('I4', 'JUMLAH');		
		$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('J3:L3');
		$this->excel->getActiveSheet()->setCellValue('J3', 'JUMLAH PENDIDIK');		
		$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('J4', '<=SMA');		
		$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('K4', 'DIPLOMA');		
		$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('K4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('L4', '>=S1');		
		$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('L4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('M3:O3');
		$this->excel->getActiveSheet()->setCellValue('M3', 'JUMLAH PESERTA DIDIK');		
		$this->excel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('M4', 'LAKI-LAKI');		
		$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('M4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('N4', 'PEREMPUAN');		
		$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('N4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('O4', 'JUMLAH');		
		$this->excel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('O4')->getFont()->setBold(true);

		$baris = 5;
		$kueri = $this->mlaporan->getLapTabel1();
		$thun = $this->mlaporan->getTaAktif();
		$no = 1;
		foreach($kueri as $dt_kueri)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_kueri->nama_paud);
			$this->excel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $this->arey->getJenisPaud($dt_kueri->jenis_paud));
			$this->excel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->excel->getActiveSheet()->setCellValue('D'.$baris, $dt_kueri->alamat_paud);
			$this->excel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setWrapText(true);									
			$this->excel->getActiveSheet()->setCellValue('E'.$baris, $dt_kueri->npns_paud);					
			$this->excel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('F'.$baris, $dt_kueri->kepala_paud);					
			$this->excel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			

			$kelamin = $this->mlaporan->getJumKelGuru($dt_kueri->id_pauds);
			$this->excel->getActiveSheet()->setCellValue('G'.$baris, $kelamin['laki']);					
			$this->excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('H'.$baris, $kelamin['perempuan']);					
			$this->excel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('I'.$baris, '=SUM(G'.$baris.':H'.$baris.')');
			$this->excel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			

			$pendidikan = $this->mlaporan->getJumPendikGuru($dt_kueri->id_pauds);
			$this->excel->getActiveSheet()->setCellValue('J'.$baris, $pendidikan['sma']);					
			$this->excel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('K'.$baris, $pendidikan['diploma']);					
			$this->excel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('L'.$baris, $pendidikan['s1']);
			$this->excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			

			$murid = $this->mlaporan->getJumSiswaPaud($dt_kueri->id_pauds,$thun['tahun']);
			$this->excel->getActiveSheet()->setCellValue('M'.$baris, $murid['laki']);					
			$this->excel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('N'.$baris, $murid['perempuan']);					
			$this->excel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			
			$this->excel->getActiveSheet()->setCellValue('O'.$baris, '=SUM(M'.$baris.':N'.$baris.')');
			$this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);			

			$baris++;
		}

		$brs_bwh = $baris - 1;
		$this->excel->getActiveSheet()->getStyle('A3:O'.$brs_bwh)->applyFromArray($styleArray);	

		$filename='Laporan PAUD Rembang '.date("Y-m-d").'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
				             
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save('php://output');
	}	
}