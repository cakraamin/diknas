<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporans extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library(array('arey','excel'));
		$this->load->helper(array('tanggal','terbilang'));
		$this->load->model('mlaporans','',TRUE);

		if($this->session->userdata('user_level') == "")
		{
			redirect('dashboard');
		}
	}

	function index()
	{		
		$status = array(
			'1'		=> 'Negeri',
			'2'		=> 'Swasta',
			'3'		=> 'Negeri dan Swasta'
		);
		
		$data = array(
			'main'			=> 'laporans',
			'laporan'		=> 'select',			
			'tahun'			=> $this->mlaporans->getTahun(),
			'jenjang'		=> $this->arey->getJenjang(),
			'status'		=> $status,
			'link'			=> 'generate',
			'keterangan'	=> 'Laporan RK SD'
		);

		$this->load->view('template',$data);
	}

	public function generate()
	{
		$tahun = $this->input->post('tahun',TRUE);
		$jenjang = $this->input->post('jenjang',TRUE);
		$status = $this->input->post('status',TRUE);
		if($jenjang == '1')
		{
			redirect('laporans/generate_sd/'.$tahun.'/'.$status);
		}
		else
		{			
			redirect('laporans/generate_all/'.$tahun.'/'.$jenjang.'/'.$status);
		}	
	}

	public function generate_sd($tahun,$status)
	{
		$this->load->library('excel');		

		$stat_skul = array(
			'1'		=> '(Negeri)',
			'2'		=> '(Swasta)',
			'3'		=> '(Negeri dan Swasta)'
		);

		$tahune = $this->mlaporans->getTahune($tahun);

		$objPHPExcel = PHPExcel_IOFactory::load('./template/RK-SD.xls');	

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('K4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);

		$kueri = $this->mlaporans->getSdNegeri($status);		
		$row = 12;		
		foreach($kueri as $dt_kueri)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kueri['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kueri['kode']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kueri['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kueri['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kueri['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kueri['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kueri['2']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, "=SUM(E".$row.":H".$row.")");
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kueri['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kueri['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kueri['3']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, "=SUM(J".$row.":L".$row.")");
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kueri['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kueri['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kueri['4']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, "=SUM(N".$row.":P".$row.")");
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kueri['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kueri['6']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kueri['6']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kueri['6']['4']);

			$row++;			
		}		

		//sheet kedua
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()->setCellValue('N4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue('AM4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('Y1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedDuaNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['1']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['1']['8']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['2']['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['2']['5']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['2']['5']['2']);

			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['3']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['3']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['3']['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['3']['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['3']['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['3']['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['3']['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['3']['5']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['3']['5']['2']);

			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['4']['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['4']['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['4']['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['4']['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['4']['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AT'.$row, $dt_kedua['4']['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $dt_kedua['4']['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, $dt_kedua['4']['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AW'.$row, $dt_kedua['4']['5']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, $dt_kedua['4']['5']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, $dt_kedua['4']['6']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, $dt_kedua['4']['6']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('BA'.$row, $dt_kedua['4']['7']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, $dt_kedua['4']['7']['2']);			

			$row++;			
		}		

		//sheet ketiga
		$objPHPExcel->setActiveSheetIndex(2);
		$objPHPExcel->getActiveSheet()->setCellValue('S4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedTigaNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['6']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['2']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['2']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['6']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['2']['6']['pr']);			

			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['3']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['3']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['3']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['3']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['3']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['3']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['3']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['3']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['6']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['3']['6']['pr']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['4']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['4']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['4']['6']);			

			$row++;			
		}			

		//sheet keempat
		$objPHPExcel->setActiveSheetIndex(3);
		$objPHPExcel->getActiveSheet()->setCellValue('U4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedEmpatNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['4']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['5']['dalam']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['5']['luar']);

			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['2']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['9']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['3']['1']['jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['3']['2']['jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['3']['3']['jumlah']);						
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['3']['4']['jumlah']);

			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['4']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['4']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['4']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['4']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['4']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['4']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['4']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['4']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['4']['10']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['4']['11']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['12']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['13']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['14']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['4']['15']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['4']['16']);

			$row++;			
		}			

		//sheet kelima
		$objPHPExcel->setActiveSheetIndex(4);
		$objPHPExcel->getActiveSheet()->setCellValue('AG4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedLimaNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['1']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['2']['0']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['2']['0']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['2']['1']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['2']['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['2']['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['2']['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['3']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['4']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['4']['1']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['3']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['3']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['3']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['3']['2']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['3']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['3']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['3']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['3']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['3']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['3']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['3']['6']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['3']['6']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['3']['7']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['3']['7']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['8']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['8']['pr']);			
			
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['4']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['4']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['4']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['4']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['4']['3']['pr']);

			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $dt_kedua['5']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, $dt_kedua['5']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AW'.$row, $dt_kedua['5']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, $dt_kedua['5']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, $dt_kedua['5']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, $dt_kedua['5']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('BA'.$row, $dt_kedua['5']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, $dt_kedua['5']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('BC'.$row, $dt_kedua['5']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('BD'.$row, $dt_kedua['5']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('BE'.$row, $dt_kedua['5']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('BF'.$row, $dt_kedua['5']['5']['pr']);

			$row++;			
		}			

		//sheet keenam
		$objPHPExcel->setActiveSheetIndex(5);
		$objPHPExcel->getActiveSheet()->setCellValue('Z4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedEnamNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['5']);
						
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, "0");
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, "0");
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['2']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['2']['4']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['2']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['2']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['2']['6']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['2']['6']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['2']['7']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['2']['7']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['2']['8']['lk']+$dt_kedua['2']['9']['lk']+$dt_kedua['2']['10']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['2']['8']['pr']+$dt_kedua['2']['9']['pr']+$dt_kedua['2']['10']['pr']);			
			
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['3']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['3']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['3']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['3']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['3']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['3']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['3']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['3']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['3']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['3']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['3']['6']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['3']['6']['pr']);			

			$row++;			
		}			

		//sheet ketujuh
		$objPHPExcel->setActiveSheetIndex(6);
		$objPHPExcel->getActiveSheet()->setCellValue('X4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedTujuhNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['0']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['1']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['2']['pr']);						
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['1']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['1']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['1']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['1']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['1']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['1']['5']['pr']);
						
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['2']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['2']['5']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['3']['0']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['3']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['3']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['1']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['3']['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['3']['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['3']['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['2']['2']);
						
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['4']['0']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['4']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['0']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['0']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['5']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['4']['1']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['4']['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['4']['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AT'.$row, $dt_kedua['4']['1']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $dt_kedua['4']['1']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, $dt_kedua['5']['1']);

			$row++;			
		}

		//sheet kedelapan
		$objPHPExcel->setActiveSheetIndex(7);
		$objPHPExcel->getActiveSheet()->setCellValue('N4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedDelepanNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['0']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['0']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['0']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['2']['0']);						

			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['3']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['3']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['3']['0']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['3']['0']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['3']['0']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, 0);			
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['0']['6']);			
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['3']['0']['7']);			

			$row++;			
		}		

		//sheet kesembilan
		$objPHPExcel->setActiveSheetIndex(8);
		$objPHPExcel->getActiveSheet()->setCellValue('J4', $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA SEKOLAH DASAR ( SD ) TAHUN PELAJARAN ".$tahune);
		$kedua = $this->mlaporans->getSheedSembilanNegeri($tahun,$status);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['0']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['0']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['0']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['0']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['1']['0']['6']);						
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['1']['0']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['1']['0']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['1']['0']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['1']['0']['10']);			

			$row++;			
		}		

		$filename="RK SD ".mt_rand(1,100000).'.xls'; 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

		exit;
	}

	public function generate_all($tahun,$jenis,$status)
	{		
		$jenjange = array(
			'2'		=> 'SMP',
			'3'		=> 'SMA',
			'4'		=> 'SMK'
		);

		$stat_skul = array(
			'1'		=> '(Negeri)',
			'2'		=> '(Swasta)',
			'3'		=> '(Negeri dan Swasta)'
		);

		$skule = array(
			'2'		=> 'SEKOLAH MENENGAH PERTAMA ( SMP )',
			'3'		=> 'SEKOLAH MENENGAH ATAS ( SMA )',
			'4'		=> 'SEKOLAH MENENGAH KEJURUAN ( SMK )'
		);

		$tahune = $this->mlaporans->getTahune($tahun);

		$this->load->library('excel');		

		$objPHPExcel = PHPExcel_IOFactory::load('./template/RK-'.$jenjange[$jenis].'.xls');	

		
		//sheet satu
		$objPHPExcel->setActiveSheetIndex(0);		
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$kol1 = ($jenis == 2)?"F4":"F5";
		$objPHPExcel->getActiveSheet()->setCellValue($kol1, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheedSatuLainNegeri($jenis,$tahun,$status);

		$row = ($jenis == 2)?12:13;
		$no = 1;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nss']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['alamat']);	
			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $this->arey->getAkreditasi($dt_kedua['akre']));	
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $this->arey->getWaktu($dt_kedua['waktu']));	
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $this->arey->getStatusMutu($dt_kedua['mutu']));	
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $this->arey->getSertifikat($dt_kedua['iso']));	
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $this->arey->getWaktu($dt_kedua['waktu']));

			if($jenis == 4)	
			{
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, (in_array("1", $dt_kedua['kelompok']))?"Ya":"");
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, (in_array("2", $dt_kedua['kelompok']))?"Ya":"");
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, (in_array("3", $dt_kedua['kelompok']))?"Ya":"");
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, (in_array("4", $dt_kedua['kelompok']))?"Ya":"");
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, (in_array("5", $dt_kedua['kelompok']))?"Ya":"");
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, (in_array("6", $dt_kedua['kelompok']))?"Ya":"");				
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['1']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['1']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['1']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['1']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['1']['5']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['1']['6']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['1']['7']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['1']['8']);

			$row++;			
			$no++;
		}						

		//sheet dua
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		if($jenis == 2){
			$kol2 = 'P4';
		}elseif($jenis == 3){
			$kol2 = 'N5';
		}else{
			$kol2 = "M5";
		}
		$objPHPExcel->getActiveSheet()->setCellValue($kol2, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheedDuaLainNegeri($jenis,$tahun,$status);

		$row = ($jenis == 2)?12:13;		
		$no = 1;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['1']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['2']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['3']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['4']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['5']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['1']['6']['1']);			

			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['1']['0']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['1']['1']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['1']['2']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['1']['3']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['1']['4']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['1']['5']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['1']['6']['2']);			

			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['2']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['2']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['2']['5']);			
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['2']['6']);

			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['4']['dalam']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['4']['luar']);			

			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['3']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['3']['3']);

			$row++;	
			$no++;		
		}

		//sheet tiga
		$objPHPExcel->setActiveSheetIndex(2);
		if($jenis == 2){
			$kol3 = 'W4';
		}elseif($jenis == 3){
			$kol3 = 'M5';
			$objPHPExcel->getActiveSheet()->setCellValue('Z1', "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
			$objPHPExcel->getActiveSheet()->setCellValue('AK5', $stat_skul[$status]);
		}else{
			$kol3 = "AA5";			
		}
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol3, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheedTigaLainNegeri($jenis,$tahun,$status);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);			
			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['0']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['1']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['1']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['2']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['2']['2']);						
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, 0);			
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, 0);

			//tempat e error
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['2']['0']['1']);		
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['2']['0']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['2']['1']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['2']['1']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['2']['2']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['2']['2']['2']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['2']['3']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['2']['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['2']['4']['1']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['2']['4']['2']);						

			if($jenis == 2)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['3']['1']['lk']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['3']['1']['pr']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['3']['2']['lk']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['3']['2']['pr']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['3']['3']['lk']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['3']['3']['pr']);
			}

			if($jenis == 3 || $jenis == 4)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['2']['5']['1']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['2']['5']['2']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['2']['6']['1']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['2']['6']['2']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['2']['7']['1']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['2']['7']['2']);									

				$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['3']['1']['lk']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['3']['1']['pr']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AT'.$row, $dt_kedua['3']['2']['lk']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $dt_kedua['3']['2']['pr']);			
				$objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, $dt_kedua['3']['3']['lk']);						
				$objPHPExcel->getActiveSheet()->setCellValue('AW'.$row, $dt_kedua['3']['3']['pr']);
			}							

			$row++;			
		}

		//sheet empat
		$objPHPExcel->setActiveSheetIndex(3);
		if($jenis == 2){
			$kol4 = 'T4'; $A4 = 'E1'; $B4 = 'AI1'; $kols4 = 'AX4';
		}elseif($jenis == 3){
			$kol4 = 'O5'; $A4 = 'C1'; $B4 = 'AI1'; $kols4 = 'AU5';
		}else{
			$kol4 = "R5"; $A4 = 'C1'; $B4 = 'AI1'; $kols4 = 'AX5';
		}
		$objPHPExcel->getActiveSheet()->setCellValue($A4, "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol4, $stat_skul[$status]);
		$objPHPExcel->getActiveSheet()->setCellValue($B4, "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kols4, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheedEmpatLainNegeri($jenis,$tahun,$status);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);			

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['1']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['1']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['2']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['2']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['3']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['3']['pr']);						
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, 0);			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, 0);			

			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['4']);			

			//tempat e error 
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['3']['0']);			
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['3']['1']);						
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['3']['2']);

			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['4']['1']['jumlah']);			
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['4']['1']['luas']);						
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['4']['2']['jumlah']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['4']['2']['luas']);			
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['4']['3']['jumlah']);						
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['4']['3']['luas']);			
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['4']['4']['jumlah']);			
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['4']['4']['luas']);									

			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['5']['0']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['5']['1']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['5']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['5']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['5']['4']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['5']['5']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['5']['6']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['5']['7']);									
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['5']['8']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['5']['9']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['5']['10']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['5']['11']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['5']['12']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['5']['13']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['5']['14']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['5']['15']);									
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['5']['16']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['5']['17']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['5']['18']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AT'.$row, $dt_kedua['5']['19']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $dt_kedua['5']['20']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, $dt_kedua['5']['21']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AW'.$row, $dt_kedua['5']['22']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, $dt_kedua['5']['23']);									
			$objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, $dt_kedua['5']['24']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$row, $dt_kedua['5']['25']);						
			$objPHPExcel->getActiveSheet()->setCellValue('BA'.$row, $dt_kedua['5']['26']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BB'.$row, $dt_kedua['5']['27']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BC'.$row, $dt_kedua['5']['28']);						
			$objPHPExcel->getActiveSheet()->setCellValue('BD'.$row, $dt_kedua['5']['29']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BE'.$row, $dt_kedua['5']['30']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BF'.$row, $dt_kedua['5']['31']);									
			$objPHPExcel->getActiveSheet()->setCellValue('BG'.$row, $dt_kedua['5']['32']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BH'.$row, $dt_kedua['5']['33']);						
			$objPHPExcel->getActiveSheet()->setCellValue('BI'.$row, $dt_kedua['5']['34']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BJ'.$row, $dt_kedua['5']['35']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BK'.$row, $dt_kedua['5']['36']);						
			$objPHPExcel->getActiveSheet()->setCellValue('BL'.$row, $dt_kedua['5']['37']);			
			$objPHPExcel->getActiveSheet()->setCellValue('BM'.$row, $dt_kedua['5']['38']);

			$row++;			
		}

		//sheet lima
		$objPHPExcel->setActiveSheetIndex(4);
		if($jenis == 2){
			$kol5 = 'W4'; $A5 = 'O1';
		}elseif($jenis == 3){
			$kol5 = 'AF5'; $A5 = 'W1';
		}else{
			$kol5 = "T5"; $A5 = 'K1';
		}
		$objPHPExcel->getActiveSheet()->setCellValue($A5, "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol5, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheedLimaLainNegeri($jenis,$tahun,$status);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, ($dt_kedua['1']['kuri'] == 2)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, ($dt_kedua['1']['kuri'] == 2)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, ($dt_kedua['1']['kuri'] == 2)?"Ya":"");

			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, ($dt_kedua['1']['kuri'] == 3)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, ($dt_kedua['1']['kuri'] == 3)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, ($dt_kedua['1']['kuri'] == 3)?"Ya":"");

			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, ($dt_kedua['1']['kuri'] == 4)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, ($dt_kedua['1']['kuri'] == 4)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, ($dt_kedua['1']['kuri'] == 4)?"Ya":"");

			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['2']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['2']['0']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['2']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['2']['0']['8']);			
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['2']['0']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['2']['0']['10']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['2']['0']['11']);						
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['2']['0']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['2']['0']['12']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['2']['0']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['2']['0']['13']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['2']['0']['7']);

			$row++;			
		}

		//sheet enam
		$objPHPExcel->setActiveSheetIndex(5);		
		$kol6 = ($jenis == 2)?"G4":"I5";
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol6, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheedEnamLainNegeri($jenis,$tahun,$status);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['0']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['0']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['0']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['0']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['0']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['1']['0']['7']);						
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['1']['0']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['1']['0']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['1']['0']['10']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['1']['0']['11']);			

			$row++;			
		}

		//sheet ketujuh
		$objPHPExcel->setActiveSheetIndex(6);
		if($jenis == 2){
			$kol7 = 'T4'; $A7 = 'D1';
		}elseif($jenis == 3){
			$kol7 = 'Q5'; $A7 = 'C1';
		}else{
			$kol7 = "W5"; $A7 = 'C1';
		}
		$objPHPExcel->getActiveSheet()->setCellValue($A7, "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol7, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheetLainTujuhNegeri($jenis,$status);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, ($dt_kedua['1']['jk'] == 1)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, ($dt_kedua['1']['jk'] == 2)?"Ya":"");

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, ($dt_kedua['1']['golongan'] == 2)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, ($dt_kedua['1']['golongan'] == 3)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, ($dt_kedua['1']['golongan'] == 4)?"Ya":"");			
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, ($dt_kedua['1']['golongan'] == 5)?"Ya":"");			

			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, ($dt_kedua['1']['umur'] < 20)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, ($dt_kedua['1']['umur'] >= 20 && $dt_kedua['1']['umur'] <= 29)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, ($dt_kedua['1']['umur'] >= 30 && $dt_kedua['1']['umur'] <= 39)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, ($dt_kedua['1']['umur'] >= 40 && $dt_kedua['1']['umur'] <= 49)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, ($dt_kedua['1']['umur'] >= 50 && $dt_kedua['1']['umur'] <= 59)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, ($dt_kedua['1']['umur'] > 59)?"Ya":"");			

			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, ($dt_kedua['1']['tmt'] < 5)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, ($dt_kedua['1']['tmt'] >= 5 && $dt_kedua['1']['tmt'] <= 9)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, ($dt_kedua['1']['tmt'] >= 10 && $dt_kedua['1']['tmt'] <= 14)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, ($dt_kedua['1']['tmt'] >= 15 && $dt_kedua['1']['tmt'] <= 19)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, ($dt_kedua['1']['tmt'] >= 20 && $dt_kedua['1']['tmt'] <= 24)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, ($dt_kedua['1']['tmt'] > 24)?"Ya":"");			

			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, "");
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, "");
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, "");			
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, "");			
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, "");
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, ($dt_kedua['1']['ijazah'] == 5)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, ($dt_kedua['1']['ijazah'] == 6)?"Ya":"");			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, ($dt_kedua['1']['ijazah'] == 7)?"Ya":"");			
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, ($dt_kedua['1']['ijazah'] == 8)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, ($dt_kedua['1']['ijazah'] == 9)?"Ya":"");
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, ($dt_kedua['1']['ijazah'] == 10)?"Ya":"");			
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, ($dt_kedua['1']['ijazah'] == 11)?"Ya":"");			

			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['2']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['2']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['2']['1']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['2']['1']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['2']['2']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['2']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['2']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['2']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['2']['4']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['2']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['2']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['2']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['2']['6']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AT'.$row, $dt_kedua['2']['6']['pr']);
			$row++;			
		}

		//sheet delapan
		//tempat e error
		$objPHPExcel->setActiveSheetIndex(7);
		if($jenis == 2){
			$kol8 = 'T4'; $A8 = 'D1';
		}elseif($jenis == 3){
			$kol8 = 'P5'; $A8 = 'C1';
		}else{
			$kol8 = "T5"; $A8 = 'G1';
		}
		$objPHPExcel->getActiveSheet()->setCellValue($A8, "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol8, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheetLainDelapanNegeri($jenis,$status);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['lk']+$dt_kedua['1']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['1']['lk']+$dt_kedua['1']['1']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['2']['lk']+$dt_kedua['1']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['3']['lk']+$dt_kedua['1']['3']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['4']['lk']+$dt_kedua['1']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['1']['5']['lk']+$dt_kedua['1']['5']['pr']);						
			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['5']);
						
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, 0);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['0']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['3']['0']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['3']['1']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['3']['1']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['3']['2']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['3']['2']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['3']['3']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['3']['3']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['3']['4']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['4']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['3']['5']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['3']['5']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['3']['6']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['3']['6']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['7']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['7']['pr']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['3']['8']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['3']['8']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['3']['9']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['3']['9']['pr']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['3']['10']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['3']['10']['pr']);

			$row++;			
		}

		//sheet kesembilan
		//error meneh
		$objPHPExcel->setActiveSheetIndex(8);
		if($jenis == 2){
			$kol9 = 'S4'; $A9 = "C1";
		}elseif($jenis == 3){
			$kol9 = 'U5'; $A9 = "F1";
		}else{
			$kol9 = "AB5"; $A9 = "H1";
		}
		$objPHPExcel->getActiveSheet()->setCellValue($A9, "RANGKUMAN KABUPATEN DATA ".$skule[$jenis]." TAHUN PELAJARAN ".$tahune);
		$objPHPExcel->getActiveSheet()->setCellValue($kol9, $stat_skul[$status]);
		$kedua = $this->mlaporans->getSheetLainSembilanNegeri($jenis,$status);	

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['0']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['0']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kedua['1']['0']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['0']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['0']['4']);

			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kedua['2']['0']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['3']['0']);						
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['3']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['3']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['3']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['3']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['3']['7']);						
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['3']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['9']);

			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['4']['0']);						
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['4']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['4']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['4']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['4']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['4']['7']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['4']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['4']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['4']['10']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['4']['11']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['4']['12']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['4']['13']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['4']['14']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['4']['15']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['16']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['17']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['18']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['4']['19']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['4']['20']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $dt_kedua['4']['21']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $dt_kedua['4']['22']);
			$objPHPExcel->getActiveSheet()->setCellValue('AT'.$row, $dt_kedua['4']['23']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$row, $dt_kedua['4']['24']);
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$row, $dt_kedua['4']['25']);
			$objPHPExcel->getActiveSheet()->setCellValue('AW'.$row, $dt_kedua['4']['26']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AX'.$row, $dt_kedua['4']['27']);
			$objPHPExcel->getActiveSheet()->setCellValue('AY'.$row, $dt_kedua['4']['28']);

			$row++;			
		}

		$filename="RK ".$jenjange[$jenis]." ".mt_rand(1,100000).'.xls'; 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

		exit;
	}
}