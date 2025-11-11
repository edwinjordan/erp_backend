<?php
	class MY_Controller extends CI_Controller{
		
	}
	class MY_Admin extends MY_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->library('template');
        	$this->template->set_platform('public');
        	$this->template->set_theme('admin-lte');  
			// if($this->session->userdata("admin_username") == FALSE){
			// 	redirect("Login/");
			// }
			$this->_loadcss();
        	$this->_loadjs();
        	$this->_loadpart();
			
		}

	protected function _loadpart() {
       // $data_header['active'] = 'beranda';
      //  $this->template->set_part('navbar', 'Template/view_menu');
       // $data_footer['footer'] = $this->M_home->view('setting_ukuran');        
        $this->template->set_part('footer', 'Template/footer');
    }


    protected function _loadcss() {  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/styles/style-horizontal.min.css', 'remote');        
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css', 'remote');

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/waves/waves.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/sweet-alert/sweetalert.css','remote');  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/css/dataTables.bootstrap.min.css','remote'); 
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css','remote');  

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/chart/chartist/chartist.min.css','remote'); 

        // $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/fullcalendar/fullcalendar.min.css','remote'); 
        // $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/fullcalendar/fullcalendar.print.css','remote');
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/color-switcher/color-switcher.min.css','remote');
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/select2/css/select2.min.css','remote');    

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal.css','remote');
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal-default-theme.css','remote');  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/dropify/css/dropify.min.css','remote');        
        
        //$this->template->set_css('skin-blue.min.css');    
    }

    protected function _loadjs() {    
       
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/jquery.min.js','header', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/modernizr.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/bootstrap/js/bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/nprogress/nprogress.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/sweet-alert/sweetalert.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/waves/waves.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/fullscreen/jquery.fullscreen-min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/select2/js/select2.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/percircle/js/percircle.js','footer', 'remote');

        $this->template->set_js('https://www.gstatic.com/charts/loader.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/chart/chartist/chartist.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/chart.chartist.init.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/moment/moment.js','footer', 'remote');

        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/fullcalendar/fullcalendar.min.js','footer', 'remote');
        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/fullcalendar.init.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/main.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/horizontal-menu.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/horizontal-menu.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/color-switcher/color-switcher.min.js','footer', 'remote');


        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/js/jquery.dataTables.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/js/dataTables.bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/js/dataTables.responsive.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/js/responsive.bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/datatables.demo.min.js','footer', 'remote');

        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/myscript.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/dropify/js/dropify.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/fileUpload.demo.min.js','footer', 'remote');
       
    }


	}


    class MY_Admin2 extends MY_Controller{
        
        public function __construct(){
            parent:: __construct();
            $this->load->library('template');
            $this->template->set_platform('public');
            $this->template->set_theme('admin-lte');  
            // if($this->session->userdata("admin_username") == FALSE){
            //  redirect("Login/");
            // }
            $this->_loadcss();
            $this->_loadjs();
            $this->_loadpart();
            
        }

    protected function _loadpart() {
       // $data_header['active'] = 'beranda';
        $this->template->set_part('navbar', 'Template/view_menu');
       // $data_footer['footer'] = $this->M_home->view('setting_ukuran');        
        $this->template->set_part('footer', 'Template/footer');
    }


    protected function _loadcss() {  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/styles/style-horizontal.min.css', 'remote');        
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css', 'remote');

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/waves/waves.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/sweet-alert/sweetalert.css','remote');  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/css/dataTables.bootstrap.min.css','remote'); 
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css','remote');  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/flexdatalist/jquery.flexdatalist.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/popover/jquery.popSelect.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/select2/css/select2.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/select2/css/select2.min.css','remote');    

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal.css','remote');
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal-default-theme.css','remote');  

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/color-switcher/color-switcher.min.css','remote');      
        
        //$this->template->set_css('skin-blue.min.css');    
    }

    protected function _loadjs() {    
       
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/jquery.min.js','header', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/modernizr.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/bootstrap/js/bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/nprogress/nprogress.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/sweet-alert/sweetalert.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/waves/waves.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/fullscreen/jquery.fullscreen-min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/select2/js/select2.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/percircle/js/percircle.js','footer', 'remote');

        $this->template->set_js('https://www.gstatic.com/charts/loader.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/chart/chartist/chartist.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/chart.chartist.init.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/moment/moment.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/fullcalendar/fullcalendar.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/fullcalendar.init.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/main.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/horizontal-menu.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/horizontal-menu.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/color-switcher/color-switcher.min.js','footer', 'remote');


        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/js/jquery.dataTables.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/js/dataTables.bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/js/dataTables.responsive.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/js/responsive.bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/datatables.demo.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/myscript.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/form.demo.min.js','footer', 'remote');
       
    }


    }

    class MY_Admin3 extends MY_Controller{
        
        public function __construct(){
            parent:: __construct();
            $this->load->library('template');
            $this->template->set_platform('public');
            $this->template->set_theme('admin-lte');  
            // if($this->session->userdata("admin_username") == FALSE){
            //  redirect("Login/");
            // }
            $this->_loadcss();
            $this->_loadjs();
            $this->_loadpart();
            
        }

    protected function _loadpart() {
       // $data_header['active'] = 'beranda';
        $this->template->set_part('navbar', 'Template/view_menu');
       // $data_footer['footer'] = $this->M_home->view('setting_ukuran');        
        $this->template->set_part('footer', 'Template/footer');
    }


    protected function _loadcss() {  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/styles/style-horizontal.min.css', 'remote');        
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css', 'remote');

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/waves/waves.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/sweet-alert/sweetalert.css','remote');  
        // $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/css/dataTables.bootstrap.min.css','remote'); 
        // $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css','remote');  
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/flexdatalist/jquery.flexdatalist.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/popover/jquery.popSelect.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/select2/css/select2.min.css','remote'); 

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/select2/css/select2.min.css','remote');    

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal.css','remote');
        $this->template->set_css(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal-default-theme.css','remote');  

        $this->template->set_css(base_url().'assets/public/themes/admin-lte/color-switcher/color-switcher.min.css','remote');      
        
        //$this->template->set_css('skin-blue.min.css');    
    }

    protected function _loadjs() {    
       
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/jquery.min.js','header', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/modernizr.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/bootstrap/js/bootstrap.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/nprogress/nprogress.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/sweet-alert/sweetalert.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/waves/waves.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/fullscreen/jquery.fullscreen-min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/select2/js/select2.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/percircle/js/percircle.js','footer', 'remote');

        $this->template->set_js('https://www.gstatic.com/charts/loader.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/chart/chartist/chartist.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/chart.chartist.init.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/moment/moment.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/fullcalendar/fullcalendar.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/fullcalendar.init.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/main.min.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/horizontal-menu.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/horizontal-menu.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/color-switcher/color-switcher.min.js','footer', 'remote');


        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/js/jquery.dataTables.min.js','footer', 'remote');

        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/media/js/dataTables.bootstrap.min.js','footer', 'remote');
        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/js/dataTables.responsive.min.js','footer', 'remote');

        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/js/responsive.bootstrap.min.js','footer', 'remote');
        // $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/datatables.demo.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/myscript.js','footer', 'remote');
        $this->template->set_js(base_url().'assets/public/themes/admin-lte/plugin/modal/remodal/remodal.min.js','footer', 'remote');

        $this->template->set_js(base_url().'assets/public/themes/admin-lte/scripts/form.demo.min.js','footer', 'remote');
       
    }


    }

	// class MY_Pegawai extends MY_Controller{
		
	// 	public function __construct(){
	// 		parent:: __construct();
	// 		if($this->session->userdata("username_pegawai") == FALSE){
	// 			redirect("Supir/");
	// 		}
			
	// 	}
	// }
	// class MY_Ukm extends MY_Controller{
		
	// 	public function __construct(){
	// 		parent:: __construct();
	// 		if($this->session->userdata("ukm") == FALSE ){
	// 			redirect("login/");
	// 		}
			
	// 	}
	// }
	// class MY_User extends MY_Controller{
		
	// 	public function __construct(){
	// 		parent:: __construct();
	// 		if($this->session->userdata("user") == FALSE ){
	// 			redirect("login/");
	// 		}
			
	// 	}
	// }
	
?>