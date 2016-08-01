<?php  
$add_part       =$_POST['partisipan'];
//add no shipment
$id_partisipan=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$add_part'"));
$add_bl         =$_POST['bl'];
$date           =date("dmy");
$add_jml_ns         =$_POST['jml_ns'];
$add_noship     =$_POST['no_ship'];
$add_tot_wins   =$_POST['tot_wins'];
$add_min_allo   =$_POST['min_allo'];
$add_total_allo =$_POST['total_allo'];
$add_ava_allo   =$_POST['ava_allo'];
$add_nama_mu    =$_POST['mu']; 
$add_type_trees =$_POST['type_trees'];
$add_total_trees=$_POST['total_trees'];
$add_no_order   =$_POST['no_order'];
$unallocated2   =$_POST['unallocated'];
$start_w        =$_POST['start_w'];
$land           =$_POST['land'];
$destination    =$_POST['destination'];
$treeperwins    =$_POST['treeperwins'];
$tpw_fix        =$_POST['tpw_fix'];
$fee            =$_POST['fee'];
$note           =$_POST['note'];
$log            =$_POST['log'];
$desa           =$_POST['desa'];
$petani         =$_POST['petani'];

$add=$_REQUEST['add'];
$save=$_REQUEST['save'];
if ($add or $save ) {


//insert into t4t_htc
$id_pohon=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$add_type_trees'"));
$mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$add_nama_mu'")); 
$tujuan=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$add_noship'")); //tujuan [0]
$no_t4tlahan=mysql_fetch_array(mysql_query("select no_t4tlahan,koordinat from current_tree where used='0' and hidup='1' and kd_mu='$mu[0]' and no_t4tlahan='$land' limit 1"));
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
$geo=$no_t4tlahan[1];
$id_partisipan=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$add_part'"));
//no shipment
$date=date("Y-m-d");
$date_second=date("Y-m-d h:i:s");
$tanggal=date("dmy");  
$wins_bagi=$add_total_trees/$treeperwins; //total pohon/tpw

//update current tree
$ns=mysql_fetch_array(mysql_query("select no_sh from add_htc where no_shipment like '%$tanggal%' and id_part='$id_partisipan[0]' order by no desc limit 1 "));
for ($i=1; $i <= 1 ; $i++) { 
     //no shipment
    $date=date("dmy");
   
   $ns2=$ns[0]+$i;
    
     $query_current_tree_update=mysql_query("update current_tree set used='1',bl='1111-11-11',no_shipment='$add_noship' where used='0' and hidup='1' and kd_mu='$mu[0]' and koordinat!='' and no_t4tlahan='$land' limit $add_total_trees");
}




//insert into t4t_htc
$k=1;
while ($k <= 1 ) {
$jml_ns=mysql_fetch_array(mysql_query("select no_sh from add_htc where bl like '%$tanggal%' and id_part='$id_partisipan[0]' order by no desc limit 1 "));
$jml_ns2=$jml_ns[0]+1;
$no_ship_htc=$id_partisipan[0].''.$tanggal.''.$jml_ns2;
$data_lahan=mysql_query("select * from current_tree where bl='1111-11-11' and no_shipment='$add_noship' group by no_t4tlahan");

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

    $a=mysql_query("select count(*) from current_tree where bl='1111-11-11' and no_shipment='$add_noship' group by no_t4tlahan");
    $j=1;
    while ($jml_pohon=mysql_fetch_array($a)) {
        $jml_pohon2[$j]=$jml_pohon[0];
    $j++;
    }
    
    
    //no - bl - tujuan - kd lahan - no lahan - geo - silvilkultur - luas - petani - desa - ta - mu - jml phn - geo 2 - no shipment - time
    $query_htc=mysql_query("insert into t4t_htc values ('','$add_bl','$destination','$kd_lahan2','$no_lahan2','$geo2','$silvilkultur2[0]','$luas2','$petani2[0]','$desa2[0]','$ta2[0]','$mu2[0]','$jml_pohon2[$i]','','$add_noship','$date')");

$i++;
}
  $k++;  
}//end while

   $date=date("Y-m-d");
   
    //update current_tree kedua
    $query_current_tree_update2=mysql_query("update current_tree set bl='$add_bl' where bl='1111-11-11'");


} //end if


