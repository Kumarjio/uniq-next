<?php

class SetupCompanySetup
{

    function __construct()
    {
        $this->bootstrap = get_instance()->bootstrap;
        get_instance()->auto_load_module('sales');
    }

    function index()
    {

    }

    var $fields = array(
            'coy_name'=>null,
            'coy_def_language'=>0,
            'gst_no'=>null,
            'tax_prd'=>null,
            'tax_last'=>null,
            'coy_no'=>null,
            'postal_address'=>null,
            'coy_logo'=>null,
            'phone'=>null,
            'fax'=>null,
            'email'=>null,
            'domicile'=>null,
            'use_dimension'=>null,
            'base_sales'=>null,
            'no_item_list' => 0,
            'no_customer_list' => 0,
            'no_supplier_list' => 0,
            'curr_default'=>null,
            'f_year'=>null,
            'time_zone' => 0,
//             'version_id'=>null,
            'add_pct'=>null,
            'login_tout'=>null,
            'round_to'=>null,
            'auto_curr_reval'=>null,
            'bcc_email'=>null,
            'self_bill_approval_ref'=>null,
            'self_bill_start_date'=>null,
            'self_bill_end_date'=>null
        )
        ;
    function form()
    {
        start_form(true);
        echo "<div class=card-panel>";
        $this->bootstrap->box_start("");
        $myrow = get_company_prefs();

        foreach ($this->fields as $field=>$v) {
            if (isset($myrow[$field]))
                $_POST[$field] = $myrow[$field];
        }

        if ($_POST['add_pct'] == - 1)
            $_POST['add_pct'] = "";

        $_POST['del_coy_logo'] = 0;
        row_start();
        col_start(4, 'col l12 s6');
            input_text_bootstrap( "Company Name (To appear on reports)", 'coy_name', $value = null, $title = null, $submit_on_change = false, $size = NULL, $max = NULL,'');
        col_end();
        col_start(4, 'col l4 s6');
            input_textarea_bootstrap(_("Address"), 'postal_address', $_POST['postal_address']);
        col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap( "Country", 'domicile');
        col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap("Phone Number",'phone');
        col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap("Fax Number",'fax');
        col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap(_("Email Address"), 'email');
        col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap(_("BCC Address For all outgoing mails"), 'bcc_email',$value = null, $title = null, $submit_on_change = false, $size = NULL, $max = NULL,'');
        col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap(_("Official Company Number"), 'coy_no');
        col_end();
      row_end();
      row_start();
        col_start(12, 'col s12'); echo "<hr style='margin-bottom:50px'/>"; col_end();
        col_start(4, 'col l4 s6');
            input_text_bootstrap(_("GST No."), 'gst_no');
        col_end();
        col_start(4, 'col l4 s6');
            currency_bootstrap(_("Home Currency"), 'curr_default');
        col_end();
        col_start(4, 'col l4 s6 offset-s6 pull-s6');
            fiscalyear_bootstrap(_("Fiscal Year"), 'f_year', $_POST['f_year']);
        col_end();
        col_start(4, 'col l4 s6');
          input_text_addon_bootstrap(_("Tax Periods"), 'tax_prd',null,'Months');
        col_end();
        col_start(4, 'col l4 s6');
            input_text_addon_bootstrap(_("Tax Last Period"), 'tax_last',null,'Months back');
        col_end();

            if ( config_ci('kastam') ) {
              // col_end();
              col_start(4, 'col l4 s6');
                $this->bootstrap->fieldset_start("Self Bill");
                input_text_bootstrap(_("Approval Ref"), 'self_bill_approval_ref');
                input_date_bootstrap(_("Start Date"), 'self_bill_start_date');
                input_date_bootstrap(_("End Date"), 'self_bill_end_date');
                $this->bootstrap->fieldset_end();
                col_end();
            } else {
                hidden('self_bill_approval_ref');
                hidden('self_bill_start_date');
                hidden('self_bill_end_date');
            }

        col_end();
        col_start(4, 'col l4 s6');
        /*language*/

        echo ' <input name="default_language" type="text" value="'.$_POST['coy_def_language'].'" hidden>
              <div class="input-box">
                <label class="col s12"><span synlang="syncard-language">Select Language</span></label>
                <div class="col s12">
                  <select name="coy_def_language">
                  </select>
                </div>
              </div>';

        col_end();
      row_end();
      row_start();
        col_start(12, 'col l12 s12'); echo "<hr style='margin-bottom:50px'/>"; col_end();
        col_start(4, 'col l12 s6');
          // input_label_bootstrap(_("Company Logo"),null, $myrow['coy_logo']);
        // 
          // file_bootstrap(_("New Company Logo"), 'pic','(jpg|png)','pic');
          echo '
            <label>New Company Logo</label>
            <div class="file-field input-field">
              <div class="btn">
                <span>File</span>
                <input type="file" name="pic" id="id" multiple>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload New Company Logo">
              </div>
            </div>
          ';
        // col_end();
        // col_start(4, 'col s4 col-sm-6');
        col_end();
        col_start(4, 'col l12 s6');
          check_bootstrap(_("Delete Company Logo"), 'del_coy_logo', $_POST['del_coy_logo']);
        col_end();
        col_start(4, 'col l4 s6');
          sales_types_bootstrap(_("Base for auto price calculations"), 'base_sales', $_POST['base_sales'], false, _('No base price list'));
        col_end();
        col_start(4, 'col l4 s6');
          input_text_addon_bootstrap(_("Add Price from Std Cost "), 'add_pct',null,'percent (%)');
        col_end();
        col_start(4, 'col l4 s6');
          $curr = get_currency($_POST['curr_default']);
          input_text_addon_bootstrap(_("Round to nearest"), 'round_to',null,$curr['hundreds_name']);
        col_end();
        // echo "<hr style='margin-bottom:50px'/>";
      row_end();
      row_start();
        col_start(12, 'col l12'); echo "<hr style='margin-bottom:10px'/>"; col_end();
        $this->bootstrap->fieldset_start("Search Setting");
        echo "<div class='col l4'>";
        check_bootstrap(_("Search Item List"), 'no_item_list');
        echo "</div>";

        echo "<div class='col l4'>";
        check_bootstrap(_("Search Customer List"), 'no_customer_list');
        echo "</div>";

        echo "<div class='col l4'>";
        check_bootstrap(_("Search Supplier List"), 'no_supplier_list');
        echo "</div>";
        // col_end();
        // col_start(4, 'col l4 s6');
//         label_row("", "&nbsp;");
        $this->bootstrap->fieldset_start("Work Session");
        echo "<div class='col l4'>";
        check_bootstrap(_("Automatic Revaluation Currency Accounts"), 'auto_curr_reval', $_POST['auto_curr_reval']);
        echo "</div>";
        echo "<div class='col l4'>";
        check_bootstrap(_("Time Zone on Reports"), 'time_zone', $_POST['time_zone']);
        echo "</div>";
        echo "<div class='col l4'>";
        input_text_addon_bootstrap(_("Login Timeout"), 'login_tout',null,'seconds');
        echo "</div>";

        hidden('coy_logo', input_val('coy_logo'));

        // col_end();
        row_end();

        $this->bootstrap->box_footer_start();
//         echo submit('update', _("Update"), false, '', 'default',"save");
        //submit('update', _("Update"), true, '', 'default',"save");
        submit('update', _("Update"), true, '', false ,"save");
        $this->bootstrap->box_end();
        echo "</div>";
        end_form();
        // -------------------------------------------------------------------------------------------------


    }

