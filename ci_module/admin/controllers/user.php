<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class AdminUser
{

    var $selected_id = 0;

    var $mode = NULL;

    function __construct()
    {}

    function index()
    {   
        echo "<input type='hidden' id='activelimit' value=".file_get_contents(ACTIVE).">";
        start_form();
        box_start("");
        $this->listview();
	echo "<h4>Max ".file_get_contents(ACTIVE)." <span synlang='syncard-language'>active users</span></h4>";
        box_footer_show_active();

        box_start("User Detail");
        $this->detail();

        box_footer_start();
        submit_add_or_update_center($this->selected_id == - 1, '', 'both');
        box_footer_end();

        box_end();
        end_form();
    }

    private function listview()
    {
        $result = get_users(check_value('show_inactive'));
        div_start("",null, false, $attributes = 'class="col-md-12 table-box"');
        start_table(TABLESTYLE);

        $th = array(
            _("User login"),
            _("Full Name"),
            _("Phone"),
            _("E-mail"),
            _("Last Visit"),
            _("Access Level"),
            "" => array(
                'label' => "",
                'width' => '5%',
                'align'=>'center',
                'class'=>'text-center'
            ),
            //"edit" => array(
            //    'label' => "Edit",
            //    'width' => '5%',
            //    'align'=>'center',
            //    'class'=>'text-center'
            //),
            //"delete" => array(
            //    'label' => 'Del',
            //    'width' => '5%',
            //    'align'=>'center',
            //    'class'=>'text-center'
            //)
        );

        inactive_control_column($th, 1);
        table_header($th);

        $k = 0; // row colour counter

        while ($myrow = db_fetch($result)) {
            $option_html = "";
            alt_table_row_color($k);

            $last_visit_date = sql2date($myrow["last_visit_date"]);

            /* The security_headings array is defined in config.php */
            $not_me = strcasecmp($myrow["user_id"], $_SESSION["wa_current_user"]->username);

            label_cell($myrow["user_id"]);
            label_cell($myrow["real_name"]);
            label_cell($myrow["phone"]);
            email_cell($myrow["email"]);
            label_cell($last_visit_date, "nowrap");
            label_cell($myrow["role"]);

            if ($not_me)
                inactive_control_cell($myrow["id"], $myrow["inactive"], 'users', 'id');
            elseif (check_value('show_inactive'))
                label_cell('');

            $option_html .= button("Edit" . $myrow["id"], _("Edit"));//edit_button_cell("Edit" . $myrow["id"], _("Edit")); 
            if ($not_me)
                $option_html .= button("Delete" . $myrow["id"], _("Delete"));//delete_button_cell("Delete" . $myrow["id"], _("Delete"));
            //else
            //    label_cell('');
                
            $option_html =
            '<button type="button" class="button operation-button"><i class="fa fa-ellipsis-v"></i></button><div class="operation-modal"><div class="operation-content">'.
            '<h4><span synlang="syncard-language">Option menu</span></h4>'.
            '<hr/>'.
            '<div class="operation-dumb">'.
            $option_html.
            '</div></div></div>';
            label_cell($option_html, "align='center'");
            end_row();
        } // END WHILE LIST LOOP

        end_table(1);
        div_end();
    }

    private function detail()
    {
        row_start();
        col_start(4, 'col-md-4 col-sm-6');

        $_POST['email'] = "";
        if ($this->selected_id != - 1) {
            if ( $this->mode == 'Edit') {
                // editing an existing User
                $myrow = get_user($this->selected_id);

                $_POST['id'] = $myrow["id"];
                $_POST['user_id'] = $myrow["user_id"];
                $_POST['real_name'] = $myrow["real_name"];
                $_POST['phone'] = $myrow["phone"];
                $_POST['email'] = $myrow["email"];
                $_POST['role_id'] = $myrow["role_id"];
                $_POST['language'] = $myrow["language"];
                $_POST['print_profile'] = $myrow["print_profile"];
                $_POST['rep_popup'] = $myrow["rep_popup"];
                $_POST['pos'] = $myrow["pos"];
                $_POST['imei'] = $myrow["imei"];
            }
            hidden('selected_id', $this->selected_id);
            hidden('user_id');

            // start_row();
            input_label_bootstrap( "User login", 'user_id');
        } else { // end of if $selected_id only do the else when a new record is being entered
            input_text(_("User Login"), "user_id");
            $_POST['language'] = user_language();
            $_POST['print_profile'] = user_print_profile();
            $_POST['rep_popup'] = user_rep_popup();
            $_POST['pos'] = user_pos();
            $_POST['imei'] = '';
        }
        $_POST['password'] = "";

        $pass_help = NULL;
        if ($this->selected_id != - 1) {
            $pass_help = 'Enter a new password to change, leave empty to keep current.';
        }

        col_end();
        col_start(4, 'col-md-4 col-sm-6');
        input_password(_("Password"), 'password',$pass_help);
        col_end();
        col_start(4, 'col-md-4 col-sm-6');
        input_text(_("Full Name"), 'real_name');
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        input_text(_("Telephone No."), 'phone');
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        input_text(_("Email Address"), 'email');
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        security_roles_bootstrap(_("Access Level"), 'role_id', null);
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        languages_bootstrap(_("Language"), 'language');
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        pos_list(_("User's POS") , 'pos', null);
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        print_profiles(_("Printing profile"), 'print_profile', null, _('Browser printing support'));
        col_end();
        col_start(4, 'col-md-4 col-sm-6');

        check_bootstrap(_("Use popup window for reports"), 'rep_popup', $_POST['rep_popup'], false, _('Set this option to on if your browser directly supports pdf files'));

        col_end();
        col_start(4, 'col-md-4 col-sm-6');
        input_text(_("IMEI / Serial Number"), 'imei');


        col_end();
        row_end();
    }
}
