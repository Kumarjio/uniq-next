<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL,
	as published by the Free Software Foundation, either version 3
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
class customers_app extends application
{
	function customers_app()
	{
		$mainmodule = $_SESSION['apidumm'];
        if($mainmodule['SALES']['status'] == "1"){
			$this->application("orders", _($this->help_context = "Sales"),true,'receipt', 'purple-text accent-2');
			$this->add_module(_("Dashboard"),'','sales/dashboard');

			if ($mainmodule['SALES']['OPERATIONS']['status'] == "1"){
				$this->add_module(_("Operations"),'');

				if ($mainmodule['SALES']['OPERATIONS'][0]['name'] == "Sales Quotation" && $mainmodule['SALES']['OPERATIONS'][0]['active'] == "1"){
					$this->add_lapp_function(1, _("Sales Quotation"), "sales/inquiry/sales_orders_view.php?type=32", 'SA_SALESTRANSVIEW', MENU_INQUIRY,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][1]['name'] == "Sales Order" && $mainmodule['SALES']['OPERATIONS'][1]['active'] == "1"){
					$this->add_lapp_function(1, _("Sales Order"), "sales/inquiry/sales_orders_view.php?type=30", 'SA_SALESTRANSVIEW', MENU_INQUIRY,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][2]['name'] == "Direct Delivery Order" && $mainmodule['SALES']['OPERATIONS'][2]['active'] == "1"){
					$this->add_lapp_function(1, _("Direct Delivery"),"sales/inquiry/customer_inquiry.php?filtertype=5", 'SA_SALESDELIVERY', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][3]['name'] == "Direct Invoice" && $mainmodule['SALES']['OPERATIONS'][3]['active'] == "1"){
					$this->add_lapp_function(1, _("Direct Invoice"),"sales/inquiry/customer_inquiry.php?filtertype=1", 'SA_SALESINVOICE', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][4]['name'] == "Sales Invoice" && $mainmodule['SALES']['OPERATIONS'][4]['active'] == "1"){
					$this->add_lapp_function(1, _("Sales Invoice"),"sales/invoice?NewInvoice=1", 'SA_SALESINVOICE', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][5]['name'] == "Deliveries Against Sales Order" && $mainmodule['SALES']['OPERATIONS'][5]['active'] == "1"){
					$this->add_lapp_function(1, _("Del. Against Sales Orders"),
					"sales/inquiry/sales_orders_view.php?OutstandingOnly=1", 'SA_SALESDELIVERY', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][6]['name'] == "Invoice Against D/O" && $mainmodule['SALES']['OPERATIONS'][6]['active'] == "1"){
					$this->add_lapp_function(1, _("Inv. Against Sales Delivery"),
					"sales/inquiry/sales_deliveries_view.php?OutstandingOnly=1", 'SA_SALESINVOICE', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][10]['name'] == "Customer Payments" && $mainmodule['SALES']['OPERATIONS'][10]['active'] == "1"){
					$this->add_rapp_function(1, _("Customer Payments"),
					"sales/customer_payments.php?", 'SA_SALESPAYMNT', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][11]['name'] == "Customer Credit Notes" && $mainmodule['SALES']['OPERATIONS'][11]['active'] == "1"){
					$this->add_rapp_function(1, _("Customer Credit Notes"),
					"sales/credit_note_entry.php?NewCredit=Yes", 'SA_SALESCREDIT', MENU_TRANSACTION,'');
				}

				if ($mainmodule['SALES']['OPERATIONS'][12]['name'] == "Allocate Customer Payments" && $mainmodule['SALES']['OPERATIONS'][12]['active'] == "1"){
					// $this->add_rapp_function(1, _("Allocate Customer Payments or Credit Notes"),
					$this->add_rapp_function(1, _("Alloc. Customer Payments"),
					"sales/allocations/customer_allocation_main.php?", 'SA_SALESALLOC', MENU_TRANSACTION,'');
				}

				if( config_ci('kastam')){
				    $this->add_lapp_function(1, _("Bad Debt Processing"), "admin/bad_deb.php?type=customer",'SA_SALESALLOC',MENU_TRANSACTION,'');
				}
			}else{
				$this->add_rapp_function(1, '','', '', '','');
			}



			if ($mainmodule['SALES']['INQUIRIES']['status'] == "1"){
				$this->add_module(_("Inquiry"),'');

				if ($mainmodule['SALES']['INQUIRIES'][13]['name'] == "Customer Transactions" && $mainmodule['SALES']['INQUIRIES'][13]['active'] == "1"){
					$this->add_lapp_function(2, _("Customer Transaction"),"sales/inquiry/customer_inquiry.php?", 'SA_SALESTRANSVIEW', MENU_INQUIRY,'');
				}

				if ($mainmodule['SALES']['INQUIRIES'][14]['name'] == "Customer Allocations" && $mainmodule['SALES']['INQUIRIES'][14]['active'] == "1"){
					$this->add_lapp_function(2, _("Customer Allocation"),"sales/inquiry/customer_allocation_inquiry.php?", 'SA_SALESALLOC', MENU_INQUIRY,'');
				}
			}else{
				$this->add_lapp_function(2, '','', '', '','');
			}

			if ($mainmodule['SALES']['REPORTS']['status'] == "1"){
				$this->add_module(_("Reports"),'');

				if ($mainmodule['SALES']['REPORTS'][16]['name'] == "Customer Ledger" && $mainmodule['SALES']['REPORTS'][16]['active'] == "1"){

					$this->add_lapp_function(3, _("Customer Ledger"),"reporting/reports_main.php?Class=0&REP_ID=101", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['REPORTS'][17]['name'] == "Aged Customer Analysis" && $mainmodule['SALES']['REPORTS'][17]['active'] == "1"){

					$this->add_lapp_function(3, _("Aged Customer Analysis"),"reporting/reports_main.php?Class=0&REP_ID=102", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['REPORTS'][18]['name'] == "Customer Detail Listing" && $mainmodule['SALES']['REPORTS'][18]['active'] == "1"){
					$this->add_lapp_function(3, _("Customer Detail Listing"),"reporting/reports_main.php?Class=0&REP_ID=103", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['REPORTS'][19]['name'] == "Sales Summary Report" && $mainmodule['SALES']['REPORTS'][19]['active'] == "1"){
					$this->add_lapp_function(3, _("Sales Summary Report"),"reporting/reports_main.php?Class=0&REP_ID=114", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['REPORTS'][20]['name'] == "Price List" && $mainmodule['SALES']['REPORTS'][20]['active'] == "1"){
					$this->add_lapp_function(3, _("Price Listing"),"reporting/reports_main.php?Class=0&REP_ID=104", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['REPORTS'][21]['name'] == "Order Status Listing" && $mainmodule['SALES']['REPORTS'][21]['active'] == "1"){

					$this->add_lapp_function(3, _("Order Status Listing"),"reporting/reports_main.php?Class=0&REP_ID=105", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['REPORTS'][22]['name'] == "Salesman Listing" && $mainmodule['SALES']['REPORTS'][22]['active'] == "1"){

					$this->add_lapp_function(3, _("Salesman Listing"),"reporting/reports_main.php?Class=0&REP_ID=106", 'SA_CUSTOMER', MENU_ENTRY,'');
				}
			}else{
				$this->add_lapp_function(3, '','', '', '','');
			}

			if ($mainmodule['SALES']['DOC PRINTING']['status'] == "1"){

				$this->add_module(_("Document Printing"),'');

				if ($mainmodule['SALES']['DOC PRINTING'][23]['name'] == "Print Invoices" && $mainmodule['SALES']['DOC PRINTING'][23]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Invoices"),"reporting/reports_main.php?Class=0&REP_ID=107", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['DOC PRINTING'][24]['name'] == "Print Credit Notes" && $mainmodule['SALES']['DOC PRINTING'][24]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Credit Notes"),"reporting/reports_main.php?Class=0&REP_ID=113", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['DOC PRINTING'][25]['name'] == "Print Delivery Orders" && $mainmodule['SALES']['DOC PRINTING'][25]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Deliveries"),
					"reporting/reports_main.php?Class=0&REP_ID=110", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['DOC PRINTING'][26]['name'] == "Print Statements" && $mainmodule['SALES']['DOC PRINTING'][26]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Statements"), "index.php/customer/printing/statements", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['DOC PRINTING'][27]['name'] == "Print Sales Orders" && $mainmodule['SALES']['DOC PRINTING'][27]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Sales Orders"),
						"reporting/reports_main.php?Class=0&REP_ID=109", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['DOC PRINTING'][28]['name'] == "Print Sales Quotations" && $mainmodule['SALES']['DOC PRINTING'][28]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Sales Quotations"),
						"reporting/reports_main.php?Class=0&REP_ID=111", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['DOC PRINTING'][29]['name'] == "Print Receipts" && $mainmodule['SALES']['DOC PRINTING'][29]['active'] == "1"){

					$this->add_lapp_function(4, _("Print Receipts"),
						"reporting/reports_main.php?Class=0&REP_ID=112", 'SA_CUSTOMER', MENU_ENTRY,'');
				}
			}else{
				$this->add_lapp_function(4, '', '', '', '','');
			}

			if ($mainmodule['SALES']['HOUSEKEEPING']['status'] == "1"){
				$this->add_module(_("Housekeeping"),'');

				if ($mainmodule['SALES']['HOUSEKEEPING'][30]['name'] == "Customer Maintenance" && $mainmodule['SALES']['HOUSEKEEPING'][30]['active'] == "1"){

					$this->add_lapp_function(5, _("Customer Maintenance"), "sales/manage/customers.php?", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['HOUSEKEEPING'][31]['name'] == "Customer Branches" && $mainmodule['SALES']['HOUSEKEEPING'][31]['active'] == "1"){

					$this->add_lapp_function(5, _("Customer Branches"),"sales/manage/customer_branches.php?", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($mainmodule['SALES']['HOUSEKEEPING'][32]['name'] == "Sales Groups" && $mainmodule['SALES']['HOUSEKEEPING'][32]['active'] == "1"){

					$this->add_lapp_function(5, _("Sales Groups"),
						"sales/manage/sales_groups.php?", 'SA_SALESGROUP', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['SALES']['HOUSEKEEPING'][33]['name'] == "Sales Types" && $mainmodule['SALES']['HOUSEKEEPING'][33]['active'] == "1"){

					$this->add_rapp_function(5, _("Sales Types"),
						"sales/manage/sales_types.php?", 'SA_SALESTYPES', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['SALES']['HOUSEKEEPING'][34]['name'] == "Sales Person" && $mainmodule['SALES']['HOUSEKEEPING'][34]['active'] == "1"){

					$this->add_rapp_function(5, _("Sales Persons"),
						"sales/manage/sales_people.php?", 'SA_SALESMAN', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['SALES']['HOUSEKEEPING'][35]['name'] == "Sales Area" && $mainmodule['SALES']['HOUSEKEEPING'][35]['active'] == "1"){

					$this->add_rapp_function(5, _("Sales Areas"),
						"sales/manage/sales_areas.php?", 'SA_SALESAREA', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['SALES']['HOUSEKEEPING'][36]['name'] == "Credit Status Setup" && $mainmodule['SALES']['HOUSEKEEPING'][36]['active'] == "1"){

					$this->add_rapp_function(5, _("Credit Status Setup"),
						"sales/manage/credit_status.php?", 'SA_CRSTATUS', MENU_MAINTENANCE,'');
				}
			}else{
				$this->add_rapp_function(5, '','', '', '','');
			}
		}

		$this->add_extensions();
	}
}


?>
