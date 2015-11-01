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
		//redirect('laporans/sd');
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

	public function sd()
	{
		$data = array(
			'main'			=> 'laporans',
			'laporan'		=> 'select',			
			'tahun'			=> $this->mlaporans->getTahun(),
			'jenjang'		=> $this->arey->getJenjang(),
			'link'			=> 'generate',
			'keterangan'	=> 'Laporan RK SD'
		);

		$this->load->view('template',$data);
	}

	public function generate()
	{
		$tahun = $this->input->post('tahun',TRUE);
		$jenjang = $this->input->post('jenjang',TRUE);
		if($jenjang == '1')
		{
			redirect('laporans/generate_sd/'.$tahun);
		}
		else
		{			
			redirect('laporans/generate_all/'.$tahun.'/'.$jenjang);
		}	
	}

	public function generate_sd($tahun)
	{
		$this->load->library('excel');		

		$objPHPExcel = PHPExcel_IOFactory::load('./template/RK-SD.xls');	

		$objPHPExcel->setActiveSheetIndex(0);

		$kueri = $this->mlaporans->getSdNegeri();		
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
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kueri['6']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kueri['6']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kueri['6']['3']);

			$row++;			
		}		

		$kueri = $this->mlaporans->getSdSwasta();		
		$row = 27;		
		foreach($kueri as $dt_kueri)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kueri['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kueri['kode']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kueri['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dt_kueri['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kueri['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kueri['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dt_kueri['2']['4']);			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kueri['3']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kueri['3']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kueri['3']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kueri['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kueri['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kueri['4']['3']);			
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kueri['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kueri['6']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kueri['6']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kueri['6']['3']);

			$row++;			
		}		

		//sheet kedua
		$objPHPExcel->setActiveSheetIndex(1);
		$kedua = $this->mlaporans->getSheedDuaNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedDuaSwasta($tahun);

		$row = 27;		
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
		$kedua = $this->mlaporans->getSheedTigaNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedTigaSwasta($tahun);

		$row = 27;		
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
		$kedua = $this->mlaporans->getSheedEmpatNegeri($tahun);

		$row = 12;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['4']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['2']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['9']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['1']['jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['3']['2']['jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['3']['3']['jumlah']);			
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['3']['4']['jumlah']);

			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['4']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['4']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['4']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['4']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['4']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['4']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['4']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['4']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['4']['10']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['4']['11']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['4']['12']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['4']['13']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['14']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['15']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['16']);

			$row++;			
		}	

		$kedua = $this->mlaporans->getSheedEmpatSwasta($tahun);

		$row = 27;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['1']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['1']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dt_kedua['1']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dt_kedua['1']['4']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dt_kedua['2']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dt_kedua['2']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dt_kedua['2']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $dt_kedua['2']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dt_kedua['2']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dt_kedua['2']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dt_kedua['2']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dt_kedua['2']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['2']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $dt_kedua['2']['9']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['1']['jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $dt_kedua['3']['2']['jumlah']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $dt_kedua['3']['3']['jumlah']);			
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $dt_kedua['3']['4']['jumlah']);

			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $dt_kedua['4']['0']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $dt_kedua['4']['1']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['4']['2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['4']['3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['4']['4']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['4']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['4']['6']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['4']['7']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['4']['8']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['4']['9']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['4']['10']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['4']['11']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['4']['12']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $dt_kedua['4']['13']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['4']['14']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['4']['15']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['4']['16']);

			$row++;			
		}

		//sheet kelima
		$objPHPExcel->setActiveSheetIndex(4);
		$kedua = $this->mlaporans->getSheedLimaNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedLimaSwasta($tahun);

		$row = 27;		
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
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['3']['8']['lk']+$dt_kedua['3']['9']['lk']+$dt_kedua['3']['10']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['3']['8']['pr']+$dt_kedua['3']['9']['pr']+$dt_kedua['3']['10']['pr']);			
			
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
		$kedua = $this->mlaporans->getSheedEnamNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedEnamSwasta($tahun);

		$row = 27;		
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
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['2']['8']['lk']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['2']['8']['pr']);			
			
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
		$kedua = $this->mlaporans->getSheedTujuhNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedTujuhSwasta($tahun);

		$row = 27;		
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
		$kedua = $this->mlaporans->getSheedDelepanNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedDelepanSwasta($tahun);

		$row = 27;		
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
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dt_kedua['3']['0']['5']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $dt_kedua['3']['0']['6']);			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $dt_kedua['3']['0']['7']);			

			$row++;			
		}	

		//sheet kesembilan
		$objPHPExcel->setActiveSheetIndex(8);
		$kedua = $this->mlaporans->getSheedSembilanNegeri($tahun);

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

		$kedua = $this->mlaporans->getSheedSembilanSwasta($tahun);

		$row = 27;
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

	public function generate_all($tahun,$jenis)
	{		
		$jenjange = array(
			'2'		=> 'SMP',
			'3'		=> 'SMA',
			'4'		=> 'SMK'
		);

		$this->load->library('excel');		

		$objPHPExcel = PHPExcel_IOFactory::load('./template/RK-'.$jenjange[$jenis].'.xls');	

		
		//sheet satu
		$objPHPExcel->setActiveSheetIndex(0);
		$kedua = $this->mlaporans->getSheedSatuLainNegeri($jenis,$tahun);

		$row = ($jenis == 2)?12:13;
		$no = 1;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nss']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dt_kedua['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dt_kedua['alamat']);	
			
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
		$kedua = $this->mlaporans->getSheedDuaLainNegeri($jenis,$tahun);

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

			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['3']['1']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['3']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['3']['3']);

			$row++;	
			$no++;		
		}

		//sheet tiga
		$objPHPExcel->setActiveSheetIndex(2);
		$kedua = $this->mlaporans->getSheedTigaLainNegeri($jenis,$tahun);

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

			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $dt_kedua['2']['0']['1']+$dt_kedua['2']['0']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $dt_kedua['2']['1']['1']+$dt_kedua['2']['1']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $dt_kedua['2']['2']['1']+$dt_kedua['2']['2']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $dt_kedua['2']['3']['1']+$dt_kedua['2']['3']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $dt_kedua['2']['4']['1']+$dt_kedua['2']['4']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $dt_kedua['2']['5']['1']+$dt_kedua['2']['5']['2']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $dt_kedua['2']['6']['1']+$dt_kedua['2']['6']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $dt_kedua['2']['7']['1']+$dt_kedua['2']['7']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $dt_kedua['2']['8']['1']+$dt_kedua['2']['8']['2']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $dt_kedua['2']['9']['1']+$dt_kedua['2']['9']['2']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $dt_kedua['2']['10']['1']+$dt_kedua['2']['10']['2']);

			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $dt_kedua['3']['1']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $dt_kedua['3']['1']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $dt_kedua['3']['2']['lk']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $dt_kedua['3']['2']['pr']);			
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $dt_kedua['3']['3']['lk']);						
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $dt_kedua['3']['3']['pr']);

			$row++;			
		}

		//sheet empat
		$objPHPExcel->setActiveSheetIndex(3);
		$kedua = $this->mlaporans->getSheedEmpatLainNegeri($jenis,$tahun);

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
		$kedua = $this->mlaporans->getSheedLimaLainNegeri($jenis,$tahun);

		$row = 13;		
		foreach($kedua as $dt_kedua)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-12);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dt_kedua['nama']);
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
		$kedua = $this->mlaporans->getSheedEnamLainNegeri($jenis,$tahun);

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
		$kedua = $this->mlaporans->getSheetLainTujuhNegeri($jenis);

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
		$objPHPExcel->setActiveSheetIndex(7);
		$kedua = $this->mlaporans->getSheetLainDelapanNegeri($jenis);

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
		$objPHPExcel->setActiveSheetIndex(8);
		$kedua = $this->mlaporans->getSheetLainSembilanNegeri($jenis);	

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