<?php

class SalesInquiryAllocations
{

    function __construct()
    {
        $this->page_variables();
        $this->ajax_updates();
        $this->bootstrap = get_instance()->bootstrap;


    }

    function view(){
        if (!@$_GET['popup'])
            start_form();
        echo "<div class=card-panel>";
        box_start();
        $this->fillter();
        set_global_customer($_POST['customer_id']);

        $this->allocations_table();

        box_footer();
        box_end();
        echo "</div>";
        if (!@$_GET['popup']){
            end_form();
        }
    }

    private function page_variables()
    {
        $filterType = input_val('filterType');
        if (isset($_GET['filterType'])) {
            $filterType = $_GET['filterType'];
        }

        set_post('filterType', $filterType);

        if (isset($_GET['customer_id'])){
            $_POST['customer_id'] = $_GET['customer_id'];
        }

        if (!isset($_POST['customer_id']))
            $_POST['customer_id'] = get_global_customer();
    }

    private function ajax_updates()
    {

    }

    function fillter()
    {
        row_start('inquiry-filter justify-content-center');
        if (! @$_GET['popup']) {

            col_start(12,'col l6 s6');
            customer_list_bootstrap( _("Customer"), 'customer_id', input_val('customer_id'), false, ! @$_GET['popup']);
        }
        if (! isset($_POST['filterType']))
        $_POST['filterType'] = 0;
        col_start(12,'col l6 s6');
        $fillter_type_title = "Tran Type";
        cust_allocations_bootstrap( $fillter_type_title, 'filterType', input_val('filterType'), true);
        
        col_start(12,'col l6 s6');
        input_date_bootstrap( "From", 'TransAfterDate', NULL, false, false, 0, - 1);

        col_start(12,'col l6 s6');
        input_date_bootstrap( "To", 'TransToDate', NULL);


        col_start(12,'col l6 s6');
        check_bootstrap('show settled', 'settled');
        echo "<div class=clearfix style='margin-top:50px'></div>";
        col_start(12,'col l6 s6');
        submit_bootstrap( 'RefreshInquiry', _("Search"), _('Refresh Inquiry'), 'default','search');
        echo "<div class=clearfix style='margin-bottom:50px'></div>";
        row_end();
    }

    function allocations_table()
    {
        $sql = get_sql_for_customer_allocation_inquiry(
                get_post('TransAfterDate'),
                get_post('TransToDate'),
                get_post('customer_id'),
                get_post('filterType'),
                check_value('showSettled')
        );
        // ------------------------------------------------------------------------------------------------
        db_query("set @bal:=0");

        $cols = array(
            _("Type") => array(
                'fun' => 'systype_name',
                'ord' => ''
            ),
            _("#") => array(
              'fun' => 'view_link',
              'ord' => ''
            ),
            _("Reference"),
            _("Order") => array(
              'fun' => 'order_view',
              'ord' => ''
            ),
            _("Date") => array(
                'name' => 'tran_date',
                'type' => 'date',
                'ord' => 'asc'
            ),
            _("Due Date") => array(
                'type' => 'date',
                'fun' => 'due_date'
            ),
            _("Customer") => array(
                'name' => 'name',
                'ord' => 'asc'
            ),
            _("Currency") => array(
                'align' => 'center'
            ),
            _("Debit") => array(
                'align' => 'right',
                'fun' => 'fmt_debit'
            ),
            _("Credit") => array(
                'align' => 'right',
                'insert' => true,
                'fun' => 'fmt_credit'
            ),
            _("Allocated") => 'amount',
            _("Balance") => array(
                'type' => 'amount',
                'insert' => true,
                'fun' => 'fmt_balance'
            ),
            array(
                'align' => 'center',
                'insert' => true,
                'fun' => 'allocation_link'
            )
        );

        if ($_POST['customer_id'] != ALL_TEXT) {
            $cols[_("Customer")] = 'skip';
            $cols[_("Currency")] = 'skip';
        }

        $table = & new_db_pager('doc_tbl', $sql, $cols, $table = null, $key = null, $page_len = 10);
        // echo db_table_responsive($table);
        display_db_pager($table);
    }
}
