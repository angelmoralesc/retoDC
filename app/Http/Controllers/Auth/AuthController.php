<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;


use DB;
use Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
	
	
	
	/**
	 * use validator 
	 */
	 public function postLogin(Request $request)
	 {

		$email 			= $_POST['usrkrtm_name'];
		$password 		= $_POST['krtm_passGuord'];
		$app_key		= $_POST['app_key'];
		$gpsCoordinates	= $_POST['gps_coordinates'];
		$lang_code 		= @$_POST['language_code'];
		

		// Validate email & password not empty 		
		if(!$email || !$password)
		{			
			if(!$email)
			{
				$code_id = 22;
			}
			elseif(!$password)
			{
				$code_id = 23;
			}
			
			$qr_mssg = DB::table('app_data_messages_view') -> 
						where('id_code', '=', $code_id) ->
						where('code_language', '=', $lang_code) ->
						get();
			$mssg = $qr_mssg[0] -> message;

			return response() -> json(['success' => false, 'error' => $mssg]); 
			
		}
		else
		{
			$qr_usr = DB::table('app_users') ->  
				where('username', '=', $email) -> 
				where('password', '=', $password) -> first();
				
				
				// print_r($qr_usr);

			 if(!$qr_usr)
			 {
			 	$code_id = 24; 
				$qr_mssg = DB::table('app_data_messages_view') -> 
							where('id_code', '=', $code_id) ->
							where('code_language', '=', $lang_code) ->
							get();
				$mssg = $qr_mssg[0] -> message;

				return response() -> json(['success' => false, 'error' => $mssg]); 
			 }
			 else
			 {
				$qr_usrdata 	= DB::table('app_users_data_personal') -> 
						where('app_users_data_personal.id_user', '=', $qr_usr -> id) -> 
						join('app_users_data_settings', 'app_users_data_settings.id_user', '=','app_users_data_personal.id_user') -> 							
						join('app_data_languages_cat', 'app_users_data_settings.id_language', '=', 'app_data_languages_cat.id') -> 
						select('app_users_data_personal.id_user AS idUser', 
						'app_users_data_personal.name AS name',
						'app_users_data_personal.email AS email',
						'app_users_data_personal.lastname AS lastName',
						'app_users_data_personal.id_country AS countryId', 
						'app_users_data_personal.zipcode AS zipCode',
						'app_users_data_personal.phone AS phoneNumber',
						'app_users_data_personal.university AS college',
						'app_users_data_personal.gender', 
						'app_users_data_personal.date_birthday AS birthday', 
					    'app_users_data_personal.title',
					    'app_users_data_personal.quote',
					    'app_users_data_personal.about AS aboutMe', 
						'app_data_languages_cat.name AS language_name',  
						'app_data_languages_cat.code AS language_code') -> get();
		
		
				
		
					$qr_interests 	= DB::table('app_users_interests') -> 
							where('app_users_interests.id_user', '=',  $qr_usr -> id) -> 
							join('app_data_interests_view', 'app_data_interests_view.id', '=', 'app_users_interests.id_interests') -> 
							select('app_data_interests_view.id AS id', 'app_data_interests_view.name AS interests_name')
							-> get();
		
		
					$qr_tags 	= DB::table('app_users_tags') -> 
								where('app_users_tags.id_user', '=', $qr_usr -> id) ->
								join('app_data_tags_cat', 'app_data_tags_cat.id', '=', 'app_users_tags.id_tag') -> 
		
								select('app_data_tags_cat.id', 'app_data_tags_cat.name') ->
								get();
								
								
								// print_r($qr_usrdata);
								
		
		

					$obj 					= (array)$qr_usrdata[0];
					$obj['tags'] 			= $qr_tags;
					$obj['interestsIds'] 	= $qr_interests;
					$output = (object)$obj;

				$json_resp = array('success' => true,
								'object' => $obj);
								
								
				Session::put('id_user', $qr_usr -> id);
				
				$hoy = Carbon::today();
				
				$objdt 					= (array)$hoy;
				
							
				
				$insert_a = array('id_user' => $qr_usr -> id,
									
									'token_expiration' 		=> '9999-12-31 23:59:59',
									'useragent'				=> $_SERVER['HTTP_USER_AGENT'],
									'ip_address'			=> $_SERVER['REMOTE_ADDR'],
									'gps_coordinates'		=> $gpsCoordinates, 
									'date'					=> str_replace('.000000', '', $objdt['date'])
									);
				
				DB::table('app_users_session') -> insert($insert_a);
		
								
			 }
 


			// GUARDAR SESIONES -> app_users_session
			/*
			 * id_user  						= $qr_usr -> id
			 * token	varchar(100)
			 * token_expiration	datetime		= '9999-99-99 23:59:59'
			 * useragent	varchar(255)	
			 * ip_address	varchar(39)			$_SERVER['REMOTE_ADDR']
			 * mac_address	char(17)		
			 * gps_coordinates	varchar(18)		$gpsCoordinates
			 * hostname	varchar(63)
			 * device	varchar(50)				
			 * operating_system	varchar(20)		
			 * operating_system_version	varchar(6)
			 * date datetime 
			 *
		
			 * 			 
 
			 *  
			*/
			// echo csrf_token();


			return response()->json($json_resp);
		}
		
		
		
	 }


	public function psswrd_update(Request $request)
	{
		// email 
		// nuevo password 
		// echo 'RECUPERA PASSWORD';
		
		$data = $request -> input(); 
		$id_user 			= strtolower(utf8_encode($data['object']["idUser"]));
		$oldPassword        = (utf8_encode($data['object']["psswrd"]));
		$newPassword        = (utf8_encode($data['object']["nwpsswrd"]));
		$elmail 			= strtolower(utf8_encode($data['object']["email"]));
		

		$lang_code			= (($data['object']["language_code"]));
		
		
		// VALIDAMOS LA EXISTENCIA DEL email EN UNA SOLA PASADA 
		
		
		if( $elmail )
		{
			$qr = DB::table('app_users') 				->
				where('username', '=', $elmail) 		-> 
				where('password', '=', $oldPassword) 	->
				where('id', '=', $id_user) 	->
				get();
				

				
				if( $qr ) // SI el id USER y EL email no coinciden 
				{
					if($qr[0] -> password == $newPassword)
					{
							$code_id = 37; 
							$qr_mssg = DB::table('app_data_messages_view') -> 
										where('id_code', '=', $code_id) ->
										where('code_language', '=', $lang_code) ->
										get();
										
							$mssg = $qr_mssg[0] -> message;
							return response() -> json(['success' => false, 'error' => $mssg]);
							break;
					}
					else 
					{
						if($qr[0] -> id == $id_user) // SI EL IDE USER DE BASE Y EL QUE SOLICITAN CAINCIDEN 
						{
							DB::table('app_users') 		-> 
							where('id', '=', $id_user) 	-> 
							update(['password' => $newPassword]);
	
						 	$code_id = 32; 
							$qr_mssg = DB::table('app_data_messages_view') -> 
										where('id_code', '=', $code_id) ->
										where('code_language', '=', $lang_code) ->
										get();
										
							
							
										
	
										
							$mssg = $qr_mssg[0] -> message;
							return response() -> json(['success' => true, 'message' => $mssg]); 
							break;
							
						}
						else {
						 	$code_id = 29; 
							$qr_mssg = DB::table('app_data_messages_view') -> 
										where('id_code', '=', $code_id) ->
										where('code_language', '=', $lang_code) ->
										get();
							$mssg = $qr_mssg[0] -> message;
			
							return response() -> json(['success' => false, 'error' => $mssg ]); 
							break;
						}
					}
				}
				else
				{
				 	$code_id = 24; 
					$qr_mssg = DB::table('app_data_messages_view') -> 
								where('id_code', '=', $code_id) ->
								where('code_language', '=', $lang_code) ->
								get();
					$mssg = $qr_mssg[0] -> message;
	
					return response() -> json(['success' => false, 'error' => $mssg]); 
					
					break;
				}
		}
		else {
				 	$code_id = 22; 
					$qr_mssg = DB::table('app_data_messages_view') -> 
								where('id_code', '=', $code_id) ->
								where('code_language', '=', $lang_code) ->
								get();
					$mssg = $qr_mssg[0] -> message;
	
					return response() -> json(['success' => false, 'error' => $mssg]); 
					break;
		}
		
		
		
		/*
       "appKey":"iYhH07rfV5aXve2ardH3MB4haLcnzjbV", 
       "idUser": 66,
       "email": "test@test.com", 
       "psswrd": "ElNuevoPassword",
       "isFacebook": true,
       "idFacebook": 111000222333,
       "language_code": es-mx
		 * */
		
		
	}
	

         public function fbpostLogin(Request $request)
         {

                // app_data_screen = scr_Login

                /*
                echo '<pre>';
                        print_r($_POST);
                echo '</pre>';
                */


                // $email                  = $_POST['usrkrtm_name'];
                // $password               = $_POST['krtm_passGuord'];
                $app_key            = $_POST['app_key'];
                $id_facebook 		= $_POST['id_facebook'];
				$gpsCoordinates 	= $_POST['gps_coordinates'];
				$lang_code 			= $_POST['language_code'];

                // $data = array('username' => $email, 'password' => $password) ;

                // $validator = $this -> validator($data);

                // Validate email & password not empty
                if(!$id_facebook)
                {
                        // Validar e mail . . .

                        // return response() -> json(['success' => false, 'message' => 'usuariono registrado']);
                        // Query para obtener de la vista de mensajes los errores . . .
                        
				 	$code_id = 22; 
					$qr_mssg = DB::table('app_data_messages_view') -> 
								where('id_code', '=', $code_id) ->
								where('code_language', '=', $lang_code) ->
								get();
					$mssg = $qr_mssg[0] -> message;
					// Query para obtener de la vista de mensajes los errores . . .
					return response() -> json(['success' => false, 'error' => $mssg]); 
                        
                        

                }
                else
                {
                        // Busca usuario|password y crea sesión . . .
                        // $qr_usr = ;

                        // echo $email . ' ' . $password . ' ' . $app_key . '  ' . $gpsCoordinates      ;
                        $qr_usrf = DB::table('app_users') ->
                                where('id_facebook', '=', $id_facebook) -> first();
					 if(!$qr_usrf)
					 {
					 	
					 	//return response() -> json(['success' => false, 'message' => 'Wrong Facebook account']);
						
						$code_id = 24; 
						$qr_mssg = DB::table('app_data_messages_view') -> 
									where('id_code', '=', $code_id) ->
									where('code_language', '=', $lang_code) ->
									get();
						$mssg = $qr_mssg[0] -> message;
						// Query para obtener de la vista de mensajes los errores . . .
						return response() -> json(['success' => false, 'error' => $mssg]); 
						
						
					 }
					 else
					 {
		
						// app_users_data_personal
						// join -> app_users_data_settings
						// join -> app_users_interests
						// join -> app_users_socialnetwork
			
						$qr_usrdata 	= DB::table('app_users_data_personal') -> 
								where('app_users_data_personal.id_user', '=', $qr_usrf -> id) -> 
								join('app_users_data_settings', 'app_users_data_settings.id_user', '=','app_users_data_personal.id_user') -> 
								join('app_data_languages_cat', 'app_users_data_settings.id_language', '=', 'app_data_languages_cat.id') -> 
								
			
								 select('app_users_data_personal.id_user AS idUser', 
								'app_users_data_personal.name AS name',
								'app_users_data_personal.lastname AS lastName',
								'app_users_data_personal.email AS email',
								'app_users_data_personal.id_country AS countryId', 
								'app_users_data_personal.zipcode AS zipCode',
								'app_users_data_personal.phone AS phoneNumber',
								'app_users_data_personal.university AS college',
								'app_users_data_personal.gender', 
								'app_users_data_personal.date_birthday AS birthday', 
							        'app_users_data_personal.title',
							        'app_users_data_personal.quote',
							        'app_users_data_personal.about AS aboutMe', 
								'app_data_languages_cat.name AS language_name',  'app_data_languages_cat.code AS language_code') -> get();
			
			
					
			
						$qr_interests 	= DB::table('app_users_interests') -> 
								where('app_users_interests.id_user', '=',  $qr_usrf -> id) -> 
								join('app_data_interests_view', 'app_data_interests_view.id', '=', 'app_users_interests.id_interests') -> 
								select('app_data_interests_view.id AS id', 'app_data_interests_view.name AS interests_name')
								-> get();
			
			
						$qr_tags 	= DB::table('app_users_tags') -> 
									where('app_users_tags.id_user', '=', $qr_usrf -> id) ->
									join('app_data_tags_cat', 'app_data_tags_cat.id', '=', 'app_users_tags.id_tag') -> 
			
									select('app_data_tags_cat.id', 'app_data_tags_cat.name') ->
									get();
									
			
			
						$obj 					= (array)$qr_usrdata[0];
						$obj['tags'] 			= $qr_tags;
						$obj['interestsIds'] 	= $qr_interests;  // array("title" => "Asignación de Autores por obra");
						$output = (object)$obj;
			
						// Hacer los insert para los historiales . . . 
						 
			
							$json_resp = array('success' => true,
											'object' => $obj);
					 }
 







                        return response()->json($json_resp);
                }



         }



	

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

?>