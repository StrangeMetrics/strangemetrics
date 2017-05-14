<?php

function settings_index()
{
	check_login();
	
   $db = db_connect();
	
	// settings scheleton
	$settings = [
		'hasoffers_network_id' => '',
		'hasoffers_api_key' => '',
		'mailgun_api_key' => ''
	];
	
	// Load settings from DB
	$db_settings = $db->query('SELECT key, value FROM settings WHERE account_id = '.$_SESSION['user']['account_id'].' AND object = "global"');
	if ($db_settings)
	{
		$settings = $db_settings;
	}

	set(compact('settings'));
	return render ('/settings/index.html.php');
}

function settings_integrations()
{
	check_login();
	
	$db = db_connect();
	
	$integrations = $db->query('SELECT id, platform, name, status FROM tracking_platforms WHERE account_id = '.$_SESSION['user']['account_id'])->fetch_all(MYSQL_ASSOC);
	
	set('integrations', $integrations);
	return render ('/settings/integrations.html.php');
}

function settings_integrations_add()
{
	return render('/settings/integrations_add.html.php');
}

function settings_emails()
{
	check_login();
	
	return render('/settings/emails.html.php');
}