<?php /* Smarty version Smarty-3.0.7, created on 2019-02-15 10:40:54
         compiled from "application/views/master/jabatan/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:7049655345c6634c621a074-49038848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1d4ad39efc7377037c31ecf766f2c32445fcf24' => 
    array (
      0 => 'application/views/master/jabatan/edit.html',
      1 => 1550202041,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7049655345c6634c621a074-49038848',
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
      <li><a href="#">Master Data</a></li>
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('master/jabatan');?>
"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</a></li>
      <li class="active">Edit</li>
    </ol>
  </div>
</div>
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Edit Data Jabatan Fungsional
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('master/jabatan');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i><span class="hidden-xs"> Kembali</span></a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
          <input type="hidden" name="jabatan_id" :value="result.jabatan_id" />
          <div class="form-group">
            <label class="col-md-3 col-form-label">
              Induk Jabatan<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <select v-model="input.parent_id" name="parent_id" class="form-control select2" data-placeholder="Pilih" style="width: 100%">
                <option value="0">*</option>
                <?php echo (($tmp = @$_smarty_tpl->getVariable('list_parent')->value)===null||$tmp==='' ? '' : $tmp);?>

              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Nama Jabatan<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.jabatan_nm" name="jabatan_nm" maxlength="100" class="form-control" placeholder="Nama Jabatan" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Group<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <div class="form-check">
                <label class="custom-control custom-radio">
                  <input name="grup" class="custom-control-input" type="radio" v-model="input.grup" value="pengurus">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Pengurus</span>
                </label>
                <label class="custom-control custom-radio">
                  <input name="grup" class="custom-control-input" type="radio" v-model="input.grup" value="penasihat">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Penasihat</span>
                </label>
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
</div>
<script type="text/javascript">

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $("select").select2({
    allowClear: true
  });
});  

var http = axios.create({
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('master/jabatan');?>
"
});

var vm = new Vue({
  el: "#app",
  data: {
    input: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    result: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
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
