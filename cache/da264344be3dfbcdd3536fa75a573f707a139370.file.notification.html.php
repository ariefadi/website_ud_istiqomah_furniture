<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 21:50:13
         compiled from "application/views/base/templates/notification.html" */ ?>
<?php /*%%SmartyHeaderCode:15754430325c5d9725638104-57091184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da264344be3dfbcdd3536fa75a573f707a139370' => 
    array (
      0 => 'application/views/base/templates/notification.html',
      1 => 1548938248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15754430325c5d9725638104-57091184',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- notification template -->
<?php if ((($tmp = @$_smarty_tpl->getVariable('notification_header')->value)===null||$tmp==='' ? '' : $tmp)=="error"){?>
<div class="alert alert-warning fade in">
    <button type="button" class="close close-sm" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <h4>
        <i class="icon-ok-sign"></i>
        <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('notification_header')->value, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('notification_header')->value,SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('notification_header')->value));?>

    </h4>
    <p>
        <?php echo $_smarty_tpl->getVariable('notification_message')->value;?>

        <?php echo $_smarty_tpl->getVariable('notification_error')->value;?>

    </p>
</div>
<?php }elseif((($tmp = @$_smarty_tpl->getVariable('notification_header')->value)===null||$tmp==='' ? '' : $tmp)=="success"){?>
<div class="alert alert-success fade in">
    <button type="button" class="close close-sm" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <h4>
        <i class="icon-ok-sign"></i>
        <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('notification_header')->value, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('notification_header')->value,SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('notification_header')->value));?>

    </h4>
    <p>
        <?php echo $_smarty_tpl->getVariable('notification_message')->value;?>

        <?php echo $_smarty_tpl->getVariable('notification_error')->value;?>

    </p>
</div>
<?php }elseif((($tmp = @$_smarty_tpl->getVariable('notification_header')->value)===null||$tmp==='' ? '' : $tmp)=="info"){?>
<div class="alert alert-info fade in">
    <button type="button" class="close close-sm" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <h4>
        <i class="icon-ok-sign"></i>
        <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('notification_header')->value, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->getVariable('notification_header')->value,SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->getVariable('notification_header')->value));?>

    </h4>
    <p>
        <?php echo $_smarty_tpl->getVariable('notification_message')->value;?>

        <?php echo $_smarty_tpl->getVariable('notification_error')->value;?>

    </p>
</div>
<?php }elseif((($tmp = @$_smarty_tpl->getVariable('notification_header')->value)===null||$tmp==='' ? '' : $tmp)=="warning_error"){?>
<div class="alert alert-danger fade in">
    <button type="button" class="close close-sm" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <h4>
        <i class="icon-ok-sign"></i>
        WARNING
    </h4>
    <p>
        <?php echo $_smarty_tpl->getVariable('notification_message')->value;?>

        <?php echo $_smarty_tpl->getVariable('notification_error')->value;?>

    </p>
</div>
<?php }else{ ?>
<?php }?>
<!-- End of notification template -->
