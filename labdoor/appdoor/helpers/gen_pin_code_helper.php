<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 


if(! function_exists('func__gen_pin_code')) 
{ 
    function func__gen_pin_code($lenth = 6) 
    { 
        $pin=''; 
        
        for ($i = 0; $i<$lenth; $i++) 
        { 
            $pin .= mt_rand(0,9); 
        } 
        
        return $pin; 
    } 
} 

?>