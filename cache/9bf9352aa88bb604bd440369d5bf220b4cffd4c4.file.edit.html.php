<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 23:17:44
         compiled from "application/views/settings/portal/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:11940765435c5daba896b740-39995799%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9bf9352aa88bb604bd440369d5bf220b4cffd4c4' => 
    array (
      0 => 'application/views/settings/portal/edit.html',
      1 => 1548937804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11940765435c5daba896b740-39995799',
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
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/portal');?>
">Web Portal</a></li>
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
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/portal');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
          <input type="hidden" name="portal_id" :value="result.portal_id" />
          <input type="hidden" name="old_portal_alias" :value="result.portal_alias" />
          <input type="hidden" name="old_portal_session" :value="result.portal_session" />
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Nama Portal <br>
              <small class="form-text text-danger">Wajib diisi.</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.portal_nm" name="portal_nm" maxlength="50" placeholder="Nama Portal" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Judul Web <br>
              <small class="form-text text-danger">Wajib diisi.</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.site_title" name="site_title" maxlength="100" placeholder="Judul Web" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Deskripsi Web <br>
              <small class="form-text text-danger">Wajib diisi.</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.site_desc" name="site_desc" maxlength="100" placeholder="Deskripsi Web" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Meta Description <br>
              <small class="form-text text-danger">Wajib diisi.</small>
            </label>
            <div class="col-md-7">
              <textarea class="form-control input-sm" v-model="input.meta_desc" placeholder="Meta Description" name="meta_desc"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Meta Keyword <br>
              <small class="form-text text-danger">Wajib diisi.</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.meta_keyword" name="meta_keyword" maxlength="255" placeholder="Meta Keyword" class="form-control" />
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
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/portal');?>
"
});

  new Vue({
    el: "#app",
    data: {
      input:<?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
      result:<?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
      loading:false
    },
    methods: {
      editProcess: function () {
        var self = this;
        this.loading = true;
        console.log(this.input);
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
        });
      }
    }
  })
</script>
