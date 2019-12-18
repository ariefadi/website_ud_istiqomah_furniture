<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 20:08:42
         compiled from "application/views/settings/menu/index.html" */ ?>
<?php /*%%SmartyHeaderCode:9193529995c6416dab255f7-56367362%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48ba2f30f2c9bbbcf49b8cc1c2869fb5d7a5cd7e' => 
    array (
      0 => 'application/views/settings/menu/index.html',
      1 => 1548944029,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9193529995c6416dab255f7-56367362',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- Page heading start-->
<div class = "row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Navigation</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">Pengaturan Aplikasi</a></li>
            <li class="active">Navigation</li>
        </ol>
    </div>
</div>
<!-- Page heading end-->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Navigation
        </div>
        <div class="panel-body p-0">
          <!-- notification template -->
          <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
          <!-- end of notification template-->
          <div class="table-responsive">
            <table id="row-spacing" class="table table-borderless hover-table" style="min-width: 1029px;">
              <thead>
                <tr>
                  <th width='10%' class="text-center">ID</th>
                  <th width='25%' class="text-left">Nama Portal</th>
                  <th width='40%' class="text-left">Judul</th>
                  <th width='15%' class="text-center">Jumlah Menu</th>
                  <th width='15%' class="text-center"></th>
                </tr>
              </thead>
              <tbody>
                <?php  $_smarty_tpl->tpl_vars['result'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rs_id')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['result']->key => $_smarty_tpl->tpl_vars['result']->value){
?>
                <tr>
                  <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['result']->value['portal_id'];?>
</td>
                  <td><?php echo ((mb_detect_encoding($_smarty_tpl->tpl_vars['result']->value['portal_nm'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->tpl_vars['result']->value['portal_nm'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->tpl_vars['result']->value['portal_nm']));?>
</td>
                  <td><?php echo ((mb_detect_encoding($_smarty_tpl->tpl_vars['result']->value['site_title'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->tpl_vars['result']->value['site_title'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->tpl_vars['result']->value['site_title']));?>
</td>
                  <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['result']->value['total_menu'];?>
</td>
                  <td class="text-center">
                    <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url(('settings/menu/navigation/').($_smarty_tpl->tpl_vars['result']->value['portal_id']));?>
" class=""  data-toggle="tooltip" data-placement="top" title="Edit">
                      <i class="fa fa-pencil text-info m-r-10"></i>
                    </a>
                  </td>
                </tr>
                <?php }} else { ?>
                <tr>
                  <td colspan="5">Data tidak ditemukan!</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<!--body wrapper end-->
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
