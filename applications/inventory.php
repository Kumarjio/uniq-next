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
class inventory_app extends application
{
	function inventory_app()
	{
		$mainmodule = $_SESSION['apidumm'];
        if($mainmodule['INVENTORY']['status'] == "1"){
			$this->application("stock", _($this->help_context = "Products"),true,'local_shipping', 'green-text darken-4');

			if($mainmodule['INVENTORY']['OPERATIONS']['status'] == "1"){
				$this->add_module(_("Operations"), '');

				if ($mainmodule['INVENTORY']['OPERATIONS'][57]['name'] == "Inventory Location Transfers" && $mainmodule['INVENTORY']['OPERATIONS'][57]['active'] == "1"){
					$this->add_lapp_function(0, _("Inventory Location Transfers"),
						"inventory/transfers.php?NewTransfer=1", 'SA_LOCATIONTRANSFER', MENU_TRANSACTION,'');
				}

				if ($mainmodule['INVENTORY']['OPERATIONS'][58]['name'] == "Inventory Adjustments" && $mainmodule['INVENTORY']['OPERATIONS'][58]['active'] == "1"){
					$this->add_lapp_function(0, _("Inventory Adjustments"),
						"inventory/adjustments.php?NewAdjustment=1", 'SA_INVENTORYADJUSTMENT', MENU_TRANSACTION,'');
				}
			}else{
				$this->add_rapp_function(0, '','', '', '','');
			}

			if($mainmodule['INVENTORY']['INQUIRIES']['status'] == "1"){
				$this->add_module(_("Inquiry"), '');

				if ($mainmodule['INVENTORY']['INQUIRIES'][59]['name'] == "Inventory Item Movement" && $mainmodule['INVENTORY']['INQUIRIES'][59]['active'] == "1"){
					$this->add_lapp_function(1, _("Inventory Item Movements"),
						"inventory/inquiry/stock_movements.php?", 'SA_ITEMSTRANSVIEW', MENU_INQUIRY,'');
				}

				if ($mainmodule['INVENTORY']['INQUIRIES'][60]['name'] == "Inventory Item Status" && $mainmodule['INVENTORY']['INQUIRIES'][60]['active'] == "1"){
					$this->add_lapp_function(1, _("Inventory Item Status"),
						"inventory/inquiry/stock_status.php?", 'SA_ITEMSSTATVIEW', MENU_INQUIRY,'');
				}
			}else{
				$this->add_rapp_function(1, '','', '', '','');
			}

			if($mainmodule['INVENTORY']['REPORTS']['status'] == "1"){
				$this->add_module(_("Reports"), '');

				if ($mainmodule['INVENTORY']['REPORTS'][61]['name'] == "Inventory Valuation Report" && $mainmodule['INVENTORY']['REPORTS'][61]['active'] == "1"){
					$this->add_rapp_function(2, _("Inventory Valuation Report"),
						"reporting/reports_main.php?Class=2&REP_ID=301", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][62]['name'] == "Inventory Planning Report" && $mainmodule['INVENTORY']['REPORTS'][62]['active'] == "1"){
					$this->add_rapp_function(2, _("Inventory Planning Report"),
						"reporting/reports_main.php?Class=2&REP_ID=302", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][63]['name'] == "Stock Check Sheets" && $mainmodule['INVENTORY']['REPORTS'][63]['active'] == "1"){
					$this->add_rapp_function(2, _("Stock Check Sheets"),
						"reporting/reports_main.php?Class=2&REP_ID=303", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][64]['name'] == "Inventory Sales Report" && $mainmodule['INVENTORY']['REPORTS'][64]['active'] == "1"){
					$this->add_rapp_function(2, _("Inventory Sales Report"),
						"reporting/reports_main.php?Class=2&REP_ID=304", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][65]['name'] == "GNL Valuation Report" && $mainmodule['INVENTORY']['REPORTS'][65]['active'] == "1"){
					$this->add_rapp_function(2, _("GNL Valuation Report"),
						"reporting/reports_main.php?Class=2&REP_ID=305", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][66]['name'] == "Inventory Purchasing Report" && $mainmodule['INVENTORY']['REPORTS'][66]['active'] == "1"){
					$this->add_rapp_function(2, _("Inventory Purchasing Report"),
						"reporting/reports_main.php?Class=2&REP_ID=306", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][67]['name'] == "Inventory Movement Report" && $mainmodule['INVENTORY']['REPORTS'][67]['active'] == "1"){
					$this->add_rapp_function(2, _("Inventory Movement Report"),
						"reporting/reports_main.php?Class=2&REP_ID=307", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][68]['name'] == "Costed Inventory Report" && $mainmodule['INVENTORY']['REPORTS'][68]['active'] == "1"){
					$this->add_rapp_function(2, _("Costed Inventory Movement Report"),
						"reporting/reports_main.php?Class=2&REP_ID=308", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}

				if ($mainmodule['INVENTORY']['REPORTS'][69]['name'] == "Item Sales Summary Report" && $mainmodule['INVENTORY']['REPORTS'][69]['active'] == "1"){
					$this->add_rapp_function(2, _("Item Sales Summary Report"),
						"reporting/reports_main.php?Class=2&REP_ID=309", 'SA_ITEMSTRANSVIEW', MENU_REPORT,'');
				}
			}else{
				$this->add_rapp_function(2, '','', '', '','');
			}
		// 		$this->add_module(_("Document Printing"));

			if($mainmodule['INVENTORY']['HOUSEKEEPING']['status'] == "1"){
				$this->add_module(_("Housekeeping"), '');

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][70]['name'] == "Items" && $mainmodule['INVENTORY']['HOUSEKEEPING'][70]['active'] == "1"){
					$this->add_lapp_function(3, _("Items"),
						"inventory/manage/items.php?", 'SA_ITEM', MENU_ENTRY,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][71]['name'] == "Foreign Item Codes" && $mainmodule['INVENTORY']['HOUSEKEEPING'][71]['active'] == "1"){
					$this->add_lapp_function(3, _("Foreign Item Codes"),
						"inventory/manage/item_codes.php?", 'SA_FORITEMCODE', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][72]['name'] == "Sales Kits" && $mainmodule['INVENTORY']['HOUSEKEEPING'][72]['active'] == "1"){
					$this->add_lapp_function(3, _("Sales Kits"),
						"inventory/manage/sales_kits.php?", 'SA_SALESKIT', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][73]['name'] == "Item Categories" && $mainmodule['INVENTORY']['HOUSEKEEPING'][73]['active'] == "1"){
					$this->add_lapp_function(3, _("Item Categories"),
						"inventory/manage/item_categories.php?", 'SA_ITEMCATEGORY', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][74]['name'] == "Inventory Locations" && $mainmodule['INVENTORY']['HOUSEKEEPING'][74]['active'] == "1"){
					$this->add_lapp_function(3, _("Inventory Locations"),
						"inventory/manage/locations.php?", 'SA_INVENTORYLOCATION', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][75]['name'] == "Inventory Movement Types" && $mainmodule['INVENTORY']['HOUSEKEEPING'][75]['active'] == "1"){
					$this->add_lapp_function(3, _("Inventory Movement Types"),
						"inventory/manage/movement_types.php?", 'SA_INVENTORYMOVETYPE', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][76]['name'] == "Units of Measure" && $mainmodule['INVENTORY']['HOUSEKEEPING'][76]['active'] == "1"){
					$this->add_lapp_function(3, _("Units of Measure"),
						"inventory/manage/item_units.php?", 'SA_UOM', MENU_MAINTENANCE,'');
				}

				// if ($item_menu_housekeeping[76]['name'] != "Units of Measure" && $item_menu_housekeeping[76]['active'] == "0"){
					$this->add_lapp_function(4, _("Reorder Levels"),
						"inventory/reorder_level.php?", 'SA_REORDER', MENU_MAINTENANCE,'');
				// }

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][77]['name'] == "Sales Pricing" && $mainmodule['INVENTORY']['HOUSEKEEPING'][77]['active'] == "1"){
					$this->add_lapp_function(3, _("Sales Pricing"),
						"inventory/prices.php?", 'SA_SALESPRICE', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][78]['name'] == "Purchasing Pricing" && $mainmodule['INVENTORY']['HOUSEKEEPING'][78]['active'] == "1"){
					$this->add_lapp_function(3, _("Purchasing Pricing"),
						"inventory/purchasing_data.php?", 'SA_PURCHASEPRICING', MENU_MAINTENANCE,'');
				}

				if ($mainmodule['INVENTORY']['HOUSEKEEPING'][79]['name'] == "Standard Costs" && $mainmodule['INVENTORY']['HOUSEKEEPING'][79]['active'] == "1"){
					$this->add_rapp_function(3, _("Standard Costs"),
						"inventory/cost_update.php?", 'SA_STANDARDCOST', MENU_MAINTENANCE,'');
				}
			}else{
				$this->add_rapp_function(3, '','', '', '','');
			}
		}
		$this->add_extensions();
	}
}


?>
