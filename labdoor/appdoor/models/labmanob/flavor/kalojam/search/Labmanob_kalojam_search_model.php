<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labmanob_kalojam_search_model extends CI_Model 
{

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->db->db_select($this->db->database); 
    }



    public function count_affiliate_partners_from_search($affiliate_partner_id='', $affiliate_partner_name='', $phone_no='', $email_input='', $current_address_input='', $current_city_input='', $permanent_address_input='', $permanent_city_input='') 
    { 

        if ( (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL)) || (($affiliate_partner_name != '') && ($affiliate_partner_name != NULL)) || (($phone_no != '') && ($phone_no != NULL)) || (($email_input != '') && ($email_input != NULL)) || (($current_address_input != '') && ($current_address_input != NULL)) || (($current_city_input != '') && ($current_city_input != NULL)) || (($permanent_address_input != '') && ($permanent_address_input != NULL)) || (($permanent_city_input != '') && ($permanent_city_input != NULL)) )
        {
            $flag = 0;

            if (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL))
            {
                $this->db->where('id', $affiliate_partner_id);
                $flag++;
            }

            if (($affiliate_partner_name != '') && ($affiliate_partner_name != NULL))
            {
                $this->db->like('firstname', $affiliate_partner_name);
                $this->db->or_like('lastname', $affiliate_partner_name);
                $flag++;
            }

            if (($phone_no != '') && ($phone_no != NULL))
            {
                $this->db->like('phone_no', $phone_no);
                $flag++;
            }

            if (($email_input != '') && ($email_input != NULL))
            {
                $this->db->like('email', $email_input);
                $flag++;
            }

            if (($current_address_input != '') && ($current_address_input != NULL))
            {
                $this->db->like('current_address', $current_address_input);
                $flag++;
            }

            if (($current_city_input != '') && ($current_city_input != NULL))
            {
                $this->db->like('current_city', $current_city_input);
                $flag++;
            }

            if (($permanent_address_input != '') && ($permanent_address_input != NULL))
            {
                $this->db->like('permanent_address', $permanent_address_input);
                $flag++;
            }

            if (($permanent_city_input != '') && ($permanent_city_input != NULL))
            {
                $this->db->like('permanent_city', $permanent_city_input);
                $flag++;
            }

            if($flag != 0)
            {
                return $this->db->count_all_results('affiliate_partners');
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



    public function affiliate_partners_from_search($affiliate_partner_id='', $affiliate_partner_name='', $phone_no='', $email_input='', $current_address_input='', $current_city_input='', $permanent_address_input='', $permanent_city_input='', $page=1, $results_per_page=10, $return_as_obj=TRUE) 
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

        if ( (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL)) || (($affiliate_partner_name != '') && ($affiliate_partner_name != NULL)) || (($phone_no != '') && ($phone_no != NULL)) || (($email_input != '') && ($email_input != NULL)) || (($current_address_input != '') && ($current_address_input != NULL)) || (($current_city_input != '') && ($current_city_input != NULL)) || (($permanent_address_input != '') && ($permanent_address_input != NULL)) || (($permanent_city_input != '') && ($permanent_city_input != NULL)) )
        {
            $flag = 0;

            if (($affiliate_partner_id != '') && ($affiliate_partner_id != NULL))
            {
                $this->db->where('id', $affiliate_partner_id);
                $flag++;
            }

            if (($affiliate_partner_name != '') && ($affiliate_partner_name != NULL))
            {
                $this->db->like('firstname', $affiliate_partner_name);
                $this->db->or_like('lastname', $affiliate_partner_name);
                $flag++;
            }

            if (($phone_no != '') && ($phone_no != NULL))
            {
                $this->db->like('phone_no', $phone_no);
                $flag++;
            }

            if (($email_input != '') && ($email_input != NULL))
            {
                $this->db->like('email', $email_input);
                $flag++;
            }

            if (($current_address_input != '') && ($current_address_input != NULL))
            {
                $this->db->like('current_address', $current_address_input);
                $flag++;
            }

            if (($current_city_input != '') && ($current_city_input != NULL))
            {
                $this->db->like('current_city', $current_city_input);
                $flag++;
            }

            if (($permanent_address_input != '') && ($permanent_address_input != NULL))
            {
                $this->db->like('permanent_address', $permanent_address_input);
                $flag++;
            }

            if (($permanent_city_input != '') && ($permanent_city_input != NULL))
            {
                $this->db->like('permanent_city', $permanent_city_input);
                $flag++;
            }

            if($flag != 0)
            {
                $this->db->order_by('id', 'DESC'); 
                $query = $this->db->get('affiliate_partners', $results_per_page, $offset); 
                
                return ($return_as_obj) ? $query->result() : $query->result_array();
            }
            else
            {
                $this->db->reset_query();

                $this->db->where('id', 0); //making sure no results are generated by giving a value that don't exists
                $this->db->order_by('id', 'DESC'); 
                $query = $this->db->get('affiliate_partners', $results_per_page, $offset); 
                
                return ($return_as_obj) ? $query->result() : $query->result_array();
            }
        }
        else
        {
            $this->db->reset_query();

            $this->db->where('id', 0); //making sure no results are generated by giving a value that don't exists
            $this->db->order_by('id', 'DESC'); 
            $query = $this->db->get('affiliate_partners', $results_per_page, $offset); 
            
            return ($return_as_obj) ? $query->result() : $query->result_array();
        } 
        
    }



} 

?>