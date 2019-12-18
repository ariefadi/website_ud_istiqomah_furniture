<?php /* Smarty version Smarty-3.0.7, created on 2019-02-11 09:34:31
         compiled from "application/views/settings/permissions/access_update.html" */ ?>
<?php /*%%SmartyHeaderCode:3525200325c60df372709d1-87346461%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ff7007c11434495dcdfe14bf155d527d51c2336' => 
    array (
      0 => 'application/views/settings/permissions/access_update.html',
      1 => 1548947840,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3525200325c60df372709d1-87346461',
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
        <li>
          <a href="#"></a>Pengaturan Aplikasi</li>
          <li>
            <a href="#"></a><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</li>
            <li class="active"><?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['role_nm'])===null||$tmp==='' ? '' : $tmp);?>
</li>
          </ol>
        </div>
      </div>
      <!-- Page heading end-->
      <div class="row" id="app">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              Permissions From Administrator <?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['role_nm'])===null||$tmp==='' ? '' : $tmp);?>

              <div class="panel-btn">
                <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/permissions');?>
" class="btn btn-outline btn-default btn-sm">
                  <i class="fa fa-angle-left"></i> Kembali</a>
                </div>
                <h3 class="panel-title"></h3>
              </div>
              <div class="panel-search">
                <form class="form-horizontal" id="searchForm" v-on:submit.prevent="searchProcess">
                  <div class="form-group row">
                    <div class="col-md-6">
                      <div class="input-group">
                        <select name="portal_id" class="form-control select2" data-placeholder="Pilih Portal">
                          <option value=""></option>
                          <?php  $_smarty_tpl->tpl_vars['portal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rs_portal')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['portal']->key => $_smarty_tpl->tpl_vars['portal']->value){
?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['portal']->value['portal_id'];?>
" <?php if ((($tmp = @$_smarty_tpl->getVariable('search')->value['portal_id'])===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['portal']->value['portal_id']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['portal']->value['portal_id'];?>
 / <?php echo ((mb_detect_encoding($_smarty_tpl->tpl_vars['portal']->value['portal_nm'], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->tpl_vars['portal']->value['portal_nm'],SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->tpl_vars['portal']->value['portal_nm']));?>
</option>
                          <?php }} ?>
                        </select>
                        <span class="input-group-btn">
                          <button type="submit" name="search" value="cari" class="btn btn-default bootstrap-touchspin-up">
                            <i class="ti-search" v-show="!loading"></i>
                            <i class="fa fa-spinner fa-spin" v-show="loading"></i>
                          </button>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>
                </form>
              </div>
              <form class="form-horizontal" id="processForm" v-on:submit.prevent="permissionProcess">
                <div class="panel-body p-0">
                  <input type="hidden" name="portal_id" :value="default_portal_id" />
                  <input type="hidden" name="role_id" :value="result.role_id" />
                  <!-- notification template -->
                  <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                  <!-- end of notification template-->
                  <transition name="fade">
                    <div class="m-b-10 text-center" v-show="loading">
                      <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/loading.gif" style="width:120px;height:120px" alt="loading...">
                      <h3>Menampilkan Data Permissions Administrator</h3>
                      <span>Mohon menunggu beberapa waktu...</span>
                    </div>
                  </transition>
                  <div class="table-responsive">
                    <table id="row-spacing" class="table table-borderless hover-table" style="min-width: 1029px;">
                      <thead>
                        <tr>
                          <th width='5%' class="text-center">
                            <input type="checkbox" class="checked-all-menu" checked>
                          </th>
                          <th width='40%' class="text-left">Judul Menu</th>
                          <th width='15%' class="text-left">URL</th>
                          <th width='10%' class="text-center">Create</th>
                          <th width='10%' class="text-center">Read</th>
                          <th width='10%' class="text-center">Update</th>
                          <th width='10%' class="text-center">Delete</th>
                        </tr>
                      </thead>
                      <tbody v-html="list_menu">
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer text-right">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">
                    <i class="fa fa-check" v-show="!loading"></i>
                    <i class="fa fa-spinner fa-spin" v-show="loading"></i>
                    Simpan
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
          $(".checked-all").click(function() {
            var status = $(this).is(":checked");
            if (status === true) {
              $(".r" + $(this).val()).prop('checked', true);
            } else {
              $(".r" + $(this).val()).prop('checked', false);
            }
          });
          $(".checked-all-menu").click(function() {
            var status = $(this).is(":checked");
            if (status === true) {
              $(".r-menu").prop('checked', true);
            } else {
              $(".r-menu").prop('checked', false);
            }
          });
          $(".select2").select2({
            allowClear: true
          });
        });
  
        var http = axios.create({
          baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/permissions');?>
"
        });
  
        var vm = new Vue({
          el: "#app",
          data: {
            rs_portal: <?php echo json_encode($_smarty_tpl->getVariable('rs_portal')->value);?>
,
            result: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
            list_menu: <?php echo json_encode($_smarty_tpl->getVariable('list_menu')->value);?>
,
            default_portal_id:<?php echo $_smarty_tpl->getVariable('default_portal_id')->value;?>
,
            loading: false,
          },
          methods: {
            searchProcess: function() {
              var self = this;
              this.loading = true;
              self.setLoading = true;
              let myForm = document.getElementById('searchForm');
              let formData = new FormData(myForm);
  
              http.post('/filter_portal_process', formData)
              .then(response => {
                this.loading = false;
                self.setLoading = false;
                this.list_menu = response.data.list_menu;
                this.search = response.data.search;
              })
              .catch(error => {
                this.loading = false;
                self.setLoading = false;
                console.error(error);
              });
            },
            permissionProcess: function () {
              var self = this;
              this.loading = true;
  
              let myForm = document.getElementById('processForm');
              let formData = new FormData(myForm);
  
              http.post('/process', formData)
              .then(response => {
                this.loading = false;
                self.sweetAlert(response.data);
              })
              .catch(error => {
                this.loading = false;
                console.error(error);
              });
            }
          }
        });
        </script>
  