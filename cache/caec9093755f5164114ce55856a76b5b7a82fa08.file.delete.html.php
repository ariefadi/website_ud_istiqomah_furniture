<?php /* Smarty version Smarty-3.0.7, created on 2019-02-15 10:48:05
         compiled from "application/views/master/jabatan/delete.html" */ ?>
<?php /*%%SmartyHeaderCode:14498388505c663675b12335-63351954%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'caec9093755f5164114ce55856a76b5b7a82fa08' => 
    array (
      0 => 'application/views/master/jabatan/delete.html',
      1 => 1550202484,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14498388505c663675b12335-63351954',
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
      <li class="active">Hapus</li>
    </ol>
  </div>
</div>
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Hapus Data Jabatan Fungsional
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
        <form class="form-horizontal" id="deleteForm" v-on:submit.prevent="deleteProcess">
          <input type="hidden" name="jabatan_id" :value="result.jabatan_id" />
          <div class="form-group row">
            <label class="col-md-2 col-form-label">Induk Jabatan</label>
            <div class="col-md-7">
              <p class="form-control-static">: <?php echo (($tmp = @$_smarty_tpl->getVariable('parent')->value['jabatan_nm'])===null||$tmp==='' ? '* root' : $tmp);?>
</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label">Nama Jabatan</label>
            <div class="col-md-7">
              <p class="form-control-static" v-text="': '+result.jabatan_nm"></p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 col-form-label">Group</label>
            <div class="col-md-7">
              <p class="form-control-static">: <?php if ($_smarty_tpl->getVariable('result')->value['grup']=='pengurus'){?><b>PENGURUS</b><?php }else{ ?><b>PENASIHAT</b><?php }?></p>
            </div>
          </div>
          <div class="form-group row">
            <div class=" text-right col-md-3">
              <button type="submit" class="btn btn-danger waves-effect waves-light m-t-10">
                <i class="fa fa-trash" v-show="!loading"></i>
                <i class="fa fa-spinner fa-spin" v-show="loading"></i>
                Hapus
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
    $('[data-toggle="tooltip"]').tooltip()
  });
  var http = axios.create({
    baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('master/jabatan');?>
"
  });
  
  new Vue({
    el: "#app",
    data: {
      result: <?php echo json_encode($_smarty_tpl->getVariable('result')->value);?>
,
      loading: false
    },
    methods: {
      deleteProcess: function() {
        var self = this;
        this.loading = true;
  
        swal({
          title: "Yakin anda akan menghapus data ?",
          text: "Data akan dihapus secara permanen",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, hapus data",
          cancelButtonText: "Batalkan",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(){
          this.loading = true;
  
          let myForm = document.getElementById('deleteForm');
          let formData = new FormData(myForm);
  
          http.post('/delete_process', formData)
          .then(response => {
            this.loading = false;
            self.sweetAlert(response.data);
          })
          .catch(error => {
            this.loading = false;
            console.error(error);
          });
        });
        this.loading = false;
      }
    }
  })
</script>
