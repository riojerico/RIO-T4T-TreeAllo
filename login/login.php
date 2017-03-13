<?php
error_reporting(0);
session_start();
include '../koneksi/koneksi.php';
$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$password = md5($password);
// query untuk mendapatkan record dari username
$query = "SELECT * FROM otenuser WHERE uname = '$username' ";
$hasil = mysql_query($query);
$data = mysql_fetch_array($hasil);

date_default_timezone_set('Asia/Jakarta');
$waktu    = date("d/m/Y - h:i:sa");
// cek kesesuaian password
if ($password == $data['passwd'] && $data['id_grup']=='adm')
{
echo "<div align='center'>
  <font color='green'><strong>Success!</strong></font> Login Successful.
  </div>";
    // menyimpan username dan level ke dalam session
    $_SESSION['level'] = $data['id_grup'];
    $_SESSION['username'] = $data['uname'];
    $_SESSION['id'] = $data['id'];
    $_SESSION['jml_sesi']=0;
    $_SESSION['start_login']=$waktu;
    $id=$_SESSION['id'];
    $user=mysql_fetch_array(mysql_query("select uname from otenuser where id='$id'"));
    $_SESSION['user']=$user[0];
    //Penggunaan Meta Header HTTP
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../admin.php?3ad70a78a1605cb4e480205df880705c">';    
	exit;
}
elseif ($password == $data['passwd'] && $data['id_grup']=='mkt')
{
echo "<div align='center'>
  <font color='green'><strong>Success!</strong></font> Login Successful.
  </div>";
    // menyimpan username dan level ke dalam session
    $_SESSION['level'] = $data['id_grup'];
    $_SESSION['username'] = $data['uname'];
    $_SESSION['id'] = $data['id'];
    $_SESSION['jml_sesi']=0;
    $_SESSION['start_login']=$waktu;
    $id=$_SESSION['id'];
    $user=mysql_fetch_array(mysql_query("select uname from otenuser where id='$id'"));
    $_SESSION['user']=$user[0];
    //Penggunaan Meta Header HTTP
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../admin.php?3ad70a78a1605cb4e480205df880705c">';    
	exit;
}
else 
echo '<div align="center"><font color="red"><strong>Warning!</strong></font> Login Unsuccessful.<br>Please check your username or your password.</div>';

 echo '<META HTTP-EQUIV="Refresh" Content="2; URL=../login/">';


?>
