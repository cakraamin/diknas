<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class ACL

	{

		var $perms = array();		//Array : Stores the permissions for the user

		var $userID = 0;			//Integer : Stores the ID of the current user

		var $userRoles = array();	//Array : Stores the roles of the current user

		var $hasil = array();

		

		function __constructor($userID = '')

		{

			$this->ci =& get_instance();



			if ($userID != '')

			{

				$this->userID = floatval($userID);

			} else {

				$this->userID = floatval($this->ci->session->userdata('user_id'));

			}

			$this->userRoles = $this->getUserRoles();

			$this->buildACL();

		}

		

		function ACL($userID = '')

		{

			$this->__constructor($userID);

			//crutch for PHP4 setups

		}

		

		function buildACL()

		{

			//first, get the rules for the user's role

			if (count($this->userRoles) > 0)

			{

				$this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));

			}

			//then, get the individual user permissions

			$this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));

		}

		

		function getPermKeyFromID($permID)

		{

			$strSQL = "SELECT `permKey` FROM `permissions` WHERE `permID` = " . floatval($permID) . " LIMIT 1";

			$data = mysql_query($strSQL);

			$row = mysql_fetch_array($data);

			return $row[0];

		}

		function getContrNameFromID($permID)

		{

			$strSQL = "SELECT `controllerName` FROM `permissions` WHERE `permID` = " . floatval($permID) . " LIMIT 1";

			$data = mysql_query($strSQL);

			$row = mysql_fetch_array($data);

			return $row[0];

		}

		

		function getPermNameFromID($permID)

		{

			$strSQL = "SELECT `permName` FROM `permissions` WHERE `permID` = " . floatval($permID) . " LIMIT 1";

			$data = mysql_query($strSQL);

			$row = mysql_fetch_array($data);

			return $row[0];

		}

		

		function getRoleNameFromID($roleID)

		{

			$strSQL = "SELECT `roleName` FROM `roles` WHERE `roleID` = " . floatval($roleID) . " LIMIT 1";

			$data = mysql_query($strSQL);

			$row = mysql_fetch_array($data);

			return $row[0];

		}

		

		function getUserRoles()

		{

			$strSQL = "SELECT * FROM `user_roles` WHERE `userID` = " . floatval($this->userID) . " ORDER BY `addDate` ASC";

			//$strSQL = "SELECT * FROM `user_roles` WHERE `userID` = 5 ORDER BY `addDate` ASC";

			$data = mysql_query($strSQL);

			$resp = array();

			while($row = mysql_fetch_array($data))

			{

				$resp[] = $row['roleID'];

			}

			return $resp;

		}

		

		function getAllRoles($format='ids')

		{

			$format = strtolower($format);

			$strSQL = "SELECT * FROM `roles` ORDER BY `roleName` ASC";

			$data = mysql_query($strSQL);

			$resp = array();

			while($row = mysql_fetch_array($data))

			{

				if ($format == 'full')

				{

					$resp[] = array("ID" => $row['roleID'],"Name" => $row['roleName']);

				} else {

					$resp[] = $row['roleID'];

				}

			}

			return $resp;

		}

		

		function getAllPerms($format='ids')

		{

			$format = strtolower($format);

			$strSQL = "SELECT * FROM `permissions` ORDER BY `permName` ASC";

			$data = mysql_query($strSQL);

			$resp = array();

			while($row = mysql_fetch_assoc($data))

			{

				if ($format == 'full')

				{

					$resp[$row['permKey']] = array('ID' => $row['permID'], 'Name' => $row['permName'], 'Key' => $row['permKey'], 'Contr' => $row['controllerName']);

				} else {

					$resp[] = $row['permID'];

				}

			}

			return $resp;

		}



		function getRolePerms($role)

		{

			if (is_array($role))

			{

				$roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";

			} else {

				$roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";

			}

			$data = mysql_query($roleSQL);

			$perms = array();

			while($row = mysql_fetch_assoc($data))

			{

				$pK = strtolower($this->getPermKeyFromID($row['permID']));

				$cK = strtolower($this->getContrNameFromID($row['permID']));

				if ($pK == '') { continue; }

				if ($cK == '') { continue; }

				if ($row['value'] === '1') {

					$hP = true;

				} else {

					$hP = false;

				}

				$perms[$cK] = array('perm' => $cK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID'],'status' => $row['value'],'tanggal' => $row['addDate'], 'contr' => $cK);

			}

			return $perms;

		}

		

		function getUserPerms($userID)

		{

			$strSQL = "SELECT * FROM `user_perms` WHERE `userID` = " . floatval($userID) . " ORDER BY `addDate` ASC";

			$data = mysql_query($strSQL);

			$perms = array();

			while($row = mysql_fetch_assoc($data))

			{

				$pK = strtolower($this->getPermKeyFromID($row['permID']));

				if ($pK == '') { continue; }

				if ($row['value'] == '1') {

					$hP = true;

				} else {

					$hP = false;

				}

				$perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);

			}

			return $perms;

		}

		

		function userHasRole($roleID)

		{

			foreach($this->userRoles as $k => $v)

			{

				if (floatval($v) === floatval($roleID))

				{

					return true;

				}

			}

			return false;

		}

		

		function hasPermission($permKey)

		{

			$permKey = strtolower($permKey);

			if (array_key_exists($permKey,$this->perms))

			{

				if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)

				{

					return true;

				} else {

					return false;

				}

			} else {

				return true;

			}

		}

		

		function getUsername($userID)

		{

			$strSQL = "SELECT `username` FROM `users` WHERE `ID` = " . floatval($userID) . " LIMIT 1";

			$data = mysql_query($strSQL);

			$row = mysql_fetch_array($data);

			return $row[0];

		}

		function cetak()

		{

			return $this->perms;

		}

		function getAkses()
		{
			$url = $this->ci->uri->segment(1).'/'.$this->ci->uri->segment(2);			
			if ($this->hasPermission($url) === true)
			{
				return true;
			}
			else 
			{
				$this->ci->message->set('notice','Anda Tidak Berhak Mengakses Halaman Ini, Silahkan Hubungi Administrator');
				redirect('dashboard');
			}
		}

	}



?>