<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once( BASEPATH . 'plugins/simponi/SimponiBRIService.php' );

class CI_Simponi extends SimponiBRIService {
    //put your code here
    function CI_Simponi() {
        // simponi constructor
        parent::__construct();

    }
}
