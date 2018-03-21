<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-03-20 18:17:12
         compiled from "/Applications/MAMP/htdocs/uniq-next/ci_module//report/views/form-reports.html" */ ?>
<?php /*%%SmartyHeaderCode:9143837315ab0dfa8288b56-08849243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b90666727b1b7ff9ea269730920a36399c1425d8' => 
    array (
      0 => '/Applications/MAMP/htdocs/uniq-next/ci_module//report/views/form-reports.html',
      1 => 1512640068,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9143837315ab0dfa8288b56-08849243',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'area_width' => 0,
    'fields' => 0,
    'field' => 0,
    'name' => 0,
    'submit' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5ab0dfa8385416_19264168',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ab0dfa8385416_19264168')) {function content_5ab0dfa8385416_19264168($_smarty_tpl) {?><div class="clearfix portlet light portlet-fit portlet-form" >
	<div class="form-body form-horizontal clearfix" >
		<div class="row justify-content-center">
		<?php if (!isset($_smarty_tpl->tpl_vars['area_width']->value)) {?>
		<?php $_smarty_tpl->tpl_vars['area_width'] = new Smarty_variable(8, null, 0);?>
		<?php }?>
		<div class="col-md-<?php echo $_smarty_tpl->tpl_vars['area_width']->value;?>
 col-12" >
		<?php if (isset($_smarty_tpl->tpl_vars['fields']->value)) {
$_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['field']->key;
?>

			<?php if ($_smarty_tpl->tpl_vars['field']->value['type']!='HIDDEN') {?>

				<?php echo form::formInputGroup(array('field'=>$_smarty_tpl->tpl_vars['field']->value,'name'=>$_smarty_tpl->tpl_vars['name']->value),$_smarty_tpl);?>


			<?php } else { ?>
				<?php echo form::formInput(array('type'=>$_smarty_tpl->tpl_vars['field']->value['type'],'name'=>$_smarty_tpl->tpl_vars['name']->value,'field'=>$_smarty_tpl->tpl_vars['field']->value),$_smarty_tpl);?>

			<?php }?>
			<?php } ?>
	<?php }?>
		</div>
		</div>
	</div>
	<?php if (isset($_smarty_tpl->tpl_vars['submit']->value)) {?>
	<div class="form-actions" >
		<?php echo HtmlInquiryActionsSmarty::page_button_back(array(),$_smarty_tpl);?>

		<?php  $_smarty_tpl->tpl_vars['title'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['title']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['submit']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['title']->key => $_smarty_tpl->tpl_vars['title']->value) {
$_smarty_tpl->tpl_vars['title']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['title']->key;
?>
			<?php if (is_array($_smarty_tpl->tpl_vars['title']->value)) {?>
				<?php echo form::submit_button(array('name'=>$_smarty_tpl->tpl_vars['name']->value,'title'=>$_smarty_tpl->tpl_vars['title']->value[0],'atype'=>$_smarty_tpl->tpl_vars['title']->value[1]),$_smarty_tpl);?>

			<?php } else { ?>
				<?php echo form::submit_button(array('name'=>$_smarty_tpl->tpl_vars['name']->value,'title'=>$_smarty_tpl->tpl_vars['title']->value,'atype'=>1),$_smarty_tpl);?>

			<?php }?>

		<?php } ?>
	</div>
	<?php }?>
</div><?php }} ?>
