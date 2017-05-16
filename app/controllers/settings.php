<?php

function settings_index()
{
	check_login();
	
   $db = db_connect();
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		$settings = $_POST['settings'];
		if ( ! $settings['aws_key'] || ! $settings['aws_secret'] || ! $settings['aws_bucket'])
		{
			flash ('errors', '<p>Please complete all fields.</p>');
		} else {
			
			foreach ($settings as $key=>$value)
			{
				$query = 'INSERT INTO settings (account_id, object, `key`, `value`) VALUES ';
				$query.= '('.$_SESSION['user']['account_id'].', "global", "'.$key.'", "'.$value.'") ';
				$query.= 'ON DUPLICATE KEY UPDATE `value` = "'.$value.'"';
				$db->query($query);
			}
			flash ('success', '<p>Settings updated correctly.</p>');
		}
	} else {
		
		$settings = [
			'aws_key' => '', 
			'aws_secret' => '',
			'aws_bucket' => ''
		];
		
		// Load settings from DB
		$db_settings = $db->query('SELECT `key`, `value` FROM settings WHERE account_id = '.$_SESSION['user']['account_id'].' AND object = "global"');
		if ($db_settings)
		{
			$result = $db_settings->fetch_all(MYSQL_ASSOC);
			foreach ($result as $row)
			{
				$settings[$row['key']] = $row['value'];
			}
		}
	}
	
	set('settings', $settings);
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
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		$integration = $_POST['app'];
		if ( ! $integration['name']
			|| ! $integration['settings']['network_id']
			|| ! $integration['settings']['api_key']
			)
		{
			flash ('errors', '<p>Please complete all fields.</p>');
		} else {
			
			$db = db_connect();
			
			$query = 'INSERT INTO tracking_platforms (account_id, platform, name, status, created) VALUES ';
			$query.= '('.$_SESSION['user']['account_id'].', "'.$integration['platform'].'", "'.$integration['name'].'", "'.$integration['status'].'", "'.date('Y-m-d H:i:s').'")';
			
			if ($db->query($query) )
			{
				$integration['id'] = $db->insert_id;

				$query = 'INSERT INTO settings (account_id, object, entity_id, `key`, `value`) VALUES ';
				foreach ($integration['settings'] as $key=>$value)
				{
					$query.= '('.$_SESSION['user']['account_id'].', "tracking_platform", '.$integration['id'].', "'.$key.'", "'.$value.'"), ';
				}

				$db->query(substr($query, 0, -2));
				
				flash ('success', '<p>Integration saved successfully.</p>');
				header('Location: '.url_for('/settings/integrations'));
			} else {
				flash('errors', '<p>Error creating integration.</p>');
			}
		}
	}
	
	return render('/settings/integrations_add.html.php');
}

function settings_integrations_edit($id)
{
	$db = db_connect();
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		$integration = $_POST['app'];
		if ( ! $integration['name']
			|| ! $integration['settings']['network_id']
			|| ! $integration['settings']['api_key']
			)
		{
			flash ('errors', '<p>Please complete all fields.</p>');
		} else {
			
			if ($db->query('UPDATE tracking_platforms SET name = "'.$integration['name'].'", status = "'.$integration['status'].'", platform = "'.$integration['platform'].'", updated = "'.date('Y-m-d H:i:s').'" WHERE id = '.$id))
			{
				// Update settings
				foreach ($integration['settings'] as $key=>$value)
				{
					$db->query('UPDATE settings SET value = "'.$value.'" WHERE account_id = '.$_SESSION['user']['account_id'].' AND object = "tracking_platform" AND entity_id = '.$id.' AND `key` = "'.$key.'"');
				}
				flash ('success', '<p>Integration updated successfully.</p>');
			} else {
				flash ('errors', '<p>Error updating integration.</p>');
			}
		}
	}
	
	$query = 'SELECT tp.id, tp.name, tp.platform, tp.status, s.key, s.value FROM tracking_platforms tp LEFT JOIN settings s ON s.object = "tracking_platform" AND s.entity_id = tp.id WHERE tp.id = '.$id;
	$result = $db->query( $query );
		
	if ($result)
	{
		$result = $result->fetch_all(MYSQL_ASSOC);
		$integration = [
			'id' => $result[0]['id'],
			'name' => $result[0]['name'],
			'status' => $result[0]['status'],
			'platform' => $result[0]['platform'],
			'settings' => []
		];
		
		foreach ($result as $s)
		{
			$integration['settings'][$s['key']] = $s['value'];
		}
	} else {
		flash ('errors', '<p>Error searching for integration.</p>');
		header ('Location: '.$_SERVER['HTTP_REFERER']);
	}

	set ('integration', $integration);
	return render('/settings/integrations_edit.html.php');
}

function settings_emails()
{
	check_login();
	
	return render('/settings/emails.html.php');
}