<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');

		$this->load->model('mhome','',TRUE);
		$this->load->helper('captcha');
	}

	function tes($viewer=1)
	{	
		if($viewer == 1)
		{
			$tabele = 'tabelFGuru';
		}
		elseif($viewer == 2)
		{
			$tabele = 'tabelFStatus';	
		}
		elseif($viewer == 3)
		{
			$tabele = 'tabelFGolongan';	
		}
		elseif($viewer == 4)
		{
			$tabele = 'tabelFPendidikan';		
		}
		elseif($viewer == 5)
		{
			$tabele = 'tabelFSertifikasi';		
		}
		else
		{
			$tabele = 'tabelFGuruPensiun';
		}

		$data = array(
			'usere'		=> $this->mhome->getAkhirUser(),
			'kueri'		=> $this->mhome->getGuru($viewer),
			'tabele'	=> $tabele,
			'viewene'	=> $viewer,
			'viewer'	=> $this->arey->getJenisViewer()
		);
		
		$this->load->view('peta',$data);
	}

	/*function index($viewer=1)
	{	
		if($viewer == 1)
		{
			$tabele = 'tabelFGuru';
		}
		elseif($viewer == 2)
		{
			$tabele = 'tabelFStatus';	
		}
		elseif($viewer == 3)
		{
			$tabele = 'tabelFGolongan';	
		}
		elseif($viewer == 4)
		{
			$tabele = 'tabelFPendidikan';		
		}
		elseif($viewer == 5)
		{
			$tabele = 'tabelFSertifikasi';		
		}
		else
		{
			$tabele = 'tabelFGuruPensiun';
		}

		$data = array(
			'usere'		=> $this->mhome->getAkhirUser(),
			'kueri'		=> $this->mhome->getGuru($viewer),
			'tabele'	=> $tabele,
			'viewene'	=> $viewer,
			'viewer'	=> $this->arey->getJenisViewer()
		);
		
		$this->load->view('petas',$data);
	}*/

	function index($viewer=1)
	{	
		if($viewer == 1)
		{
			$tabele = 'tabelFGuru';
		}
		elseif($viewer == 2)
		{
			$tabele = 'tabelFStatus';	
		}
		elseif($viewer == 3)
		{
			$tabele = 'tabelFGolongan';	
		}
		elseif($viewer == 4)
		{
			$tabele = 'tabelFPendidikan';		
		}
		elseif($viewer == 5)
		{
			$tabele = 'tabelFSertifikasi';		
		}
		else
		{
			$tabele = 'tabelFGuruPensiun';
		}

		$this->load->library('googlemaps');
		$config['center'] = '-6.708609147163017, 111.33379555307329';
		$config['zoom'] = 'auto';

		//$config['center'] = '37.4419, -122.1419';
		//$config['zoom'] = 'auto';

		$this->googlemaps->initialize($config);

		$AllPeta = $this->mhome->getLokasiAll();

	    $socket=@fsockopen('36.78.220.156','80',$errno,$errstr,2);

	    if($socket==true)
	    {
	    	foreach($AllPeta as $detail_peta)
			{
				$marker = array();
				$marker['position'] = $detail_peta['titik'];
				$marker['infowindow_content'] = $detail_peta['ket'];
				$marker['icon'] = base_url().'assets/template/fingers/images/icon/peta/embassy.png';		
				$this->googlemaps->add_marker($marker);
			}
	    }		

		$data = array(
			'usere'		=> $this->mhome->getAkhirUser(),
			'kueri'		=> $this->mhome->getGuru($viewer),
			'tabele'	=> $tabele,
			'viewene'	=> $viewer,
			'viewer'	=> $this->arey->getJenisViewer(),
			'map'		=> $this->googlemaps->create_map()
		);
		
		$this->load->view('petane',$data);
	}

	public function detail($viewer=1,$kec=0,$id=0)
	{
		if($viewer == 1)
		{
			$tabele = 'tabelFGuru';
		}
		elseif($viewer == 2)
		{
			$tabele = 'tabelFStatusSkul';	
		}
		elseif($viewer == 3)
		{
			$tabele = 'tabelFGolonganSkul';	
		}
		elseif($viewer == 4)
		{
			$tabele = 'tabelFPendidikanSkul';		
		}
		else
		{
			$tabele = 'tabelFSertifikasiSkul';	
		}

		$data = array(	  								
			'tabele'		=> $tabele,
			'viewer'		=> $this->arey->getJenisViewer(),
			'kueri'			=> $this->mhome->getDetailGuru($viewer,$kec,$id),
			'usere'			=> $this->mhome->getAkhirUser(),
			'viewene'		=> $viewer,
			'kece'			=> $kec,
			'id'			=> $id
		);
			
		$this->load->view('petas',$data);
	}

	public function submit()
	{
		$view = $this->input->post('jenis_view',TRUE);

		redirect('home/index/'.$view);
	}

	function login()
	{		
		$vals = array(
		    'img_path'	=> './captcha/',
		    'img_url'	=> base_url().'captcha/'		    
		);

		$cap = create_captcha($vals);		

		$capt = array(
		    'captcha_time'	=> $cap['time'],
		    'ip_address'	=> $this->input->ip_address(),
		    'word'			=> $cap['word']
		);

		$query = $this->db->insert_string('captcha', $capt);
		$this->db->query($query);

		if($this->session->userdata('logged_in')) 
		{
			$akhir = $this->mhome->getAkhirSess($this->session->userdata('user_email'));

			if(isset($akhir->username) && isset($akhir->kode_token))
			{
				redirect('dashboard/index/'.$akhir->username.'/'.$akhir->kode_token);
			}
		}

		$data = array(
			'logo'		=> 'logo_login.png',
			'word'		=> $cap['word']
		);

		$this->load->view('login',$data);	
	}

	function login_ptk()
	{
		$vals = array(
		    'img_path'	=> './captcha/',
		    'img_url'	=> base_url().'captcha/'		    
		);

		$cap = create_captcha($vals);		

		$capt = array(
		    'captcha_time'	=> $cap['time'],
		    'ip_address'	=> $this->input->ip_address(),
		    'word'			=> $cap['word']
		);

		$query = $this->db->insert_string('captcha', $capt);
		$this->db->query($query);

		if($this->session->userdata('logged_in')) 
		{
			$akhir = $this->mhome->getAkhirSess($this->session->userdata('user_email'));

			if(isset($akhir->username) && isset($akhir->kode_token))
			{
				redirect('dashboard/index/'.$akhir->username.'/'.$akhir->kode_token);
			}
		}

		$data = array(
			'logo'		=> 'logo_ptk.png',
			'word'		=> $cap['word']
		);

		$this->load->view('login',$data);	
	}

	function login_paud()
	{
		$vals = array(
		    'img_path'	=> './captcha/',
		    'img_url'	=> base_url().'captcha/'		    
		);

		$cap = create_captcha($vals);		

		$capt = array(
		    'captcha_time'	=> $cap['time'],
		    'ip_address'	=> $this->input->ip_address(),
		    'word'			=> $cap['word']
		);

		$query = $this->db->insert_string('captcha', $capt);
		$this->db->query($query);

		if($this->session->userdata('logged_in')) 
		{
			$akhir = $this->mhome->getAkhirSess($this->session->userdata('user_email'));

			if(isset($akhir->username) && isset($akhir->kode_token))
			{
				redirect('paud/dashboard');
			}
		}

		$data = array(
			'logo'		=> 'logo_paud.png',
			'word'		=> $cap['word']
		);

		$this->load->view('login',$data);	
	}

	function logon($usename,$token)
	{	
		if(!$this->simpleloginsecure->cek_token($token)) 
		{
			echo "Login Ilegal";
		}					

		$username = $this->input->post('username',TRUE);
		$password = $this->input->post('password',TRUE);

		if($this->simpleloginsecure->cek($username)) 
		{
			if($this->simpleloginsecure->login($username, $password)) 
			{
				$inpute = array(
					'kode_token'	=> $token,
					'username'		=> $this->input->post('username',TRUE),
					'date_token'	=> date("Y-m-d h:i:s")
				);
				$query = $this->db->insert_string('token', $inpute);
				$this->db->query($query);
				
				$data = array(
					'statuss' => "ok",
					'level'   => $this->session->userdata('levels')
				);
			}
			else
			{
				$data = array(
					'statuss' => "Maaf Login Gagal"
				);
			}
		}
		else
		{
			$data = array(
				'statuss' => "Maaf Username Tidak Diketahui"
			);
		}
		echo json_encode($data);
	}

	function buat()
	{		
		$buat = $this->simpleloginsecure->create('admin', 'admin');
		if($buat)
		{
			echo "selesai";
		}
		else
		{
			echo "gagal";
		}
	}

	function logout()
	{
		//$this->simpleloginsecure->logout();

		$array_items = array(
			'logged_in' 		=> '', 
			'user_id'			=> '',
			'user_email'		=> '',
			'user_pass'			=> '',
			'user_date'			=> '',
			'user_modified'		=> '',
			'user_last_login'	=> '',
			'levels'			=> '',
			'user_level'		=> '',
			'id_school'			=> ''
		);

		$this->session->unset_userdata($array_items);
		redirect('home/login');
	}

	function login_sd()
	{
		if($this->simpleloginsecure->login('96325698', 'CTHGY54WUL'))
		{
			redirect('dashboard');
		}
		else
		{
			echo "gagal";
		}
	}

	function login_smp()
	{
		if($this->simpleloginsecure->login('95123574', 'LH9V9H6U2A'))
		{
			redirect('dashboard');
		}
		else
		{
			echo "gagal";
		}
	}

	function login_sma()
	{
		if($this->simpleloginsecure->login('97542912', 'VIDKGAA2GU'))
		{
			redirect('dashboard');
		}
		else
		{
			echo "gagal";
		}
	}

	function login_smk()
	{
		if($this->simpleloginsecure->login('74532569', '5TQMHSJK9D'))
		{
			redirect('dashboard');
		}
		else
		{
			echo "gagal";
		}
	}

	function login_admin()
	{
		if($this->simpleloginsecure->login('admin', 'vespasuper'))
		{
			redirect('dashboard');
		}
		else
		{
			echo "gagal";
		}
	}	
}
