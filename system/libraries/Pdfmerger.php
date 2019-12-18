<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once( BASEPATH.'plugins/pdfmerger/PDFMerger.php' );

class CI_Pdfmerger extends PDFMerger {

    function CI_Pdfmerger() {
        // tcpdf constructor
        parent::__construct();

    }
}
// END PDFMerger Class
