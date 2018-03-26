<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(ROOT . "/sales/includes/sales_ui.inc");

class SalesInvoice {
    function __construct() {

        $update_model = module_model_load('update','sales');
        $update_model->add_gl_debtor_trans();
    }

    function index(){
        page('Sales Overdue Invoice');
        $finish = $this->check_page_finish();
        if( !$finish ){
            if( input_get('NewInvoice') ){
                create_sale_cart(ST_SALESINVOICE,0);
            }
            if( !isset($_SESSION['Items']) ){
                redirect_query("NewInvoice=1");
            }
            $this->check_submit();

            get_instance()->librarie_in_module('sale_cart', 'sales');
            $this->cart = get_instance()->sale_cart;
            $this->cart->cart = $_SESSION['Items'];
            $this->document_add();
            start_form();
            echo "<div class=card-panel>";
            hidden('cart_id');
            box_start();

            $error = $this->cart->display_order_header($_SESSION['Items'],true);
            if ($error == "") {
                echo "<div class=clearfix></div>";
                box_start(_("Sales Invoice Items"));

                $this->cart->overdue_items_box(true);
                echo "<div class=clearfix style='margin-bottom:10px'></div>";
                $this->cart->display_gl_items(true);
                echo "<div class=clearfix style='margin-bottom:10px'></div>";
                $this->cart->display_delivery_details($_SESSION['Items']);

                box_footer_start();

                $this->form_buttons();
                box_footer_end();
            } else {
                display_error($error);
                box_footer();
            }
            if( intval( $document_id = input_get('document')) > 0 ){
                hidden('document_id',$document_id);
            }
            box_end();
            echo "</div>";
            end_form();
        }

    }

    private function form_buttons(){
        $cancelorder = _("Cancel Invoice");
        $porder = _("Place Invoice");

        if ($_SESSION['Items']->trans_no == 0) {
            submit_center_first('ProcessInvoice', $porder, _('Check entered data and save document'), false);
            submit('CancelOrder', $cancelorder, true, _('Cancels document entry or removes sales order when editing an old document'), true);
            submit_js_confirm('CancelOrder', _('You are about to void this Document.\nDo you want to continue?'));
        } else {
            submit_center_last('CancelOrder', $cancelorder, _('Cancels document entry or removes sales order when editing an old document'), true);

            if ($_SESSION['Items']->trans_type == ST_SALESORDER)
                submit_js_confirm('CancelOrder', _('You are about to cancel undelivered part of this order.\nDo you want to continue?'));
            else
                submit_js_confirm('CancelOrder', _('You are about to void this Document.\nDo you want to continue?'));
        }
    }

    private function check_submit()
    {
        global $Ajax;
        if (list_updated('branch_id')) {
            // when branch is selected via external editor also customer can change
            $br = get_branch(get_post('branch_id'));
            $_POST['customer_id'] = $br['debtor_no'];
            $Ajax->activate('customer_id');
        }

        if (isset($_POST['page_reload'])) {
            page_modified();
        }

        if (isset($_POST['ProcessInvoice']) && can_process_sale_cart()) {

            $modified = ($_SESSION['Items']->trans_no != 0);
//            $so_type = $_SESSION['Items']->so_type;

            //$ret = $_SESSION['Items']->write(1);
            $sale_model = module_model_load('sale_invoice','sales');
            $ret = $sale_model->write_sales_invoice($_SESSION['Items']);

            if ($ret == - 1) {
                display_error(_("The entered reference is already in use."));
                $ref = get_next_reference($_SESSION['Items']->trans_type);
                if ($ref != $_SESSION['Items']->reference) {
                    display_error(_("The reference number field has been increased. Please save the document again."));
                    $_POST['ref'] = $_SESSION['Items']->reference = $ref;
                    $Ajax->activate('ref');
                }
                set_focus('ref');
            } else {


                $trans_no = key($_SESSION['Items']->trans_no);
                $trans_type = $_SESSION['Items']->trans_type;
                new_doc_date($_SESSION['Items']->document_date);
                if (isset($_POST['customer_ref'])) {
                    update_source_ref($trans_type, $trans_no, $_POST['customer_ref']);
                }
                processing_end();

                $query = "AddedDI=$trans_no&Type=$trans_type";

                if( intval( $document_id = input_post('document_id')) > 0 ){
                    $mobile_model = module_model_load('mobile','documents');
                    $mobile_model->update_posting_link($trans_type,$trans_no,$document_id);
                }

                redirect_query($query);
            }
        }
    }

    private function check_page_finish()
    {
        $invoice = input_get('AddedDI');

        if( !empty($invoice) AND intval($invoice) > 0){
            $sql = "SELECT trans_type_from, trans_no_from FROM " . TB_PREF . "cust_allocations
			WHERE trans_type_to=" . ST_SALESINVOICE . " AND trans_no_to=" . db_escape($invoice);
            $result = db_query($sql, "could not retrieve customer allocation");
            $row = db_fetch($result);

            box_start();
            row_start();

            col_start(6, "col-md-6");
            mt_list_start('Actions', '', 'blue');

            mt_list_tran_view(_("&View This Invoice"), ST_SALESINVOICE, $invoice);
            mt_list_gl_view(_("View the GL &Journal Entries for this Invoice"), ST_SALESINVOICE, $invoice);
            mt_list_link(_("Enter a &New Invoice"), "/sales/invoice?NewInvoice=1");

            if ($row === false)
                mt_list_link(_("Entry &customer payment for this invoice"), "/sales/customer_payments.php?SInvoice=" . $invoice);

            mt_list_link(_("Add an Attachment"), "/admin/attachments.php?filterType=" . ST_SALESINVOICE . "&trans_no=$invoice");

            col_start(6, "col-md-6");
            mt_list_start('Printing', null, 'red');

            mt_list_print(_("&Print Sales Invoice"), ST_SALESINVOICE, $invoice . "-" . ST_SALESINVOICE, 'prtopt');
            mt_list_print(_("&Email Sales Invoice"), ST_SALESINVOICE, $invoice . "-" . ST_SALESINVOICE, null, 1);
            set_focus('prtopt');


            if ($row !== false)
                mt_list_print(_("Print &Receipt"), $row['trans_type_from'], $row['trans_no_from'] . "-" . $row['trans_type_from'], 'prtopt');

            row_end();
            box_footer();
            box_end();


            return true;
        }
        return false;
    }

    private function document_add(){
        $document_id = input_get('document');
        if( is_numeric($document_id) AND !in_ajax() ){
            $mobile_model = module_model_load('mobile','documents');
            $row = $mobile_model->item($document_id);
            $data = unserialize($row->data);
            if( !empty($data) ){
                $_POST['ref'] = $data['ref'];
                $_POST['customer_id'] = $data['customer_id'];
                $revenue_model = module_model_load('revenue','admin');
                $revenue = $revenue_model->get_row($data['revenue_id']);
                if( is_object($revenue) AND !empty($revenue) ){
                    $_SESSION['Items']->add_gl_line(0, $revenue->gl_account, $tax_id = 0, $data['customer_amount'], $data['customer_bill_no']);
                }
            }
        }
    }
}
