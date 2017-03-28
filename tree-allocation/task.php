<?php
	session_start();
	include '../koneksi/koneksi.php';

	$no_shipment = 'MF006432012';
	$wins_used 	 = mysql_fetch_array(mysql_query("SELECT wins_used from t4t_shipment where no_shipment='$no_shipment'"));
	$_SESSION['jml_sesi'] = 0;
	$jml_sesi 	 = $_SESSION['jml_sesi'];
	$pecah 		= explode(",", $wins_used[0]);
	$jml_pecah  = count($pecah);
	echo $jml_pecah.'<br><br>';
	for ($i=0; $i < $jml_pecah ; $i++) {
		$pecah_2 = explode("-", $pecah[$i]);
		//echo $pecah_2[1].'<br>';
		//jika memenuhi tanda (-)
		if (isset($pecah_2[1])) {
			  for ($j=$pecah_2[0]; $j <= $pecah_2[1] ; $j++) {
	             echo $n = $j." ";
	             $cek_win = mysql_fetch_array(mysql_query("SELECT wins from t4t_wins where wins='$j'"));
	             if ($cek_win==true) {
	               echo "true";
	               $jml_sesi=$jml_sesi+1;
	             }else{
	             	echo "false";
	             }
	          }
		}else{
			echo $j=$pecah_2[0];
			$cek_win = mysql_fetch_array(mysql_query("SELECT wins from t4t_wins where wins='$j'"));
			if ($cek_win==true) {
	               echo "true";
	             }else{
	             	echo "false";
	             }
		}
	}


  //echo $jml_sesi;
?>
