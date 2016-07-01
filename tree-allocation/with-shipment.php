          <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation With Shipments</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>With Shipment</li>
          </ol>
        </div>
      </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Form Tree Allocation With Shipment
                          </header>
                          <div class="panel-body">

                              <!-- Form -->
                              <form class="form-horizontal " method="post">

                              <!-- PARTISIPAN -->
                              <?php $parts=$_REQUEST['partisipan'] ?>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">Participants</label>
                                      <div class="col-sm-10">
                                          <select class="form-control m-bot15" name="partisipan" onchange='this.form.submit()'>
                                              <option><?php
                                              if ($parts=='') {
                                                echo "- Partisipan -";
                                              }else{
                                              echo $parts; }?>
                                              </option>
                                              <?php
                                              $data=mysql_query("select * from t4t_partisipan order by nama asc");
                                              while ($data2=mysql_fetch_array($data)) {
                                              ?>
                                              <option value="<?php echo $data2['nama']?>"><?php echo $data2['nama'] ?></option>
                                              <?php
                                              } ?>
                                          </select>
                                          <noscript><input type="submit" value="partisipan"></noscript>
                                      </div>

                                  </div>
                                  <!-- CLOSE PARTISIPAN -->

                                  <!-- NO SHIPMENT -->
                                  <?php
                                    $no_ship = $_REQUEST['no_ship'] ;
                                    if ($parts) {
                                      $id_comp=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$parts'"));

                                  ?>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">No Shipment</label>
                                      <div class="col-sm-10">
                                          <select class="form-control m-bot15" name="no_ship" onchange="this.form.submit()" required>
                                              <option><?php
                                              if ($no_ship=='') {
                                                echo "- No Shipment -";
                                              }else{
                                              echo $no_ship; }?>
                                              </option>
                                              <?php
                                              $data=mysql_query("select * from t4t_shipment where id_comp='$id_comp[0]' order by no_shipment asc");
                                              while ($data2=mysql_fetch_array($data)) {
                                              ?>
                                              <option value="<?php echo $data2['no_shipment'] ?>"><?php echo $data2['no_shipment'] ?></option>
                                              <?php
                                              }
                                              ?>
                                          </select>
                                          <noscript><input type="submit" value="no_ship"></noscript>
                                      </div>
                                  </div>
                                  <?php  }  ?>
                                  <!-- CLOSE NO SHIPMENT -->

                                  <!-- NO ORDER -->
                                  <?php
                                    $no_order = $_REQUEST['no_order'] ;
                                    if ($no_ship) {
                                      $id_comp=mysql_fetch_array(mysql_query("select id from t4t_partisipan where nama='$parts'"));

                                  ?>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">No Order</label>
                                      <div class="col-sm-10">
                                          <select class="form-control m-bot15" name="no_order" onchange="this.form.submit()" required>
                                              <option><?php
                                              if ($no_order=='') {
                                                echo "- No Order -";
                                              }else{
                                              echo $no_order; }?>
                                              </option>
                                              <?php
                                              $data=mysql_query("select * from t4t_shipment where id_comp='$id_comp[0]' and acc_paid='1' and no_shipment='$no_ship' order by no_order asc");
                                              while ($data2=mysql_fetch_array($data)) {
                                                for ($i=0; $i < 20 ; $i++) {
                                                $pisah=explode(", ", $data2['no_order']);
                                              ?>
                                              <option value="<?php echo $pisah[$i] ?>"><?php echo $pisah[$i] ?></option>
                                              <?php
                                                }
                                              }
                                              ?>
                                          </select>
                                          <noscript><input type="submit" value="no_order"></noscript>
                                      </div>
                                  </div>
                                  <?php  }  ?>
                                  <!-- CLOSE NO ORDER -->

                                  <!-- [OPEN] BL - TOTAL WINS - MIN. ALLOCATION -  TOT. ALLOCATION - AVA. ALLOCATION - M. UNIT -->
                                  <?php
                                    $no_order  =$_REQUEST['no_order'];

                                    if ($no_order) {

                                     $data_ship=mysql_fetch_array(mysql_query("select * from t4t_shipment where no_shipment='$no_ship' and id_comp='$id_comp[0]' "));

                                  ?>
                                    <!-- OPEN BL -->
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">BL</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" readonly="" name="bl" value="<?php echo $data_ship['bl']?>" required>
                                      </div>
                                  </div>
                                    <!-- CLOSE BL -->

                                    <!-- OPEN TOTAL WINS -->
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">Total Allocation <b>(WINS)</b></label>
                                      <?php
                                        $tot_wins=$_REQUEST['tot_wins'];
                                      ?>
                                      <div class="col-sm-10">
                                          <input type="number" class="form-control" name="tot_wins" value="<?php echo $tot_wins ?>" required>
                                      </div>
                                  </div>
                                      <!-- CLOSE TOTAL WINS -->

                                      <!-- OPEN TOTAL ALLO -->
                                  <div class="form-group">
                                  <?php $total_allo=$_REQUEST['total_allo'];
                                  //echo $total_allo; ?>

                                      <label class="col-sm-2 control-label">Total Allocation <b>(Tree)</b></label>
                                      <div class="col-sm-10">
                                          <input type="number" class="form-control a" onchange="hitung();" name="total_allo" value="<?php echo $total_allo;?>" required="" min="<?php echo $tot_wins ?>">
                                      </div>
                                  </div>
                                      <!-- CLOSE TOTAL ALLO -->

                                      <!-- cek wins -->
                                  <div class="form-group">
                                  <?php $ava_allo=$_REQUEST['win_num']; 
                                    $win_num=mysql_fetch_array(mysql_query("select wins_used from t4t_shipment where no_shipment='$no_ship' "));
                                  ?>
                                      <label class="col-sm-2 control-label">Wins Number</label>
                                      <div class="col-sm-10">
                                          <textarea type="" class="form-control" readonly="" name="win_num" required><?php echo $win_num[0] ?></textarea>
                                      </div>
                                      <label class="col-sm-2 "></label>
                                      <div class="col-sm-10">
                                       <font color="red">*wins used from shipment</font>
                                       </div>
                                  </div>
                                      <!-- //cek wins -->

                                      <!-- START WINS -->
                                  <div class="form-group">
                                  <?php $ava_allo=$_REQUEST['ava_allo']; ?>
                                  <div class="col-lg-2"></div>
                                    <div class="col-lg-4">
                                      <label class="col-sm-3 control-label c">Start Wins</label>
                                      <div class="col-sm-6">
                                      <?php $start_w=$_REQUEST['start_w']; ?>
                                          <input type="number" class="form-control" name="start_w" value="<?php echo $start_w ?>" required="">
                                      </div>
                                    </div>
                                    <div class="col-lg-4">
                                      <label class="col-sm-3 control-label c">End Wins</label>
                                      <div class="col-sm-6">
                                      <?php $start_w=$_REQUEST['start_w']; ?>
                                          <input type="number" class="form-control " readonly="" name="end_w" value="<?php echo (int)$start_w+(int)$tot_wins-1; ?>" required="">
                                      </div>
                                    </div>
                                    <div class="col-lg-2"></div>
                                  </div>
                                      <!-- //START WINS -->


                                      <!-- END WINS -->
                                      <!-- //END WINS -->

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
                                  </div>
                                      <!-- CLOSE MU -->

                                  <?php  } ?>
                                  <!-- [CLOSE] BL - TOTAL WINS - MIN. ALLOCATION -  TOT. ALLOCATION - AVA. ALLOCATION - M. UNIT -->

                                  <!-- OPEN TYPE OF TREES - TOTAL TREES -->
                                  <?php
                                  $mu = $_REQUEST['mu'] ;
                                    if ($mu) { ?>
                                   <?php $type_trees=$_REQUEST['type_trees'] ?>

                                   <!-- OPEN TYPE TREES -->
                                  <!-- <div class="form-group">
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
                                  </div> -->
                                  <!-- CLOSE TYPE TREES -->

                                  <?php

                                  $tot_trees=$_REQUEST['type_trees'];
                                 // echo $tot_trees;
                                  $id_trees=mysql_fetch_array(mysql_query("select * from t4t_pohon where nama_pohon like '%$tot_trees%'"));
                                 // echo $id_trees['id_pohon'];
                                  $id_mu=mysql_fetch_array(mysql_query("select * from t4t_mu where nama like '%$mu%'"));
                                 // echo $id_mu['kd_mu'];

                                  //echo $land;
                                  $jumlah_pohon=mysql_fetch_array(mysql_query("select count(*) from current_tree where kd_mu='$id_mu[0]' and used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 "));
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
                                      $unallocated=$total_allo-$pohon;
                                  ?>
                              <!-- close form -->
                              <?php
 
                                 //if submit check
                                 $cek=$_REQUEST['cek'];
                                 if ($cek) {
                                  date_default_timezone_set('Asia/Jakarta');
                                   $time=date("Y-m-d");
                                   $bl=$_REQUEST['bl'];
                                   $cek_order=mysql_fetch_array(mysql_query("select * from t4t_wins where no_order='$no_order' and no_shipment='$no_ship' limit 1"));
                                  
                                  if ($cek_order['id_part']==$id_comp[0]) {//Trees over allocation
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-warning"><strong>Warning</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      "No Order" and "No Shipment" have ever been processed... <br><font color="green">Ignore if all risks are understood</font>
                                                      
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                          <?php 
                                          if ($unallocated==0) {
                                             ?>
                                             <!-- SUBMIT BUTTON -->
                                          <form  id="form" action="action/blocking-process/index.php" method="post">
                                          <div align="center">
                                          <?php $pohon=$_REQUEST['total_trees'];
                                                $unallocated=$total_allo-$pohon;
                                          ?>

                                          <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                          <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                          <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                          <input type="hidden" name="tot_wins" value="<?php echo $tot_wins ?>">
                                          <input type="hidden" name="min_allo" value="<?php echo $item[0] ?>">
                                          <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                          <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                          <input type="hidden" name="ava_allo" value="<?php echo $ava_allo ?>">
                                          <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                          <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                          <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                          <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                          <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                          <input type="hidden" name="land" value="<?php echo $land ?>">
                                          


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
                                                              Please submit data now...
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </body>
                                          <!-- end modal -->
                                              <button type="submit" value="save" name="save" class="btn btn-primary"><i class="fa fa-save"> Submit</i></button>
                                              <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

                                          </div>
                                          </form>

                                             <?php
                                           }//end pass
                                          elseif ($unallocated > 0) {
                                        ?>
                                         <!-- SUBMIT BUTTON ke add 1-->
                                          <form  id="form" action="admin.php?c3b00eb86cd337880f1639111f2af716f86f51ed9f35a9b3ced72f3876350b3c" method="post">
                                          <div align="center">


                                          <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                          <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                          <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                          <input type="hidden" name="tot_wins" value="<?php echo $tot_wins ?>">
                                          <input type="hidden" name="min_allo" value="<?php echo $tot_wins[0] ?>">
                                          <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                          <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                          <input type="hidden" name="ava_allo" value="<?php echo $ava_allo ?>">
                                          <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                          <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                          <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                          <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                          <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                          <input type="hidden" name="land" value="<?php echo $land ?>">


                                          <!-- modal -->
                                          <body onLoad="$('#my-modal-unallo').modal('show');">
                                              <div id="my-modal-unallo" class="modal fade">
                                                  <div class="modal-dialog">
                                                      <div class="modal-content">
                                                          <div class="modal-header">
                                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                          <h4 class="modal-title alert alert-warning"> <strong>Data has been checked!</strong></h4>
                                                          </div>
                                                          <div class="modal-body">
                                                         <font color="red"> Tree < Total Tree Allocation </font><br>
                                                              Please add another trees...
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </body>
                                          <!-- end modal -->

                                              <button type="submit" value="save" name="save" class="btn btn-primary"><i class="fa fa-plus"> Add</i></button>
                                              <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

                                          </div>
                                          </form>
                                          <?php

                                           }//end unallocated
                                 }//end over

                                  
                                      //if unallocated
                                    elseif ($unallocated > 0) {
                                        ?>

                                 <!-- SUBMIT BUTTON ke add 1-->
                                  <form  id="form" action="admin.php?c3b00eb86cd337880f1639111f2af716f86f51ed9f35a9b3ced72f3876350b3c" method="post">
                                  <div align="center">


                                  <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                  <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $tot_wins ?>">
                                  <input type="hidden" name="min_allo" value="<?php echo $tot_wins[0] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="ava_allo" value="<?php echo $ava_allo ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">


                                  


                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-unallo').modal('show');">
                                      <div id="my-modal-unallo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-warning"> <strong>Data has been checked!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                 <font color="red"> Tree < Total Tree Allocation </font><br>
                                                      Please add another trees...
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->

                                      <button type="submit" value="save" name="save" class="btn btn-primary"><i class="fa fa-plus"> Add</i></button>
                                      <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

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

                                  <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                  <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $tot_wins ?>">
                                  <input type="hidden" name="min_allo" value="<?php echo $item[0] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="ava_allo" value="<?php echo $ava_allo ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">
                                  


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
                                                      Please submit data now...
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                      <button type="submit" value="save" name="save" class="btn btn-primary"><i class="fa fa-save"> Submit</i></button>
                                      <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

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

