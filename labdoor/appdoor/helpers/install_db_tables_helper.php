<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'users_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'login_attempts_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'affiliate_partners_sql.php');  
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'patients_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'test_categories_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'tests_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'test_invoices_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'test_invoice_records_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'test_invoice_payments_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'test_invoice_logs_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'files_sql.php'); 
require_once(APPPATH.'lmlib'.DIRECTORY_SEPARATOR.'lmtbl'.DIRECTORY_SEPARATOR.'image_files_records_sql.php'); 

$ci =& get_instance();
$ci->registry->db_tables = $db_tables; 

?>