<?php

function cases_create_from_detection($detection_id)
{
	check_login();
	$db = db_connect();
	
	// Create a case from a detection
	$detection = $db->query('SELECT offer_id, affiliate_id, sub_ids, analysis_id, impressions, clicks, conversions FROM detections WHERE id = '.$detection_id.' AND account_id = '.$_SESSION['user']['account_id'].' LIMIT 1')->fetch_array(MYSQL_ASSOC);
	if ($detection)
	{
		if ($db->query('INSERT INTO cases (account_id, offer_id, affiliate_id, sub_ids, analysis_id, status, created) VALUES ('.$_SESSION['user']['account_id'].', '.$detection['offer_id'].', '.$detection['affiliate_id'].', '.$detection['sub_ids'].', '.$detection['analysis_id'].', "open", "'.date('Y-m-d H:i:s').'")'))
		{
			$case_id = $db->insert_id;
			
			// Update detection
			$db->query('UPDATE detections SET status = "processed", case_id = '.$case_id.' WHERE id = '.$detection_id);
			
			flash ('success', '<p>Case <code>#'.$case_id.'</code> created successfully.</p>');
			header ('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	return false;
}

function cases_index()
{
	check_login();
	$db = db_connect();
	
	$cases = $db->query('SELECT id, offer_id, affiliate_id, sub_ids, analysis_id, status, created FROM cases WHERE account_id = '.$_SESSION['user']['account_id'].' ORDER BY id DESC');
	if ($cases)
	{
		$cases = $cases->fetch_all(MYSQL_ASSOC);
	}
	
	set ('cases', $cases);
	return render('/cases/index.html.php');
}