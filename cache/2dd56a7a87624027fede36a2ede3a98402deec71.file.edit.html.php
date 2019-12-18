<?php /* Smarty version Smarty-3.0.7, created on 2019-04-06 21:25:58
         compiled from "application/views/profil/struktur_organisasi/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:19929748365ca8b6f6352da2-99791688%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2dd56a7a87624027fede36a2ede3a98402deec71' => 
    array (
      0 => 'application/views/profil/struktur_organisasi/edit.html',
      1 => 1554560751,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19929748365ca8b6f6352da2-99791688',
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
      <li><a href="#">Profil Perusahaan</a></li>
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/struktur_organisasi');?>
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
        Edit Data Struktur Organisasi
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/struktur_organisasi');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i><span class="hidden-xs"> Kembali</span></a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
          <input type="hidden" name="kepengurusan_id" :value="result.kepengurusan_id" class="form-control" />
          <input type="hidden" name="old_lampiran_path" :value="result.lampiran_path" class="form-control" />
          <input type="hidden" name="old_lampiran_file" :value="result.lampiran_file" class="form-control" />
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Nama Kepengurusan Organisasi <br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.kepengurusan_nama" name="kepengurusan_nama" maxlength="100" class="form-control" placeholder="Nama Kepengurusan Organisasi" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Tahun Mulai Kepengurusan <br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-2">
              <date-picker name="kepengurusan_tahun_mulai" v-model="input.kepengurusan_tahun_mulai" class="form-control input-sm" :config="startRange" @dp-change="onStartDatetimeChanged($event)" placeholder="yyyy"></date-picker>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Tahun Berakhir Kepengurusan<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-2">
              <date-picker name="kepengurusan_tahun_berakhir" v-model="input.kepengurusan_tahun_berakhir" class="form-control input-sm" :config="endRange" @dp-change="onEndDatetimeChanged($event)" placeholder="yyyy"></date-picker>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Dokumen Lampiran<br>
              <small class="form-text text-info">Boleh Kosong</small>
            </label>
            <div class="col-md-6">
                <input type="file" class="file-styled" @change="onFileChange" name="lampiran_file" accept=".pdf,.doc,.docx,.xls,.xlsx"/> <br>
                <span class="form-text text-info">
                    <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("profil/struktur_organisasi/download");?>
/'+result.kepengurusan_id" v-text="result.lampiran_file"></a>
                </span>
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

var http = axios.create({
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/struktur_organisasi');?>
"
});

var datePickerConfig = {
  format: "YYYY",
  language: 'id'
};

Vue.component('date-picker', VueBootstrapDatetimePicker.default);

var vm = new Vue({
  el: "#app",
  data: {
    startRange: {
      format: 'YYYY',
      showClear: true,
      showClose: true,
      locale:'id',
    },
    endRange: {
      format: 'YYYY',
      useCurrent: false,
      showClear: true,
      showClose: true,
      locale:'id',
    }, 
    result : <?php echo json_encode($_smarty_tpl->getVariable('rs_detail')->value);?>
,
    input : <?php echo json_encode($_smarty_tpl->getVariable('rs_detail')->value);?>
,
    input_lampiran: {
      lampiran_file:{
        name_file:'',
        type_file:'',
        size_file:''
      },
    },
    loading: false
  },
  mounted: function() {
    $('[data-toggle="tooltip"]').tooltip();
    $("select").select2({
      allowClear: true
    });
    $(".file-styled").uniform({
        fileButtonClass: 'action btn btn-default'
    });
  },
  methods:{
    onStartDatetimeChanged: function ($event) {
      this.$set(this.startRange, 'minDate', $event.date);
    },
    onEndDatetimeChanged: function ($event) {
      this.$set(this.endRange, 'maxDate', $event.date);
    },
    onFileChange: function(event){
      this.input.lampiran_file = event.target.files[0];
    },
    editProcess: function () {
      var self = this;
      this.loading = true;

      var lampiran_file = this.input_lampiran.lampiran_file;

      let myForm = document.getElementById('editForm');
      let formData = new FormData(myForm);
      formData.append('lampiran_file', lampiran_file);

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
