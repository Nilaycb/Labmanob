<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller 
{ 

    public function  __construct()
    {
        parent::__construct(); 
        $this->load->helper(array('form', 'file')); 
        $this->load->library(array('session', 'pagination', 'table', 'form_validation')); 
        $this->load->model('accounts/login_model', 'login_model'); 
        $this->load->model('labmanob/labmanob_summary_model', 'labmanob_summary_model'); 
        $this->load->model('labmanob/labmanob_search_model', 'labmanob_search_model'); 
        $this->load->model('labmanob/labmanob_add_model', 'labmanob_add_model'); 
        $this->load->model('labmanob/labmanob_view_model', 'labmanob_view_model'); 
        
    } 



    public function index() 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            $h_view_data = array(); 
            $view_data = array(); 
            $f_view_data = array(); 
            
            $h_view_data['title'] = "View"; 
            $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
            
            $this->load->view('header', $h_view_data); 
            $this->load->view('labmanob/l_col_main', $view_data); 
            $this->load->view('labmanob/view/m_col_main', $view_data); 
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
            $generate_csv_allowed = FALSE;
            $csv_file_requested = FALSE;

            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('submit_generate_csv', 'Generate CSV', array('trim')); 

            if ($this->form_validation->run() == FALSE) 
            {
                $results_per_page = 10; 
            }
            else 
            {
                $results_per_page_input = $this->input->post_get('results_per_page'); 
                $results_per_page = ($results_per_page_input) ? $results_per_page_input : 10; 

                if( !empty($this->input->post_get('submit_generate_csv')) ) 
                {
                    $csv_file_requested = TRUE;
                }

                if( ($csv_file_requested === TRUE) && ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')) ) 
                {
                    $generate_csv_allowed = TRUE;
                }
            }


            $page_input_ok = FALSE; 

            $total_results = $this->labmanob_view_model->count_patients(); 
            
            
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
            
            $pgn_config['base_url'] = site_url('labmanob/view/patients'); 
            $pgn_config['total_rows'] = $total_results;
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
            
            
            if (($total_results > 0) && ($page_input_ok === TRUE)) 
            { 
                $total_pages = ($total_results / $results_per_page); 
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
                    $h_view_data['title'] = "Patients"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['pagination_links'] = $this->pagination->create_links(); 
                    $view_data['patients_table_empty'] = FALSE; 
                    
                    $this->table->set_heading('ID', 'First Name', 'Last Name', 'Sex', 'Phone No', 'Email', 'Current Address', 'Current City', 'Permanent Address', 'Permanent City', 'Extra Info', 'Added'); 
                    $patients = $this->labmanob_view_model->patients($page, $results_per_page, TRUE); 
                    
                    // CSV generating code start {
                    $view_data['page'] = $page;
                    $view_data['csv_file_requested'] = FALSE;
                    $view_data['csv_file_generated'] = FALSE;
                    if(($csv_file_requested) && ($generate_csv_allowed)) {
                        $view_data['csv_file_requested'] = TRUE;
                        
                        $patients_csv_query = $this->labmanob_view_model->patients_get_query($page, $results_per_page); 
                        
                        $this->load->dbutil();
                        $csv_timestamp = now();

                        // $csv_save_path=assets_path().temp_dir().'csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        $csv_save_path = $this->config->item('labmanob_external_path', 'labmanob').$this->config->item('labmanob_generated_dir', 'labmanob').'patients/csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        if(!file_exists($csv_save_path) && !is_dir($csv_save_path)) {
                            mkdir($csv_save_path, 0777, TRUE);
                        }

                        $csv_filename=mdate("%d-%m-%Y-%H_%i_%s", $csv_timestamp).'.csv';
                        $csv_file_path = $csv_save_path.$csv_filename;
                        $write_csv_file = write_file($csv_file_path, $this->dbutil->csv_from_result($patients_csv_query));

                        if($write_csv_file)
                        {
                            $view_data['csv_file_generated'] = TRUE;
                            $view_data['csv_file_path'] = $csv_file_path;
                        }
                    }
                    else if (($csv_file_requested) && (!$generate_csv_allowed))
                    {
                        $view_data['error_message'] = 'Request denied! Not enough permissions!';
                    }
                    // } CSV generating code end

                    foreach ($patients as $patient) { 
                        $patient_id_anchor = anchor('labmanob/view/patient/'.$patient->id, $patient->id, array('class' => 'uk-link-reset')); 
                        $this->table->add_row(array('data' => $patient_id_anchor, 'class' => 'uk-table-link'), $patient->firstname, $patient->lastname, $patient->sex, $patient->phone_no, $patient->email, $patient->current_address, $patient->current_city, $patient->permanent_address, $patient->permanent_city, $patient->extra_info, $patient->created); 
                    } 
                        
                    $view_data['patients_table'] = $this->table->generate(); 
                    $view_data['total_results'] = $total_results;
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_patients', $view_data); 
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
                    $h_view_data['title'] = "Patients"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['patients_table_empty'] = TRUE; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_patients', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                } 
                else 
                { 
                    show_404(current_url()); 
                } 
                
            } 
            
            
        } 
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
        
    } 



    public function patient($id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $id = NULL;
            $id_input_ok = FALSE;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id_input_ok = TRUE;
                $id = $id_input;
            }
            else 
            {
                $id_input_ok = FALSE;
                show_404(current_url());
            }

            if(isset($id) && ($id_input_ok === TRUE))
            {
                if($this->labmanob_view_model->count_patients_by_id($id) > 0)
                {
                    $patient = $this->labmanob_view_model->test_invoice_patient($id, TRUE);
                    $patient = $patient[0];

                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 

                    /* codes for patient image generation start { */
                    if(!empty($patient))
                    {
                        $this->load->library('files_library');
                        $get_file_by_id_result = $this->files_library->get_file_by_id__db($patient->img_id, FALSE);

                        if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                        {
                            $get_file_by_id_result = $get_file_by_id_result[0];

                            $view_data['patient_image_data'] = $get_file_by_id_result;
                            
                            if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                            {
                                $encoded_patient_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                                
                                if($encoded_patient_image_data !== FALSE)
                                {
                                    $view_data['encoded_patient_image_data'] = $encoded_patient_image_data;
                                }
                            }
                        }
                    }
                    /* } codes for patient image generation end */
                
                    $h_view_data['title'] = "View Patient"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                    $view_data['patient'] = $patient;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_patient', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    show_404(current_url());
                }
            }
            else
            {
                //No Patient ID given
                //Show Select Patient form

                $this->form_validation->set_rules('patient_id', 'Patient ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_patient_id', array($this->labmanob_add_model, 'has_patient_id')))); 
                $this->form_validation->set_message('has_patient_id', 'The {field} does not exist! Please check and try again.'); 

                if ($this->form_validation->run() == FALSE) 
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Select Patient | View Patient"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_select_patient', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    redirect('labmanob/view/patient/'.$this->input->post('patient_id', TRUE), 'refresh');
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function affiliate_partners($page_input='') 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            $generate_csv_allowed = FALSE;
            $csv_file_requested = FALSE;

            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('submit_generate_csv', 'Generate CSV', array('trim')); 

            if ($this->form_validation->run() == FALSE) 
            {
                $results_per_page = 10; 
            }
            else 
            {
                $results_per_page_input = $this->input->post_get('results_per_page'); 
                $results_per_page = ($results_per_page_input) ? $results_per_page_input : 10; 

                if( !empty($this->input->post_get('submit_generate_csv')) ) 
                {
                    $csv_file_requested = TRUE;
                }

                if( ($csv_file_requested === TRUE) && ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')) ) 
                {
                    $generate_csv_allowed = TRUE;
                }
            }
                

            $page_input_ok = FALSE; 

            $total_results = $this->labmanob_view_model->count_affiliate_partners(); 
            
            
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
            
            $pgn_config['base_url'] = site_url('labmanob/view/affiliate_partners'); 
            $pgn_config['total_rows'] = $total_results;
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
            
            
            if (($total_results > 0) && ($page_input_ok === TRUE)) 
            { 
                $total_pages = ($total_results / $results_per_page); 
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

                    $h_view_data['title'] = "Affiliate Partners"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['pagination_links'] = $this->pagination->create_links(); 
                    $view_data['affiliate_partners_table_empty'] = FALSE; 
                    
                    $this->table->set_heading('ID', 'First Name', 'Last Name', 'Sex', 'Phone No', 'Email', 'Current Address', 'Current City', 'Permanent Address', 'Permanent City', 'Extra Info', 'Added'); 
                    $affiliate_partners = $this->labmanob_view_model->affiliate_partners($page, $results_per_page, TRUE); 

                    // CSV generating code start {
                    $view_data['page'] = $page;
                    $view_data['csv_file_requested'] = FALSE;
                    $view_data['csv_file_generated'] = FALSE;
                    if(($csv_file_requested) && ($generate_csv_allowed)) {
                        $view_data['csv_file_requested'] = TRUE;
                        
                        $affiliate_partners_csv_query = $this->labmanob_view_model->affiliate_partners_get_query($page, $results_per_page); 
                        
                        $this->load->dbutil();
                        $csv_timestamp = now();

                        // $csv_save_path=assets_path().temp_dir().'csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        $csv_save_path = $this->config->item('labmanob_external_path', 'labmanob').$this->config->item('labmanob_generated_dir', 'labmanob').'affiliate_partners/csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        if(!file_exists($csv_save_path) && !is_dir($csv_save_path)) {
                            mkdir($csv_save_path, 0777, TRUE);
                        }

                        $csv_filename=mdate("%d-%m-%Y-%H_%i_%s", $csv_timestamp).'.csv';
                        $csv_file_path = $csv_save_path.$csv_filename;
                        $write_csv_file = write_file($csv_file_path, $this->dbutil->csv_from_result($affiliate_partners_csv_query));

                        if($write_csv_file)
                        {
                            $view_data['csv_file_generated'] = TRUE;
                            $view_data['csv_file_path'] = $csv_file_path;
                        }
                    }
                    else if (($csv_file_requested) && (!$generate_csv_allowed))
                    {
                        $view_data['error_message'] = 'Request denied! Not enough permissions!';
                    }
                    // } CSV generating code end
                    
                    foreach ($affiliate_partners as $affiliate_partner) { 
                        $affiliate_partner_id_anchor = anchor('labmanob/view/affiliate_partner/'.$affiliate_partner->id, $affiliate_partner->id, array('class' => 'uk-link-reset'));
                        $this->table->add_row(array('data' => $affiliate_partner_id_anchor, 'class' => 'uk-table-link'), $affiliate_partner->firstname, $affiliate_partner->lastname, $affiliate_partner->sex, $affiliate_partner->phone_no, $affiliate_partner->email, $affiliate_partner->current_address, $affiliate_partner->current_city, $affiliate_partner->permanent_address, $affiliate_partner->permanent_city, $affiliate_partner->extra_info, $affiliate_partner->created); 
                    } 
                        
                    $view_data['affiliate_partners_table'] = $this->table->generate(); 
                    $view_data['total_results'] = $total_results;
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_affiliate_partners', $view_data); 
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
                    $h_view_data['title'] = "Affiliate Partners"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['affiliate_partners_table_empty'] = TRUE; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_affiliate_partners', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                } 
                else 
                { 
                    show_404(current_url()); 
                } 
                
            } 
            
            
        } 
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
        
    } 



    public function affiliate_partner($id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $id = NULL;
            $id_input_ok = FALSE;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id_input_ok = TRUE;
                $id = $id_input;
            }
            else 
            {
                $id_input_ok = FALSE;
                show_404(current_url());
            }

            if(isset($id) && ($id_input_ok === TRUE))
            {
                if($this->labmanob_view_model->count_affiliate_partners_by_id($id) > 0)
                {
                    $affiliate_partner = $this->labmanob_view_model->affiliate_partner($id, TRUE);
                    $affiliate_partner = $affiliate_partner[0];

                    
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 

                    /* codes for affiliate_partner image generation start { */
                    if(!empty($affiliate_partner))
                    {
                        $this->load->library('files_library');
                        $get_file_by_id_result = $this->files_library->get_file_by_id__db($affiliate_partner->img_id, FALSE);

                        if(($get_file_by_id_result != FALSE) && isset($get_file_by_id_result)) 
                        {
                            $get_file_by_id_result = $get_file_by_id_result[0];

                            $view_data['affiliate_partner_image_data'] = $get_file_by_id_result;
                            
                            if(isset($get_file_by_id_result['encode_level']) && ($get_file_by_id_result['encode_level'] != 0)) 
                            {
                                $encoded_affiliate_partner_image_data = $this->files_library->get_encoded_image_data($get_file_by_id_result, $get_file_by_id_result['encode_level'], FALSE);
                                
                                if($encoded_affiliate_partner_image_data !== FALSE)
                                {
                                    $view_data['encoded_affiliate_partner_image_data'] = $encoded_affiliate_partner_image_data;
                                }
                            }
                        }
                    }
                    /* } codes for affiliate_partner image generation end */
                
                    $h_view_data['title'] = "View Affiliate Partner"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                    $view_data['affiliate_partner'] = $affiliate_partner;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_affiliate_partner', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    show_404(current_url());
                }
            }
            else
            {
                //No Affiliate Partner ID given
                //Show Select Affiliate Partner form

                $this->form_validation->set_rules('affiliate_partner_id', 'Affiliate Partner ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_affiliate_partner_id', array($this->labmanob_add_model, 'has_affiliate_partner_id')))); 
                $this->form_validation->set_message('has_affiliate_partner_id', 'The {field} does not exist! Please check and try again.'); 

                if ($this->form_validation->run() == FALSE) 
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Select Affiliate Partner | View Affiliate Partner"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_select_affiliate_partner', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    redirect('labmanob/view/affiliate_partner/'.$this->input->post('affiliate_partner_id', TRUE), 'refresh');
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function test_categories($page_input='') 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            $generate_csv_allowed = FALSE;
            $csv_file_requested = FALSE;

            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('submit_generate_csv', 'Generate CSV', array('trim')); 

            if ($this->form_validation->run() == FALSE) 
            {
                $results_per_page = 10; 
            }
            else 
            {
                $results_per_page_input = $this->input->post_get('results_per_page'); 
                $results_per_page = ($results_per_page_input) ? $results_per_page_input : 10; 

                if( !empty($this->input->post_get('submit_generate_csv')) ) 
                {
                    $csv_file_requested = TRUE;
                }

                if( ($csv_file_requested === TRUE) && ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')) ) 
                {
                    $generate_csv_allowed = TRUE;
                }
            }


            $page_input_ok = FALSE; 

            $total_results = $this->labmanob_view_model->count_test_categories(); 
            
            
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
            
            $pgn_config['base_url'] = site_url('labmanob/view/test_categories'); 
            $pgn_config['total_rows'] = $total_results;
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
            
            
            if (($total_results > 0) && ($page_input_ok === TRUE)) 
            { 
                $total_pages = ($total_results / $results_per_page); 
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
                    $h_view_data['title'] = "Test Categories"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['pagination_links'] = $this->pagination->create_links(); 
                    $view_data['test_categories_table_empty'] = FALSE; 
                    
                    $this->table->set_heading('ID', 'Category Name', 'Category Code Name', 'Category Description', 'Added'); 
                    $test_categories = $this->labmanob_view_model->test_categories($page, $results_per_page, TRUE); 
                    
                    // CSV generating code start {
                    $view_data['page'] = $page;
                    $view_data['csv_file_requested'] = FALSE;
                    $view_data['csv_file_generated'] = FALSE;
                    if(($csv_file_requested) && ($generate_csv_allowed)) {
                        $view_data['csv_file_requested'] = TRUE;
                        
                        $test_categories_csv_query = $this->labmanob_view_model->test_categories_get_query($page, $results_per_page); 
                        
                        $this->load->dbutil();
                        $csv_timestamp = now();

                        // $csv_save_path=assets_path().temp_dir().'csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        $csv_save_path = $this->config->item('labmanob_external_path', 'labmanob').$this->config->item('labmanob_generated_dir', 'labmanob').'test_categories/csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        if(!file_exists($csv_save_path) && !is_dir($csv_save_path)) {
                            mkdir($csv_save_path, 0777, TRUE);
                        }

                        $csv_filename=mdate("%d-%m-%Y-%H_%i_%s", $csv_timestamp).'.csv';
                        $csv_file_path = $csv_save_path.$csv_filename;
                        $write_csv_file = write_file($csv_file_path, $this->dbutil->csv_from_result($test_categories_csv_query));

                        if($write_csv_file)
                        {
                            $view_data['csv_file_generated'] = TRUE;
                            $view_data['csv_file_path'] = $csv_file_path;
                        }
                    }
                    else if (($csv_file_requested) && (!$generate_csv_allowed))
                    {
                        $view_data['error_message'] = 'Request denied! Not enough permissions!';
                    }
                    // } CSV generating code end

                    foreach ($test_categories as $test_category) { 
                        $test_category_id_anchor = anchor('labmanob/view/test_category/'.$test_category->id, $test_category->id, array('class' => 'uk-link-reset'));
                        $this->table->add_row(array('data' => $test_category_id_anchor, 'class' => 'uk-table-link'), $test_category->category_name, $test_category->category_codename, $test_category->category_description, $test_category->created); 
                    } 
                        
                    $view_data['test_categories_table'] = $this->table->generate(); 
                    $view_data['total_results'] = $total_results;
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test_categories', $view_data); 
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
                    $h_view_data['title'] = "Test Categories"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['test_categories_table_empty'] = TRUE; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test_categories', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                } 
                else 
                { 
                    show_404(current_url()); 
                } 
                
            } 
            
            
        } 
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
        
    } 



    public function test_category($id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $id = NULL;
            $id_input_ok = FALSE;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id_input_ok = TRUE;
                $id = $id_input;
            }
            else 
            {
                $id_input_ok = FALSE;
                show_404(current_url());
            }

            if(isset($id) && ($id_input_ok === TRUE))
            {
                if($this->labmanob_view_model->count_test_categories_by_id($id) > 0)
                {
                    $test_category = $this->labmanob_view_model->test_category($id, TRUE);
                    $test_category = $test_category[0];

                    
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                
                    $h_view_data['title'] = "View Test Category"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                    $view_data['test_category'] = $test_category;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test_category', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    show_404(current_url());
                }
            }
            else
            {
                //No Test Category ID given
                //Show Select Test Category form

                $this->form_validation->set_rules('test_category_id', 'Test Category ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_test_category_id', array($this->labmanob_add_model, 'has_test_category_id')))); 
                $this->form_validation->set_message('has_test_category_id', 'The {field} does not exist! Please check and try again.'); 

                if ($this->form_validation->run() == FALSE) 
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Select Test Category | View Test Category"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_select_test_category', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    redirect('labmanob/view/test_category/'.$this->input->post('test_category_id', TRUE), 'refresh');
                }
            }
        }
        else
        {
            redirect('accounts/login', 'refresh'); 
        }
    } 



    public function tests($page_input='') 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            $generate_csv_allowed = FALSE;
            $csv_file_requested = FALSE;

            $this->form_validation->set_data($this->input->get());

            $this->form_validation->set_rules('results_per_page', 'Results Per Page', array('trim', 'is_natural_no_zero', 'min_length[1]', 'max_length[11]')); 

            $this->form_validation->set_rules('submit_generate_csv', 'Generate CSV', array('trim')); 

            if ($this->form_validation->run() == FALSE) 
            {
                $results_per_page = 10; 
            }
            else 
            {
                $results_per_page_input = $this->input->post_get('results_per_page'); 
                $results_per_page = ($results_per_page_input) ? $results_per_page_input : 10; 

                if( !empty($this->input->post_get('submit_generate_csv')) ) 
                {
                    $csv_file_requested = TRUE;
                }

                if( ($csv_file_requested === TRUE) && ((strtolower($_SESSION['username']) == 'master') || (strtolower($_SESSION['username']) == 'admin')) ) 
                {
                    $generate_csv_allowed = TRUE;
                }
            }


            $page_input_ok = FALSE; 

            $total_results = $this->labmanob_view_model->count_tests(); 
            
            
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
            
            $pgn_config['base_url'] = site_url('labmanob/view/tests'); 
            $pgn_config['total_rows'] = $total_results; 
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
            
            
            if (($total_results > 0) && ($page_input_ok === TRUE)) 
            { 
                $total_pages = ($total_results / $results_per_page); 
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
                    $h_view_data['title'] = "Tests"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['pagination_links'] = $this->pagination->create_links(); 
                    $view_data['tests_table_empty'] = FALSE; 
                    
                    $this->table->set_heading('ID', 'Test Name', 'Test Code Name', 'Test Category', 'Test Price', 'Test Description', 'Added', 'Modified'); 
                    $tests = $this->labmanob_view_model->tests_joined_test_categories($page, $results_per_page, TRUE); 
                    
                    // CSV generating code start {
                    $view_data['page'] = $page;
                    $view_data['csv_file_requested'] = FALSE;
                    $view_data['csv_file_generated'] = FALSE;
                    if(($csv_file_requested) && ($generate_csv_allowed)) {
                        $view_data['csv_file_requested'] = TRUE;
                        
                        $tests_csv_query = $this->labmanob_view_model->tests_joined_test_categories_get_query($page, $results_per_page); 
                        
                        $this->load->dbutil();
                        $csv_timestamp = now();

                        // $csv_save_path=assets_path().temp_dir().'csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        $csv_save_path = $this->config->item('labmanob_external_path', 'labmanob').$this->config->item('labmanob_generated_dir', 'labmanob').'tests/csv/'.mdate("%d-%m-%Y", $csv_timestamp).'/';
                        if(!file_exists($csv_save_path) && !is_dir($csv_save_path)) {
                            mkdir($csv_save_path, 0777, TRUE);
                        }

                        $csv_filename=mdate("%d-%m-%Y-%H_%i_%s", $csv_timestamp).'.csv';
                        $csv_file_path = $csv_save_path.$csv_filename;
                        $write_csv_file = write_file($csv_file_path, $this->dbutil->csv_from_result($tests_csv_query));

                        if($write_csv_file)
                        {
                            $view_data['csv_file_generated'] = TRUE;
                            $view_data['csv_file_path'] = $csv_file_path;
                        }
                    }
                    else if (($csv_file_requested) && (!$generate_csv_allowed))
                    {
                        $view_data['error_message'] = 'Request denied! Not enough permissions!';
                    }
                    // } CSV generating code end

                    foreach ($tests as $test) { 
                        $test_id_anchor = anchor('labmanob/view/test/'.$test->id, $test->id, array('class' => 'uk-link-reset'));
                        $test_category_codename_anchor = anchor('labmanob/view/test_category/'.$test->test_category_id, $test->test_category_codename, array('class' => 'uk-link-reset'));
                        $this->table->add_row(array('data' => $test_id_anchor, 'class' => 'uk-table-link'), $test->test_name, $test->test_codename, array('data' => $test_category_codename_anchor, 'class' => 'uk-table-link'), $test->test_price, $test->test_description, $test->created, $test->modified); 
                    } 
                        
                    $view_data['tests_table'] = $this->table->generate(); 
                    $view_data['total_results'] = $total_results;
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_tests', $view_data); 
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
                    $h_view_data['title'] = "Tests"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['tests_table_empty'] = TRUE; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_tests', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                } 
                else 
                { 
                    show_404(current_url()); 
                } 
                
            } 
            
            
        } 
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
        
    } 



    public function test($test_id_input='') 
    {
        if ($this->login_model->login_check() === TRUE) 
        {
            $test_id = NULL;
            $test_id_input_ok = FALSE;

            if ($test_id_input == '') 
            { 
                $test_id_input_ok = FALSE; 
            } 
            else if ((($test_id_input != '') || (!empty($test_id_input))) && (preg_match('/^[1-9][0-9]*$/', $test_id_input))) 
            { 
                $test_id_input_ok = TRUE;
                $test_id = $test_id_input;
            }
            else 
            {
                $test_id_input_ok = FALSE;
                show_404(current_url());
            }

            if(isset($test_id) && ($test_id_input_ok === TRUE))
            {
                if($this->labmanob_view_model->count_tests_by_id($test_id) > 0)
                {
                    $test = $this->labmanob_view_model->test_joined_test_categories($test_id, TRUE);
                    $test = $test[0];

                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                
                    $h_view_data['title'] = "View Test"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                    $view_data['test'] = $test;

                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    show_404(current_url());
                }
            }
            else
            {
                //No Test ID given
                //Show Select Test form

                $this->form_validation->set_rules('test_id', 'Test ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_test_id', array($this->labmanob_add_model, 'has_test_id')))); 
                $this->form_validation->set_message('has_test_id', 'The {field} does not exist! Please check and try again.'); 

                if ($this->form_validation->run() == FALSE) 
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Select Test | View Test"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_select_test', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    redirect('labmanob/view/test/'.$this->input->post('test_id', TRUE), 'refresh');
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
            $page_input_ok = FALSE; 
            $results_per_page = 10; 

            $total_results = $this->labmanob_view_model->count_test_invoices(); 
            
            
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
            
            $pgn_config['base_url'] = site_url('labmanob/view/test_invoices'); 
            $pgn_config['total_rows'] = $total_results; 
            $pgn_config['per_page'] = $results_per_page; 
            
            $this->pagination->initialize($pgn_config); 
            
            $table_tpl = array(
                'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">',
                'heading_cell_start' => '<th class="uk-table-shrink uk-text-nowrap">'
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
            
            
            if (($total_results > 0) && ($page_input_ok === TRUE)) 
            { 
                $total_pages = ($total_results / $results_per_page); 
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
                    $h_view_data['title'] = "Test Invoices"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['pagination_links'] = $this->pagination->create_links(); 
                    $view_data['test_invoices_table_empty'] = FALSE; 
                    
                    $this->table->set_heading('ID', 'Patient ID', 'Patient Name', 'Patient Age', 'Ref By', 'Affiliate Partner ID', 'Extra Info', 'Total', 'Discount', 'Discount By', 'Subtotal', 'Added', 'Details'); 
                    $test_invoices = $this->labmanob_view_model->test_invoices($page, $results_per_page, TRUE); 
                    
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
                        
                        
                        $test_invoice_id_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice->id, $test_invoice->id, array('class' => 'uk-link-reset'));
                        $test_invoice_patient_id_anchor = anchor('labmanob/view/patient/'.$test_invoice->patient_id, $test_invoice->patient_id, array('class' => 'uk-link-reset'));
                        $test_invoice_anchor = anchor('labmanob/view/test_invoice/'.$test_invoice->id, 'View', array('class' => 'uk-link-reset'));
                        $this->table->add_row(array('data' => $test_invoice_id_anchor, 'class' => 'uk-table-link'), array('data' => $test_invoice_patient_id_anchor, 'class' => 'uk-table-link'), $patient_name, $test_invoice->patient_age, $test_invoice->ref_by, $test_invoice->affiliate_partner_id, array('data' => $test_invoice->extra_info, 'class' => 'uk-text-truncate'), $test_invoice->total, $test_invoice->discount, $test_invoice->discount_by, $test_invoice->subtotal, $test_invoice->created, array('data' => $test_invoice_anchor, 'class' => 'uk-table-link')); 
                        } 
                        
                    $view_data['test_invoices_table'] = $this->table->generate(); 
                    $view_data['total_results'] = $total_results;
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test_invoices', $view_data); 
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
                    $h_view_data['title'] = "Test Invoices"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    $view_data['test_invoices_table_empty'] = TRUE; 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test_invoices', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data); 
                } 
                else 
                { 
                    show_404(current_url()); 
                } 
                
            } 
            
            
        } 
        else 
        { 
            redirect('accounts/login', 'refresh'); 
        } 
        
    } 



    public function test_invoice($id_input='') 
    { 
        
        if ($this->login_model->login_check() === TRUE) 
        { 
            $id = NULL;

            if ($id_input == '') 
            { 
                $id_input_ok = FALSE; 
            } 
            else if ((($id_input != '') || (!empty($id_input))) && (preg_match('/^[1-9][0-9]*$/', $id_input))) 
            { 
                $id = $id_input; 
                $id_input_ok = TRUE; 
            } 
            else 
            { 
                $id_input_ok = FALSE; 
                show_404(current_url()); 
            } 

            if(isset($id) && ($id_input_ok === TRUE))
            {
                if(($this->labmanob_view_model->count_test_invoices_by_id($id) > 0) && ($id_input_ok === TRUE))
                {
                    $test_invoice = $this->labmanob_view_model->test_invoice($id, TRUE);
                    $test_invoice = $test_invoice[0];

                    $test_invoice_patient = $this->labmanob_view_model->test_invoice_patient($test_invoice->patient_id, TRUE);
                    $test_invoice_patient = $test_invoice_patient[0];

                    $test_invoice_payment = $this->labmanob_view_model->test_invoice_payment($test_invoice->id, TRUE);
                    $test_invoice_payment = $test_invoice_payment[0];

                    $test_invoice_records = $this->labmanob_view_model->test_invoice_records_by_test_invoice_id($id, FALSE);

                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                
                    $h_view_data['title'] = "Test Invoice - Details"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary();                 

                    $table_tpl = array(
                        'table_open' => '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-small">'
                        ); 
                
                    $this->table->set_template($table_tpl);
                    $this->table->set_heading('Serial No', 'Test ID', 'Test Name', 'Price', 'Quantity', 'Total', 'Discount', 'Discount By', 'Subtotal');
                
                    $total_discount = 0;
                    $total = 0;
                    $i = 1;
                    foreach ($test_invoice_records as $test_key => $test_items)
                    {
                        $test_name_result = $this->labmanob_view_model->get_tests_name_by_id($test_items['test_id']);
                        $test_name = ($test_name_result !== FALSE) ? $test_name_result[0]->test_name : '';

                        $discount = 0;

                        if(!empty($test_items['discount']))
                        {
                            $discount = $this->labmanob_view_model->calc_discount($test_items['discount'], $test_items['total']);
                            $total_discount += $discount;
                        }

                        $total += $test_items['total'];
                        $this->table->add_row($i, $test_items['test_id'], $test_name, $test_items['test_price'], $test_items['quantity'], sprintf("%.2f", (float)$test_items['total']), $test_items['discount'], $test_items['discount_by'], sprintf("%.2f", (float)$test_items['subtotal'])); 
                        $i++;
                    }
                    $final_total = $test_invoice->total;
                    $this->table->add_row('', '', '', '', '', sprintf("%.2f", (float)$total), sprintf("%.2f", (float)$total_discount), '', sprintf("%.2f", (float)$final_total));

                    /* QR code generator */
                    $output_dir = 'test_invoices/';
                    $this->load->helper('phpqrcode');
                    $qrDataText = $this->config->item('business_entity_name', 'labmanob');
                    $qrDataText .= "\n".'Test Invoice ID: '.$test_invoice->id;
                    $qrDataText .= "\n".'Invoice Issued: '.$test_invoice->created;
                    $qrDataText .= "\n".'Patient ID: '.$test_invoice->patient_id;
                    $qrDataText .= "\n".'Patient Name: '.$test_invoice_patient->firstname.' '.$test_invoice_patient->lastname;
                    $qrDataText .= "\n".'Patient Phone: '.$test_invoice_patient->phone_no;
                    $qrDataText .= "\n".'Ref By: '.$test_invoice->ref_by;
                    $qrPixel = 1;
                    $qrFrame = 4;
                    $qrTempFile = qrcodes_path().$output_dir.'test_invoice_svg_'.$test_invoice->id.'_'.$qrPixel.'_'.$qrFrame.'.png';
                    QRcode::png($qrDataText, $qrTempFile, QR_ECLEVEL_M, $qrPixel, $qrFrame); 
                    if(file_exists($qrTempFile))
                    {
                        $qrCodeUrl = base_url($qrTempFile);
                    }
                    else
                    {
                        $qrCodeUrl = NULL;
                    }
                    /* QR code generator end */

                    $view_data['test_invoice'] = $test_invoice;
                    $view_data['test_invoice_patient'] = $test_invoice_patient;
                    $view_data['test_invoice_payment'] = $test_invoice_payment;
                    $view_data['test_invoice_records_table'] = $this->table->generate();
                    $view_data['qrCodeUrl'] = $qrCodeUrl;


                    /* Test Invoice Logs Table codes start { */
                    $view_data['test_invoice_logs_table_empty'] = TRUE;

                    $total_test_invoice_logs_results = $this->labmanob_view_model->count_test_invoice_logs_from_id($test_invoice->id);
                    if($total_test_invoice_logs_results > 0)
                    {
                        $this->table->set_template($table_tpl);
                        $this->table->set_heading('Serial No', 'Test Invoice Log ID', 'Username', 
                                                    'Prev Total', 'Prev Discount', 'Prev Discount By', 'Prev Subtotal', 'Prev Full Paid', 'Prev Paid Amount', 
                                                    'Total', 'Discount', 'Discount By', 'Subtotal', 'Full Paid', 'Paid Amount', 'Date Created'
                        );
                

                        $test_invoice_logs = $this->labmanob_view_model->test_invoice_logs_by_test_invoice_id($id, $sort='ASC', TRUE);

                        $i = 1;
                        foreach ($test_invoice_logs as $test_invoice_log) { 
                            $prev_is_full_paid = ($test_invoice_log->prev_is_full_paid == 1) ? "Yes" : "No";
                            $is_full_paid = ($test_invoice_log->is_full_paid == 1) ? "Yes" : "No";

                            $this->table->add_row($i, $test_invoice_log->id, $test_invoice_log->username, 
                                                    sprintf("%.2f", (float)$test_invoice_log->prev_total), $test_invoice_log->prev_discount, $test_invoice_log->prev_discount_by, sprintf("%.2f", (float)$test_invoice_log->prev_subtotal), $prev_is_full_paid, sprintf("%.2f", (float)$test_invoice_log->prev_paid_amount),
                                                    sprintf("%.2f", (float)$test_invoice_log->total), $test_invoice_log->discount, $test_invoice_log->discount_by, sprintf("%.2f", (float)$test_invoice_log->subtotal), $is_full_paid, sprintf("%.2f", (float)$test_invoice_log->paid_amount), $test_invoice_log->created
                            ); 
                                                
                            $i++;
                        }

                        $view_data['test_invoice_logs_table_empty'] = FALSE;
                        $view_data['test_invoice_logs_table'] = $this->table->generate(); 
                        $view_data['total_test_invoice_logs_results'] = $total_test_invoice_logs_results;
                    }
                    /* } Test Invoice Logs Table codes end */


                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_test_invoice', $view_data); 
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    show_404(current_url());
                }
            }
            else
            {
                //No Test Invoice ID given
                //Show Select Test Invoice form

                $this->form_validation->set_rules('test_invoice_id', 'Test Invoice ID', array('trim', 'required', 'is_natural', 'min_length[1]', 'max_length[11]', array('has_test_invoice_id', array($this->labmanob_add_model, 'has_test_invoice_id')))); 
                $this->form_validation->set_message('has_test_invoice_id', 'The {field} does not exist! Please check and try again.'); 

                if ($this->form_validation->run() == FALSE) 
                {
                    $h_view_data = array(); 
                    $view_data = array(); 
                    $f_view_data = array(); 
                    
                    $h_view_data['title'] = "Select Test Invoice | View Test Invoice"; 
                    $view_data['summary'] = $this->labmanob_summary_model->get_full_summary(); 
                    
                    $this->load->view('header', $h_view_data); 
                    $this->load->view('labmanob/l_col_main', $view_data); 
                    $this->load->view('labmanob/view/m_col_select_test_invoice', $view_data);
                    $this->load->view('labmanob/r_col_main', $view_data); 
                    $this->load->view('footer', $f_view_data);
                }
                else
                {
                    redirect('labmanob/view/test_invoice/'.$this->input->post('test_invoice_id', TRUE), 'refresh');
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