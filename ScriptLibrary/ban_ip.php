<?php
/* List with IPs */
$ban_ip_list = array('37.115.191.78',
					 '37.144.32.2',
	  				 '41.142.246.185',
	  				 '46.118.158.95',
					 '69.64.48.172',
					 '93.93.152.2',
	  				 '176.10.104.234',
					 '197.157.255.130');
 
/* List with IP ranges. Use the '*' as the range selector */
$ban_ip_range = array('188.143.232.*');
 
/* Visitor's IP Address */
$user_ip = $_SERVER['REMOTE_ADDR'];
 
/* Message to output if the IP is in the ban list */
$msg = 'You do not have permission to access this page.';
 
/* Message to output if the IP is in the ban list */
 
    if(in_array($user_ip, $ban_ip_list))
    {
      exit($msg);
    }
 
/* Check if the Visitor's IP is in our range's list */
 
if(!empty($ban_ip_range))
{
foreach($ban_ip_range as $range)
{
    $range = str_replace('*','(.*)', $range);
 
    if(preg_match('/'.$range.'/', $user_ip))
    {
      exit($msg);
    }
}
}
?>