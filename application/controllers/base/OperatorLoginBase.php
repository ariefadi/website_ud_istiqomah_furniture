<?php

class ApplicationBase extends CI_Controller {

    // init base variable
    protected $portal_id;
    protected $com_portal;
    protected $com_user;

    public function __construct() {
        date_default_timezone_set("Asia/Jakarta");
        // load basic controller
        parent::__construct();
        // load app data
        $this->base_load_app();
        // view app data
        $this->base_view_app();
    }

    /*
     * Method pengolah base load
     * diperbolehkan untuk dioverride pada class anaknya
     */

    protected function base_load_app() {
        // load themes (themes default : default)
        $this->smarty->load_themes("default");
        //load styles
        $this->smarty->load_style("default/load-style.css");
        // load javascript
        $this->smarty->load_javascript("resource/themes/default/plugins/jquery/dist/jquery.min.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/bootstrap/dist/js/tether.min.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/bootstrap/dist/js/bootstrap.min.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/bootstrap-extension/js/bootstrap-extension.min.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/sidebar-nav/dist/sidebar-nav.min.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/js/jquery.slimscroll.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/js/waves.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/js/custom.min.js");
        $this->smarty->load_javascript("resource/themes/default/plugins/styleswitcher/jQuery.style.switcher.js");
    }

    /*
     * Method pengolah base view
     * diperbolehkan untuk dioverride pada class anaknya
     */

    protected function base_view_app() {
        $this->smarty->assign("config", $this->config);
        // display site title
        self::_display_site_title();
        // get session admin
        self::_get_session();
    }

    /*
     * Method layouting base document
     * diperbolehkan untuk dioverride pada class anaknya
     */

    protected function display($tmpl_name = 'base/default/document-login.html') {
        // set template
        $this->smarty->display($tmpl_name);
    }

    //
    // base private method here
    // prefix ( _ )
    // site title
    private function _display_site_title() {
        $this->portal_id = $this->config->item('portal_operator');
        // site data
        $this->com_portal = $this->m_site->get_site_data_by_id($this->portal_id);
        if (!empty($this->com_portal)) {
            $this->smarty->assign("site", $this->com_portal);
        }
    }

    // get session admin
    private function _get_session() {
        // session admin
        $this->com_user = $this->tsession->userdata('session_operator');
    }

}
