<?php /* Smarty version Smarty-3.0.7, created on 2019-02-14 16:20:13
         compiled from "application/views/profil/visi_misi/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:14327231135c6532cdad6ad2-67876507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f5a1c71989ebc8a2d1d9a2a75f26cf80226e376' => 
    array (
      0 => 'application/views/profil/visi_misi/edit.html',
      1 => 1550135994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14327231135c6532cdad6ad2-67876507',
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
      <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/visi_misi');?>
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
        Edit Data Visi & Misi Perusahaan
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/visi_misi');?>
" class="btn btn-outline btn-default btn-sm"><i class="fa fa-angle-left"></i><span class="hidden-xs"> Kembali</span></a>
        </div>
      </div>
      <div class="panel-body">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <form class="form-horizontal" id="editForm" v-on:submit.prevent="editProcess">
          <input type="hidden" name="id_visi_misi" :value="result.id_visi_misi" />  
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Judul Visi Misi <br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.visi_misi_title" name="visi_misi_title" maxlength="100" class="form-control" placeholder="Judul Visi Misi" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Vision Mision Title <br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <input type="text" v-model="input.visi_misi_title_en" name="visi_misi_title_en" maxlength="100" class="form-control" placeholder="Vision Mision Title" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Deskripsi Visi<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <summernote name="visi_desc" :model="input.visi_desc" class="form-control" :value="input.visi_desc" :config="config" placeholder="Deskripsi Visi"></summernote>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Vision Description<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <summernote name="visi_desc_en" :model="input.visi_desc_en" class="form-control" :value="input.visi_desc_en" :config="config" placeholder="Vision Description"></summernote>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Deskripsi Misi<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <summernote name="misi_desc" :model="input.misi_desc" class="form-control" :value="input.misi_desc" :config="config" placeholder="Deskripsi Misi"></summernote>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Mission Description<br>
              <small class="form-text text-danger">Wajib diisi</small>
            </label>
            <div class="col-md-7">
              <summernote name="misi_desc_en" :model="input.misi_desc_en" class="form-control" :value="input.misi_desc_en" :config="config" placeholder="Mission Description"></summernote>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">
              Status Aktif
            </label>
            <div class="col-md-7">
              <div class="form-check">
                <label class="custom-control custom-radio">
                  <input name="active_st" class="custom-control-input" type="radio" v-model="input.active_st" value="1">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Aktif</span>
                </label>
                <label class="custom-control custom-radio">
                  <input name="active_st" class="custom-control-input" type="radio" v-model="input.active_st" value="0">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Tidak Aktif</span>
                </label>
              </div>
              <small class="form-text text-danger">Wajib diisi.</small>
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

// inisialisasi summernote
var summernoteComponent = {

    template: '<textarea :name="name"></textarea>',

    props: {
        model: {
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        config: {
            type: Object,
            default: {},
        },
    },

    mounted() {
        let vm = this;
        let config = this.config;

        config.callbacks = {

            onInit: function () {
                $(vm.$el).summernote("code", vm.model);
            },

            onChange: function () {
                vm.$emit('change', $(vm.$el).summernote('code'));
            },

            onBlur: function () {
                vm.$emit('change', $(vm.$el).summernote('code'));
            }
        };

        $(this.$el).summernote(config);

    },
}

var http = axios.create({
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/visi_misi');?>
"
});
var vm = new Vue({
  el: "#app",
  components: {
    summernote: summernoteComponent
  },
  data: {
    input:<?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    result:<?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
    loading: false,
    config: {
      height: 250,
      toolbar: [
        // [groupName, [list of button]]
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['fontsize', 'color']],
        ['para', ['paragraph']],
        ['insert', ['link','image', 'doc', 'video']], // image and doc are customized buttons
        ['misc', ['codeview']],
      ],
    }, 
  },
  mounted: function() {
    $('[data-toggle="tooltip"]').tooltip();
    $("select").select2({
      allowClear: true
    });
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
});
</script>
