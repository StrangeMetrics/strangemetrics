<?php

function users_signup()
{

   $user = ['email'=>''];

   if ($_SERVER['REQUEST_METHOD']=='POST')
   {
      $user = $_POST['user'];

      // Validation
      if (
      ! $user['email']
      || ! $user['password']
      || strlen($user['password']) < 6
      ) {
         flash('errors', 'Please complete all fields.');
      } else {
			
         // Continue account and user creation
         $db = db_connect();
			
			// Check if user doesn't exit
			$db_user = $db->query('SELECT id FROM users WHERE email = "'.$user['email'].'" LIMIT 1');
			if ($db_user->num_rows>0)
			{
				flash ('errors', 'This email already has an account created.');
			} else {
				
	         // Start with account
	         if ($db->query('INSERT INTO accounts (created) VALUES ("'.date('Y-m-d H:i:s').'")'))
	         {
	            $account['id'] = $db->insert_id;
	            if ($db->query('INSERT INTO users (account_id, is_account_owner, status, email, password, created) VALUES ('.$account['id'].', 1, "on", "'.$user['email'].'", "'.gen_password($user['password']).'", "'.date('Y-m-d H:i:s').'")'));
	            {

	               send_email(
	                  $user['email'],
	                  'Welcome to StrangeMetrics',
	                  'signup',
	                  [
	                     'validation_url' => 'http://'.APP_DOMAIN.url_for('/validate/'.gen_validation($db->insert_id))
	                  ]
	               );

	               flash ('success', 'Thank you! We sent you an email with instructions to proceed.');
	               header ('Location: '.url_for('/login'));
	               exit;
	            }
	            flash ('errors', 'Error creating user.');
	         }
	         flash ('errors', 'Error creating account.');
				
			}
      }
   }

   set('user', $user);
   layout('login_layout.html.php');
   return render('/users/signup.html.php');
}

function users_validate($hashed_user_id=null)
{
   if ( ! $hashed_user_id)
   {
      flash ('errors', 'Error on validation URL.');
      header ('Location: '.url_for('/login'));
      exit;
   }
   $user_id = de_gen_validation($hashed_user_id);
   $db = db_connect();
   if ($db->query ('UPDATE users SET email_is_verified = 1 WHERE id = '.$user_id))
   {
      flash ('success', 'Your email has been validated.');
      header ('Location: '.url_for('/login'));
   }
}

function users_login()
{
   $login = ['email'=>'', 'password'=>''];
   if ($_SERVER['REQUEST_METHOD']=='POST')
   {
      $db = db_connect();
      $login = $_POST['user'];
      if (
         ! $login['email']
         || ! $login['password']
      ) {
         flash ('errors', 'Please complete your credentials.');
      } else {
         if ($user_result = $db->query('SELECT users.id, users.account_id, users.email, users.password, users.email_is_verified, users.status FROM users JOIN accounts ON users.account_id = accounts.id WHERE users.email = "'.$login['email'].'" LIMIT 1'))
         {
            $user = $user_result->fetch_array(MYSQL_ASSOC);
            if ($user['password']==gen_password($login['password']))
            {
               if ($user['email_is_verified']==1 && $user['status']=="on")
               {
                  $_SESSION['user'] = [
                     'id' => $user['id'],
                     'email' => $user['email'],
                     'account_id' => $user['account_id']
                  ];

                  $db->query('UPDATE users SET last_login = "'.date('Y-m-d H:i:s').'", last_login_ip = "'.$_SERVER['REMOTE_ADDR'].'" WHERE id = '.$user['id']);
                  return header ('Location: '.url_for('/'));

               } else {
                  flash ('errors', 'Either your email is not verified, or your user was disabled.');
               }
            } else {
               flash ('errors', 'Your email and/or password are wrong.');
            }
         } else {
            flash ('errors', 'Your email and/or password are wrong.');
         }
      }
   }
   set ('login', $login);
   layout('login_layout.html.php');
   return render('/users/login.html.php');
}

function users_logout()
{
   unset ($_SESSION['user']);
   header('Location: '.url_for('/login'));
   return true;
}

