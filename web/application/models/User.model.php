<?php

class User extends Model {

	public $id = 0;
	public $status;
	public $confirmation;
	public $username;
	public $password;
	public $email;
	public $first_name;
	public $last_name;
	public $address;
	public $address_2;
	public $city;
	public $state;
	public $zipcode;
	public $phone;

	function save ($_matchcolumn='id',$_data=null) {
		return parent::save($_matchcolumn,$this->toArray());
	}

	function delete ($matchcolumn,$id) {
		return parent::delete('id',$this->toArray());
	}


}


?>
