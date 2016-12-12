<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\MdlUser;

class CtrUser extends Controller{

	function newUser(Request $request){

		$name      = $request->input('name');
		$email     = $request->input('email');
		$password  = base64_encode($request->input('password'));

		if(!with(new MdlUser)->validateUser($email)){
			with(new MdlUser)->newUser($name,$email,$password);
			$result = array("success"=>true);
		}else
			$result = array("success" => false);

		return response()->json($result);	
		
	}

	function loginUser(Request $request){

		$email     = $request->input('email');
		$password  = base64_encode($request->input('password'));

		$id = with(new MdlUser)->loginUser($email,$password);

		$result = array("id" => $id);

		return response()->json($result);
	}

	function lastUser(){
		
		$user = with(new MdlUser)->lastUser();

		return response()->json($user);
	}

}
		