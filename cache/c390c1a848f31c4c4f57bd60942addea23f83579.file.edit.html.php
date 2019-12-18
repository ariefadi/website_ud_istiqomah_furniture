<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 22:26:37
         compiled from "application/views/settings/roles/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:18537818695c64372df15cf6-92681031%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c390c1a848f31c4c4f57bd60942addea23f83579' => 
    array (
      0 => 'application/views/settings/roles/edit.html',
      1 => 1548946617,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18537818695c64372df15cf6-92681031',
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
        <li><a href="#">Pengaturan Aplikasi</a></li>
        <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/roles');?>
"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</a></li>
        <li class="active">Edit</li>
    </ol>
  </div>
</div>
<!-- Page heading end-->
  <div class="row" id="app">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            Edit Data <?php echo $_smarty_tpl->getVariable('page_title')->value;?>

          <div class="panel-btn">
            <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/roles');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
          </div>
        </div>
        <div class="panel-body">
          <!-- notification template -->
          <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
          <!-- end of notification template-->
          <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
            <input type="hidden" name="role_id" v-model="result.role_id" :value="result.role_id">
            <input type="hidden" name="old_role_nm" v-model="result.old_role_nm" value="result.role_nm">
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Group</label>
              <div class="col-md-7">
                <select v-model="inputs.group_id" v-select="inputs.group_id" class="select2 form-control" name="group_id" data-placeholder="Pilih Group" style="width: 100%">
                  <option v-for="group in rs_group" :value="group.group_id" v-text="group.group_name"></option>
                </select>
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Role Name</label>
              <div class="col-md-7">
                <input type="text" name="role_nm" maxlength="100" v-model="inputs.role_nm" class="form-control" placeholder="Role Name" />
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Role Description</label>
              <div class="col-md-7">
                <input type="text" name="role_desc" maxlength="100" v-model="inputs.role_desc" class="form-control" placeholder="Role Description" />
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Default Page</label>
              <div class="col-md-7">
                <input type="text" name="default_page" maxlength="50" v-model="inputs.default_page" class="form-control" placeholder="Default Page"/>
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Portal</label>
              <div class="col-md-7">
                <select v-model="inputs.portal_id" v-select="inputs.portal_id" class="select2 form-control" name="portal_id" data-placeholder="Pilih Portal" style="width: 100%">
                  <option v-for="portal in rs_portal" :value="portal.portal_id" v-text="portal.portal_nm"></option>
                </select>
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="reset" class="btn btn-warning waves-effect waves-light m-t-10"><i class="fa fa-refresh"></i> Reset</button>
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
  </div>
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $("select").select2({
    allowClear: true
  });
});

var http = axios.create({
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/roles');?>
"
});

new Vue({
  el: '#app',
  data: {
    rs_group: <?php echo json_encode($_smarty_tpl->getVariable('rs_group')->value);?>
,
    rs_portal: <?php echo json_encode($_smarty_tpl->getVariable('rs_portal')->value);?>
,
    result:<?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    inputs: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    loading: false,
  },
  methods: {
    editProcess: function () {
      var self = this;
      this.loading = true;

      let myForm = document.getElementById('editForm');
      let formData = new FormData(myForm);

      http.post('/edit_process', formData)
      .then(response => {
        this.loading = false;
        self.sweetAlert(response.data);
      })
      .catch(error => {
        this.loading = false;
        console.error(error);
      })
    }
  }
});
</script>
