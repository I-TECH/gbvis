<?php

require_once 'DB.class.php';

class UserLogin {

	public function get_sector($sector)
	{
		$db = new DB();
		$result = $db->select('users', "sector= $sector");
		
		return new sector($result);
	}
	
}

?>