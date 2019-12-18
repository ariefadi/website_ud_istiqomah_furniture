<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 20:17:54
         compiled from "application/views/settings/menu/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:17432089315c641902672950-35336837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87fb930f4c9347e1c48d325560b73c3c94518ab6' => 
    array (
      0 => 'application/views/settings/menu/edit.html',
      1 => 1548944790,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17432089315c641902672950-35336837',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- Page heading start-->
<div class="row bg-title">
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">Navigation</h4>
  </div>
  <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <ol class="breadcrumb">
      <li><a href="#">Pengaturan Aplikasi</a></li>
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/menu');?>
">Navigation</a></li>
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url(('settings/menu/navigation/').($_smarty_tpl->getVariable('portal')->value['portal_id']));?>
">List Navigation</a></li>
      <li class="active">Edit</li>
    </ol>
  </div>
</div>
<!-- Page heading end-->
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Edit Data Navigation
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url(('settings/menu/navigation/').($_smarty_tpl->getVariable('portal')->value['portal_id']));?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
          <input type="hidden" name="portal_id" :value="portal.portal_id" />
          <input type="hidden" name="nav_id" :value="result.nav_id" />
          <input type="hidden" name="old_nav_title" :value="result.nav_title">
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Induk Menu</label>
            <div class="col-md-7">
              <select
                @change = "getListParent()"
                v-model="input.parent_id"
                v-select="input.parent_id"
                id="select-menu"
                name="parent_id"
                class="form-control select2"
                data-placeholder="Pilih menu induk"
                style="width:100%">
                <option value="0">*</option>
                <option v-for="rec in list_parent" :value="rec.nav_id" v-text="rec.nav_title"></option>
              </select>
              <small class="help-block text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Judul Menu</label>
            <div class="col-md-7">
              <input type="text" name="nav_title" maxlength="100" size="50" placeholder="Judul Menu" v-model="input.nav_title" class="form-control" />
              <small class="help-block text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Deskripsi</label>
            <div class="col-md-7">
              <input type="text" name="nav_desc" maxlength="255" size="70" placeholder="Deskripsi Menu" v-model="input.nav_desc" class="form-control" />
              <small class="help-block text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Alamat Menu</label>
            <div class="col-md-7">
              <input type="text" name="nav_url" maxlength="255" size="40" placeholder="Alamat Menu" v-model="input.nav_url" class="form-control" />
              <small class="help-block text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Urutan</label>
            <div class="col-md-7">
              <input type="text" name="nav_no" maxlength="5" size="5" placeholder="Urutan Menu" v-model="input.nav_no" class="form-control" />
              <small class="help-block text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Digunakan
            </label>
            <div class="col-md-7">
              <div class="form-check">
                <label class="custom-control custom-radio">
                  <input name="active_st" class="custom-control-input" type="radio" v-model="input.active_st" value="1">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Ya</span>
                </label>
                <label class="custom-control custom-radio">
                  <input name="active_st" class="custom-control-input" type="radio" v-model="input.active_st" value="0">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Tidak</span>
                </label>
              </div>
              <small class="form-text text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Ditampilkan
            </label>
            <div class="col-md-7">
              <div class="form-check">
                <label class="custom-control custom-radio">
                  <input name="display_st" class="custom-control-input" type="radio" v-model="input.display_st" value="1">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Ya</span>
                </label>
                <label class="custom-control custom-radio">
                  <input name="display_st" class="custom-control-input" type="radio" v-model="input.display_st" value="0">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Tidak</span>
                </label>
              </div>
              <small class="form-text text-danger">Wajib diisi.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Icon</label>
            <div class="col-md-6">
              <div class="input-group">
                <input type="text" name="nav_icon" placeholder="Navigasi Icon" maxlength="50" size="50" v-model="input.nav_icon" class="form-control" placeholder="Icon Class" />
              </div>
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
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/menu');?>
"
});

var vm = new Vue({
  el: "#app",
  data: {
    portal: <?php echo json_encode($_smarty_tpl->getVariable('portal')->value);?>
,
    input: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    result: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    list_parent: <?php echo json_encode($_smarty_tpl->getVariable('list_parent')->value);?>
,
    loading: false,
  },
  methods:{
    editProcess: function () {
      var self = this;
      this.loading = true;

      let myForm = document.getElementById('editForm');
      let formData = new FormData(myForm);

      http.post('/process_update', formData)
      .then(response => {
        this.loading = false;
        self.sweetAlert(response.data);
      })
      .catch(error => {
        this.loading = false;
        console.error(error);
      })
    },
    getListParent: function(){
      var self = this;
      this.loading = true;

      http.get('/get_list_parent?portal_id='+this.portal.portal_id)
      .then(response => {
        this.list_parent = response.data;
        setTimeout(function(){
          $("#select-menu").select2({ allowClear:true })
        })
        this.loading = false;
      })
      .catch(error => {
        this.loading = false;
        console.error(error);
      })
    }
  }
});
</script>