function users_reset_password()
{
   $user = ['email'=>''];
   if ($_SERVER['REQUEST_METHOD']=='POST')
   {
      $user = $_POST['user'];
      if (
      ! $user['email']
      ) {
         flash ('errors', 'Please enter your email.');
      } else {
         $db = db_connect();
         if ($result = $db->query('SELECT id, email, created, last_login, last_login_ip FROM users WHERE email = "'.$user['email'].'" LIMIT 1')->fetch_array(MYSQL_ASSOC))
         {
            if ($result['email']==$user['email'])
            {
               $token = gen_password($result['last_login'].$result['created'].$result['email'].$result['last_login_ip']);
               send_email(
                  $user['email'],
                  'Reset your StrangeMetrics password',
                  'reset',
                  [
                     'reset_url' => 'http://'.APP_DOMAIN.'/update_password/'.$token
                  ]
               );
               flash('success', 'An email has been sent to that email address.');
            }
         } else {
            flash ('errors', 'Sorry, we can\'t find that email.');
         }
      }
   }
   set ('user', $user);
   layout('login_layout.html.php');
   return render('/users/reset_password.html.php');
}

function users_update_password($token=null)
{
   if ( ! $token)
   {
      header ('Location: '.url_for('/reset_password'));
      exit;
   }

   $user = ['email'=>'', 'token'=>$token];

   if ($_SERVER['REQUEST_METHOD']=='POST')
   {
      $user = array_merge($user, $_POST['user']);
      if (
      ! $user['email']
      || ! $user['password']
      || strlen($user['password']) < 6
      ) {
         flash ('errors', 'Please complete all fields');
      } else {
         $db = db_connect();
         if ($user_db = $db->query('SELECT id, email, created, last_login, last_login_ip FROM users WHERE email = "'.$user['email'].'" LIMIT 1')->fetch_array(MYSQL_ASSOC))
         {
            $token_db = gen_password($user_db['last_login'].$user_db['created'].$user_db['email'].$user_db['last_login_ip']);
            if ($token==$token_db)
            {
               if ($db->query('UPDATE users SET password = "'.gen_password($user['password']).'" WHERE id = '.$user_db['id']))
               {
                  flash ('success', 'Password updated correctly.');
                  header ('Location: '.url_for('/login'));
               } else {
                  flash ('errors', 'Error updating password.');
               }
            } else {
               flash ('errors', 'Invalid token.');
            }
         } else {
            flash ('errors', 'Sorry, we can\'t find that email.');
         }
      }
   }

   set('user', $user);
   layout('login_layout.html.php');
   return render('/users/update_password.html.php');
}

function users_me()
{
   check_login();
   $db = db_connect();
   if ($_SERVER['REQUEST_METHOD']=='POST')
   {
      $user = $_POST['user'];
      if (isset($user['password']) && strlen($user['password']) > 6)
      {
         // Update password and send email
         if ($db->query('UPDATE users SET updated = "'.date('Y-m-d H:i:s').'", password = "'.gen_password($user['password']).'" WHERE id = '.$_SESSION['user']['id']))
         {
            send_email(
               $_SESSION['user']['email'],
               'Your password has been updated',
               'password_updated',
               [
                  'ip' => $_SERVER['REMOTE_ADDR']
               ]
            );
            flash ('success', 'Password updated.');
         }
      } else {
         flash ('errors', 'Password must be complete and at least 6 characters long.');
      }
   }
   $result = $db->query('SELECT email, last_login, last_login_ip FROM users WHERE id = '.$_SESSION['user']['id']);
   if ($result)
   {
      set('user', $result->fetch_array(MYSQL_ASSOC));
   }
   return render('/users/me.html.php');
}

function gen_password($string)
{
   return md5($string.SALT);
}

function gen_validation($string)
{
   return base64_encode($string);
}

function de_gen_validation($string)
{
   return base64_decode($string);
}

function check_login($redirect = true, $account_id=null)
{
   if ( ! isset($_SESSION['user']) || ! $_SESSION['user'])
   {
      if ($redirect)
      {
         header ('Location: '.url_for('/login'));
      }
      return false;
   }
   if (isset ($account_id) && $_SESSION['user']['account_id']!=$account_id)
   {
      if ($redirect)
      {
         header ('Location: '.url_for('/login'));
      }
      return false;
   }
   return true;
}

function check_admin()
{
   if ($_SESSION['user']['type']=='admin')
   {
      return true;
   }
   header('Location: '.url_for('/logout'));
   exit;
}
