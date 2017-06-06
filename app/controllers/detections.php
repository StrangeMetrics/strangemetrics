<?php

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
