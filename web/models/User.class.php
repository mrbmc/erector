<?php

class User extends Model {

//	public $user_id = 0;
//	public $user_status;
//	public $user_confirmation;
//	public $user_username;
//	public $user_password;
//	public $user_email;
//	public $user_first_name;
//	public $user_last_name;
//	public $user_address;
//	public $user_address_2;
//	public $user_city;
//	public $user_state;
//	public $user_zipcode;
//	public $user_phone;

	function save ($matchcolumn,$data) {
		return parent::save('user_id',$this->toArray());
	}

	function delete ($matchcolumn,$id) {
		return parent::delete('user_id',$this->toArray());
	}


}


?>
