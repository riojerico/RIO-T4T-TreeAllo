<?php 
ob_start();
include '../../koneksi/koneksi.php';

//for encription
include "../../assets/lib-encript/function.php";


// --------------
//POST from FORM
$id_part	=$_POST['partisipan'];
$no_ship	=$_POST['no_ship']; //no_shipment
$bl			=$_POST['bl']; //bl
$tot_wins	=$_POST['tot_wins'];
$min_allo	=$_POST['min_allo'];
$total_allo	=$_POST['total_allo'];
$ava_allo	=$_POST['ava_allo'];
$nama_mu	=$_POST['mu']; //mu name
$type_trees	=$_POST['type_trees'];
$total_trees=$_POST['total_trees'];
$no_order	=$_POST['no_order'];
$unallocated=$_POST['unallocated'];
$start_w 	=$_POST['start_w'];
$land 		=$_POST['land'];



// if ($_POST['save']) {

//insert into t4t_htc
$id_pohon=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$type_trees'"));
$mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$nama_mu'")); 
$tujuan=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$no_ship'")); //tujuan [0]
$no_t4tlahan=mysql_fetch_array(mysql_query("select no_t4tlahan,koordinat from current_tree where used='0' and hidup='1' and no_t4tlahan='$land' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' limit 1"));
$no=$no_t4tlahan[0];
$lahan=mysql_fetch_array(mysql_query("select * from t4t_lahan where no='$no'"));
$kd_lahan=$lahan['kd_lahan']; //kd_lahan
$no_lahan=$lahan['no_lahan']; //no_lahan
$luas=$lahan['luas_lahan']; //luas
$kd_petani=$lahan['kd_petani'];
$kd_desa=$lahan['id_desa'];
$desa=mysql_fetch_array(mysql_query("select desa from t4t_desa where id_desa='$kd_desa'")); //desa [0]
$petani=mysql_fetch_array(mysql_query("select nm_petani from t4t_petani where kd_petani='$kd_petani' and id_desa='$kd_desa'")); //petani [0]
$kd_ta=$lahan['kd_ta'];
$ta=mysql_fetch_array(mysql_query("select nama from t4t_tamaster where kd_ta='$kd_ta'")); //ta [0]
$id_lahan=$lahan['id_lahan'];

$silvilkultur=mysql_fetch_array(mysql_query("select jenis_lahan from t4t_typelahan where id_lahan='$id_lahan'")); //silvilkultur [0]
$geo=$no_t4tlahan['koordinat'];
$id_partisipan=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$id_part'"));

 $query_htc=mysql_query("insert into t4t_htc values ('','$bl','$tujuan[0]','$kd_lahan','$no_lahan','$geo','$silvilkultur[0]','$luas','$petani[0]',
                         '$desa[0]','$ta[0]','$nama_mu','$total_trees','','$no_ship')");


//insert into t4t_wins
for ($i=1; $i <= $tot_wins ; $i++) { 
	//get the last wins
		// $last_wins=mysql_query("select wins from t4t_wins order by no desc limit 1 ");
		// $last_wins2=mysql_fetch_array($last_wins);
		// $wins=$last_wins2['wins'];
	    // $wins+$i;
	//ambil start wins
	$wins=$start_w-1;
	//echo "<br>";
    $win=$wins+$i;

	//no - win - no_order - pesen? - used? - unused? - vc? - bl - id_part - no shipment
  $id_partisipan[0];

    $query_wins=mysql_query("insert into t4t_wins values ('','$win','$no_order','','','','','$bl','$id_partisipan[0]','$no_ship')");
}

//update current tree
 $query_current_tree_update=mysql_query("update current_tree set used='1',bl='$bl',no_shipment='$no_ship' where used='0' and hidup='1' and no_t4tlahan='$land' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' limit $total_trees");

$item_qty=mysql_fetch_array(mysql_query("select item_qty from t4t_shipment where bl='$bl'"));
$item=$item_qty[0];
// echo "<br>";
$qty_akhir=$item-$total_allo;

 // $query_update_qty_item=mysql_query("update t4t_shipment set item_qty='$qty_akhir' where bl='$bl' ");



header("location:../../admin.php?c3b00eb86cd337880f1639111f2af716061ba997b556a75c89e9bad84f0eb324");



// } //end post save

// if ($_POST['add']) {
// 	 $query_htc=mysql_query("insert into t4t_htc values ('','$bl','$tujuan[0]','$kd_lahan','$no_lahan','$geo','$silvilkultur[0]','$luas','$petani[0]',
//                           '$desa[0]','$ta[0]','$nama_mu','$total_trees','','$no_ship')");

// 	 $query_wins=mysql_query("insert into t4t_wins values ('','$win','$no_order','','','','','$bl','$id_partisipan[0]','$no_ship')");

// 	 $query_current_tree_update=mysql_query("update current_tree set used='1' where used='0' and hidup='1' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' limit $total_trees");

// 		 if ($unallocated>0) {
// 					header("location:../../admin.php?c3b00eb86cd337880f1639111f2af716f86f51ed9f35a9b3ced72f3876350b3c");
// 		 }else
// 		   {
// 				    header("location:../../admin.php?c3b00eb86cd337880f1639111f2af716061ba997b556a75c89e9bad84f0eb324"); //ditambah url untuk sukses nantinya
// 		   }
// }

?>