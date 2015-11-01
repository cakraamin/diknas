<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Manajemen extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->model('muser','',TRUE);

		$this->load->library(array('page','SimpleLoginSecure','arey','acl'));



		if(!$this->session->userdata('logged_in')) 

		{

			redirect('home');

		}

	}



	function index()

	{

		redirect('manajemen/users');

	}



	function users($id="",$nama="",$kec=0,$kunci="kosong",$short_by='id_school',$short_order='desc',$page=0)

	{
		if($id == "" && $nama == "")
		{
			$this->message->set('notice','Tingkat sekolah belum ditentukan');
			redirect('manajemen/users/1');		
		}
		$per_page = 10;

		$total_page = $this->muser->getNumMember($id,$kec,$kunci);

		$url = 'manajemen/users/'.$id.'/'.$nama.'/'.$kec.'/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		

		$query = $this->muser->getMember($kec,$kunci,$id,$per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('manajemen/users/'.$id.'/'.$nama.'/'.$kec.'/'.$kunci.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=9),

			'main'			=> 'users',

			'users'			=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page,

			'id'			=> $id,

			'nama'			=> $nama,

			'kecamatan'		=> $this->muser->getSelekKec(),

			'kec'			=> $kec,

			'kunci'			=> ($kunci == 'kosong')?"":$kunci

		);

		$this->load->view('template',$data);

	}

	function paud($short_by='user_id',$short_order='desc',$page=0)

	{		
		$per_page = 10;

		$total_page = $this->muser->getNumMemberPaud();

		$url = 'manajemen/paud/'.$short_by.'/'.$short_order.'/';		

		$query = $this->muser->getMemberPaud($per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('manajemen/paud/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=8),

			'main'			=> 'paud',

			'users'			=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page,			

		);

		$this->load->view('template',$data);

	}

	function lain($short_by='user_id',$short_order='desc',$page=0)

	{		
		$per_page = 10;

		$total_page = $this->muser->getNumMemberLain();

		$url = 'manajemen/lain/'.$short_by.'/'.$short_order.'/';		

		$query = $this->muser->getMemberLain($per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('manajemen/lain/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=8),

			'main'			=> 'lain',

			'users'			=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page,			

		);

		$this->load->view('template',$data);

	}

	function roles($short_by='roleID',$short_order='desc',$page=0)

	{

		$per_page = 10;

		$total_page = $this->db->count_all('roles');

		$url = 'user/roles/'.$short_by.'/'.$short_order.'/';

		

		$query = $this->muser->getRoles($per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('manajemen/roles/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),

			'main'			=> 'roles',

			'manajemen'		=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page

		);

		$this->load->view('template',$data);

	}



	function permissions($short_by='permID',$short_order='desc',$page=0)

	{

		$per_page = 10;

		$total_page = $this->db->count_all('permissions');

		$url = 'manajemen/permissions/'.$short_by.'/'.$short_order.'/';

		

		$query = $this->muser->getPermissions($per_page,$page,$short_by,$short_order);

		if(count($query) == 0 && $page != 0)

		{

			redirect('manajemen/roles/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		

		}

				

		$data = array(

			'kueri' 		=> $query,

			'page'			=> $page,

			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),

			'main'			=> 'permissions',

			'manajemen'		=> 'select',

			'sort_by' 		=> $short_by,

			'sort_order' 	=> $short_order,			

			'page'			=> $page

		);

		$this->load->view('template',$data);

	}



	function tambah_user($id,$nama="")

	{

		if($id == "")

		{

			$this->message->set('notice','Kode Tingkat Sekolah Salah');

			redirect('dashboard');

		}



		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'addUser',

			'ket'			=> 'Form User',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_user/'.$id.'/'.$nama,

			'skul'			=> $this->muser->getSekolah($id),

			'level'			=> $this->muser->getUserLevel(),

			'id'			=> $id,

			'nama'			=> $nama

		);

			

		$this->load->view('template',$data);

	}

	function tambah_paud()
	{
		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'addPaud',

			'ket'			=> 'Form User',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_paud',			

			'level'			=> $this->muser->getUserLevel(),		

		);

		$this->load->view('template',$data);

	}

	function tambah_lain()
	{
		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'addLain',

			'ket'			=> 'Form User Lainnya',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_lain',			

			'level'			=> $this->muser->getUserLevel(),		

		);

		$this->load->view('template',$data);

	}

	function generate_paud()
	{
		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'generate_paud',

			'ket'			=> 'Form User Paud',

			'jenis'			=> 'Generate',

			'link'			=> 'auto_paud'			

		);

		$this->load->view('template',$data);
	}

	function generate_code($length = 10)
	{
    	if ($length <= 0)
        {
        	return false;
        }
            
        $code = "";
        $chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < $length; $i++)
        {
        	$code = $code . substr($chars, rand() % strlen($chars), 1);
        }
        return $code;
            
    }

	function auto_paud()
	{
		$email = ascii_to_entities(addslashes($this->input->post('email',TRUE)));
		$pass = $this->generate_code(10);

		$this->load->library('email');

		$config['mailtype'] = 'html';
		$config['validate'] = TRUE;
		$this->email->initialize($config);

		$this->email->from('SiapaAku87@gmail.com', 'Profil Dinpendik Rembang');
		$this->email->to($email);

		$this->email->subject('Pemberitahuan Username dan Password System');
		$this->email->message('Selamat Datang Di Aplikasi Profil Dinpendik Rembang.<br/>Username: '.$email.'<br/>Password:'.$pass);	

		if($this->email->send())
		{			
			if($this->simpleloginsecure->create($email, $pass, 101,''))
			{
				$this->message->set('succes','User berhasil digenerate');
			}
			else
			{
				$this->message->set('notice','User gagal digenerate');
			}
		}
		else
		{
			$this->message->set('notice','User gagal digenerate');
		}
		redirect('manajemen/paud');
	}


	function set_role($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/roles');

		}



		$this->acl->ACL($id);



		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'setRole',

			'ket'			=> 'Form User',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_user_role/'.$id,

			'kueri'			=> $this->acl->getAllRoles('full'),

			'id'			=> $id

		);

			

		$this->load->view('template',$data);

	}



	function set_permission($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/permissions');

		}



		$this->acl->ACL($id);



		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'setPermission',

			'ket'			=> 'Form User',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_user_perm/'.$id,			

			'kueri'			=> $this->acl->getAllPerms('full'),

			'akses'			=> $this->arey->getAkses(),

			'rPerms' 		=> $this->acl->perms

		);

			

		$this->load->view('template',$data);

	}



	function set_role_permissions($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/permissions');

		}



		$this->acl->ACL($id);



		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'setRolePerm',

			'ket'			=> 'Form Role Fitur Akses',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_role_perm/'.$id,

			'aPerms'		=> $this->acl->getAllPerms('full'),				

			'rPerms' 		=> $this->acl->getRolePerms($id),			

			'roleID'		=> $id

		);

			

		$this->load->view('template',$data);

	}



	function simpan_user_role($id)

	{

		$jumlah = $this->input->post('jumlah',TRUE);

		for($i=0;$i<$jumlah;$i++)

		{

			$input = $this->input->post('role'.$i);

			if($input == 1)

			{				

				$kueri = $this->muser->addUserRole($id,$this->input->post('roles'.$i));

			}

			else

			{

				$kueri = $this->muser->delUserRole($id,$this->input->post('roles'.$i));	

			}

		}



		if($kueri)

		{

			$this->message->set('succes','Update roles berhasil');

		}

		else

		{

			$this->message->set('notice','Update roles gagal');

		}



		redirect('manajemen/set_role/'.$id);

	}



	function simpan_user_perm($id)

	{

		$jumlah = $this->input->post('jumlah',TRUE);

		$kode = explode("-", $this->input->post('nilai',TRUE));

		for($i=0;$i<$jumlah;$i++)

		{

			$input = $this->input->post('perm_'.$i);

			$permKode = $kode[$i+1];

			if($input != 'x')

			{				

				$kueri = $this->muser->updateUserPerm($id,$permKode,$input);

			}

			else

			{

				$kueri = $this->muser->delUserPerm($id,$permKode);	

			}

		}



		if($kueri)

		{

			$this->message->set('succes','Update permissions berhasil');

		}

		else

		{

			$this->message->set('notice','Update permissions gagal');

		}



		redirect('manajemen/set_permission/'.$id);

	}



	function simpan_role_perm($id)

	{

		$jumlah = $this->input->post('jumlah',TRUE);

		for($i=0;$i<$jumlah;$i++)

		{

			$input = $this->input->post('role'.$i);

			if($input == '1' || $input == '0')

			{				

				$kueri = $this->muser->addRolePerm($id,$this->input->post('roles'.$i),$input);											

			}

			else

			{		

				$kueri = $this->muser->delRolePerm($id,$this->input->post('roles'.$i));	

			}

		}		



		if($kueri)

		{

			$this->message->set('succes','Update roles berhasil');

		}

		else

		{

			$this->message->set('notice','Update roles gagal');

		}



		redirect('manajemen/set_role_permissions/'.$id);

	}



	function tambah_role()

	{

		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'formRole',

			'ket'			=> 'Form Akses User',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_role'

		);

			

		$this->load->view('template',$data);

	}



	function tambah_permission()

	{

		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'formPermission',

			'ket'			=> 'Form Fitur Akses',

			'jenis'			=> 'Tambah',

			'link'			=> 'simpan_permission'

		);

			

		$this->load->view('template',$data);

	}



	function edit_user($ids,$nama,$id,$jenis="")

	{

		if($id == '')

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/users');

		}



		if($jenis == "")

		{

			$re = "user";

		}

		else

		{

			$re = "dashboard";

		}



		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'editUser',

			'ket'			=> 'Form User',

			'jenis'			=> 'Edit',

			'kueri'			=> $this->muser->editUser($id),

			'link'			=> 'update_user/'.$id.'/'.$ids.'/'.$nama,

			're'			=> $re,

			'ids'			=> $ids,

			'nama'			=> $nama

		);

			

		$this->load->view('template',$data);

	}

	function edit_paud($id)

	{

		if($id == '')

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/paud');

		}

		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'editPaud',

			'ket'			=> 'Form User',

			'jenis'			=> 'Edit',

			'kueri'			=> $this->muser->editUser($id),

			'link'			=> 'update_paud/'.$id,
		);

			

		$this->load->view('template',$data);

	}

	function edit_lain($id)

	{

		if($id == '')

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/lain');

		}

		$data = array(	  

			'users'			=> 'select',

			'main'			=> 'editLain',

			'ket'			=> 'Form User',

			'jenis'			=> 'Edit',

			'kueri'			=> $this->muser->editUser($id),

			'link'			=> 'update_lain/'.$id,
		);

			

		$this->load->view('template',$data);

	}

	function edit_role($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/roles');

		}



		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'formRole',

			'ket'			=> 'Form Akses User',

			'jenis'			=> 'Edit',

			'kueri'			=> $this->muser->editRole($id),

			'link'			=> 'update_role/'.$id

		);

			

		$this->load->view('template',$data);

	}



	function edit_permission($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/permissions');

		}



		$data = array(	  

			'manajemen'		=> 'select',

			'main'			=> 'formPermission',

			'ket'			=> 'Form Fitur Akses',

			'jenis'			=> 'Edit',

			'kueri'			=> $this->muser->editPermission($id),

			'link'			=> 'update_permission/'.$id

		);

			

		$this->load->view('template',$data);

	}

	

	function simpan_user($id,$nama)

	{	
		$sekolah = $this->input->post('sekolah',TRUE);

		if($this->muser->cekUser($sekolah) > 0)

		{

			$this->message->set('notice','Sekolah sudah digunakan');

			redirect('manajemen/users/'.$id.'/'.$nama);

		}



		$levels = array();



		$username = $this->input->post('username',TRUE);

		$password = $this->input->post('password',TRUE);

		$level = $this->input->post('level',TRUE);

		foreach($level as $dt_level)

		{

			$levels[] = $dt_level;

		}		

		if($this->simpleloginsecure->cek($username)) 

		{

			$this->message->set('notice','Nama user sudah digunakan');

		}

		else

		{

			if($this->simpleloginsecure->create($username, $password, $levels[0], $sekolah))

			{

				$terakhir = $this->db->insert_id();



				foreach($level as $dt_level)

				{

					$this->muser->addUserRole($terakhir,$dt_level);

				}



				if($this->db->affected_rows() > 0)

				{

					$this->message->set('succes','User berhasil dibuat');

				}				

				else

				{

					$this->message->set('notice','User gagal dibuat dibuat');

				}

			}

			else

			{

				$this->message->set('notice','User gagal dibuat');

			}

		}

		redirect('manajemen/users/'.$id.'/'.$nama);

	}

	function simpan_paud()
	{	
		$username = $this->input->post('username',TRUE);

		$password = $this->input->post('password',TRUE);

		$level = $this->input->post('level',TRUE);

		if($this->simpleloginsecure->cek($username)) 

		{

			$this->message->set('notice','Nama user sudah digunakan');

		}

		else

		{

			if($this->simpleloginsecure->create($username, $password, $level, ''))

			{

				$terakhir = $this->db->insert_id();
				$this->muser->addUserRole($terakhir,$level);

				if($this->db->affected_rows() > 0)

				{

					$this->message->set('succes','User berhasil dibuat');

				}				

				else

				{

					$this->message->set('notice','User gagal dibuat dibuat');

				}

			}

			else

			{

				$this->message->set('notice','User gagal dibuat');

			}

		}

		redirect('manajemen/paud');

	}

	function simpan_lain()
	{	
		$username = $this->input->post('username',TRUE);

		$password = $this->input->post('password',TRUE);

		$level = $this->input->post('level',TRUE);

		if($this->simpleloginsecure->cek($username)) 

		{

			$this->message->set('notice','Nama user sudah digunakan');

		}

		else

		{

			if($this->simpleloginsecure->create($username, $password, $level, '1000000'))

			{

				$terakhir = $this->db->insert_id();
				$this->muser->addUserRole($terakhir,$level);

				if($this->db->affected_rows() > 0)

				{

					$this->message->set('succes','User berhasil dibuat');

				}				

				else

				{

					$this->message->set('notice','User gagal dibuat dibuat');

				}

			}

			else

			{

				$this->message->set('notice','User gagal dibuat');

			}

		}

		redirect('manajemen/lain');

	}



	function simpan_role()

	{		

		$this->muser->addRole();



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','Role berhasil dibuat');

		}

		else

		{

			$this->message->set('notice','Role gagal dibuat');

		}



		redirect('manajemen/roles');

	}



	function simpan_permission()

	{		

		$this->muser->addPermission();



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','Fitur Akses berhasil dibuat');

		}

		else

		{

			$this->message->set('notice','Permission gagal dibuat');

		}



		redirect('manajemen/permissions');

	}

	

	function update_user($id,$ids,$nama)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/users/'.$ids.'/'.$nama);

		}



		$username = $this->input->post('username',TRUE);

		$old = $this->input->post('oldpassword',TRUE);

		$new = $this->input->post('password',TRUE);

		$re = $this->input->post('re',TRUE);

		if($this->simpleloginsecure->edit_password($username, $old, $new))

		{

			$this->message->set('succes','Update password user berhasil');

		}

		else

		{

			$this->message->set('notice','Maaf update password user gagal');

		}

		redirect('manajemen/users/'.$ids.'/'.$nama);

	}

	function update_paud($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/paud');

		}



		$username = $this->input->post('username',TRUE);

		$old = $this->input->post('oldpassword',TRUE);

		$new = $this->input->post('password',TRUE);		

		if($this->simpleloginsecure->edit_password($username, $old, $new))

		{

			$this->message->set('succes','Update password user berhasil');

		}

		else

		{

			$this->message->set('notice','Maaf update password user gagal');

		}

		redirect('manajemen/paud');

	}

	function update_lain($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/lain');

		}



		$username = $this->input->post('username',TRUE);

		$old = $this->input->post('oldpassword',TRUE);

		$new = $this->input->post('password',TRUE);		

		if($this->simpleloginsecure->edit_password($username, $old, $new))

		{

			$this->message->set('succes','Update password user berhasil');

		}

		else

		{

			$this->message->set('notice','Maaf update password user gagal');

		}

		redirect('manajemen/lain');

	}



	function update_role($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/roles');

		}



		$this->muser->updateRole($id);



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','Role berhasil diupdate');

		}

		else

		{

			$this->message->set('notice','Role gagal diupdate');

		}

		redirect('manajemen/roles');

	}



	function update_permission($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/permissions');

		}



		$this->muser->updatePermission($id);



		if($this->db->affected_rows() > 0)

		{

			$this->message->set('succes','Permission berhasil diupdate');

		}

		else

		{

			$this->message->set('notice','Permission gagal diupdate');

		}

		redirect('manajemen/permissions');

	}

	

	function hapus_user($id,$ids,$nama)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/users/'.$ids.'/'.$nama);

		}



		if($this->simpleloginsecure->delete($id))

		{

			$this->message->set('succes','User berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','User gagal dihapus');

		}

		redirect('manajemen/users/'.$ids.'/'.$nama);

	}

	function hapus_paud($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/paud');

		}



		if($this->simpleloginsecure->delete($id))

		{

			$this->message->set('succes','User berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','User gagal dihapus');

		}

		redirect('manajemen/paud');

	}

	function hapus_lain($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/lain');

		}



		if($this->simpleloginsecure->delete($id))

		{

			$this->message->set('succes','User berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','User gagal dihapus');

		}

		redirect('manajemen/lain');

	}

	function hapus_role($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/roles');

		}



		if($this->muser->deleteRole($id))

		{

			$this->message->set('succes','Role berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','Role gagal dihapus');

		}

		redirect('manajemen/roles');

	}



	function hapus_permission($id)

	{

		if($id == "")

		{

			$this->message->set('notice','Maaf parameter salah');

			redirect('manajemen/permissions');

		}



		if($this->muser->deletePermission($id))

		{

			$this->message->set('succes','Permission berhasil dihapus');

		}

		else

		{

			$this->message->set('notice','Permission gagal dihapus');

		}

		redirect('manajemen/permissions');

	}

	/*back via email function all_users()
	{		
		$cek = $this->input->post('check');
		$link = $this->input->post('links');

		if(!is_array($cek))
		{			
			$kec = $this->input->post('kecamatan',TRUE);
			redirect('manajemen/users/'.$link.'/'.$kec);
		}
		foreach($cek as $dt_cek)
		{
			if($this->input->post('tombol',TRUE) == 'hapus')
			{
				$this->simpleloginsecure->delete($dt_cek);
			}
			else
			{
				$cekEmail = $this->muser->getEmail($dt_cek);

				$this->load->library('email');

				$config['mailtype'] = 'html';
				$config['validate'] = TRUE;
				$this->email->initialize($config);

				$this->email->from('SiapaAku87@gmail.com', 'Profil Dinpendik Rembang');
				$this->email->to($cekEmail['email']);

				$this->email->subject('Pemberitahuan Username dan Password System');
				$this->email->message('Selamat Datang Di Aplikasi Profil Dinpendik Rembang.<br/>Username: '.$cekEmail['npsn'].'<br/>Password:'.$cekEmail['npsn']);	

				if($this->email->send())
				{
					if($this->simpleloginsecure->create($cekEmail['npsn'], $cekEmail['npsn'], 2, $dt_cek))
					{
						$this->message->set('succes','User berhasil digenerate');
					}
					else
					{
						$this->message->set('notice','User gagal digenerate');
					}
				}
				else
				{
					$this->message->set('notice','User gagal digenerate');
				}				
			}			
		}

		if($this->input->post('tombol',TRUE) == 'hapus')
		{
			$this->message->set('succes','User berhasil dihapus');
		}		
		redirect('manajemen/users/'.$link);
	}*/

	function all_users()
	{						
		$eksel = array();

		$cek = $this->input->post('check');
		$link = $this->input->post('links');

		if(!is_array($cek) || $this->input->post('tombol',TRUE) == "")
		{				
			$kunci = $this->input->post('kunci',TRUE);
			$kunci = str_replace(" ", "-", $kunci);		
			$kec = $this->input->post('kecamatan',TRUE);
			redirect('manajemen/users/'.$link.'/'.$kec.'/'.$kunci);
		}
		foreach($cek as $dt_cek)
		{
			if($this->input->post('tombol',TRUE) == 'hapus')
			{
				$this->simpleloginsecure->delete_school($dt_cek);
				//echo "hapus".$dt_cek;
				//exit();
			}
			else
			{
				$cekEmail = $this->muser->getEmail($dt_cek);
				$pass = $this->generate_code(10);

				if($this->simpleloginsecure->create($cekEmail['npsn'], $pass, 2, $dt_cek))
				{
					$eksel[] = array($cekEmail['npsn'],$pass,$cekEmail['nama']);
				}
				else
				{
					$this->message->set('notice','Maaf User Telah Dibuat Sebelumnya');
					redirect('manajemen/users/'.$link);
				}
			}			
		}

		if($this->input->post('tombol',TRUE) == 'hapus')
		{
			$this->message->set('succes','User berhasil dihapus');			
		}
		else
		{
			$this->load->library('excel');

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
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);			
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);			
			$this->excel->getActiveSheet()->setTitle("Tabel 1");
			
			$this->excel->getActiveSheet()->mergeCells('A1:C1');
			$this->excel->getActiveSheet()->setCellValue('A1','DAFTAR USER DAN PASSWORD');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		

			$this->excel->getActiveSheet()->setCellValue('A3', 'NO');		
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->setCellValue('B3', 'NAMA SEKOLAH');		
			$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);		
			$this->excel->getActiveSheet()->setCellValue('C3', 'USERNAME');		
			$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);					
			$this->excel->getActiveSheet()->setCellValue('D3', 'PASSWORD');		
			$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);					

			$baris = 4;
			$no = 1;
			foreach($eksel as $dt_eksel)
			{
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_eksel[2]);				
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_eksel[0]);				
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $dt_eksel[1]);				
				$baris++;
				$no++;
			}

			$brs_bwh = $baris - 1;
			$this->excel->getActiveSheet()->getStyle('A3:D'.$brs_bwh)->applyFromArray($styleArray);	

			$filename='Password Data Sekolah '.date("Y-m-d").'.xls';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
					             
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			$objWriter->save('php://output');			
		}
		redirect('manajemen/users/'.$link);
	}

	function all_paud()

	{

		$cek = $this->input->post('check');

		$link = $this->input->post('links');

		if(!is_array($cek))

		{		
			redirect('manajemen/paud');
		}

		foreach($cek as $dt_cek)

		{

			$this->simpleloginsecure->delete($dt_cek);

		}

		$this->message->set('succes','User berhasil dihapus');

		redirect('manajemen/paud');

	}

	function all_lain()

	{

		$cek = $this->input->post('check');

		$link = $this->input->post('links');

		if(!is_array($cek))

		{		
			redirect('manajemen/lain');
		}

		foreach($cek as $dt_cek)

		{

			$this->simpleloginsecure->delete($dt_cek);

		}

		$this->message->set('succes','User berhasil dihapus');

		redirect('manajemen/lain');

	}

	function all_roles()

	{

		$cek = $this->input->post('check');

		if(!is_array($cek))

		{

			$this->message->set('notice','Tidak ada roles yang dipilih');

			redirect('manajemen/roles');

		}

		foreach($cek as $dt_cek)

		{

			$this->muser->deleteRole($dt_cek);

		}

		$this->message->set('succes','Roles berhasil dihapus');

		redirect('manajemen/roles');

	}



	function all_permissions()

	{			

		$cek = $this->input->post('check');

		if(!is_array($cek))

		{

			$this->message->set('notice','Tidak ada fitur akses yang dipilih');

			redirect('manajemen/permissions');

		}

		foreach($cek as $dt_cek)

		{

			$this->muser->deletePermission($dt_cek);

		}

		$this->message->set('succes','Fitur akses berhasil dihapus');

		redirect('manajemen/permissions');

	}

}