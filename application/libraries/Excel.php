<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  ======================================= 
 *  Author     : Web Preparations Team
 *  License    : Protected 
 *  Email      : admin@webpreparations.com 
 * 
 *  ======================================= 
 */

// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// echo APPPATH;
require_once __DIR__ . "../../third_party/PHPExcel/Classes/PHPExcel.php";

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}