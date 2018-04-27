<?php
class renderer
{
    function __construct()
    {
        $this->theme_uri = NULL;
        $this->theme_img_uri = '//' . $_SERVER['HTTP_HOST'] . '/themes/syncard/images';
        $this->add_resource();
        add_document_ready_js("$.map(ajax_fun, function(value, key) { fn = ajax_fun[key]; if(typeof fn === 'function') { fn(); } });");
        $this->setup_wizard = module_control_load('wizard','setup');
        $this->setup_wizard->run();
        $this->setup_wizard->status_show();
    }

    function wa_header() {page(_($help_context = "Main Menu"), false, true); }

    function wa_footer() { end_page(false, true); }

    function menu_header($title, $no_menu, $is_index, $button_reload = false)
    {
        global $help_base_url, $db_connections, $power_by;

        $logo = null;
        $home = site_url();

        echo '<div class="main">';

         /*language*/
        $lang_session = $_SESSION['SysPrefs']->prefs['coy_def_language'];
        echo "<input name='lang_session' type='hidden' value='".$lang_session."'>";

        //header
        if (!$no_menu) {
            $waapp = $_SESSION['App'];
            module_view('header',array('title'=>$title,'apps'=>$_SESSION['App']->applications),true, false,'html' );
            $cur = get_company_Pref('coy_name');
            add_access_extensions();
        }

        /*content*/
        // echo '<div class="row">';

        /*breadcrumb*/
        // if ($title && ! $is_index) {
            $page_description = NULL;
            module_view('page_header',array('title'=>$title,'page_description'=>$page_description),true, false,'html' );
        // } else {
            // echo
            // '<div class="page-head white z-depth-1">
            //   <h5><span class="badge"><a href="#!" class="grey-text dropdown-button" data-activates="account-options"><i class="material-icons">settings</i></a></span><b>UNIQ365 BUSINESS SYSTEM</b></h5>
            //   <!--p>COMPANY: '.get_company_Pref('coy_name').'</p-->
            // </div>';

            // echo '
            // <div class="navbar-fixed z-depth-2">
            //   <nav class="blue accent-2">
            //     <div class="row">
            //     <div class="col s12">
            //     <div class="nav-wrapper">
            //       <ul>
            //         <li><a href="#" data-target="slide-out" class="button-menu"><i class="material-icons">menu</i></a></li>
            //         <li><a href="#" class="brand-logo">Home</a></li>
            //       </ul>
            //       <ul class="right account-menu">
            //         <li><a href="#"><i class="material-icons">notifications</i></a></li>
            //         <li><a href="#!" data-activates="account-options" class="img-container dropdown-button"><img src="/assets/images/default-avatar.png"/></a></li>
            //       </ul>
            //     </div>
            //     </div>
            //     </div>
            //   </nav>
            // </div>';
        // }

        echo '<div class="clearfix"></div>';
        echo '<div class="container inner">';
        echo '<div class="page-content row">';
        if (isset($_GET['application']) && $_GET['application'] == 'H') {
            $dashboard = module_control_load('dashboard','dashboard');
            $dashboard->home();
        }

        $this->setup_wizard->status_show();
    }

    function display_applications($app){}

    function menu_footer($no_menu, $is_index)
    {
        global $Pagehelp, $Ajax, $power_url, $power_by, $power_company;

        echo '</div>'; //page-content
        echo '</div>'; //container
        // echo '</div>'; //row

        if ($no_menu == false) {
            $data = array('phelp'=>NULL,'power_url'=>$power_url,'power_by'=>$power_by,'power_company'=>$power_company);
            if (isset($_SESSION['wa_current_user'])) {
                $phelp = implode(' | ', $Pagehelp);
                $Ajax->addUpdate(true, 'hotkeyshelp', $phelp);
                $data['phelp'] = $phelp;
            }
            module_view('page_footer',$data,true, false,'html' );
        }

        echo "</div>"; //page-wrapper
    }


    var $css = array(
        'bootstrap-custom.css',
        'layout.css'
    );

    private function add_resource(){
        global $assets_path, $js_userlib;

        // add_css_source($assets_path.'plugins/simple-line-icons/simple-line-icons.min.css');
        // add_css_source($assets_path.'plugins/datatables/datatables.min.css');
        // add_css_source($assets_path.'plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
        // add_css_source($assets_path.'plugins/bootstrap-table/bootstrap-table.css');
        // add_css_source($assets_path.'plugins/bootstrap-select/css/bootstrap-select.css');

        foreach ($this->css as $css) {
            add_css_source($assets_path.user_theme() . '/css/' . $css);
        }

        // add_js_source($assets_path.user_theme(). '/global/scripts/app.js');
        // add_js_source($assets_path.user_theme(). '/scripts/layout.js');
        // add_js_source($assets_path.'plugins/bootstrap-table/bootstrap-table.js');
        // add_js_source($assets_path.'plugins/bootstrap-select/js/bootstrap-select.js');
        // add_js_source($assets_path.'plugins/bootstrap-modal/js/bootstrap-modalmanager.js');
        // add_js_source($assets_path.'docxtemplater/node_modules/docxtemplater/build/docxtemplater.js');
        // add_js_source($assets_path.'docxtemplater/node_modules/docxtemplater/vendor/FileSaver.min.js');
        // add_js_source($assets_path.'docxtemplater/node_modules/docxtemplater/vendor/jszip-utils.js');
        add_js_source($assets_path.'js/modal.js');
        add_js_source($assets_path.'js/syncard.js');
        add_js_source($assets_path.'syncard/scripts/layout.js');
    }
}
