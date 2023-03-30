<?php
header("Content-type: application/json; charset=utf-8");

include_once(dirname(__FILE__).'/../SuperjobAPI.php');
include_once(dirname(__FILE__).'/../apikey.php');


try 
{
	$API = new SuperjobAPI(); //можно и так: SuperjobAPI::instance();
	$API->setSecretKey(CLIENT_SECRET);
	$clients = $API->clients(array('keyword' => 'Газпром', 'page' => 2, 'count' => 5));
	$vacancies = $API->vacancies(array('keyword' => 'php', 'town' => 4, 'page' => 1, 'count' => 5));
	
	$redirect_uri = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}?access=1#oauth";
	
	if (!empty($_REQUEST['contacts']))
	{
		$API->redirectToAuthorizePage(CLIENT_ID,
			$redirect_uri, 'custom_data_value');
	}
	elseif (!empty($_REQUEST['access']))
	{
		$token_info = $API->fetchAccessToken($_REQUEST['code'], $redirect_uri, CLIENT_ID, CLIENT_SECRET);

		$access_token = $token_info['access_token'];
		$API->setAccessToken($access_token);
		
		// Под кем зашёл пользователь?
		$user = $API->current_user();

		$vacancies_with_contacts = $API->vacancies(
					array(
						'keyword' => 'php',
						'count' => 10, 
						't' => array(12, 13)
					)
				);
	}

	echo (json_encode( $vacancies ));
}
catch (SuperjobAPIException $e)
{
	$error = $e->getMessage();
}
