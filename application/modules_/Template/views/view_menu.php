 <nav class="nav-horizontal">
    <button type="button" class="menu-close hidden-on-desktop js__close_menu"><i class="fa fa-times"></i><span>CLOSE</span></button>
    <div class="container menu-container" style="">
      
      <ul class="menu js__accordion">
          <?php
                $id_level=$this->session->userdata('id_posisi');
                $main_menu=$this->db->join('mainmenu','mainmenu.idmenu=tab_akses_mainmenu.id_menu')
                                    ->where('tab_akses_mainmenu.id_level',$id_level)
                                    ->where('tab_akses_mainmenu.r','1')
                                    ->order_by('mainmenu.idmenu','asc')
                                    ->get('tab_akses_mainmenu')
                                    ->result();
                print_r($this->db->last_query());                    
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