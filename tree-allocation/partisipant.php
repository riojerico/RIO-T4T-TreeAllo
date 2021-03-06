
          <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation With Shipments</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>for Partisipant</li>
          </ol>
        </div>
      </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Form Tree Allocation for Partisipant
                          </header>
                          <div class="panel-body">

                              <!-- Form -->
                              <form class="form-horizontal " method="post">

                              <!-- PARTISIPAN -->
                              <?php $parts=$_REQUEST['partisipan'] ?>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">Partisipan</label>
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
                                              $data=mysql_query("select * from t4t_shipment where id_comp='$id_comp[0]' and blocked='0' order by no_shipment asc");
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

                                  <!-- cek no order -->
                                  <?php  
                                  $no_ship = $_REQUEST['no_ship'] ;
                                  $cek_no=mysql_fetch_array(mysql_query("select * from t4t_order a where no_order='$no_order' and no_ship like '%$no_ship%'"));
                                   $cek_no['no_order'];
                                  ?>
                                  <!-- end cek no order -->

                              <!-- blocked = 1 -->
                                  <?php  
                                  if ($no_order && $cek_no['no_order']!="") {
                                  ?>
                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Your "No Order" has been blocked!</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      Please choose another "No Order"...
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <?php
                                  }
                                  ?>
                              <!-- end blocked = 1 -->

                                  <!-- [OPEN] BL - TOTAL WINS - MIN. ALLOCATION -  TOT. ALLOCATION - AVA. ALLOCATION - M. UNIT -->
                                  <?php
                                    $no_order  =$_REQUEST['no_order'];

                                    if ($no_order && $cek_no['no_order']=="") {

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
                                      <label class="col-sm-2 control-label">Total WINS</label>
                                      <?php
                                        $tot_wins=mysql_fetch_array(mysql_query("select jml_wins from t4t_order where no_order='$no_order'"));

                                        // $data_totwins=mysql_fetch_array(mysql_query("select a.jml_wins from t4t_order a, t4t_shipment b where a.no_order=b.no_order"));
                                        //   $no_order=mysql_fetch_array(mysql_query("select no_order from t4t_shipment where no_shipment='$no_ship'"));

                                  // [[IF WITH LOOPING]]
                                       // $res=0;
                                       // for ($i=0; $i < 100; $i++) {
                                       //    $pisah=explode(", ", $no_order[0]);
                                       //   //   echo $pisah[$i]."<br>";
                                       //    $data_no_order=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[$i]'"));

                                       //    $data_no_order2=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[2]'"));
                                       //    $data_no_order19=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[19]'"));

                                       //    // $wins_per_order=$data_no_order['jml_wins']."+" ;
                                       //    $wins_per_order=$data_no_order['jml_wins'];
                                       //    $wins_per_order1=$data_no_order1['jml_wins'];
                                       //    $wins_per_order2=$data_no_order1['jml_wins'];
                                       //    $wins_per_order19=$data_no_order1['jml_wins'];

                                       //   //print_r ($wins_per_order[0]);

                                       //    ECHO "<BR>";

                                       //  }
                                    // [[CLOSE LOOPING ]]

                                    // [[PROSES MANUAL]]
                                        // $pisah=explode(", ", $no_order[0]);
                                        // //Hanya dapat memproses 20 Order
                                        // $data_no_order1=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[0]'"));
                                        // $data_no_order2=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[1]'"));
                                        // $data_no_order3=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[2]'"));
                                        // $data_no_order4=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[3]'"));
                                        // $data_no_order5=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[4]'"));
                                        // $data_no_order6=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[5]'"));
                                        // $data_no_order7=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[6]'"));
                                        // $data_no_order8=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[7]'"));
                                        // $data_no_order9=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[8]'"));
                                        // $data_no_order10=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[9]'"));
                                        // $data_no_order11=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[10]'"));
                                        // $data_no_order12=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[11]'"));
                                        // $data_no_order13=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[12]'"));
                                        // $data_no_order14=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[13]'"));
                                        // $data_no_order15=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[14]'"));
                                        // $data_no_order16=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[15]'"));
                                        // $data_no_order17=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[16]'"));
                                        // $data_no_order18=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[17]'"));
                                        // $data_no_order19=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[18]'"));
                                        // $data_no_order20=mysql_fetch_array(mysql_query("select * from t4t_order where no_order='$pisah[19]'"));

                                        // $w1=$data_no_order1['jml_wins'];
                                        // $w2=$data_no_order2['jml_wins'];
                                        // $w3=$data_no_order3['jml_wins'];
                                        // $w4=$data_no_order4['jml_wins'];
                                        // $w5=$data_no_order5['jml_wins'];
                                        // $w6=$data_no_order6['jml_wins'];
                                        // $w7=$data_no_order7['jml_wins'];
                                        // $w8=$data_no_order8['jml_wins'];
                                        // $w9=$data_no_order9['jml_wins'];
                                        // $w10=$data_no_order10['jml_wins'];
                                        // $w11=$data_no_order11['jml_wins'];
                                        // $w12=$data_no_order12['jml_wins'];
                                        // $w13=$data_no_order13['jml_wins'];
                                        // $w14=$data_no_order14['jml_wins'];
                                        // $w15=$data_no_order15['jml_wins'];
                                        // $w16=$data_no_order16['jml_wins'];
                                        // $w17=$data_no_order17['jml_wins'];
                                        // $w18=$data_no_order18['jml_wins'];
                                        // $w19=$data_no_order19['jml_wins'];
                                        // $w20=$data_no_order20['jml_wins'];

                                        // $hasil= $w1+$w2+$w3+$w4+$w5+$w6+$w7+$w8+$w9+$w10+$w11+$w12+$w13+$w14+$w15+$w16+$w17+$w18+$w19+$w20;
                                      //[[CLOSE MANUAL]]
                                      ?>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" readonly="" name="tot_wins" value="<?php echo $tot_wins[0]; ?>" required>
                                      </div>
                                  </div>
                                      <!-- CLOSE TOTAL WINS -->

                                      <!-- OPEN MIN. ALLO -->
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label">Minimum Allocation</label>

                                      <?php
                                      $item=mysql_fetch_array(mysql_query("select item_qty from t4t_shipment where no_shipment='$no_ship'")); ?>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control b" name="min_allo" readonly="" value="<?php echo $tot_wins[0]; ?>" required>
                                      </div>
                                  </div>
                                      <!-- CLOSE MIN. ALLO -->

                                      <!-- OPEN TOTAL ALLO -->
                                  <div class="form-group">
                                  <?php $total_allo=$_REQUEST['total_allo'];
                                  //echo $total_allo; ?>

                                      <label class="col-sm-2 control-label">Total Allocation</label>
                                      <div class="col-sm-10">
                                          <input type="number" class="form-control a" onchange="hitung();" readonly="" name="total_allo" value="<?php echo $tot_wins[0];?>" required="" min="<?php echo $tot_wins[0] ?>">
                                      </div>
                                  </div>
                                      <!-- CLOSE TOTAL ALLO -->

                                      <!-- OPEN AVA ALLO -->
                                  <div class="form-group">
                                  <?php $ava_allo=$_REQUEST['ava_allo']; ?>
                                      <label class="col-sm-2 control-label c">Available Allocation</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control c" readonly="" name="ava_allo" value="<?php echo $ava_allo ?>" required>
                                      </div>
                                      <label class="col-sm-2 "></label>
                                      <div class="col-sm-10">
                                       <font color="red">*data can not be negative</font>
                                       </div>
                                  </div>
                                      <!-- CLOSE AVA ALLO -->


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
                                  $jumlah_pohon=mysql_fetch_array(mysql_query("select count(*) from view_t4t_ct where used='0' and hidup='1' and koordinat!='' and kd_mu='$id_mu[0]' and id_pohon='$id_trees[0]'"));
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

                                   $unallocated;
                                      //if unallocated
                                      if ($unallocated > 0) {
                                        ?>

                                 <!-- SUBMIT BUTTON -->
                                  <form  id="form" action="admin.php?4e8fa844acbd97b810cffdfc020424200c8befd0326d62ec7437ad3637ad87b9" method="post">
                                  <div align="center">


                                  <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                  <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $tot_wins[0] ?>">
                                  <input type="hidden" name="min_allo" value="<?php echo $tot_wins[0] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="ava_allo" value="<?php echo $ava_allo ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
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

                                      <button type="submit" value="save" name="save" class="btn btn-primary"><i class="fa fa-save"> Submit</i></button>
                                      <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

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

                                  <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                  <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $tot_wins[0] ?>">
                                  <input type="hidden" name="min_allo" value="<?php echo $item[0] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="ava_allo" value="<?php echo $ava_allo ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">


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

