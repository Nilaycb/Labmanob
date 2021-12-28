<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 



if(! function_exists('func__discount__calc')) 
{ 
    function func__discount__calc($discount, $amount)
    {
        $discount_value = 0;

        if(!empty($discount))
        {
            if(func__discount__check_regex_pct_in_discount($discount) == TRUE)
            {
                $discount_value_array = explode("%", $discount);
                $discount_value = $amount * ($discount_value_array[0] / 100);
            }
            else
            {
                $discount_value = $discount;
            }
        }
        
        return $discount_value;
    }
} 



if(! function_exists('func__discount__check_regex_pct_in_discount')) 
{ 
    function func__discount__check_regex_pct_in_discount($discount)
	{
		if (empty($discount)) 
        { 
            return FALSE; 
        } 
        else 
        { 
            $discount_pattern='/^([-]?)(([0-9]+)([.])?)?([0-9]+)[%]$/'; 
            
            if(!preg_match($discount_pattern, $discount)) 
            { 
                return FALSE; 
            } 
            else 
            { 
                return TRUE; 
            } 
            
        }
        
    }
}



if(! function_exists('func__discount__check_regex')) 
{ 
    function func__discount__check_regex($discount)
	{
		if (empty($discount)) 
        { 
            return TRUE; 
        } 
        else 
        { 
	
			/**
			*
			* pattern supports with % (like 0.00) =		/^([-]?)(([0-9]+)([.])?)?([0-9]+)[%]?$/
			* pattern supports (like 0.08 or 0.050) and doesn't support (0.00) =		/^([-]?)(([0-9]+)([.])?)?(0*)([1-9]+)([0-9]*)[%]?$/
			*
			*/
			
            $discount_pattern='/^([-]?)(([0-9]+)([.])?)?([0-9]+)[%]?$/'; 
            
            if(!preg_match($discount_pattern, $discount)) 
            { 
                return FALSE; 
            } 
            else 
            { 
                return TRUE; 
            } 
            
        }
    }
} 

?>