    function update()
    {
        $max_image_size = 500;
        $input_error = 0;

        if (! check_num('login_tout', 10)) {
            display_error(_("Login timeout must be positive number not less than 10."));
            set_focus('login_tout');
            $input_error = 1;
        }
        if (strlen($_POST['coy_name']) == 0) {
            $input_error = 1;
            display_error(_("The company name must be entered."));
            set_focus('coy_name');
        }

        if (isset($_FILES['pic']) && $_FILES['pic']['name'] != '') {
            $this->upload_logo();
            $filename_store = $_POST['coy_logo'];
        } else {
            $filename_store = NULL;
        }

        if (check_value('del_coy_logo')) {

            $filename = company_path() . "/images/" . clean_file_name(get_company_pref('coy_logo'));
            if (file_exists($filename)) {
                $result = unlink($filename);
                if (! $result) {
                    display_error(_('The existing image could not be removed'));
                    $input_error = 1;
                }
            }
            $_POST['coy_logo'] = "";
        }

        if ($_POST['add_pct'] == "")
            $_POST['add_pct'] = - 1;
        if ($_POST['round_to'] <= 0)
            $_POST['round_to'] = 1;

        if ($input_error != 1) {
            $value_array = get_post($this->fields);
            if (isset($filename_store) AND $filename_store ) {
                $value_array['coy_logo'] = $filename_store;
            }

            if (! $value_array['curr_default']) {
                unset($value_array['curr_default']);
            }
            update_company_prefs($value_array);

            $_SESSION['wa_current_user']->timeout = $_POST['login_tout'];
            display_notification_centered(_("Company setup has been updated."));
        }

        set_focus('coy_name');
    }

    private function upload_logo()
    {
        global $pic_width, $pic_height, $max_image_size;

        $result = $_FILES['pic']['error'];
        $filename = company_path() . "/images";

        if (! file_exists($filename)) {
            mkdir($filename);
        }

        $upload_file = clean_file_name($_FILES['pic']['name']);
        $filename .= "/" . $upload_file;
        $ext = pathinfo($filename);
        $store_file = $ext['filename'] . '-' . time() . '.' . $ext['extension'];
        $filename = str_replace($upload_file, $store_file, $filename);
        $input_error = false;
        // But check for the worst
        if (! in_array(substr(strtolower($filename), - 4), array(
            '.jpg',
            '.png',
            'jpeg'
        ))) {
            display_error(_('Only jpg and png files are supported - a file extension of .jpg or .png is expected'));
            $input_error = 1;
        } elseif ($_FILES['pic']['size'] > ($max_image_size * 1024)) { // File Size Check
            display_error(_('The file size is over the maximum allowed. The maximum size allowed in KB is') . ' ' . $max_image_size);
            $input_error = 1;
        } elseif ($_FILES['pic']['type'] == "text/plain") { // File type Check
            display_error(_('Only graphics files can be uploaded'));
            $input_error = 1;
        }

        // if (file_exists($filename)){
        // $ext = pathinfo($filename);

        // $filename_store = $store_file;
        // // $filename = company_path()."/images/".$filename_store;
        // // $result = unlink($filename);
        // // if (!$result){
        // // display_error(_('The existing image could not be removed'));
        // // $input_error = 1;
        // // }
        // } else {
        // $filename_store = $_POST['coy_logo'];
        // }

        if ($input_error != 1) {
            $result = move_uploaded_file($_FILES['pic']['tmp_name'], $filename);
            // $_POST['coy_logo'] = clean_file_name($_FILES['pic']['name']);
            $_POST['coy_logo'] = $store_file;
            $filename_store = $store_file;
            if (! $result) {
                display_error(_('Error uploading logo file'));
            }
        } else {
            display_error(_('Error uploading logo file to '.$filename));
        }
    }
}
