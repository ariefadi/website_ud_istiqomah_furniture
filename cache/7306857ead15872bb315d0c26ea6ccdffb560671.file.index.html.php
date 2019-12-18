<?php /* Smarty version Smarty-3.0.7, created on 2019-02-13 21:40:07
         compiled from "application/views/home/profil/index.html" */ ?>
<?php /*%%SmartyHeaderCode:9037387295c642c477d83a3-75373640%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7306857ead15872bb315d0c26ea6ccdffb560671' => 
    array (
      0 => 'application/views/home/profil/index.html',
      1 => 1550068806,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9037387295c642c477d83a3-75373640',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="row bg-title">
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">Profil</h4>
  </div>
  <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li class="active">Profil</li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-md-4 col-xs-12">
    <div class="white-box">
      <div class="user-bg"> 
        <img alt="user" src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/doc/images/bg-img/profile-menu.png" width="100%">
        <div class="overlay-box">
          <div class="user-content">
            <a href="javascript:void(0)"><img src="<?php echo $_smarty_tpl->getVariable('com_user')->value['personal_img'];?>
" class="thumb-lg img-circle" alt="img"></a>
            <h4 class="text-white"><?php echo $_smarty_tpl->getVariable('com_user')->value['nama'];?>
</h4>
            <h5 class="text-white"><?php echo $_smarty_tpl->getVariable('com_user')->value['user_mail'];?>
</h5> 
          </div>
        </div>
      </div>
      <div class="user-btm-box">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <i class="fa fa-credit-card fa-1x icon-fw"></i> <?php echo $_smarty_tpl->getVariable('com_user')->value['nik'];?>

          </li>
          <li class="list-group-item">
            <i class="fa fa-map-marker fa-1x icon-fw"></i> <?php echo $_smarty_tpl->getVariable('com_user')->value['alamat'];?>

          </li>
          <li class="list-group-item">
            <i class="fa fa-venus-mars fa-1x icon-fw"></i> <?php if ($_smarty_tpl->getVariable('com_user')->value['jenis_kelamin']=="L"){?> Laki-Laki<?php }else{ ?> Perempuan<?php }?>
          </li>
          <li class="list-group-item">
            <i class="fa fa-mobile fa-1x icon-fw"></i> <?php echo $_smarty_tpl->getVariable('com_user')->value['telp'];?>

          </li>
        </ul>
        <div class="col-md-12 text-center">
          <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/welcome/logout_process');?>
" class="btn btn-md btn-block btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-xs-12">
    <div class="white-box">
      <ul class="nav customtab nav-tabs" role="tablist">
        <li role="presentation" class="nav-item">
          <a href="#settings" class="nav-link active" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="true">
            <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Ubah Password</span>
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="settings" aria-expanded="true">
          <!-- notification template -->
          <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
          <!-- end of notification template-->
          <form class="form-horizontal form-material" action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('home/profil/update_user');?>
" method="post">
            <div class="form-group">
              <label class="col-form-label col-md-3">Password Lama</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="old_password" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-form-label col-md-3">Password Baru</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="new_password" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-form-label col-md-3">Konfirmasi Password Baru</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="new_password_confirm" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-form-label col-md-3"></label>
              <div class="col-md-6">
                <button type="submit" name="button" class="btn btn-sm btn-success">
                  <i class="fa fa-check"></i> Simpan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
