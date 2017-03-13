<?php
error_reporting(0);
session_start();
include '../koneksi/koneksi.php';
$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$password = md5($password);
// query untuk mendapatkan record dari username
$query = "SELECT * FROM otenuser WHERE uname = '$username'";
$hasil = mysql_query($query);
$data = mysql_fetch_array($hasil);
// cek kesesuaian password
if ($password == $data['passwd'])
{
echo "<div align='center'>
  <font color='green'><strong>Success!</strong></font> Login Successful.
  </div>";
    // menyimpan username dan level ke dalam session
    $_SESSION['level'] = $data['id_grup'];
    $_SESSION['username'] = $data['uname'];
    //Penggunaan Meta Header HTTP
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../admin.php?3ad70a78a1605cb4e480205df880705c">';    
	exit;
}
else 
echo '<div align="center"><font color="red"><strong>Warning!</strong></font> Login Unsuccessful.<br>Please check your username or your password.</div>';

 echo '<META HTTP-EQUIV="Refresh" Content="2; URL=../login/">';


?>
