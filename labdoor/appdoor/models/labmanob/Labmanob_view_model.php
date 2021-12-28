<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_view_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->helper(array('discount'));
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }



    public function patients($page=1, $results_per_page=10, $return_as_obj=TRUE) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('patients') : $this->db->get('patients', $results_per_page, $offset); 
        
        return ($return_as_obj) ? $query->result() : $query->result_array(); 
        
    } 



    public function patients_get_query($page=1, $results_per_page=10) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 

        $this->db->select('id AS Id, firstname AS Firstname, lastname AS Lastname, sex AS Sex, phone_no AS Mobile, email AS Email, current_address AS "Current Address", current_city AS "Current City", permanent_address AS "Permanent Address", permanent_city AS "Permanent City", extra_info AS "Additional Info", created AS Added, modified AS Modified');
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('patients') : $this->db->get('patients', $results_per_page, $offset); 
        
        return $query;
        
    } 



    public function count_patients() 
    { 
        return $this->db->count_all('patients'); 
        
    } 



    public function affiliate_partners($page=1, $results_per_page=10, $return_as_obj=TRUE) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('affiliate_partners') : $this->db->get('affiliate_partners', $results_per_page, $offset); 
        
        return ($return_as_obj) ? $query->result() : $query->result_array(); 
        
    } 



    public function affiliate_partners_get_query($page=1, $results_per_page=10) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 

        $this->db->select('id AS "Affiliate Partner ID", firstname AS First Name, lastname AS Last Name, sex AS Sex, phone_no AS "Mobile", email AS "Email", current_address AS "Current Address",  current_city AS "Current City", permanent_address AS "Permanent Address",  permanent_city AS "Permanent City", created AS Added');
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('affiliate_partners') : $this->db->get('affiliate_partners', $results_per_page, $offset); 
        
        return $query;
        
    } 



    public function count_affiliate_partners() 
    { 
        return $this->db->count_all('affiliate_partners'); 
        
    } 



    public function test_categories($page=1, $results_per_page=10, $return_as_obj=TRUE) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('test_categories') : $this->db->get('test_categories', $results_per_page, $offset); 
        
        return ($return_as_obj) ? $query->result() : $query->result_array(); 
        
    } 



    public function test_categories_get_query($page=1, $results_per_page=10) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 

        $this->db->select('test_categories.id AS "Test Category ID, test_categories.category_name AS "Test Category Name", test_categories.category_codename AS "Test Category Code Name", test_categories.category_description AS "Test Category Description", test_categories.created AS Added');
        
        $this->db->order_by('test_categories.id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('test_categories') : $this->db->get('test_categories', $results_per_page, $offset); 
        
        return $query; 
        
    } 



    public function count_test_categories() 
    { 
        return $this->db->count_all('test_categories'); 
        
    } 



    public function count_test_categories_by_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('id', $id); 
            return $this->db->count_all_results('test_categories'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    } 



    public function count_affiliate_partners_by_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('id', $id); 
            return $this->db->count_all_results('affiliate_partners'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    } 



    public function count_patients_by_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('id', $id); 
            return $this->db->count_all_results('patients'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    } 



    public function count_tests_by_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('id', $id); 
            return $this->db->count_all_results('tests'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    } 



    public function count_test_invoices_by_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('id', $id); 
            return $this->db->count_all_results('test_invoices'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    } 



    public function count_test_invoice_payments_from_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('test_invoice_id', $id); 
            return $this->db->count_all_results('test_invoice_payments'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    }



    public function count_test_invoice_logs_from_id($id=NULL) 
    { 
        
        if ($id !== NULL) 
        { 
            $this->db->where('test_invoice_id', $id); 
            return $this->db->count_all_results('test_invoice_logs'); 
        } 
        else 
        { 
            return 0; 
        } 
        
    }



    public function test_invoice_logs_by_test_invoice_id($id=NULL, $sort_input='DESC', $return_as_obj=TRUE) 
    { 
        
        if ($id !== NULL) 
        { 
            ($sort_input == 'ASC') ? $this->db->order_by('id', 'ASC') : $this->db->order_by('id', 'DESC'); 
            $this->db->where('test_invoice_id', $id); 
            $query = $this->db->get('test_invoice_logs'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        } 
        else 
        { 
            return FALSE; 
        } 
        
    } 



    public function tests($page=1, $results_per_page=10, $return_as_obj=TRUE) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('tests') : $this->db->get('tests', $results_per_page, $offset); 
        
        return ($return_as_obj) ? $query->result() : $query->result_array(); 
        
    }



    public function tests_joined_test_categories($page=1, $results_per_page=10, $return_as_obj=TRUE) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 

        $this->db->select('tests.id AS id, tests.test_name AS test_name, tests.test_codename AS test_codename, tests.test_category_id, test_categories.category_name AS test_category_name, test_categories.category_codename AS test_category_codename, tests.test_price AS test_price, tests.test_description AS test_description, tests.created AS created, tests.modified AS modified');
        $this->db->join('test_categories', 'tests.test_category_id = test_categories.id', 'left');
        
        $this->db->order_by('tests.id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('tests') : $this->db->get('tests', $results_per_page, $offset); 
        
        return ($return_as_obj) ? $query->result() : $query->result_array(); 
        
    }



    public function tests_joined_test_categories_get_query($page=1, $results_per_page=10) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 

        $this->db->select('tests.id AS "Test ID", tests.test_name AS "Test Name", tests.test_codename AS "Test Code Name", test_categories.category_codename AS "Test Category", tests.test_price AS "Test Price", tests.test_description AS "Test Description", tests.created AS Added, tests.modified AS Modified');
        $this->db->join('test_categories', 'tests.test_category_id = test_categories.id', 'left');
        
        $this->db->order_by('tests.id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('tests') : $this->db->get('tests', $results_per_page, $offset); 
        
        return $query;
        
    }
    
    

    public function test_invoices($page=1, $results_per_page=10, $return_as_obj=TRUE) 
    { 
        if ($page == 1) 
        { 
            $offset = 0; 
        } 
        else if ($page > 1) 
        { 
            $offset=($page * $results_per_page) - $results_per_page; 
        } 
        else 
        { 
            $offset = 0; 
        } 
        
        $this->db->order_by('id', 'DESC'); 
        $query = ($page === FALSE) ? $this->db->get('test_invoices') : $this->db->get('test_invoices', $results_per_page, $offset); 
        
        return ($return_as_obj) ? $query->result() : $query->result_array(); 
        
    }



    public function test($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->where('id', $id); 
            $query = $this->db->get('tests'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_joined_test_categories($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->select('tests.id AS id, tests.test_name AS test_name, tests.test_codename AS test_codename, tests.test_category_id, test_categories.category_name AS test_category_name, test_categories.category_codename AS test_category_codename, tests.test_price AS test_price, tests.test_description AS test_description, tests.created AS created, tests.modified AS modified');
            $this->db->join('test_categories', 'tests.test_category_id = test_categories.id');
            
            $this->db->where('tests.id', $id); 
            $query = $this->db->get('tests'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_category($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->where('id', $id); 
            $query = $this->db->get('test_categories'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function affiliate_partner($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->where('id', $id); 
            $query = $this->db->get('affiliate_partners'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_invoice($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->where('id', $id); 
            $query = $this->db->get('test_invoices'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_invoice_patient($patient_id=NULL, $return_as_obj=TRUE) 
    { 
        if(($patient_id === FALSE) || ($patient_id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $patient_id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->where('id', $patient_id); 
            $query = $this->db->get('patients'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_invoice_payment($test_invoice_id=NULL, $return_as_obj=TRUE) 
    { 
        if(($test_invoice_id === FALSE) || ($test_invoice_id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $test_invoice_id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->order_by('id', 'DESC'); 
            $this->db->where('test_invoice_id', $test_invoice_id); 
            $query = $this->db->get('test_invoice_payments'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_invoice_record($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        { 
            $this->db->where('id', $id); 
            $query = $this->db->get('test_invoice_records'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function test_invoice_records_by_test_invoice_id($id=NULL, $return_as_obj=TRUE) 
    { 
        if(($id === FALSE) || ($id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $id)))
        {
            return FALSE;
        }
        else
        { 
            $this->db->where('test_invoice_id', $id); 
            $query = $this->db->get('test_invoice_records'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function get_tests_name_by_id($test_id=NULL, $return_as_obj=TRUE) 
    { 
        if(($test_id === FALSE) || ($test_id === NULL) || (!preg_match('/^[1-9][0-9]*$/', $test_id)))
        {
            return FALSE;
        }
        else
        {
            $this->db->select('id, test_name');
            $this->db->where('id', $test_id); 
            $query = $this->db->get('tests'); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array(); 
        }
    }



    public function count_tests() 
    { 
        return $this->db->count_all('tests'); 
        
    } 



    public function count_test_invoices() 
    { 
        return $this->db->count_all('test_invoices'); 
        
    } 



    public function calc_discount($discount, $amount)
    {
        return func__discount__calc($discount, $amount);
    }



} 

?>