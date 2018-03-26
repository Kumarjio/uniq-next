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
//
$direct = $_POST['guna'];
if($direct == 'add'){
	add();
}elseif($direct == 'delete'){
	delete();
}

//testing

function add(){
	$company_id = $_POST['comp_id'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	setcookie('comp_name', $company_id, time() + (86400 * 30 * 12), '/');
	setcookie('name_name', $username, time() + (86400 * 30 * 12), '/');
	setcookie('pass_name', $password, time() + (86400 * 30 * 12), '/');
	echo json_encode($company_id);
}
function delete(){
	setcookie('name_name', '', time() + (86400 * 30 * 12), '/');
	setcookie('pass_name', '', time() + (86400 * 30 * 12), '/');
	echo json_encode('ok');
}
?>
