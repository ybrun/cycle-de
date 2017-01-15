<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cyclede = "dmiccorpglde.mysql.db";
$database_cyclede = "dmiccorpglde";
$username_cyclede = "dmiccorpglde";
$password_cyclede = "Password7";
$cyclede = mysql_pconnect($hostname_cyclede, $username_cyclede, $password_cyclede) or trigger_error(mysql_error(),E_USER_ERROR); 
?>