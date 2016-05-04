<?php  
$add_part       =$_POST['partisipan'];
$add_noship     =$_POST['no_ship']; 
$add_bl         =$_POST['bl']; 
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
$land     =$_POST['land'];

$add=$_REQUEST['add'];
$save=$_REQUEST['save'];
if ($add or $save ) {


//insert into t4t_htc
$id_pohon=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$add_type_trees'"));
$mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$add_nama_mu'")); 
$tujuan=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$add_noship'")); //tujuan [0]
$no_t4tlahan=mysql_fetch_array(mysql_query("select no_t4tlahan,koordinat from current_tree where used='0' and hidup='1' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' and no_t4tlahan='$land' limit 1"));
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

$query_htc=mysql_query("insert into t4t_htc values ('','$add_bl','$tujuan[0]','$kd_lahan','$no_lahan','$geo','$silvilkultur[0]','$luas','$petani[0]',
                        '$desa[0]','$ta[0]','$add_nama_mu','$add_total_trees','','$add_noship')");


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
 $query_current_tree_update=mysql_query("update current_tree set used='1',bl='$add_bl',no_shipment='$add_noship' where used='0' and hidup='1' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' and no_t4tlahan='$land' limit $add_total_trees");

$item_qty=mysql_fetch_array(mysql_query("select item_qty from t4t_shipment where bl='$bl'"));
$item=$item_qty[0];
// echo "<br>";
$qty_akhir=$item-$total_allo;

  //$query_update_qty_item=mysql_query("update t4t_shipment set item_qty='$qty_akhir' where bl='$bl' ");
}


