<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation', 'pagination', 'table'));
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_search_model', 'labmanob_search_model'); 
        $this->load->model('labmanob/labmanob_view_model', 'labmanob_view_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        
    } 



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $h_view_data = array(); 
            $view_data = array(); 
            $f_view_data = array(); 
            
            $h_view_data['title'] = "Search"; 
            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
            
            $this->load->view('header', $h_view_data); 
            $this->load->view('labmanob/l_col_main', $view_data); 
            $this->load->view('labmanob/search/m_col_main', $view_data);
            $this->load->view('labmanob/r_col_main', $view_data); 
            $this->load->view('footer', $f_view_data);
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function patients($page_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('patient_id', 'Patient ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('patient_name', 'Patient Name', array('trim', 'max_length[100]', array('check_regex_name', array($this->labmanob_add_model, 'check_regex_name')))); 
            $this->form_validation->set_message('check_regex_name', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 
            
            $this->form_validation->set_rules('phone_no', 'Phone Number', array('trim', 'is_natural_no_zero', 'min_length[2]', 'max_length[100]')); 
            
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email'); 
                
            $this->form_validation->set_rules('current_address', 'Current Address', 'trim|max_length[255]'); 
            
            $this->form_validation->set_rules('current_city', 'Current City', 'trim|max_length[50]'); 
            
            $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|max_length[255]'); 
            
            $this->form_validation->set_rules('permanent_city', 'Permanent City', 'trim|max_length[50]'); 
            
            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 


            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Search Patients"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/search/m_col_patients', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;

                if (empty($this->input->post_get('patient_id')) && empty($this->input->post_get('patient_name')) && empty($this->input->post_get('phone_no')) && empty($this->input->post_get('email')) && empty($this->input->post_get('current_address')) && empty($this->input->post_get('current_city')) && empty($this->input->post_get('permanent_address')) && empty($this->input->post_get('permanent_city')) )
                {
                    $error_count++;
                    $error_message = "Please fill up at least one field besides the Results Per Page field!";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Search Patients"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/search/m_col_patients', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $patient_id_input = $this->input->post_get('patient_id');
                    $patient_name_input = $this->input->post_get('patient_name');
                    $phone_no_input = $this->input->post_get('phone_no');
                    $email_input = $this->input->post_get('email');
                    $current_address_input = $this->input->post_get('current_address');
                    $current_city_input = $this->input->post_get('current_city');
                    $permanent_address_input = $this->input->post_get('permanent_address');
                    $permanent_city_input = $this->input->post_get('permanent_city');
                    $results_per_page_input = $this->input->post_get('results_per_page'); 

                    $page_input_ok = FALSE; 
                    $results_per_page = ($results_per_page_input) ? $results_per_page_input : 10; 

                    $total_search_results = $this->labmanob_search_model->count_patients_from_search($patient_id_input, $patient_name_input, $phone_no_input, $email_input, $current_address_input, $current_city_input, $permanent_address_input, $permanent_city_input); 
                    
                    
                    $pgn_config['full_tag_open'] = '<ul class="uk-pagination uk-flex-right uk-margin">'; 
                    $pgn_config['full_tag_close'] = '</ul>'; 
                    $pgn_config['first_link'] = '<span uk-pagination-previous></span><span class="uk-margin-small-right" uk-pagination-previous></span> First'; 
                    $pgn_config['first_tag_open'] = '<li>'; 
                    $pgn_config['first_tag_close'] = '</li>'; 
                    $pgn_config['last_link'] = 'Last <span class="uk-margin-small-left" uk-pagination-next></span><span uk-pagination-next></span>'; 
                    $pgn_config['last_tag_open'] = '<li>'; 
                    $pgn_config['last_tag_close'] = '</li>'; 
                    $pgn_config['next_link'] = 'Next <span class="uk-margin-small-left" uk-pagination-next></span>'; 
                    $pgn_config['next_tag_open'] = '<li>'; 
                    $pgn_config['next_tag_close'] = '</li>'; 
                    $pgn_config['prev_link'] = '<span class="uk-margin-small-right" uk-pagination-previous></span> Previous'; 
                    $pgn_config['prev_tag_open'] = '<li>'; 
                    $pgn_config['prev_tag_close'] = '</li>'; 
                    $pgn_config['cur_tag_open'] = '<li class="uk-active">'; 
                    $pgn_config['cur_tag_close'] = '</li>'; 
                    $pgn_config['num_tag_open'] = '<li>'; 
                    $pgn_config['num_tag_close'] = '</li>'; 
                    
                    $pgn_config['uri_segment'] = 4; 
                    $pgn_config['num_links'] = 2; 
                    $pgn_config['use_page_numbers'] = TRUE; 
                    $pgn_config['reuse_query_string'] = TRUE; 
                    
                    $pgn_config['base_url'] = site_url('labmanob/search/patients'); 
                    $pgn_config['total_rows'] = $total_search_results;
                    $pgn_config['per_page'] = $results_per_page; 
                    
                    $this->pagination->initialize($pgn_config); 
                    
                    $table_tpl = array(
                        'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                        ); 
                    
                    $this->table->set_template($table_tpl); 
                    
                    
                    if ($page_input == '') 
                    { 
                        $page = 1; 
                        $page_input_ok = TRUE; 
                    } 
                    else if ((($page_input != '') || (!empty($page_input))) && (preg_match('/^[1-9][0-9]*$/', $page_input))) 
                    { 
                        $page = $page_input; 
                        $page_input_ok = TRUE; 
                    } 
                    else 
                    { 
                        $page_input_ok = FALSE; 
                        show_404(current_url()); 
                    } 
                    
                    
                    if (($total_search_results > 0) && ($page_input_ok === TRUE)) 
                    { 
                        $total_pages = ($total_search_results / $results_per_page); 
                        $total_pages = ceil($total_pages); 
                        
                        if ($page > $total_pages) 
                        { 
                            show_404(current_url()); 
                        } 
                        else 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Patients"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['pagination_links'] = $this->pagination->create_links(); 
                            $view_data['patients_table_empty'] = FALSE; 
                            
                            $this->table->set_heading('ID', 'First Name', 'Last Name', 'Sex', 'Phone No', 'Email', 'Current Address', 'Current City', 'Permanent Address', 'Permanent City', 'Extra Info', 'Added'); 
                            $patients = $this->labmanob_search_model->patients_from_search($patient_id_input, $patient_name_input, $phone_no_input, $email_input, $current_address_input, $current_city_input, $permanent_address_input, $permanent_city_input, $page, $results_per_page, TRUE); 
                            
                            foreach ($patients as $patient) { 
                                $patient_id_anchor = anchor('labmanob/view/patient/'.$patient->id, $patient->id, array('class' => 'uk-link-reset')); 
                                $this->table->add_row(array('data' => $patient_id_anchor, 'class' => 'uk-table-link'), $patient->firstname, $patient->lastname, $patient->sex, $patient->phone_no, $patient->email, $patient->current_address, $patient->current_city, $patient->permanent_address, $patient->permanent_city, $patient->extra_info, $patient->created); 
                            } 
                                
                            $view_data['patients_table'] = $this->table->generate(); 
                            $view_data['total_search_results'] = $total_search_results;
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/search/m_col_patients__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        
                    } 
                    else 
                    { 
                        
                        if ($page == 1) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Patients"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['patients_table_empty'] = TRUE; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/search/m_col_patients__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_404(current_url()); 
                        } 
                        
                    }
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function test_invoices($page_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('test_invoice_id', 'Test Invoice ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('patient_id', 'Patient ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('ref_by', 'Ref By', array('trim', 'max_length[255]', array('check_regex_ref_by', array($this->labmanob_add_model, 'check_regex_name'))));
            $this->form_validation->set_message('check_regex_ref_by', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 

            $this->form_validation->set_rules('affiliate_partner_id', 'Affiliate Partner ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('begin_date', 'Begin Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('end_date', 'End Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('payment_status', 'Payment Status', array('trim', 'alpha_dash', 'min_length[1]', 'max_length[10]')); 
            

            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Search Test Invoices"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/search/m_col_test_invoices', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;
                $payment_status_input = strtolower($this->input->post_get('payment_status'));

                if ( empty($this->input->post_get('test_invoice_id')) && empty($this->input->post_get('patient_id')) && empty($this->input->post_get('ref_by')) && empty($this->input->post_get('begin_date')) && empty($this->input->post_get('end_date')) && empty($this->input->post_get('payment_status')) )
                {
                    $error_count++;
                    $error_message = "Please fill up at least one field!";
                }
                else if ( ($payment_status_input != 'all') && ($payment_status_input != 'full_paid') && ($payment_status_input != 'due') )
                {
                    $error_count++;
                    $error_message = "Invalid Payment Status requested!";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Search Test Invoices"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/search/m_col_test_invoices', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $test_invoice_id_input = $this->input->post_get('test_invoice_id');
                    $patient_id_input = $this->input->post_get('patient_id');
                    $ref_by_input = $this->input->post_get('ref_by');
                    $affiliate_partner_id_input = $this->input->post_get('affiliate_partner_id');
                    $begin_date_input = $this->input->post_get('begin_date');
                    $end_date_input = $this->input->post_get('end_date'); 

                    $page_input_ok = FALSE; 
                    $results_per_page = 10; 

                    $total_search_results = $this->labmanob_search_model->count_test_invoices_from_search_joined_payments($test_invoice_id_input, $patient_id_input, $ref_by_input, $affiliate_partner_id_input, $begin_date_input, $end_date_input, $payment_status_input); 
                    
                    
                    $pgn_config['full_tag_open'] = '<ul class="uk-pagination uk-flex-right uk-margin">'; 
                    $pgn_config['full_tag_close'] = '</ul>'; 
                    $pgn_config['first_link'] = '<span uk-pagination-previous></span><span class="uk-margin-small-right" uk-pagination-previous></span> First'; 
                    $pgn_config['first_tag_open'] = '<li>'; 
                    $pgn_config['first_tag_close'] = '</li>'; 
                    $pgn_config['last_link'] = 'Last <span class="uk-margin-small-left" uk-pagination-next></span><span uk-pagination-next></span>'; 
                    $pgn_config['last_tag_open'] = '<li>'; 
                    $pgn_config['last_tag_close'] = '</li>'; 
                    $pgn_config['next_link'] = 'Next <span class="uk-margin-small-left" uk-pagination-next></span>'; 
                    $pgn_config['next_tag_open'] = '<li>'; 
                    $pgn_config['next_tag_close'] = '</li>'; 
                    $pgn_config['prev_link'] = '<span class="uk-margin-small-right" uk-pagination-previous></span> Previous'; 
                    $pgn_config['prev_tag_open'] = '<li>'; 
                    $pgn_config['prev_tag_close'] = '</li>'; 
                    $pgn_config['cur_tag_open'] = '<li class="uk-active">'; 
                    $pgn_config['cur_tag_close'] = '</li>'; 
                    $pgn_config['num_tag_open'] = '<li>'; 
                    $pgn_config['num_tag_close'] = '</li>'; 
                    
                    $pgn_config['uri_segment'] = 4; 
                    $pgn_config['num_links'] = 2; 
                    $pgn_config['use_page_numbers'] = TRUE; 
                    $pgn_config['reuse_query_string'] = TRUE; 
                    
                    $pgn_config['base_url'] = site_url('labmanob/search/test_invoices'); 
                    $pgn_config['total_rows'] = $total_search_results;
                    $pgn_config['per_page'] = $results_per_page; 
                    
                    $this->pagination->initialize($pgn_config); 
                    
                    $table_tpl = array(
                        'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                        ); 
                    
                    $this->table->set_template($table_tpl); 
                    
                    
                    if ($page_input == '') 
                    { 
                        $page = 1; 
                        $page_input_ok = TRUE; 
                    } 
                    else if ((($page_input != '') || (!empty($page_input))) && (preg_match('/^[1-9][0-9]*$/', $page_input))) 
                    { 
                        $page = $page_input; 
                        $page_input_ok = TRUE; 
                    } 
                    else 
                    { 
                        $page_input_ok = FALSE; 
                        show_404(current_url()); 
                    } 
                    
                    
                    if (($total_search_results > 0) && ($page_input_ok === TRUE)) 
                    { 
                        $total_pages = ($total_search_results / $results_per_page); 
                        $total_pages = ceil($total_pages); 
                        
                        if ($page > $total_pages) 
                        { 
                            show_404(current_url()); 
                        } 
                        else 
                        { 
                            $earnings_subtotal = 0;
                            $earnings_paid_amount = 0;
                            $earnings_due = 0;

                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Test Invoices"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['pagination_links'] = $this->pagination->create_links(); 
                            $view_data['test_invoices_table_empty'] = FALSE; 
                            
                            $this->table->set_heading('ID', 'Patient ID', 'Patient Name', 'Patient Age', 'Ref By', 'Affiliate Partner ID', 'Extra Info', 'Total', 'Discount', 'Discount By', 'Subtotal', 'Paid', 'Due', 'Added', 'Details'); 
                            $test_invoices = $this->labmanob_search_model->test_invoices_from_search_joined_payments($test_invoice_id_input, $patient_id_input, $ref_by_input, $affiliate_partner_id_input, $begin_date_input, $end_date_input, $payment_status_input, $page, $results_per_page, TRUE); 
                            
                            foreach ($test_invoices as $test_invoice) { 
                                $patient_name = ''; 
                                
                                
                                if ($this->labmanob_view_model->count_test_invoice_payments_from_id($test_invoice->id) > 0) 
                                { 
                                    $patients = $this->labmanob_search_model->patients_by_id($test_invoice->patient_id, TRUE); 
                                    
                                    if ($patients !== FALSE) 
                                    { 
                                    
                                        foreach ($patients as $patient) 
                                        { 
                                            $patient_name = $patient->firstname.' '.$patient->lastname; 
                                        } 
                                    
                                    } 
                                    else 
                                    { 
                                        $patient_name = ''; 
                                    } 
                                    
                                } 
                                else 
                                { 
                                    $patient_name = ''; 
                                } 
                                

                                $earnings_subtotal += (float)$test_invoice->subtotal;
                                $earnings_paid_amount += (float)$test_invoice->paid_amount;
                                $earnings_due += (float)($test_invoice->subtotal - $test_invoice->paid_amount);
                                
                                $test_invoice_id_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice->id, $test_invoice->id, array('class' => 'uk-link-reset'));
                                $test_invoice_patient_id_anchor = anchor('labmanob/view/patient/'.$test_invoice->patient_id, $test_invoice->patient_id, array('class' => 'uk-link-reset'));
                                $test_invoice_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice->id, 'View', array('class' => 'uk-link-reset'));
                                $this->table->add_row(array('data' => $test_invoice_id_anchor, 'class' => 'uk-table-link'), array('data' => $test_invoice_patient_id_anchor, 'class' => 'uk-table-link'), $patient_name, $test_invoice->patient_age, $test_invoice->ref_by, $test_invoice->affiliate_partner_id, array('data' => $test_invoice->extra_info, 'class' => 'uk-text-truncate'), sprintf("%.2f", (float)$test_invoice->total), $test_invoice->discount, $test_invoice->discount_by, sprintf("%.2f", (float)$test_invoice->subtotal), sprintf("%.2f", (float)$test_invoice->paid_amount), sprintf("%.2f", (float)($test_invoice->subtotal - $test_invoice->paid_amount)), $test_invoice->created, array('data' => $test_invoice_anchor, 'class' => 'uk-table-link')); 
                            } 
                                
                            $view_data['test_invoices_table'] = $this->table->generate(); 
                            $view_data['total_search_results'] = $total_search_results;
                            $view_data['earnings_subtotal'] = sprintf("%.2f", (float)$earnings_subtotal); 
                            $view_data['earnings_paid_amount'] = sprintf("%.2f", (float)$earnings_paid_amount); 
                            $view_data['earnings_due'] = sprintf("%.2f", (float)$earnings_due); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/search/m_col_test_invoices__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        
                    } 
                    else 
                    { 
                        
                        if ($page == 1) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Test Invoices"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['test_invoices_table_empty'] = TRUE; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/search/m_col_test_invoices__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_404(current_url()); 
                        } 
                        
                    }
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function tests_invoice_freq($page_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('test_id', 'Test Invoice ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('begin_date', 'Begin Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('end_date', 'End Date', array('trim', 'min_length[1]', 'max_length[30]')); 
            

            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Search Tests Invoice Frequency"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/search/m_col_tests_invoice_freq', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;

                if ( empty($this->input->post_get('test_id')) && empty($this->input->post_get('begin_date')) && empty($this->input->post_get('end_date')) )
                {
                    $error_count++;
                    $error_message = "Please fill up at least one field!";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Search Tests Invoice Frequency"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/search/m_col_tests_invoice_freq', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    /* tests_invoice_freq by test_id start { */
                    if (!empty($this->input->post_get('test_id')))
                    {
                        $test_id_input = $this->input->post_get('test_id'); 
                        $begin_date_input = $this->input->post_get('begin_date');
                        $end_date_input = $this->input->post_get('end_date'); 

                        $page_input_ok = FALSE; 
                        $results_per_page = 10; 

                        $total_search_results = $this->labmanob_search_model->count_test_invoice_records_from_search('', '', $test_id_input, $begin_date_input, $end_date_input); 
                        
                        
                        $pgn_config['full_tag_open'] = '<ul class="uk-pagination uk-flex-right uk-margin">'; 
                        $pgn_config['full_tag_close'] = '</ul>'; 
                        $pgn_config['first_link'] = '<span uk-pagination-previous></span><span class="uk-margin-small-right" uk-pagination-previous></span> First'; 
                        $pgn_config['first_tag_open'] = '<li>'; 
                        $pgn_config['first_tag_close'] = '</li>'; 
                        $pgn_config['last_link'] = 'Last <span class="uk-margin-small-left" uk-pagination-next></span><span uk-pagination-next></span>'; 
                        $pgn_config['last_tag_open'] = '<li>'; 
                        $pgn_config['last_tag_close'] = '</li>'; 
                        $pgn_config['next_link'] = 'Next <span class="uk-margin-small-left" uk-pagination-next></span>'; 
                        $pgn_config['next_tag_open'] = '<li>'; 
                        $pgn_config['next_tag_close'] = '</li>'; 
                        $pgn_config['prev_link'] = '<span class="uk-margin-small-right" uk-pagination-previous></span> Previous'; 
                        $pgn_config['prev_tag_open'] = '<li>'; 
                        $pgn_config['prev_tag_close'] = '</li>'; 
                        $pgn_config['cur_tag_open'] = '<li class="uk-active">'; 
                        $pgn_config['cur_tag_close'] = '</li>'; 
                        $pgn_config['num_tag_open'] = '<li>'; 
                        $pgn_config['num_tag_close'] = '</li>'; 
                        
                        $pgn_config['uri_segment'] = 4; 
                        $pgn_config['num_links'] = 2; 
                        $pgn_config['use_page_numbers'] = TRUE; 
                        $pgn_config['reuse_query_string'] = TRUE; 
                        
                        $pgn_config['base_url'] = site_url('labmanob/search/tests_invoice_freq'); 
                        $pgn_config['total_rows'] = $total_search_results;
                        $pgn_config['per_page'] = $results_per_page; 
                        
                        $this->pagination->initialize($pgn_config); 
                        
                        $table_tpl = array(
                            'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                            ); 
                        
                        $this->table->set_template($table_tpl); 
                        
                        
                        if ($page_input == '') 
                        { 
                            $page = 1; 
                            $page_input_ok = TRUE; 
                        } 
                        else if ((($page_input != '') || (!empty($page_input))) && (preg_match('/^[1-9][0-9]*$/', $page_input))) 
                        { 
                            $page = $page_input; 
                            $page_input_ok = TRUE; 
                        } 
                        else 
                        { 
                            $page_input_ok = FALSE; 
                            show_404(current_url()); 
                        } 
                        
                        
                        if (($total_search_results > 0) && ($page_input_ok === TRUE)) 
                        { 
                            $total_pages = ($total_search_results / $results_per_page); 
                            $total_pages = ceil($total_pages); 
                            
                            if ($page > $total_pages) 
                            { 
                                show_404(current_url()); 
                            } 
                            else 
                            { 
                                $total_test_quantity = 0;

                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                                $h_view_data['title'] = "Search Tests Invoice Frequency"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                $view_data['pagination_links'] = $this->pagination->create_links(); 
                                $view_data['tests_invoice_freq_table_empty'] = FALSE; 
                                
                                $this->table->set_heading('Record ID', 'Test Invoice ID', 'Test ID', 'Test Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal', 'Added', 'Details'); 
                                $test_invoice_records = $this->labmanob_search_model->test_invoice_records_from_search('', '', $test_id_input, $begin_date_input, $end_date_input, $page, $results_per_page, TRUE); 
                                
                                foreach ($test_invoice_records as $test_invoice_record) {
                                    $total_test_quantity += $test_invoice_record->quantity;

                                    $test_invoice_record_id_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice_record->test_invoice_id, $test_invoice_record->test_invoice_id, array('class' => 'uk-link-reset'));
                                    $test_invoice_id_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice_record->test_invoice_id, $test_invoice_record->test_invoice_id, array('class' => 'uk-link-reset'));
                                    $test_invoice_view_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice_record->test_invoice_id, 'View', array('class' => 'uk-link-reset'));
                                    $this->table->add_row(array('data' => $test_invoice_record_id_anchor, 'class' => 'uk-table-link'), array('data' => $test_invoice_id_anchor, 'class' => 'uk-table-link'), $test_invoice_record->test_id, $test_invoice_record->test_price, $test_invoice_record->quantity, sprintf("%.2f", (float)$test_invoice_record->total), $test_invoice_record->discount, $test_invoice_record->discount_by, sprintf("%.2f", (float)$test_invoice_record->subtotal), $test_invoice_record->created, array('data' => $test_invoice_view_anchor, 'class' => 'uk-table-link')); 
                                } 
                                    
                                $view_data['tests_invoice_freq_table'] = $this->table->generate(); 
                                $view_data['total_search_results'] = $total_search_results;
                                $view_data['total_test_quantity'] = $total_test_quantity;
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/search/m_col_tests_invoice_freq__result', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            } 
                            
                        } 
                        else 
                        { 
                            
                            if ($page == 1) 
                            { 
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                                $h_view_data['title'] = "Search Tests Invoice Frequency"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                $view_data['tests_invoice_freq_table_empty'] = TRUE; 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/search/m_col_tests_invoice_freq__result', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            } 
                            else 
                            { 
                                show_404(current_url()); 
                            } 
                            
                        }
                    }
                    /* tests_invoice_freq by test_id end } */

                    /* tests_invoice_freq by date range start { */
                    /******************************
                    ** this section of code can also be called as 
                    ** tests_invoice_freq_summary
                    ** since this section has been inegrated to the prior coded section tests_invoice_freq
                    ** with a view to not to add any extra other URI for the tests overview for a given date range
                    *******************************/
                    else if( !empty($this->input->post_get('begin_date')) || !empty($this->input->post_get('end_date')) )
                    {
                        $begin_date_input = $this->input->post_get('begin_date');
                        $end_date_input = $this->input->post_get('end_date'); 

                        $page_input_ok = FALSE; 
                        $results_per_page = 10; 

                        $total_search_results = $this->labmanob_search_model->count_test_invoice_records_sum_group_by_from_search_joined_tests_joined_test_categories('', '', '', $begin_date_input, $end_date_input, array('tests.id')); 
                        
                        
                        $pgn_config['full_tag_open'] = '<ul class="uk-pagination uk-flex-right uk-margin">'; 
                        $pgn_config['full_tag_close'] = '</ul>'; 
                        $pgn_config['first_link'] = '<span uk-pagination-previous></span><span class="uk-margin-small-right" uk-pagination-previous></span> First'; 
                        $pgn_config['first_tag_open'] = '<li>'; 
                        $pgn_config['first_tag_close'] = '</li>'; 
                        $pgn_config['last_link'] = 'Last <span class="uk-margin-small-left" uk-pagination-next></span><span uk-pagination-next></span>'; 
                        $pgn_config['last_tag_open'] = '<li>'; 
                        $pgn_config['last_tag_close'] = '</li>'; 
                        $pgn_config['next_link'] = 'Next <span class="uk-margin-small-left" uk-pagination-next></span>'; 
                        $pgn_config['next_tag_open'] = '<li>'; 
                        $pgn_config['next_tag_close'] = '</li>'; 
                        $pgn_config['prev_link'] = '<span class="uk-margin-small-right" uk-pagination-previous></span> Previous'; 
                        $pgn_config['prev_tag_open'] = '<li>'; 
                        $pgn_config['prev_tag_close'] = '</li>'; 
                        $pgn_config['cur_tag_open'] = '<li class="uk-active">'; 
                        $pgn_config['cur_tag_close'] = '</li>'; 
                        $pgn_config['num_tag_open'] = '<li>'; 
                        $pgn_config['num_tag_close'] = '</li>'; 
                        
                        $pgn_config['uri_segment'] = 4; 
                        $pgn_config['num_links'] = 2; 
                        $pgn_config['use_page_numbers'] = TRUE; 
                        $pgn_config['reuse_query_string'] = TRUE; 
                        
                        $pgn_config['base_url'] = site_url('labmanob/search/tests_invoice_freq'); 
                        $pgn_config['total_rows'] = $total_search_results;
                        $pgn_config['per_page'] = $results_per_page; 
                        
                        $this->pagination->initialize($pgn_config); 
                        
                        $table_tpl = array(
                            'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                            ); 
                        
                        $this->table->set_template($table_tpl); 
                        
                        
                        if ($page_input == '') 
                        { 
                            $page = 1; 
                            $page_input_ok = TRUE; 
                        } 
                        else if ((($page_input != '') || (!empty($page_input))) && (preg_match('/^[1-9][0-9]*$/', $page_input))) 
                        { 
                            $page = $page_input; 
                            $page_input_ok = TRUE; 
                        } 
                        else 
                        { 
                            $page_input_ok = FALSE; 
                            show_404(current_url()); 
                        } 
                        
                        
                        if (($total_search_results > 0) && ($page_input_ok === TRUE)) 
                        { 
                            $total_pages = ($total_search_results / $results_per_page); 
                            $total_pages = ceil($total_pages); 
                            
                            if ($page > $total_pages) 
                            { 
                                show_404(current_url()); 
                            } 
                            else 
                            { 
                                $total_test_quantity = 0;

                                $sum_query_build = array(
                                    array(
                                        'as' => 'Quantity',
                                        'field' => 'test_invoice_records.quantity'
                                    )
                                );

                                $order_by_query_build = array(
                                    array(
                                        'order_by' => 'DESC',
                                        'field' => 'Quantity'
                                    )
                                );

                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                                $h_view_data['title'] = "Search Tests Invoice Frequency"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                $view_data['pagination_links'] = $this->pagination->create_links(); 
                                $view_data['tests_invoice_freq_table_empty'] = FALSE;

                                $this->table->set_heading('Test ID', 'Test Name', 'Test Category', 'Quantity'); 
                                $test_invoice_records = $this->labmanob_search_model->test_invoice_records_sum_group_by_from_search_joined_tests_joined_test_categories('', '', '', $begin_date_input, $end_date_input, $sum_query_build, array('tests.id'), $order_by_query_build, $page, $results_per_page, TRUE); 
                                
                                foreach ($test_invoice_records as $test_invoice_record) {
                                    $this->table->add_row($test_invoice_record->test_id, $test_invoice_record->test_name, $test_invoice_record->category_name, $test_invoice_record->Quantity); 
                                } 
                                    
                                $view_data['tests_invoice_freq_table'] = $this->table->generate(); 
                                $view_data['total_search_results'] = $total_search_results;
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/search/m_col_tests_invoice_freq__result', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            } 
                            
                        } 
                        else 
                        { 
                            
                            if ($page == 1) 
                            { 
                                $h_view_data = array(); 
                                $view_data = array(); 
                                $f_view_data = array(); 
                                $h_view_data['title'] = "Search Tests Invoice Frequency"; 
                                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                                $view_data['tests_invoice_freq_table_empty'] = TRUE; 
                                
                                $this->load->view('header', $h_view_data); 
                                $this->load->view('labmanob/l_col_main', $view_data); 
                                $this->load->view('labmanob/search/m_col_tests_invoice_freq__result', $view_data); 
                                $this->load->view('labmanob/r_col_main', $view_data); 
                                $this->load->view('footer', $f_view_data); 
                            } 
                            else 
                            { 
                                show_404(current_url()); 
                            } 
                            
                        }
                    }
                    /* tests_invoice_freq by date range end } */
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function test_invoice_logs($page_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('test_invoice_log_id', 'Test Invoice Log ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('test_invoice_id', 'Test Invoice ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|min_length[5]|max_length[30]');
            
            $this->form_validation->set_rules('begin_date', 'Begin Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('end_date', 'End Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('prev_payment_status', 'Previous Payment Status', array('trim', 'alpha_dash', 'min_length[1]', 'max_length[10]'));

            $this->form_validation->set_rules('payment_status', 'Payment Status', array('trim', 'alpha_dash', 'min_length[1]', 'max_length[10]'));
            

            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Search Test Invoice Logs"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/search/m_col_test_invoice_logs', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;
                $prev_payment_status_input = strtolower($this->input->post_get('prev_payment_status'));
                $payment_status_input = strtolower($this->input->post_get('payment_status'));

                if ( empty($this->input->post_get('test_invoice_log_id')) && empty($this->input->post_get('test_invoice_id')) && empty($this->input->post_get('username')) && empty($this->input->post_get('begin_date')) && empty($this->input->post_get('end_date')) && empty($this->input->post_get('prev_payment_status')) && empty($this->input->post_get('payment_status')) )
                {
                    $error_count++;
                    $error_message = "Please fill up at least the Previous Payment Status and the Payment Status fields!";
                }
                else if ( ($prev_payment_status_input != 'all') && ($prev_payment_status_input != 'full_paid') && ($prev_payment_status_input != 'due') )
                {
                    $error_count++;
                    $error_message = "Invalid Previous Payment Status requested!";
                }
                else if ( ($payment_status_input != 'all') && ($payment_status_input != 'full_paid') && ($payment_status_input != 'due') )
                {
                    $error_count++;
                    $error_message = "Invalid Payment Status requested!";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Search Test Invoice Logs"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/search/m_col_test_invoice_logs', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $test_invoice_log_id_input = $this->input->post_get('test_invoice_log_id'); 
                    $test_invoice_id_input = $this->input->post_get('test_invoice_id'); 
                    $username_input = strtolower($this->input->post_get('username')); 
                    $begin_date_input = $this->input->post_get('begin_date');
                    $end_date_input = $this->input->post_get('end_date'); 

                    $page_input_ok = FALSE; 
                    $results_per_page = 10; 

                    $total_search_results = $this->labmanob_search_model->count_test_invoice_logs_from_search($test_invoice_log_id_input, $test_invoice_id_input, $username_input, $begin_date_input, $end_date_input, $prev_payment_status_input, $payment_status_input); 
                    
                    
                    $pgn_config['full_tag_open'] = '<ul class="uk-pagination uk-flex-right uk-margin">'; 
                    $pgn_config['full_tag_close'] = '</ul>'; 
                    $pgn_config['first_link'] = '<span uk-pagination-previous></span><span class="uk-margin-small-right" uk-pagination-previous></span> First'; 
                    $pgn_config['first_tag_open'] = '<li>'; 
                    $pgn_config['first_tag_close'] = '</li>'; 
                    $pgn_config['last_link'] = 'Last <span class="uk-margin-small-left" uk-pagination-next></span><span uk-pagination-next></span>'; 
                    $pgn_config['last_tag_open'] = '<li>'; 
                    $pgn_config['last_tag_close'] = '</li>'; 
                    $pgn_config['next_link'] = 'Next <span class="uk-margin-small-left" uk-pagination-next></span>'; 
                    $pgn_config['next_tag_open'] = '<li>'; 
                    $pgn_config['next_tag_close'] = '</li>'; 
                    $pgn_config['prev_link'] = '<span class="uk-margin-small-right" uk-pagination-previous></span> Previous'; 
                    $pgn_config['prev_tag_open'] = '<li>'; 
                    $pgn_config['prev_tag_close'] = '</li>'; 
                    $pgn_config['cur_tag_open'] = '<li class="uk-active">'; 
                    $pgn_config['cur_tag_close'] = '</li>'; 
                    $pgn_config['num_tag_open'] = '<li>'; 
                    $pgn_config['num_tag_close'] = '</li>'; 
                    
                    $pgn_config['uri_segment'] = 4; 
                    $pgn_config['num_links'] = 2; 
                    $pgn_config['use_page_numbers'] = TRUE; 
                    $pgn_config['reuse_query_string'] = TRUE; 
                    
                    $pgn_config['base_url'] = site_url('labmanob/search/test_invoice_logs'); 
                    $pgn_config['total_rows'] = $total_search_results;
                    $pgn_config['per_page'] = $results_per_page; 
                    
                    $this->pagination->initialize($pgn_config); 
                    
                    $table_tpl = array(
                        'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                        ); 
                    
                    $this->table->set_template($table_tpl); 
                    
                    
                    if ($page_input == '') 
                    { 
                        $page = 1; 
                        $page_input_ok = TRUE; 
                    } 
                    else if ((($page_input != '') || (!empty($page_input))) && (preg_match('/^[1-9][0-9]*$/', $page_input))) 
                    { 
                        $page = $page_input; 
                        $page_input_ok = TRUE; 
                    } 
                    else 
                    { 
                        $page_input_ok = FALSE; 
                        show_404(current_url()); 
                    } 
                    
                    
                    if (($total_search_results > 0) && ($page_input_ok === TRUE)) 
                    { 
                        $total_pages = ($total_search_results / $results_per_page); 
                        $total_pages = ceil($total_pages); 
                        
                        if ($page > $total_pages) 
                        { 
                            show_404(current_url()); 
                        } 
                        else 
                        { 
                            $order_by_query_build = array(
                                array(
                                    'order_by' => 'DESC',
                                    'field' => 'id'
                                )
                            );

                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Test Invoice Logs"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['pagination_links'] = $this->pagination->create_links(); 
                            $view_data['test_invoice_logs_table_empty'] = FALSE; 
                            
                            $this->table->set_heading('Test Invoice Log ID', 'Test Invoice ID', 'Is Latest Log', 'Username', 
                                                'Prev Total', 'Prev Discount', 'Prev Discount By', 'Prev Subtotal', 'Prev Full Paid', 'Prev Paid Amount', 
                                                'Total', 'Discount', 'Discount By', 'Subtotal', 'Full Paid', 'Paid Amount', 'Date Created'
                            );
                            
                            $test_invoice_logs = $this->labmanob_search_model->test_invoice_logs_from_search($test_invoice_log_id_input, $test_invoice_id_input, $username_input, $begin_date_input, $end_date_input, $prev_payment_status_input, $payment_status_input, $order_by_query_build, $page, $results_per_page, TRUE); 
                            
                            foreach ($test_invoice_logs as $test_invoice_log) {
                                $prev_is_full_paid = ($test_invoice_log->prev_is_full_paid == 1) ? "Yes" : "No";
                                $is_full_paid = ($test_invoice_log->is_full_paid == 1) ? "Yes" : "No";
                                $latest_test_invoice_log_by_test_invoice_id = $this->labmanob_search_model->test_invoice_logs_from_search('', $test_invoice_log->test_invoice_id, '', '', '', '', '', 1, 1, TRUE); 
                                $is_latest_test_invoice_log_by_test_invoice_id = ($test_invoice_log->id == $latest_test_invoice_log_by_test_invoice_id[0]->id) ? "Yes" : "No";

                                $test_invoice_id_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice_log->test_invoice_id, $test_invoice_log->test_invoice_id, array('class' => 'uk-link-reset'));
                                $this->table->add_row($test_invoice_log->id, array('data' => $test_invoice_id_anchor, 'class' => 'uk-table-link'), $is_latest_test_invoice_log_by_test_invoice_id, $test_invoice_log->username, 
                                                        sprintf("%.2f", (float)$test_invoice_log->prev_total), $test_invoice_log->prev_discount, $test_invoice_log->prev_discount_by, sprintf("%.2f", (float)$test_invoice_log->prev_subtotal), $prev_is_full_paid, sprintf("%.2f", (float)$test_invoice_log->prev_paid_amount),
                                                        sprintf("%.2f", (float)$test_invoice_log->total), $test_invoice_log->discount, $test_invoice_log->discount_by, sprintf("%.2f", (float)$test_invoice_log->subtotal), $is_full_paid, sprintf("%.2f", (float)$test_invoice_log->paid_amount), $test_invoice_log->created
                                );
                            }
                                
                            $view_data['test_invoice_logs_table'] = $this->table->generate(); 
                            $view_data['total_search_results'] = $total_search_results;
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/search/m_col_test_invoice_logs__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        
                    } 
                    else 
                    { 
                        
                        if ($page == 1) 
                        { 
                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Search Test Invoice Logs"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['test_invoice_logs_table_empty'] = TRUE; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/search/m_col_test_invoice_logs__result', $view_data); 
                            $this->load->view('labmanob/r_col_main', $view_data); 
                            $this->load->view('footer', $f_view_data); 
                        } 
                        else 
                        { 
                            show_404(current_url()); 
                        } 
                        
                    }
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



}

?>