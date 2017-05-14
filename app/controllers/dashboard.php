<?php
function dashboard_index()
{
   check_login();
   return render('/dashboard/index.html.php');
}
