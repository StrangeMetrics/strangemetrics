<?php

function detections_index($page=0)
{
   check_login();
	
	$limit = 20;
	$offset = $limit * $page;
	
	$db = db_connect();

	$total_items = $db->query('SELECT COUNT(*) AS rows FROM detections WHERE account_id = '.$_SESSION['user']['account_id'].' AND status = "pending"')->fetch_array(MYSQL_ASSOC)['rows'];
	$detections = $db->query('SELECT id, analysis_id, offer_id, affiliate_id, sub_ids, impressions, clicks, conversions, formula_used, created FROM detections WHERE account_id = '.$_SESSION['user']['account_id'].' AND status = "pending" ORDER BY created DESC LIMIT '.$offset.', '.$limit);

	if ($detections)
	{
		$detections = $detections->fetch_all(MYSQL_ASSOC);
	}
	
	set ('total_items', $total_items);
	set ('limit', $limit);
	set ('page', $page);
	set ('detections', $detections);
   return render('/detections/index.html.php');
}

function detections_ignore($id=null)
{
	check_login();
	$db = db_connect();
	
	if ( ! $id)
	{
		return false;
	}
	
	if ($db->query('UPDATE detections SET status = "ignored" WHERE id = '.$id))
	{
		flash ('info', '<p>Detection <code>#'.$id.'</code> ignored.</p>');
		header ('Location: '.$_SERVER['HTTP_REFERER']);
	}
}
