<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 22:22:32
         compiled from "application/views/settings/groups/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:9039121025c6436388bd170-35819358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70ba5421cefedde23dfe66d97803987993016ab3' => 
    array (
      0 => 'application/views/settings/groups/edit.html',
      1 => 1548921071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9039121025c6436388bd170-35819358',
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
      <li><a href="#">Pengaturan Aplikasi</a></li>
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/groups');?>
">Groups</a></li>
      <li class="active">Edit</li>
    </ol>
  </div>
</div>
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Edit Data
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/groups');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
          <input type="hidden" name="group_id" :value="result.group_id" />
          <input type="hidden" name="old_group_name" v-model="old_group_name" :value="result.group_name">
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Nama Group<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" name="group_name" maxlength="50" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['group_name'])===null||$tmp==='' ? '' : $tmp);?>
" class="form-control input-sm" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Deskripsi Group<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" name="group_desc" maxlength="100" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['group_desc'])===null||$tmp==='' ? '' : $tmp);?>
" class="form-control input-sm" />
            </div>
          </div>
          <div class="form-group row">
            <label for="portal_id" class="col-md-3 col-form-label">
              Portal<br>
              <small class="form-text text-danger">Wajib diisi.</small>
            </label>
            <div class="col-sm-9 col-md-7">
              <select v-model="input.portal_id" v-select="input.portal_id" name="portal_id" class="form-control select2" data-placeholder="Pilih Portal" style="width:100%">
                <option value=""></option>
                <option v-for="portal in rs_portal" :value="portal.portal_id" v-text="portal.portal_nm"></option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="text-right col-md-12">
              <button type="reset" class="btn btn-warning waves-effect waves-light m-t-10"><i class="fa fa-refresh"></i> Reset</button>
              <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">
                <i class="fa fa-check" v-show="!loading"></i>
                <i class="fa fa-spinner fa-spin" v-show="loading"></i>
                Simpan
              </button>
            </div>
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
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/groups');?>
"
});

var vm = new Vue({
  el: "#app",
  data: {
    rs_portal: <?php echo json_encode($_smarty_tpl->getVariable('rs_portal')->value);?>
,
    input: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    result: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    old_group_name: "<?php echo $_smarty_tpl->getVariable('result')->value['group_name'];?>
",
    loading: false,
  },
  methods:{
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