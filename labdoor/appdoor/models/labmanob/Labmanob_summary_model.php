<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_summary_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }



    public function get_summary($input='') 
    { 
        $input = strtolower($input); 
        
        $summary_array = array(); 
        
        $summary_array['count_patients'] = $this->count_patients($input); 
        $summary_array['count_test_invoices'] = $this->count_test_invoices($input); 
        $summary_array['count_earnings'] = $this->count_earnings($input); 
        $summary_array['count_earnings_due_paid'] = $this->count_earnings_due_paid($input); 
        $summary_array['count_earnings_due'] = $this->count_earnings_due($input); 
        
        if (($input == 'total') || ($input == '')) 
        { 
            $summary_array['count_test_categories'] = $this->count_test_categories(); 
            $summary_array['count_tests'] = $this->count_tests(); 
        } 
        
        return $summary_array; 
    } 



    public function get_full_summary($input='') 
    { 
        $full_summary_array = array(); 
        
        $full_summary_array['total'] = $this->get_summary(); 
        $full_summary_array['today'] = $this->get_summary('today'); 
        $full_summary_array['lastday'] = $this->get_summary('lastday'); 
        
        return $full_summary_array; 
    } 



    public function count_patients($input='') 
    { 
        $input = strtolower($input); 
        
        
        if ($input == 'today') 
        { 
            $datetime_start = date('Y-m-d 00:00:00', now()); 
            $datetime_end = date('Y-m-d 23:59:59', now()); 
         } 
         else if ($input == 'lastday') 
         { 
             $date_input = date('Y-m-d', now()); 
             
             $datetime_start = date('Y-m-d 00:00:00', strtotime($date_input.' -1 day')); 
            $datetime_end = date('Y-m-d 23:59:59', strtotime($date_input.' -1 day')); 
        } 
        else 
        { 
            /** do nothing **/ 
        } 
        
        
        if (($input == 'today') || ($input == 'lastday')) 
        { 
            $this->db->where('created >=', $datetime_start); 
            $this->db->where('created <=', $datetime_end); 
        } 
        
        
        return $this->db->count_all_results('patients'); 
        
    } 



    public function count_test_invoices($input='') 
    { 
        $input = strtolower($input); 
        
        
        if ($input == 'today') 
        { 
            $datetime_start = date('Y-m-d 00:00:00', now()); 
            $datetime_end = date('Y-m-d 23:59:59', now()); 
         } 
         else if ($input == 'lastday') 
         { 
             $date_input = date('Y-m-d', now()); 
             
             $datetime_start = date('Y-m-d 00:00:00', strtotime($date_input.' -1 day')); 
            $datetime_end = date('Y-m-d 23:59:59', strtotime($date_input.' -1 day')); 
        } 
        else 
        { 
            /** do nothing **/ 
        } 
        
        
        if (($input == 'today') || ($input == 'lastday')) 
        { 
            $this->db->where('created >=', $datetime_start); 
            $this->db->where('created <=', $datetime_end); 
        } 
        
        
        return $this->db->count_all_results('test_invoices'); 
        
    } 



    public function count_test_categories() 
    { 
        return $this->db->count_all('test_categories'); 
        
    } 



    public function count_tests() 
    { 
        return $this->db->count_all('tests'); 
        
    } 



    public function count_earnings($input='') 
    { 
        $input = strtolower($input); 
        
        
        if ($input == 'today') 
        { 
            $datetime_start = date('Y-m-d 00:00:00', now()); 
            $datetime_end = date('Y-m-d 23:59:59', now()); 
         } 
         else if ($input == 'lastday') 
         { 
             $date_input = date('Y-m-d', now()); 
             
             $datetime_start = date('Y-m-d 00:00:00', strtotime($date_input.' -1 day')); 
            $datetime_end = date('Y-m-d 23:59:59', strtotime($date_input.' -1 day')); 
        } 
        else 
        { 
            /** do nothing **/ 
        } 
        
        
        if (($input == 'today') || ($input == 'lastday')) 
        { 
            $this->db->where('created >=', $datetime_start); 
            $this->db->where('created <=', $datetime_end); 
        } 
        
        
        $query = $this->db->get('test_invoices'); 
        
        $earnings = 0; 
        
        foreach ($query->result() as $result) 
        { 
            $earnings += $result->subtotal; 
        } 
        
        return $earnings; 
    } 



    public function count_earnings_full_paid($input='') 
    { 
        $input = strtolower($input); 
        
        
        if ($input == 'today') 
        { 
            $datetime_start = date('Y-m-d 00:00:00', now()); 
            $datetime_end = date('Y-m-d 23:59:59', now()); 
         } 
         else if ($input == 'lastday') 
         { 
             $date_input = date('Y-m-d', now()); 
             
             $datetime_start = date('Y-m-d 00:00:00', strtotime($date_input.' -1 day')); 
            $datetime_end = date('Y-m-d 23:59:59', strtotime($date_input.' -1 day')); 
        } 
        else 
        { 
            /** do nothing **/ 
        } 
        
        
        if (($input == 'today') || ($input == 'lastday')) 
        { 
            $this->db->where('created >=', $datetime_start); 
            $this->db->where('created <=', $datetime_end); 
        } 
        
        
        $this->db->where('is_full_paid', 1); 
        $query = $this->db->get('test_invoice_payments'); 
        
        $earnings_full_paid = 0; 
        
        foreach ($query->result() as $result) 
        { 
            
            $this->db->where('id', $result->test_invoice_id); 
            $query2 = $this->db->get('test_invoices'); 
            
            foreach ($query2->result() as $result2) 
            { 
                $earnings_full_paid += $result2->subtotal; 
            } 
            
        } 
        
        
        return $earnings_full_paid; 
    } 



    public function count_earnings_due_paid($input='') 
    { 
        $input = strtolower($input); 
        
        
        if ($input == 'today') 
        { 
            $datetime_start = date('Y-m-d 00:00:00', now()); 
            $datetime_end = date('Y-m-d 23:59:59', now()); 
         } 
         else if ($input == 'lastday') 
         { 
             $date_input = date('Y-m-d', now()); 
             
             $datetime_start = date('Y-m-d 00:00:00', strtotime($date_input.' -1 day')); 
            $datetime_end = date('Y-m-d 23:59:59', strtotime($date_input.' -1 day')); 
        } 
        else 
        { 
            /** do nothing **/ 
        } 
        
        
        if (($input == 'today') || ($input == 'lastday')) 
        { 
            $this->db->where('created >=', $datetime_start); 
            $this->db->where('created <=', $datetime_end); 
        } 
        
        
        $this->db->where('is_full_paid', 0); 
        $query = $this->db->get('test_invoice_payments'); 
        
        $due_amount_has_been_paid = 0; 
        
        foreach ($query->result() as $result) 
        { 
            $due_amount_has_been_paid += $result->paid_amount; 
        } 
        
        
        return $due_amount_has_been_paid; 
    } 



    public function count_earnings_total_paid($input='') 
    { 
        $input = strtolower($input); 
        
        $earnings_total_paid = ($this->count_earnings_full_paid($input) + $this->count_earnings_due_paid($input)); 
        
        return $earnings_total_paid; 
    } 



    public function count_earnings_due($input='') 
    { 
        $input = strtolower($input); 
        
        $earnings_due = ($this->count_earnings($input) - $this->count_earnings_total_paid($input)); 
        
        return $earnings_due; 
    } 



} 

?>