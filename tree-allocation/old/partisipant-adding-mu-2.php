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
$unallocated2    =$_POST['unallocated'];

$add=$_REQUEST['add'];
$save=$_REQUEST['save'];
if ($add or $save ) {


//-------------------[1]insert into t4t_htc-------------------
$id_pohon=mysql_fetch_array(mysql_query("select id_pohon from t4t_pohon where nama_pohon='$add_type_trees'"));
$mu=mysql_fetch_array(mysql_query("select kd_mu from t4t_mu where nama='$add_nama_mu'")); 
$tujuan=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$add_noship'")); //tujuan [0]
$no_t4tlahan=mysql_fetch_array(mysql_query("select no_t4tlahan from view_t4t_ct where hidup='1' and used='0' and koordinat!='' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]'"));
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
$geo=$lahan['koordinat'];
$id_partisipan=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$add_part'"));

$query_htc=mysql_query("insert into t4t_htc values ('','$add_bl','$tujuan[0]','$kd_lahan','$no_lahan','$geo','$silvilkultur[0]','$luas','$petani[0]',
                        '$desa[0]','$ta[0]','$add_nama_mu','$add_total_trees','','$add_noship')");



//-------------------[3]WINS-------------------
$cek_no_order_baru=mysql_fetch_array(mysql_query("select * from t4t_order where jml_wins!='' and no_order='$add_no_order'"));

if ($cek_no_order_baru[used]=="1") {  
  //insert into t4t_wins auto
  for ($i=1; $i <= $add_total_trees ; $i++) { 
    //get the last wins
    $last_wins=mysql_query("select wins from t4t_wins_copy order by no desc limit 1 ");
    $last_wins2=mysql_fetch_array($last_wins);
    $wins=$last_wins2['wins'];
      $wins+$i;
    //echo "<br>";
      $win=$wins+1;

    //no - win - no_order - pesen? - used? - unused? - vc? - bl - id_part - no shipment
    $id_partisipan[0];

      $query_wins_auto=mysql_query("insert into t4t_wins_copy values ('','$win','$add_no_order','','','','','$add_bl','$id_partisipan[0]','$add_noship')"); 

}
}else{

//t4t wins sesuai order (khusus pertama)
$data2=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$add_no_order'"));
$wins_awal=$data2['wins1']-1;

   for ($i=1; $i < $add_total_trees+1 ; $i++) {
   //$pisah=explode(", ", $data2['no_order']);
   $win=$wins_awal+$i;
   $query_wins=mysql_query("insert into t4t_wins_copy values ('','$win','$add_no_order','','','','','$add_bl','$id_partisipan[0]','$add_noship')");
     }

  }
//-----------------[2]update current tree-------------------
 $query_current_tree_update=mysql_query("update current_tree set used='1' where used='0' and hidup='1' and id_pohon='$id_pohon[0]' and kd_mu='$mu[0]' limit $add_total_trees");


//[4]update nomor wins dari t4t_order
$query_update_wins_order=mysql_query("update t4t_order set used='1' where no_order='$add_no_order'");

//[5]update no_ship dari t4t_order
$ship=mysql_fetch_array(mysql_query("select no_ship from t4t_order where no_order='$no_order'"));//ambil data ship terakhir
$query_update_no_ship=mysql_query("update t4t_order set no_ship='$ship[0],$add_noship,' where no_order='$add_no_order'");

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
					<h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation For Partisipant</h3>
					<ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>For Partisipant</li>
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
                                              $data=mysql_query("select * from t4t_mu order by nama asc");
                                              while ($data2=mysql_fetch_array($data)) {
                                              ?>
                                              <option value="<?php echo $data2['nama']?>"><?php echo $data2['nama'] ?></option>  
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
                                      
                                          <select class="form-control m-bot15" name="type_trees" onchange='this.form.submit()'>
                                              <option><?php 
                                              if ($type_trees=='') {
                                                echo "- Type of Trees -";
                                              }else{
                                              echo $type_trees; }?>
                                              </option>
                                              <?php 
                                              $data=mysql_query("select * from t4t_pohon order by nama_pohon asc");
                                              while ($data2=mysql_fetch_array($data)) {
                                              ?>
                                              <option value="<?php echo $data2['nama_pohon']?>"><?php echo $data2['nama_pohon'] ?></option>  
                                              <?php 
                                              } ?> 
                                          </select>
                                          <noscript><input type="submit" value="type_trees"></noscript>
                                      </div>
                                  </div>
                                  <!-- CLOSE TYPE TREES -->

                                  <?php 
                                 
                                  $tot_trees=$_REQUEST['type_trees'];
                                 // echo $tot_trees; 
                                  $id_trees=mysql_fetch_array(mysql_query("select * from t4t_pohon where nama_pohon like '%$tot_trees%'"));
                                 // echo $id_trees['id_pohon'];
                                  $id_mu=mysql_fetch_array(mysql_query("select * from t4t_mu where nama like '%$mu%'"));
                                 // echo $id_mu['kd_mu'];
                                  $jumlah_pohon=mysql_fetch_array(mysql_query("select count(*) from current_tree where used='0' and hidup='1' and kd_mu='$id_mu[0]' and id_pohon='$id_trees[0]'"));
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
                                  
                                 <!-- SUBMIT BUTTON ke adding 1-->
                                  <form  id="form" action="admin.php?4e8fa844acbd97b810cffdfc020424200c8befd0326d62ec7437ad3637ad87b9" method="post">
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
                                  <form  id="form" action="action/blocking-process/ac_part.php" method="post">
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