<?php



class Muser extends CI_Model{

	function __construct()

	{

		parent::__construct();

	}



	function getMember($kec,$kunci,$id,$num,$offset,$sort_by,$sort_order)//menu admin

	{
		$data = array();
		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$kunci = ($kunci != "")?str_replace("-", " ", $kunci):"";
		$kunci = ($kunci == "kosong")?"":" AND nama_school LIKE '%".mysql_real_escape_string($kunci)."%' ";

		$sort_columns = array('id_school');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'id_school';

		$kec = ($kec == 0)?"":" AND id_kecamatan='$kec' ";
		
		$sql = "SELECT * FROM schools WHERE jenjang_school='$id' $kec $kunci ORDER BY $sort_by $sort_order LIMIT $offset,$num";						

		$query = $this->db->query($sql);

		$hasil = $query->result();
		foreach($hasil as $dt_hasil)
		{
			$sql_u = "SELECT * FROM users WHERE id_school='".$dt_hasil->id_school."'";
			$qstatus = $this->db->query($sql_u);
			$qhasil = $qstatus->row();
			$qdata = (isset($qhasil->user_email))?$qhasil->user_email:"Belum Ditentukan";
			$qkode = (isset($qhasil->user_id))?$qhasil->user_id:0;

			$data[] = array(
				'id_school'		=> $dt_hasil->id_school,
				'nama_school'	=> $dt_hasil->nama_school,
				'status'		=> $qdata,
				'kode'			=> $qkode,
				'query'			=> $sql_u
			);	
		}

		return $data;

	}

	function getEmail($id)
	{
		$kueri = $this->db->query("SELECT * FROM schools WHERE id_school='$id'");
		$hasil = $kueri->row();
		$nama = (isset($hasil->nama_school))?$hasil->nama_school:"";
		$email = (isset($hasil->email_school))?$hasil->email_school:"";
		$npsn = (isset($hasil->npsn_school))?$hasil->npsn_school:"";

		$data = array(
			'email'		=> $email,
			'npsn'		=> $npsn,
			'nama'		=> $nama
		);

		return $data;
	}

	function getMemberPaud($num,$offset,$sort_by,$sort_order)//menu admin

	{

		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$sort_columns = array('user_id');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'user_id';
		$sql = "SELECT * FROM users WHERE user_level='100' OR user_level='101' ORDER BY $sort_by $sort_order LIMIT $offset,$num";					
		$query = $this->db->query($sql);

		return $query->result();

	}

	function getMemberLain($num,$offset,$sort_by,$sort_order)//menu admin

	{

		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$sort_columns = array('user_id');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'user_id';
		$sql = "SELECT * FROM users WHERE id_school='1000000' ORDER BY $sort_by $sort_order LIMIT $offset,$num";					
		$query = $this->db->query($sql);

		return $query->result();

	}



	function getNumMember($id,$kec,$kunci)

	{		
		$kunci = ($kunci != "")?str_replace("-", " ", $kunci):"";
		$kunci = ($kunci == "kosong")?"":" AND nama_school LIKE '%".mysql_real_escape_string($kunci)."%' ";

		$kec = ($kec == 0)?"":" AND id_kecamatan='$kec'";		
		$sql = "SELECT * FROM schools WHERE jenjang_school='$id' $kec $kunci";		

		$query = $this->db->query($sql);

		return $query->num_rows();

	}

	function getNumMemberPaud()
	{		
		$sql = "SELECT * FROM users WHERE user_level='100' OR user_level='101'";		
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getNumMemberLain()
	{		
		$sql = "SELECT * FROM users WHERE id_school='1000000'";		
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getRoles($num,$offset,$sort_by,$sort_order)//menu admin

	{

		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$sort_columns = array('roleID');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'roleID';

		$sql = "SELECT * FROM roles ORDER BY $sort_by $sort_order LIMIT $offset,$num";

		$query = $this->db->query($sql);

		return $query->result();

	}



	function getPermissions($num,$offset,$sort_by,$sort_order)//menu admin

	{

		if (empty($offset))

		{

			$offset=0;

		}

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';

		$sort_columns = array('permID');

		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'permID';

		$sql = "SELECT * FROM permissions ORDER BY $sort_by $sort_order LIMIT $offset,$num";

		$query = $this->db->query($sql);

		return $query->result();

	}

	

	function editUser($id)

	{

		$sql = "SELECT * FROM users WHERE user_id='$id'";

		$kueri = $this->db->query($sql);

		if($kueri->num_rows() > 0)

		{

			$hasil = $kueri->row();

			return $hasil;

		}

	}



	function getSekolah($id)

	{

		$query = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id' ORDER BY id_school ASC");



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



	function getUserLevel()

	{

		$query = $this->db->query("SELECT * FROM roles ORDER BY roleID ASC");



		if ($query->num_rows()> 0)

		{

			$data[] = "";

			foreach ($query->result_array() as $row)

			{

				$data[$row['roleID']] = $row['roleName'];

			}

			$data[100] = "Admin PAUD";
			$data[101] = "Operator PAUD";

		}

		else

		{

			$data[''] = "";

		}

		$query->free_result();

		return $data;

	}



	function addRole()

	{

		$data = array(

			'roleID'		=> '',

			'roleName'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('role',TRUE))))

		);



		$this->db->insert('roles', $data); 

	}



