<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 22:38:13
         compiled from "application/views/settings/groups/add.html" */ ?>
<?php /*%%SmartyHeaderCode:1192237525c6439e59c7725-34641301%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdec5ad70138f23f002102a99f60fb87b7a4dc6b' => 
    array (
      0 => 'application/views/settings/groups/add.html',
      1 => 1549636277,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1192237525c6439e59c7725-34641301',
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
"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</a></li>
      <li class="active">Tambah</li>
    </ol>
  </div>
</div>
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Tambah Data
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
        <form class="form-horizontal" id="addForm" v-on:submit.prevent="addProcess">
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Nama Group<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.group_name" name="group_name" maxlength="50" class="form-control" placeholder="Nama Group" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Deskripsi Group<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.group_desc" name="group_desc" maxlength="100"  class="form-control" placeholder="Deskripsi Group" />
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
    input: {
      group_name: '',
      group_desc: '',
      portal_id: ''
    },
    loading: false,
  },
  methods:{
    addProcess: function () {
      var self = this;
      this.loading = true;

      let myForm = document.getElementById('addForm');
      let formData = new FormData(myForm);

      http.post('/add_process', formData)
      .then(response => {
        this.loading = false;

        if(response.data.status == 'success'){
          this.input.group_name = '';
          this.input.group_desc = '';
          this.input.portal_id = '';
        }

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