?>
          <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation With Shipments</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>With Shipment</li>
            <li><i class="fa fa-file-text-o"></i>Adding Management Unit</li>
          </ol>
        </div>
      </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Unallocated : <?php echo $unallocated2 ?>
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
                                                      <input type="hidden" name="no_ship" value="<?php echo $add_noship ?>">
                                                      <input type="hidden" name="bl" value="<?php echo $add_bl ?>">
                                                      <input type="hidden" name="tot_wins" value="<?php echo $add_tot_wins ?>">
                                                      <input type="hidden" name="total_allo" value="<?php echo $add_total_allo ?>">
                                                      <input type="hidden" name="no_order" value="<?php echo $add_no_order ?>">
                                                      <input type="hidden" name="unallocated" value="<?php echo $unallocated2 ?>">
                                                      <input type="hidden" name="start_w" value="<?php echo $start_w ?>">



                                  </div>
                                      <!-- CLOSE MU -->

                                  <!-- [CLOSE] BL - TOTAL WINS - MIN. ALLOCATION -  TOT. ALLOCATION - AVA. ALLOCATION - M. UNIT -->

                                  <!-- OPEN TYPE OF TREES - TOTAL TREES -->
                                  <?php
                                  $mu = $_REQUEST['mu'] ;
                                    if ($mu) { ?>
                                   <?php $type_trees=$_REQUEST['type_trees'] ?>

                                   <!-- OPEN TYPE TREES -->
                                  <div class="form-group">
                                      <label class="control-label col-sm-2">Type of Trees</label>
                                      <div class="col-sm-10">

                                          <select class="form-control m-bot15" name="type_trees" onchange='this.form.submit()' required>
                                              <option><?php
                                              if ($type_trees=='') {
                                                echo "- Type of Trees -";
                                              }else{
                                              echo $type_trees; }?>
                                              </option>
                                              <?php
                                              $unit_per_mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$mu'"));

                                              $data=mysql_query("select count(no_pohon) as trees,id_pohon from current_tree where hidup=1 and used=0 
                                and bl='' and no_shipment='' and koordinat!='' and kd_mu='$unit_per_mu[0]' group by id_pohon order by trees desc");
                                              while ($data2=mysql_fetch_array($data)) {


                                               $species=$data2[1];
                                               $sp=mysql_fetch_array(mysql_query("select * from t4t_pohon where id_pohon='$species'"));
                                              ?>
                                              <option value="<?php echo $sp['nama_pohon']?>"><?php echo $sp['nama_pohon'] ?> ( <?php echo $data2[0] ?>)</option>
                                              <?php
                                              } ?>
                                          </select>
                                          <noscript><input type="submit" value="type_trees"></noscript>
                                      </div>
                                  </div>
                                  <!-- CLOSE TYPE TREES -->

                                  <!-- OPEN LAHAN TREES -->
                                  <div class="form-group">
                                      <label class="control-label col-sm-2">Land ID</label>
                                      <div class="col-sm-10">
                                      <?php $land2=$_REQUEST['land2'] ?>
                                          <select class="form-control m-bot15" name="land2" onchange='this.form.submit()' required>
                                              <option><?php
                                              if ($land2=='') {
                                                echo "- Land ID -";
                                              }else{
                                              echo $land2; }?>
                                              </option>
                                              <?php
                                              //ambilidmu dan id pohon
                                              $idpohon2=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$type_trees'"));
                                              $idmu2=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$mu'"));

                                              $data=mysql_query("select count(*) as jml_pohon,no from add_jmlpohon_lahan where kd_mu='$idmu2[0]' and id_pohon='$idpohon2[0]' and used=0 and bl='' and no_shipment='' and koordinat!='' 
                                                and used=0 and hidup=1 group by no_t4tlahan order by jml_pohon desc");
                                              while ($data2=mysql_fetch_array($data)) {


                                              ?>
                                              <option value="<?php echo $data2['no']?>"><?php echo $data2['no'] ?> (<?php echo $data2[0] ?> Trees)</option>
                                              <?php
                                              } ?>
                                          </select>
                                          <noscript><input type="submit" value="land2"></noscript>
                                      </div>
                                  </div>
                                  <!-- CLOSE LAHAN TREES -->

                                  <?php 
                                 
                                  $tot_trees=$_REQUEST['type_trees'];
                                 // echo $tot_trees; 
                                  $id_trees=mysql_fetch_array(mysql_query("select * from t4t_pohon where nama_pohon like '%$tot_trees%'"));
                                 // echo $id_trees['id_pohon'];
                                  $id_mu=mysql_fetch_array(mysql_query("select * from t4t_mu where nama like '%$mu%'"));
                                 // echo $id_mu['kd_mu'];
                                  $jumlah_pohon=mysql_fetch_array(mysql_query("select count(*) from current_tree where kd_mu='$id_mu[0]' and id_pohon='$id_trees[0]' and used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 and no_t4tlahan='$land2'"));
                                 // echo $jumlah_pohon[0];
                                  ?>

                                  <!-- OPEN TOTAL TREES -->
                                  <div class="form-group">
                                      <label class="control-label col-sm-2">Trees</label>
                                      <div class="col-sm-7">
                                      <?php $tree=$_REQUEST['total_trees'] ?>
                                       
                                          <input type="number" class="form-control" onchange="this.form.submit()" name="total_trees" value="<?php echo $tree ?>" max="<?php echo $jumlah_pohon[0] ?>" max="<?php echo $total_allo ?>" min="1" required="">
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
                                    <input type="" class="form-control" name="" value="<?php echo  $unallocated ?> unallocated" readonly="">
                                  </div>
                              <!-- close form -->
                              <?php

                                 //if submit check
                                 $cek=$_REQUEST['cek'];
                                 if ($cek) {  

                                   $unallocated;
                                      //if unallocated 
                                      if ($unallocated > 0) {
                                        ?>
                                  
                                 <!-- SUBMIT BUTTON ke adding 2-->
                                  <form  id="form" action="admin.php?c3b00eb86cd337880f1639111f2af7166ad8cf08ca126c631f0f21f266b999f9" method="post">
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
                                  <input type="hidden" name="land" value="<?php echo $land2 ?>">


                    
                                    
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-unallo').modal('show');">
                                      <div id="my-modal-unallo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Data has been checked!</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please submit data now...
                                                  </div>
                                              </div>
                                          </div> 
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                        <br><br>
                                      <button type="submit" value="add" name="add" class="btn btn-primary"><i class="fa fa-save"> Submit</i></button>
                                     
                                     
                                  </div>
                                  </form>
                                  <?php 

                                   }//end unallocated

                                   elseif ($unallocated==0) {
                                     ?>
                                     <!-- SUBMIT BUTTON -->
                                  <form  id="form" action="action/blocking-process/index.php" method="post">
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
                                  <input type="hidden" name="land" value="<?php echo $land2 ?>">


                    
                                    
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-allo').modal('show');">
                                      <div id="my-modal-allo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Data has been checked!</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please submit data now...
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
                                                  <h4 class="modal-title">Data do not match!</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please check your allocation trees...
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
<?php include 'js/jsku.php'; ?>