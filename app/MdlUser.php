<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MdlUser extends Model
{
	protected $table = 'users';
	public $timestamps = false;

	function newUser($name,$email,$password){
		
		$user = new MdlUser();
			$user->name = $name;
			$user->email = $email;
			$user->password = $password;
		$user->save();
	}

	function validateUser($email){
		$user = MdlUser::where('email','=',$email)
						->first();

		if(sizeof($user))
			return true;
		else
			return false;					
	}

	function loginUser($email,$password){

		$user = MdlUser::where('email','=',$email)
						->where('password','=',$password)
						->first();
		
		if(sizeof($user)){
			$user = $user->toArray();
			return $user['id'];
		}else
			return 0;
	}

	function lastUser(){
		$user = MdlUser::all()->last();
		return $user->toArray();
	}
}