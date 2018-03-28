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

if (!isset($path_to_root) || isset($_GET['path_to_root']) || isset($_POST['path_to_root']))
	die(_("Restricted access"));

include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/page/header.inc");

$js = "<script language='JavaScript' type='text/javascript'>
function defaultCompany(){
	document.forms[0].company_login_name.options[".$_SESSION["wa_current_user"]->company."].selected = true;
}
</script>";
add_js_file('login.js');
// Display demo user name and password within login form if "$allow_demo_mode" is true
if ($allow_demo_mode == true){
	    //$demo_text = _("Login as user: demouser and password: password");
} else {
	//$demo_text = _("Please login here");
	if (@$allow_password_reset) {
      $demo_text .= " "._("or")." <a href='$path_to_root/index.php?reset=1'>"._("request new password")."</a>";
    }
}

if (check_faillog()) {
		$blocked_msg = '<span class=redfg>'._('Too many failed login attempts.<br>Please wait a while or try later.').'</span>';

	    $js .= "<script>setTimeout(function() {
	    	document.getElementsByName('SubmitUser')[0].disabled=0;
	    	document.getElementById('log_msg').innerHTML='$demo_text'}, 1000*$login_delay);</script>";
	    $demo_text = $blocked_msg;
}
if (!isset($def_coy))
	$def_coy = 0;

$def_theme = "default";

$login_timeout = $_SESSION["wa_current_user"]->last_act;

$title = $login_timeout ? _('Authorization timeout') : $app_title." - "._("Login");
$encoding = isset($_SESSION['language']->encoding) ? $_SESSION['language']->encoding : "iso-8859-1";
$rtl = isset($_SESSION['language']->dir) ? $_SESSION['language']->dir : "ltr";
$onload = !$login_timeout ? "onload='defaultCompany()'" : "";

$coy_name = null;
$company_info = $ci->db->where_in('name',array('coy_name','coy_logo'))->get('sys_prefs')->result();
if( $company_info ){
    foreach ($company_info AS $info){
        if( $info->name=='coy_logo' ){
            $coy_logo = $info->value;
        } else if ($info->name=='coy_name') {
            $coy_name = $info->value;
        }
    }
}

$coy_logo = company_logo();
include_once($path_to_root . "/themes/$theme/renderer.php");
$rend = new renderer();

// $login_cek = "disabled=disabled";

// if($db_connections[0]['dbname']!=COUNTRY."_uniqdefault" || $db_connections[0]['dbname']!="uniq365_onlyou"){
// 	$login_cek = "";
// }

