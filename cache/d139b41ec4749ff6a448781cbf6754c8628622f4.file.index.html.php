<?php /* Smarty version Smarty-3.0.7, created on 2019-02-15 10:35:20
         compiled from "application/views/master/jabatan/index.html" */ ?>
<?php /*%%SmartyHeaderCode:15172353925c663378671771-36269812%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd139b41ec4749ff6a448781cbf6754c8628622f4' => 
    array (
      0 => 'application/views/master/jabatan/index.html',
      1 => 1550201719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15172353925c663378671771-36269812',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- Page heading start-->
<div class="row bg-title">
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</h4>
  </div>
  <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <ol class="breadcrumb">
      <li><a href="#">Master Data</a></li>
      <li class="active"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Data Jabatan Fungsional
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('master/jabatan/add/');?>
" id="demo-btn-addrow" class="btn btn-sm btn-success">
            <i class="fa fa-plus"></i> <span class="hidden-xs">Tambah</span>
          </a>
        </div>
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
                    <th width='40%' class="text-center">Nama Jabatan</th>
                    <th width='30%' class="text-center">Group</th>
                    <th width='30%' class="text-center">#</th>
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
