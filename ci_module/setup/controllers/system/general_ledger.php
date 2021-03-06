<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class SetupSystemGeneralLedger
{

    function __construct()
    {

    }

    function index(){
        echo "<div class=card-panel>";
        start_form();
        box_start("");

        $this->form();

        box_footer_start();
        submit('submit', _("Update"), true, '', 'default','save');
//         submit('submit', _("Update"), true, '', false,'save');
        box_form_end();
        box_end();
        end_form(2);
        echo "</div>";
    }

    private function load_data(){
        $myrow = get_company_prefs();

        $_POST['retained_earnings_act'] = $myrow["retained_earnings_act"];
        $_POST['profit_loss_year_act'] = $myrow["profit_loss_year_act"];
        $_POST['debtors_act'] = $myrow["debtors_act"];
        $_POST['creditors_act'] = $myrow["creditors_act"];
        $_POST['freight_act'] = $myrow["freight_act"];
        $_POST['pyt_discount_act'] = $myrow["pyt_discount_act"];

        $_POST['exchange_diff_act'] = $myrow["exchange_diff_act"];
        $_POST['rounding_difference_act'] = $myrow["rounding_difference_act"];
        $_POST['bank_charge_act'] = $myrow["bank_charge_act"];
        $_POST['default_sales_act'] = $myrow["default_sales_act"];
        $_POST['default_sales_discount_act'] = $myrow["default_sales_discount_act"];
        $_POST['default_prompt_payment_act'] = $myrow["default_prompt_payment_act"];

        $_POST['default_inventory_act'] = $myrow["default_inventory_act"];
        $_POST['default_cogs_act'] = $myrow["default_cogs_act"];
        $_POST['default_adj_act'] = $myrow["default_adj_act"];
        $_POST['default_inv_sales_act'] = $myrow['default_inv_sales_act'];
        $_POST['default_assembly_act'] = $myrow['default_assembly_act'];
        // $_POST['cash_sales_invoice'] = isset($myrow['cash_sales_invoice']) ? $myrow['cash_sales_invoice'] : NULL;

        $_POST['allow_negative_stock'] = $myrow['allow_negative_stock'];

        $_POST['po_over_receive'] = percent_format($myrow['po_over_receive']);
        $_POST['po_over_charge'] = percent_format($myrow['po_over_charge']);
        $_POST['past_due_days'] = $myrow['past_due_days'];

        $_POST['grn_clearing_act'] = $myrow['grn_clearing_act'];

        $_POST['default_credit_limit'] = $myrow['default_credit_limit'];
        $_POST['legal_text'] = $myrow['legal_text'];
        $_POST['accumulate_shipping'] = $myrow['accumulate_shipping'];

        $_POST['default_workorder_required'] = $myrow['default_workorder_required'];
        $_POST['default_dim_required'] = $myrow['default_dim_required'];
        $_POST['default_delivery_required'] = $myrow['default_delivery_required'];

        $_POST['baddeb_sale_reverse'] = $myrow['baddeb_sale_reverse'];
        $_POST['baddeb_sale_tax_reverse'] = $myrow['baddeb_sale_tax_reverse'];
        $_POST['baddeb_sale_tax'] = $myrow['baddeb_sale_tax'];
        $_POST['baddeb_purchase_reverse'] = $myrow['baddeb_purchase_reverse'];
        $_POST['baddeb_purchase_tax_reverse'] = $myrow['baddeb_purchase_tax_reverse'];
        $_POST['baddeb_purchase_tax'] = $myrow['baddeb_purchase_tax'];


        $_POST['sale_gst_default'] = isset($myrow['sale_gst_default']) ? $myrow['sale_gst_default'] : NULL;
        $_POST['purchase_gst_default'] = isset($myrow['purchase_gst_default']) ? $myrow['purchase_gst_default'] : NULL;

        global $gst_registration_date;
        foreach ($gst_registration_date as $field => $val) {
            if (isset($myrow[$field])) {
                $_POST[$field] = $myrow[$field];
            }
        }
    }
    private function form()
    {
        if (get_company_pref('grn_clearing_act') === null) { // available from 2.3.1, can be not defined on pre-2.4 installations
            set_company_pref('grn_clearing_act', 'glsetup.purchase', 'varchar', 15, 0);
            refresh_sys_prefs();
        }

        $this->load_data();

        row_start();
        col_start(6, 'col l6');
        // ---------------
        if ( config_ci('kastam') ) {
            fieldset_start(_("Company GST Registration Date"));

            echo get_instance()->finput->inputtaxes('Default GST Code', 'gst_default_code', input_val('gst_default_code'), '2,3', 'row');

            date_row(_("GST Start Date"), 'gst_start_date');
        } else {
            hidden('gst_default_code', input_val('gst_default_code'));
            hidden('gst_start_date', input_val('gst_start_date'));
        }

        fieldset_start(_("General GL"));

        input_text_addon_bootstrap( _("Past Due Days Interval"), 'past_due_days', $_POST['past_due_days'],  _("days"));
        gl_accounts_bootstrap(_("Retained Earnings"), 'retained_earnings_act');
        gl_accounts_bootstrap(_("Profit/Loss Year"), 'profit_loss_year_act');
        gl_accounts_bootstrap(_("Exchange Variances Account"), 'exchange_diff_act');
        gl_accounts_bootstrap(_("Rounding Difference Account"), 'rounding_difference_act');

        if ( config_ci('kastam')) {
            gl_accounts_bootstrap(_("Bank Charges Account"), 'bank_charge_act');
            gl_accounts_bootstrap(_("Custom Duty"), 'custom_duty');
        } else {
            hidden('bank_charge_act');
            hidden('custom_duty');
        }

        // ---------------

        fieldset_start(_("Customers and Sales"));
        input_text( _("Default Credit Limit"), 'default_credit_limit');
        check_bootstrap( _("Accumulate batch shipping"), 'accumulate_shipping');
        input_textarea_bootstrap(_("Legal Text on Invoice"), 'legal_text');
        gl_accounts_bootstrap(_("Shipping Charged Account"), 'freight_act', $_POST['freight_act']);

        // ---------------

        fieldset_start(_("Customers and Sales Defaults"));
        // default for customer branch
        gl_accounts_bootstrap(_("Receivable Account"), 'debtors_act');
        gl_accounts_bootstrap(_("Sales Account"), 'default_sales_act', null, false, false, true);
        gl_accounts_bootstrap(_("Sales Discount Account"), 'default_sales_discount_act');
        gl_accounts_bootstrap(_("Prompt Payment Discount Account"), 'default_prompt_payment_act');
        input_text_addon_bootstrap(_("Delivery Required By"), 'default_delivery_required', $_POST['default_delivery_required'],_("days"));
        // gl_all_accounts_list_row(_("Cash Sales Invoice:"), 'cash_sales_invoice');
        /*
         * 150828 - QuanNH add Bad Deb setting
         */
        if (config_ci('kastam')) {
            fieldset_start(_("Bad Debts Defaults"));
            gl_accounts_bootstrap(_("Sales Reverse Account"), 'baddeb_sale_reverse', $_POST['baddeb_sale_reverse']);
            gl_accounts_bootstrap(_("Output Tax Reverse Account"), 'baddeb_sale_tax_reverse', $_POST['baddeb_sale_tax_reverse']);
            echo $ci->finput->inputtaxes('Output Tax', 'baddeb_sale_tax', $_POST['baddeb_sale_tax'], 2, 'row');

            gl_accounts_bootstrap(_("Purchase Reverse Account"), 'baddeb_purchase_reverse', $_POST['baddeb_purchase_reverse']);
            gl_accounts_bootstrap(_("Input Tax Reverse Account"), 'baddeb_purchase_tax_reverse', $_POST['baddeb_purchase_tax_reverse']);
            echo $ci->finput->inputtaxes('Input Tax', 'baddeb_purchase_tax', $_POST['baddeb_purchase_tax'], 3, 'row');
        } else {
            hidden('baddeb_sale_reverse');
            hidden('baddeb_sale_tax_reverse');
            hidden('baddeb_sale_tax');
            hidden('baddeb_purchase_reverse');
            hidden('baddeb_purchase_tax_reverse');
            hidden('baddeb_purchase_tax');
        }

        // ----------------

        col_end();
        // echo "<div class=clearfix></div>";
        col_start(6, 'col l6');

        fieldset_start(_("Department Defaults"));
        input_text_addon_bootstrap(_("Department Required By After"), 'default_dim_required', $_POST['default_dim_required'], _("days"));
        // ---------------

        fieldset_start(_("Suppliers and Purchasing"));
        input_percent(_("Delivery Over-Receive Allowance"), 'po_over_receive');
        input_percent(_("Invoice Over-Charge Allowance"), 'po_over_charge');

        fieldset_start(_("Suppliers and Purchasing Defaults"));
        gl_accounts_bootstrap(_("Payable Account"), 'creditors_act', $_POST['creditors_act']);
        gl_accounts_bootstrap(_("Purchase Discount Account"), 'pyt_discount_act', $_POST['pyt_discount_act']);
        gl_accounts_bootstrap(_("GRN Clearing Account"), 'grn_clearing_act', get_post('grn_clearing_act'), true, false, _("No postings on GRN"));

        fieldset_start(_("Inventory"));
        check_bootstrap( _("Allow Negative Inventory"), 'allow_negative_stock', null,  false, false, '',$help='Warning:  This may cause a delay in GL postings');
//         label_row(null, _("Warning:  This may cause a delay in GL postings"), "", "class='stockmankofg' colspan=2");

        fieldset_start(_("Items Defaults"));
        gl_accounts_bootstrap(_("Sales Account"), 'default_inv_sales_act');
        gl_accounts_bootstrap(_("Inventory Account"), 'default_inventory_act');
        // this one is default for items and suppliers (purchase account)
        gl_accounts_bootstrap(_("C.O.G.S. Account"), 'default_cogs_act');
        gl_accounts_bootstrap(_("Inventory Adjustments Account"), 'default_adj_act');
        gl_accounts_bootstrap(_("Item Assembly Costs Account"), 'default_assembly_act');

        // ----------------
        if (config_ci('kastam')) {
//             fieldset_start(_("Manufacturing Defaults"));
//             input_text(_("Work Order Required By After"), 'default_workorder_required', $_POST['default_workorder_required'], 6, 6, '', "", _("days"));

//             fieldset_start(_("Maximum Claimable Input Tax"));

            fieldset_start(_("Simplified Invoice"), 'maximum_claimable_input_tax');
            currencies_list_row(_("Check to Currency"), 'maximum_claimable_currency', input_val('maximum_claimable_currency'));
        } else {
            hidden('default_workorder_required');
            hidden('maximum_claimable_input_tax');
            hidden('maximum_claimable_currency');
        }

        col_end();
        row_end();
        row_start();
        col_start(6, 'col l6');
        fieldset_start(_("Product GST Default"));
        gst_list_bootstrap(_("Sales GST Type"), 'sale_gst_default');
        gst_list_bootstrap(_("Purchase GST Type"), 'purchase_gst_default');

        col_end();
        row_end();
    }
}
