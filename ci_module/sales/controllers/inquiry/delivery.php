<?php

class SalesInquiryDelivery
{

    function __construct()
    {
        $this->check_submit();
    }

    function view()
    {

        // -----------------------------------------------------------------------------------
        start_form(false, false, $_SERVER['PHP_SELF'] . "?OutstandingOnly=" . $_POST['OutstandingOnly']);
        echo "<div class=card-panel>";
        box_start();
        $_POST['DeliveryAfterDate'] = '10-01-2015';
        $this->filter();
        // row_start();
        $this->items();
        // row_end();
        box_footer();
        box_end();
        echo "</div>";
        end_form();
    }

    private function filter()
    {
        row_start('inquiry-filter');
        col_start(3, 'col l4 s6');
        input_text('Delivery Numb.','DeliveryNumber',null,true);
//         ref_cells(_("#:"), 'DeliveryNumber', '', null, '', true);

        col_start(3, 'col l4 s6');
        input_date_bootstrap('from', 'DeliveryAfterDate',null,false, -30);

        col_start(3, 'col l4 s6');
        input_date_bootstrap('to', 'DeliveryToDate',null,false,1);

        col_start(3, 'col l4 s6');
        locations_bootstrap('Location', 'StockLocation',null,true);

        col_start(4, 'col l4 s6');
        stock_items_bootstrap('Item', 'SelectStockFromList', null, true);
//         stock_items_list_cells(_("Item:"), 'SelectStockFromList', null, true);

        col_start(4, 'col l4 s6');
        customer_list_bootstrap(_("Customer"), 'customer_id', null, true);
//         customer_list_cells(_("Select a customer: "), 'customer_id', null, true, true);

        col_start(1, 'col l4 s6');
        submit_bootstrap('SearchOrders', _("Search"), _('Select documents'), 'default' , 'search');
//         submit('SearchOrders', _("Search"), true , _('Select documents'), 'default');

        hidden('OutstandingOnly', $_POST['OutstandingOnly']);
        row_end();
        echo '<div class="clearfix" style="margin-bottom:50px"></div>';
    }

    private function items()
    {
        if (isset($_GET['selected_customer'])) {
            $selected_customer = $_GET['selected_customer'];
        } elseif (isset($_POST['selected_customer'])) {
            $selected_customer = $_POST['selected_customer'];
        } else
            $selected_customer = - 1;

        if (isset($_POST['SelectStockFromList']) && ($_POST['SelectStockFromList'] != "") && ($_POST['SelectStockFromList'] != ALL_TEXT)) {
            $selected_stock_item = $_POST['SelectStockFromList'];
        } else {
            $selected_stock_item = null;
        }


        $cols = array(
            _("#") => array(
                'fun' => 'trans_view'
            ),
            _("Cust"),
            'branch_code' => 'skip',
            _("Branch") => array(
                'ord' => ''
            ),
            _("Contact"),
            _("Reference"),
            _("Cust Ref"),
            _("Date") => array(
                'type' => 'date',
                'ord' => ''
            ),
            _("Due By") => 'date',
            _("Total") => array(
                'type' => 'amount',
                'ord' => ''
            ),
            _("Currency") => array(
                'align' => 'center'
            ),

            submit('BatchInvoice', _("Batch"), false, _("Batch Invoicing")) => array(
                'insert' => true,
                'fun' => 'batch_checkbox',
                'align' => 'center'
            ),

            'edit'=>array(
                'label'=>'Edit',
                'insert' => true,
                'fun' => 'edit_link'
            ),
            'invoice'=>array(
                'label'=>'Inv',
                'insert' => true,
                'fun' => 'invoice_link'
            ),
            'print'=>array(
                'label'=>'Prt',
                'insert' => true,
                'fun' => 'prt_link'
            )
        );

        // -----------------------------------------------------------------------------------
        if (isset($_SESSION['Batch'])) {
            foreach ($_SESSION['Batch'] as $trans => $del)
                unset($_SESSION['Batch'][$trans]);
            unset($_SESSION['Batch']);
        }

        $sql = get_sql_for_sales_deliveries_view($selected_customer, $selected_stock_item, $_POST['customer_id']);

        $table = & new_db_pager('deliveries_tbl', $sql, $cols);
        $table->set_marker('check_overdue', _("Marked items are overdue."));

        $table->ci_control = $this;

        display_db_pager($table);
    }

    function edit_link($row)
    {
        return $row["Outstanding"]==0 ? '' :
        pager_link(_('Edit'), "/sales/customer_delivery.php?ModifyDelivery="
            .$row['trans_no'], ICON_EDIT);
    }

//     function invoice_link($row)
//     {
//         return $row["Outstanding"]==0 ? '' :
//         pager_link(_('Invoice'), "/sales/customer_invoice.php?DeliveryNumber="
//             .$row['trans_no'], ICON_DOC);
//     }

    private function check_submit()
    {
        global $Ajax;
        if (isset($_POST['BatchInvoice'])) {
            // checking batch integrity
            $del_count = 0;
            foreach ($_POST['Sel_'] as $delivery => $branch) {
                $checkbox = 'Sel_' . $delivery;
                if (check_value($checkbox)) {
                    if (! $del_count) {
                        $del_branch = $branch;
                    } else {
                        if ($del_branch != $branch) {
                            $del_count = 0;
                            break;
                        }
                    }
                    $selected[] = $delivery;
                    $del_count ++;
                }
            }

            if (! $del_count) {
                display_error(_('For batch invoicing you should
		    select at least one delivery. All items must be dispatched to
		    the same customer branch.'));
            } else {
                $_SESSION['DeliveryBatch'] = $selected;
                meta_forward($path_to_root . '/sales/customer_invoice.php', 'BatchInvoice=Yes');
            }
        }

        // -----------------------------------------------------------------------------------
        if (get_post('_DeliveryNumber_changed')) {
            $disable = get_post('DeliveryNumber') !== '';

            $Ajax->addDisable(true, 'DeliveryAfterDate', $disable);
            $Ajax->addDisable(true, 'DeliveryToDate', $disable);
            $Ajax->addDisable(true, 'StockLocation', $disable);
            $Ajax->addDisable(true, '_SelectStockFromList_edit', $disable);
            $Ajax->addDisable(true, 'SelectStockFromList', $disable);
            // if search is not empty rewrite table
            if ($disable) {
                $Ajax->addFocus(true, 'DeliveryNumber');
            } else
                $Ajax->addFocus(true, 'DeliveryAfterDate');
            $Ajax->activate('deliveries_tbl');
        }
    }
}
