<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 22:46:27
         compiled from "application/views/users/akun/index.html" */ ?>
<?php /*%%SmartyHeaderCode:12746497575c5da453bce9d5-07975124%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '360ec528c50bf4f2f80eda989d1e5401155ecbf8' => 
    array (
      0 => 'application/views/users/akun/index.html',
      1 => 1549640786,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12746497575c5da453bce9d5-07975124',
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
      <li><a href="#">Data Akun</a></li>
      <li class="active"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</li>
    </ol>
  </div>
</div>
<div class="row" id="app">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Data Akun
          <div class="panel-btn">
            <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('users/akun/add');?>
" id="demo-btn-addrow" class="btn btn-sm btn-success">
              <i class="fa fa-plus"></i> <span class="hidden-xs">Tambah</span>
            </a>
          </div>
        </div>
        <div class="panel-search">
          <form class="form-horizontal" id="searchForm" v-on:submit.prevent="searchPost">
            <div class="form-group m-b-10 row">
              <div class="col-md-12">
                <label for="username">Username</label>
                <input name="username" type="text" v-model="search.username" class="form-control input-sm" placeholder="Username" />
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
            <div class="progress-bar progress-bar-info active progress-bar-striped" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> Memuat data akun . . . </div>
        </div>
        <div class="table-responsive">
          <table id="row-spacing" class="table table-borderless hover-table" style="min-width: 1029px;">
            <thead>
              <tr>
                <th width='5%' class="text-center">No</th>
                <th width='25%' class="text-center">Nama Lengkap &amp; NIK</th>
                <th width='20%' class="text-center">Email</th>
                <th width='15%' class="text-center">Jumlah Role</th>
                <th width='10%' class="text-center">Status</th>
                <th width='10%' class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-show="rs_result" v-for="(result, index) in rs_result">
                <td class="text-center" v-text="(no + index)"></td>
                <td class="align-middle comment-center">
                  <div class="comment-body">
                    <div class="user-img">
                      <img :src="'<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
'+result.img_path+'/'+result.personal_img" alt="user" class="img-circle" style="width: 32px; height: 32px;" v-if="result.personal_img">
                      <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/placeholder-male.jpg" alt="user" class="img-circle" style="width: 32px; height: 32px;" v-if="!result.personal_img && result.jenis_kelamin == 'L'">
                      <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/placeholder-female.png" alt="user" class="img-circle" style="width: 32px; height: 32px;" v-if="!result.personal_img && result.jenis_kelamin == 'P'">
                    </div>
                    <div class="mail-contnet">
                      <h5 v-text="result.nama"></h5>
                      <span class="font-10" v-text="result.nik"></span>
                    </div>
                  </div>
                </td>
                <td v-text="result.user_mail"></td>
                <td class="text-center"><label class="label label-primary label-table" v-text="result.jml_role"></label></td>
                <td class="align-middle text-center">
                  <span class="label label-table label-rounded label-success" v-if="result.user_st == '1'">Aktif</span>
                  <span class="label label-table label-rounded label-danger" v-else>Tidak Aktif</span>
                </td>
                <td class="text-center">
                  <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("users/akun/edit");?>
/'+result.user_id" data-toggle="tooltip" data-original-title="Edit">
                      <i class="fa fa-pencil text-info m-r-10"></i>
                  </a>
                  <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("users/akun/delete");?>
/'+result.user_id" data-toggle="tooltip" data-original-title="Delete">
                      <i class="fa fa-times text-danger m-r-10"></i>
                  </a>
                </td>
              </tr>
              <tr v-show="rs_result == ''">
                <td colspan="6">Data tidak ditemukan!</td>
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
      $("select").select2({
          allowClear: true
      });
  });

  var http = axios.create({
    baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('users/akun');?>
"
  });

  Vue.component('paginate', VuejsPaginate);

  var vm = new Vue({
    el: "#app",
    data: {
      rs_role: <?php echo json_encode($_smarty_tpl->getVariable('rs_role')->value);?>
,
      rs_result: <?php echo json_encode($_smarty_tpl->getVariable('rs_result')->value);?>
,
      no: <?php echo $_smarty_tpl->getVariable('no')->value;?>
,
      search: <?php echo json_encode($_smarty_tpl->getVariable('search')->value);?>
,
      pagination: <?php echo json_encode($_smarty_tpl->getVariable('pagination')->value);?>
,
      loading: false,
      CurrentPage: 1,
    },
    methods: {
      changePage: function(pageNum) {
        console.log(this.rs_result);
        var self = this;
        this.loading = true;
        self.setLoading = true;
        this.CurrentPage = pageNum;

        http.get('/get_data_akun?page_num='+pageNum)
        .then(response => {
          console.log(response.data.pagination.start);
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
      searchPost: function() {
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
          this.rs_role = response.data.rs_role;
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
          this.rs_role = [];
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
