<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-03-20 12:30:21
         compiled from "/Applications/MAMP/htdocs/uniq-next/ci_module//html/views/page_header.html" */ ?>
<?php /*%%SmartyHeaderCode:4901873855ab08e5dba15f0-61805993%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eac598de13f651584da4f6152a7072e9d55f648c' => 
    array (
      0 => '/Applications/MAMP/htdocs/uniq-next/ci_module//html/views/page_header.html',
      1 => 1521313131,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4901873855ab08e5dba15f0-61805993',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'page_description' => 0,
    'button_add_new' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5ab08e5dc12f65_38000973',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ab08e5dc12f65_38000973')) {function content_5ab08e5dc12f65_38000973($_smarty_tpl) {?><!-- <div class="page-head white z-depth-1 hide-on-med-and-down"> -->
<div class="page-head blue darken-4 white-text z-depth-1 hide-on-med-and-down">
	<h3><span synlang="syncard-language"><span class="badge"><a href="#!" class="white-text dropdown-button" data-activates="account-options"><i class="material-icons">settings</i></a></span>&nbsp;</span></h3>
	<h4><span synlang="syncard-language"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</span></h4>
	<h5><span synlang="syncard-language">&nbsp;</span></h5>
	<?php if ($_smarty_tpl->tpl_vars['page_description']->value) {?><p><?php echo $_smarty_tpl->tpl_vars['page_description']->value;?>
</p><?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['button_add_new']->value)) {?>
		<!-- <div class="fixed-action-btn"> -->
			<?php echo HtmlInquiryActionsSmarty::inquiry_addnew_button(array(),$_smarty_tpl);?>

		<!-- </div> -->
	<?php }?>
</div>
<?php }} ?>
