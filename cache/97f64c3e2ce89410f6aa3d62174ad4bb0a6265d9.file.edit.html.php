<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 22:41:52
         compiled from "application/views/users/akun/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:11084045455c5da3406a7257-24954607%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97f64c3e2ce89410f6aa3d62174ad4bb0a6265d9' => 
    array (
      0 => 'application/views/users/akun/edit.html',
      1 => 1549640511,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11084045455c5da3406a7257-24954607',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="row bg-title">
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title hidden-xs"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</h4>
    <h5 class="page-title text-center visible-xs"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</h5>
  </div>
  <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 hidden-xs">
    <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('users/akun');?>
" id="demo-btn-addrow" class="btn btn-primary pull-right m-l-20 btn-outline waves-effect waves-light">
      <i class="fa fa-chevron-left"></i>
      <span class="hidden-xs">Kembali</span>
    </a>
    <ol class="breadcrumb">
      <li>
        <a href="#"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</a>
      </li>
      <li>
        <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('users/akun/');?>
">Akun</a>
      </li>
      <li class="active">Edit</li>
    </ol>
  </div>
</div>
<div id="app" class="row">
  <div class="col-md-12">
    <div class="white-box">
      <form id="editForm" enctype="multipart/form-data">
        <input type="hidden" name="user_id" :value="result.user_id">
        <input type="hidden" name="old_user_mail" :value="result.user_mail">
        <input type="hidden" name="old_nik" :value="result.nik">
        <form-wizard @on-complete="onComplete" color="#03a9f3" title="Pendataan Akun" subtitle="Formulir Isian Pendataan Akun" back-button-text="Sebelumnya"
        next-button-text="Selanjutnya" finish-button-text="Selesai">
        <transition name="fade">
          <div class="m-b-10 text-center" v-show="loading">
            <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/loading.gif" style="width:120px;height:120px" alt="loading...">
            <h3>Menyimpan Data Akun</h3>
            <span>Mohon menunggu beberapa waktu...</span>
          </div>
        </transition>
        <tab-content title="Identitas Personal" icon="ti-id-badge">
          <div class="panel panel-info">
            <div class="panel-heading">
              Identitas Personal Sesuai KTP
              <div class="pull-right hidden-xs">
                Step 1 of 3
              </div>
              <small class="form-text visible-xs">
                Step 2 of 3
              </small>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Nama Lengkap
                      <small class="form-text text-danger">Wajib diisi.</small>
                    </label>
                    <div class="col-md-8">
                      <input type="text" name="nama" v-model="input.nama" class="form-control input-sm" placeholder="Nama Lengkap" autofocus="" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">NIK (No KTP)
                      <small class="form-text text-danger">Wajib diisi.</small>
                    </label>
                    <div class="col-md-8">
                      <input type="text" name="nik" v-model="input.nik" placeholder="NIK" class="form-control input-sm" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Tempat Lahir
                      <small class="form-text text-danger">Wajib diisi.</small>
                    </label>
                    <div class="col-md-8">
                      <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" v-model="input.tempat_lahir" class="form-control input-sm" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Tanggal Lahir
                      <small class="form-text text-danger">Wajib diisi.</small>
                    </label>
                    <div id="demo-dp-component" class="col-md-8">
                      <div class="input-group date">
                        <date-picker
                        v-model="input.tanggal_lahir"
                        id="tanggal_lahir"
                        class="form-control input-sm"
                        :config="dateFormat"
                        placeholder="dd-mm-yyyy"
                        name="tanggal_lahir">
                      </date-picker>
                      <span class="input-group-addon"><i class="icon-calender"></i></span>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Jenis Kelamin
                    <small class="form-text text-danger">Wajib diisi.</small>
                  </label>
                  <div class="col-md-8">
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="custom-control custom-radio">
                            <input name="jenis_kelamin" class="custom-control-input" v-model="input.jenis_kelamin" type="radio" value="L" >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Laki - Laki</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="custom-control custom-radio">
                            <input name="jenis_kelamin" class="custom-control-input" v-model="input.jenis_kelamin" type="radio" value="P">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Perempuan</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Status Perkawinan
                    <small class="form-text text-danger">Wajib diisi.</small>
                  </label>
                  <div class="col-md-8">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="custom-control custom-radio">
                            <input name="status_perkawinan" class="custom-control-input" type="radio" v-model="input.status_perkawinan" value="kawin">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Kawin</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="custom-control custom-radio">
                            <input name="status_perkawinan" class="custom-control-input" type="radio" v-model="input.status_perkawinan" value="belum kawin">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Belum Kawin</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="custom-control custom-radio">
                            <input name="status_perkawinan" class="custom-control-input" type="radio" v-model="input.status_perkawinan" value="duda">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Duda</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="custom-control custom-radio">
                            <input name="status_perkawinan" class="custom-control-input" type="radio" v-model="input.status_perkawinan" value="janda">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Janda</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Alamat
                    <small class="form-text text-danger">Wajib Diisi.</small>
                  </label>
                  <div class="col-md-8">
                    <textarea name="alamat" class="form-control" placeholder="Alamat Lengkap" v-model="input.alamat"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label">RT/RW
                    <small class="form-text text-danger">Wajib Diisi.</small>
                  </label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <input type="text" class="form-control input-sm" name="rt" v-model="input.rt" placeholder="RT">
                      <input type="text" class="form-control input-sm" name="rw" v-model="input.rw" placeholder="RW">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Pekerjaan
                    <small class="form-text text-danger">Wajib Diisi.</small>
                  </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control input-sm" placeholder="Pekerjaan" name="pekerjaan" v-model="input.pekerjaan">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label">Telp/No Handphone</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control input-sm" placeholder="Nomor Telephone" name="telp" v-model="input.telp">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <hr>
                <div class="form-group row">
                  <label class="col-md-12 col-form-label">Foto Personal
                    <small class="form-text text-info">Format png/jpg, max size 2Mb</small>
                  </label>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <input type="file" name="personal_img" id="personal-img-file" class="form-control file-styled" />
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <img id="personal-img" class="img-thumbnail" :src="'<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
'+result.img_path+'/'+result.personal_img" alt="Personal" width="150px">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="Data Akun" icon="ti-book">
        <div class="panel panel-info">
          <div class="panel-heading">
            Data Akun User
            <div class="pull-right hidden-xs">
              Step 2 of 3
            </div>
            <small class="form-text visible-xs">
              Step 2 of 3
            </small>
          </div>
          <div class="panel-body">
            <div class="form-group row">
              <label class="col-md-3 col-form-label">E-mail</label>
              <div class="col-md-7">
                <input type="text" name="user_mail" placeholder="E-mail" v-model="input.user_mail" class="form-control input-sm" />
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Password</label>
              <div class="col-md-7">
                <input type="password" name="user_pass" placeholder="Password" class="form-control input-sm" />
                <small class="help-block text-danger">Wajib diisi.</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Status</label>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="custom-control custom-radio">
                        <input name="user_st" class="custom-control-input" v-model="input.user_st" type="radio" value="1" >
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Aktif</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="custom-control custom-radio">
                        <input name="user_st" class="custom-control-input" v-model="input.user_st" type="radio" value="0">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Tidak Aktif</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="Roles" icon="ti-user">
        <div class="panel panel-info">
          <div class="panel-heading">
            Pengaturan Hak Akses User
            <div class="pull-right hidden-xs">
              Step 3 of 3
            </div>
            <small class="form-text visible-xs">
              Step 3 of 3
            </small>
          </div>
          <div class="panel-body">
            <?php  $_smarty_tpl->tpl_vars['portal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rs_portal')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['portal']->key => $_smarty_tpl->tpl_vars['portal']->value){
?>
            <div class="form-group row">
              <label class="col-form-label col-sm-4 text-bold"><?php echo $_smarty_tpl->tpl_vars['portal']->value['portal_nm'];?>
</label>
              <div class="col-sm-8 row">
                <?php  $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['portal']->value['roles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['role']->key => $_smarty_tpl->tpl_vars['role']->value){
?>
                <div class="col-sm-6">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input name="roles[]" id="checkbox-<?php echo $_smarty_tpl->tpl_vars['role']->value['role_id'];?>
" class="form-check-input" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['role']->value['role_id'];?>
" <?php if (in_array($_smarty_tpl->tpl_vars['role']->value['role_id'],$_smarty_tpl->getVariable('user_roles')->value)){?>checked=""<?php }?>> <?php echo $_smarty_tpl->tpl_vars['role']->value['role_nm'];?>
 </label>
                    </div>
                  </div>
                  <?php }} ?>
                </div>
              </div>
              <hr class="mar-hr">
              <?php }} ?>
            </div>
          </div>
        </tab-content>
      </form-wizard>
    </form>
  </div>
