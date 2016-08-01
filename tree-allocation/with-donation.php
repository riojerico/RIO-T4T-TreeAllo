<section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation With Donation</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>With Donation</li>
          </ol>
        </div>
      </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Form Tree Allocation With Donation
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
                                                echo "- Participants -";
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

                                  <!-- NO ORDER -->
                                  <?php
                                    $no_order = $_REQUEST['no_order'] ;
                                    if ($parts) {
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
                                              $data=mysql_query("select * from t4t_order where id_comp='$id_comp[0]' and acc='1' order by no desc");
                                              while ($data2=mysql_fetch_array($data)) {
                                                // for ($i=0; $i < 20 ; $i++) {
                                                $pisah=explode(", ", $data2['no_order']);
                                              ?>
                                              <option value="<?php echo $data2['no_order'] ?>"><?php echo $data2['no_order'] ?></option>
                                              <?php
                                                //}
                                              }
                                              ?>
                                          </select>
                                          <noscript><input type="submit" value="no_order"></noscript>
                                      </div>
                                  </div>
                                  <?php  }  ?>
                                  <!-- CLOSE NO ORDER -->

                                  <!-- NO SHIPMENT -->
                                  <?php
                                    $no_ship = $_REQUEST['no_ship'] ;
                                    if ($no_order) {
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
                                               
                                              $data=mysql_query("select * from t4t_shipment where id_comp='$id_comp[0]' and no_order like '%$no_order%' and wins_used not like '%-%' and wins_used not like '%,%' order by no desc");
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

                                    <!-- cek wins -->
                                  <div class="form-group">
                                  <?php 
                                    $win_number=$_REQUEST['win_num']; 
                                    $win_num=mysql_fetch_array(mysql_query("select wins_used from t4t_shipment where no_shipment='$no_ship' "));
                                  ?>
                                      <label class="col-sm-2 control-label">Wins Number</label>
                                      <div class="col-sm-10">
                                          <textarea type="" class="form-control" name="win_num" placeholder="<?php echo $win_num[0] ?>" readonly="" required><?php echo $win_num[0] ?></textarea>
                                      </div>
                                      <label class="col-sm-2 "></label>
                                      <div class="col-sm-10">
                                       <font color="red">*must be 1 wins</font>
                                       </div>
                                  </div>
                                      <!-- //cek wins -->


                                    <!-- OPEN TOTAL ALLO -->
                                  <div class="form-group">
                                  <?php $total_allo=$_REQUEST['total_allo'];
                                        $tersedia=mysql_fetch_array(mysql_query("select count(*) from current_tree where used=0 and hidup=1 and bl='' and no_shipment='' and koordinat!=''"));
                                   ?>

                                      <label class="col-sm-2 control-label">Total Allocation <b>(Tree)</b></label>
                                      <div class="col-sm-7">
                                          <input type="number" class="form-control a" onchange="hitung();" name="total_allo" value="<?php echo $total_allo;?>" required="" max="<?php echo $tersedia[0] ?>" min='1'>
                                      </div>
                                      <div class="col-sm-3">
                                          <input type="" class="form-control " name="tersedia" value="<?php  echo $tersedia[0];?> available trees" required="" readonly>
                                      </div>
                                  </div>
                                      <!-- CLOSE TOTAL ALLO -->                                     

                                  <?php  } 
                                  if ($no_ship) {

                                  ?>
                                  <!-- [CLOSE] BL - TOTAL WINS - MIN. ALLOCATION -  TOT. ALLOCATION - AVA. ALLOCATION - M. UNIT -->

                                  <div align="center">
                                  <button type="submit" name="cek" value="cek" class="btn btn-success"><i class="fa fa-check"> Check</i></button><br><br><br>
                                  </div>

                              </form>

                              <!-- close form -->
                              <?php
                                 //if submit check
                                 $cek=$_REQUEST['cek'];
                                 if ($cek) {
                             
                                   
                                   date_default_timezone_set('Asia/Jakarta');
                                   $time=date("Y-m-d");
                                   $bl=$_REQUEST['bl'];
                                   $cek_blocking=mysql_fetch_array(mysql_query("select * from current_tree where bl='$bl' and time='$time' limit 1"));
                                   // $cek_order=mysql_fetch_array(mysql_query("select * from t4t_wins where no_order='$no_order' and no_shipment='$no_ship' limit 1"));
                                   // $cek_jumlah_wins=mysql_fetch_array(mysql_query("select * from t4t_shipment where wins_used not like '%-%' and wins_used not like '%,%' and no_shipment='$no_ship'"));
                                   $cek_nomor_wins=mysql_fetch_array(mysql_query("select wins from t4t_wins where wins='$win_number'"));
                                  
                                  if ($cek_nomor_wins[0]==$win_number) {
                                    ?>
                                    <!-- modal -->
                                  <body onLoad="$('#my-modal-allo').modal('show');">
                                      <div id="my-modal-allo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-danger"><strong>Not Allowed!</strong></h4>
                                                  </div>
                                                  <div class="modal-body">
                                                  

                                                      Wins is already activated.
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->


                                  <?php  
                                  }
                                  else  { //jumlah wins 1
                                        ?>

                                  <!-- SUBMIT BUTTON -->
                                  <form  id="form" action="action/blocking-process/ac_donation.php" method="post">
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
                                  <input type="hidden" name="win_num" value="<?php echo $win_number ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">
                                  <input type="hidden" name="log" value="<?php echo $_SESSION['id'] ?>">                              


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
                                                          <tr><!-- partisipan -->
                                                            <td>Participants</td>
                                                            <td>:</td>
                                                            <td><?php echo $parts ?></td>
                                                          </tr>
                                                          <tr><!-- no order -->
                                                            <td>Order Number</td>
                                                            <td>:</td>
                                                            <td><?php echo $no_order ?></td>
                                                          </tr>
                                                          <tr><!-- no ship -->
                                                            <td>Shipment Number</td>
                                                            <td>:</td>
                                                            <td><?php echo $no_ship ?></td>
                                                          </tr>
                                                          <tr><!-- bl -->
                                                            <td>BL Number</td>
                                                            <td>:</td>
                                                            <td><?php echo $bl ?></td>
                                                          </tr>
                                                          <tr><!-- Wins Number -->
                                                            <td><B>WINS</B> Number</td>
                                                            <td>:</td>
                                                            <td><?php echo $win_number ?></td>
                                                          </tr>
                                                          <tr><!-- tot tree -->
                                                            <td>Tot. Allocation <b>TREE</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $total_allo ?></td>
                                                          </tr>
                                                         
                                                          
                                                          
                                                        </table>
                                                        <br><br>

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
                              }
                                }//end check
                      }
                                  ?>
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