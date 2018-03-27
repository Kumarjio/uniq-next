<?php

class SalesManagerPerson
{

    function __construct()
    {}

    function index()
    {
        echo "<div class=card-panel>";
        start_form();

        box_start("");
        $this->persons_list();

        box_start("Sales Persons Detail");
        row_start();
        $this->person_item();
        row_end();

        box_footer_start();
        submit_add_or_update_center($this->id == - 1, '', 'both');
        box_footer_end();

        box_end();

        end_form();
        echo "</div>";
    }

    private function persons_list()
    {
        $result = get_salesmen(check_value('show_inactive'));
        start_table(TABLESTYLE);
        $th = array(
            _("Name"),
            _("Phone"),
            _("Fax"),
            _("Email"),
            _("Provision"),
            _("Break Pt."),
            _("Provision") . " 2",
             "edit"=>array('label'=>'','width'=>'5%','class'=>'center'),
            "delete"=>array('label'=>'','width'=>'5%','class'=>'center')
        );
        inactive_control_column($th);
        table_header($th);

        $k = 0;

        while ($myrow = db_fetch($result)) {

            alt_table_row_color($k);

            label_cell($myrow["salesman_name"]);
            label_cell($myrow["salesman_phone"]);
            label_cell($myrow["salesman_fax"]);
            email_cell($myrow["salesman_email"]);
            label_cell(percent_format($myrow["provision"]) . " %", "nowrap");
            amount_cell($myrow["break_pt"]);
            label_cell(percent_format($myrow["provision2"]) . " %", "nowrap");
            inactive_control_cell($myrow["salesman_code"], $myrow["inactive"], 'salesman', 'salesman_code');
            edit_button_cell("Edit" . $myrow["salesman_code"], _("Edit"));
            delete_button_cell("Delete" . $myrow["salesman_code"], _("Delete"));
            end_row();
        } // END WHILE LIST LOOP

        inactive_control_row($th);
        end_table();
    }

    private function person_item()
    {

        // ------------------------------------------------------------------------------------------------
        $_POST['salesman_email'] = "";
        if ( $this->id != - 1) {
            if ($this->mode == 'Edit') {
                // editing an existing Sales-person
                $myrow = get_salesman($this->id);

                $_POST['salesman_name'] = $myrow["salesman_name"];
                $_POST['salesman_phone'] = $myrow["salesman_phone"];
                $_POST['salesman_fax'] = $myrow["salesman_fax"];
                $_POST['salesman_email'] = $myrow["salesman_email"];
                $_POST['provision'] = percent_format($myrow["provision"]);
                $_POST['break_pt'] = price_format($myrow["break_pt"]);
                $_POST['provision2'] = percent_format($myrow["provision2"]);
            }
            hidden('selected_id', $this->id);
        } elseif ($this->mode != 'ADD_ITEM') {
            $_POST['provision'] = percent_format(0);
            $_POST['break_pt'] = price_format(0);
            $_POST['provision2'] = percent_format(0);
        }

        col_start(6, 'col l4 s6');
        input_text_bootstrap("Sales person name", 'salesman_name');
        col_end();
        col_start(6, 'col l4 s6');
        input_text_bootstrap("Telephone number", 'salesman_phone');
        col_end();
        col_start(6, 'col l4 s6');
        input_text_bootstrap("Fax number", 'salesman_fax');
        col_end();
        col_start(6, 'col l4 s6');
        input_text_bootstrap("E-mail", 'salesman_email');
        col_end();
        col_start(6, 'col l4 s6');
        input_percent('Provision','provision');
        col_end();
        col_start(6, 'col l4 s6');
        input_money('Break Pt.','break_pt');
        col_end();
        col_start(6, 'col l4 s6');
        input_percent('Provision 2','provision2');
        col_end();
        col_start(6, 'col l4 s6');
//         start_table(TABLESTYLE2);

//         text_row_ex(_("Sales person name:"), 'salesman_name', 30);
//         text_row_ex(_("Telephone number:"), 'salesman_phone', 20);
//         text_row_ex(_("Fax number:"), 'salesman_fax', 20);
//         email_row_ex(_("E-mail:"), 'salesman_email', 40);
//         percent_row(_("Provision") . ':', 'provision');
//         amount_row(_("Break Pt.:"), 'break_pt');
//         percent_row(_("Provision") . " 2:", 'provision2');
//         end_table(1);
        col_end();
//         submit_add_or_update_center($selected_id == - 1, '', 'both');
    }
}
