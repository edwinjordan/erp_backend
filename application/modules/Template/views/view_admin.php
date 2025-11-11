<?php 

$user = $this->session->userdata('username');
if(!$user){
redirect("/");
}else{
  
?>
<!DOCTYPE html>
<html lang="en">

<!--================================================================================
  Item Name: Materialize - Material Design Admin Template
  Version: 3.1
  Author: GeeksLabs
  Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LARIS 32 KONFEKSI</title>
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  <?php
    // Page Title
    if(isset($theme['assets']['header']['title'])){
      echo $this->template->get_title() . "\n";
    }

    // Meta Tags
    if(isset($theme['assets']['header']['meta'])) {
      foreach($this->template->get_meta() as $meta_tag) {
        echo $meta_tag . "\n";
      }
    }

    // Custom CSS Files
    if(isset($theme['assets']['header']['css'])) {
      foreach($this->template->get_css() as $css_file) {
        echo $css_file . "\n";
      }
    }

    // Custom JS Files
    if(isset($theme['assets']['header']['js'])) {
      foreach($this->template->get_js('header') as $js_file) {
        echo $js_file . "\n";
      }
    }
  ?>  

  <style>   
    .item-transition {
      transition: opacity .5s ease;
    }
    .item-enter {
      opacity: 0;
    }
    .item-leave {
      opacity: 0;   
      display: none;
      position: absolute;   
    }
    .fade-transition {
      transition: opacity .3s ease;
    }
    .fade-enter, .fade-leave {
      opacity: 0;
    }

    @media (max-width: 1024px) {
      .menu-container {
        width: auto;
      }
    }
    
  </style>
  <script type="text/javascript">
      BASE_URL = '<?php echo base_url();?>';
    </script>
</head>

<body>

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START HEADER -->
<header class="fixed-header">
  <div class="header-top">
    <div class="container">
      <div class="pull-left">
        <a href="<?php echo base_url().'dashboard'; ?>" class="logo">LARIS 32 KONFEKSI</a>
      </div>
      <!-- /.pull-left -->
      <div class="pull-right">
        <div class="ico-item hidden-on-desktop">
          <button type="button" class="menu-button js__menu_button fa fa-bars waves-effect waves-light"></button>
        </div>
      
        <div class="ico-item">
          <a href="#" class="ico-item fa fa-user js__toggle_open" data-target="#user-status"></a>
          <div id="user-status" class="user-status js__toggle">
            <a href="#" class="avatar"><img src="http://placehold.it/80x80" alt=""><span class="status online"></span></a>
            <h5 class="name"><a href="profile.html"><?php echo $user; ?></a></h5>
            <!-- <h5 class="position">Administrator</h5> -->
            <!-- /.name -->
            <div class="control-items">
              <!-- <div class="control-item"><a href="#" title="Settings"><i class="fa fa-gear"></i></a></div> -->
              <div class="control-item"><a href="<?php echo base_url(); ?>Auth/logout"  title="Log out"><i class="fa fa-power-off"></i></a></div>
            </div>
            <!-- /.control-items -->
          </div>
          <!-- /#user-status -->
        </div>
        <!-- /.ico-item -->
      </div>
      <!-- /.pull-right -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.header-top -->

  <nav class="nav-horizontal" style="display: flex; align-items: center; justify-content: center;">
    <button type="button" class="menu-close hidden-on-desktop js__close_menu"><i class="fa fa-times"></i><span>CLOSE</span></button>
    <div class="menu-container" style="">
      
      <ul class="menu js__accordion">
          <?php
                $id_level=$this->session->userdata('id_posisi');
                $main_menu=$this->db->join('mainmenu','mainmenu.idmenu=tab_akses_mainmenu.id_menu')
                                    ->where('tab_akses_mainmenu.id_level',$id_level)
                                    ->where('tab_akses_mainmenu.r','1')
                                    ->order_by('mainmenu.idmenu','asc')
                                    ->get('tab_akses_mainmenu')
                                    ->result();
                foreach ($main_menu as $rs) {
                ?>
                <?php
                $row = $this->db->where('mainmenu_idmenu',$rs->idmenu)->get('submenu')->num_rows();
                    if($row>0){
                        $sub_menu=$this->db->join('submenu','submenu.id_sub=tab_akses_submenu.id_sub_menu')
                                           ->where('submenu.mainmenu_idmenu',$rs->idmenu)
                                           ->where('tab_akses_submenu.id_level',$id_level)
                                           ->where('tab_akses_submenu.r','1')
                                           ->get('tab_akses_submenu')
                                           ->result();
          ?>          
          <li class="has-sub">
            <a href="#" class="js__control"  style="overflow: hidden">
              <i class="<?=$rs->icon_class?>"></i>
              <span><?=$rs->nama_menu?></span>
            </a>
                       <!--  <ul class="sub-menu single js__content"> -->
                        <?php
                        echo "<ul class='sub-menu single js__content'>";
                        foreach ($sub_menu as $rsub){
                        ?>  
                          <li><a href="<?=base_url().$rsub->link_sub?>"> <?=$rsub->nama_sub?></a></li>
                        <?php
                        }
                            echo "</ul>";
                        }else{ 
                        ?>
                        <!-- /.sub-menu single -->
          </li>
           <li class="has-sub">
            <a href="<?=base_url().$rs->link_menu?>" class="" style="overflow: hidden">
              <i class="<?=$rs->icon_class?>"></i>
              <span><?=$rs->nama_menu?></span>
            </a>
                        <!-- /.sub-menu single -->
          </li>

          <?php
                        }
                        }
                        ?>
                        <?php
                            if ($id_level==1){?>
                    
                        <?php
                        }
                        ?>
       
      </ul>
      <!-- /.menu -->
    </div>
    <!-- /.container -->
  </nav>
 
  <!-- /.nav-horizontal -->
</header>
<?php } ?>
  <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->
<!--   <div id="wrapper">
    <div class="main-content container-fluid"> -->
    <!-- START MAIN -->
      <!-- START WRAPPER -->
     
        <!-- START LEFT SIDEBAR NAV-->
     
        <!-- END LEFT SIDEBAR NAV-->
        
        <!-- //////////////////////////////////////////////////////////////////////////// -->
            <?php 
                if(isset($content)) {
                    echo $content;
                }
            ?>
       <!-- 
       </div>
  </div>  --> 
      <!-- LEFT RIGHT SIDEBAR NAV-->
    <!-- END WRAPPER -->
  <!-- END MAIN -->



  <!-- //////////////////////////////////////////////////////////////////////////// -->
  <?php  
      if(isset($parts['footer'])) {
            echo $parts['footer'];
        }   
  ?>
  
  <?php
        // Custom JS Files
        if(isset($theme['assets']['footer']['js'])) {
            foreach($this->template->get_js('footer') as $js_file) {
                echo $js_file . "\n";
            }
        }

    ?>
    
    
</body>

</html>