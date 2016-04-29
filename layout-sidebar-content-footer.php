    <?php 
        error_reporting(0);
        include './assets/lib-encript/function.php';
    ?>
     <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">                
                  <li class="">
                      <a class="" href="admin.php?3ad70a78a1605cb4e480205df880705c">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="fa fa-tree"></i>
                          <span>Tree Allocation</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="?<?php echo paramEncrypt('hal=with-shipment')?>">With Shipment</a></li> 
                          <li><a class="" href="?<?php echo paramEncrypt('hal=with-container')?>">With Container</a></li> 
                          <li><a class="" href="?<?php echo paramEncrypt('hal=with-donation')?>">With Donation</a></li>  
                          <li><a class="" href="?<?php echo paramEncrypt('hal=with-donation-rev')?>">With Donation Rev</a></li>  
                          <li><a class="" href="?<?php echo paramEncrypt('hal=with-donation-adding-mu-rev-3')?>">add 3</a></li>  
                          <li><a class="" href="?<?php echo paramEncrypt('hal=with-donation-adding-mu-rev-4')?>">add 4</a></li>


                      </ul>
                  </li>       
                
                  
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!--main content start-->
      <section id="main-content">
    <?php
    //untuk mendecode url yang di enrypsi
    $var=decode($_SERVER['REQUEST_URI']);
    
    //pecahkan nilai array
    $page=$var['hal'];
    
    //concate dengan nama file
    $halaman="tree-allocation/$page.php";
    
    //jika file yang diinclude tidak ada.
    if(!file_exists($halaman) || empty($page)){
        include "blank.html";
    }else{
        include "$halaman";
    }
    ?>
      </section>
      <!--main content end-->
  </section>
  <!-- container section start -->
