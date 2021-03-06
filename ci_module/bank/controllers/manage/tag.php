<?php

class BankManageTag
{

    var $selected_id = 0;
    var $mode = NULL;

    function __construct()
    {}

    function index()
    {
        start_form();
        echo "<div class='card-panel'>";
        box_start("");
        $this->listview();
        box_footer_show_active();

        
        $this->detail();

        box_footer_start();
        submit_add_or_update_center($this->selected_id == - 1, '', 'both');
//         submit_add_or_update_center($selected_id == -1, '', 'both');
        box_footer_end();

        box_end();
        echo "</div>";
        end_form();
    }

    private function listview()
    {
        $result = get_tags($_POST['type'], check_value('show_inactive'));
        start_table(TABLESTYLE);
        $th = array(
            _("Tag Name"),
            _("Tag Description"),
            "edit" => array(
                'label' => 'Edit',
                'width' => '5%'
            ),
            "delete" => array(
                'label' => "Dele",
                'width' => '5%'
            )
        );
        inactive_control_column($th);
        table_header($th);

        $k = 0;
        while ($myrow = db_fetch($result)) {
            alt_table_row_color($k);

            label_cell($myrow['name']);
            label_cell($myrow['description']);
            inactive_control_cell($myrow["id"], $myrow["inactive"], 'tags', 'id');
            edit_button_cell("Edit" . $myrow["id"], _("Edit"));
            delete_button_cell("Delete" . $myrow["id"], _("Delete"));
            end_row();
        }

        end_table(1);
    }

    private function detail()
    {
        echo "<div style='margin-top:70px'></div>";
        box_start("Account Tag Detail");
        row_start();
        col_start(4, 'col m4');

        if ($this->selected_id != - 1) { // We've selected a tag
            if ($this->mode == 'Edit') {
                // Editing an existing tag
                $myrow = get_tag($this->selected_id);

                $_POST['name'] = $myrow["name"];
                $_POST['description'] = $myrow["description"];
            }
            // Note the selected tag
            hidden('selected_id', $this->selected_id);
        }

        input_text_bootstrap(_("Tag Name:"), 'name');
        col_end();
        col_start(4, 'col m4');
        input_text_bootstrap(_("Tag Description:"), 'description');
        hidden('type');

//         end_table(1);
        col_end();
        row_end();
    }
}