?>
          <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation With Sponsorship</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>With Sponsorship</li>
            <li><i class="fa fa-file-text-o"></i>Adding Management Unit</li>
          </ol>
        </div>
      </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Unallocated : [<b> <?php echo $unallocated2 ?> </b>] | Tree per Wins : [ <?php echo $treeperwins ?> ]
                          </header>
                          <div class="panel-body">
                          
                              <!-- Form -->
                              <form class="form-horizontal " method="post">

                                      <!-- OPEN MU -->
                                   <?php $mu=$_REQUEST['mu'] ?>
                                  <div class="form-group">
                                      <label class="control-label col-sm-2">Mangement Unit</label>
                                      <div class="col-sm-10">

                                          <select class="form-control m-bot15" name="mu" onchange='this.form.submit()'>
                                              <option><?php
                                              if ($mu=='') {
                                                echo "- Mangement Unit -";
                                              }else{
                                              echo $mu; }?>
                                              </option>
                                              <?php
                                              $data=mysql_query("select count(no_pohon) as trees,kd_mu from current_tree where hidup=1 and used=0 and bl='' 
                                                and no_shipment='' and koordinat!='' group by kd_mu order by trees desc");
                                              while ($data2=mysql_fetch_array($data)) {

                                                $unit=$data2[1];
                                                $data_mu=mysql_fetch_array(mysql_query("select * from t4t_mu where kd_mu='$unit'"));
                                              ?>
                                              <option value="<?php echo $data_mu['nama'];?>"><?php
                                                
                                                
                                               echo $data_mu['nama'];?> (<?php echo $data2[0]; ?> Trees)</option>
                                              <?php
                                              } ?>
                                          </select>
                                          <noscript><input type="submit" value="mu"></noscript>
                                      </div>
                                                      <input type="hidden" name="partisipan" value="<?php echo $add_part ?>">
                                                      <input type="text" name="jml_ns" value="<?php echo $add_jml_ns ?>">
                                                      <input type="text" name="no_ship" value="<?php echo $id_partisipan[0].''.date("dmy").''.$add_jml_ns?>">
                                                      <input type="hidden" name="bl" value="<?php echo $add_bl ?>">
                                                      <input type="text" name="tot_wins" value="<?php echo $add_tot_wins ?>">
                                                      <input type="hidden" name="total_allo" value="<?php echo $add_total_allo ?>">
                                                      <input type="hidden" name="no_order" value="<?php echo $add_no_order ?>">
                                                      <input type="hidden" name="unallocated" value="<?php echo $unallocated2 ?>">
                                                      <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                                      <input type="hidden" name="destination" value="<?php echo $destination ?>">
                                                      <input type="hidden" name="treeperwins" value="<?php echo $treeperwins ?>">
                                                      <input type="hidden" name="tpw_fix" value="<?php echo $tpw_fix ?>">
                                                      <input type="hidden" name="fee" value="<?php echo $fee ?>">
                                                      <input type="hidden" name="note" value="<?php echo $note ?>">
                                                      <input type="hidden" name="log" value="<?php echo $log ?>">
                                                      <input type="text" name="land" value="<?php echo $land ?>">
                                                      <input type="hidden" name="petani" value="<?php echo $petani ?>">
                                                      <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  </div>
                                      <!-- CLOSE MU -->

                                  <!-- [CLOSE] BL - TOTAL WINS - MIN. ALLOCATION -  TOT. ALLOCATION - AVA. ALLOCATION - M. UNIT -->

                                  <!-- OPEN TYPE OF TREES - TOTAL TREES -->
                                  <?php
                                  $mu = $_REQUEST['mu'] ;
                                    if ($mu) { ?>
                                    <!-- TA -->
                                  <?php 
                                    $ta=$_REQUEST['ta']; 

                                  ?>
                                  <!-- <div class="form-group">
                                    <label class="control-label col-sm-2">TA ID</label>
                                    <div class="col-sm-3">
                                      <select class="form-control" name="ta" onchange="this.form.submit()"> 
                                        <option><?php 
                                        if ($ta=='') {
                                          echo "- TA ID -";
                                        }else{
                                          echo $ta;
                                          } ?>
                                        </option>
                                        <?php
                                        $kab_kode=mysql_fetch_array(mysql_query("select kab_kode from t4t_mu where nama='$mu'"));
                                        $data=mysql_query("select * from t4t_tamaster where kab_code='$kab_kode[0]'");
                                        while ($data2=mysql_fetch_array($data)) {
                                        ?>
                                        <option value="<?php echo $data2['kd_ta'] ?>"><?php echo $data2['nama'] ?> (<?php echo $data2['kd_ta'] ?>)</option> 
                                        <?php
                                        }
                                        ?>
                                     </select>
                                      <noscript><input type="submit" value='ta'></noscript>
                                    </div>
                                    <label class="control-label col-sm-2">Target Area</label>
                                    <div class="col-lg-3">
                                    <input class="form-control" type="text" readonly="" value="<?php $t=mysql_fetch_array(mysql_query("select nama from t4t_tamaster where kd_ta='$ta'")); echo $t[0]; ?>">
                                    </div>
                                  </div> -->
                                  <!-- TA Close -->

                                    <!-- Desa -->
                                  <?php 
                                    $desa=$_REQUEST['desa']; 

                                  ?>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2">Village ID</label>
                                    <div class="col-sm-3">
                                      <select class="form-control" name="desa" onchange="this.form.submit()"> 
                                        <option><?php 
                                        if ($desa=='') {
                                          echo "- Village ID -";
                                        }else{
                                          echo $desa;
                                          } ?>
                                        </option>
                                        <?php
                                        $kab_kode=mysql_fetch_array(mysql_query("select kab_kode from t4t_mu where nama='$mu'"));
                                        $data=mysql_query("select a.* from t4t_desa a,add_jmlpohon_lahan b where a.kab_code='$kab_kode[0]' and a.id_desa=b.id_desa group by a.desa order by desa asc");
                                        while ($data2=mysql_fetch_array($data)) {
                                        ?>
                                        <option value="<?php echo $data2['id_desa'] ?>"><?php echo $data2['desa'] ?> (<?php echo $data2['id_desa'] ?>)</option> 
                                        <?php
                                        }
                                        ?>
                                     </select>
                                      <noscript><input type="submit" value='desa'></noscript>
                                    </div>
                                    <label class="control-label col-sm-2">Village</label>
                                    <div class="col-lg-3">
                                    <input class="form-control" type="text" readonly="" value="<?php $v=mysql_fetch_array(mysql_query("select desa from t4t_desa where id_desa='$desa'")); echo $v[0]; ?>">
                                    </div>
                                  </div>
                                  <!-- Desa Close -->
                                  <!-- Petani -->
                                  <?php $petani=$_REQUEST['petani'] ?>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2">Farmer ID</label>
                                    <div class="col-sm-3">
                                      <select class="form-control" name="petani" onchange="this.form.submit()"> 
                                        <option><?php 
                                        if ($petani=='') {
                                          echo "- Farmer ID -";
                                        }else{
                                          echo $petani;
                                          } ?>
                                        </option>
                                        <?php
                                       // $id_desa=mysql_fetch_array(mysql_query("select id_desa from t4t_desa where desa='$desa'"));
                                        //$kd_petani_view=mysql_fetch_array(mysql_query("select kd_petani from add_jmlpohon_lahan where id_desa='$desa' group by kd_petani"));
                                        $data=mysql_query("select b.* from add_jmlpohon_lahan a, t4t_petani b where b.id_desa='$desa' and a.kd_petani=b.kd_petani and a.id_desa=b.id_desa group by kd_petani");
                                        while ($data2=mysql_fetch_array($data)) {
                                        ?>
                                        <option value="<?php echo $data2['kd_petani'] ?>"><?php echo $data2['nm_petani'] ?> (<?php echo $data2['kd_petani'] ?>)</option> 
                                        <?php
                                        }
                                        ?>
                                        <option value=""></option> 

                                     </select>
                                      <noscript><input type="submit" value='petani'></noscript>
                                    </div>
                                    <label class="control-label col-sm-2">Farmer</label>
                                    <div class="col-lg-3">
                                    <input class="form-control" type="text" readonly="" value="<?php $f=mysql_fetch_array(mysql_query("select nm_petani from t4t_petani where kd_petani='$petani' and id_desa='$desa'")); echo $f[0]; ?>">
                                    </div>
                                  </div>
                                  <!-- Petani Close -->
                                  <!-- OPEN LAHAN TREES -->
                                  <?php $land=$_REQUEST['land'] ?>
                                  <div class="form-group">
                                      <label class="control-label col-sm-2">Land ID</label>
                                      <div class="col-sm-10">
                                          <select class="form-control m-bot15" name="land" onchange='this.form.submit()' required>
                                              <option><?php
                                              if ($land=='') {
                                                echo "- Land ID -";
                                              }else{
                                              echo $land; }?>
                                              </option>
                                              <?php
                                              //ambil idmu                                             
                                              $idmu2=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$mu'"));
                                              $data=mysql_query("select count(*) as jml_pohon,no from add_jmlpohon_lahan where kd_mu='$idmu2[0]' and used=0 and bl='' and no_shipment='' and koordinat!='' 
                                                and used=0 and hidup=1 and id_desa='$desa' and kd_petani='$petani' group by no_t4tlahan order by jml_pohon desc");
                                              while ($data2=mysql_fetch_array($data)) {
                                              ?>
                                              <option value="<?php echo $data2['no']?>"><?php echo $data2['no'] ?> (<?php echo $data2[0] ?> Trees)</option>
                                              <?php
                                              } ?>
                                          </select>
                                          <noscript><input type="submit" value="land"></noscript>
                                      </div>
                                  </div>
                                  <!-- CLOSE LAHAN TREES -->
                                   <?php $type_trees=$_REQUEST['type_trees'] ?>

                                  <?php 
                                 
                                  $tot_trees=$_REQUEST['type_trees'];
                                 // echo $tot_trees; 
                                  $id_trees=mysql_fetch_array(mysql_query("select * from t4t_pohon where nama_pohon like '%$tot_trees%'"));
                                 // echo $id_trees['id_pohon'];
                                  $id_mu=mysql_fetch_array(mysql_query("select * from t4t_mu where nama like '%$mu%'"));
                                 // echo $id_mu['kd_mu'];
                                  $jumlah_pohon=mysql_fetch_array(mysql_query("select count(*) from current_tree where kd_mu='$id_mu[0]' and used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 and no_t4tlahan='$land'"));
                                 // echo $jumlah_pohon[0];
                                  ?>

                                  <!-- OPEN TOTAL TREES -->
                                  <div class="form-group">
                                      <label class="control-label col-sm-2">Trees</label>
                                      <div class="col-sm-7">
                                      <?php $tree=$_REQUEST['total_trees'] ?>
                                       
                                          <input type="number" class="form-control" onchange="this.form.submit()" name="total_trees" value="<?php echo $tree ?>" max="<?php echo $unallocated ?>" max="<?php echo $jumlah_pohon[0] ?>" min="1" required="">
                                          <noscript><input type="submit" value="total_trees"></noscript>
                                      </div>
                                      
                                      <div class="col-sm-3">
                                          <input type="" class="form-control" name="ava_trees" value="<?php echo  $jumlah_pohon[0] ?> available" readonly="">
                                      </div><br>
                                      <label class="col-sm-9 control-label"></label>
                                      <div class="col-sm-3">
                                      <font color="red">*if 0 it means the tree is empty </font>
                                      </div> 
                                  </div>
                                  <!-- CLOSE TOTAL TREES -->

                                  


                                  <!-- CLOSE  -->  
                                  <div align="center">                                
                                  <button type="submit" name="cek" value="cek" class="btn btn-success"><i class="fa fa-check"> Check</i></button><br><br><br>
                                  </div>

                              </form>
                              <?php $pohon=$_REQUEST['total_trees']; 
                                      $unallocated=$unallocated2-$pohon;
                                  ?>
                                  <div class="col-sm-2">
                                    <input type="" class="form-control" name="" value="<?php echo  $unallocated ?> unallocated estimation" readonly="">
                                  </div>
                              <!-- close form -->
                              <?php

                                 //if submit check
                                 $cek=$_REQUEST['cek'];
                                 if ($cek) {  

                                   $tree=$_REQUEST['total_trees'];
                                   $ava_trees=$jumlah_pohon[0];
                                   // $cek_kelipatan=$tree/$treeperwins;
                                   // $tiga_dari_belakang= substr ($cek_kelipatan, -3, 1); // menghasilkan ","
                                   // $dua_dari_belakang= substr ($cek_kelipatan, -2, 1); // menghasilkan ","
                                   // $empat_dari_belakang= substr ($cek_kelipatan, -4, 1); // menghasilkan ","
                                   // $tiga_dari_depan= substr ($cek_kelipatan, 2, 1); // menghasilkan ","
                                   // $dua_dari_depan= substr ($cek_kelipatan, 1, 1); // menghasilkan ","

                                   if ($tree>$ava_trees==1) {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please check the available trees ...
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                 elseif ($empat_dari_belakang==".") {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Sorry, the number of trees must be multiples of the treeperwins 
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                 elseif ($tiga_dari_belakang==".") {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Sorry, the number of trees must be multiples of the treeperwins 
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                 elseif ($dua_dari_belakang==".") {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Sorry, the number of trees must be multiples of the treeperwins 
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                 elseif ($tiga_dari_depan==".") {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Sorry, the number of trees must be multiples of the treeperwins 
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                 elseif ($dua_dari_depan==".") {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Sorry, the number of trees must be multiples of the treeperwins 
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                      //if unallocated 
                                      elseif ($unallocated > 0) {
                                        ?>
                                  
                                 <!-- SUBMIT BUTTON ke adding 1-->
                                  <form  id="form" action="admin.php?a46082f9f5d6e76572879db4b9985b5b2f8e9f23bcc4170dc360b7138a84d10a" method="post">
                                  <div align="center">
                                  

                                  <input type="hidden" name="partisipan" value="<?php echo $_REQUEST['partisipan'] ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $_REQUEST['no_ship'] ?>">
                                  <input type="hidden" name="bl" value="<?php echo $_REQUEST['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $_REQUEST['tot_wins'] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $_REQUEST['total_allo'] ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $_REQUEST['no_order'] ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">
                                  <input type="hidden" name="destination" value="<?php echo $destination ?>">
                                  <input type="hidden" name="treeperwins" value="<?php echo $treeperwins ?>">
                                  <input type="hidden" name="tpw_fix" value="<?php echo $tpw_fix ?>">
                                  <input type="text" name="jml_ns" value="<?php echo $_REQUEST['jml_ns'] ?>">
                                  <input type="hidden" name="fee" value="<?php echo $fee ?>">
                                  <input type="hidden" name="note" value="<?php echo $note ?>">  
                                  <input type="hidden" name="log" value="<?php echo $log ?>">
                                  <input type="hidden" name="petani" value="<?php echo $petani ?>">
                                  <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-unallo').modal('show');">
                                      <div id="my-modal-unallo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-warning"><strong>Data has been checked!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                  <table border="0">
                                                          
                                                          
                                                          <tr><!-- mu -->
                                                            <td>Management Unit</td>
                                                            <td>:</td>
                                                            <td><?php echo $mu ?></td>
                                                          </tr>

                                                          <tr><!-- tot tree -->
                                                            <td>Tot. Trees <b>TREE</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $tree ?></td>
                                                          </tr>
                                                          
                                                        </table>
                                                        <br><br>
                                                      Please <b>add</b> data now...
                                                  </div>
                                              </div>
                                          </div> 
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                        <br><br>
                                      <button type="submit" value="add" name="add" class="btn btn-warning"><i class="fa fa-plus"> Add</i></button>
                                     
                                     
                                  </div>
                                  </form>
                                  <?php 

                                   }//end unallocated

                                   elseif ($unallocated==0) {
                                     ?>
                                     <!-- SUBMIT BUTTON -->
                                  <form  id="form" action="action/blocking-process/ac_sponsorship.php" method="post">
                                  <div align="center">
                                  <?php $pohon=$_REQUEST['total_trees']; 
                                        $unallocated=$total_allo-$pohon;
                                  ?>

                                  <input type="hidden" name="partisipan" value="<?php echo $_REQUEST['partisipan'] ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $_REQUEST['no_ship'] ?>">
                                  <input type="hidden" name="bl" value="<?php echo $_REQUEST['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $_REQUEST['tot_wins'] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $_REQUEST['total_allo'] ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $_REQUEST['no_order'] ?>">
                                  <input type="hidden" name="unallocated" value="0">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">
                                  <input type="hidden" name="destination" value="<?php echo $destination ?>">
                                  <input type="hidden" name="treeperwins" value="<?php echo $treeperwins ?>">
                                  <input type="hidden" name="tpw_fix" value="<?php echo $tpw_fix ?>"> 
                                  <input type="text" name="jml_ns" value="<?php echo $_REQUEST['jml_ns'] ?>"> 
                                  <input type="hidden" name="fee" value="<?php echo $fee ?>">
                                  <input type="hidden" name="note" value="<?php echo $note ?>">                  
                                  <input type="hidden" name="log" value="<?php echo $log ?>">
                                  <input type="hidden" name="petani" value="<?php echo $petani ?>">
                                  <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-allo').modal('show');">
                                      <div id="my-modal-allo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-success"><strong>Data has been checked!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                  <table border="0">
                                                          
                                                          
                                                          <tr><!-- mu -->
                                                            <td>Management Unit</td>
                                                            <td>:</td>
                                                            <td><?php echo $mu ?></td>
                                                          </tr>

                                                          <tr><!-- tot tree -->
                                                            <td>Tot. Trees <b>TREE</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $tree ?></td>
                                                          </tr>
                                                          
                                                        </table>
                                                        <br><br>
                                                      Please <b>submit</b> data now...
                                                  </div>
                                              </div>
                                          </div> 
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <br><br>
                                      <button type="submit" value="save" name="save" class="btn btn-primary"><i class="fa fa-save"> Submit</i></button>
                                     
                                     
                                  </div>
                                  </form>

                                     <?php
                                   }//end pass
                                 elseif ($unallocated<0){//Trees over allocation 
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Data do not match!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please check the available trees ...
                                                  </div>
                                              </div>
                                          </div> 
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                 }//end over

                                 
                                 
                                }//end check
                                 ?>







                             <?php   
                                  } ?>
                          </div>
                      </section>
                      
                      
                      
                  </div>
              </div>
              <!-- Basic Forms & Horizontal Forms-->
              
                      </div>
                  </div>
              </div>
              <!-- page end-->
          </section>
