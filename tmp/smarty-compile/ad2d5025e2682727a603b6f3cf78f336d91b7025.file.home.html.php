<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-03-20 12:30:10
         compiled from "/Applications/MAMP/htdocs/uniq-next/ci_module//dashboard/views/home.html" */ ?>
<?php /*%%SmartyHeaderCode:2730360685ab08e525b8527-28148869%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad2d5025e2682727a603b6f3cf78f336d91b7025' => 
    array (
      0 => '/Applications/MAMP/htdocs/uniq-next/ci_module//dashboard/views/home.html',
      1 => 1521306424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2730360685ab08e525b8527-28148869',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app' => 0,
    'b' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5ab08e526300f2_30121958',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ab08e526300f2_30121958')) {function content_5ab08e526300f2_30121958($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/Applications/MAMP/htdocs/uniq-next/ci//thirdparty/Smarty-3.1.21/ci/function.site_url.php';
?><!-- <div class="row"> -->
	 <!-- <div class="jumbotron">
	    <h1>WELCOME</h1>
    <p>to UNIQ365 Best cloud accounting ever.</p>
 	 </div> -->
 	 <!-- <h3 class="text-center"><span synlang="syncard-language">QUICK MENU</span></h3> -->
	<!-- <?php $_smarty_tpl->tpl_vars['b'] = new Smarty_variable(1, null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['app']->value)&&count($_smarty_tpl->tpl_vars['app']->value)>0) {
$_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['app']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['a']->key;
?> -->
	<!-- <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 menu-style" > -->

	<!-- <div class="col-lg-2 col-md-4 col-sm-6" style="margin: 40px 0;">
		<div class="menu-style">
			<div class="menu-number">
				<span class="menu-number-number"><b><?php echo $_smarty_tpl->tpl_vars['b']->value++;?>
</b></span>
			</div>

			<a class="portlet light homeblock" href="<?php echo smarty_function_site_url(array('uri'=>$_smarty_tpl->tpl_vars['a']->value[0]),$_smarty_tpl);?>
" > -->
				<!--  -->
				<!-- <span>
					<span class="home-icon" ><i class="fa fa-<?php echo $_smarty_tpl->tpl_vars['a']->value[3];?>
 fa-4x menu-icon"></i></span> -->
					<!-- <h4><?php echo $_smarty_tpl->tpl_vars['a']->value[1];?>
</h4> -->
					<!-- <h5 synlang="syncard-language"><?php echo $_smarty_tpl->tpl_vars['a']->value[1];?>
</h5>
					<span synlang="syncard-language"><?php echo $_smarty_tpl->tpl_vars['a']->value[2];?>
</span>
				</span>
			</a>
		</div>
	</div> -->
	<!-- <?php }
}?> -->
<!-- </div> -->

<?php $_smarty_tpl->tpl_vars['b'] = new Smarty_variable(1, null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['app']->value)&&count($_smarty_tpl->tpl_vars['app']->value)>0) {
$_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['app']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
<div class="col s12 m6 l4">
		<!-- <ul class="collection waves-effect col s12 white z-depth-1">
		    <li class="collection-item avatar">
		      <i class="material-icons circle orange"><?php echo $_smarty_tpl->tpl_vars['a']->value[3];?>
</i>
		      <p><span class="title syncard-language"><?php echo $_smarty_tpl->tpl_vars['a']->value[1];?>
</span></p>
					<p><span synlang="syncard-language"><?php echo $_smarty_tpl->tpl_vars['a']->value[2];?>
</span></p>
		    </li>
		</ul> -->
		<a href="<?php echo smarty_function_site_url(array('uri'=>$_smarty_tpl->tpl_vars['a']->value[0]),$_smarty_tpl);?>
" class="black-text">
		<div class="card home white col s12 waves-effect hoverable">
      <div class="card-content">
				<p><i class="material-icons medium orange-text"><?php echo $_smarty_tpl->tpl_vars['a']->value[3];?>
</i></p>
        <span class="card-title syncard-language"><?php echo $_smarty_tpl->tpl_vars['a']->value[1];?>
</span>
        <p><span synlang="syncard-language"><?php echo $_smarty_tpl->tpl_vars['a']->value[2];?>
</span></p>
      </div>
      <!-- <div class="card-action">
        <span synlang="syncard-language">Go</span>
      </div> -->
    </div>
		</a>
</div>
<?php }
}?>
<?php }} ?>
