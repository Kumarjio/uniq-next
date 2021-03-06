<?php

class GlManageGroup
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
        submit_add_or_update_center($this->selected_id == "", '', 'both');
        box_footer_end();

        box_end();
        echo "</div>";
        end_form();
    }

    private function listview()
    {
        $result = get_account_types(check_value('show_inactive'));
        $th = array(
            'id' => array(
                'label' => _("ID"),
                'width' => '5%'
            ),
            _("Group Name"),
            _("Subgroup Of"),
            _("Class"),
            "edit" => array(
                'label' => "Edit",
                'width' => '5%'
            ),
            "delete" => array(
                'label' => 'Del',
                'width' => '5%'
            )
        );
        inactive_control_column($th);

        start_table(TABLESTYLE);
        table_header($th);

        $k = 0;
        while ($myrow = db_fetch($result)) {

            alt_table_row_color($k);

            $bs_text = get_account_class_name($myrow["class_id"]);

            if ($myrow["parent"] == '-1') {
                $parent_text = "";
            } else {
                $parent_text = get_account_type_name($myrow["parent"]);
            }

            label_cell($myrow["id"]);
            label_cell($myrow["name"]);
            label_cell($parent_text);
            label_cell($bs_text);
            inactive_control_cell($myrow["id"], $myrow["inactive"], 'chart_types', 'id');
            edit_button_cell("Edit" . $myrow["id"], _("Edit"));
            delete_button_cell("Delete" . $myrow["id"], _("Delete"));
            end_row();
        }


        end_table(1);
    }

    private function detail()
    {
        echo "<div style='margin-top:70px;'></div>";
        box_start("GL Account Group Detail");
        row_start();

        col_start(4, 'col-md-4 col-sm-6');

        // -----------------------------------------------------------------------------------

        // start_table(TABLESTYLE2);

        if ($this->selected_id != "") {
            if ($this->mode == 'Edit') {
                // editing an existing status code
                $myrow = get_account_type($this->selected_id);

                $_POST['id'] = $myrow["id"];
                $_POST['name'] = $myrow["name"];
                $_POST['parent'] = $myrow["parent"];
                if ($_POST['parent'] == '-1')
                    $_POST['parent'] == "";
                $_POST['class_id'] = $myrow["class_id"];
                hidden('selected_id', $myrow['id']);
                hidden('old_id', $myrow["id"]);
            } else {
                hidden('selected_id', $this->selected_id);
                hidden('old_id', $_POST["old_id"]);
            }
        }

        input_text_bootstrap(_("ID"), 'id');
        col_end();
        col_start(4, 'col-md-4 col-sm-6');
        input_text_bootstrap(_("Name"), 'name');
        col_end();
        col_start(4, 'col-md-4 col-sm-6');
        gl_account_types(_("Subgroup Of"), 'parent', null, _("None"), true);
        col_end();
        col_start(4, 'col-md-4 col-sm-6');
        classes_list(_("Class"), 'class_id', null);

        col_end();
        row_end();

    }
}
