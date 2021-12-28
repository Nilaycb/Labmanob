<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_test_invoice_incomes_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }



    /*************************************** 
    ** @param $sum can be a specific field value or an array
    ** for SUM rename facility a multidimensional array is required
    **  Example: array(
    **              array(
    **                'as' => 'q',
    **                'field' => 'quantity'
    **              ),
    **            )
    ** Key "as" and "field" are fixed and both must be set (Case-insensitive)
    ** values for both keys are case-sensitive
    ***********
    ***********
    ** for ORDER BY facility a multidimensional array is required
    ** Similar to SUM rename facility to some extent
    **  Example: array(
    **              array(
    **                'order_by' => 'DESC', //See Codeigniter Docs for the value field
    **                'field' => 'quantity'
    **              ),
    **            )
    ** Key "order_by" and "field" are fixed and both must be set (Case-insensitive)
    ** values for both keys are case-sensitive
    ***********
    ***********
    ** @param $group_by can be an array or a specific field value
    ***************************************/
    public function test_invoices_sum_group_by_from_flavor_kalojam_report_test_invoice_incomes_joined_payments($test_invoice_id='', $patient_id='', $ref_by='', $begin_date='', $end_date='', $payment_status='all', $sum=array(), $group_by=array(), $order_by=array(), $page=1, $results_per_page=10, $return_as_obj=TRUE) 
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

        if ( (($test_invoice_id != '') && ($test_invoice_id != NULL)) || (($patient_id != '') && ($patient_id != NULL)) || (($ref_by != '') && ($ref_by != NULL)) || (($begin_date != '') && ($begin_date != NULL)) || (($end_date != '') && ($end_date != NULL)) || (($payment_status == 'full_paid') || ($payment_status == 'due') || ($payment_status == 'all')) )
        {
            $this->db->select('test_invoices.id, test_invoices.patient_id, test_invoices.ref_by, test_invoices.total, test_invoices.discount, test_invoices.subtotal, test_invoices.ctrl__status, DATE(test_invoices.created) as Created_date, test_invoice_payments.is_full_paid, test_invoice_payments.paid_amount');
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
                if (!empty($group_by))
                {
                    $this->db->group_by($group_by);
                }


                if(!is_array($sum) && !empty($sum))
                {
                    $this->db->select_sum($sum);
                }
                else if(!empty($sum))
                {
                    array_filter($sum, function($sum) {
                        $sum = (is_array($sum)) ? array_change_key_case($sum) : $sum;
                        if(is_array($sum) && array_key_exists('as', $sum) && array_key_exists('field', $sum) && $sum['field'] != '') {
                            if ($sum['as'] != '') {
                                $this->db->select_sum($sum['field'], $sum['as']);
                            }
                            else {
                                $this->db->select_sum($sum['field']);
                            }
                        } 
                        else if(is_array($sum) && (!array_key_exists('as', $sum) || !array_key_exists('field', $sum)) ) {
                            // array is not formatted in the way we expect
                            // discard
                        }
                        else if(!is_array($sum) && !empty($sum)) {
                            // originally was named/unnamed array, after filtering here we need only the value
                            $this->db->select_sum($sum);
                        }
                    });
                }

                if(!is_array($order_by) && !empty($order_by))
                {
                    // since this is a specific value, it needs to be taken as field
                    $this->db->order_by($order_by, 'DESC');
                }
                else if(!empty($order_by))
                {
                    array_filter($order_by, function($order_by) {
                        $order_by = (is_array($order_by)) ? array_change_key_case($order_by) : $order_by;
                        if(is_array($order_by) && array_key_exists('order_by', $order_by) && array_key_exists('field', $order_by) && $order_by['field'] != '') {
                            if ($order_by['order_by'] != '') {
                                $this->db->order_by($order_by['field'], $order_by['order_by']);
                            }
                            else {
                                $this->db->order_by($order_by['field'], 'DESC');
                            }
                        } 
                        else if(is_array($order_by) && (!array_key_exists('order_by', $order_by) || !array_key_exists('field', $order_by)) ) {
                            // array is not formatted in the way we expect
                            // discard
                        }
                        else if(!is_array($order_by) && !empty($order_by)) {
                            // originally was named/unnamed array, after filtering here we need only the value
                            // since this is a specific value, it needs to be taken as field
                            $this->db->order_by($order_by, 'DESC');
                        }
                    });
                }
                
                $query = $this->db->get('test_invoices', $results_per_page, $offset); 
                
                return ($return_as_obj) ? $query->result() : $query->result_array();
            }
            else
            {
                $this->db->reset_query();

                $this->db->where('test_invoices.id', 0); //making sure no results are generated by giving a value that don't exists
                $this->db->order_by('test_invoices.id', 'DESC'); 
                $query = $this->db->get('test_invoices', $results_per_page, $offset); 
                
                return ($return_as_obj) ? $query->result() : $query->result_array();
            }
        }
        else
        {
            $this->db->reset_query();

            $this->db->where('id', 0); //making sure no results are generated by giving a value that don't exists
            $this->db->order_by('id', 'DESC'); 
            $query = $this->db->get('test_invoices', $results_per_page, $offset); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array();
        } 
        
    }



    public function count_test_invoices_sum_group_by_from_flavor_kalojam_report_test_invoice_incomes_joined_payments($test_invoice_id='', $patient_id='', $ref_by='', $begin_date='', $end_date='', $payment_status='all', $group_by=array() ) 
    { 

        if ( (($test_invoice_id != '') && ($test_invoice_id != NULL)) || (($patient_id != '') && ($patient_id != NULL)) || (($ref_by != '') && ($ref_by != NULL)) || (($begin_date != '') && ($begin_date != NULL)) || (($end_date != '') && ($end_date != NULL)) || (($payment_status == 'full_paid') || ($payment_status == 'due') || ($payment_status == 'all')) )
        {
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
                $this->db->select('test_invoices.id, test_invoices.patient_id, test_invoices.ref_by, test_invoices.total, test_invoices.discount, test_invoices.subtotal, test_invoices.ctrl__status, DATE(test_invoices.created) as Created_date, test_invoice_payments.is_full_paid, test_invoice_payments.paid_amount');
                $this->db->join('test_invoice_payments', 'test_invoice_payments.test_invoice_id = test_invoices.id');
                
                if (!empty($group_by))
                {
                    $this->db->group_by($group_by);
                }
                $query = $this->db->get('test_invoices');

                return $query->num_rows();
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



} 

?>