	function addPermission()

	{

		$perm = strip_tags(ascii_to_entities(addslashes($this->input->post('perm',TRUE))));

		$contr = strip_tags(ascii_to_entities(addslashes($this->input->post('contr',TRUE))));

		$permKecil = strtolower($perm);

		$noSpace = str_replace(" ", "_", $permKecil);



		$data = array(

			'permID'		=> '',

			'permKey'		=> $noSpace,

			'permName'		=> $perm,

			'controllerName'=> $contr

		);



		$this->db->insert('permissions', $data); 	

	}



	function editRole($id)

	{

		$query = $this->db->query("SELECT * FROM roles WHERE roleID='$id'");

		return $query->row();

	}



	function updateRole($id)

	{

		$data = array(

            'roleName'		=> strip_tags(ascii_to_entities(addslashes($this->input->post('role',TRUE))))

       	);



		$this->db->where('roleID', $id);

		$this->db->update('roles', $data); 

	}



	function updatePermission($id)

	{

		$perm = strip_tags(ascii_to_entities(addslashes($this->input->post('perm',TRUE))));

		$contr = strip_tags(ascii_to_entities(addslashes($this->input->post('contr',TRUE))));

		$permKecil = strtolower($perm);

		$noSpace = str_replace(" ", "_", $permKecil);



		$data = array(

			'permKey'		=> $noSpace,

			'permName'		=> $perm,

			'controllerName'=> $contr

		);



		$this->db->where('permID', $id);

		$this->db->update('permissions', $data);

	}



	function deleteRole($id)

	{

		$kueri = $this->db->query("DELETE FROM roles WHERE roleID='$id'");

		return $kueri;

	}



	function deletePermission($id)

	{

		$kueri = $this->db->query("DELETE FROM permissions WHERE permID='$id'");

		return $kueri;

	}



	function editPermission($id)

	{

		$kueri = $this->db->query("SELECT * FROM permissions WHERE permID='$id'");

		return $kueri->row();

	}



	function addUserRole($id,$role)

	{

		$query_hapus = $this->db->query("DELETE FROM user_roles WHERE userID='$id' AND roleID='$role'");

		if($query_hapus)

		{

			$query = $this->db->query("INSERT INTO user_roles VALUES('$id','$role',NOW())");

			return $query;

		}

	}



	function addRolePerm($id,$perm,$val)

	{

		$query_hapus = $this->db->query("DELETE FROM role_perms WHERE roleID='$id' AND permID='$perm'");

		if($query_hapus)

		{

			$query = $this->db->query("INSERT INTO role_perms(roleID,permID,value,addDate) VALUES('$id','$perm','$val',NOW())");

			return $query;

		}

	}



	function addUserPerm($id,$role)

	{

		$query_hapus = $this->db->query("DELETE FROM user_roles WHERE userID='$id' AND roleID='$role'");

		if($query_hapus)

		{

			$query = $this->db->query("INSERT INTO user_roles VALUES('$id','$role',NOW())");

			return $query;

		}

	}



	function delUserRole($id,$role)

	{

		$query_hapus = $this->db->query("DELETE FROM user_roles WHERE userID='$id' AND roleID='$role'");

		return $query_hapus;

	}



	function delRolePerm($id,$perm)

	{

		$query_hapus = $this->db->query("DELETE FROM role_perms WHERE roleID='$id' AND permID='$perm'");

		return $query_hapus;

	}



	function updateUserPerm($id,$permKode,$input)

	{

		$query_hapus = $this->db->query("DELETE FROM user_perms WHERE userID='$id' AND permID='$permKode'");

		if($query_hapus)

		{

			$query = $this->db->query("INSERT INTO user_perms(userID,permID,value,addDate) VALUES('$id','$permKode','$input',NOW())");

			return $query;

		}

	}



	function delUserPerm($id,$permKode)

	{

		$query_hapus = $this->db->query("DELETE FROM user_perms WHERE userID='$id' AND permID='$permKode'");

		return $query_hapus;

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



	function cekUser($id)

	{
		$sql = "SELECT * FROM users WHERE id_school='$id'";

		$kueri = $this->db->query($sql);

		return $kueri->num_rows();

	}

}

?>