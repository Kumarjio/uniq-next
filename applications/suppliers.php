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
class suppliers_app extends application
{
	function suppliers_app()
	{
		$mainmodule = $_SESSION['apidumm'];
        if($mainmodule['PURCHASE']['status'] == "1"){
			$this->application("AP", _($this->help_context = "Purchases"),true,'shopping_basket', 'brown-text accent-2');
			$this->add_module(_("Dashboard"),'', "/purchases/dashboard");

			$submenu = $mainmodule['PURCHASE'];

			$item_menu_operations = $submenu['OPERATIONS'];
			$item_menu_inquiry = $submenu['INQUIRIES'];
			$item_menu_repots = $submenu['REPORTS'];
			$item_menu_document = $submenu['DOC PRINTING'];
			$item_menu_housekeeping = $submenu['HOUSEKEEPING'];

			if ($submenu['OPERATIONS']['status'] == "1"){
				$this->add_module(_("Operations"), '');

				//$this->add_lapp_function(1, _("Purchase Order Entry"),
				//	"purchasing/po_entry_items.php?NewOrder=Yes", 'SA_PURCHASEORDER', MENU_TRANSACTION);

				if ($item_menu_operations[38]['name'] == "Purchase Orders" && $item_menu_operations[38]['active'] == "1"){
					$this->add_lapp_function(1, _("Purchase Orders"), "purchasing/inquiry/po_search_completed.php?", 'SA_SUPPTRANSVIEW', MENU_INQUIRY,'');
				}

				if ($item_menu_operations[39]['name'] == "Direct GRN" && $item_menu_operations[39]['active'] == "1"){
					$this->add_lapp_function(1, _("Direct GRN"), "purchasing/inquiry/supplier_inquiry.php?filtertype=6", 'SA_GRN', MENU_TRANSACTION,'');
				}
			// 		$this->add_lapp_function(0, _("Direct Invoice"),"purchasing/po_entry_items.php?NewInvoice=Yes", 'SA_SUPPLIERINVOICE', MENU_TRANSACTION);

				if ($item_menu_operations[40]['name'] == "Direct Invoice" && $item_menu_operations[40]['active'] == "1"){
					$this->add_lapp_function(1, _("Direct Invoice"), "purchasing/inquiry/supplier_inquiry.php?filtertype=1", 'SA_SUPPLIERINVOICE', MENU_TRANSACTION ,'');
				}

				if ($item_menu_operations[41]['name'] == "Supplier Invoices" && $item_menu_operations[41]['active'] == "1"){
					$this->add_rapp_function(1, _("Supplier Invoices"),"purchasing/inquiry/supplier_inquiry.php?filtertype=2", 'SA_SUPPLIERINVOICE', MENU_TRANSACTION,'');
				}

				if ($item_menu_operations[42]['name'] == "Payment to Supplies" && $item_menu_operations[42]['active'] == "1"){
					$this->add_rapp_function(1, _("Payments to Suppliers"),
						"purchasing/supplier_payment.php?", 'SA_SUPPLIERPAYMNT', MENU_TRANSACTION,'');
				}
			// 		$this->add_rapp_function(0, "","");
				if ($item_menu_operations[43]['name'] == "Supplier Credit Notes" && $item_menu_operations[43]['active'] == "1"){
					$this->add_rapp_function(1, _("Supplier Credit Notes"),
						"purchasing/supplier_credit.php?New=1", 'SA_SUPPLIERCREDIT', MENU_TRANSACTION,'');
				}

				if ($item_menu_operations[44]['name'] == "Allocate Supplier Payments" && $item_menu_operations[44]['active'] == "1"){
					// $this->add_rapp_function(1, _("Allocate Supplier Payments or Credit Notes"),
					$this->add_rapp_function(1, _("Allocate Supplier Payments"),
						"purchasing/allocations/supplier_allocation_main.php?", 'SA_SUPPLIERALLOC', MENU_TRANSACTION,'');
				}

					if( config_ci('kastam')){
					    $this->add_lapp_function(1, _("Bad Debt Processing"), "admin/bad_deb.php?type=supplier", 'SA_SUPPLIERALLOC', MENU_TRANSACTION,'');
					}
			}else{
				$this->add_rapp_function(1, '','', '', '','');
			}

			if ($submenu['INQUIRIES']['status'] == "1"){
				$this->add_module(_("Inquiry"), '');

				if ($item_menu_inquiry[45]['name'] == "Supplier Transactions" && $item_menu_inquiry[45]['active'] == "1"){
					$this->add_lapp_function(2, _("Supplier Transaction"),
						"purchasing/inquiry/supplier_inquiry.php?", 'SA_SUPPTRANSVIEW', MENU_INQUIRY,'');
				}

				// $this->add_lapp_function(2, "","");

				if ($item_menu_inquiry[46]['name'] == "Supplier Allocations" && $item_menu_inquiry[46]['active'] == "1"){
					$this->add_lapp_function(2, _("Supplier Allocation"),
						"purchasing/inquiry/supplier_allocation_inquiry.php?", 'SA_SUPPLIERALLOC', MENU_INQUIRY,'');
				}

			// 		$this->add_rapp_function(1, _("Supplier and Purchasing Reports"), "reporting/reports_main.php?Class=1", 'SA_SUPPTRANSVIEW', MENU_REPORT);

			// 		$this->add_lapp_function(1, _("Check Transactions"),
			// 		    "index.php/purchases/inquiry/check", 'SA_SALESALLOC', MENU_INQUIRY,'list-ul');

			}else{
				$this->add_rapp_function(2, '','', '', '','');
			}

			if ($submenu['REPORTS']['status'] == "1"){
				$this->add_module(_("Reports"), '');

				if ($item_menu_repots[48]['name'] == "Supplier Ledger" && $item_menu_repots[48]['active'] == "1"){
					$this->add_lapp_function(3, _("Supplier Ledger"),
						"reporting/reports_main.php?Class=1&REP_ID=201", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				// 	$this->add_lapp_function(2, _("Aged Supplier Analyses"),
				// 		"reporting/reports_main.php?Class=1&REP_ID=202", 'SA_CUSTOMER', MENU_ENTRY);

				if ($item_menu_repots[49]['name'] == "Aged Supplier Analysis" && $item_menu_repots[49]['active'] == "1"){
					$this->add_lapp_function(3, _("Age Supplier Analysis"),
					    "reporting/reports_main.php?Class=1&REP_ID=202", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($item_menu_repots[50]['name'] == "Payment Report Report" && $item_menu_repots[50]['active'] == "1"){
					$this->add_lapp_function(3, _("Payment Report"),
						"reporting/reports_main.php?Class=1&REP_ID=203", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($item_menu_repots[51]['name'] == "Outstanding GRN Report" && $item_menu_repots[51]['active'] == "1"){
					$this->add_lapp_function(3, _("Outstanding GRNs Report"),
						"reporting/reports_main.php?Class=1&REP_ID=204", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($item_menu_repots[52]['name'] == "Supplier Detail Listing" && $item_menu_repots[52]['active'] == "1"){
					$this->add_lapp_function(3, _("Supplier Detail Listing"),
						"reporting/reports_main.php?Class=1&REP_ID=205", 'SA_CUSTOMER', MENU_ENTRY,'');
				}
			}else{
				$this->add_rapp_function(3, '','', '', '','');
			}

			if ($submenu['DOC PRINTING']['status'] == "1"){
				$this->add_module(_("Document Printing"), '');

				if ($item_menu_document[53]['name'] == "Print PO" && $item_menu_document[53]['active'] == "1"){
					$this->add_lapp_function(4, _("Print Purchase Orders"),
						"reporting/reports_main.php?Class=1&REP_ID=209", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

				if ($item_menu_document[54]['name'] == "Print remittance" && $item_menu_document[54]['active'] == "1"){
					$this->add_lapp_function(4, _("Print Remittances"),
						"reporting/reports_main.php?Class=1&REP_ID=210", 'SA_CUSTOMER', MENU_ENTRY,'');
				}

			}else{
				$this->add_rapp_function(4, '','', '', '','');
			}

			if ($submenu['HOUSEKEEPING']['status'] == "1"){
				$this->add_module(_("Housekeeping"), '');

				if ($item_menu_housekeeping[55]['name'] == "Supplier Maintenance" && $item_menu_housekeeping[55]['active'] == "1"){
					$this->add_lapp_function(5, _("Suppliers Maintenance"),"purchasing/manage/suppliers.php?", 'SA_SUPPLIER', MENU_ENTRY,'');
				}
			}else{
				$this->add_rapp_function(5, '','', '', '','');
			}

		}
		$this->add_extensions();
	}
}


?>
