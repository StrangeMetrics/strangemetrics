<?php

function db_connect()
{
   $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
   if ($db)
   {
      return $db;
   }
   return false;
}
