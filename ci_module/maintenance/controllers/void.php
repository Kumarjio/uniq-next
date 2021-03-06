<?php

class MaintenanceVoid
{

    var $selected_id = 0;

    var $mode = NULL;

    function __construct()
    {
        $this->not_implemented = array(
            ST_PURCHORDER,
            ST_SALESORDER,
            ST_SALESQUOTE,
            ST_COSTUPDATE
        );
    }


    function index()
    {
        echo "<div class=card-panel>";
        start_form();

        box_start("");
        row_start("inquiry-filter");
            $this->filter();
        row_end();

        $this->listview();

        if ($this->selected_id > 0) {
            box_start("");
            $this->detail();
        }

        box_footer_start();

        if ($this->selected_id > 0) {
            if (! isset($_POST['ProcessVoiding']))
                submit('ProcessVoiding', _("Void Transaction"), true, '', 'default');
            else {
                if (! exist_transaction($_POST['filterType'], $_POST['trans_no'])) {
                    display_error(_("The entered transaction does not exist or cannot be voided."));
                    unset($_POST['trans_no']);
                    unset($_POST['memo_']);
                    unset($_POST['date_']);
                    submit('ProcessVoiding', _("Void Transaction"), true, '', 'default');
                } else {
                    display_warning(_("Are you sure you want to void this transaction ? This action cannot be undone."), 0, 1);
                    submit('ConfirmVoiding', _("Proceed"),true, '', true);
                    submit('CancelVoiding', _("Cancel"), true, '', 'cancel');
                }
            }
        }

        // submit_add_or_update_center($this->selected_id == - 1, '', 'both');
        box_footer_end();

        box_end();
        end_form();
        echo "</div>";
    }

    private function filter()
    {
        col_start(4, 'col l4 s6');
        systypes(_("Type:"), 'filterType', null, true, $this->not_implemented);
        if (list_updated('filterType'))
            $selected_id = - 1;

        if (! isset($_POST['FromTransNo']))
            $_POST['FromTransNo'] = "1";
        if (! isset($_POST['ToTransNo']))
            $_POST['ToTransNo'] = "999999";

        col_end();

        col_start(4, 'col l4 s6');
        input_text(_("from"), 'FromTransNo');
        col_end();

        col_start(4, 'col l4 s6');
        input_text(_("to"), 'ToTransNo');
        col_end();

        col_start(4, 'col l12');
        submit('ProcessSearch', _("Search"), true, '', 'default', 'search');
        col_end();
    }

    private function listview()
    {
        $trans_ref = false;
        $sql = get_sql_for_view_transactions($_POST['filterType'], $_POST['FromTransNo'], $_POST['ToTransNo'], $trans_ref);
        if ($sql == "")
            return;

        $cols = array(
            _("#") => array(
                'insert' => true,
                'fun' => 'view_link',
                'width' => '5%',
                'align' => 'center',
                'class'=>'text-center',
            ),
            _("Reference") => array(
                'fun' => 'ref_view'
            ),
            _("Date") => array(
                'type' => 'date',
                'fun' => 'date_view'
            ),
            _('GL') => array(
                'label' => "GL",
                'insert' => true,
                'fun' => 'gl_view',
                'width' => '5%',
                'align'=>'center'
            ),
            _("Select") => array(
                'insert' => true,
                'fun' => 'select_link',
                'width' => '5%',
                'align'=>'center'
            )
        );

        $table = & new_db_pager('transactions', $sql, $cols);
        // $table->width = "40%";
        display_db_pager($table);
    }

    private function detail()
    {
        row_start();

        if ($this->selected_id != - 1) {
            hidden('trans_no', $this->selected_id);
            hidden('selected_id', $this->selected_id);
        } else {
            hidden('trans_no', '');
            $_POST['memo_'] = '';
        }

        echo "<div class='card'>";
        col_start(4, 'col m12');
        input_label_bootstrap(_("Transaction #"), null, ($this->selected_id == - 1 ? '' : $this->selected_id));
        col_end();

        col_start(4, 'col l4');
        input_date_bootstrap(_("Voiding Date"), 'date_');
        col_end();

        col_start(4, 'col l12 s6');
        input_textarea_bootstrap(_("Memo"), 'memo_');
        col_end();
        echo "</div>";
        row_end();
    }
}
