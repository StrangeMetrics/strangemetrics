<?php
function dashboard_index()
{
   check_login();
	
	$db = db_connect();
	$detections = $db->query('SELECT id, analysis_id, offer_id, affiliate_id, sub_ids, impressions, clicks, conversions, formula_used, created FROM detections WHERE account_id = '.$_SESSION['user']['account_id'].' AND status = "pending" ORDER BY created DESC LIMIT 100');

	if ($detections)
	{
		$detections = $detections->fetch_all(MYSQL_ASSOC);
	}
	
	set ('detections', $detections);
   return render('/dashboard/index.html.php');
}