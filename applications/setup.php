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
class setup_app extends application
{
	function setup_app()
	{
		$mainmodule = $_SESSION['apidumm'];

        if($mainmodule['SETUP']['status'] == "1"){
			$this->application("system", _($this->help_context = "Setup"),true,'settings');

			if ($mainmodule['SETUP']['COMPANY']['status'] == "1"){
				$this->add_module(_("Company"),'');
				if ($mainmodule['SETUP']['COMPANY'][117]['name'] == "Import Data" && $mainmodule['SETUP']['COMPANY'][117]['active'] == "1"){
					$this->add_lapp_function(0, _("Import Data"),"admin/import.php?", 'SA_SETUPCOMPANY', MENU_SETTINGS,'');
				}
				if ($mainmodule['SETUP']['COMPANY'][118]['name'] == "Company Setup" && $mainmodule['SETUP']['COMPANY'][118]['active'] == "1"){
					$this->add_lapp_function(0, _("Company Setup"),"admin/company_preferences.php?", 'SA_SETUPCOMPANY', MENU_SETTINGS,'');
				}
				if ($mainmodule['SETUP']['COMPANY'][119]['name'] == "User Account Setup" && $mainmodule['SETUP']['COMPANY'][119]['active'] == "1"){
					$this->add_lapp_function(0, _("User Accounts Setup"),
						"admin/users.php?", 'SA_USERS', MENU_SETTINGS,'');
				}
				if ($mainmodule['SETUP']['COMPANY'][120]['name'] == "Access Setup" && $mainmodule['SETUP']['COMPANY'][120]['active'] == "1"){
					$this->add_lapp_function(0, _("Access Setup"),
						"admin/security_roles.php?", 'SA_SECROLES', MENU_SETTINGS,'');
				}
				if ($mainmodule['SETUP']['COMPANY'][121]['name'] == "Display Setup" && $mainmodule['SETUP']['COMPANY'][121]['active'] == "1"){
					$this->add_lapp_function(0, _("Display Setup"),
						"admin/display_prefs.php?", 'SA_SETUPDISPLAY', MENU_SETTINGS,'');
				}
				if ($mainmodule['SETUP']['COMPANY'][122]['name'] == "Forms Setup" && $mainmodule['SETUP']['COMPANY'][122]['active'] == "1"){
					$this->add_lapp_function(0, _("Forms Setup"),
						"admin/forms_setup.php?", 'SA_FORMSETUP', MENU_SETTINGS,'');
				}

					if ($_SESSION['SysPrefs']->prefs['gst_no'] == null) {
			        }else{
			        	if ($mainmodule['SETUP']['COMPANY'][123]['name'] == "Taxes" && $mainmodule['SETUP']['COMPANY'][123]['active'] == "1"){
							$this->add_rapp_function(0, _("Taxes"),
							"taxes/tax_types.php?", 'SA_TAXRATES', MENU_MAINTENANCE,'share-square-o');
						}
			        }
			    if ($mainmodule['SETUP']['COMPANY'][124]['name'] == "System & GL Setup" && $mainmodule['SETUP']['COMPANY'][124]['active'] == "1"){
					$this->add_rapp_function(0, _("System and General GL Setup"),
						"admin/gl_setup.php?", 'SA_GLSETUP', MENU_SETTINGS,'');
				}
				if ($mainmodule['SETUP']['COMPANY'][125]['name'] == "Fiscal Years" && $mainmodule['SETUP']['COMPANY'][125]['active'] == "1"){
					$this->add_rapp_function(0, _("Fiscal Years"), "admin/fiscal-years", 'SA_FISCALYEARS', MENU_MAINTENANCE,'');
				}

				if( config_ci('mobile_document')){
				    $this->add_rapp_function(0, _("Expense Type"),"admin/expense-type", 'SA_PRINTPROFILE', MENU_MAINTENANCE,"");
				    $this->add_rapp_function(0, _("Revenue Type"),"admin/revenue-type", 'SA_PRINTPROFILE', MENU_MAINTENANCE,"");
				}
			}

			if ($mainmodule['SETUP']['MISCELLANOUS']['status'] == "1"){
				$this->add_module(_("Miscellaneous"), '');
				if ($mainmodule['SETUP']['MISCELLANOUS'][126]['name'] == "Payment Terms" && $mainmodule['SETUP']['MISCELLANOUS'][126]['active'] == "1"){
					$this->add_lapp_function(1, _("Payment Terms"),
						"admin/payment_terms.php?", 'SA_PAYTERMS', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MISCELLANOUS'][127]['name'] == "Shipping Company" && $mainmodule['SETUP']['MISCELLANOUS'][127]['active'] == "1"){
					$this->add_lapp_function(1, _("Shipping Company"),
						"admin/shipping_companies.php?", 'SA_SHIPPING', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MISCELLANOUS'][128]['name'] == "Points of Sales" && $mainmodule['SETUP']['MISCELLANOUS'][128]['active'] == "1"){
					$this->add_rapp_function(1, _("Points of Sale"), "sales/manage/sales_points.php?", 'SA_POSSETUP', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MISCELLANOUS'][129]['name'] == "Printers" && $mainmodule['SETUP']['MISCELLANOUS'][129]['active'] == "1"){
					$this->add_rapp_function(1, _("Printers"), "admin/printers.php?", 'SA_PRINTERS', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MISCELLANOUS'][130]['name'] == "Contact Categories" && $mainmodule['SETUP']['MISCELLANOUS'][130]['active'] == "1"){
					$this->add_rapp_function(1, _("Contact Categories"), "admin/crm_categories.php?", 'SA_CRMCATEGORY', MENU_MAINTENANCE,'');
				}
			}

			if ($mainmodule['SETUP']['MAINTENANCE']['status'] == "1"){
				$this->add_module(_("Maintenance"), '');
				if ($mainmodule['SETUP']['MAINTENANCE'][131]['name'] == "Void a Transaction" && $mainmodule['SETUP']['MAINTENANCE'][131]['active'] == "1"){
					$this->add_lapp_function(2, _("Void a Transaction"),"admin/void_transaction.php?", 'SA_VOIDTRANSACTION', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MAINTENANCE'][132]['name'] == "View or Print Transaction" && $mainmodule['SETUP']['MAINTENANCE'][132]['active'] == "1"){
					$this->add_lapp_function(2, _("View or Print Transactions"),
						"admin/view_print_transaction.php?", 'SA_VIEWPRINTTRANSACTION', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MAINTENANCE'][133]['name'] == "Attach Documents" && $mainmodule['SETUP']['MAINTENANCE'][133]['active'] == "1"){
					$this->add_lapp_function(2, _("Attach Documents"),
						"admin/attachments.php?filterType=20", 'SA_ATTACHDOCUMENT', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['MAINTENANCE'][134]['name'] == "Audit Trails" && $mainmodule['SETUP']['MAINTENANCE'][134]['active'] == "1"){
					$this->add_lapp_function(2, _("Audit Trail"),
							"admin/audit-trail", 'SA_VIEWPRINTTRANSACTION', MENU_MAINTENANCE,'');
				}
					if( config_ci('kastam')){
					    $this->add_lapp_function(2, _("Fix Posting"),"gl/fix_posting.php", 'SA_ATTACHDOCUMENT', MENU_MAINTENANCE,'');
					    $this->add_lapp_function(2, _("Bad debt"),"admin/bad_deb.php", 'SA_ATTACHDOCUMENT', MENU_MAINTENANCE,'');
					}
			}

			if ($mainmodule['SETUP']['OPENING BALANCES']['status'] == "1"){
				$this->add_module(_("Opening Balances"), '');
				if ($mainmodule['SETUP']['OPENING BALANCES'][135]['name'] == "Bank Accounts" && $mainmodule['SETUP']['OPENING BALANCES'][135]['active'] == "1"){
					$this->add_lapp_function(3, _("Bank Account"), "maintenance/opening/bank", 'SA_VOIDTRANSACTION', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['OPENING BALANCES'][136]['name'] == "System GL Balances" && $mainmodule['SETUP']['OPENING BALANCES'][136]['active'] == "1"){
					$this->add_lapp_function(3, _("System GL Accounts"),"opening/gl", 'SA_VIEWPRINTTRANSACTION', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['OPENING BALANCES'][137]['name'] == "Inventory" && $mainmodule['SETUP']['OPENING BALANCES'][137]['active'] == "1"){
					$this->add_lapp_function(3, _("Inventory"),"admin/opening.php?type=inventory", 'SA_VOIDTRANSACTION', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['OPENING BALANCES'][138]['name'] == "Customers" && $mainmodule['SETUP']['OPENING BALANCES'][138]['active'] == "1"){
					$this->add_lapp_function(3, _("Customer"),"opening/customer", 'SA_VOIDTRANSACTION', MENU_MAINTENANCE,'');
				}
				if ($mainmodule['SETUP']['OPENING BALANCES'][139]['name'] == "Suppliers" && $mainmodule['SETUP']['OPENING BALANCES'][139]['active'] == "1"){
					$this->add_lapp_function(3, _("Supplier"),"opening/supplier", 'SA_VOIDTRANSACTION', MENU_MAINTENANCE,'');
				}
			}
		}
		$this->add_extensions();
	}
}


?>
