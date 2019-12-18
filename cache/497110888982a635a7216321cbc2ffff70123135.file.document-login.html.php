<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 21:50:06
         compiled from "application/views/base/default/document-login.html" */ ?>
<?php /*%%SmartyHeaderCode:9151937565c5d971e135740-42276416%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '497110888982a635a7216321cbc2ffff70123135' => 
    array (
      0 => 'application/views/base/default/document-login.html',
      1 => 1535984152,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9151937565c5d971e135740-42276416',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/gif" sizes="16x16" href="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/doc/images/icon/favicon.gif">
    <title><?php echo (($tmp = @$_smarty_tpl->getVariable('page_title')->value)===null||$tmp==='' ? 'e-commerce - UD Istiqomah Furniture' : $tmp);?>
 | <?php echo (($tmp = @$_smarty_tpl->getVariable('site')->value['site_title'])===null||$tmp==='' ? '' : $tmp);?>
</title>
    <!-- themes style -->
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('THEMESPATH')->value;?>
" media="screen" />
    <?php echo $_smarty_tpl->getVariable('LOAD_STYLE')->value;?>

    <!-- other style -->
    <!-- load javascript -->
    <?php echo $_smarty_tpl->getVariable('LOAD_JAVASCRIPT')->value;?>

    <!-- end of javascript	-->
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('template_content')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            </div>
        </div>
    </section>
</body>
</html>