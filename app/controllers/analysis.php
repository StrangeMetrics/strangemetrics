<?php

function analysis_index()
{
	check_login();
	$db = db_connect();

	$analysis = $db->query('SELECT tp.id AS tracking_platform_id, tp.name AS tracking_platform, a.id, a.name, a.last_run, a.status, a.run_every_hours FROM analysis a LEFT JOIN tracking_platforms tp ON tp.id = a.tracking_platform_id WHERE a.account_id = '.$_SESSION['user']['account_id']);

	if ($analysis)
	{
		$analysis = $analysis->fetch_all(MYSQL_ASSOC);
	}
	
	set ('analysis', $analysis);
	return render('/analysis/index.html.php');
	
}

function analysis_new()
{
	check_login();
	
	$db = db_connect();
	$tracking_platforms = $db->query('SELECT id, name FROM tracking_platforms WHERE status = "on" AND account_id = '.$_SESSION['user']['account_id'])->fetch_all(MYSQL_ASSOC);
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		$analysis = $_POST['analysis'];
		if ( ! $analysis['name'] || ! $analysis['run_every_hours'] || ! $analysis['formula'])
		{
			flash ('errors', '<p>Please complete all required fields.</p>');
		} else {
			
			if ($db->query('INSERT INTO analysis (account_id, tracking_platform_id, name, created, run_every_hours, status, formula) VALUES ('.$_SESSION['user']['account_id'].', '.$analysis['tracking_platform_id'].', "'.$analysis['name'].'", "'.date('Y-m-d H:i:s').'", '.$analysis['run_every_hours'].', "'.$analysis['status'].'", "'.$analysis['formula'].'")'))
			{
				$analysis['id'] = $db->insert_id;
				
				foreach ($analysis['settings'] as $key=>$value)
				{
					$db->query('INSERT INTO settings (account_id, object, entity_id, `key`, `value`) VALUES ('.$_SESSION['user']['account_id'].', "analysis", '.$analysis['id'].', "'.$key.'", "'.$value.'")');
				}
				flash ('success', '<p>Analysis created correctly.</p>');
				header ('Location: '.url_for('/analysis'));
			}
		}
	} else {
		$analysis = [
			'tracking_platform_id' => '', 
			'name' => '', 
			'run_every_hours' => '', 
			'formula' => '', 
			'status' => 'on', 
			'settings' => [
				'report_type' => 'get_stats',
				'filter_categories' => '', 
				'filter_offers' => ''
			]
		];
	}
	
	set ('analysis', $analysis);
	set ('tps', $tracking_platforms);
	return render('/analysis/new.html.php');
}

function analysis_edit($id)
{
	check_login();
	$db = db_connect();
	
	$tracking_platforms = $db->query('SELECT id, name FROM tracking_platforms WHERE status = "on" AND account_id = '.$_SESSION['user']['account_id'])->fetch_all(MYSQL_ASSOC);
	
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		$analysis = $_POST['analysis'];
		$analysis['id'] = $id;
		
		if ( ! $analysis['name'] || ! $analysis['run_every_hours'] || ! $analysis['formula'])
		{
			flash ('errors', '<p>Please complete all required fields.</p>');
		} else {
			
			if ($db->query('UPDATE analysis SET tracking_platform_id = '.$analysis['tracking_platform_id'].', name = "'.$analysis['name'].'", updated = "'.date('Y-m-d H:i:s').'", run_every_hours = '.$analysis['run_every_hours'].', status = "'.$analysis['status'].'", formula = "'.$analysis['formula'].'" WHERE id = '.$id))
			{
				foreach ($analysis['settings'] as $key=>$value)
				{
					$db->query('UPDATE settings SET `value` = "'.$value.'" WHERE account_id = '.$_SESSION['user']['account_id'].' AND object = "analysis" AND entity_id = '.$id.' AND `key` = "'.$key.'"');
				}
				flash ('success', '<p>Analysis updated correctly.</p>');
			}
		}
	} else {
		$query = 'SELECT a.id, a.name, a.run_every_hours, a.formula, a.status, a.tracking_platform_id, s.key, s.value FROM analysis a LEFT JOIN settings s ON s.entity_id = a.id AND a.account_id = '.$_SESSION['user']['account_id'].' WHERE s.account_id = '.$_SESSION['user']['account_id'].' AND s.object = "analysis" AND a.id = '.$id;
	
		$rows = $db->query($query)->fetch_all(MYSQL_ASSOC);
	
		$analysis = [
			'id' => $rows[0]['id'],
			'tracking_platform_id' => $rows[0]['tracking_platform_id'], 
			'name' => $rows[0]['name'], 
			'run_every_hours' => $rows[0]['run_every_hours'], 
			'formula' => $rows[0]['formula'], 
			'status' => $rows[0]['status'], 
		];
		foreach ($rows as $row)
		{
			$analysis['settings'][$row['key']] = $row['value'];
		}
	}
	
	set ('analysis', $analysis);
	set ('tps', $tracking_platforms);
	
	return render('/analysis/edit.html.php');
	
}