<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function assets_url() 
{
$ci =& get_instance();
return base_url().$ci->config->item('assets_path','assets');
}

function assets_path() 
{
$ci =& get_instance();
return $ci->config->item('assets_path','assets');
}

function temp_dir() 
{
$ci =& get_instance();
return $ci->config->item('temp_dir','assets');
}

function qrcodes_dir() 
{
$ci =& get_instance();
return $ci->config->item('qrcodes_dir','assets');
}

function qrcodes_path() 
{
return assets_path().temp_dir().qrcodes_dir();
}

function uploads_dir() 
{
$ci =& get_instance();
return $ci->config->item('uploads_dir','assets');
}

function uploads_path() 
{
return assets_path().uploads_dir();
}

function jquery_url() 
{
$ci =& get_instance();
return assets_url().$ci->config->item('jquery_path','assets');
}

function jquery_ui_url() 
{
$ci =& get_instance();
return assets_url().$ci->config->item('jquery_ui_path','assets');
}

function bootstrap_url() 
{
$ci =& get_instance();
return assets_url().$ci->config->item('bootstrap_path','assets');
}

function uikit_url() 
{
$ci =& get_instance();
return assets_url().$ci->config->item('uikit_path','assets');
}

function flatpickr_url() 
{
$ci =& get_instance();
return assets_url().$ci->config->item('flatpickr_path','assets');
} 

?>