<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::post('home/proposal/search', 'HomeController@searchProposal');
Route::get('/home', 'HomeController@index');

Route::post('dpd/delete', 'DpdController@destroy');
Route::resource('dpd', 'DpdController');


Route::post('deleteUser', 'UserController@destroy');
	//Block Administrator DPP
	Route::get('user-dpp/{id}/edit', 'UserController@edit');
	Route::get('user-dpp/create', 'UserController@createUserDpp');
	Route::get('user-dpp', 'UserController@indexUserDpp');
	//ENDAdministrator DPP

	//Block Administrator DPD
	Route::get('user-dpd/{id}/edit', 'UserController@edit');
	Route::get('user-dpd/create', 'UserController@createUserDpd');
	Route::get('user-dpd', 'UserController@indexUserDpd');
	//ENDBlock Administrator DPD

	//Block Member
	Route::post('member/import', 'UserController@postImport');
	Route::get('member/import', 'UserController@getImport');
	Route::get('member/{id}/edit', 'UserController@edit');
	Route::get('member/create','UserController@create');
	Route::get('member/{id}', 'UserController@show');
	Route::get('member', 'UserController@index');
	//ENDBlock Member
Route::post('user/password/change', 'UserController@chagePassword');
Route::post('user/deletephoto', 'UserController@deletephoto');
Route::post('user/uploadphoto', 'UserController@uploadphoto');
Route::resource('user', 'UserController');

//Proposal
Route::post('proposal/import', 'ProposalController@postImport');
Route::get('proposal/import', 'ProposalController@getImport');
Route::post('proposal/fileCompletion', 'ProposalController@fileCompletion');
Route::post('deleteProposal', 'ProposalController@destroy');
Route::post('proposal/deletefile','ProposalController@deletefile');
Route::post('proposal/changestatus','ProposalController@changestatus');
Route::get('proposal/downloadfile','ProposalController@downloadfile');
Route::post('proposal/uploadfile', 'ProposalController@uploadfile');
Route::resource('proposal', 'ProposalController');
//EndProposal


//Configuration
	//Proposal "Equalization"
	Route::post('configuration/proposal/equalization', 'ConfigurationController@saveEqualizationProposal');
	Route::get('configuration/proposal/equalization', 'ConfigurationController@getEqualizationProposal');
	//Proposal "NEW"
	Route::post('configuration/proposal/new', 'ConfigurationController@saveNewProposal');
	Route::get('configuration/proposal/new', 'ConfigurationController@getNewProposal');
	//Proposal "EXTENSION"
	Route::post('configuration/proposal/extension', 'ConfigurationController@saveExtensionProposal');
	Route::get('configuration/proposal/extension', 'ConfigurationController@getExtensionProposal');

	//Role
	Route::post('configuration/role/update-permission', 'RoleController@updatePermission');
	Route::get('configuration/role/{id}', 'RoleController@show');
	Route::get('configuration/role', 'RoleController@index');
	//Permission
	Route::post('configuration/permission/store', 'PermissionController@store');
	Route::get('configuration/permission/create', 'PermissionController@create');
	Route::get('configuration/permission/{id}', 'PermissionController@show');
	Route::get('configuration/permission', 'PermissionController@index');


//Datatables
Route::controller('datatables', 'DatatablesController',[
	'getDpds'=>'datatables.getDpds',
	'getUserDpps'=>'datatables.getUserDpps',
	'getUserDpds'=>'datatables.getUserDpds',
	'getMembers'=>'datatables.getMembers',
	'getMembersOfDpd'=>'datatables.getMembersOfDpd',
	'getProposals'=>'datatables.getProposals',
	'getProposals_1'=>'datatables.getProposals_1',
	'getProposals_2'=>'datatables.getProposals_2',
	'getProposals_3'=>'datatables.getProposals_3',
	'getProposals_9'=>'datatables.getProposals_9',
	'getProposals_on_process'=>'datatables.getProposals_on_process',
	'getProposalRekapitulasi'=>'datatables.getProposalRekapitulasi',
	'getRoles'=>'datatables.getRoles',
	'getPermissions'=>'datatables.getPermissions',
]);

//Profile
Route::post('profile/change-password', 'ProfileController@changePassword');
Route::resource('profile', 'ProfileController');

//Select2
Route::get('select2User', 'Select2Controller@select2User');
Route::get('select2UserFromCreateProposal', 'Select2Controller@select2UserFromCreateProposal');

Route::get('select2Dpd', 'Select2Controller@select2Dpd');
Route::get('select2DpdFromCreateProposal', 'Select2Controller@select2DpdFromCreateProposal');

Route::get('template/proposal', 'TemplateController@proposal');
Route::get('template/member', 'TemplateController@member');
Route::resource('template', 'TemplateController');