<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 23:17:41
         compiled from "application/views/settings/portal/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1189247065c5daba5ba4a94-31035776%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcd012e445cb9a7103634c5bccbf13555c3e6da6' => 
    array (
      0 => 'application/views/settings/portal/index.html',
      1 => 1548937275,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1189247065c5daba5ba4a94-31035776',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="row bg-title">
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title hidden-xs"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</h4>
    <h4 class="page-title text-center visible-xs"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</h4>
  </div>
  <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 hidden-xs">
    <ol class="breadcrumb">
      <li><a href="#">Pengaturan</a></li>
      <li class="active">Web Portal</li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Web Portal
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/portal/add/');?>
" id="demo-btn-addrow" class="btn btn-sm btn-success">
            <i class="fa fa-plus"></i> 
            <span class="hidden-xs">Tambah</span>
          </a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <div class="table-responsive">
          <table id="row-spacing" class="table table-borderless hover-table" style="min-width: 1029px;">
            <thead>
              <tr>
                <th width='5%' class="text-center">ID</th>
                <th width='20%' class="text-left">Nama Portal</th>
                <th width='25%' class="text-left">Judul</th>
                <th width='35%' class="text-left">Deskripsi</th>
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
                <td><?php echo $_smarty_tpl->tpl_vars['result']->value['site_title'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['result']->value['site_desc'];?>
</td>
                <td class="text-center">
                  <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url(('settings/portal/edit/').($_smarty_tpl->tpl_vars['result']->value['portal_id']));?>
" class=""  data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fa fa-pencil text-info m-r-10"></i>
                  </a>
                  <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url(('settings/portal/delete/').($_smarty_tpl->tpl_vars['result']->value['portal_id']));?>
" class="" data-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="fa fa-times text-danger"></i>
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
<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
