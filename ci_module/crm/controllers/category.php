<?php

class CrmCategory
{

    var $selected_id = 0;

    var $mode = NULL;

    function __construct()
    {}

    function index()
    {
        echo "<div class=card-panel>";
        start_form();
        box_start("");
        $this->listview();
        box_footer_show_active();

        box_start("");
        $this->detail();

        box_footer_start();
        submit_add_or_update_center($this->selected_id == - 1, '', 'both');
        box_footer_end();

        box_end();
        echo "</div>";
        end_form();
    }

    private function listview()
    {
        $result = get_crm_categories(check_value('show_inactive'));
        start_table(TABLESTYLE, "width=70%");

        $th = array(
            _("Category Type"),
            _("Category Subtype"),
            _("Short Name"),
            _("Description"),
            "edit" => array(
                'label' => "Edit",
                'width' => '5%',
                'class'=>'text-center',
            ),
            "delete" => array(
                'label' => 'Del',
                'width' => '5%',
                'class'=>'text-center',
            )
        );
        inactive_control_column($th);

        table_header($th);
        $k = 0;

        while ($myrow = db_fetch($result)) {

            alt_table_row_color($k);

            label_cell($myrow["type"]);
            label_cell($myrow["action"]);
            label_cell($myrow["name"]);
            label_cell($myrow["description"]);

            inactive_control_cell($myrow["id"], $myrow["inactive"], 'crm_categories', 'id');

            edit_button_cell("Edit" . $myrow["id"], _("Edit"));
            if ($myrow["system"])
                label_cell('');
            else
                delete_button_cell("Delete" . $myrow["id"], _("Delete"));
            end_row();
        }

        end_table(1);
    }

    private function detail()
    {

        if ($this->selected_id != -1)
        {
            if ( $this->mode == 'Edit') {
                //editing an existing area
                $myrow = get_crm_category($this->selected_id);

                $_POST['name']  = $myrow["name"];
                $_POST['type']  = $myrow["type"];
                $_POST['subtype']  = $myrow["action"];
                $_POST['description']  = $myrow["description"];
            }
            hidden("selected_id", $this->selected_id);
        }

        row_start();
        echo "<div class='card' style='margin-top:100px;'>";
        if ( $this->mode == 'Edit' && $myrow['system']) {
            col_start(4, 'col l4 s6');
            input_label_bootstrap( _("Contact Category Type"), 'type' );
            col_end();
            col_start(4, 'col l4 s6');
            input_label_bootstrap(_("Contact Category Subtype"), 'subtype' );
            col_end();
        } else {
            //	crm_category_type_list_row(_("Contact Category Type:"), 'type', null, _('Other'));
            col_start(4, 'col l4 s6');
            input_text( _("Contact Category Type"), 'type');
            col_end();
            col_start(4, 'col l4 s6');
            input_text(_("Contact Category Subtype"), 'subtype');
            col_end();
        }

        col_start(4, 'col l4 s6');
        input_text(_("Category Short Name"), 'name');
        col_end();
        col_start(4, 'col l8 s6');
        input_textarea_bootstrap(_("Category Description"), 'description');


        col_end();
        echo "</div>";
        row_end();
    }
}
