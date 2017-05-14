<?php

// APPLICATION

define('APP_NAME', 'Strange Metrics'); // Used in public places
define('APP_DOMAIN', 'app.strangemetrics.org');

// MYSQL
if (isset($_ENV['STAGE']) && $_ENV['STAGE']=='prod')
{

   //
   // PRODUCTION
   //

   define('DBHOST', '');
   define('DBNAME', '');
   define('DBUSER', '');
   define('DBPASS', '');

}
elseif (isset($_ENV['STAGE']) && $_ENV['STAGE']=='dev') {

   // development

   define('DBHOST', '');
   define('DBNAME', '');
   define('DBUSER', '');
   define('DBPASS', '');

}
else {

   // localhost

   define('DBHOST', 'localhost');
   define('DBNAME', 'strangemetricsorg');
   define('DBUSER', 'root');
   define('DBPASS', 'root');

}

// S3
define('AWSACCESSKEY', '');
define('AWSSECRETKEY', '');

// MAILGUN
define('MAILGUN_API_BASE_URL', '');
define('MAILGUN_API_KEY', '');
define('MAILGUN_DOMAIN', '');
define('MAIL_FROM', '');

// SECURITY
define('SALT', 'o30ofIU&TVRCILVBuPA7aVv2cK12rSfWXugfg1ptUdJOY0');

// VIEWS
define('LAYOUT', 'app_layout.html.php');

function before($route)
{
   if (isset($_ENV['STAGE']) && ($_ENV['STAGE']=='dev' || $_ENV['STAGE']=='prod'))
   {
		define('SITE_URI', 'http://app.strangemetrics.org');
      option('base_uri', '/');
   } else {
		define('SITE_URI', '');
      option('base_uri', '');
   }

   if (check_login(false))
   {
      set('section', substr($route['callback'], 0, strpos($route['callback'], '_')));
      set('sub', substr($route['callback'], (strpos($route['callback'], '_')+1)));
   }
   layout(LAYOUT);

}
