<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(version_compare(PHP_VERSION, '5.3.7', '>=') && version_compare(PHP_VERSION, '5.5.0', '<'))
{
      require_once(APPPATH.'third_party'.DIRECTORY_SEPARATOR.'password_compat-1.0.4'.DIRECTORY_SEPARATOR.'password.php');
} 

?>