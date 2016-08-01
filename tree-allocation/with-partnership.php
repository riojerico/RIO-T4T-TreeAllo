<section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-tree"></i> Tree Allocation With Partnership</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="admin.php?3ad70a78a1605cb4e480205df880705c">Home</a></li>
            <li><i class="fa fa-tree"></i>Tree Allocation</li>
            <li><i class="fa fa-file-text-o"></i>With Partnership</li>
          </ol>
        </div>
      </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Form Tree Allocation With Partnership
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
                                              $data=mysql_query("select * from t4t_shipment where id_comp='$id_comp[0]' and acc_paid='1' and no_order!='' order by no desc");
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
                                  </div>
                                                                  

                                    <!-- OPEN TOTAL ALLO -->
                                  <div class="form-group">
                                  <?php $total_allo=$_REQUEST['total_allo'];
                                  //echo $total_allo; ?>

                                      <label class="col-sm-2 control-label">Total Allocation <b>(Tree)</b></label>
                                      <div class="col-sm-10">
                                          <input type="number" class="form-control a" onchange="hitung();" name="total_allo" value="<?php echo $total_allo;?>" required="" >
                                      </div>
                                  </div>
                                      <!-- CLOSE TOTAL ALLO -->

                                      <!-- Destination -->
                                      <?php $destination=mysql_fetch_array(mysql_query("select kota_tujuan from t4t_shipment where no_shipment='$no_ship'")) ?>
                                      <div class="form-group">
                                        <label class="col-sm-2 control-label">Destination</label>
                                        <div class="col-sm-10">
                                            <input type="" class="form-control" name="destination" value="<?php echo $destination[0] ?>" readonly="">
                                        </div>
                                      </div>
                                      <!-- Close Destination -->

                                      <!-- Note -->
                                      <?php $note=$_REQUEST['note'] ?>
                                      <div class="form-group">
                                        <label class="col-sm-2 control-label">Note</label>
                                        <div class="col-sm-8">
                                          <textarea class="form-control" name="note" placeholder="<?php $sh_note=mysql_fetch_array(mysql_query("select note from t4t_shipment where no_shipment='$no_ship'")); echo $sh_note[0]; ?>"><?php echo $note ?></textarea>
                                        </div>
                                      </div>
                                      <!-- Close Note -->

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
                                      <noscript><input type="submit" value='id_lahan'></noscript>
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
                                        $kd_petani_view=mysql_fetch_array(mysql_query("select kd_petani from add_jmlpohon_lahan where id_desa='$desa' group by kd_petani"));
                                        $data=mysql_query("select * from add_jmlpohon_lahan where id_desa='$desa' group by kd_petani");
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

                                
                                  <?php
                                  $tot_trees=$_REQUEST['type_trees'];
                                 // echo $tot_trees;
                                  $id_trees=mysql_fetch_array(mysql_query("select * from t4t_pohon where nama_pohon like '%$tot_trees%'"));
                                 // echo $id_trees['id_pohon'];
                                  $id_mu=mysql_fetch_array(mysql_query("select * from t4t_mu where nama like '%$mu%'"));
                                 // echo $id_mu['kd_mu'];
                                  //echo $land;
                                  $jumlah_pohon=mysql_fetch_array(mysql_query("select count(*) from add_jmlpohon_lahan where kd_mu='$id_mu[0]' and used=0 and bl='' and no_shipment='' and koordinat!='' and used=0 and hidup=1 and id_desa='$desa' and kd_petani='$petani'"));
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
                                   date_default_timezone_set('Asia/Jakarta');
                                   $time=date("Y-m-d");
                                   $bl=$_REQUEST['bl'];
                                  // $cek_blocking=mysql_fetch_array(mysql_query("select * from current_tree where bl='$bl' and time='$time' limit 1"));
                                   $cek_order=mysql_fetch_array(mysql_query("select * from t4t_wins where no_order='$no_order' and no_shipment='$no_ship' limit 1"));
                                  if ($cek_order['id_part']==$id_comp[0] && $unallocated>0) {// Order Ada dan Unallocated
                                  ?>
                                  <form  id="form" action="admin.php?3964ad8ca07227dec234962092ef676c2f8e9f23bcc4170dc360b7138a84d10a" method="post">
                                  <div align="center">


                                  <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                  <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $tot_wins ?>">
                                  <input type="hidden" name="min_allo" value="<?php echo $tot_wins[0] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="win_num" value="<?php echo $win_number ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">
                                  <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  <input type="hidden" name="petani" value="<?php echo $petani ?>">
                                  <input type="hidden" name="note" value="<?php echo $note ?>">

                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-"><strong>Warning!<br><font color="red">"No Order" and "No Shipment" have ever been processed...</font></strong></h4>
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
                                                          <tr><!-- destin -->
                                                            <td>Destination</td>
                                                            <td>:</td>
                                                            <td><?php echo $destination[0] ?></td>
                                                          </tr>
                                                          <tr><!-- mu -->
                                                            <td>Management Unit</td>
                                                            <td>:</td>
                                                            <td><?php echo $mu ?></td>
                                                          </tr>
                                                          <tr><!-- Village -->
                                                            <td>Village</td>
                                                            <td>:</td>
                                                            <td><?php
                                                            $nama_desa=mysql_fetch_array(mysql_query("select * from t4t_desa where id_desa='$desa'"));
                                                             echo $nama_desa['desa']; ?></td>
                                                          </tr>
                                                          <tr><!-- Farmer -->
                                                            <td>Farmer</td>
                                                            <td>:</td>
                                                            <td><?php 
                                                            $nama_petani=mysql_fetch_array(mysql_query("select * from t4t_petani where id_desa='$desa' and kd_petani='$petani'"));
                                                            echo $nama_petani['nm_petani']; ?></td>
                                                          </tr>
                                                          <tr><!-- note -->
                                                            <td>Note</td>
                                                            <td>:</td>
                                                            <td><?php echo $note ?></td>
                                                          </tr>
                                                        </table>
                                                        <br><br>
                                                      
                                                      <font color="green">Ignore if all risks are understood</font><br>
                                                      <font color="red"> Tree < Total Tree Allocation </font><br>
                                                      Please add another tree...
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->
                                  <button type="submit" value="save" name="save" class="btn btn-warning"><i class="fa fa-plus"> Add Tree</i></button>
                                      <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

                                  </div>
                                  </form>
     
                                         
                                          <?php
                                 }//end Order Ada dan Unallocated

                                 elseif ($cek_order['id_part']==$id_comp[0] && $unallocated==0) {// Order Ada dan Pass
                                  ?>
                                  <form  id="form" action="action/blocking-process/ac_partnership.php" method="post">
                                  <div align="center">
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
                                  <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  <input type="hidden" name="petani" value="<?php echo $petani ?>">  
                                  <input type="hidden" name="note" value="<?php echo $note ?>">

                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-over').modal('show');">
                                      <div id="my-modal-over" class="modal fade" align="center">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-"><strong>Warning!<br><font color="red">"No Order" and "No Shipment" have ever been processed...</font></strong></h4>
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
                                                          <tr><!-- destin -->
                                                            <td>Destination</td>
                                                            <td>:</td>
                                                            <td><?php echo $destination[0] ?></td>
                                                          </tr>
                                                          <tr><!-- mu -->
                                                            <td>Management Unit</td>
                                                            <td>:</td>
                                                            <td><?php echo $mu ?></td>
                                                          </tr>
                                                          <tr><!-- Village -->
                                                            <td>Village</td>
                                                            <td>:</td>
                                                            <td><?php
                                                            $nama_desa=mysql_fetch_array(mysql_query("select * from t4t_desa where id_desa='$desa'"));
                                                             echo $nama_desa['desa']; ?></td>
                                                          </tr>
                                                          <tr><!-- Farmer -->
                                                            <td>Farmer</td>
                                                            <td>:</td>
                                                            <td><?php 
                                                            $nama_petani=mysql_fetch_array(mysql_query("select * from t4t_petani where id_desa='$desa' and kd_petani='$petani'"));
                                                            echo $nama_petani['nm_petani']; ?></td>
                                                          </tr>
                                                          <tr><!-- note -->
                                                            <td>Note</td>
                                                            <td>:</td>
                                                            <td><?php echo $note ?></td>
                                                          </tr>
                                                        </table>
                                                        <br><br>
                                                      
                                                      <font color="green">Ignore if all risks are understood</font><br>
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
                                 }//end Order Ada dan Pass

                                      //if unallocated
                                    elseif ($unallocated > 0) {
                                        ?>

                                 <!-- SUBMIT BUTTON -->
                                  <form  id="form" action="admin.php?3964ad8ca07227dec234962092ef676c2f8e9f23bcc4170dc360b7138a84d10a" method="post">
                                  <div align="center">


                                  <input type="hidden" name="partisipan" value="<?php echo $parts ?>">
                                  <input type="hidden" name="no_ship" value="<?php echo $no_ship ?>">
                                  <input type="hidden" name="bl" value="<?php echo $data_ship['bl'] ?>">
                                  <input type="hidden" name="tot_wins" value="<?php echo $tot_wins ?>">
                                  <input type="hidden" name="min_allo" value="<?php echo $tot_wins[0] ?>">
                                  <input type="hidden" name="total_allo" value="<?php echo $total_allo ?>">
                                  <input type="hidden" name="mu" value="<?php echo $mu ?>">
                                  <input type="hidden" name="win_num" value="<?php echo $win_number ?>">
                                  <input type="hidden" name="type_trees" value="<?php echo $type_trees ?>">
                                  <input type="hidden" name="total_trees" value="<?php echo $pohon ?>">
                                  <input type="hidden" name="no_order" value="<?php echo $no_order ?>">
                                  <input type="hidden" name="unallocated" value="<?php echo $unallocated ?>">
                                  <input type="hidden" name="start_w" value="<?php echo $start_w ?>">
                                  <input type="hidden" name="land" value="<?php echo $land ?>">
                                  <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  <input type="hidden" name="petani" value="<?php echo $petani ?>">
                                  <input type="hidden" name="note" value="<?php echo $note ?>">

                                  


                                  <!-- modal -->
                                  <body onLoad="$('#my-modal-unallo').modal('show');">
                                      <div id="my-modal-unallo" class="modal fade">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title alert alert-warning"> <strong>Warning!</strong></h4>
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
                                                          <tr><!-- destin -->
                                                            <td>Destination</td>
                                                            <td>:</td>
                                                            <td><?php echo $destination[0] ?></td>
                                                          </tr>
                                                          <tr><!-- mu -->
                                                            <td>Management Unit</td>
                                                            <td>:</td>
                                                            <td><?php echo $mu ?></td>
                                                          </tr>
                                                          <tr><!-- Village -->
                                                            <td>Village</td>
                                                            <td>:</td>
                                                            <td><?php
                                                            $nama_desa=mysql_fetch_array(mysql_query("select * from t4t_desa where id_desa='$desa'"));
                                                             echo $nama_desa['desa']; ?></td>
                                                          </tr>
                                                          <tr><!-- Farmer -->
                                                            <td>Farmer</td>
                                                            <td>:</td>
                                                            <td><?php 
                                                            $nama_petani=mysql_fetch_array(mysql_query("select * from t4t_petani where id_desa='$desa' and kd_petani='$petani'"));
                                                            echo $nama_petani['nm_petani']; ?></td>
                                                          </tr>
                                                          <tr><!-- note -->
                                                            <td>Note</td>
                                                            <td>:</td>
                                                            <td><?php echo $note ?></td>
                                                          </tr>
                                                        </table>
                                                        <br><br>

                                                 <font color="red"> Tree < Total Tree Allocation </font><br>
                                                      Please add another tree...
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </body>
                                  <!-- end modal -->

                                      <button type="submit" value="save" name="save" class="btn btn-warning"><i class="fa fa-plus"> Add Tree</i></button>
                                      <a href="" name="" id="" class="btn btn-danger"><i class="fa fa-eraser"> Clear</i></a>

                                  </div>
                                  </form>
                                  <?php
                                   }//end unallocated
                                   elseif ($unallocated==0) {
                                     ?>
                                     <!-- SUBMIT BUTTON -->
                                  <form  id="form" action="action/blocking-process/ac_partnership.php" method="post">
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
                                  <input type="hidden" name="desa" value="<?php echo $desa ?>">
                                  <input type="hidden" name="petani" value="<?php echo $petani ?>">   
                                  <input type="hidden" name="note" value="<?php echo $note ?>">                         


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
                                                          <tr><!-- destin -->
                                                            <td>Destination</td>
                                                            <td>:</td>
                                                            <td><?php echo $destination[0] ?></td>
                                                          </tr>
                                                          <tr><!-- mu -->
                                                            <td>Management Unit</td>
                                                            <td>:</td>
                                                            <td><?php echo $mu ?></td>
                                                          </tr>
                                                          <tr><!-- Village -->
                                                            <td>Village</td>
                                                            <td>:</td>
                                                            <td><?php
                                                            $nama_desa=mysql_fetch_array(mysql_query("select * from t4t_desa where id_desa='$desa'"));
                                                             echo $nama_desa['desa']; ?></td>
                                                          </tr>
                                                          <tr><!-- Farmer -->
                                                            <td>Farmer</td>
                                                            <td>:</td>
                                                            <td><?php 
                                                            $nama_petani=mysql_fetch_array(mysql_query("select * from t4t_petani where id_desa='$desa' and kd_petani='$petani'"));
                                                            echo $nama_petani['nm_petani']; ?></td>
                                                          </tr>
                                                          <tr><!-- note -->
                                                            <td>Note</td>
                                                            <td>:</td>
                                                            <td><?php echo $note ?></td>
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