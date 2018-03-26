<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-03-20 12:41:48
         compiled from "/Applications/MAMP/htdocs/uniq-next/ci_module//html/views/header.html" */ ?>
<?php /*%%SmartyHeaderCode:14396631465ab08e52325653-52770943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05cc2de1646b8190e8f8b19f8b0d8b63b9debdb7' => 
    array (
      0 => '/Applications/MAMP/htdocs/uniq-next/ci_module//html/views/header.html',
      1 => 1521520908,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14396631465ab08e52325653-52770943',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5ab08e5253afa2_68501439',
  'variables' => 
  array (
    'title' => 0,
    'button_add_new' => 0,
    'apps' => 0,
    'app' => 0,
    'module' => 0,
    'lapp' => 0,
    'rapp' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ab08e5253afa2_68501439')) {function content_5ab08e5253afa2_68501439($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/Applications/MAMP/htdocs/uniq-next/ci//thirdparty/Smarty-3.1.21/ci/function.site_url.php';
?><div class="navbar hide-on-large-only">
	<nav class="blue darken-4 white-text nav-extended">
	  <div class="nav-wrapper">
	    <!-- <a href="#!" class="brand-logo"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a> -->
	    <a href="#!"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a>
	    <ul class="left">
				<li><a href="#" data-activates="slide-out" class="button-menu"><i class="material-icons">menu</i></a></li>
	    </ul>
	  </div>
	</nav>
</div>

<div class="fixed-action-btn hide-on-large-only">
<?php if (isset($_smarty_tpl->tpl_vars['button_add_new']->value)) {?>
		<?php echo HtmlInquiryActionsSmarty::inquiry_addnew_button_fixed(array(),$_smarty_tpl);?>

<?php }?>
</div>

<ul id="account-options" class="dropdown-content right">
  <li><?php echo form::anchor(array('uri'=>'admin/change_current_user_password.php','title'=>'<span synlang="syncard-language">Account</span>'),$_smarty_tpl);?>
</li>
  <li><?php echo form::anchor(array('uri'=>'admin/display_prefs.php','title'=>'<span synlang="syncard-language">Settings</span>'),$_smarty_tpl);?>
</li>
  <li class="divider"></li>
  <li><a href="<?php echo smarty_function_site_url(array('uri'=>'access/logout.php'),$_smarty_tpl);?>
"><span synlang="syncard-language">Logout</span></a></li>
</ul>

<ul id="account-options_side" class="dropdown-content right">
  <li><?php echo form::anchor(array('uri'=>'admin/change_current_user_password.php','title'=>'<span synlang="syncard-language">Account</span>'),$_smarty_tpl);?>
</li>
  <li><?php echo form::anchor(array('uri'=>'admin/display_prefs.php','title'=>'<span synlang="syncard-language">Settings</span>'),$_smarty_tpl);?>
</li>
  <li class="divider"></li>
  <li><a href="<?php echo smarty_function_site_url(array('uri'=>'access/logout.php'),$_smarty_tpl);?>
"><span synlang="syncard-language">Logout</span></a></li>
</ul>

<ul id="slide-out" class="side-nav fixed">
	<li>
		<div class="user-view">
			<div class="background">
				<img src="/assets/images/background.jpg">
			</div>
			<a href="#!user"><img class="circle" src="/assets/images/default-avatar.png"></a>
			<a href="#!name"><span class="white-text name">Welcome!</span></a>
			<a href="#!" class="dropdown-button email white-text" data-activates="account-options_side"><i class="material-icons right">arrow_drop_down</i><?php echo HtmlUserSmarty::user_login_fullname(array(),$_smarty_tpl);?>
</a>
		</div>
	</li>
	<?php $_smarty_tpl->tpl_vars["moduledisable"] = new Smarty_variable(0, null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['apps']->value)&&count($_smarty_tpl->tpl_vars['apps']->value)>0) {?>
	<?php  $_smarty_tpl->tpl_vars['app'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['app']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['apps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['app']->key => $_smarty_tpl->tpl_vars['app']->value) {
$_smarty_tpl->tpl_vars['app']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['app']->key;
?>
		<?php if (isset($_smarty_tpl->tpl_vars['app']->value->enabled)&&$_smarty_tpl->tpl_vars['app']->value->enabled!=1) {?>
			<?php $_smarty_tpl->tpl_vars['moduledisable'] = new Smarty_variable(1, null, 0);?>
		<?php } else { ?>
			<?php $_smarty_tpl->tpl_vars['moduledisable'] = new Smarty_variable(0, null, 0);?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['app']->value->id!='Dashboard') {?>
  <li class="no-padding">
		<?php if (isset($_smarty_tpl->tpl_vars['app']->value->modules)) {?>
		<ul class="collapsible collapsible-accordion">
			<li>
				<?php if ($_smarty_tpl->tpl_vars['app']->value->name!='Home') {?> <a class="collapsible-header waves-effect"><span synlang="syncard-language"><i class="material-icons left"><?php echo $_smarty_tpl->tpl_vars['app']->value->icon;?>
</i><?php echo $_smarty_tpl->tpl_vars['app']->value->name;?>
</span></a>
					<div class="collapsible-body">
						<ul class="collapsible collapsible-accordion">
							<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['app']->value->modules; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
?> <?php if (isset($_smarty_tpl->tpl_vars['module']->value->name)&&preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['module']->value->name, $tmp)>0) {?>
			        <li>
								<?php if ($_smarty_tpl->tpl_vars['module']->value->name!='Dashboard'&&$_smarty_tpl->tpl_vars['module']->value->name!='Mobile Accountant') {?> <a class="collapsible-header waves-effect"><i class="material-icons right">arrow_drop_down</i> <?php echo $_smarty_tpl->tpl_vars['module']->value->name;?>
 </a>
								<?php } else { ?> <?php echo FaPermissionSmarty::application_menu(array('module'=>$_smarty_tpl->tpl_vars['module']->value),$_smarty_tpl);?>
 <?php }?>
			          <div class="collapsible-body">
			            <ul>
										<?php if (isset($_smarty_tpl->tpl_vars['module']->value->lappfunctions)) {?>
											<?php  $_smarty_tpl->tpl_vars['lapp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lapp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['module']->value->lappfunctions; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lapp']->key => $_smarty_tpl->tpl_vars['lapp']->value) {
$_smarty_tpl->tpl_vars['lapp']->_loop = true;
?>
											<?php echo FaPermissionSmarty::application_link(array('app'=>$_smarty_tpl->tpl_vars['lapp']->value,'outer'=>'li'),$_smarty_tpl);?>

											<?php } ?>
										<?php }?>
										<?php if (isset($_smarty_tpl->tpl_vars['module']->value->rappfunctions)) {?>
											<?php  $_smarty_tpl->tpl_vars['rapp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rapp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['module']->value->rappfunctions; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rapp']->key => $_smarty_tpl->tpl_vars['rapp']->value) {
$_smarty_tpl->tpl_vars['rapp']->_loop = true;
?>
												<?php echo FaPermissionSmarty::application_link(array('app'=>$_smarty_tpl->tpl_vars['rapp']->value,'outer'=>'li'),$_smarty_tpl);?>

											<?php } ?>
										<?php }?>
			            </ul>
			          </div>
			        </li>
							<?php }?> <?php } ?>
			      </ul>
					</div>
				<?php } else { ?> <?php echo FaPermissionSmarty::application_link(array('app'=>$_smarty_tpl->tpl_vars['app']->value),$_smarty_tpl);?>
 <?php }?>
			</li>
		</ul>
		<?php }?>
	</li> <?php }?>
	<?php }
}?>
	<li class="divider"></li>
	<li><a href="#" class="collapsible-header waves-effect"><span synlang="syncard-language">Help</span></a></li>
	<li><a href="<?php echo smarty_function_site_url(array('uri'=>'access/logout.php'),$_smarty_tpl);?>
" class="collapsible-header waves-effect"><span synlang="syncard-language">Logout</span></a></li>
</ul>
<?php }} ?>
