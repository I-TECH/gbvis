<?php
require_once 'User.class.php';
require_once 'DB.class.php';

class UserTools {

	//Log the user in. First checks to see if the 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	
	
	
	public function login($username, $password)
	{
	      
		$hashedPassword = md5($password);
		$result = mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'");

		if(mysql_num_rows($result) == 1)
		{
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			return true;
		}else{
			return false;
		}
	}
	
	
	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION["user"]);
		unset($_SESSION["login_time"]);
		unset($_SESSION["logged_in"]);
		session_destroy();
	}

	//Check to see if a username exists.
	//This is called during registration to make sure all user names are unique.
	public function checkUsernameExists($username) {
		$result = mysql_query("select id from users where username='$username'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//Check to see if a username exists with email.
	//This is called during registration to make sure all user names are unique.
	public function checkEmailExists($email) {
	    $result = mysql_query("select id from users where email='$email'");
	    if(mysql_num_rows($result) == 0)
	    {
	        return false;
	    }else{
	        return true;
	    }
	}
	//Check to see if a token exists.
	//This is called during password recovery to ensure the password recovery token exists.
	public function checkPasswordRecoveryTokenExists($token) {
		$result = mysql_query("select id from users where hash_token='$token'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//get a user
	//returns a User object. Takes the users id as an input
	public function get($id)
	{
		$db = new DB();
		$result = $db->select('users', "id = $id");
		
		return new User($result);
	}
	//get a user group
	//returns a User group  object. Takes the users group  id as an input
	public function get_usergroup($user_group)
	{
		$db = new DB();
		$result = $db->select('users', "user_group= $user_group");
		
		return new user_group($result);
	}
	
	public function isGuest($user_group)
	{
		if($user_group == 3)
		{
		
		return true;
		}
	}
	
	public function isSuperAdmin($user_group)
	{
		if($user_group == 1)
		{
		
		return true;
		}
	}
	public function isAdmin($user_group)
	{
		if($user_group == 2)
		{
		
		return true;
		}
	}
	//enter user reset password hash token
	public function set_reset_password_token($email, $username, $token)
	{
	       
		$result = mysql_query("UPDATE users set hash_token ='$token' where email='$email' and username = '$username'");
	    if($result)
	    {
	        return true;
	    }else{
	        return false;
	    }
	}
	//enter user reset password hash token
	public function update_user_password($token, $password)
	{
	    $password = md5($password);   
		$result = mysql_query("UPDATE users set password ='$password', hash_token = '' where hash_token='$token'");
	    if($result)
	    {
	        return true;
	    }else{
	        return false;
	    }
	}
	///Sector
	
	public function get_sector($sector)
	{
	       
		$db = new DB();
		$result = $db->select('users', "sector= $sector");
		
		 return new sector($result);
	}
	
	public function ngec($sector)
	{
		if($sector == 0)
		{
		
		return true;
		}
	}
	
	public function judiciary($sector)
	{
		if($sector == 1)
		{
		
		return true;
		}
	}
	public function health($sector)
	{
		if($sector == 2)
		{
		
		return true;
		}
	}
	public function police($sector)
	{
		if($sector == 3)
		{
		
		return true;
		}
	}
	public function prosection($sector)
	{
		if($sector == 4)
		{
		
		return true;
		}
	}
	public function education($sector)
	{
		if($sector == 5)
		{
		
		return true;
		}
	}
	public function community($sector)
	{
		if($sector == 7)
		{
		
		return true;
		}
	}
	public function social_services($sector)
	{
		if($sector == 6)
		{
		
		return true;
		}
	}
}

?>
