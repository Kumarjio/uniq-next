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
class general_ledger_app extends application
{
	function general_ledger_app()
	{
		$mainmodule = $_SESSION['apidumm'];
        if( $mainmodule['CASH and GL']['status'] == "1"){

			$this->application("GL", _($this->help_context = "Cash and GL"),true,'monetization_on');
			$this->add_module(_("Dashboard"), "", "gl/dashboard");

			if( $mainmodule['CASH and GL']['OPERATIONS']['status'] == "1"){
				$this->add_module(_("Operations"), '');
				if ( $mainmodule['CASH and GL']['OPERATIONS'][80]['name'] == "Payments" &&  $mainmodule['CASH and GL']['OPERATIONS'][80]['active'] == "1"){
					$this->add_lapp_function(1, _("Payments"), "gl/inquiry/journal_inquiry.php?filtertype=1", 'SA_PAYMENT', MENU_TRANSACTION,'');
				}
				if ( $mainmodule['CASH and GL']['OPERATIONS'][81]['name'] == "Receipts" &&  $mainmodule['CASH and GL']['OPERATIONS'][81]['active'] == "1"){
					$this->add_lapp_function(1, _("Deposits"), "gl/inquiry/journal_inquiry.php?filtertype=2", 'SA_DEPOSIT', MENU_TRANSACTION,'');
				}
				if ( $mainmodule['CASH and GL']['OPERATIONS'][82]['name'] == "Bank Account Transfers" &&  $mainmodule['CASH and GL']['OPERATIONS'][82]['active'] == "1"){
					$this->add_lapp_function(1, _("Bank Account Transfers"), "gl/bank_transfer.php?", 'SA_BANKTRANSFER', MENU_TRANSACTION,'');
				}
				if ( $mainmodule['CASH and GL']['OPERATIONS'][83]['name'] == "Journal Entry" &&  $mainmodule['CASH and GL']['OPERATIONS'][83]['active'] == "1"){
					$this->add_rapp_function(1, _("Journal Entry"),
						"gl/gl_journal.php?NewJournal=Yes", 'SA_JOURNALENTRY', MENU_TRANSACTION,'');
				}
				if ( $mainmodule['CASH and GL']['OPERATIONS'][85]['name'] == "Budget Entry" &&  $mainmodule['CASH and GL']['OPERATIONS'][85]['active'] == "1"){
					$this->add_rapp_function(1, _("Budget Entry"),
						"gl/gl_budget.php?", 'SA_BUDGETENTRY', MENU_TRANSACTION,'');
				}
				if ( $mainmodule['CASH and GL']['OPERATIONS'][84]['name'] == "Reconcile Bank Account" &&  $mainmodule['CASH and GL']['OPERATIONS'][84]['active'] == "1"){
					$this->add_rapp_function(1, _("Reconcile Bank Account"),
						"gl/bank_account_reconcile.php?", 'SA_RECONCILE', MENU_TRANSACTION,'');
				}
			}else{
				$this->add_rapp_function(1,'','','','','');
			}

			if( $mainmodule['CASH and GL']['INQUIRIES']['status'] == "1"){
				$this->add_module(_("Inquiry"), '');

				if ($_SESSION['SysPrefs']->prefs['gst_no'] == null) {
		        }else{

					if( defined('COUNTRY') && COUNTRY==65 ){
						if ( $mainmodule['CASH and GL']['INQUIRIES'][86]['name'] == "GST Form 3 / Form 5" &&  $mainmodule['CASH and GL']['INQUIRIES'][86]['active'] == "1"){
					    	$this->add_lapp_function(2, _("GST Form 5"),"gst/form-5", 'SA_GLANALYTIC', MENU_INQUIRY,'');
					    }
					} else {
						if ( $mainmodule['CASH and GL']['INQUIRIES'][86]['name'] == "GST Form 3 / Form 5" &&  $mainmodule['CASH and GL']['INQUIRIES'][86]['active'] == "1"){
					    	$this->add_lapp_function(2, _("GST Form 3"),"index.php/gst/form-3", 'SA_GLANALYTIC', MENU_INQUIRY,'');
					    }
					}
		        }

		        if ( $mainmodule['CASH and GL']['INQUIRIES'][87]['name'] == "Journal" &&  $mainmodule['CASH and GL']['INQUIRIES'][87]['active'] == "1"){
					$this->add_lapp_function(2, _("Journal"),
						"gl/inquiry/journal_inquiry.php?", 'SA_GLANALYTIC', MENU_INQUIRY,'');
				}
				if ( $mainmodule['CASH and GL']['INQUIRIES'][88]['name'] == "GL" &&  $mainmodule['CASH and GL']['INQUIRIES'][88]['active'] == "1"){
					$this->add_lapp_function(2, _("GL"),
						"gl/inquiry/gl_account_inquiry.php?", 'SA_GLTRANSVIEW', MENU_INQUIRY,'');
				}
				if ( $mainmodule['CASH and GL']['INQUIRIES'][89]['name'] == "Bank Account" &&  $mainmodule['CASH and GL']['INQUIRIES'][89]['active'] == "1"){
					$this->add_lapp_function(2, _("Bank Account"),
						"gl/inquiry/bank_inquiry.php?", 'SA_BANKTRANSVIEW', MENU_INQUIRY,'');
				}
				if ( $mainmodule['CASH and GL']['INQUIRIES'][90]['name'] == "GST Tax" &&  $mainmodule['CASH and GL']['INQUIRIES'][90]['active'] == "1"){
					$this->add_lapp_function(2, _("Tax"),
						"gl/inquiry/tax_inquiry.php?", 'SA_TAXREP', MENU_INQUIRY,'');
				}
				if ( $mainmodule['CASH and GL']['INQUIRIES'][91]['name'] == "Trial balance" &&  $mainmodule['CASH and GL']['INQUIRIES'][91]['active'] == "1"){
					$this->add_rapp_function(2, _("Trial Balance"),
						"gl/inquiry/gl_trial_balance.php?", 'SA_GLANALYTIC', MENU_INQUIRY,'');
				}
				if ( $mainmodule['CASH and GL']['INQUIRIES'][92]['name'] == "Balance Sheet Drilldown" &&  $mainmodule['CASH and GL']['INQUIRIES'][92]['active'] == "1"){
					$this->add_rapp_function(2, _("Balance Sheet Drilldown"),
						"gl/inquiry/balance_sheet.php?", 'SA_GLANALYTIC', MENU_INQUIRY,'');
				}
				if ( $mainmodule['CASH and GL']['INQUIRIES'][93]['name'] == "Profit & Loss Drilldown" &&  $mainmodule['CASH and GL']['INQUIRIES'][93]['active'] == "1"){
					$this->add_rapp_function(2, _("Profit and Loss Drilldown"),
						"gl/inquiry/profit_loss.php?", 'SA_GLANALYTIC', MENU_INQUIRY,'');
				}
			}else{
				$this->add_rapp_function(2,'','','','','');
			}

			if( $mainmodule['CASH and GL']['REPORTS']['status'] == "1"){
				$this->add_module(_("Reports"), '');

				if ( $mainmodule['CASH and GL']['REPORTS'][94]['name'] == "Bank Statement" &&  $mainmodule['CASH and GL']['REPORTS'][94]['active'] == "1"){
					$this->add_rapp_function(3, _("Bank Statement"),
						"reporting/reports_main.php?Class=5&REP_ID=601", 'SA_BANKREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][95]['name'] == "Chart of Accounts" &&  $mainmodule['CASH and GL']['REPORTS'][95]['active'] == "1"){
					$this->add_rapp_function(3, _("Chart of Accounts"),
						"reporting/reports_main.php?Class=6&REP_ID=701", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][96]['name'] == "List of Journal Entries" &&  $mainmodule['CASH and GL']['REPORTS'][96]['active'] == "1"){
					$this->add_rapp_function(3, _("List of Journal Entries"),
						"reporting/reports_main.php?Class=6&REP_ID=702", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][97]['name'] == "GL Account Transactions" &&  $mainmodule['CASH and GL']['REPORTS'][97]['active'] == "1"){
					$this->add_rapp_function(3, _("GL Account Transactions"),
						"reporting/reports_main.php?Class=6&REP_ID=704", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][99]['name'] == "Balance Sheet" &&  $mainmodule['CASH and GL']['REPORTS'][99]['active'] == "1"){
					$this->add_rapp_function(3, _("Balance Sheet"),
						"reporting/reports_main.php?Class=6&REP_ID=706", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][100]['name'] == "Profit & Loss Statement" &&  $mainmodule['CASH and GL']['REPORTS'][100]['active'] == "1"){
					$this->add_rapp_function(3, _("Profit and Loss Statement"),
						"reporting/reports_main.php?Class=6&REP_ID=707", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][101]['name'] == "Trial Balance" &&  $mainmodule['CASH and GL']['REPORTS'][101]['active'] == "1"){
					$this->add_rapp_function(3, _("Trial Balance"),
						"reporting/reports_main.php?Class=6&REP_ID=708", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][102]['name'] == "Tax Report" &&  $mainmodule['CASH and GL']['REPORTS'][102]['active'] == "1"){
					$this->add_rapp_function(3, _("Tax Report"),
						"reporting/reports_main.php?Class=6&REP_ID=709", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][103]['name'] == "Audit Trail" &&  $mainmodule['CASH and GL']['REPORTS'][103]['active'] == "1"){
					$this->add_rapp_function(3, _("Audit Trail"), "reporting/reports_main.php?Class=6&REP_ID=710", 'SA_GLREP', MENU_REPORT,'');
				}
				if ( $mainmodule['CASH and GL']['REPORTS'][104]['name'] == "GST Grouping Details" &&  $mainmodule['CASH and GL']['REPORTS'][104]['active'] == "1"){
					$this->add_rapp_function(3, _("GST Grouping Details"), "index.php/tax/grouping-details", 'SA_GLREP', MENU_REPORT,'');
				}
			}else{
				$this->add_rapp_function(3,'','','','','');
			}

			if( $mainmodule['CASH and GL']['DOC PRINTING']['status'] == "1"){
				$this->add_module(_("Document Printing"), '');
				if ( $mainmodule['CASH and GL']['DOC PRINTING'][140]['name'] == "Bank Payment Voucher" &&  $mainmodule['CASH and GL']['DOC PRINTING'][140]['active'] == "1"){

					$this->add_lapp_function(4, _("Bank Payment Voucher"), "reporting/reports_bank.php?type=".ST_BANKPAYMENT, 'SA_BANKACCOUNT', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['DOC PRINTING'][141]['name'] == "Bank Deposit Voucher" &&  $mainmodule['CASH and GL']['DOC PRINTING'][141]['active'] == "1"){

					$this->add_lapp_function(4, _("Bank Deposit Voucher"), "reporting/reports_bank.php?type=".ST_BANKDEPOSIT, 'SA_BANKACCOUNT', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['DOC PRINTING'][142]['name'] == "Bank Account Transfer Voucher" &&  $mainmodule['CASH and GL']['DOC PRINTING'][142]['active'] == "1"){

					$this->add_lapp_function(4, _("Bank Account Transfer Voucher"), "reporting/reports_bank.php?type=".ST_BANKTRANSFER, 'SA_BANKACCOUNT', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['DOC PRINTING'][143]['name'] == "Bank Reconcile" &&  $mainmodule['CASH and GL']['DOC PRINTING'][143]['active'] == "1"){

					$this->add_lapp_function(4, _("Bank Reconcile"), "bank/report/reconcile", 'SA_BANKACCOUNT', MENU_MAINTENANCE,'');
				}
			}else{
				$this->add_rapp_function(4,'','','','','');
			}

			if( $mainmodule['CASH and GL']['HOUSEKEEPING']['status'] == "1"){
				$this->add_module(_("Housekeeping"), '');
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][105]['name'] == "Bank Accounts" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][105]['active'] == "1"){

					$this->add_lapp_function(5, _("Bank Accounts"),
						"gl/manage/bank_accounts.php?", 'SA_BANKACCOUNT', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][106]['name'] == "Quick Entries" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][106]['active'] == "1"){

					$this->add_lapp_function(5, _("Quick Entries"),
						"gl/manage/gl_quick_entries.php?", 'SA_QUICKENTRY', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][107]['name'] == "Account Tags" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][107]['active'] == "1"){

					$this->add_lapp_function(5, _("Account Tags"),
						"admin/tags.php?type=account", 'SA_GLACCOUNTTAGS', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][108]['name'] == "Currencies" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][108]['active'] == "1"){

					$this->add_lapp_function(5, "","");
					$this->add_lapp_function(5, _("Currencies"),
						"gl/manage/currencies.php?", 'SA_CURRENCY', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][109]['name'] == "Exchange Rates" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][109]['active'] == "1"){

					$this->add_lapp_function(5, _("Exchange Rates"),
						"gl/manage/exchange_rates.php?", 'SA_EXCHANGERATE', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][110]['name'] == "GL Accounts" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][110]['active'] == "1"){
					$this->add_rapp_function(5, _("GL Accounts"),
						"gl/manage/gl_accounts.php?", 'SA_GLACCOUNT', MENU_ENTRY,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][111]['name'] == "GL Account Classes" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][111]['active'] == "1"){

					$this->add_rapp_function(5, _("GL Account Groups"),
						"gl/manage/gl_account_types.php?", 'SA_GLACCOUNTGROUP', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][111]['name'] == "GL Account Classes" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][111]['active'] == "1"){

					$this->add_rapp_function(5, _("GL Account Classes"),
						"gl/manage/gl_account_classes.php?", 'SA_GLACCOUNTCLASS', MENU_MAINTENANCE,'');
				}
				if ( $mainmodule['CASH and GL']['HOUSEKEEPING'][112]['name'] == "Revaluation of Currency Accounts" &&  $mainmodule['CASH and GL']['HOUSEKEEPING'][112]['active'] == "1"){

					$this->add_rapp_function(5, _("Revaluation of Currency Accounts"),
						"gl/manage/revaluate_currencies.php?", 'SA_EXCHANGERATE', MENU_MAINTENANCE,'');
				}
			}else{
				$this->add_rapp_function(5,'','','','','');
			}
		}
		$this->add_extensions();
	}
}


?>
