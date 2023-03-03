<?php
require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf 
{
    public function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
        try{
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper($paper, $orientation);
            $dompdf->render();  
            $dompdf->stream($filename);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