//hack
$login_cek = "";

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo 'Login - '.$power_by?></title>
        <meta content="text/html;charset=iso-8859-1" http-equiv="content-type">
        <meta content="width=device-width,initial-scale=1" name="viewport">
				<link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon" />
        <link href="login.html" rel="canonical">

        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/syncard/css/components.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/syncard/css/login.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
		    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/syncard/css/login.css" rel="stylesheet" type="text/css">

				<style>
					.g-recaptcha {
						transform-origin: left top;
						-webkit-transform-origin: left top;
					}
				</style>

    </head>
    <body class="login">
        <div class="uniq-login-bag"></div>
        <div class="uniq-login-place">
		<div class="row uniq-login-container">
				<!-- <div class="col-md-6">
	            <div class="uniq-logo">
	                <img src="assets/images/bluecloud.png"/>
	                <h3>Already using Uniq365?</h3>
	                <h5>Best Accounting in the cloud ever.</h5>
	                <h5>Feel free and,</h5>
	                <h2>Join us.</h2>
	                <p><a href="#">landing.uniq365.com</a></p> -->
	                <!-- <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#partnerLogin">Login as partner.</button></p> -->
	            <!-- </div>
            	</div> -->
            	<div class="col-md-3"></div>
				<div class="col-md-6">
	            <?php start_form(false, false, $_SESSION['timeout']['uri'], "loginform");?>
								<img class="responsive-img" src="/assets/images/bluecloud.png" style="max-width:70px"/>
	             	<h5>UNIQ365</h5>
								<hr/>
								<!-- <p>connect your company ID first, before sign in.</p> -->

								<div class="uniq-group">
		              <div class="uniq-field" style="display:none">
			                <?php $comp_name = (isset($_COOKIE['comp_name'])) ? $_COOKIE['comp_name'] : null; ?>
											<input type='text' placeholder='Company ID' class='touch' name='CompanyName' value="<?=$comp_name?>" readonly="readonly"/>
		              </div>


		              <?php if (empty($db)){ ?>
		              		<?php
												// if (isset($_COOKIE['message_for']) == null) setcookie('message_for', 'testing', time() + (86400 + 30), '/');
											 	// else{
											?>
													<!-- <div class="uniq-field button">
														<button type="submit"><span class="fa fa-recycle fa-spin"></span></button>
													</div>
													<div class="led-box"><div class="led-container"><div class="led-red"></div><span>your company is not connected</span></div></div> -->
		              		<?php
												// }
											?>

		              		<!-- <div class="uniq-field button">
				                <button type="submit">Connect</button>
				            	</div> -->


	                <?php }else{ setcookie('message_for', null, -1, '/');?>

												<!-- <div class="uniq-field button">
													<button type="button" id="refresh"><span class="fa fa-refresh"></span></button>
												</div>
												<div class="led-box"><div class="led-container"><div class="led-green"></div><span>your company is connected</span></div></div> -->

	                <?php } ?>
								</div>
			      	<div class="row">
					    <div class="input-field">
					        <?php $name_name = (isset($_COOKIE['name_name'])) ? $_COOKIE['name_name'] : null; ?>
							<input id="email" type="email" class="validate" class="touch" name="user_name_entry_field" value='<?=$name_name?>' <?=$login_cek?>/>
					        <label for="email">Email</label>
					        <input type='hidden' id=ui_mode name='ui_mode' value="<?php echo $_SESSION["wa_current_user"]->ui_mode;?>" />
					    </div>
					
			            <div class="input-field">
			            	<?php $pass_name = (isset($_COOKIE['pass_name'])) ? $_COOKIE['pass_name'] : null; ?>
			                <input id="password" type="password" class="validate" class="touch" name="password" value='<?=$pass_name?>' <?=$login_cek?>/>
			                <label for="password">Password</label>
			            </div>
					</div>
		            <div class="form-group">
		                <div class="row uniq-field">
			            	<?php // if (isset($_COOKIE['comp_name']) != ''){ ?>
				            	<!-- <div class="col s12 c-container" style="padding: 0 !important">
				                	<div class="g-recaptcha" data-sitekey="6LfjHDYUAAAAACB4XaK_8o5hcTYVdRREw83UXwEu"></div>
				            	</div> -->
				            <?php // } ?>
		            		</div>
										<?php
											// if(isset($_SESSION['login'])){
											// 		echo '<p>Your account has login in other device</p>'.
							        //     		 '<p>please check company name or input username and password</p>' ;
											// }
										?>
	                  <div class="uniq-field button">
	                      <button class="btn waves-effect blue waves-light" name=btn_login type="button" lang="btnlog-1" <?=$login_cek?>>Sign in</button>
	                  </div>

	                  <!-- Modal accountbook list -->
 						<div id="accountbookList" hidden="">
 						    <!-- Modal content-->
 						    <!-- <div class="content"> -->
 						      <div class="input-field">
 						      <!-- <hr> -->
 						        <p>Select accountbook. (Scroll)</p>
 						      <!-- </div> -->
 						      <div class="body" style="overflow-y:scroll; height:150px; background-color: transparent;">&nbsp;</div>
 						    </div>
 						  <!-- </div> -->
 						</div>

	                  <?php //if (isset($_COOKIE['message_for_login']) != 'null'){ ?>
						<!-- <div id="message_for_login">
							<p>If you can not sign in, check your username or password, otherwise your company is not linked in the plan.</p>
						</div> -->
	              		<?php //} ?>

	                  <input type="hidden" name="company_login_name" value="0" />
	         			</div>
						  <?php end_form(1)?>
						 </div>
					 </div>
				 </div>

					 <!-- Define partner login element -->
					 <!-- Modal login -->
						<!-- <div id="partnerLogin" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-sm"> -->

						    <!-- Modal content-->
						    <!-- <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Partner login.</h4>
						      </div>
						      <div class="modal-body">
										<form id="accessForm">
											<div class="form-group">
				                <input type="text" placeholder="Partner ID" class="form-control login-partner" name="partner_user" autocomplete="off"/>
											</div>
											<div class="form-group">
				                <input type="password" placeholder="Password" class="form-control login-partner" name="partner_pass" autocomplete="new-password"/>
											</div>
										</form>
						      </div>
						      <div class="modal-footer">
							        <button type="button" class="btn btn-primary login-partner">Access</button>
						      </div>
						    </div>

						  </div>
						</div> -->

						<!-- Modal accountbook list -->
 						<!-- <div id="accountbookList" class="modal fade" role="dialog">
 						  <div class="modal-dialog modal-sm"> -->

 						    <!-- Modal content-->
 						    <!-- <div class="modal-content">
 						      <div class="modal-header">
 						        <button type="button" class="close" data-dismiss="modal">&times;</button>
 						        <h4 class="modal-title">Accountbook list.</h4>
 						      </div>
 						      <div class="modal-body">&nbsp;</div>
 						      <div class="modal-footer">
 						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 						      </div>
 						    </div>

 						  </div>
 						</div> -->

 						<!-- modal capcha login -->
 						<!-- <div id="selectidcomp" class="modal fade" role="dialog">
 						  <div class="modal-dialog modal-sm"> -->

 						     <!-- Modal content-->
 						    <!-- <div class="modal-content">
 						      <div class="modal-header">
 						        <button type="button" class="close" data-dismiss="modal">&times;</button>
 						        <h4 class="modal-title">Accountbook list.</h4>
 						      </div>
 						      <div class="modal-body">&nbsp;</div>
 						      <div class="modal-footer">
 						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 						      </div>
 						    </div>

 						  </div>
 						</div> -->
					 <!-- End -->

					 <script language="javascript" type="text/javascript" src="/assets/js/jquery-min.1.9.1.js"></script>
					 <script language="javascript" type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>
	         <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
	         <script src='https://www.google.com/recaptcha/api.js'></script>
	         <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
	         <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js'></script>
           <script type="text/javascript">
					 	//custom script
						$(function() {
							form_handle();
						  // Initialize scaling
						  scaleCaptcha();
						  // changesubmit();

							$('#refresh').on('click', function(){
								$("[name=CompanyName]").val("");
								document.cookie = "comp_name=";
								alert("company ID - removed");
								location.reload();
							});

							M.toast({html: 'If you can not sign in, check your username or password, otherwise your company is not linked in the plan.'})
						});

						function form_handle(){
                 $('.touch').on('focus', function( ){
                    $('.uniq-login-bag').addClass('grey');
                 });
                 $('.touch').on('blur', function( ){
                     $('.uniq-login-bag').removeClass('grey');;
                 });
             };

						 // RESPONSIVE CAPTCHA
						function scaleCaptcha(elementWidth) {
						  // Width of the reCAPTCHA element, in pixels
						  var reCaptchaWidth = 304;
						  // Get the containing element's width
							var containerWidth = $('.c-container').width();

						  // Only scale the reCAPTCHA if it won't fit
						  // inside the container
						  if(reCaptchaWidth > containerWidth) {
						    // Calculate the scale
						    var captchaScale = containerWidth / reCaptchaWidth;
						    // Apply the transformation
						    $('.g-recaptcha').css({
						      'transform':'scale('+captchaScale+')'
						    });
						  }
						}

					//accountbook access list -------------------
					var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

					$(".login-partner").on("keypress", function(e){
						if(e.which == 13 || e.keyCode == 13){
							getAccountbook();
						}
					});

					$("button.login-partner").on("click", function(e){
							getAccountbook();
					});

					$('#partnerLogin').on('shown.bs.modal', function () {
					  $('[name=partner_user]').focus()
					})

					//customer login
					$("button[name=btn_login]").on("click", function(e){
							getAccountbook_();
					});

					// function getAccountbook(){
					// 	var username = $("#accessForm [name=partner_user]").val();
					// 	var password = Base64.encode($("#accessForm [name=partner_pass]").val());
					// 	$.ajax({
					// 		url: "http://api.uniq365.com/uniq/accountbook/list",
					// 		type: 'post',
					// 		dataType: 'json',
					// 		async: false,
					// 		data: { username : username, password: password },
					// 		success: function(result){
					// 			console.log(result);
					// 			if(result.error != undefined) {
					// 				$(".modal").modal("hide");

					// 				setTimeout(function(){
					// 					alert(result.error.text);
					// 					$("#partnerLogin").modal("show");
					// 				},300);
					// 			} else {
					// 				$("#partnerLogin").modal("hide");
					// 				$("#accountbookList .modal-body").html(generateList(result));
					// 				$("#accountbookList").modal({
					// 					backdrop: 'static',
  			// 						keyboard: false
					// 				});
					// 			}
					// 		},
					// 		complete: function(xhr,status) {  },
					// 		error: function(xhr,status,error) {
					// 			$(".modal").modal("hide");

					// 			setTimeout(function(){
					// 				alert("Invalid login!");
					// 				$("#partnerLogin").modal("show");
					// 			},300);
					// 		}
					// 	});
					// }

					function getAccountbook_(){
						var username = $('[name="user_name_entry_field"]').val();
						var password = Base64.encode($('[name="password"]').val());
						// var password = Base64.encode($("#accessForm [name=partner_pass]").val());
						$.ajax({
							url: "http://api.uniq365.com/uniq/getcompany/",
							type: 'post',
							dataType: 'json',
							async: false,
							data: { username : username, password: password },
							success: function(result){
								console.log(result);
								if(result.error != undefined) {
									alert(result.error.text);
								} else {
									$("#accountbookList .body").html(generateList(result));
									$("#accountbookList").show();
									$("#message_for_login").hide();
									$("[name=btn_login]").hide();
									// $("#accountbookList").modal({
									// 	backdrop: 'static',
  							// 		keyboard: false
									// });
								}
							},
							complete: function(xhr,status) {  },
							error: function(xhr,status,error) {
								alert("Invalid login!");
							}
						});
					}

					function generateList(data){
						var html = "<p>Accountbook undetected!</p>";

						if(data.length > 0){
							html = "<ul class='accountbook-list collection'>";
							for(var loop=0; loop<data.length; loop++){
								html = html + "<li class='collection-item'><button type='button' class='btn waves-effect waves-light form-control access-list-button' onclick='getAccount(this)' value='" + data[loop].id + "'>" + data[loop].name + "</button></li>";
							}

							html = html +  "</ul>";
						}

						return html;
					}

					function getAccount(elem){
						var companyId = $(elem).val();
						$("[name=CompanyName]").val(companyId);
						$("[name=loginform]").submit();
					}

					function setdb(ini){
						var t_companyid = $(ini).val();
						username = $('[name="user_name_entry_field"]').val();
						password = $('[name="password"]').val();
						$.ajax({
							url: "/access/setlogin.php",
							type:'post',
							dataType: 'json',
							data: {
								guna: 'add',
								comp_id: t_companyid,
								username: username,
								password: password
							},
					        success: function(response) {
					        	console.log(response);
					        	location.reload();
					        }
						});
					}

					function changesubmit(){
						var c_name = $('[name="CompanyName"]').val();
						$('[name=btn_login]').prop('type','button');
						$('[name="password"]').val();
						$('[name=btn_login]').on('click',function(){
							var u_name = $('[name="CompanyName"]').val();
							username = $('[name="user_name_entry_field"]').val();
							password = $('[name="password"]').val();
							if(u_name == ''){
								$.ajax({
									url: "http://api.uniq365.com/uniq/getcompany/",
									type: 'post',
									dataType: 'json',
									async: false,
									data: { username : username, password: password },
									success: function(result){
										if(!result.error) {
											console.log(result);
											$('#selectidcomp').modal('show');
											$("#selectidcomp .modal-body").html(listcompany(result));
										}
									},
									complete: function(xhr,status) {  },
									error: function(xhr,status,error) {

									}
								});
							}else{
								$.ajax({
									url: "/access/setlogin.php",
									type:'post',
									dataType: 'json',
									data: {
										guna: 'delete'
									},
							        success: function(response) {
							        	console.log(response);
							        	$('[name=loginform]').submit();
							        }
								});
							}

						});
						// $('[name=submitlogin]').on('click',function(){
						// 	$('[name="loginform"]').submit();
						// });
					}
        </script>
    </body>
</html>
