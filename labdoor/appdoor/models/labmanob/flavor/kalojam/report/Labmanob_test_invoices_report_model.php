<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_test_invoices_report_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->config('database');
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }


    public function count_test_invoices_report($test_invoice_id='', $patient_id='', $ref_by='', $affiliate_partner_id='', $begin_date='', $end_date='', $payment_status='all') 
    { 
        $payment_status = strtolower($payment_status);

        if ( (($test_invoice_id != '') && ($test_invoice_id != NULL)) || (($patient_id != '') && ($patient_id != NULL)) || (($ref_by != '') && ($ref_by != NULL)) || (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL)) || (($begin_date != '') && ($begin_date != NULL)) || (($end_date != '') && ($end_date != NULL)) || (($payment_status == 'full_paid') || ($payment_status == 'due') || ($payment_status == 'all')) )
        {
            $this->db->select('test_invoices.id, test_invoices.patient_id, test_invoices.ref_by, test_invoices.affiliate_partner_id, test_invoices.ctrl__status, test_invoices.created, test_invoice_payments.is_full_paid, test_invoice_payments.paid_amount');
            $this->db->join('test_invoice_payments', 'test_invoice_payments.test_invoice_id = test_invoices.id');

            $flag = 0;

            if (($test_invoice_id != '') && ($test_invoice_id != NULL))
            {
                $this->db->where('test_invoices.id', $test_invoice_id);
                $flag++;
            }

            if (($patient_id != '') && ($patient_id != NULL))
            {
                $this->db->where('test_invoices.patient_id', $patient_id);
                $flag++;
            }

            if (($ref_by != '') && ($ref_by != NULL))
            {
                $this->db->like('test_invoices.ref_by', $ref_by);
                $flag++;
            }

            if (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL))
            {
                $this->db->where('test_invoices.affiliate_partner_id', $affiliate_partner_id);
                $flag++;
            }

            if (($begin_date != '') && ($begin_date != NULL))
            {
                $begin_date = date('Y-m-d H:i:s', strtotime($begin_date));
                $this->db->where('test_invoices.created >=', $begin_date);
                $flag++;
            }

            if (($end_date != '') && ($end_date != NULL))
            {
                $end_date = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($end_date)));
                $this->db->where('test_invoices.created <', $end_date);
                $flag++;
            }

            if ($payment_status == 'full_paid')
            {
                $this->db->where('test_invoice_payments.is_full_paid', 1);
                $flag++;
            }
            else if ($payment_status == 'due')
            {
                $this->db->where('test_invoice_payments.is_full_paid', 0);
                $flag++;
            }
            else if($payment_status == 'all')
            {
                $flag++; //enables db to generate results for the "all" input
            }

            if($flag != 0)
            {
                return $this->db->count_all_results('test_invoices');
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }
        
    } 



    public function test_invoices_report($test_invoice_id='', $patient_id='', $ref_by='', $affiliate_partner_id='', $begin_date='', $end_date='', $payment_status='all', $page=1, $results_per_page=10, $return_as_obj=TRUE) 
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

        $payment_status = strtolower($payment_status);

        if ( (($test_invoice_id != '') && ($test_invoice_id != NULL)) || (($patient_id != '') && ($patient_id != NULL)) || (($ref_by != '') && ($ref_by != NULL)) || (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL)) || (($begin_date != '') && ($begin_date != NULL)) || (($end_date != '') && ($end_date != NULL)) || (($payment_status == 'full_paid') || ($payment_status == 'due') || ($payment_status == 'all')) )
        {
            if ($this->config->item('sql', 'db') == 'mysql')
            {
                $this->db->select('test_invoices.id, test_invoices.patient_id, CONCAT(patients.firstname, " ", patients.lastname) AS "patient_name", patients.current_address, patients.phone_no, test_invoices.affiliate_partner_id, CONCAT(affiliate_partners.firstname, " ", affiliate_partners.lastname) AS "affiliate_partner_name", test_invoices.total, test_invoices.discount, test_invoice_payments.paid_amount, test_invoices.discount_by, test_invoices.subtotal, test_invoices.created');
            }
            else
            {
                $this->db->select('test_invoices.id, test_invoices.patient_id, (patients.firstname || " " || patients.lastname) AS "patient_name", patients.current_address, patients.phone_no, test_invoices.affiliate_partner_id, (affiliate_partners.firstname || " " || affiliate_partners.lastname) AS "affiliate_partner_name", test_invoices.total, test_invoices.discount, test_invoice_payments.paid_amount, test_invoices.discount_by, test_invoices.subtotal, test_invoices.created');
            }

            $this->db->join('test_invoice_payments', 'test_invoice_payments.test_invoice_id = test_invoices.id');
            $this->db->join('patients', 'patients.id = test_invoices.patient_id');
            $this->db->join('affiliate_partners', 'affiliate_partners.id = test_invoices.affiliate_partner_id');

            $flag = 0;

            if (($test_invoice_id != '') && ($test_invoice_id != NULL))
            {
                $this->db->where('test_invoices.id', $test_invoice_id);
                $flag++;
            }
            
            if (($patient_id != '') && ($patient_id != NULL))
            {
                $this->db->where('test_invoices.patient_id', $patient_id);
                $flag++;
            }

            if (($ref_by != '') && ($ref_by != NULL))
            {
                $this->db->like('test_invoices.ref_by', $ref_by);
                $flag++;
            }

            if (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL))
            {
                $this->db->where('test_invoices.affiliate_partner_id', $affiliate_partner_id);
                $flag++;
            }

            if (($begin_date != '') && ($begin_date != NULL))
            {
                $begin_date = date('Y-m-d H:i:s', strtotime($begin_date));
                $this->db->where('test_invoices.created >=', $begin_date);
                $flag++;
            }

            if (($end_date != '') && ($end_date != NULL))
            {
                $end_date = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($end_date)));
                $this->db->where('test_invoices.created <', $end_date);
                $flag++;
            }

            if ($payment_status == 'full_paid')
            {
                $this->db->where('test_invoice_payments.is_full_paid', 1);
                $flag++;
            }
            else if ($payment_status == 'due')
            {
                $this->db->where('test_invoice_payments.is_full_paid', 0);
                $flag++;
            }
            else if($payment_status == 'all')
            {
                $flag++; //enables db to generate results for the "all" input
            }

            if($flag != 0)
            {
                $this->db->order_by('test_invoices.id', 'DESC'); 
                $query = $this->db->get('test_invoices', $results_per_page, $offset); 
                
                //return $query;
                return ($return_as_obj) ? $query->result() : $query->result_array();
            }
            else
            {
                //making sure no results are generated by giving a value that don't exists
            
                return FALSE;
            }
        }
        else
        {
            //making sure no results are generated by giving a value that don't exists
            
            return FALSE;
        } 
        
    } 
    
    
    
    public function test_invoices_report_get_query($test_invoice_id='', $patient_id='', $ref_by='', $affiliate_partner_id='', $begin_date='', $end_date='', $payment_status='all', $page=1, $results_per_page=10) 
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

        $payment_status = strtolower($payment_status);

        if ( (($test_invoice_id != '') && ($test_invoice_id != NULL)) || (($patient_id != '') && ($patient_id != NULL)) || (($ref_by != '') && ($ref_by != NULL)) || (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL)) || (($begin_date != '') && ($begin_date != NULL)) || (($end_date != '') && ($end_date != NULL)) || (($payment_status == 'full_paid') || ($payment_status == 'due') || ($payment_status == 'all')) )
        {
            if ($this->config->item('sql', 'db') == 'mysql')
            {
                $this->db->select('test_invoices.id AS "Test Invoice ID", test_invoices.patient_id AS "Patient ID", CONCAT(patients.firstname, " ", patients.lastname) AS "Patient Name", patients.current_address AS "Current Address", patients.phone_no AS "Mobile", test_invoices.affiliate_partner_id AS "Affiliate Partner ID", CONCAT(affiliate_partners.firstname, " ", affiliate_partners.lastname) AS "Affiliate Partner Name", test_invoices.total AS "Total", test_invoices.discount AS "Discount", test_invoice_payments.paid_amount AS "Paid Amount", test_invoices.discount_by AS "Discount By"');
            }
            else
            {
                $this->db->select('test_invoices.id AS "Test Invoice ID", test_invoices.patient_id AS "Patient ID", (patients.firstname || " " || patients.lastname) AS "Patient Name", patients.current_address AS "Current Address", patients.phone_no AS "Mobile", test_invoices.affiliate_partner_id AS "Affiliate Partner ID", (affiliate_partners.firstname || " " || affiliate_partners.lastname) AS "Affiliate Partner Name", test_invoices.total AS "Total", test_invoices.discount AS "Discount", test_invoice_payments.paid_amount AS "Paid Amount", test_invoices.discount_by AS "Discount By"');
            }

            $this->db->join('test_invoice_payments', 'test_invoice_payments.test_invoice_id = test_invoices.id');
            $this->db->join('patients', 'patients.id = test_invoices.patient_id');
            $this->db->join('affiliate_partners', 'affiliate_partners.id = test_invoices.affiliate_partner_id');

            $flag = 0;

            if (($test_invoice_id != '') && ($test_invoice_id != NULL))
            {
                $this->db->where('test_invoices.id', $test_invoice_id);
                $flag++;
            }
            
            if (($patient_id != '') && ($patient_id != NULL))
            {
                $this->db->where('test_invoices.patient_id', $patient_id);
                $flag++;
            }

            if (($ref_by != '') && ($ref_by != NULL))
            {
                $this->db->like('test_invoices.ref_by', $ref_by);
                $flag++;
            }

            if (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL))
            {
                $this->db->where('test_invoices.affiliate_partner_id', $affiliate_partner_id);
                $flag++;
            }

            if (($begin_date != '') && ($begin_date != NULL))
            {
                $begin_date = date('Y-m-d H:i:s', strtotime($begin_date));
                $this->db->where('test_invoices.created >=', $begin_date);
                $flag++;
            }

            if (($end_date != '') && ($end_date != NULL))
            {
                $end_date = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($end_date)));
                $this->db->where('test_invoices.created <', $end_date);
                $flag++;
            }

            if ($payment_status == 'full_paid')
            {
                $this->db->where('test_invoice_payments.is_full_paid', 1);
                $flag++;
            }
            else if ($payment_status == 'due')
            {
                $this->db->where('test_invoice_payments.is_full_paid', 0);
                $flag++;
            }
            else if($payment_status == 'all')
            {
                $flag++; //enables db to generate results for the "all" input
            }

            if($flag != 0)
            {
                $this->db->order_by('test_invoices.id', 'DESC'); 
                $query = $this->db->get('test_invoices', $results_per_page, $offset); 
                
                return $query;
                //return ($return_as_obj) ? $query->result() : $query->result_array();
            }
            else
            {
                //making sure no results are generated by giving a value that don't exists
            
                return FALSE;
            }
        }
        else
        {
            //making sure no results are generated by giving a value that don't exists
            
            return FALSE;
        } 
        
    }



} 

?>