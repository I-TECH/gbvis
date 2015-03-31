<?php
require_once 'UserTools.class.php';
require_once 'DB.class.php';


class User {

	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $user_group;
	public $hashedPassword;
	public $email;
	public $mobile_phone;
	public $sector;
	public $joinDate;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data){
		$this->id = (isset($data['id'])) ? $data['id'] : "";
		$this->firstname = (isset($data['firstname'])) ? $data['firstname'] : "";
		$this->lastname = (isset($data['lastname'])) ? $data['lastname'] : "";
		$this->username = (isset($data['username'])) ? $data['username'] : "";
		$this->user_group = (isset($data['user_group'])) ? $data['user_group'] : "";
		$this->hashedPassword = (isset($data['password'])) ? $data['password'] : "";
		$this->email = (isset($data['email'])) ? $data['email'] : "";
		$this->mobile_phone = (isset($data['mobile_phone'])) ? $data['mobile_phone'] : "";
		$this->sector = (isset($data['sector'])) ? $data['sector'] : "";
		$this->joinDate = (isset($data['join_date'])) ? $data['join_date'] : "";
	}
	

	public function save($isNewUser = false) {
		//create a new database object.
		$db = new DB();
		
		//if the user is already registered and we're
		//just updating their info.
		if(!$isNewUser) {
			//set the data array
			$data = array(
			    "firstname" => "'$this->firstname'",
				"lastname" => "'$this->lastname'",
				"username" => "'$this->username'",
				"user_group" => "$this->user_group",
				"password" => "'$this->hashedPassword'",
				"email" => "'$this->email'",
				"mobile_phone" => "'$this->mobile_phone'",
				"sector" => "'$this->sector'"
				
			);
			
			//update the row in the database
			$db->update($data, 'users', 'id = '.$this->id);
		}
		else {
		//if the user is being registered for the first time.
			$data = array(
			    "firstname" => "'$this->firstname'",
				"lastname" => "'$this->lastname'",
				"username" => "'$this->username'",
				"user_group" => "'$this->user_group'",
				"password" => "'$this->hashedPassword'",
				"email" => "'$this->email'",
				"mobile_phone" => "'$this->mobile_phone'",
				"sector" => "'$this->sector'",
				"join_date" => "'".date("Y-m-d H:i:s",time())."'"
			);
			
			$this->id = $db->insert($data, 'users');
			$this->joinDate = time();
		}
		return true;
	}
	
}

?>