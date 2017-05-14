<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/vendor/limonade.php';
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
dispatch('/settings/integrations', 'settings_integrations');
dispatch('/settings/integrations/add', 'settings_integrations_add');
dispatch('/settings/emails', 'settings_emails');

run();
