<?php

class ManageSalesPoint
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

        $this->detail();

        box_footer_start();
        submit_add_or_update_center($this->selected_id == - 1, '', 'both');
        box_footer_end();

        box_end();
        end_form();
        echo "</div>";
    }

    private function listview()
    {
        $result = get_all_sales_points(check_value('show_inactive'));
        start_table(TABLESTYLE);

        $th = array(
            _('POS Name'),
            _('Credit sale'),
            _('Cash sale'),
            _('Location'),
            _('Default account'),
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
            label_cell($myrow["pos_name"], "nowrap");
            label_cell($myrow['credit_sale'] ? _('Yes') : _('No'));
            label_cell($myrow['cash_sale'] ? _('Yes') : _('No'));
            label_cell($myrow["location_name"], "");
            label_cell($myrow["bank_account_name"], "");
            inactive_control_cell($myrow["id"], $myrow["inactive"], "sales_pos", 'id');
            edit_button_cell("Edit" . $myrow['id'], _("Edit"));
            delete_button_cell("Delete" . $myrow['id'], _("Delete"));
            end_row();
        }

        end_table(1);
    }

    private function detail()
    {
        echo "<div style='margin-top:70px;'></div>";
        box_start("Points of Sale Detail");
        row_start();
        $cash = db_has_cash_accounts();
        if (! $cash){
            col_start(12, 'col l12');
            display_heading2(_("To have cash POS first define at least one cash bank account."));
        }

        if ($this->selected_id != - 1) {

            if ($this->mode == 'Edit') {
                $myrow = get_sales_point($this->selected_id);

                $_POST['name'] = $myrow["pos_name"];
                $_POST['location'] = $myrow["pos_location"];
                $_POST['account'] = $myrow["pos_account"];
                if ($myrow["credit_sale"])
                    $_POST['credit_sale'] = 1;
                if ($myrow["cash_sale"])
                    $_POST['cash_sale'] = 1;
            }
            hidden('selected_id', $this->selected_id);
        }

        col_start(4, 'col l6 s6');
        input_text(_("Point of Sale Name"), 'name');
        col_end();
        col_start(4, 'col l6 s6');
        locations_bootstrap(_("POS location"), 'location');
        col_end();
        row_end();
        row_start();
        if ($cash) {
            col_start(4, 'col l4 s6');
            check_bootstrap(_('Allowed credit sale terms selection'), 'credit', check_value('credit_sale'));
            col_end();
            col_start(4, 'col l4 s6');
            check_bootstrap(_('Allowed cash sale terms selection'), 'cash', check_value('cash_sale'));
            col_end();
            col_start(4, 'col l4 s6');
            cash_accounts_list(_("Default cash account"), 'account');
            col_end();
        } else {
            hidden('credit', 1);
            hidden('account', 0);
        }


        row_end();
        box_end();
    }
}
