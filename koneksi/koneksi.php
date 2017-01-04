<?php 
$con = mysql_connect("localhost","root","");
if (!$con) {
	die('Cannot Connect'.mysql_error());
}
mysql_select_db("t4t_t4t");

?>
