<?php
error_reporting(0);
ob_start();
include '../../koneksi/koneksi.php';

//for encription
include "../../assets/lib-encript/function.php";

// --------------
//POST from FORM
$id_part	    =$_POST['partisipan'];
$no_ship	    =$_POST['no_ship']; //no_shipment
$bl			      =$_POST['bl']; //bl
$tot_wins	    =$_POST['tot_wins'];
$min_allo	    =$_POST['min_allo'];
$total_allo	  =$_POST['total_allo'];
$win_num	    =$_POST['win_num'];
$nama_mu	    =$_POST['mu']; //mu name
$type_trees	  =$_POST['type_trees'];
$total_trees  =$_POST['total_trees'];
$no_order	    =$_POST['no_order'];
$unallocated  =$_POST['unallocated'];
$start_w 	    =$_POST['start_w'];
$land 		    =$_POST['land'];
$log          =$_POST['log'];

date_default_timezone_set('Asia/Jakarta');
$datetime	= date("Y-m-d H:i:s");


$id_pohon=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$type_trees'"));
$mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$nama_mu'"));
$tujuan=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$no_ship'")); //tujuan [0]
$no_t4tlahan=mysql_fetch_array(mysql_query("select no_t4tlahan,koordinat from current_tree where used='0' and hidup='1' and kd_mu='$mu[0]' and koordinat!='' limit $total_trees"));
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
$z=1;
$select_current_tree=mysql_query("select count(*) as jml_pohon,kd_mu from add_jmlpohon_lahan where used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 group by kd_mu");

while ( $load=mysql_fetch_array($select_current_tree)) {

   $kdman_unit   =$_POST['kdman_unit'.$z];
   $alokasi_pohon=$_POST['alokasi_pohon'.$z];

   $query_current_tree_update=mysql_query("update current_tree set used='1',bl='1111-11-11',no_shipment='$no_ship' where used='0' and hidup='1' and kd_mu='$kdman_unit' and koordinat!='' limit $alokasi_pohon");

$z++;
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
            //no - win - no_order - pesen? - used? - unused? - vc? - bl - id_part - no shipment - time - log user - type
            $query_wins=mysql_query("insert into t4t_wins values ('','$hasil','$no_order','','','','','$bl','$id_partisipan[0]','$no_ship','$date','$log','1')");

            $hasil++;
        }


    }

$a++;
}





//insert into t4t_htc
$k=1;
while ($k <= 1 ) {

$data_lahan=mysql_query("select * from current_tree where bl='1111-11-11' and no_shipment='$no_ship' group by no_t4tlahan");

$i=1;
while ( $data=mysql_fetch_array($data_lahan)) {
    $no_lahan2      =$data['no_t4tlahan'];
    $get_lahan      =mysql_fetch_array(mysql_query("select * from t4t_lahan where no='$no_lahan2'"));
    $kd_lahan2      =$get_lahan['kd_lahan'];
    $geo2           =$data['koordinat'];
    $kd_sil         =$get_lahan['id_lahan'];
    $silvilkultur2  =mysql_fetch_array(mysql_query("select jenis_lahan from t4t_typelahan where id_lahan='$kd_sil'"));
    $luas2          =$get_lahan['luas_lahan'];
    $kd_ptn         =$get_lahan['kd_petani'];
    $kd_ds          =$get_lahan['id_desa'];
    $desa2          =mysql_fetch_array(mysql_query("select desa from t4t_desa where id_desa='$kd_ds'"));
    $petani2        =mysql_fetch_array(mysql_query("select nm_petani from t4t_petani where kd_petani='$kd_ptn' and id_desa='$kd_ds'"));
    $kdta           =$get_lahan['kd_ta'];
    $ta2            =mysql_fetch_array(mysql_query("select nama from t4t_tamaster where kd_ta='$kdta'"));
    $kdman_unit0    =$get_lahan['kd_mu'];
    $kdman_unit     =mysql_fetch_array(mysql_query("select nama from t4t_mu where kd_mu='$kdman_unit0'"));
    $a=mysql_query("select count(*) from current_tree where bl='1111-11-11' and no_shipment='$no_ship' group by no_t4tlahan");

    $j=1;
    while ($jml_pohon=mysql_fetch_array($a)) {
        $jml_pohon2[$j]=$jml_pohon[0];
    $j++;
    }


    //no - bl - tujuan - kd lahan - no lahan - geo - silvilkultur - luas - petani - desa - ta - mu - jml phn - geo 2 - no shipment - time
   $query_htc=mysql_query("insert into t4t_htc values ('','$bl','$tujuan[0]','$kd_lahan2','$no_lahan2','$geo2','$silvilkultur2[0]','$luas2','$petani2[0]','$desa2[0]','$ta2[0]','$kdman_unit[0]','$jml_pohon2[$i]','','$no_ship','$date')");

$i++;
}
  $k++;
}//end while

$date=date("Y-m-d");
//update current_tree kedua
$query_current_tree_update2=mysql_query("update current_tree set bl='$bl' where bl='1111-11-11'");


// header("location:../../admin.php?4c079fe60164545aca6a15d1da3842b26d13fa85a72a1c4d0d323d98934f6d2f"); awal
header("location:ac_transaction.php");



?>
