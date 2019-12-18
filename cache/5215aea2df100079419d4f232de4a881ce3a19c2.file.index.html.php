<?php /* Smarty version Smarty-3.0.7, created on 2019-04-06 21:51:51
         compiled from "application/views/profil/struktur_organisasi/index.html" */ ?>
<?php /*%%SmartyHeaderCode:7981292805ca8bd071b3e63-30517175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5215aea2df100079419d4f232de4a881ce3a19c2' => 
    array (
      0 => 'application/views/profil/struktur_organisasi/index.html',
      1 => 1554562309,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7981292805ca8bd071b3e63-30517175',
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
      <li><a href="#">Profil Perusahaan</a></li>
      <li class="active"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</li>
    </ol>
  </div>
</div>
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Data Struktur Organisasi
        <div class="panel-btn">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/struktur_organisasi/add/');?>
" id="demo-btn-addrow" class="btn btn-sm btn-success">
            <i class="fa fa-plus"></i> <span class="hidden-xs">Tambah</span>
          </a>
        </div>
      </div>
      <div class="panel-search">
        <form class="form-horizontal" id="searchForm" v-on:submit.prevent="searchProcess">
          <div class="form-group m-b-10 row">
            <div class="col-md-12">
              <label for="kepengurusan_nama">Nama Struktur Organisasi</label>
              <input name="kepengurusan_nama" type="text" v-model="search.kepengurusan_nama" class="form-control input-sm" placeholder="Nama Struktur Organisasi" />
            </div>
          </div>  
          <div class="form-group m-b-10 row">
            <div class="text-right col-md-12">
              <button type="button" v-on:click.prevent="resetSearch" class="btn btn-danger">Reset</button>
              <button type="submit" name="search" value="cari" class="btn btn-success">
                <i class="ti-search" v-show="!loading"></i>
                <i class="fa fa-spinner fa-spin" v-show="loading"></i>
                Cari
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="panel-body p-0">
        <!-- notification template -->
        <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <!-- end of notification template-->
        <div class="progress progress-md m-b-0" v-show="loading">
            <div class="progress-bar progress-bar-info active progress-bar-striped" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> Memuat data groups . . . </div>
        </div>
        <div class="table-responsive">
          <table id="row-spacing" class="table table-borderless hover-table" style="min-width: 1029px;">
            <thead>
              <tr>
                <th width='5%' class="text-center">No</th>
                <th width='30%' class="text-center">Nama Struktur Organisasi</th>
                <th width='15%' class="text-center">Tahun Mulai</th>
                <th width='15%' class="text-center">Tahun Berakhir</th>
                <th width='25%' class="text-center">File Pendukung</th>
                <th width='10%' class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-show="rs_result" v-for="(result, index) in rs_result">
                <td class="text-center" v-text="(no + index)"></td>
                <td class="text-center">
                    <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("profil/struktur_organisasi/struktur");?>
/'+result.kepengurusan_id" v-text="result.kepengurusan_nama"></a>
                </td>
                <td class="text-center"><b v-text="result.kepengurusan_tahun_mulai"></b></td>
                <td class="text-center"><b v-text="result.kepengurusan_tahun_berakhir"></b></td>
                <td class="align-middle text-center">
                  <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("profil/struktur_organisasi/download");?>
/'+result.kepengurusan_id" v-text="result.lampiran_file"></a>
                </td>
                <td class="text-center">
                  <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("profil/struktur_organisasi/edit");?>
/'+result.kepengurusan_id" data-toggle="tooltip" data-original-title="Edit">
                    <i class="fa fa-pencil text-info m-r-10"></i>
                  </a>
                  <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("profil/struktur_organisasi/delete_process");?>
/'+result.kepengurusan_id" data-toggle="tooltip" data-original-title="Hapus" onclick="return confirm('Apakah anda yakin akan menghapus struktur organisasi ini ?');">
                    <i class="fa fa-times text-danger m-r-10"></i>
                  </a>
                  <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("profil/struktur_organisasi/struktur");?>
/'+result.kepengurusan_id" data-toggle="tooltip" data-original-title="Struktur Kepengurusan">
                    <i class="fa fa-sitemap text-success m-r-10"></i>
                  </a>
                </td>
              </tr>
              <tr v-show="rs_result == ''">
                <td colspan="5">Data tidak ditemukan!</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="panel-footer p-10">
          <div class="row">
            <div class="col-md-6">
              <ul class="pagination pagination-label">
                <li><span>Menampilkan <b v-text="pagination.start+' - '+pagination.end"></b> dari <b v-text="pagination.total"></b> Data</span></li>
              </ul>
            </div>
            <div class="col-md-6 text-right" v-show="pagination.data.page_count > 1">
              <paginate :page-count="pagination.data.page_count" :page-range="5" :margin-page="2" :click-handler="changePage" :first-button-text="'<<'" :prev-text="'<'" :next-text="'>'" :last-button-text="'>>'" :container-class="'pagination pagination-label'">
              </paginate>
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
var http = axios.create({
  baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/struktur_organisasi');?>
"
});

Vue.component('paginate', VuejsPaginate);

var vm = new Vue({
  el: "#app",
  data: {
    rs_result: <?php echo json_encode($_smarty_tpl->getVariable('rs_result')->value);?>
,
    no: <?php echo $_smarty_tpl->getVariable('no')->value;?>
,
    search: <?php echo json_encode($_smarty_tpl->getVariable('search')->value);?>
,
    pagination: <?php echo json_encode($_smarty_tpl->getVariable('pagination')->value);?>
,
    loading: false,
  },
  methods: {
    changePage: function(pageNum) {
      var self = this;
      this.loading = true;
      self.setLoading = true;
      this.CurrentPage = pageNum;

      http.get('/get_data_groups?page_num='+pageNum)
      .then(response => {
        this.loading = false;
        self.setLoading = false;
        this.no = response.data.pagination.start;
        this.rs_result = response.data.result;
        this.search = response.data.search;
        this.pagination = response.data.pagination;
      })
      .catch(error => {
        this.loading = false;
        console.error(error);
      });
    },
    searchProcess: function() {
      var self = this;
      this.loading = true;
      self.setLoading = true;
      let myForm = document.getElementById('searchForm');
      let formData = new FormData(myForm);

      http.post('/search_process', formData)
      .then(response => {
        this.loading = false;
        self.setLoading = false;
        this.no = response.data.pagination.start;
        this.rs_result = response.data.result;
        this.search = response.data.search;
        this.pagination = response.data.pagination;
      })
      .catch(error => {
        this.loading = false;
        self.setLoading = false;
        console.error(error);
      });
    },
    resetSearch: function() {
      var self = this;
      this.loading = true;

      http.post('/reset_search')
      .then(response => {
        this.loading = false;
        self.setLoading = false;

        this.no = response.data.pagination.start;
        this.rs_result = response.data.result;
        this.search = response.data.search;
        this.pagination = response.data.pagination;
      })
      .catch(error => {
        this.loading = false;
        console.error(error);
      });
    },
  }
});
</script>
