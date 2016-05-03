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
echo $tot_wins	=$_POST['tot_wins'];
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
$destination=$_POST['destination'];




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
$petani=mysql_fetch_array(mysql_query("select nm_petani from t4t_petani where kd_petani='$kd_petani'")); //petani [0]
$kd_desa=$lahan['id_desa'];
$desa=mysql_fetch_array(mysql_query("select desa from t4t_desa where id_desa='$kd_desa'")); //desa [0]
$kd_ta=$lahan['kd_ta'];
$ta=mysql_fetch_array(mysql_query("select nama from t4t_tamaster where kd_ta='$kd_ta'")); //ta [0]
$id_lahan=$lahan['id_lahan'];

$silvilkultur=mysql_fetch_array(mysql_query("select jenis_lahan from t4t_typelahan where id_lahan='$id_lahan'")); //silvilkultur [0]
$geo=$no_t4tlahan['koordinat'];
$id_partisipan=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$id_part'"));
//echo $id_partisipan[0];

//no shipment
$date=date("dmy");
$ns_win=mysql_fetch_array(mysql_query("select count(*) from add_htc where no_shipment like '%$date%' and id_part='$id_partisipan[0]' group by id_part"));
    
//insert into t4t_wins
for ($i=1; $i <= $tot_wins ; $i++) { 
	//ambil start wins
	$wins=$start_w-1;
    $win=$wins+$i;
   
    $ns_win2=$ns_win[0]+$i;
    $ns_win2;
	//no - win - no_order - pesen? - used? - unused? - vc? - bl - id_part - no shipment
   
    $query_wins=mysql_query("insert into t4t_wins values ('','$win','$no_order','','','','','$bl','$id_partisipan[0]','$id_partisipan[0]$date$ns_win2')");
}

//insert into t4t_htc
$ns_htc=mysql_fetch_array(mysql_query("select count(*) from add_htc where no_shipment like '%$date%' and id_part='$id_partisipan[0]' group by id_part"));
for ($i=1; $i <= $total_trees ; $i++) { 
	 //no shipment
    $date=date("dmy");
    
    $ns_htc2=$ns_htc[0]+$i;

   //echo $ns_htc2;
//no - bl - tujuan - kd lahan - no lahan - geo - silvilkultur - luas - petani - desa - ta - mu - jml phn - geo 2 - no shipment 
 $query_htc=mysql_query("insert into t4t_htc values ('','$bl','$destination','$kd_lahan','$no_lahan','$geo','$silvilkultur[0]','$luas','$petani[0]',
                       '$desa[0]','$ta[0]','$nama_mu','1','','$id_partisipan[0]$date$ns_htc2')");

}


 $ns=mysql_fetch_array(mysql_query("select count(*) from add_current_tree where no_shipment like '%$date%' and id_part='$id_partisipan[0]' group by id_part"));
//update current tree
for ($i=1; $i <= $total_trees ; $i++) { 
	 //no shipment
    $date=date("dmy");
   
    $ns2=$ns[0]+$i;
    //echo $ns2;

    
	 $query_current_tree_update=mysql_query("update current_tree set used='1',bl='$bl',no_shipment='$id_partisipan[0]$date$ns2' where used='0' and hidup='1' and no_t4tlahan='$land' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' limit 1");
}



header("location:../../admin.php?a1a839ee8e9795202c5ebbcbe25ee83662484a4b355c150b26c3c6c68cde7ef7");

?>