<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/* Nomenclatura para rutas */
/*
 * ----------------------------------------------
 * Nomenclature pathnames
 *
 * Languages
 *
 * This route define the path to request languages and their response
 *
 * app_lang_req/{code} this request the lang code
 * the controller Lang define all contrl actions
 *

 Route::get('/', function () {
    return view('welcome');
});
 * */

	/*Controllers*/
	Route::post('newUser', 'CtrUser@newUser');
	Route::get('lastUser', 'CtrUser@lastUser');
	Route::post('loginUser', 'CtrUser@loginUser');

	/*Views*/
	Route::get('/', function(){
		return view('login');
	});

	Route::get('/home', function(){
		return view('home');
	});

	Route::get('app_lang_req/{code}', 	'Lang@app_lang_req');
	Route::get('app_lang_req/{code}/{version}', 	'Lang@app_lang_update');
	
	/*** CLON RAUL ARROYO ****/ 
	Route::get('app_lang_reqs/{code}', 	'Lang@app_lang_reqs');
	Route::get('app_lang_reqs/{code}/{version}', 	'Lang@app_lang_updates');
	
	
	/* * * Interests list * * */
	Route::get('app_data_interests_cat/{code_lang}', 'Interests@app_data_interests_cat');
	Route::get('app_data_interests_det/{code_lang}/{id_interests}', 'Interests@app_data_interests_det');
	Route::get('app_data_interests_gen', 'Interests@app_data_interests_gen'); 
	
	/* Countries catalog */
	Route::get('app_countries_cat', 	'Countries@app_countries_list');

	/*Base Controller*/
	Route::post('decode_profile_image/',		'Base@decode_profile_image');

	/*Sign Controller*/

	Route::post('app_sign_up',		'Sign@app_sign_up');
	Route::post('search_tag',		'Sign@search_tag');
	Route::post('tag_list',		'Sign@tag_list');
	Route::post('check_email',		'Sign@check_email');

	//Route::post('prueba',		'Prueba@prueba');
	/***Cards Service***/

	Route::post('create_card', 'Cards@create_card');
	Route::get('prueba/{code}',		'Images@obtain_image');
	Route::get('obtain_image/{route}',		'Cards@obtain_image');
	Route::post('create_kartomi_card',		'Cards@create_kartomi_card');
	Route::post('search_card',		'Cards@search_card');
	Route::post('create_new_card',		'Cards@create_new_card');
	Route::post('card_preview',		'Cards@card_preview');
	Route::post('search_cards_by_user',		'Cards@search_cards_by_user');
	Route::post('edit_card',		'Cards@edit_card');
	Route::post('data_card',		'Cards@data_card');
	Route::any('list_design',		'Cards@list_design');
	
	/* * * LOGIN SERVICES * * */ 
	// Route::get('auth/login', 'Auth\AuthController@getLogin'); // Para Web
	Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
	Route::post('auth/fblogin', ['as' =>'auth/fblogin', 'uses' => 'Auth\AuthController@fbpostLogin']);
	Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);
	Route::post('auth/psswrd_rcvr', ['as' => 'auth/psswrd_rcvr', 'uses' => 'Auth\AuthController@psswrd_update']);
	
	
	/** Listado de compañias **/ 
	Route::post('new_company',		'Companies@new_company');
	Route::any('app_companies_list',		'Companies@app_companies_list');
		
	/** Servicio que devuelve el listadode de contactos tomando como referencia el id_usuario **/ 
	Route::get('app_contacts_user/{id_user}', 'Contacts@app_contacts_list');
	Route::post('app_contacts_add/{id_user_send}/{id_user_receiver}/{language_code}', 'Contacts@app_contacts_add');
	Route::post('app_contacts_search/{id_user_send}/{language_code}', 'Contacts@app_contacts_search');
	Route::post('app_contacts_list_g/{id_user_send}/{language_code}', 'Contacts@app_contacts_list_g');				
	Route::post('app_contacts_search/{id_user_send}/{language_code}', 'Contacts@app_contacts_search');
	Route::post('app_contacts_block/{id_user_send}/{id_user_receiver}/', 'Contacts@app_contacts_block');
	Route::post('shared_contacts_list', 'Contacts@shared_contacts_list');
	

	/* Servicios para los meetings */ 
	Route::post('app_meetings_new/{id_user}', 'Meetings@new_meeting');
	Route::post('app_meeting_list/{id_user}', 'Meetings@app_meetings_user_list');
	Route::post('app_meeting_list_member/{id_user}', 'Meetings@app_meeting_user_list_members');
	
	
	
	


	/***CALENDAR***/

	Route::post('new_user_schedule', 'Calendar@new_user_schedule');
	Route::post('schedule_details', 'Calendar@schedule_details');
	Route::any('event_cat_list', 'Calendar@event_cat_list');
	Route::post('search_schedules_by_user', 'Calendar@search_schedules_by_user');
	Route::post('search_schedules_by_month', 'Calendar@search_schedules_by_month');
	Route::post('search_schedules_today', 'Calendar@search_schedules_today');
	Route::post('search_schedules_this_week', 'Calendar@search_schedules_this_week');
	Route::post('search_specific_month', 'Calendar@search_specific_month');
	Route::post('search_schedules_specific_day', 'Calendar@search_schedules_specific_day');
	Route::post('schedules_by_specific_month', 'Calendar@schedules_by_specific_month');
	

	Route::get('app_profile/{id_user}', 'Profile@app_profile_dateail');
	Route::post('app_profile_update/{id_user}', 'Profile@app_profile_update');
	
	
	Route::get('app_images/{directory}/{image}', 'Images@app_images_path');
	



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
