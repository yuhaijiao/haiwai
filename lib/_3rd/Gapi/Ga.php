<?php
namespace Lib\_3rd\Gapi;
class Ga {
	const client_login_url = 'https://www.google.com/accounts/ClientLogin';
	//const account_data_url = 'https://www.google.com/analytics/feeds/accounts/default';
	const account_data_url = 'https://www.googleapis.com/analytics/v2.4/management/accounts/~all/webproperties/~all/profiles';
	const report_data_url = 'https://www.google.com/analytics/feeds/data';
	const interface_name = 'GAPI-1.3';
	
	private $auth_token = null;
	
	private function getAuthToken(){
		
	}
	
	private function 
}