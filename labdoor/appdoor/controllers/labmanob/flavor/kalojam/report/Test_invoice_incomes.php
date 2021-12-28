<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_invoice_incomes extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form')); 
        $this->load->library(array('session', 'form_validation', 'pagination', 'table'));
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/flavor/kalojam/report/labmanob_test_invoice_incomes_model', 'labmanob_test_invoice_incomes_model'); 
    } 



    public function index() 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            if(strtolower($_SESSION['username']) != 'viewer')
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Test Invoice Incomes"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoice_incomes', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                $h_view_data['title'] = "Access Denied"; 
                
                $this->load->view('errors/access/header', $h_view_data); 
                $this->load->view('errors/access/l_col_main', $view_data); 
                $this->load->view('errors/access/m_col_access_denied', $view_data); 
                $this->load->view('errors/access/r_col_main', $view_data); 
                $this->load->view('errors/access/footer', $f_view_data); 
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function view($page_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('begin_date', 'Begin Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('end_date', 'End Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('group_by', 'Group by Date', 'trim'); 
            

            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Test Invoice Incomes"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoice_incomes', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;

                if ( empty($this->input->post_get('begin_date')) && empty($this->input->post_get('end_date')) )
                {
                    $error_count++;
                    $error_message = "Please fill up at least one field!";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Test Invoice Incomes"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoice_incomes', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $group_by = array();
                    $group_by_date_bool = FALSE;

                    if (($this->input->post_get('group_by')) && (strtolower($this->input->post_get('group_by')) == 'date')) 
                    {
                        $group_by=array('Created_date');
                        $group_by_date_bool = TRUE;
                    }

                    $begin_date_input = $this->input->post_get('begin_date');
                    $end_date_input = $this->input->post_get('end_date'); 

                    $page_input_ok = FALSE; 
                    $results_per_page = 10; 

                    $total_search_results = $this->labmanob_test_invoice_incomes_model->count_test_invoices_sum_group_by_from_flavor_kalojam_report_test_invoice_incomes_joined_payments('', '', '', $begin_date_input, $end_date_input, 'all', $group_by); 
                    
                    
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
                    
                    $pgn_config['uri_segment'] = 7; 
                    $pgn_config['num_links'] = 2; 
                    $pgn_config['use_page_numbers'] = TRUE; 
                    $pgn_config['reuse_query_string'] = TRUE; 
                    
                    $pgn_config['base_url'] = site_url('labmanob/flavor/kalojam/report/test_invoice_incomes/view'); 
                    $pgn_config['total_rows'] = (!$group_by_date_bool && ($total_search_results > 0)) ? 1 : $total_search_results;
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
                            $sum_query_build = array(
                                array(
                                    'as' => 'Subtotal',
                                    'field' => 'test_invoices.subtotal'
                                ),
                                array(
                                    'as' => 'Discount',
                                    'field' => 'test_invoices.discount'
                                ),
                                array(
                                    'as' => 'Total',
                                    'field' => 'test_invoices.total'
                                )
                            );

                            $sum_query2_build = array(
                                array(
                                    'as' => 'Subtotal',
                                    'field' => 'test_invoices.subtotal'
                                ),
                                array(
                                    'as' => 'Paid_amount',
                                    'field' => 'test_invoice_payments.paid_amount'
                                )
                            );

                            /* $order_by_query_build = array(
                                array(
                                    'order_by' => 'DESC',
                                    'field' => 'Subtotal'
                                )
                            ); */

                            $h_view_data = array(); 
                            $view_data = array(); 
                            $f_view_data = array(); 
                            $h_view_data['title'] = "Test Invoice Incomes"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['pagination_links'] = $this->pagination->create_links(); 
                            $view_data['test_invoice_incomes_table_empty'] = FALSE;

                            $test_invoice_incomes = $this->labmanob_test_invoice_incomes_model->test_invoices_sum_group_by_from_flavor_kalojam_report_test_invoice_incomes_joined_payments('', '', '', $begin_date_input, $end_date_input, 'all', $sum_query_build, $group_by, /* $order_by_query_build */ '', $page, $results_per_page, TRUE); 
                            $test_invoice_incomes2 = $this->labmanob_test_invoice_incomes_model->test_invoices_sum_group_by_from_flavor_kalojam_report_test_invoice_incomes_joined_payments('', '', '', $begin_date_input, $end_date_input, 'due', $sum_query2_build, $group_by, /* $order_by_query_build */ '', $page, $results_per_page, TRUE); 

                            
                            $test_invoice_incomes_final = array_map(function ($test_invoice_incomes, $test_invoice_incomes2) {
                                $temp2['Due'] = 0;
                                
                                /* First converting the stdClass object to json object data and then
                                decoding it to an array setting json_decode to TRUE */
                                $temp = json_decode(json_encode($test_invoice_incomes), TRUE);
                                $test_invoice_incomes2_temp = json_decode(json_encode($test_invoice_incomes2), TRUE);

                                // checking if test_invoice_incomes2 is also available to get merged
                                if (($test_invoice_incomes2_temp !== NULL) && ($test_invoice_incomes2_temp['Subtotal'] !== NULL) && ($test_invoice_incomes2_temp['Paid_amount'] !== NULL)) 
                                {
                                    $temp2['Due'] = $test_invoice_incomes2_temp['Subtotal'] - $test_invoice_incomes2_temp['Paid_amount'];
                                }

                                return array_merge($temp, $temp2);
                            }, $test_invoice_incomes, $test_invoice_incomes2);


                            if(!empty($group_by) && ($group_by_date_bool === TRUE))
                            {
                                $this->table->set_heading('Date', 'Total', 'Discount', 'Due', 'Subtotal'); 
                                foreach ($test_invoice_incomes_final as $test_invoice_income) {
                                    $this->table->add_row($test_invoice_income['Created_date'], $test_invoice_income['Total'], $test_invoice_income['Discount'], $test_invoice_income['Due'], $test_invoice_income['Subtotal']); 
                                }
                            } 
                            else 
                            {
                                $this->table->set_heading('Total', 'Discount', 'Due', 'Subtotal'); 
                                foreach ($test_invoice_incomes_final as $test_invoice_income) {
                                    $this->table->add_row($test_invoice_income['Total'], $test_invoice_income['Discount'], $test_invoice_income['Due'], $test_invoice_income['Subtotal']); 
                                }
                            }
                                
                            $view_data['test_invoice_incomes_table'] = $this->table->generate(); 
                            $view_data['total_search_results'] = $total_search_results;
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoice_incomes__result', $view_data); 
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
                            $h_view_data['title'] = "Test Invoice Incomes"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['test_invoice_incomes_table_empty'] = TRUE; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoice_incomes__result', $view_data); 
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