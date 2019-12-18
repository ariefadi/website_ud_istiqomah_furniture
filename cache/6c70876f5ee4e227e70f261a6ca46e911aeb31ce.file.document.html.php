<?php /* Smarty version Smarty-3.0.7, created on 2019-02-15 22:31:55
         compiled from "application/views/base/default/document.html" */ ?>
<?php /*%%SmartyHeaderCode:15578040295c66db6be22c00-39342959%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c70876f5ee4e227e70f261a6ca46e911aeb31ce' => 
    array (
      0 => 'application/views/base/default/document.html',
      1 => 1550244714,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15578040295c66db6be22c00-39342959',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html lang="en">
<!-- head -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/gif" sizes="16x16" href="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/doc/images/logo.jpeg">
  <title><?php echo (($tmp = @$_smarty_tpl->getVariable('page')->value['nav_title'])===null||$tmp==='' ? 'E-commerce - UD Istiqomah Furniture ' : $tmp);?>
</title>
  <!-- Core CSS -->
  <!-- <link href="../themes/default/load-style.css" rel="stylesheet"> -->
  <!-- themes style -->
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('THEMESPATH')->value;?>
" />
  <!-- other style -->
  <?php echo $_smarty_tpl->getVariable('LOAD_STYLE')->value;?>

  <!-- jQuery -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/bootstrap/dist/js/tether.min.js"></script>
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/bootstrap-extension/js/bootstrap-extension.min.js"></script>
  <!-- Menu Plugin JavaScript -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/sidebar-nav/dist/sidebar-nav.min.js"></script>
  <!--slimscroll JavaScript -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/js/jquery.slimscroll.js"></script>
  <!--Wave Effects -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/js/waves.js"></script>
  <!-- Custom Theme JavaScript -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/js/custom.min.js"></script>
  <!--Style Switcher -->
  <script src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/themes/default/plugins/styleswitcher/jQuery.style.switcher.js"></script>
  <?php echo $_smarty_tpl->getVariable('LOAD_JAVASCRIPT')->value;?>

</head>
<body>
  <!-- Preloader -->
  <div class="preloader">
    <div class="cssload-speeding-wheel"></div>
  </div>
  <div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
      <div class="navbar-header">
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
          <i class="ti-menu"></i>
        </a>
        <span class="mobile-logo hidden-sm hidden-md hidden-lg">
          <!-- <img src="" alt="E-commerce" class="dark-logo"/> -->
        </span>
        <div class="top-left-part">
          <a class="logo" href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url();?>
">
            <b class="hidden-xs">
              <!-- Logo Perusahaan -->
              <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/doc/images/logo.jpeg" alt="UD Istiqomah Furniture" class="dark-logo" style="width: 32px" />
            </b>
            <span class="hidden-xs">
              <!--Logo E-commerce-->
              <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
resource/doc/images/istiqomah.jpeg" alt="E-commerce" class="dark-logo" style="width: 100px" />
            </span>
          </a>
        </div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
          <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="ti-arrow-circle-right icon-arrow-left-circle"></i></a></li>
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
          <!-- /.dropdown -->
          <li class="dropdown">
            <a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/operatorlogin/logout_process');?>
"><i class="fa fa-power-off"></i> Logout</a>
          </li>
          <li class="m-r-10">

          </li>
        </ul>
        <!-- /.dropdown-tasks -->
      </div>
    </nav>
    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="user-profile">
          <div class="dropdown user-pro-body">
            <div><img src="<?php echo $_smarty_tpl->getVariable('com_user')->value['personal_img'];?>
" alt="user-img" class="img-circle"></div>
            <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_smarty_tpl->getVariable('com_user')->value['nama'];?>
<span class="caret"></span></a>
            <ul class="dropdown-menu animated flipInY">
              <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('home/profil/index');?>
"><i class="ti-user"></i> Profil</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/welcome/logout_process');?>
"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
          </div>
        </div>
        <ul class="nav" id="side-menu">
          <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('template_sidebar')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        </ul>
      </div>
    </div>
    <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
      <div class="container-fluid">
        <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('template_content')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
      </div>


      <!-- /.container-fluid -->
      <footer class="footer text-center"> 2018 &copy; E-commerce - UD Istiqomah Furniture </footer>
    </div>
  </div>
  <!-- load javascript -->
  <?php echo $_smarty_tpl->getVariable('LOAD_JAVASCRIPT')->value;?>

  <!-- end of javascript  -->
</body>
</html>
