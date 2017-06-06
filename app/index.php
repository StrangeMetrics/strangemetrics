<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/limonade.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/database/mysql.php';

dispatch('/', 'dashboard_index');

dispatch('/login', 'users_login');
	dispatch_post('/login', 'users_login');
dispatch('/signup', 'users_signup');
	dispatch_post('/signup', 'users_signup');
dispatch('/reset_password', 'users_reset_password');
	dispatch_post('/reset_password', 'users_reset_password');
dispatch('/signout', 'users_logout');

dispatch('/settings', 'settings_index');
	dispatch_post('/settings', 'settings_index');
dispatch('/settings/integrations', 'settings_integrations');
dispatch('/settings/integrations/add', 'settings_integrations_add');
	dispatch_post('/settings/integrations/add', 'settings_integrations_add');
dispatch('/settings/integrations/:id', 'settings_integrations_edit');
	dispatch_post('/settings/integrations/:id', 'settings_integrations_edit');
dispatch('/settings/emails', 'settings_emails');
	dispatch_post('/settings/emails', 'settings_emails');

dispatch('/analysis/cron', 'analysis_cron');
dispatch('/analysis', 'analysis_index');
dispatch('/analysis/new', 'analysis_new');
	dispatch_post('/analysis/new', 'analysis_new');
dispatch('/analysis/:id', 'analysis_edit');
	dispatch_post('/analysis/:id', 'analysis_edit');

dispatch('/detections/ignore/:id', 'detections_ignore');

run();