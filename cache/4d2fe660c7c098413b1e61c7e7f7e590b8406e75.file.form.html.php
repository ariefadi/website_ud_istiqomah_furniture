<?php /* Smarty version Smarty-3.0.7, created on 2019-02-08 21:50:06
         compiled from "application/views/login/operator/form.html" */ ?>
<?php /*%%SmartyHeaderCode:2973103265c5d971e19dbc4-61383150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d2fe660c7c098413b1e61c7e7f7e590b8406e75' => 
    array (
      0 => 'application/views/login/operator/form.html',
      1 => 1548856781,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2973103265c5d971e19dbc4-61383150',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ((($tmp = @$_smarty_tpl->getVariable('login_st')->value)===null||$tmp==='' ? '' : $tmp)=='error'){?>
    <form class="form-horizontal form-material" role="form" action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/operatorlogin/login_process');?>
" method="post">
        <a href="javascript:void(0)" class="text-center db">
            <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/logo.jpeg"style="width:250px; height:250px;" alt="Home" />
        </a>
        <div class="alert alert-warning">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <strong>Gagal masuk!</strong> mohon maaf, periksa lagi username dan password anda!
        </div>
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="username" type="text" required="" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="password" type="password" required="" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-5"><div class="form-group text-center"><?php echo (($tmp = @$_smarty_tpl->getVariable('captcha')->value['image'])===null||$tmp==='' ? '' : $tmp);?>
</div></div>
                <div class="col-md-7">
                    <div class="input-group mb-10">
                        <input class="form-control input-sm" type="text" placeholder="Captcha" name="captcha" required="required" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember_me" value="1">
                    <label for="checkbox-signup"> Remember me </label>
                </div>
                <a href="javascript:void(0)" id="to-recover" class="pull-right"><i class="fa fa-lock m-r-5"></i> Lupa password?</a>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
    </form>
<?php }elseif((($tmp = @$_smarty_tpl->getVariable('login_st')->value)===null||$tmp==='' ? '' : $tmp)=='locked'){?>
    <form class="form-horizontal form-material" role="form" action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/operatorlogin/login_process');?>
" method="post"> 
        <a href="javascript:void(0)" class="text-center db">
            <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/logo.jpeg" style="width:250px; height:250px;" alt="Home" />
        </a>  
        <div class="alert alert-warning">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <strong>Gagal masuk!</strong> mohon maaf, account anda telah dikunci!
        </div>
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="username" type="text" required="" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="password" type="password" required="" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-5"><div class="form-group text-center"><?php echo (($tmp = @$_smarty_tpl->getVariable('captcha')->value['image'])===null||$tmp==='' ? '' : $tmp);?>
</div></div>
                <div class="col-md-7">
                    <div class="input-group mb-10">
                        <input class="form-control input-sm" type="text" placeholder="Captcha" name="captcha" required="required" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember_me" value="1">
                    <label for="checkbox-signup"> Remember me </label>
                </div>
                <a href="javascript:void(0)" id="to-recover" class="pull-right"><i class="fa fa-lock m-r-5"></i> Lupa password?</a>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
    </form>
<?php }elseif((($tmp = @$_smarty_tpl->getVariable('login_st')->value)===null||$tmp==='' ? '' : $tmp)=='captcha'){?>
    <form class="form-horizontal form-material" role="form" action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/operatorlogin/login_process');?>
" method="post">
        <a href="javascript:void(0)" class="text-center db">
            <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/logo.jpeg" style="width:250px; height:250px;" alt="Home" />
        </a>
        <div class="alert alert-warning">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <strong>Gagal masuk!</strong> mohon maaf, kode capctha yang anda masukkan salah!
        </div>
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="username" type="text" required="" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="password" type="password" required="" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-5"><div class="form-group text-center"><?php echo (($tmp = @$_smarty_tpl->getVariable('captcha')->value['image'])===null||$tmp==='' ? '' : $tmp);?>
</div></div>
                <div class="col-md-7">
                    <div class="input-group mb-10">
                        <input class="form-control input-sm" type="text" placeholder="Captcha" name="captcha" required="required" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember_me" value="1">
                    <label for="checkbox-signup"> Remember me </label>
                </div>
                <a href="javascript:void(0)" id="to-recover" class="pull-right"><i class="fa fa-lock m-r-5"></i> Lupa password?</a>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
    </form>
<?php }elseif((($tmp = @$_smarty_tpl->getVariable('login_st')->value)===null||$tmp==='' ? '' : $tmp)=='reset_ok'){?>
    <form class="form-horizontal form-material" role="form" action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/operatorlogin/login_process');?>
" method="post">
        <a href="javascript:void(0)" class="text-center db">
            <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/logo.jpeg" style="width:250px; height:250px;" alt="Home" />
        </a>
        <div class="alert alert-success">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <strong>Berhasil!</strong> reset password berhasil, silahkan login menggunakan password baru!
        </div>
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="username" type="text" required="" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="password" type="password" required="" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-5"><div class="form-group text-center"><?php echo (($tmp = @$_smarty_tpl->getVariable('captcha')->value['image'])===null||$tmp==='' ? '' : $tmp);?>
</div></div>
                <div class="col-md-7">
                    <div class="input-group mb-10">
                        <input class="form-control input-sm" type="text" placeholder="Captcha" name="captcha" required="required" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember_me" value="1">
                    <label for="checkbox-signup"> Remember me </label>
                </div>
                <a href="javascript:void(0)" id="to-recover" class="pull-right"><i class="fa fa-lock m-r-5"></i> Lupa password?</a>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
    </form>
<?php }else{ ?>
    <form class="form-horizontal form-material" role="form" action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('login/operatorlogin/login_process');?>
" method="post">
        <a href="javascript:void(0)" class="text-center db">
            <img src="<?php echo $_smarty_tpl->getVariable('BASEURL')->value;?>
/resource/doc/images/logo.jpeg" style="width:250px; height:250px;" alt="Home" />
        </a>    
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="username" type="text" required="" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control input-sm" name="password" type="password" required="" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-5"><div class="form-group text-center"><?php echo (($tmp = @$_smarty_tpl->getVariable('captcha')->value['image'])===null||$tmp==='' ? '' : $tmp);?>
</div></div>
                <div class="col-md-7">
                    <div class="input-group mb-10">
                        <input class="form-control input-sm" type="text" placeholder="Captcha" name="captcha" required="required" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember_me" value="1">
                    <label for="checkbox-signup"> Remember me </label>
                </div>
                <a href="javascript:void(0)" id="to-recover" class="pull-right"><i class="fa fa-lock m-r-5"></i> Lupa password?</a>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
    </form>
<?php }?>
