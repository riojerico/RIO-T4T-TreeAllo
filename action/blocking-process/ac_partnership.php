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
$iddesa     =$_POST['desa'];
$idpetani   =$_POST['petani'];
$note       =$_POST['note'];
$win_num    =$_POST['win_num'];
date_default_timezone_set('Asia/Jakarta');
$datetime	= date("Y-m-d H:i:s"); 


$id_pohon=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$type_trees'"));
$mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$nama_mu'")); 
$tujuan=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$no_ship'")); //tujuan [0]
$no_t4tlahan=mysql_fetch_array(mysql_query("select no_t4tlahan,koordinat from current_tree where used='0' and hidup='1' and kd_mu='$mu[0]' and koordinat!='' and no_t4tlahan='$land' limit 1"));
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
$date=date("Y-m-d");

    
//update current tree
$ns=mysql_fetch_array(mysql_query("select count(*) from add_current_tree where time like '%$date%' and id_part='$id_partisipan[0]' group by id_part"));
for ($i=1; $i <= 1 ; $i++) { 
     //no shipment
    $date=date("Y-m-d");
   
   $ns2=$ns[0]+$i;
    
     $query_current_tree_update=mysql_query("update current_tree set used='1',bl='$bl',no_shipment='$no_ship',time='1111-11-11' where used='0' and hidup='1' and kd_mu='$mu[0]' and koordinat!='' and no_t4tlahan='$land' limit $total_trees");
}


//insert into t4t_wins
$ex_win=explode(",", $win_num);
$ex_win2=count($ex_win);

$a=0;
$c=0;
$hasil=array();
while ( $a < $ex_win2) {
  
    for ($i=0; $i < 1 ; $i++) { 
        $isi = explode("-", $ex_win[$a]);
        $start=$isi[0];
        if (!$isi[1]) {
            $end=$isi[0];
        }else {
            $end=$isi[1];
        }

        $hasil=trim($start);
        
        for ($i=$start; $i <= $end ; $i++) { 
            //no - win - no_order - pesen? - used? - unused? - vc? - bl - id_part - no shipment - time
            $query_wins=mysql_query("insert into t4t_wins values ('','$hasil','$no_order','','','','','$bl','$id_partisipan[0]','$no_ship','$date')");

            $hasil++;
        }

       
    }

$a++;    
}


//insert into t4t_htc
    //no - bl - tujuan - kd lahan - no lahan - geo - silvilkultur - luas - petani - desa - ta - mu - jml phn - geo 2 - no shipment - time
   $query_htc=mysql_query("insert into t4t_htc values ('','$bl','$tujuan[0]','$kd_lahan','$no_lahan','$geo','$silvilkultur[0]','$luas','$petani[0]','$desa[0]','$ta[0]','$nama_mu','$total_trees','','$no_ship','$date')");


$date=date("Y-m-d");
//update current_tree kedua
$query_current_tree_update2=mysql_query("update current_tree set time='$date' where bl='$bl' and no_shipment='$no_ship' and time='1111-11-11'");

//update t4t_shipment
if ($note=="") {
    
}else {
     $query_shipment=mysql_query("update t4t_shipment set note='$note' where no_shipment='$no_ship'");
}

   

header("location:../../admin.php?3964ad8ca07227dec234962092ef676c4b7497d6f82e256c83ca11d154eeb94a");




?>