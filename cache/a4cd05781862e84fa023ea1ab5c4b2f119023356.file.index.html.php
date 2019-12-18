<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 20:27:35
         compiled from "application/views/settings/permissions/index.html" */ ?>
<?php /*%%SmartyHeaderCode:4478077175c641b47817bc6-95129415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4cd05781862e84fa023ea1ab5c4b2f119023356' => 
    array (
      0 => 'application/views/settings/permissions/index.html',
      1 => 1548946807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4478077175c641b47817bc6-95129415',
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
      <li class="active"><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</li>
    </ol>
  </div>
</div>
<!-- Page heading end-->
<div class="row" id="app">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Data <?php echo $_smarty_tpl->getVariable('page_title')->value;?>

      </div>
      <div class="panel-search bg-default">
        <form class="form-horizontal" id="searchFormAdvanced" v-on:submit.prevent="searchAdvancedPost">
          <div class="form-group m-b-10 row">
            <div class="col-md-12">
              <label for="role_nm">Nama Role</label>
              <input type="text" v-model="search.role_nm" name="role_nm" class="form-control input-sm" placeholder="Nama Role">
            </div>
          </div>  
          <div v-show="showAdvancedSearch">
            <div class="form-group m-b-10 row">
              <div class="col-md-6">
                <label for="group_id">Groups</label>
                <select v-model="search.group_id" v-select="search.group_id" name="group_id" class="form-control select2" data-placeholder="Pilih Groups" style="width:100%">
                  <option value=""></option>
                  <option v-for="group in rs_group" :value="group.group_id" v-text="group.group_name"></option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="portal_id">Portal</label>
                <select v-model="search.portal_id" v-select="search.portal_id" name="portal_id" class="form-control select2" data-placeholder="Pilih Portal" style="width:100%">
                  <option value=""></option>
                  <option v-for="portal in rs_portal" :value="portal.portal_id" v-text="portal.portal_nm"></option>
                </select>
              </div>
            </div>
          </div>   
          <div class="form-group row m-b-10">
            <div class="text-left col-md-6">
              <h5 href="#"
              type="button" 
              class="text-info cursor-pointer" 
              v-on:click="toggleAdvanced">
              <span v-html="btn_toggle"></span>
            </h5>
          </div>   
          <div class="text-right col-md-6">
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
            <div class="progress-bar progress-bar-info active progress-bar-striped" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> Memuat data permissions . . . </div>
        </div>
        <div class="table-responsive">
          <table id="row-spacing" class="table table-borderless hover-table" style="min-width: 1029px;">
            <thead>
              <tr>
                <th width='10%' class="text-center">ID</th>
                <th width='20%' class="text-center">Group</th>
                <th width='20%' class="text-center">Role Name</th>
                <th width='25%' class="text-center">Role Description</th>
                <th width='15%' class="text-center">Default Page</th>
                <th width='10%' class="text-center"></th>
              </tr>
            </thead>
            <tbody>
                <tr v-show="rs_result" v-for="(result, index) in rs_result">
                  <td class="text-center" v-text="result.role_id"></td>
                  <td class="text-center" v-text="result.group_name"></td>
                  <td class="text-center" v-text="result.role_nm"></td>
                  <td v-text="result.role_desc"></td>
                  <td class="text-center"><code v-text="result.default_page"></code></td>
                  <td class="text-center">
                      <a :href="'<?php echo $_smarty_tpl->getVariable('config')->value->site_url("settings/permissions/access_update");?>
/'+result.role_id" data-toggle="tooltip" data-original-title="Edit">
                          <i class="fa fa-pencil text-info m-r-10"></i>
                      </a>
                  </td>
                </tr>
                <tr v-show="rs_result == ''">
                    <td colspan="7">Data tidak ditemukan!</td>
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
</div>
<!--body wrapper end-->
<script type="text/javascript">
  $(function () {
      $('[data-toggle="tooltip"]').tooltip();
      $("select").select2({
          allowClear: true
      });

      // velocity
      $(".modal").each(function(l){
          $(this).on("show.bs.modal",function(l){
              var o=$(this).attr("data-easein");
              "shake"==o?$(".modal-dialog").velocity("callout."+o):"pulse"==o?$(".modal-dialog").velocity("callout."+o):"tada"==o?$(".modal-dialog").velocity("callout."+o):"flash"==o?$(".modal-dialog").velocity("callout."+o):"bounce"==o?$(".modal-dialog").velocity("callout."+o):"swing"==o?$(".modal-dialog").velocity("callout."+o):$(".modal-dialog").velocity("transition."+o)
          })
      });
  });

  var http = axios.create({
    baseURL: "<?php echo $_smarty_tpl->getVariable('config')->value->site_url('settings/permissions');?>
"
  });

  Vue.component('paginate', VuejsPaginate);

  var vm = new Vue({
    el: "#app",
    data: {
      rs_group: <?php echo json_encode($_smarty_tpl->getVariable('rs_group')->value);?>
,
      rs_portal: <?php echo json_encode($_smarty_tpl->getVariable('rs_portal')->value);?>
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
      showAdvancedSearch: false,
      btn_toggle: '<b><i class="fa fa-plus"></i> Pencarian Lebih Detail</b>',
      CurrentPage:1
    },
    methods: {
      toggleAdvanced: function(){
        this.showAdvancedSearch = this.showAdvancedSearch ? false : true;
        this.btn_toggle = this.showAdvancedSearch ? '<b><i class="fa fa-times"></i> Sembunyikan Pencarian Detail</b>' : '<b><i class="fa fa-plus"></i> Pencarian Lebih Detail</b>';
      },
      showSearchModal: function(){
          $("#search-modal").modal('show');
      },  
      changePage: function(pageNum) {
        console.log(this.rs_result);
        var self = this;
        this.loading = true;
        self.setLoading = true;
        this.CurrentPage = pageNum;
  
        http.get('/get_data_permissions?page_num='+pageNum)
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
          this.rs_group = response.data.rs_group;
          this.rs_portal = response.data.rs_portal;
          this.pagination = response.data.pagination;
        })
        .catch(error => {
          this.loading = false;
          self.setLoading = false;
          console.error(error);
        });
      },
      searchAdvancedPost: function() {
        var self = this;
        this.loading = true;
        self.setLoading = true;
        let myForm = document.getElementById('searchFormAdvanced');
        let formData = new FormData(myForm);
  
        http.post('/search_process', formData)
        .then(response => {
          this.loading = false;
          self.setLoading = false;
  
          setTimeout(function () {
              $("#search-modal").modal('hide');
          });
  
          this.no = response.data.pagination.start;
          this.rs_result = response.data.result;
          this.search = response.data.search;
          this.rs_group = response.data.rs_group;
          this.rs_portal = response.data.rs_portal;
          this.pagination = response.data.pagination;
        })
        .catch(error => {
          this.loading = false;
          self.setLoading = false;
          console.error(error);
        });
      },
      resetSearch: function(modal) {
        var self = this;
        this.loading = true;
  
        http.post('/reset_search')
        .then(response => {
          this.loading = false;
          self.setLoading = false;

          if(modal){
              setTimeout(function () {
                  $("#search-modal").modal('hide');
              });
          }
  
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