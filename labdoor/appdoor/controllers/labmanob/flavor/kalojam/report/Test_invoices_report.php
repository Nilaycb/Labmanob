<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_invoices_report extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form', 'file')); 
        $this->load->library(array('session', 'form_validation', 'pagination', 'table'));
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        $this->load->model('labmanob/flavor/kalojam/report/labmanob_test_invoices_report_model', 'labmanob_test_invoices_report_model'); 
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
                
                $h_view_data['title'] = "Test Invoices Report"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoices_report', $view_data);
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

            $this->form_validation->set_rules('test_invoice_id', 'Test Invoice ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('patient_id', 'Patient ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('ref_by', 'Ref By', array('trim', 'max_length[255]', array('check_regex_ref_by', array($this->labmanob_add_model, 'check_regex_name'))));
            $this->form_validation->set_message('check_regex_ref_by', 'The %s field may only contain alpha-numeric characters, underscores, spaces and must start with an alphabetical character!'); 

            $this->form_validation->set_rules('affiliate_partner_id', 'Affiliate Partner ID', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('begin_date', 'Begin Date', array('trim', 'min_length[1]', 'max_length[30]')); 

            $this->form_validation->set_rules('end_date', 'End Date', array('trim', 'min_length[1]', 'max_length[30]')); 
            
            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('payment_status', 'Payment Status', array('trim', 'alpha_dash', 'min_length[1]', 'max_length[10]')); 

            $this->form_validation->set_rules('submit_generate_csv', 'Generate Report', array('trim')); 
            

            if ($this->form_validation->run() == FALSE) 
            {
                $h_view_data = array(); 
                $view_data = array(); 
                $f_view_data = array(); 
                
                $h_view_data['title'] = "Test Invoices Report"; 
                $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                $this->load->view('header', $h_view_data); 
                $this->load->view('labmanob/l_col_main', $view_data); 
                $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoices_report', $view_data);
                $this->load->view('labmanob/r_col_main', $view_data); 
                $this->load->view('footer', $f_view_data);
            }
            else
            {
                $error_count = 0;
                $begin_date_input = $this->input->post_get('begin_date');
                $end_date_input = $this->input->post_get('end_date'); 
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
                else if (empty($begin_date_input) && empty($this->input->post_get('test_invoice_id')) && ((strtolower($_SESSION['username']) != 'master') && (strtolower($_SESSION['username']) != 'admin')) ) 
                {
                    $error_count++;
                    $error_message = "Non-administrative accounts are required to fill up the Begin Date field.";
                }
                else if ( ((!empty($begin_date_input) && !$this->check_backward_date_range_diff($begin_date_input)) || (!empty($end_date_input) && !$this->check_backward_date_range_diff($end_date_input))) && ((strtolower($_SESSION['username']) != 'master') && (strtolower($_SESSION['username']) != 'admin')) )
                {
                    $error_count++;
                    $error_message = "Request denied! Not enough permissions! You can generate reports for up to the past 2 days from the current date.";
                }

                if($error_count != 0)
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Test Invoices Report"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                
                    $view_data['error_message'] = $error_message;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoices_report', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    $test_invoice_id_input = $this->input->post_get('test_invoice_id');
                    $patient_id_input = $this->input->post_get('patient_id');
                    $ref_by_input = $this->input->post_get('ref_by');
                    $affiliate_partner_id_input = $this->input->post_get('affiliate_partner_id');
                    $results_per_page_input = $this->input->post_get('results_per_page'); 

                    $page_input_ok = FALSE; 
                    $results_per_page = ($results_per_page_input) ? $results_per_page_input : 50; 

                    $total_search_results = $this->labmanob_test_invoices_report_model->count_test_invoices_report($test_invoice_id_input, $patient_id_input, $ref_by_input, $affiliate_partner_id_input, $begin_date_input, $end_date_input, $payment_status_input); 
                    
                    
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
                    
                    $pgn_config['base_url'] = site_url('labmanob/flavor/kalojam/report/test_invoices_report/view'); 
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
                            $h_view_data['title'] = "Test Invoices Report"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['pagination_links'] = $this->pagination->create_links(); 
                            $view_data['test_invoices_table_empty'] = FALSE; 
                            
                            $this->table->set_heading('ID', 'Patient ID', 'Patient Name', 'Current Address', 'Mobile', 'Affiliate Partner ID', 'Affiliate Partner Name', 'Total', 'Discount', 'Paid Amount', 'Discount By', 'Due', 'Added', 'Details'); 
                            $test_invoices = $this->labmanob_test_invoices_report_model->test_invoices_report($test_invoice_id_input, $patient_id_input, $ref_by_input, $affiliate_partner_id_input, $begin_date_input, $end_date_input, $payment_status_input, $page, $results_per_page, TRUE); 
                            

                            // CSV generating code start {
                            $view_data['page'] = $page;
                            $view_data['csv_file_requested'] = FALSE;
                            $view_data['csv_file_generated'] = FALSE;
                            if(!empty($this->input->post_get('submit_generate_csv'))) {
                                $view_data['csv_file_requested'] = TRUE;
                                
                                $test_invoices_report_query = $this->labmanob_test_invoices_report_model->test_invoices_report_get_query($test_invoice_id_input, $patient_id_input, $ref_by_input, $affiliate_partner_id_input, $begin_date_input, $end_date_input, $payment_status_input, $page, $results_per_page, TRUE); 
                               
                                $this->load->dbutil();
                                $csv_timestamp = now();

                                // $csv_save_path=assets_path().temp_dir().'csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                                $csv_save_path = $this->config->item('labmanob_external_path', 'labmanob').$this->config->item('labmanob_generated_dir', 'labmanob').'test_invoices_report/csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                                if(!file_exists($csv_save_path) && !is_dir($csv_save_path)) {
                                    mkdir($csv_save_path, 0777, TRUE);
                                }

                                $csv_filename=mdate("%d-%m-%Y-%H_%i_%s", $csv_timestamp).'.csv';
                                $csv_file_path = $csv_save_path.$csv_filename;
                                $write_csv_file = write_file($csv_file_path, $this->dbutil->csv_from_result($test_invoices_report_query));

                                if($write_csv_file)
                                {
                                    $view_data['csv_file_generated'] = TRUE;
                                    $view_data['csv_file_path'] = $csv_file_path;
                                }
                            }
                            // } CSV generating code end


                            foreach ($test_invoices as $test_invoice) { 
                                $patient_name = $test_invoice->patient_name;
                                $earnings_subtotal += (float)$test_invoice->subtotal;
                                $earnings_paid_amount += (float)$test_invoice->paid_amount;
                                $earnings_due += (float)($test_invoice->subtotal - $test_invoice->paid_amount);
                                
                                $test_invoice_id_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice->id, $test_invoice->id, array('class' => 'uk-link-reset'));
                                $test_invoice_patient_id_anchor = anchor('labmanob/view/patient/'.$test_invoice->patient_id, $test_invoice->patient_id, array('class' => 'uk-link-reset'));
                                $test_invoice_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice->id, 'View', array('class' => 'uk-link-reset'));
                                $this->table->add_row(array('data' => $test_invoice_id_anchor, 'class' => 'uk-table-link'), array('data' => $test_invoice_patient_id_anchor, 'class' => 'uk-table-link'), $patient_name, $test_invoice->current_address, $test_invoice->phone_no, $test_invoice->affiliate_partner_id, $test_invoice->affiliate_partner_name, sprintf("%.2f", (float)$test_invoice->total), $test_invoice->discount, sprintf("%.2f", (float)$test_invoice->paid_amount),  $test_invoice->discount_by, sprintf("%.2f", (float)($test_invoice->subtotal - $test_invoice->paid_amount)), $test_invoice->created, array('data' => $test_invoice_anchor, 'class' => 'uk-table-link')); 
                            } 
                                
                            $view_data['test_invoices_table'] = $this->table->generate(); 
                            $view_data['total_search_results'] = $total_search_results;
                            $view_data['earnings_subtotal'] = sprintf("%.2f", (float)$earnings_subtotal); 
                            $view_data['earnings_paid_amount'] = sprintf("%.2f", (float)$earnings_paid_amount); 
                            $view_data['earnings_due'] = sprintf("%.2f", (float)$earnings_due); 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoices_report__result', $view_data); 
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
                            $h_view_data['title'] = "Test Invoices Report"; 
                            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                            $view_data['test_invoices_table_empty'] = TRUE; 
                            
                            $this->load->view('header', $h_view_data); 
                            $this->load->view('labmanob/l_col_main', $view_data); 
                            $this->load->view('labmanob/flavor/kalojam/report/m_col_test_invoices_report__result', $view_data); 
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



    // function return TRUE if date_to_check_input is within the allowed backward range from base_date
    // allowed_backward_date must have to in negetive for this function to work correctly
    private function check_backward_date_range_diff($date_to_check_input='', $base_date='', $allowed_backward_diff='-2 day')
    {
        (empty($base_date)) ? $base_date=date('Y-m-d', now()) : ''/* do nothing, input kept unchanged */ ;
        (empty($allowed_backward_diff)) ? $allowed_backward_diff='-2 day' : ''/* do nothing, input kept unchanged */ ;

        $backward_date_checkpoint = date('Y-m-d', strtotime($allowed_backward_diff, strtotime($base_date)));

        if(!empty($date_to_check_input))
        {
            if( ((strtotime($date_to_check_input) - strtotime($backward_date_checkpoint)) < 0) || ((strtotime($date_to_check_input) - strtotime($base_date)) > 0) )
            {
                return FALSE;
            }
        }

        return TRUE;
    }



} 

?>