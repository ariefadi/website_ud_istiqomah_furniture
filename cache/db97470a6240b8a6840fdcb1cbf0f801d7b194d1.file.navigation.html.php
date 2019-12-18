<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 20:17:51
         compiled from "application/views/settings/menu/navigation.html" */ ?>
<?php /*%%SmartyHeaderCode:5852141745c6418ff0061f2-64303278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db97470a6240b8a6840fdcb1cbf0f801d7b194d1' => 
    array (
      0 => 'application/views/settings/menu/navigation.html',
      1 => 1548944090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5852141745c6418ff0061f2-64303278',
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
            <li><a href="#">Navigation</a></li>
            <li class="active">List Navigation</li>
        </ol>
    </div>
</div>
<!-- Page heading end-->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            List Navigation
            <div class="panel-btn">
              <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url(('settings/menu/add/').($_smarty_tpl->getVariable('portal')->value['portal_id']));?>
" id="demo-btn-addrow" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i> <span class="hidden-xs">Tambah</span>
              </a>
              <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/menu');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
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
                  <th width='5%' class="text-center"></th>
                  <th width='40%' class="text-left">Judul Menu</th>
                  <th width='22%' class="text-left">Alamat</th>
                  <th width='10%' class="text-center">Digunakan</th>
                  <th width='10%' class="text-center">Ditampilkan</th>
                  <th width='10%' class="text-center"></th>
                </tr>
              </thead>
              <tbody>
                <?php echo (($tmp = @$_smarty_tpl->getVariable('html')->value)===null||$tmp==='' ? '<tr><td colspan="6">Data tidak ditemukan!</td></tr>' : $tmp);?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $(".select-2").select2();
})
</script>