</div>
</div>
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $("select").select2({
    allowClear: true
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#personal-img').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#personal-img-file").change(function(){
    readURL(this);
  });
});

var datePickerConfig = {
  format: "DD-MM-YYYY",
  language: 'id'
};
Vue.component('date-picker', VueBootstrapDatetimePicker.default);

var http = axios.create({
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('users/akun');?>
"
});

Vue.use(VueFormWizard)

new Vue({
  el: "#app",
  data: {
    dateFormat: {
      format: 'DD-MM-YYYY',
      showClear: true,
      showClose: true,
      locale:'id',
    },
    tanggal_lahir:"<?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['tanggal_lahir'])===null||$tmp==='' ? '' : $tmp);?>
",
    result:<?php echo json_encode($_smarty_tpl->getVariable('rs_result')->value);?>
,
    input:<?php echo json_encode($_smarty_tpl->getVariable('rs_result')->value);?>
,
    user_roles:<?php echo json_encode($_smarty_tpl->getVariable('user_roles')->value);?>
,
    rs_portal:<?php echo json_encode($_smarty_tpl->getVariable('rs_portal')->value);?>
,
    loading: false
  },
  methods: {
    setLoading: function (isLoading) {
      document.body.style.cursor =  isLoading ? 'wait' : 'default';
    },
    onComplete: function(){
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
