<?php

use Aws\S3\S3Client;

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

function analysis_cron()
{
	// Public function
	$db = db_connect();
	
	// Get next analysis to get the report
	$analysis = $db->query('SELECT a.id, a.account_id, a.formula, tp.id AS tp_id, tp.platform FROM analysis a LEFT JOIN tracking_platforms tp ON tp.id = a.tracking_platform_id WHERE a.status = "on" AND ((a.last_run IS NULL) OR (TIMEDIFF(NOW(), a.last_run) > a.run_every_hours)) ORDER BY a.last_run ASC LIMIT 1');

	if ($analysis)
	{
		$analysis = $analysis->fetch_array(MYSQL_ASSOC);
		$settings = [];
		
		// Get analysis settings
		$analysis_settings = $db->query('SELECT `key`, `value` FROM settings WHERE account_id = '.$analysis['account_id'].' AND object = "analysis" AND entity_id = '.$analysis['id']);
		if ($analysis_settings)
		{
			$analysis_settings = $analysis_settings->fetch_all(MYSQL_ASSOC);
			foreach ($analysis_settings as $as)
			{
				$settings['analysis'][$as['key']] = $as['value'];
			}
			$settings['analysis']['id'] = $analysis['id'];
			$settings['analysis']['platform'] = $analysis['platform'];
		}

		// Get platform settings
		$platform_settings = $db->query('SELECT `key`, `value` FROM settings WHERE account_id = '.$analysis['account_id'].' AND object = "tracking_platform" AND entity_id = '.$analysis['tp_id']);
		
		if ($platform_settings)
		{
			$platform_settings = $platform_settings->fetch_all(MYSQL_ASSOC);
			foreach ($platform_settings as $ps)
			{
				$settings['platform'][$ps['key']] = $ps['value'];
			}
			
			switch ($settings['analysis']['platform'])
			{
				case 'hasoffers':
				
					// Load platform API manager
					$client = new DevIT\Hasoffers\Client($settings['platform']['api_key'], $settings['platform']['network_id']);
					
					// Pull the report
					$report = $client->api('Brand\Report');
					$data = [
						'fields' => ['Stat.payout', 'Stat.revenue', 'Stat.conversions', 'Stat.ltr', 'Stat.clicks', 'Stat.ctr', 'Stat.impressions', 'Stat.affiliate_info2', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.advertiser_id'], 
						'groups' => ['Stat.affiliate_info2', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.advertiser_id'], 
						'data_start' => date('Y-m-d'), 
						'data_end' => date('Y-m-d'), 
						'sort' => ['Stat.conversions' =>'desc'],
						'limit' => 10000
					];
					
					try {
						$response = json_encode($report->getStats($data));
					} catch (DevIT\Hasoffers\Exception $e)
					{
						echo($e->getMessage());
					}
				break;
			}
			
			// Persist it in S3
			$s3_db = $db->query('SELECT `key`, `value` FROM settings WHERE account_id = '.$analysis['account_id'].' AND object = "global" AND (`key` = "aws_bucket" OR `key` = "aws_key" OR `key` = "aws_secret") LIMIT 3');
			if ($s3_db)
			{
				$s3_db = $s3_db->fetch_all(MYSQL_ASSOC);
				foreach ($s3_db as $row)
				{
					$settings['s3'][$row['key']] = $row['value'];
				}
			}
			
			$s3 = new S3Client([
				'version' => 'latest',
				'region'  => 'us-east-1', 
				'credentials' => [
					'key' => $settings['s3']['aws_key'],
					'secret' => $settings['s3']['aws_secret']
				]
			]);
			
			try {
				$path = date('Y-m-d').'/'.$settings['analysis']['id'].'_'.time().'.log';
				$s3->putObject([
					'Bucket' => $settings['s3']['aws_bucket'],
					'Key'    => $path,
					'Body'   => $response,
					'ACL'    => 'public-read'
				]);
			} catch (Aws\S3\Exception\S3Exception $e) {
			    echo "There was an error uploading the file.\n";
				 echo $e;
			}
			
			// Save report path
			$db->query('INSERT INTO reports (analysis_id, created, url) VALUES ('.$analysis['id'].', "'.date('Y-m-d H:i:s').'", "'.$path.'")');

			// Update last run date
			$db->query('UPDATE analysis SET last_run = "'.date('Y-m-d H:i:s').'" WHERE id = '.$analysis['id']);
			
			// Apply formula to rows and save detections
			$report = json_decode($response, true);
			foreach ($report['response']['data']['data'] as $row)
			{
				$values = [
					$row['Stat']['impressions'], 
					$row['Stat']['ctr'], 
					$row['Stat']['clicks'], 
					$row['Stat']['ltr'], 
					$row['Stat']['conversions'], 
					$row['Stat']['payout'], 
					$row['Stat']['revenue']
				];
				
				$eval = eval_formula($analysis['formula'], $values);
				if ($eval)
				{
					$db->query('INSERT INTO detections (analysis_id, created, offer_id, affiliate_id, sub_ids, impressions, clicks, conversions, status, formula_used) VALUES ('.$analysis['id'].', "'.date('Y-m-d H:i:s').'", '.$row['Stat']['offer_id'].', '.$row['Stat']['affiliate_id'].', '.$row['Stat']['affiliate_info2'].', '.$row['Stat']['impressions'].', '.$row['Stat']['clicks'].', '.$row['Stat']['conversions'].', "pending", "'.$analysis['formula'].'") ON DUPLICATE KEY UPDATE SET formula_used = "'.$analysis['formula'].'", status = "pending", impressions = '.$row['Stat']['impressions'].', clicks = '.$row['Stat']['clicks'].', conversions = '.$row['Stat']['conversions'].', updated = "'.date('Y-m-d H:i:s').'"');
				}
			}
		}
	}
}

function eval_formula($formula, $values)
{
	// TODO: Sanitize values in $formula
	$macros = ['{impressions}', '{ctr}', '{clicks}', '{cr}', '{conversions}', '{payout}', '{revenue}'];
	$formula = 'if('.str_replace($macros, $values, $formula).') { return true; } else { return false; }';
	return eval($formula);
}