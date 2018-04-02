<?php

class ProductsManageLocation
{

    var $id, $selected_id = 0;

    var $mode = NULL;

    function __construct()
    {}

    function index()
    {
        start_form();
        box_start("");
        row_start('card-panel');
        $this->listview();

        box_start("");
        $this->detail();

        end_row();
        box_end();
        end_form();
    }

    private function listview()
    {
        $result = get_item_locations(check_value('show_inactive'));
        start_table(TABLESTYLE);
        $th = array(
            _("Location Code"),
            _("Location Name"),
            _("Address"),
            _("Phone"),
            _("Secondary Phone"),
            "edit" => array(
                'label' => NULL,
                'width' => '5%'
            ),
            "delete" => array(
                'label' => NULL,
                'width' => '5%'
            )
        );
        inactive_control_column($th);
        table_header($th);
        $k = 0; // row colour counter
        while ($myrow = db_fetch($result)) {

            alt_table_row_color($k);

            label_cell($myrow["loc_code"]);
            label_cell($myrow["location_name"]);
            label_cell($myrow["delivery_address"]);
            label_cell($myrow["phone"]);
            label_cell($myrow["phone2"]);
            inactive_control_cell($myrow["loc_code"], $myrow["inactive"], 'locations', 'loc_code');
            edit_button_cell("Edit" . $myrow["loc_code"], _("Edit"));
            delete_button_cell("Delete" . $myrow["loc_code"], _("Delete"));
            end_row();
        }
        // END WHILE LIST LOOP
        end_table();
        inactive_control_row($th);
    }

    private function detail()
    {
        row_start('card-panel');
        col_start(12, 'col m12');
        bootstrap_set_label_column(2);

        $_POST['email'] = "";
        if ($this->selected_id != - 1) {
            // editing an existing Location

            if ($this->mode == 'Edit') {
                $myrow = get_item_location($this->selected_id);

                $_POST['loc_code'] = $myrow["loc_code"];
                $_POST['location_name'] = $myrow["location_name"];
                $_POST['delivery_address'] = $myrow["delivery_address"];
                $_POST['contact'] = $myrow["contact"];
                $_POST['phone'] = $myrow["phone"];
                $_POST['phone2'] = $myrow["phone2"];
                $_POST['fax'] = $myrow["fax"];
                $_POST['email'] = $myrow["email"];
            }
            hidden("selected_id", $this->selected_id);
            hidden("loc_code");
            label_row(_("Location Code:"), $_POST['loc_code']);
        } else { // end of if $selected_id only do the else when a new record is being entered
            input_text_bootstrap(_("Location Code:"), 'loc_code');
        }

        col_end();
        col_start(12, 'col m4');
        input_text_bootstrap(_("Location Name:"), 'location_name');
        col_end();
        col_start(12, 'col m4');
        input_text_bootstrap(_("Contact for deliveries:"), 'contact');
        col_end();
        col_start(12, 'col m4');

        input_text_bootstrap(_("Telephone No:"), 'phone');
        col_end();
        col_start(12, 'col m4');
        input_text_bootstrap(_("Secondary Phone Number:"), 'phone2');
        col_end();
        col_start(12, 'col m4');
        input_text_bootstrap(_("Facsimile No:"), 'fax');
        col_end();
        col_start(12, 'col m4');
        input_text_bootstrap(_("E-mail:"), 'email');

        col_end();
        col_start(12, 'col m12');

        input_textarea_bootstrap(_("Address:"), 'delivery_address', null, 35, 5);
        box_footer_start();
        submit_add_or_update_center($this->selected_id == - 1, '', 'both');
        box_footer_end();
        col_end();
        row_end();
    }
}
