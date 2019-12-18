<?php /* Smarty version Smarty-3.0.7, created on 2019-02-14 09:01:58
         compiled from "application/views/profil/tentang_perusahaan/index.html" */ ?>
<?php /*%%SmartyHeaderCode:10215921415c64cc16efeb03-60935468%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a4fb22a83f919f7d7a1f1cdbc410716ffa3d1b9' => 
    array (
      0 => 'application/views/profil/tentang_perusahaan/index.html',
      1 => 1550109717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10215921415c64cc16efeb03-60935468',
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
            <li class="active">Tentang Perusahaan</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Data Profil Perusahaan
            </div>
            <div class="panel-body">
                <!-- notification template -->
                <?php $_template = new Smarty_Internal_Template("base/templates/notification.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                <!-- end of notification template-->
                <form action="<?php echo $_smarty_tpl->getVariable('config')->value->site_url('profil/tentang_perusahaan/edit_process');?>
" class="form-horizontal" method="post">
                    <input type="hidden" name="data_id" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['data_id'])===null||$tmp==='' ? '' : $tmp);?>
" />
                    <div class="form-group">
                        <label for="isi" class="col-md-2 col-form-label">
                            Isi Profil Perusahaan <small class="form-text text-danger">Wajib diisi.</small>
                        </label>
                        <div class="col-md-10">
                            <textarea name="isi" id="data" class="form-control input-sm" rows="10" placeholder="Isi Profil Perusahaan"><?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['isi'])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="isi" class="col-md-2 col-form-label">
                            Content Inggris Profil Perusahaan <small class="form-text text-danger">Wajib diisi.</small>
                        </label>
                        <div class="col-md-10">
                            <textarea name="content" id="content" class="form-control input-sm" rows="10" placeholder="Content Inggris Profil Perusahaan"><?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['content'])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-md-2 col-form-label">
                            Status <small class="form-text text-danger">Wajib diisi.</small>
                        </label>
                        <div class="col-md-5">
                            <select name="status" class="form-control input-sm select-2" data-placeholder="Status">
                                <option value=""></option>
                                <option value="1" <?php if ((($tmp = @$_smarty_tpl->getVariable('result')->value['status'])===null||$tmp==='' ? '' : $tmp)=="1"){?>selected="selected"<?php }?>>Published</option>
                                <option value="0" <?php if ((($tmp = @$_smarty_tpl->getVariable('result')->value['status'])===null||$tmp==='' ? '' : $tmp)=="0"){?>selected="selected"<?php }?>>Hide</option>
                            </select>  
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-form-label">
                            Tanggal Update <small class="form-text text-danger">Wajib diisi.</small>
                        </label>
                        <div class="col-md-8">
                            <label class="form-control-static">
                                <u><i><?php echo $_smarty_tpl->getVariable('dtm')->value->get_full_date((($tmp = @$_smarty_tpl->getVariable('result')->value['tanggal'])===null||$tmp==='' ? '' : $tmp));?>
</i></u><br><b><?php echo (($tmp = @$_smarty_tpl->getVariable('result')->value['oleh'])===null||$tmp==='' ? '' : $tmp);?>
</b>
                            </label>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <div class="text-right col-md-12">
                            <button type="submit" name="save[insert]" value="Simpan" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan</button>
                            <button type="reset" name="save[reset]" value="Reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".select-2").select2({
            dropdownAutoWidth : true,
            width: '100%'
        });
        // wysiwyg 
        $('#data').summernote({
            height:300,
            minHeight: null,
            maxHeight: null,
            onpaste: function(content) {
                setTimeout(function () {
                    $('#data').code(content.target.textContent);
                }, 10);
            },
            cleaner:{
                    notTime: 2400, // Time to display Notifications.
                    action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                    newline: '<br>', // Summernote's default is to use '<p><br></p>'
                    notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                    icon: '<i class="note-icon">[Your Button]</i>',
                    keepHtml: false, // Remove all Html formats
                    keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], // If keepHtml is true, remove all tags except these
                    keepClasses: false, // Remove Classes
                    badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                    badAttributes: ['style', 'start'] // Remove attributes from remaining tags
            }
        });
        // wysiwyg 
        $('#content').summernote({
            height:300,
            minHeight: null,
            maxHeight: null,
            onpaste: function(content) {
                setTimeout(function () {
                    $('#content').code(content.target.textContent);
                }, 10);
            },
            cleaner:{
                    notTime: 2400, // Time to display Notifications.
                    action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                    newline: '<br>', // Summernote's default is to use '<p><br></p>'
                    notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                    icon: '<i class="note-icon">[Your Button]</i>',
                    keepHtml: false, // Remove all Html formats
                    keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], // If keepHtml is true, remove all tags except these
                    keepClasses: false, // Remove Classes
                    badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                    badAttributes: ['style', 'start'] // Remove attributes from remaining tags
            }
        });
    });
</script>