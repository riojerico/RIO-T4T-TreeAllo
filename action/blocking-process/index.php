<?php 

ob_start();

include '../../koneksi/koneksi.php';

//for encription

include "../../assets/lib-encript/function.php";

// --------------

//POST from FORM

$id_part    =$_POST['partisipan'];

$bl         =$_POST['bl'];

$no_ship    =$_POST['no_ship'];

$tot_wins   =$_POST['tot_wins'];

$total_allo =$_POST['total_allo'];

$nama_mu    =$_POST['mu']; //mu name

$total_trees=$_POST['total_trees'];

$no_order   =$_POST['no_order'];

$unallocated=$_POST['unallocated'];

$start_w    =$_POST['start_w'];

$destination=$_POST['destination'];

$treeperwins=$_POST['treeperwins'];

$tpw_fix=$_POST['tpw_fix'];

$fee=$_POST['fee'];

$note=$_POST['note'];

$log        =$_POST['log'];





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

//echo $id_partisipan[0];

date_default_timezone_set('Asia/Jakarta');

$time=date("Y-m-d");

$time_second=date("Y-m-d h:i:s");

//no shipment

$date=date("dmy");

$wins_bagi=$total_trees/$treeperwins; //total pohon/tpw

    





//update current tree

$select_current_tree=mysql_query("select count(*) as jml_pohon,kd_mu from add_jmlpohon_lahan where used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 group by kd_mu");

$z=1;

while ( $load=mysql_fetch_array($select_current_tree)) {



   $kdman_unit   =$_POST['kdman_unit'.$z];                                 

   $alokasi_pohon=$_POST['alokasi_pohon'.$z];



   $ns=mysql_fetch_array(mysql_query("select no_sh from add_current_tree where tgl='$date' and id_part='$id_partisipan[0]' order by no_sh desc limit 1"));

 

   $wins_alo=$alokasi_pohon/$treeperwins;

   for ($i=1; $i <= $wins_alo ; $i++) { 

   //no shipment



   $date=date("dmy");   

   $ns2=$ns[0]+$i;

     $query_current_tree_update=mysql_query("update current_tree set used='1',bl='1111-11-11',no_shipment='$id_partisipan[0]$date$ns2' where used='0' and hidup='1' and kd_mu='$kdman_unit' and koordinat!='' limit $treeperwins");

   }                     

                                      

$z++;

}











//insert into t4t_wins

$date=date("dmy");

$ns_win=mysql_fetch_array(mysql_query("select no_sh from add_wins where bl like '%$date%' and id_part='$id_partisipan[0]' order by no desc limit 1 "));

for ($i=1; $i <= $tot_wins ; $i++) { 

    //ambil start wins

    $wins=$start_w-1;

    $win=$wins+$i;

   

    $ns_win2=$ns_win[0]+$i;

    $ns_win2;

    //no - win - no_order - pesen? - used? - unused? - vc? - bl - id_part - no shipment - time - log user - type

   

    $query_wins=mysql_query("insert into t4t_wins values ('','$win','$no_order','','','','','$bl','$id_partisipan[0]','$id_partisipan[0]$date$ns_win2','$time','$log','3')");

}



//insert into t4t_shipment

$jml_ns=mysql_fetch_array(mysql_query("select no_sh from add_htc where bl like '%$date%' and id_part='$id_partisipan[0]' order by no desc limit 1 "));

// no - no ship - id comp - bl - bl tgl - wins used - wins unused - wkt shipment - foto - acc - no order - kota tujuan - fee - diskon - tgl paid - acc paid - note - buyer - item qty

for ($i=1; $i <= $tot_wins ; $i++) { 

$jml_ns2=$jml_ns[0]+$i;

$no_ship_htc=$id_partisipan[0].''.$date.''.$jml_ns2;



//Ambil wins

$wins=$start_w-1;

   $win=$wins+$i;



    $query_shipment=mysql_query("insert into t4t_shipment values ('','$no_ship_htc','$id_partisipan[0]','$bl','$time','$win','','$time_second','','1','$no_order','$destination','$fee','0','$time','1','$note','','1')");

}





//insert into t4t_htc

$select_htc=mysql_query("select count(*) as jml_pohon,kd_mu from add_jmlpohon_lahan where used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 group by kd_mu");



$htc=1;

 while ( $load=mysql_fetch_array($select_htc)) {

   $kdman_unit   =$_POST['kdman_unit'.$htc];                                 

   $alokasi_pohon=$_POST['alokasi_pohon'.$htc];



   $wins_alo=$alokasi_pohon/$treeperwins;



$k=1;

while ($k <= $wins_alo ) {

$jml_ns=mysql_fetch_array(mysql_query("select no_sh from add_current_tree where bl like '%$date%' and id_part='$id_partisipan[0]' order by no_sh desc limit 1 "));

$jml_ns2=$jml_ns[0]+1;

$no_ship_htc=$id_partisipan[0].''.$date.''.$jml_ns2;

$data_lahan=mysql_query("select * from current_tree where bl='1111-11-11' and no_shipment='$no_ship_htc' group by no_t4tlahan");



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

    $kd_mu          =$get_lahan['kd_mu'];

    $mu2            =mysql_fetch_array(mysql_query("select nama from t4t_mu where kd_mu='$kd_mu'"));



    $a=mysql_query("select count(*) from current_tree where bl='1111-11-11' and no_shipment='$no_ship_htc' group by no_t4tlahan");

    $j=1;

    while ($jml_pohon=mysql_fetch_array($a)) {

        $jml_pohon2[$j]=$jml_pohon[0];

    $j++;

    }

    

    

    //no - bl - tujuan - kd lahan - no lahan - geo - silvilkultur - luas - petani - desa - ta - mu - jml phn - geo 2 - no shipment - time

    $query_htc=mysql_query("insert into t4t_htc values ('','$bl','$destination','$kd_lahan2','$no_lahan2','$geo2','$silvilkultur2[0]','$luas2','$petani2[0]','$desa2[0]','$ta2[0]','$mu2[0]','$jml_pohon2[$i]','','$no_ship_htc','$time')");

    $query_current_tree_update2=mysql_query("update current_tree set bl='$bl' where bl='1111-11-11' and no_shipment='$no_ship_htc'");



$i++;

}

  $k++;  

}//end while

 $htc++;

 }





//header("location:../../admin.php?c3b00eb86cd337880f1639111f2af716061ba997b556a75c89e9bad84f0eb324");

header("location:ac_transaction.php");

?>