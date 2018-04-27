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
class accountantarea_app extends application
{
	function accountantarea_app()
	{
        $mainmodule = $_SESSION['apidumm'];

        if(isset($mainmodule['ACCOUNTANT']['MOBILE ACCOUNTANT']['status']) == "1"){
            $this->application("AC", _($this->help_context = "Accountant"), true, 'book', 'cyan-text accent-2');
            if (isset($mainmodule['ACCOUNTANT']['MOBILE ACCOUNTANT'][116]['name']) == "Mobile Accountant" && isset($mainmodule['ACCOUNTANT']['MOBILE ACCOUNTANT'][116]['active']) == "1"){

                $this->add_module(_("Mobile Accountant"), '', "documents/bookkeepers");
            }
        }
            $this->add_extensions();
	}
}


?>
