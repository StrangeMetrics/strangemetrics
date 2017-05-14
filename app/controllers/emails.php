<?php

function send_email($to, $subject, $template, $values=[])
{
   $mailgun = new Mailgun\Mailgun(MAILGUN_API_KEY);
   $message = file_get_contents (__DIR__.'/../emails/'.$template.'.txt');
   foreach ($values as $key=>$value)
   {
      $message = str_replace(('{'.$key.'}'), $value, $message);
   }
   $mailgun->sendMessage(MAILGUN_DOMAIN, [
      'from'      => MAIL_FROM,
      'to'        => $to,
      'subject'   => $subject,
      'text'      => $message
   ]);

   return true;
}
